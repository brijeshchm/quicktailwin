<?php

namespace App\Services;
use App\Models\Version;

use App\Models\Citieslists;
use App\Models\Zone;
use App\Models\State;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
 
use Maatwebsite\Excel\Concerns\WithChunkReading;
 
class ZoneExcelImport implements OnEachRow, WithHeadingRow, WithChunkReading
{
      
    public function onRow(Row $row)
    {
        set_time_limit(0);

        $row = $row->toArray();

        $cityName = trim($row['city'] ?? '');
        $zoneName = trim($row['zone'] ?? '');

        if ($cityName === '' || $zoneName === '') {
            return;
        }
        info('Excel imported'.$zoneName);
        // 1️⃣ Find State
        $state = State::where('name', trim($row['state'] ?? ''))->first();
        if (!$state) {
            return;
        }

        // 2️⃣ City (create if not exists)
        $city = Citieslists::firstOrCreate(
            [
                'city'     => $cityName,
                'state_id'=> $state->id
            ],
            [
                'state' => $state->name
            ]
        );

        // 3️⃣ Zone (insert one by one)
        Zone::firstOrCreate(
            [
                'city_id' => $city->id,
                'zone'    => $zoneName,
            ],
            [
                'pincode'   => trim($row['pincode'] ?? ''),
                'latitude'  => $row['latitude'] ?? null,
                'longitude' => $row['longitude'] ?? null,
            ]
        );
       echo "Excel imported".$zoneName;
        
    }

     public function chunkSize(): int
    {
        return 500;
    }

}
