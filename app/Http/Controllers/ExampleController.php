<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //

    public function cobacoba(Request $request)
    {

        $defaultFieldSYSDAT = [];
        $defaultFieldSYSDAT = array( "SDRGID" => 'Default',
                                     "SDRGDT" => Date("Y-m-d H:i:s"),
                                     "SDCHID" => 'Default',
                                     "SDCHDT" => Date("Y-m-d H:i:s"),
                                     "SDCHNO" => '0',
                                     "SDDPFG" => '1',
                                     "SDDLFG" => '0',
                                     "SDCSID" => 'Default',
                                     "SDCSDT" => Date("Y-m-d H:i:s"),
                                     "SDSRCE" => 'FirstSetup',
                                  );

        $SYSTBL = array();
        $SYSTBL->STTABL = 'YN';
        $SYSTBL->STNAME = 'YESNO';

        foreach ($defaultFieldSYSDAT as $K => $D) { $SYSTBL[$K] = $D; }
        dd($SYSTBL);

    }    
}
