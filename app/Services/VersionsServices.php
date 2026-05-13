<?php

namespace App\Services;
use App\Models\Version;
class VersionsServices
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    /**
     * Register a new Seo log.
     *
     * @param array $data
     * @return 
     * 
     */
    public function createVersion($data)
    {          
       Version::create($data);        
    }   

}
