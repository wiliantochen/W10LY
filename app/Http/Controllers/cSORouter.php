<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class cSORouter extends Controller
{
    //


    public function Panggil(Request $request) {

        try {            
            $RoutePath = $request->Controller."@".$request->Method;
            // dd($RoutePath);
            $Hasil = App::call('\App\Http\Controllers\Forms\\'.$RoutePath);
            $Hasil = json_encode($Hasil);
            $Hasil = json_decode($Hasil, true);
            $Hasil = json_encode($Hasil['original']);
            // return $Hasil;           
            return fnEnCrypt($Hasil);           
        } catch (\Exception $e) {
            // dd($e);
            return response()->json(['gagal_panggil_link'], 404);
        }

    }    


    public function Kirim(Request $request) {

        try {
            $RoutePath = $request->Controller."@".$request->Method;
            $Hasil = App::call('\App\Http\Controllers\Forms\\'.$RoutePath);
            $Hasil = json_encode($Hasil);
            $Hasil = json_decode($Hasil, true);
            $Hasil = json_encode($Hasil['original']);
            // return $Hasil;           
            return fnEnCrypt($Hasil);           
        } catch (\Exception $e) {
            die("Gagal Kirim Router" . $e );
        }

    }            


    public function Cetak(Request $request) {

        try {
            $RoutePath = $request->Controller."@".$request->Method;
            $Hasil = App::call('\App\Http\Controllers\Reports\\'.$RoutePath);
            return $Hasil;           
        } catch (\Exception $e) {
            die("Gagal Cetak Router" . $e );
        }

    }        
}
