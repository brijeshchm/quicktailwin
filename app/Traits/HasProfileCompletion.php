<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait HasProfileCompletion
{
     /**
     * Get overall profile completion percentage (0-100, rounded).
     */
    public function getProfileCompletionPercentage(): int
    {
        return (int) round($this->getProfileCompletionBreakdown()['total']);
    }
 
    /**
     * Full breakdown per section — useful for a "complete your profile"
     * checklist UI, not just a single number.
     *
     * Returns:
     * [
     *   'total' => 63.5,
     *   'sections' => [
     *       'business_info' => ['label' => 'business_info', 'earned' => 12.0, 'weight' => 20, 'percent' => 60],
     *       ...
     *   ],
     *   'missing_fields' => ['business_intro', 'gst_no', ...] // for a "complete these next" list
     * ]
     */
    public function getProfileCompletionBreakdown(): array
    {
        $config = config('profile_completion.sections', []);
 
        $total = 0.0;
        $sections = [];
        $missingFields = [];
 
        foreach ($config as $key => $section) {
            $weight = (float) ($section['weight'] ?? 0);
            $sectionPercent = 0.0;
 
            if (!empty($section['pairs'])) {
                // FAQ-style: [question, answer] pairs
                $completeCount = 0;
                $totalPairs = count($section['pairs']);
                $minRequired = $section['min_required'] ?? $totalPairs;
 
                foreach ($section['pairs'] as [$qField, $aField]) {
                    if ($this->fieldIsFilled($qField) && $this->fieldIsFilled($aField)) {
                        $completeCount++;
                    } else {
                        $missingFields[] = $aField;
                    }
                }
 
                $sectionPercent = $minRequired > 0
                    ? min(100, ($completeCount / $minRequired) * 100)
                    : 0;
 
            } elseif (!empty($section['fields']) && isset($section['min_required'])) {
                // "any N of these fields" style (social links, media gallery, legal docs)
                $filledCount = 0;
 
                foreach ($section['fields'] as $field) {
                    if ($this->fieldIsFilled($field)) {
                        $filledCount++;
                    }
                }
 
                if ($filledCount === 0) {
                    $missingFields[] = $section['fields'][0]; // representative hint
                }
 
                $sectionPercent = $section['min_required'] > 0
                    ? min(100, ($filledCount / $section['min_required']) * 100)
                    : 0;
 
            } elseif (!empty($section['fields'])) {
                // Standard: ALL fields must be filled for 100% of this section
                $totalFields = count($section['fields']);
                $filledCount = 0;
 
                foreach ($section['fields'] as $field) {
                    if ($this->fieldIsFilled($field)) {
                        $filledCount++;
                    } else {
                        $missingFields[] = $field;
                    }
                }
 
                $sectionPercent = $totalFields > 0
                    ? ($filledCount / $totalFields) * 100
                    : 0;
            }
 
            $earned = ($sectionPercent / 100) * $weight;
            $total += $earned;
 
            $sections[$key] = [
                'label'   => $key,
                'earned'  => round($earned, 2),
                'weight'  => $weight,
                'percent' => round($sectionPercent, 1),
            ];
        }
 
        return [
            'total'          => round($total, 2),
            'sections'       => $sections,
            'missing_fields' => array_values(array_unique($missingFields)),
        ];
    }
 
    /**
     * Determine if a field counts as "filled".
     * Treats null, '', whitespace-only, and literal "0"/0 as empty
     * EXCEPT for fields where 0 is a legitimate value (extend as needed).
     */
    protected function fieldIsFilled(string $field): bool
    {
        $value = $this->getAttribute($field);
 
        if ($value === null) {
            return false;
        }
 
        if (is_string($value)) {
            $trimmed = trim($value);
            return $trimmed !== '' && strtolower($trimmed) !== 'null';
        }
 
        if (is_numeric($value)) {
            // Zero counts as filled for numeric fields (e.g. year_of_estb edge cases)
            // unless explicitly listed as a "zero means empty" field below.
            $zeroMeansEmptyFields = ['personal_phone', 'mobile', 'whatsapp'];
 
            if (in_array($field, $zeroMeansEmptyFields, true) && (int) $value === 0) {
                return false;
            }
 
            return true;
        }
 
        return !empty($value);
    }
}