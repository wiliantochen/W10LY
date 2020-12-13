<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
// use App\Models\TBLSYS;
// use App\Models\TBLDSC;
use App\Models\SYSCOM;
use App\Models\SYSTBL;
use App\Models\SYSDAT;
use App\Models\SYSNOR;
use DB;

class cTES123 extends cSOController {

    public function Coba() {
// dd('aaa');
            $arrCSDT = fnGetRec("MITMAS", 
                                "MMITNOIY,MMITNO,MMCSDT,MMCSID", 
                                "MMITNOIY", "300", "") ;

            echo ' ('.empty($arrCSDT).") ";

            dd($arrCSDT);

    }

    public function AwalXXX(Request $request) {

        $iTBL = SYSNOR::select('SNNOUR')->where('SNTABL','SYSTBL')->first()->SNNOUR;
        $iDAT = SYSNOR::select('SNNOUR')->where('SNTABL','SYSDAT')->first()->SNNOUR;


        $defaultFieldSYSTBL = [];
        $defaultFieldSYSTBL = array( "STRGID" => 'Default',
                                     "STRGDT" => Date("Y-m-d H:i:s"),
                                     "STCHID" => 'Default',
                                     "STCHDT" => Date("Y-m-d H:i:s"),
                                     "STCHNO" => '0',
                                     "STDPFG" => '1',
                                     "STDLFG" => '0',
                                     "STCSID" => 'Default',
                                     "STCSDT" => Date("Y-m-d H:i:s"),
                                     "STSRCE" => 'FirstSetup',
                                  );

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

        $SYSTBL = new SYSTBL();
        $SYSTBL->STTABLIY = $iTBL++;
        $SYSTBL->STTABL = 'CC';
        $SYSTBL->STNAME = 'CASH CREDIT';
        foreach ($defaultFieldSYSTBL as $K => $D) { $SYSTBL[$K] = $D; }
        $SYSTBL->save();

        $SYSDAT = new SYSDAT();
        $SYSDAT->SDTABLIY = ($iTBL-1);
        $SYSDAT->SDDATAIY = $iDAT++;
        $SYSDAT->SDDATA = 'T';
        $SYSDAT->SDNAME = 'TUNAI';
        foreach ($defaultFieldSYSDAT as $K => $D) { $SYSDAT[$K] = $D; }
        $SYSDAT->save();

        $SYSDAT = new SYSDAT();
        $SYSDAT->SDTABLIY = ($iTBL-1);
        $SYSDAT->SDDATAIY = $iDAT++;
        $SYSDAT->SDDATA = 'K';
        $SYSDAT->SDNAME = 'KREDIT';
        foreach ($defaultFieldSYSDAT as $K => $D) { $SYSDAT[$K] = $D; }
        $SYSDAT->save();


        $RunNoDSC = new SYSNOR();
        $RunNoDSC->SNTABL = 'SYSTBL';
        $RunNoDSC->SNNOUR = $iTBL;
        $RunNoDSC->SNRGID = 'Default';
        $RunNoDSC->SNRGDT = Date("Y-m-d H:i:s");
        $RunNoDSC->SNCHID = 'Default';
        $RunNoDSC->SNCHDT = Date("Y-m-d H:i:s");
        $RunNoDSC->SNCHNO = '0';
        $RunNoDSC->SNDPFG = '1';
        $RunNoDSC->SNDLFG = '0';
        $RunNoDSC->SNCSID = 'Default';
        $RunNoDSC->SNCSDT = Date("Y-m-d H:i:s");
        $RunNoDSC->SNSRCE = 'FirstSetup';        
        $RunNoDSC->update();

        $RunNoSYS = new SYSNOR();
        $RunNoSYS->SNTABL = 'SYSDAT';
        $RunNoSYS->SNNOUR = $iDAT;
        $RunNoSYS->SNRGID = 'Default';
        $RunNoSYS->SNRGDT = Date("Y-m-d H:i:s");
        $RunNoSYS->SNCHID = 'Default';
        $RunNoSYS->SNCHDT = Date("Y-m-d H:i:s");
        $RunNoSYS->SNCHNO = '0';
        $RunNoSYS->SNDPFG = '1';
        $RunNoSYS->SNDLFG = '0';
        $RunNoSYS->SNCSID = 'Default';
        $RunNoSYS->SNCSDT = Date("Y-m-d H:i:s");
        $RunNoSYS->SNSRCE = 'FirstSetup';        
        $RunNoSYS->update();

    }

    public function Awal(Request $request) {
        $this->prosesMittra('20190701','');
    }

    public function Awalzzzz(Request $request) {
        $a = SYSCOM::where('SCCOMP','DEMO')->get();
        echo $a[0]['SCCOMPIY'];
dd($a);
        return $a->tblsys;


        $C = [];
        $C = array("TDRGID" => 'Default',
                   "TDRGDT" => Date("Y-m-d H:i:s"),
                   "TDCHID" => 'Default',
                   "TDCHDT" => Date("Y-m-d H:i:s"),
                   "TDCHNO" => '0',
                   "TDDPFG" => '1',
                   "TDDLFG" => '0',
                   "TDCSID" => 'Default',
                   "TDCSDT" => Date("Y-m-d H:i:s"),
                   "TDSRCE" => 'FirstSetup',
                  );
        // dd($C);

        $TBLDSC = new TBLDSC();
        $TBLDSC->TDDSCDIY = 1;
        $TBLDSC->TDDSCD = 'DSPLY';
        $TBLDSC->TDDSNM = 'DISPLAY';
        $TBLDSC->TDLGTH = '1';
        foreach ($C as $K => $D) { $TBLDSC[$K] = $D; }
        dd($TBLDSC);


        $TBLDSC->TDRGID = 'Default';
        $TBLDSC->TDRGDT = Date("Y-m-d H:i:s");
        $TBLDSC->TDCHID = 'Default';
        $TBLDSC->TDCHDT = Date("Y-m-d H:i:s");
        $TBLDSC->TDCHNO = '0';
        $TBLDSC->TDDPFG = '1';
        $TBLDSC->TDDLFG = '0';
        $TBLDSC->TDCSID = 'Default';
        $TBLDSC->TDCSDT = Date("Y-m-d H:i:s");
        $TBLDSC->TDSRCE = 'FirstSetup';

        // http://localhost:9999/api/TestControllerAwal
        $Data = ["Controller"=>"cTBLSYS",
                 "Method"=>"LoadGrid",
                 "AppName"=>"5S",
                 "AppUserName"=>"Wili",
                 "AppDateInfo"=>"20190426",
                 "AppToken"=>"ssss",
                 ];
        $Hasil = "getData?Data=".fnEnCrypt(json_encode($Data));
        echo $Hasil;
        return;

        echo "Masuk<br>";
          $value = $request->cookie('17373c334f8faa51a00155d7a014ccf0');
          dd($value);
          echo $value;
          return ;

//         $a = SYSCOM::find(1);
// dd($a->tbldsc);
//         return $a->tbldsc;

//         $a = TBLDSC::where('TDDSCD','YN')->first();
// dd($a->tblsys);
//         return $a->tblsys;


        // $a = TBLDSC::all();

        // foreach ($a as $key => $value) {
        //     echo $a[$key];
        //     echo $a[$key]->tblsys;
        //     echo "<hr>";
        // }
        // dd($a);

        // $a = TBLDSC::get();
        // dd($a);

        // $a = TBLDSC::with('TBLSYS')->get();
        // dd($a);

        // $a = TBLDSC::with('TBLSYS')->where('TDDSCD','YN')->get();
        // return $a;

/*===============================================================================*/
// echo "<hr>";
// echo "Testing Performance";
//     $hamsters = TBLDSC::with('TBLSYS')->get();
//     foreach ($hamsters as $hamster){
//         // echo $hamster->tblsys->first()['TSSYCD']; //->first()->TSSYCD;
//         echo $hamster['TDDSCD']." = ";
//         foreach ($hamster->tblsys as $key => $value) {
//             echo $key." - ".$value['TSSYCD']."<br>";
//         }
//     }
//     echo "<hr>";
//     $hamsters = TBLDSC::get();
//     foreach ($hamsters as $hamster){
//         // echo $hamster->tblsys->first()['TSSYCD']; //()->first()->TSSYCD;
//         echo $hamster['TDDSCD']." = ";
//         foreach ($hamster->tblsys as $key => $value) {
//             echo $key." - ".$value['TSSYCD']."<br>";
//         }
//     }
// return '<br>done XXX<hr>';
/*===============================================================================*/



/*===============================================================================*/
// echo "<hr>";
// echo "Testing Performance";
//     $tblsys = TBLDSC::where('TDDSCD','YN')->get()->first()->tblsys;
//     foreach ($tblsys as $key => $value) {
//         echo $key." - ".$value['TSSYCD']."<br>";
//     }    
//     echo "<hr>";
//     $tblsys = TBLDSC::with('TBLSYS')->where('TDDSCD','YN')->get()->first()->tblsys;
//     foreach ($tblsys as $key => $value) {
//         echo $key." - ".$value['TSSYCD']."<br>";
//     }
// return '<br>done XXX<hr>';
/*===============================================================================*/


echo "<hr>";
echo "Testing Performance (MODEL TBLDSC ada TBLSYS) ";
    // echo "<hr>";
    // echo "$"."tblsys = TBLDSC::get(); -----> ";
    // echo "Yang ini Loading DB terus...";
    // echo "<hr>";
    // $tblsys = TBLDSC::get();
    // foreach ($tblsys as $data) {
    //     echo $data->tblsys;
    //     echo "<hr>";
    // }    
    // echo "<hr>";
    // echo "$"."tblsys = TBLDSC::with('TBLSYS')->get(); -----> ";
    // echo "Yang ini katanya Gak Loading DB lagi...";
    // echo "<hr>";
    // $tblsys = TBLDSC::with('TBLSYS')->get();
    // foreach ($tblsys as $data) {
    //     echo $data->tblsys;
    //     echo "<hr>";
    // }    
    echo "<hr>";
    echo "<hr>";
    echo "<hr>";
    $tblsys = TBLDSC::has('TBLSYS')->get();
    echo 'has'.$tblsys;
    dd($tblsys);

    foreach ($tblsys as $data) {
        echo $data->tblsys;
        echo "<hr>";
    }    
return '<br>done XXX<hr>';



        $a = TBLDSC::with('TBLSYS')->where('TDDSCD','YN')->get();
        foreach ($a as $key => $value) {
            echo $a[$key];
            echo $a[$key]->tblsys;
            foreach ($a[$key]->tblsys as $key => $value) {
                echo $value['TSSYCD']."xxxx";
            }
            echo "<hr>";
        }
        dd($a);

        return $a;



        dd($a);

        dd($a->SYSCOM->SCCODE);
        return $a;

        $a = TBLDSC::where('TDDSCD','YN')->get();
        // $b = $a->test;
        // $a = TBLDSC::all();
        return $a->syscom->sccode;


        $a = TBLSYS::where('TSSYCD','Y');
        // $b = $a->TBLDSC();
        dd($a);

        // foreach ($a as $key => $value) {
        //     echo $a[$key]->TBLDSC-TDNAME;
        //     echo $value;

        // }
        dd($a);

    }


    public function Akhir() {


var_dump($_SERVER);
echo "<br><br><br><br>";
$computerId = $_SERVER['HTTP_USER_AGENT']." <br> ".$_SERVER['REMOTE_PORT']." <br> ".$_SERVER['REMOTE_ADDR'];
echo "Computer iD : ".$computerId."<br>";
echo gethostbyaddr($_SERVER['REMOTE_ADDR']);

echo "<br><br><br><br>";


        $indicesServer = array('PHP_SELF', 
'argv', 
'argc', 
'GATEWAY_INTERFACE', 
'SERVER_ADDR', 
'SERVER_NAME', 
'SERVER_SOFTWARE', 
'SERVER_PROTOCOL', 
'REQUEST_METHOD', 
'REQUEST_TIME', 
'REQUEST_TIME_FLOAT', 
'QUERY_STRING', 
'DOCUMENT_ROOT', 
'HTTP_ACCEPT', 
'HTTP_ACCEPT_CHARSET', 
'HTTP_ACCEPT_ENCODING', 
'HTTP_ACCEPT_LANGUAGE', 
'HTTP_CONNECTION', 
'HTTP_HOST', 
'HTTP_REFERER', 
'HTTP_USER_AGENT', 
'HTTPS', 
'REMOTE_ADDR', 
'REMOTE_HOST', 
'REMOTE_PORT', 
'REMOTE_USER', 
'REDIRECT_REMOTE_USER', 
'SCRIPT_FILENAME', 
'SERVER_ADMIN', 
'SERVER_PORT', 
'SERVER_SIGNATURE', 
'PATH_TRANSLATED', 
'SCRIPT_NAME', 
'REQUEST_URI', 
'PHP_AUTH_DIGEST', 
'PHP_AUTH_USER', 
'PHP_AUTH_PW', 
'AUTH_TYPE', 
'PATH_INFO', 
'ORIG_PATH_INFO') ; 

echo '<table cellpadding="10">' ; 
foreach ($indicesServer as $arg) { 
    if (isset($_SERVER[$arg])) { 
        echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ; 
    } 
    else { 
        echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ; 
    } 
} 
echo '</table>' ; 


    echo time() + (30 * 24 * 60 * 60 * 1000);
    // echo $HTTP_COOKIE_VARS;

    $link = "$_SERVER[REQUEST_URI]";
    $array_link = explode("/", $link);
    echo "<br>";
    echo $link;
    echo "<br>";
    echo $array_link[1] ;

    }

}
