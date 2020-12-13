<?php

namespace App\Console;

use Illuminate\Database\Seeder;

class soSeeder extends Seeder
{
 

    public function setDefaultField($Prefix, &$Table) 
    {


        $defaultField = [];
        $defaultField = array( "RGID" => 'Default',
                               "RGDT" => Date("Y-m-d H:i:s"),
                               "CHID" => 'Default',
                               "CHDT" => Date("Y-m-d H:i:s"),
                               "CHNO" => '0',
                               "DPFG" => '1',
                               "DLFG" => '0',
                               "CSID" => 'Default',
                               "CSDT" => Date("Y-m-d H:i:s"),
                               "SRCE" => 'FirstSetup',
                             );

        foreach ($defaultField as $K => $D) { $Table[$Prefix.$K] = $D; }

    }
  
   
}
