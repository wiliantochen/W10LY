<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

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

    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }



    public function Login(Request $request)
    {
        // $this->validate($request, [
        //     'email'    => 'required|email|max:255',
        //     'password' => 'required',
        // ]);

        // dd('auth dulu');

        $this->validate($request, [
            'SCCOMP' => 'required',
            'TUUSER' => 'required',
            'TUPSWD' => 'required',
        ]);

        $request->request->add(array('user' => $request->input('TUUSER')));
        $request->request->add(array('pwrd' => $request->input('TUPSWD')));

        // dd($request);

        try {

            $SYSCOM = SYSCOM::where('SCCOMP', '=', $request->input('SCCOMP'))->first();
            if ($SYSCOM == null) {                
                return response()->json(['Access_Code_not_found'], 404);
            }

            $TBLUSR = TBLUSR::select('TUUSER', 'TUPSWD', 'TUUSERIY' )
                    ->where([
                        ['TUCOMPIY', '=', $SYSCOM->SCCOMPIY],
                        ['TUUSER', '=', $request->TUUSER],
                      ])
                    ->first();     

            $credentials = $request->only('TUUSER');
            $credentials['TUCOMPIY'] = $SYSCOM->SCCOMPIY;
            $credentials['TUUSER'] = $request->input('TUUSER');
            $credentials['password'] = $request->input('TUPSWD');
            
            /*
             | Note :
             | app('hash')->make('admin123'); jadi harus pakai hash
             | karena password_verify('','') --> sintax ini dari PHP
             |
             |
             $a = app('hash')->make('admin123'); //-->"$2y$10$pRMWcHsILrkRDeTht0BjhuByizRxw4phL/dAX5G1FD22XNpunceYm"
             dd($a);
             */

            if (! $token = $this->jwt->attempt($credentials)) {            
                return response()->json(['user_not_found'], 404);
            }


        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent' => $e->getMessage()], 500);

        }



        DB::table('TBLUSR')
            ->where('TUUSERIY','=',$TBLUSR->TUUSERIY)                    
            ->update(['TULSLI' => date('Y-m-d H:i:s')]);

        //TULSLI
        /*
                DB::table('TBLUSR')
                    ->where('TUUSERIY','=',$TBLUSR->TUUSERIY)                    
                    ->update(['TULSLI' =>now()]);
        */

        // $Hasil = compact('token');
        // $Hasil['date'] = date('Ymd_His');
        // // dd($Hasil);
        // return response()->json($Hasil);    

        // // $UserClientInfo = $_SERVER['REMOTE_ADDR'].gethostbyaddr($_SERVER['REMOTE_ADDR']);
        // $UserClientInfo = $_SERVER['REMOTE_ADDR'];
        // $AppName = $request->AppName.$request->SCCOMP;
        // // begin generate token
        // $Koneksi = DB::connection()->getConfig("host").DB::connection()->getDatabaseName().$AppName;
        // $Date = date('Ymd_His');
        // $token = $Koneksi."".$Date."".$request->TUUSER.$UserClientInfo;
        // $token = fnEncryptPassword("Aliang2020".$token);            
        // $tokenvalue = fnEncryptPassword("Aliang2020".$token);
        // // end generate token

        // $a = array("Koneksi"=>$Koneksi,"Date"=>$Date,"Token"=>$token,"TokenValue"=>$tokenvalue);
        // dd($a);

        $Date = date('Ymd_His');
        return response()->json([
                            'success'=>true,
                            'message'=>'',
                            'dateInfo'=>$Date,
                            'token'=>compact('token')['token']
                        ]);


    }


    public function test(Request $request)
    {
        // dd($request->user());
        return "Sukses Tokennya....";
    }    

    public function CheckLogin(Request $request) {
        // dd('masuk CheckLogin');
        // auth()->invalidate(); // auth()->invalidate(true);    
        // auth()->logout();

        // auth()->refresh();    
        // $token = auth()->fromUser(auth()->user());
        // dd($token);

        // dd(auth()->factory()->getTTL() * 60);

        // $TBLUSR = $request->user();
        // dd($TBLUSR);


        // DB::table('TBLUSR')
        //     ->where('TUUSERIY','=',1)                    
        //     ->update(['TULSLI' => date('Y-m-d H:i:s')]);

        $TBLUSR = $request->user();
        $token = "";
        $expire_auth    = (auth()->factory()->getTTL() * 60);
        // dd($expire_auth);
        // $waktu_awal     =strtotime("2019-10-11 00:01:25");
        // $waktu_akhir    =strtotime("2019-10-12 12:07:59"); // bisa juga waktu sekarang now()
        $waktu_awal     = strtotime($TBLUSR->TULSLI);
        $waktu_akhir    = strtotime(date('Y-m-d H:i:s')); // bisa juga waktu sekarang now()
        //menghitung selisih dengan hasil detik
        $diff           = $waktu_akhir - $waktu_awal;
        // dd($diff);
        
        $diff_auth = $expire_auth - $diff;
        if ( $diff_auth >= 0 && $diff_auth <= 300) {
            DB::table('TBLUSR')
                ->where('TUUSERIY','=',$TBLUSR->TUUSERIY)                    
                ->update(['TULSLI' => date('Y-m-d H:i:s')]);
            $token = auth()->fromUser(auth()->user());
            // dd("Sudah mau expired!!! ".$diff_auth." -> ".date('Y-m-d H:i:s'));            
        }
        // dd($diff_auth." -> ".date('Y-m-d H:i:s'));

        $Date = $request->AppDateInfo;
        return response()->json(['success'=>true,'message'=>'','dateInfo'=>$Date,'token'=>$token]);

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
        auth()->invalidate(); // auth()->invalidate(true);   
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

        $TBLUSR = $request->user();

        $SYSMNU = DB::table('SYSMNU')
                ->select('SMMENU', 'SMNOMR', 'SMSCUT', 'SMMENUIY', 'SMACES', 'TAACES', 'SMURLW', 'SMGRUP')
                ->leftJoin('TBLUAM', function($join) use($TBLUSR) {
                    $join->on('TAMENUIY', '=', 'SMMENUIY');
                    $join->where('TAUSERIY', '=',  $TBLUSR->TUUSERIY);
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
