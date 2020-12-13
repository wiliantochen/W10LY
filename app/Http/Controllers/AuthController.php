<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

use Cookie;

use App\Models\SYSCOM;
use App\Models\SYSMNU;

class AuthController extends Controller
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function postLogin(Request $request)
    {
        // $this->validate($request, [
        //     'email'    => 'required|email|max:255',
        //     'password' => 'required',
        // ]);

        // dd('auth dulu');

        $this->validate($request, [
            'kodeAkses' => 'required',
            'user' => 'required',
            'pwrd' => 'required',
        ]);

        try {

            $SYSCOM = SYSCOM::where('SCCOMP', '=', $request->input('kodeAkses'))->first();
            if ($SYSCOM == null) {                
                return response()->json(['Access_Code_not_found'], 404);
            }

            $credentials = $request->only('TUUSER');
            $credentials['TUCOMPIY'] = $SYSCOM->SCCOMPIY;
            $credentials['TUUSER'] = $request->input('user');
            $credentials['password'] = $request->input('pwrd');
            
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


        $Hasil = compact('token');
        $Hasil['date'] = date('Ymd_His');

        return response()->json($Hasil);        

        // dd(fnEnCrypt(json_encode($Hasil)));
        // return response()->json(fnEnCrypt(json_encode($Hasil)));        

        // dd(compact('token'));
        // return response()->json(compact('token'));        


    }

    public function test(Request $request)
    {
        // dd($request->user());
        return "Sukses Tokennya....";
    }

    public function getUserLogin(Request $request)
    {
        return response()->json(['status' => 'success', 'data' => $request->user()]);
    }



    function buildTree(array $elements, $parentId = 0) 
    {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                    // $element['icon'] = 'folder_open';
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    public function LoadListUserMenu(Request $request) 
    {

        /*
           $SYSMNU = SYSMNU_Model::select('SMMENU', 'SMNOMR', 'SMSCUT', 'SMMENUIY')
                    ->where([
                        ['SMDPFG', '=', '1'],
                      ])
                    ->orderBy('SMNOMR')
                    ->get();

        */

        $TBLUSR = $request->user();

        $SYSMNU = SYSMNU::select('SMMENU', 'SMNOMR', 'SMSCUT', 'SMMENUIY', 'SMACES', 'TAACES', 'SMURLW', 'SMGRUP', 'SMMENUIY')
                        ->leftJoin('TBLUAM', function($join) use($TBLUSR) {
                            $join->on('TAMENUIY', '=', 'SMMENUIY');
                            $join->where('TAUSERIY', '=', $TBLUSR->TUUSERIY);
                        })
                        ->where([
                            ['SMDPFG', '=', '1'],
                          ])
                        ->orderBy('SMNOMR')
                        ->get();


        $tree = []; $rute = [];
        foreach($SYSMNU as $row) {  // Begin Looping Record SYSMNU  
            $Pjg = strlen(rtrim($row->SMNOMR));
            $Disabled = true;
            $icon = 'launch';
            $nilai = [];
            $name = rtrim($row->SMMENU);    
            $id = $row->SMNOMR;    // ID    
            $idMenu = $row->SMMENUIY;    // ID
            
            if (( rtrim($row->SMSCUT)=="" && rtrim($row->SMURLW)=="")) {
                $Disabled=true;
            } else {
                if (strpos(" ".rtrim($row->TAACES),"V")>=1) {
                    $Disabled=false;
                }
            }

            $pid = substr($id,0,($Pjg-2));  // Parent ID
            

            $baris = [];
            $baris['text'] = $name;
            $baris["id"] = $id;
            $baris["idMenu"] = $idMenu;
            $baris["mAkses"] = rtrim($row->SMACES);
            $baris["uAkses"] = rtrim($row->TAACES);
            $baris["enabled"] = !$Disabled;
            $baris["key"] = rtrim($row->SMURLW);
            if (( rtrim($row->SMSCUT)=="" && rtrim($row->SMURLW)=="")) {
                $baris["expanded"] = false;
            } else {
                $baris["leaf"] = true;
            }
            $baris["disabledCls"] = 'x-item-disabled';
            $baris["iconCls"] = 'x-fa fa-file-o';
            $baris["parent_id"] = $pid;

            $tree[] = $baris;

            // $tree[] = array("text"=>$name,              
            //                 "id"=>$id,
            //                 "idMenu"=>$id,
            //                 "mAkses"=>rtrim($row->SMACES),
            //                 "uAkses"=>rtrim($row->TAACES),
            //                 // "leaf"=>true,
            //                 // "remark"=>strpos(" ".rtrim($row->TAACES),"V"),
            //                 "enabled"=>!$Disabled,
            //                 "expanded"=>$id,
            //                 "disabledCls"=>'x-item-disabled',
            //                 "iconCls"=>'x-fa fa-file-o',
            //                 "parent_id"=>$pid,
            //                 "XXXX"=>"XXXX");               


        }  // End Looping Record SYSMNU


        $DataTree = $this->buildTree($tree);        
        $Hasil = array("children"=>$DataTree);

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


    public function LoadListUserMenuXXX(Request $request) 
    {


        $Hasil = "
        {children: [
         { text: 'Dashboard XXX' , iconCls: 'x-fa fa-desktop', rowCls: 'nav-tree-badge nav-tree-badge-new', viewType: 'admindashboard', routeId: 'dashboard', leaf: true , idMenu:'0', mAkses:'VE', uAkses:'VE' }
        ,{ text: 'FILE',expanded: false,children:[ 
         { text: '[FIL001] SINTAX LOG FILE', id:'TBLSLF', idMenu:'2', mAkses:'VXL', uAkses:'VXL', leaf: true , enabled: true, disabledCls: 'x-item-disabled' , iconCls: 'x-fa fa-file-o' } 
        ,{ text: '[FIL002] ERROR LOG FILE', id:'TBLELF', idMenu:'3', mAkses:'VXL', uAkses:'VXL', leaf: true , enabled: true, disabledCls: 'x-item-disabled' , iconCls: 'x-fa fa-file-o' } 
        ,{ text: '[FIL003] MENU', id:'TBLMNU', idMenu:'4', mAkses:'VAEDLX', uAkses:'VAEDLX', leaf: true , enabled: false, disabledCls: 'x-item-disabled' , iconCls: 'x-fa fa-close' } 
        ,{ text: '[FIL004] SET USER', id:'TBLUSR', idMenu:'5', mAkses:'VAEDLX', uAkses:'VAEDLX', leaf: true , enabled: false, disabledCls: 'x-item-disabled' , iconCls: 'x-fa fa-close' } 
        ,{ text: '[FIL005] COMMENT MENU', id:'TBLCMT', idMenu:'6', mAkses:'VAEDLX', uAkses:'VAEDLX', leaf: true , enabled: false, disabledCls: 'x-item-disabled' , iconCls: 'x-fa fa-close' } 
        ,{ text: '[FIL006] QUERY ANALYZER', id:'QUERY', idMenu:'7', mAkses:'VX', uAkses:'VX', leaf: true , enabled: false, disabledCls: 'x-item-disabled' , iconCls: 'x-fa fa-close' } 
        ,{ text: '[FIL007] LOCK TRANSACTION MENU', id:'TBLOCK', idMenu:'8', mAkses:'VDX', uAkses:'VDX', leaf: true , enabled: false, disabledCls: 'x-item-disabled' , iconCls: 'x-fa fa-close' } 
        ,{ text: '[FIL008] PROCESS BATCH LOG FILE', id:'TBLPLF', idMenu:'9', mAkses:'VXL', uAkses:'VXL', leaf: true , enabled: false, disabledCls: 'x-item-disabled' , iconCls: 'x-fa fa-close' } 
        ,{ text: '[FIL009] MAINTAINCE LOGFILE', id:'TBLHSS', idMenu:'10', mAkses:'VXL', uAkses:'VXL', leaf: true , enabled: false, disabledCls: 'x-item-disabled' , iconCls: 'x-fa fa-close' } ]}
        ,{ text: 'MASTER',expanded: false,children:[
         { text:' MASTER SYSTEM',expanded: false,children:[
         { text: '[SYS005] MASTER TABLE PARAMETER', id:'TBLPRM', idMenu:'13', mAkses:'VAEDLX', uAkses:'VAEDLX', leaf: true , enabled: false, disabledCls: 'x-item-disabled' , iconCls: 'x-fa fa-close' } 
        ,{ text: '[SYS010] MASTER TABLE DESCRIPTION *', id:'TBLDSC', idMenu:'14', mAkses:'VAEDLX', uAkses:'VAEDLX', leaf: true , enabled: false, disabledCls: 'x-item-disabled' , iconCls: 'x-fa fa-close' } 
        ,{ text: '[SYS015] MASTER TABLE SYSTEM *', id:'TBLSYS', idMenu:'15', mAkses:'VAEDLX', uAkses:'VAEDLX', leaf: true , enabled: false, disabledCls: 'x-item-disabled' , iconCls: 'x-fa fa-close' } 
        ,{ text: '[SYS020] MASTER TABLE ERROR MESSAGE', id:'TBLSMG', idMenu:'16', mAkses:'VAEDLX', uAkses:'VAEDLX', leaf: true , enabled: false, disabledCls: 'x-item-disabled' , iconCls: 'x-fa fa-close' } ]}, ]}
        ,{ text: 'TRANSACTION',expanded: false,children:[
         { text: '[TRS005] MESSAGE REPORT', id:'MSGTRS', idMenu:'18', mAkses:'VALXE', uAkses:'AXVLE', leaf: true , enabled: false, disabledCls: 'x-item-disabled' , iconCls: 'x-fa fa-close' } ]}
        ,{ text: 'Email', iconCls: 'x-fa fa-send', rowCls: 'nav-tree-badge nav-tree-badge-hot', viewType: 'email', leaf: true }
        ,{ text: 'Profile', iconCls: 'x-fa fa-user', viewType: 'profile', leaf: true }
        ,{ text: 'Search results', iconCls: 'x-fa fa-search', viewType: 'searchresults', leaf: true }
        ,{ text: 'FAQ', iconCls: 'x-fa fa-question', viewType: 'faq', leaf: true }
        ,{ text: 'Widgets', iconCls: 'x-fa fa-flask', viewType: 'widgets', leaf: true }
        ,{ text: 'Forms', iconCls: 'x-fa fa-edit', viewType: 'forms', leaf: true }
        ,{ text: 'Charts', iconCls: 'x-fa fa-pie-chart', viewType: 'charts', leaf: true } 
        ]}
        ";

        return $Hasil;       

    }


    public function grid(Request $request)
    {
        // dd($request->user());
        $a = '
                { name: "Jean Luc", email: "jeanluc.picard@enterprise.com", phone: "555-111-1111" },
                { name: "Worf",     email: "worf.moghsson@enterprise.com",  phone: "555-222-2222" },
                { name: "Deanna",   email: "deanna.troi@enterprise.com",    phone: "555-333-3333" },
                { name: "Data",     email: "mr.data@enterprise.com",        phone: "555-444-4444" }
            ';
        
        $a = [];
        array_push($a, array( "name" => "Jean Luc", "email" => "jeanluc.picard@enterprise.com", "phone" => "555-111-1111") );
        array_push($a, array( "name" => "Worf",     "email" => "worf.moghsson@enterprise.com",  "phone" => "555-222-2222") );
        array_push($a, array( "name" => "Deanna",   "email" => "deanna.troi@enterprise.com",    "phone" => "555-333-3333") );
        array_push($a, array( "name" => "Data",     "email" => "mr.data@enterprise.com",        "phone" => "555-444-4444") );

        // return $a;
        return response()->jSon($a);    
    }


}