<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class cSORequest extends Controller
{
    //

    public function getRequest(Request $request) {
        return $request;
    }        

    public function getCompIY(Request $request) {
        $TBLUSR = $request->user();
        $Hasil = $TBLUSR->TUUSERIY;
        // if (is_null($request->AppCompanyCode)) {
        //     return "";
        // }
        // $Hasil = fnGetCompIY($request->AppCompanyCode);
        return $Hasil;
    }        


}
