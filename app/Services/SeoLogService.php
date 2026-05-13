<?php

namespace App\Services;
 
use App\Models\Keyword;
use App\Models\SeoLog;
use Auth;
class SeoLogService
{     
    /**
     * Register a new Seo log.
     *
     * @param array $data
     * @return Keyword
     * 
     */
    public function createSeoLog($data)
    {         
      SeoLog::create($data);        
    }    
}
