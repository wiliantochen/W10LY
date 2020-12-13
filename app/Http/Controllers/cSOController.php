<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use DB;
use Illuminate\Support\Facades\Storage as Storage;

class cSOController extends Controller 
{
	

    public function getFormObject($FormObj, $Tipe="") {
      switch ($Tipe) {
        case '1':
          break;        
        default:
          $Hasil = array_filter(array_keys($FormObj), function ($k) use($FormObj) { return $FormObj[$k]['FFTipe'] === "FF"; }); 
          $a = array_filter($FormObj, function ($k) { return $k['Tipe'] === "pop"; }); 
          foreach ($a as $k => $o) {
                array_push($Hasil, $o['PopCode']);
                array_push($Hasil, $o['PopDesc']);
          }
          // dd($Hasil);
          break;
      }
      return $Hasil;

    }


    public function setFillForm($Sukses, $Hasil, $Message) {   
        if ($Hasil == "") {
            $Data = [];
        } else {
            $Data = $Hasil->count() != 0 ? $Hasil[0] : [];
        }
        return array( "success"=> $Sukses, "data"=> $Data, "message"=> $Message);
    }

    public function doExecuteQuery($UserName, $cm) {

        $Hasil = fnSetExecuteQuery($UserName, $cm); 
        // return $Hasil;

        if(!$Hasil['success']) {
          if (!isset($Hasil['eCode'])) {
            $Data = ["success"=>false,
                     "message"=>$Hasil['message'],
                     "code"=>"", ];
          } else {
            $Data = ["success"=>false,
                     "message"=>$this->getErrorMessage($Hasil['eCode']),
                     "code"=>$Hasil['eCode']['error_code'], ];
          }
        } else {
          $Data = ["success"=>true,
                   "message"=>$Hasil['message'],
                   "code"=>"", ];
        }
        return $Data;

    }

    public function getErrorMessage($err) {
        $msg = "";
        switch ($err['error_code']) {
            case "1406":
            case "22001":
                $msg = "[Field] Data value is too long";
                break;
            case "1062":
            case "23000":
                $msg = "[Primary Key] Duplicate Data, Please check again!!!";
                break;
            default:
                // $trace = $err->getTrace();
                // $message =  $err->getMessage().' in '.$err->getFile().' on line '.$err->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
                $msg = $err['message'];
                break;
        }
        return $msg;
    }

    public function prosesMittra($TRDT, $ITNOIY) {
        $SHLINE = DB::table('SHLINE')
                    ->select('SLITNOIY As MTITNOIY',
                             '-1*SLQTYS As MTQTYS',
                             'SLHARG As MTHARG',
                             'SLTOTL As MTTOTL'
                             )
                    ->leftJoin('SHHEAD','SHSHNOIY','SLSHNOIY')
                    ->where(function($query) use($TRDT, $ITNOIY) {
                        if ($TRDT != "") {
                          $query->where('SHDATE','>=', $TRDT);
                        }
                        if ($ITNOIY != "") {
                          $query->where('SLITNOIY',$ITNOIY);
                        }
                    });
        // dd($SHLINE->get());

        $PHLINE = DB::table('PHLINE')
                    ->select('PLITNOIY As MTITNOIY',                          
                             'PLQTYS As MTQTYS',
                             'PLHARG As MTHARG',
                             'PLTOTL As MTTOTL')
                    ->leftJoin('PHHEAD','PHPHNOIY','PLPHNOIY')
                    ->where(function($query) use($TRDT, $ITNOIY) {
                        if ($TRDT != "") {
                          $query->where('PHDATE','>=', $TRDT);
                        }
                        if ($ITNOIY != "") {
                          $query->where('PLITNOIY',$ITNOIY);
                        }
                    });
        // dd($PHLINE->get());

        $A = $SHLINE->unionall($PHLINE);
        dd($A->get());

    }

}
