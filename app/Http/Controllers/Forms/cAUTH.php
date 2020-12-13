<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\SYSCOM;
use App\Models\TBLUSR;
use App\Models\SYSMNU;
use DB;

class cAUTH extends cSOController {

    /*
    	Cara testing....
        http://localhost:8099/laravelwili/index.php/getData2?Controller=c_user&Method=login&TUUSER=admin&TUPSWD=admin&FLAG_ECHO=true
        http://localhost:8099/laravelwili/index.php/getData?Data=fSJmZHNhIjoiUkVTVVVUIiwibmlnb0wiOiJkb2h0ZU0iLCJyZXNVX2MiOiJyZWxsb3J0bm9DIns=
    */

    public function Login(Request $request) {
        
        $DataJSon = fnDecrypt($request->Data, "");
        // echo ;
        if (is_null($DataJSon)) {
            return response()->Json(fnProtectHack());
        }

        foreach($DataJSon as $row => $value) {  // Begin Looping DataJSon
            $request->request->add(array($row => $value));
        }  // End Looping DataJSon


        $SYSCOM = SYSCOM::where('SCCOMP',$request->SCCOMP)->first();

        $TBLUSR = TBLUSR::select('TUUSER', 'TUPSWD')
                ->where([
                    ['TUCOMPIY', '=', $SYSCOM->SCCOMPIY],
                    ['TUUSER', '=', $request->TUUSER],
                  ])
                ->get();     

// echo "Password : (".fnEncryptPassword($request->TUPSWD).") ";
// dd($TBLUSR->toArray());

        $Sukses = false;
		if (count($TBLUSR)==0) {
	        $Sukses = false;
		} else {
            $arr_TBLUSR = $TBLUSR[0];
            if ($request->TUPSWD=="") { 
                $Sukses = false; 
            } else if (rtrim($arr_TBLUSR['TUPSWD'])==fnEncryptPassword($request->TUPSWD)) { 
                $Sukses = true; 
            }
		}   

        if ($Sukses) {
            // $UserClientInfo = $_SERVER['REMOTE_ADDR'].gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $UserClientInfo = $_SERVER['REMOTE_ADDR'];
            $AppName = $request->AppName.$request->SCCOMP;
            // begin generate token
            $Koneksi = DB::connection()->getConfig("host").DB::connection()->getDatabaseName().$AppName;
            $Date = date('Ymd_His');
            $token = $Koneksi."".$Date."".$request->TUUSER.$UserClientInfo;
            $token = fnEncryptPassword("WilEdi2019".$token);            
            $tokenvalue = fnEncryptPassword("WilEdi2019".$token);
            // end generate token

            // begin generate cookies
            $cookiesCode = DB::connection()->getConfig("host").DB::getDatabaseName().$AppName.$Date;

            $cookiesToken = fnEncryptPassword("token".$cookiesCode);
            $cookiesName = fnEncryptPassword("name".$cookiesCode);
            $cookiesDate = fnEncryptPassword("dateInfo".$cookiesCode);

            $cookiesTokenValue = $tokenvalue;
            $cookiesNameValue = fnEncryptPassword($request->TUUSER.$Date);
            $cookiesDateValue = fnEncryptPassword($Date);
            // end generate cookies

            return response()->json([
                                'success'=>true,
                                'message'=>'',
                                'dateInfo'=>$Date,
                                'token'=>$token
                            ])
                            ->withCookie(cookie($cookiesToken, $cookiesTokenValue, 1))
                            ->withCookie(cookie($cookiesName, $cookiesNameValue, 1))
                            ->withCookie(cookie($cookiesDate, $cookiesDateValue, 1));
        } else {
            // return response()->json(['success'=>false,'data'=>$TBLUSR,'token'=>'','Cookies_Name'=>'']);         
            return response()->json([
                                'success'=>false,
                                'message'=>'Username and Password not match!!!',
                                'dateInfo'=>'',
                                'token'=>'']);         
        }           

    }

    public function CheckLogin(Request $request) {

        // $UserClientInfo = $_SERVER['REMOTE_ADDR'].gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $UserClientInfo = $_SERVER['REMOTE_ADDR'];
        $AppName = $request->AppName.$request->AppCompanyCode;  

        $Koneksi = DB::connection()->getConfig("host").DB::connection()->getDatabaseName().$AppName;
        $Date = $request->AppDateInfo;
        $token = $Koneksi."".$Date."".$request->AppUserName.$UserClientInfo;
        $token = fnEncryptPassword("WilEdi2019".$token);                 

        if ( $token==$request->AppToken )  {
            return response()->json(['success'=>true,'message'=>'','dateInfo'=>$Date]);
        } else {
            return response()->json(['success'=>false,'message'=>'','dateInfo'=>$Date]);
        }

    }    

    public function GetProfile(Request $request) {
        
        $TBLUSR = TBLUSR::select('TUFOTO')
                ->where([
                    ['TUUSER', '=', $request->name],
                  ])
                ->get();   

        $Hasil = $this->fnGenDataFile($TBLUSR[0]['TUFOTO']);

        return response()->jSon($Hasil); 
                
    }    

    public function Logout(Request $request) {
    
    }


    function buildTree(array $elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                    $element['icon'] = 'folder_open';
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    public function LoadUserTreeMenu(Request $request) {

        /*
           $SYSMNU = SYSMNU_Model::select('SMMENU', 'SMNOMR', 'SMSCUT', 'SMMENUIY')
                    ->where([
                        ['SMDPFG', '=', '1'],
                      ])
                    ->orderBy('SMNOMR')
                    ->get();

        */

        $USERIY = fnGetRec('TBLUSR','TUUSERIY','TUUSER',$request->Username,'');

        $SYSMNU = DB::table('SYSMNU')
                ->select('SMMENU', 'SMNOMR', 'SMSCUT', 'SMMENUIY', 'SMACES', 'TAACES', 'SMURLW', 'SMGRUP')
                ->leftJoin('TBLUAM', function($join) use($USERIY) {
                    $join->on('TAMENUIY', '=', 'SMMENUIY');
                    $join->where('TAUSERIY', '=', $USERIY->TUUSERIY);
                })
                ->where([
                    ['SMDPFG', '=', '1'],
                  ])
                ->orderBy('SMNOMR')
                ->get();


        $tree = []; $rute = [];
        foreach($SYSMNU as $row) {  // Begin Looping Record SYSMNU  
            $Pjg = strlen(rtrim($row->SMNOMR));
            $Disabled = false;
            $icon = 'launch';
            $id = rtrim($row->SMNOMR);    // ID
            $nilai = [];
            if (rtrim($row->SMSCUT)=="") {  // Begin Nama Menu
                $name = rtrim($row->SMMENU);    
                $value = 'H'.rtrim($row->SMMENUIY); // Nilai
                $nilai[] = array("id"=> "", "label"=> $name ) ; 
            } else {
                $name = "[".rtrim($row->SMSCUT)."] ".rtrim($row->SMMENU);    
                // $name = rtrim($row->SMMENU). " (". rtrim($row->SMACES).") (".rtrim($row->TAACES).")"; 
                if (!strpos(" ".rtrim($row->TAACES),"V")) {
                    $Disabled=true;
                    $icon='block';
                }
                $nilai[] = array("id"=> rtrim($row->SMMENUIY), 
                                 "label"=> $name, 
                                 "label1"=>rtrim($row->SMSCUT), 
                                 "label2"=>rtrim($row->SMMENU) ) ; 
                $value = rtrim($row->SMMENUIY); // Nilai
            } // End Nama Menu

            $pid = substr($id,0,($Pjg-2));  // Parent ID

            

            // $tree[] = array("label"=>$name,"icon"=>'folder',"value"=>$value,"id"=>$id,"parent_id"=>$pid);               
            // $tree[] = array("label"=>$name,"disabled"=>'true',"value"=>$value,"id"=>$id,"parent_id"=>$pid);               
            $tree[] = array("label"=>$name,
                            "disabled"=>$Disabled,
                            "icon"=>$icon,
                            "id"=>$id,
                            "value"=>$value,
                            "parent_id"=>$pid,
// ----------------------------------------------------------------------
                            "title"=>rtrim($row->SMMENU),
                            "shortCut"=>rtrim($row->SMSCUT),
                            "idMenu"=>$row->SMMENUIY,
                            "layout"=>"1",
                            "titleAction"=>"",
                            "modeAction"=>"",
                            "menuAkses"=>rtrim($row->SMACES),
                            "userAkses"=>rtrim($row->TAACES),
// ----------------------------------------------------------------------
                            "tombol"=>array("V"=>$this->SetTombol("V", rtrim($row->SMACES), rtrim($row->TAACES)),
                                            "A"=>$this->SetTombol("A", rtrim($row->SMACES), rtrim($row->TAACES)),
                                            "E"=>$this->SetTombol("E", rtrim($row->SMACES), rtrim($row->TAACES)),
                                            "D"=>$this->SetTombol("D", rtrim($row->SMACES), rtrim($row->TAACES)),
                                            "L"=>$this->SetTombol("L", rtrim($row->SMACES), rtrim($row->TAACES)),
                                            "V"=>$this->SetTombol("V", rtrim($row->SMACES), rtrim($row->TAACES)),
                                            "X"=>$this->SetTombol("X", rtrim($row->SMACES), rtrim($row->TAACES)),
                                            "R"=>$this->SetTombol("R", rtrim($row->SMACES), rtrim($row->TAACES)),
                                            "P"=>$this->SetTombol("P", rtrim($row->SMACES), rtrim($row->TAACES)),
                                            "Save"=>array("has"=>true,"show"=>false,"disabled"=>false),
                                            "Cancel"=>array("has"=>true,"show"=>false,"disabled"=>false),
                                            ),
// ----------------------------------------------------------------------
                            "XXXX"=>"XXXX");               


            if (rtrim($row->SMURLW)!="") {  // Begin Data Rute
                $rute[] = array("path"=>rtrim($row->SMGRUP) === "" ? rtrim($row->SMURLW) : rtrim($row->SMGRUP),
                                "name"=>$row->SMMENUIY,
                                "shortCut"=>rtrim($row->SMSCUT),
                                "url"=>rtrim($row->SMURLW),
                                // "props"=>array("".rtrim($row->SMURLW) => array( "Mode"=> "5", "sidebar"=>false) ),
                                // "props"=>array("".rtrim($row->SMURLW) => array( "Mode"=> "5", "sidebar"=>false), "Mode" => "ABCDE" ),
                                // "props"=>array("Mode" => rtrim($row->SMURLW) ),
                                // "menu"=>rtrim($row->SMMENU)."/".fnEncryptPassword('W'.$row->SMMENUIY.date('YmdHis') )
                                "menu"=>fnEncryptPassword('W'.$row->SMMENUIY.date('YmdHis') )
                                // "menu"=>$row->SMMENUIY 
                                );               
            } // End Data Rute

        }  // End Looping Record SYSMNU

        $DataTree = $this->buildTree($tree);
        $DataRute = $rute;
        
        $Hasil = array("DataTree"=>$DataTree,
                       "DataRute"=>$DataRute);

        return response()->jSon($Hasil);        

    }    

    function SetTombol($mode, $m, $u) {
        $has = false; 
        $show = false; 
        $disabled = true; 

        if (strpos(' '.strtoupper($m), strtoupper($mode), 0) > 0 ) { 
            $has = true; $show = true; $disabled = true; 
            if (strpos(' '.strtoupper($u), strtoupper($mode), 0) > 0 ) { 
                $disabled = false;             
            }
        }
        return array("has"=>$has,"show"=>$show,"disabled"=>$disabled) ;
    }

}
