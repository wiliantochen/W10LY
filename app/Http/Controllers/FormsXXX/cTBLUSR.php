<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller; //as cWeController
use Illuminate\Http\Request;
use App\Models\TBLUSR;
use App\Models\SYSMNU;
use DB;

class cTBLUSR extends Controller {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {
        $this->GridObj = [];
        // fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        fnCrtColGrid($this->GridObj, "rno", 1, 1, '', 'No', '', 50);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'TUUSERIY', 'User IY', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'TUUSER', 'Login Name', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'TUNAME', 'Full Name', 100);
        // fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'TUPSWD', 'Password', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 1, '', 'TUEMID', 'Employee ID', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'TUDEPT', 'Department', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'TUMAIL', 'Mail', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 1, '', 'TUWELC', 'Welcome Text', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'TUUSRM', 'User Remark', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'TUREMK', 'Remark', 100);
        fnCrtColGridDefault($this->GridObj, "TU");


        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('property'=>'TUUSER','direction'=>'asc');
        $this->GridColumns = [];


        $TBLUSR = TBLUSR::where([
                            ['TUCOMPIY', '=', $request->user()->TUCOMPIY],
                            ['TUDLFG', '=', '0'],
                          ]);

        $TBLUSR = fnQuerySearchAndPaginate($request, $TBLUSR, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);
        $Data = json_decode(json_encode($TBLUSR));

        $Hasil = [];
        foreach ($Data as $key => $row) {
            // array_push($Hasil, array($key => $row));
            if ($key=="data") {
                $Hasil["items"] = $row;
            } else {
                $Hasil[$key] = $row;
            }
        }
        $Hasil["Column"] = $this->GridColumns;
        return response()->jSon($Hasil);     

        // $Hasil = array( "Data"=> $TBLUSR,
        //                 "Column"=> $this->GridColumns,
        //                 "Sort"=> $this->GridSort,
        //                 "Filter"=> $this->GridFilter,
        //                 "Key"=> 'TUUSERIY');        
        // dd($Hasil);
        return response()->jSon($Hasil);     

    }


    private $FormObj = [];

    public function Setup(Request $request) {
        $L = 150;
        $cm = $request->cm;
        fnCrtObjNum($this->FormObj, $cm, 0, 0, "FF", "3", "TUUSERIY", "ID", "", $L, 200, 0);     
        fnCrtObjTxt($this->FormObj, $cm, 1, 1, "FF", "2", "TUUSER", "Login Name", "", $L, 100, 0, 50);     
        fnCrtObjTxt($this->FormObj, $cm, 1, 1, "FF", "0", "TUNAME", "Full Name", "", $L, 300);        
        fnCrtObjTxt($this->FormObj, $cm, 1, 1, "FF", "0", "TUPSWD", "Password", "", $L, 300);    
        fnCrtObjRad($this->FormObj, $cm, 1, 1, "FF", "0", "TUDPFG", "Status User", "", $L, "100", "1", "DSPLY");      
        fnCrtObjRad($this->FormObj, $cm, 1, 1, "FF", "0", "TUEXPP", "Expire Password", "", $L, "100", "1", "YN");      
        fnCrtObjDtp($this->FormObj, $cm, 1, 1, "FF", "0", "TUEXPD", "Expire Password Date", "", $L);         
        fnCrtObjNum($this->FormObj, $cm, 1, 0, "FF", "0", "TUEXPV", "Expire Password Value", "", $L, 75, 0, "", "Day", 1, 1, 9999);
        
        fnCrtObjTxt($this->FormObj, $cm, 1, 1, "FF", "0", "TUEMID", "Employee ID", "", $L, 200);        
        fnCrtObjTxt($this->FormObj, $cm, 1, 0, "FF", "0", "TUDEPT", "Department", "", $L, 300);        
        fnCrtObjTxt($this->FormObj, $cm, 1, 0, "FF", "0", "TUMAIL", "Email", "", $L, 300);    
        fnCrtObjRmk($this->FormObj, $cm, 1, 0, "FF", "0", "TUWELC", "Welcome Text", "", $L, 400);    
        fnCrtObjRmk($this->FormObj, $cm, 1, 0, "FF", "0", "TUUSRM", "User Remark", "User Remark", $L, 400);
        fnCrtObjRmk($this->FormObj, $cm, 1, 0, "FF", "0", "TUREMK", "Remark", "", $L, 400);
        // fnCrtObjGrd($this->FormObj, 1, 0, "XX", "0", "TBLUAM", "Detail Access"
        //                     , "AEL", "TBLUSR", "LoadTBLUAM");
        fnCrtObjDefault($this->FormObj, $cm, "TU");    
        
        $HasilObj = "";
        foreach ($this->FormObj as $Obj) {
            $HasilObj .= json_encode($Obj).",";
        }

        $Panel = "{xtype: 'panel', reference: 'refPanel1', name: 'Panel1', collapsible: false, collapsed: false, 
                   hidden: false, border: false, scrollable: false,  },
                  {xtype: 'panel', reference: 'refPanel2', name: 'Panel2', collapsible: false, collapsed: false, 
                   hidden: false, border: true, scrollable: false,  }";

        $Panel = "{xtype: 'panel', reference: 'refPanelA', name: 'PanelA', items: [".$Panel."], layout: 'hbox'}";

        $this->LoadGrid($request);

        $Hasil  = "";        
        $Hasil .= " 
                var f1 = this.lookupReference('refFrame1'); 
                    f1.add([".fnCrtObjGrd($cm, "refGridForm", "cTBLUSR", "loadgrid", $this->GridColumns)."]);
        ";


        $this->LoadTBLUAM($request);

        if ($cm=="modern") {
            $Hasil .= " 
                    var f2 = this.lookupReference('refFrame2'); 
                        f2.add([".$HasilObj."]);
                        f2.add([".fnCrtObjGrd($cm, "refGridDetail", "cTBLUSR", "LoadTBLUAM", $this->GridColumns, 'ALL')."]);
            ";
        } else {
            $Hasil .= " 
                    var f2 = this.lookupReference('refFrame2'); 
                        f2.add([".$Panel."]);

                    var p1 = this.lookupReference('refPanel1');
                        p1.add([".$HasilObj."]);

                    var p2 = this.lookupReference('refPanel2');
                        p2.add([".fnCrtObjGrd($cm, "refGridDetail", "cTBLUSR", "LoadTBLUAM", $this->GridColumns, 'ALL')."]);
                        this.lookupReference('refGridDetailPagingToolBar').hide();                        

            ";            
        }
        // dd($Hasil);
        // $a = json_decode(json_encode($this->LoadTBLUAM($request)))->original;
        // $a = (json_encode($this->LoadTBLUAM($request)));
        // dd($a);
        // dd($a->Column);

        $Hasil = fnEnCrypt($Hasil);           
        return response()->jSon($Hasil);   
    }


    public function Action(Request $request) {

        $Hasil = "";
        switch(strtoupper($request->mode)) {
            case strtoupper("A"): // Add Mode
                // $Hasil = "
                //     Ext.Msg.alert('Access Denied', 'No permission for this action!!!', Ext.emptyFn);
                //     this.onAction('');
                // ";
                $Hasil = "";
                $Hasil = "
                    var s =  this.lookupReference('refGridDetail');                    
                        s.getStore().clearFilter(true);
                        s.getStore().load();
                ";
                break;
            case strtoupper("L"): // View Mode
            case strtoupper("E"): // Edit Mode
                $Hasil  = "";
                $Hasil .= $this->FillForm($request);
                $Hasil .= "

                    var ObjTUUSERIY = this.lookupReference('TUUSERIY');
                    var TUUSERIY = this.getObjValue(ObjTUUSERIY);
                    // console.log('Edit Edit Edit 3333', TUUSERIY);
                    var s =  this.lookupReference('refGridDetail');
                        s.getStore().clearFilter(true);
                        s.getStore().load({
                            params: {
                                filter: Ext.encode([{operator:'=',value:TUUSERIY,property:'TUUSERIY'}])
                            } 
                        })


                ";
                // dd($Hasil);
                break;
            case strtoupper("1"):
            case strtoupper("2"):
            case strtoupper("3"):

                $Hasil = $this->doExecuteQuery( $request->user(), "cTBLUSR@Save");  
                if ($Hasil['success']) {


                    switch(strtoupper($request->mode)) {
                        case strtoupper("1"):
                            $Hasil = "
                                this.showToast('insert completed');
                                // Ext.Msg.alert('Success', 'Hore Sukses!!!', Ext.emptyFn);
                                this.onAction('Cancel');
                                this.onAction('A');
                                this.refreshGrid();
                                ";
                            break;
                        case strtoupper("2"):
                            $Hasil = "
                                this.showToast('update completed');
                                // Ext.Msg.alert('Success', 'Hore Edit!!!', Ext.emptyFn);
                                this.onAction('Cancel');
                                this.refreshGrid();
                            ";
                            break;
                        case strtoupper("3"):
                            $Hasil = "
                                this.showToast('delete completed');
                                // Ext.Msg.alert('Success', 'Hore Delete!!!', Ext.emptyFn);
                                this.refreshGrid();
                            ";
                            break;                
                    }

                } else {
                    $Hasil = "
                        Ext.Msg.alert('Error', '".str_replace("'",
                            "\'",$Hasil['message'])."', Ext.emptyFn);
                    ";
                }


                break;
            default:
                $Hasil = "
                    // Ext.Msg.alert('Access Denied', 'No permission for this action!!!', Ext.emptyFn);
                    // this.onAction('');
                ";
                break;
        }

        $Hasil = fnEnCrypt($Hasil);           
        return response()->jSon($Hasil);  

    }


    public function FillForm(Request $request) {
        // dd( $request->grid);
        if ($request->grid=="") {
            $Hasil = "
                Ext.Msg.alert('Error', 'Data belum di pilih atau Data tidak ada!!!', Ext.emptyFn);
                this.onAction('');
            ";
            return $Hasil;
        }
        $this->Setup($request);
        $FillFormObject = $this->getFormObject($this->FormObj);
        // dd($FillFormObject);
        $TBLUSR = TBLUSR::select( $FillFormObject )
                        ->where([
                            ['TUUSERIY', '=', $request->grid->TUUSERIY],
                            // ['TUUSERIY', '=', '1'],
                          ])->get();
        // dd($TBLUSR[0]);

        $Hasil = "";
        // if (strtoupper($request->mode)=="E") {
        //     $Hasil = "
        //         Ext.Msg.alert('Error', 'Sudah Approved tidak bisa di edit!!!', Ext.emptyFn);
        //         this.onAction('');
        //     ";
        //     return $Hasil;
        // }

        $Hasil .= $this->setFillForm(true, $TBLUSR, "");
        $Hasil .= "this.setObjValue(this.getObj('TUPSWD'),'***********');\n";
        return $Hasil;
        // return response()->jSon($Hasil);        
    }   


    // public function SaveData (Request $request) {

    //     $Hasil = $this->doExecuteQuery( $request->AppUserName, "cTBLUSR@StpTBLUSR");  
    //     // $Hasil->message = ""; 
    //     // $Hasil = array("success"=> $BerHasil, "message"=> " Sukses... ".$message.$b);
    //     return response()->jSon($Hasil);

    // }

    public function Save(Request $request) {

        $fTBLUSR = json_encode($request->form);
        $fTBLUSR = json_decode($fTBLUSR, true);

        $Delimiter = "";
        $UnikNo = fnGenUnikNo($Delimiter);

        $HasilCheckBFCS = fnCheckBFCS (
                            array("Table"=>"TBLUSR", 
                                  "Key"=>"TUUSERIY", 
                                  "Data"=>$fTBLUSR, 
                                  "Mode"=>$request->mode,
                                  "Menu"=>"", 
                                  "FieldTransDate"=>""));
        if (!$HasilCheckBFCS["success"]) {
            return response()->jSon($HasilCheckBFCS);
        }

        $UserName = $request->user()->TUUSER;
        // dd($fTBLUSR);

        switch ($request->mode) {
            case "1":
                $fTBLUSR['TUCOMPIY'] = $request->user()->TUCOMPIY;
                $fTBLUSR['TUUSERIY'] = fnSYSNOR('TBLUSR', $UserName);
                $FinalField = fnGetSintaxCRUD ($UserName, $fTBLUSR, 
                    '1', "TU", 
                    ['TUCOMPIY','TUUSERIY','TUUSER','TUNAME','TUPSWD','TUEMID','TUDEPT','TUMAIL','TUWELC',
                     'TUEXPP','TUEXPD','TUEXPV','TUDPFG','TUUSRM','TUREMK'], 
                    $UnikNo );
                DB::table('TBLUSR')->insert($FinalField);

                break;
            case "2":
                $FinalField = fnGetSintaxCRUD ($UserName, $fTBLUSR, 
                    '2', "TU", 
                    ['TUNAME','TUPSWD','TUEMID','TUDEPT','TUMAIL','TUWELC',
                     'TUEXPP','TUEXPD','TUEXPV','TUDPFG','TUUSRM','TUREMK'], 
                    $UnikNo );
                DB::table('TBLUSR')
                    ->where('TUUSERIY','=',$fTBLUSR['TUUSERIY'])
                    ->update($FinalField);

                break;
            case "3":
                DB::table('TBLUAM')
                    ->where('TAUSERIY','=',$fTBLUSR['TUUSERIY'])      
                    ->delete();
                DB::table('TBLUSR')
                    ->where('TUUSERIY','=',$fTBLUSR['TUUSERIY'])      
                    ->delete();
                break;
        }


        // // Begin Insert Detail Hak Akses
        // switch ($request->mode) {
        //     case "1":
        //     case "2":

        //         $DataDetail = $fTBLUSR['TBLUAM']; 
        //         foreach($DataDetail as $key => $value) {
        //             $fTBLUAM = $DataDetail[$key];
        //             $TBL = DB::table('TBLUAM')
        //                 ->select('TANOMRIY')
        //                 ->where([
        //                         ['TAMENUIY','=',$fTBLUAM['TAMENUIY']],
        //                         ['TAUSERIY','=',$fTBLUSR['TUUSERIY']]
        //                         ])
        //                 ->first();
        //             if (is_null($TBL)) { 
        //                 $fTBLUAM['TAUSERIY'] = $fTBLUSR['TUUSERIY'];
        //                 $FinalField = fnGetSintaxCRUD ($UserName, $fTBLUAM, 
        //                     '1', "TA", 
        //                     ['TAMENUIY','TAUSERIY','TAACES'], 
        //                     $UnikNo );
        //                 DB::table('TBLUAM')->insert($FinalField);
        //             } else {
        //                 $fTBLUAM['TANOMRIY'] = $TBL->TANOMRIY;
        //                 $FinalField = fnGetSintaxCRUD ($UserName, $fTBLUAM, 
        //                     '2', "TA", 
        //                     ['TAACES'], 
        //                     $UnikNo );
        //                 DB::table('TBLUAM')
        //                     ->where('TANOMRIY','=',$fTBLUAM['TANOMRIY'])
        //                     ->update($FinalField);
        //             } 
        //         } 

        //         break;
        // }
        // // END Insert Detail Hak Akses

    }


    // private $FormObjDetail = [];

    // public function FormObjectDetail(Request $request) {

    //     // fnCrtObjTxt($this->FormObjDetail, 0, "FF", "3", "Panel11", "TANOMRIY", "Line IY", "", false);
    //     fnCrtObjTxt($this->FormObjDetail, 0, "FF", "3", "Panel11", "TAMENUIY", "Menu IY", "", false);
    //     fnCrtObjPop($this->FormObjDetail, 1, "FF", "2", "Panel12", "TAUSERIY", "TUUSER", "TUUSER", "User", "", false, "TBLUSR", true, 1);
    //     // fnCrtObjTxt($this->FormObjDetail, 0, "FF", "3", "Panel13", "SMNOMR", "Nomor", "", false);
    //     fnCrtObjTxt($this->FormObjDetail, 1, "FF", "3", "Panel13", "SMMENU", "Menu", "", false);
    //     fnCrtObjTxt($this->FormObjDetail, 1, "FF", "3", "Panel13", "SMSCUT", "Short Cut", "", false);
    //     // fnCrtObjTxt($this->FormObjDetail, 0, "FF", "3", "Panel13", "SMACES", "Access Original", "", false);
    //     // fnCrtObjTxt($this->FormObjDetail, 1, "FF", "0", "Panel13", "TAACES", "Access", "", false);
    //     fnCrtObjRad($this->FormObjDetail, 1, "FF", "0", "Panel13", "TAACES", "Access", "", "1", "toggle", "MODE", false);
    //     // fnCrtObjRmk($this->FormObjDetail, 1, "FF", "0", "Panel13", "SLREMK", "Remark", "", false, 100);
    //         // fnUpdObj($this->FormObj, "SHREMK", array("Helper"=>'Terserah anda mau isi apa?'));


    //     return response()->jSon($this->FormObjDetail);   
    // }

    // public function LoadTBLUAM(Request $request) {

    //     // fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'TANOMRIY', 'User Access IY', 100);
    //     fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'TAMENUIY', 'Menu IY', 100);
    //     // fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'TAUSERIY', 'User IY', 100);
    //     fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'SMNOMR', 'Nomor', 100);
    //     fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'SMMENU', 'Menu', 100);
    //     fnCrtColGrid($this->GridObj, "txt", 1, 0, '', 'SMSCUT', 'Short Cut', 100);
    //     fnCrtColGrid($this->GridObj, "hdn", 0, 0, '', 'SMACES', 'TipeAccess', 100);
    //     fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'TAACES', 'Access', 100);
    //     fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
    //     // fnCrtColGridDefault($this->GridObj, "TU");

    //     $this->GridFilter = [];
    //     $this->GridSort = [];
    //     $this->GridSort[] = array('name'=>'SMNOMR','direction'=>'asc');
    //     $this->GridColumns = [];

    //     $TBLUSR = TBLUSR::noLock()
    //             ->leftJoin('TBLUAM','TAUSERIY','TUUSERIY')
    //             ->leftJoin('SYSMNU','SMMENUIY','TAMENUIY')
    //             ->where([
    //                 ['TUDLFG', '=', '0'],
    //                 ['TUUSERIY', '=', $request->TUUSERIY],
    //               ]);

    //     $TBLUSR = fnQuerySearchAndPaginate($request, $TBLUSR, 
    //                                        $this->GridObj, 
    //                                        $this->GridSort, 
    //                                        $this->GridFilter, 
    //                                        $this->GridColumns);

    //     $Hasil = array( "Data"=> $TBLUSR,
    //                     "Column"=> $this->GridColumns,
    //                     "Sort"=> $this->GridSort,
    //                     "Filter"=> $this->GridFilter,
    //                     "Key"=> 'TANOMRIY');
    //     // dd($Hasil);
    //     return response()->jSon($Hasil);     

    // }



    public function LoadTBLUAM(Request $request) {
        $this->GridObj = [];
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'TAMENUIY', 'Menu IY', 100);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'SMNOMR', 'Nomor', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'SMMENU', 'Menu', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'SMSCUT', 'Short Cut', 100);
        fnCrtColGrid($this->GridObj, "hdn", 0, 0, '', 'SMACES', 'TipeAccess', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'TAACES', 'Access', 100);
        fnCrtColGrid($this->GridObj, "hdn", 0, 0, '', 'TAUSERIY', 'User IY', 100);

        $TAUSERIY = 0;
        if ($request->filter!=null){
            $f = json_decode($request->filter);
            $TAUSERIY = $f[0]->value;            
        }

        if ($TAUSERIY == 0 ) {
            $request->filter = null;
            $f = [];
        }

        $COMPIY = $request->user()->TUCOMPIY;

        $this->GridFilter = $f;        
        $this->GridSort = [];
        $this->GridSort[] = array('property'=>'SMNOMR','direction'=>'asc');
        $this->GridColumns = [];

        // $TBLUSR = TBLUSR::leftJoin('TBLUAM','TAUSERIY','TUUSERIY')
        //                 ->leftJoin('SYSMNU','SMMENUIY','TAMENUIY')
        //                 ->where([
        //                     ['TUDLFG', '=', '0'],
        //                     // ['TUUSERIY', '=', $request->user()->TUUSERIY],
        //                     ['TUUSERIY', '=', $TAUSERIY],
        //                   ]);

// select('TAMENUIY','SMNOMR','SMMENU','SMSCUT','SMACES', DB::raw(" 'xxxx' as TAACES"),'TAUSERIY') //,  'TAACES'
        $TBLUSR = SYSMNU::leftJoin('TBLUSR',function($join) use($TAUSERIY, $COMPIY) {                                                
        // $TBLUSR = DB::table('SYSMNU')
        //                 ->select('TAMENUIY','SMNOMR','SMMENU','SMSCUT','SMACES', DB::raw(" 'xxxx' as TAACES"), 'TAUSERIY')
                        // ->leftJoin('TBLUSR',function($join) use($TAUSERIY, $COMPIY) {                                                
                            // $join->on(DB::raw("'1'"), '=', DB::raw("'1'"));
                            $join->on('TUCOMPIY', '=', DB::raw("'".$COMPIY."'"));
                            if ($TAUSERIY===0) {
                                $join->on('TUUSER', '=', DB::raw("'Admin'"));
                            } else {
                                $join->on('TUUSERIY', '=', DB::raw("'".$TAUSERIY."'"));
                            }
                          })
                        ->leftJoin('TBLUAM',function($join) use($TAUSERIY) {                                                
                            $join->on('TAMENUIY', '=', 'SMMENUIY');
                            $join->on('TAUSERIY', '=', 'TUUSERIY');
                          })
                        ->where([
                            ['TUCOMPIY', '=', $COMPIY],
                          ]); //->toSql()


        $TBLUSR = fnQuerySearchAndPaginate($request, $TBLUSR, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);


        $Data = json_decode(json_encode($TBLUSR));

        $Hasil = [];
        foreach ($Data as $key => $row) {
            // array_push($Hasil, array($key => $row));
            if ($key=="data") {

                $arrData = $row;
                if ($TAUSERIY == 0 ) { // ini pada saat ADD, jadi TAACES = ''
                    $arrData=[];
                    foreach ($row as $field => $record) {
                        $record->TAACES = "";
                        $arrData = array_merge($arrData,  [$record]);
                    }
                }

                $Hasil["items"] = $arrData;

            } else {
                $Hasil[$key] = $row;
            }
        }
        
        $Hasil["Column"] = $this->GridColumns;
        return response()->jSon($Hasil);     

        // $Hasil = array( "Data"=> $TBLUSR,
        //                 "Column"=> $this->GridColumns,
        //                 "Sort"=> $this->GridSort,
        //                 "Filter"=> $this->GridFilter,
        //                 "Key"=> 'TUUSERIY');        
        // dd($Hasil);
        // return response()->jSon($Hasil);     

    }

}
