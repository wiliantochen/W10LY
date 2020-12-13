<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class soLink extends Controller
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

    public function getLink(Request $request)
    {


        try {            
            $RoutePath = $request->c."@".$request->m;
            // dd($RoutePath);
            $Hasil = App::call('\App\Http\Controllers\Forms\\'.$RoutePath);
            // $Hasil = json_encode($Hasil);
            // $Hasil = json_decode($Hasil, true);
            // $Hasil = json_encode($Hasil['original']);
            // return fnEnCrypt($Hasil);           
            return $Hasil;           
        } catch (\Exception $e) {
            return response()->json(['gagal_panggil_link'], 404);
        }

    }    

    public function getLinkXXXX(Request $request)
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
