<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller; //as cWeController
use Illuminate\Http\Request;
use App\Models\SYSMNU;
use DB;

class cSYSMNU extends Controller {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {
        $this->GridObj = [];
        // fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        fnCrtColGrid($this->GridObj, "rno", 1, 1, '', 'No', '', 50);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'SMMENUIY', 'Menu IY', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'SMNOMR', 'No Urut', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'SMMENU', 'Menu Description', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'SMSCUT', 'Short Cut', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 1, '', 'SMACES', 'Menu Access', 100);
        fnCrtColGrid($this->GridObj, "num", 0, 0, '', 'SMBCDT', 'Back Dt', 100);
        fnCrtColGrid($this->GridObj, "num", 0, 0, '', 'SMFWDT', 'Forward Dt', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 1, '', 'SMURLW', 'Form', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 1, '', 'SMGRUP', 'Group', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'SMUSRM', 'User Remark', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'SMREMK', 'Remark', 100);
        fnCrtColGridDefault($this->GridObj, "SM");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('property'=>'SMNOMR','direction'=>'asc');
        $this->GridColumns = [];

        $SYSMNU = SYSMNU::where([
                            ['SMDLFG', '=', '0'],
                          ]);

        $SYSMNU = fnQuerySearchAndPaginate($request, $SYSMNU, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Data = json_decode(json_encode($SYSMNU));

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

        // $Hasil = array( "Data"=> $SYSMNU,
        //                 "Column"=> $this->GridColumns,
        //                 "Sort"=> $this->GridSort,
        //                 "Filter"=> $this->GridFilter,
        //                 "Key"=> 'SMMENUIY');
        // // dd($Hasil);
        // return response()->jSon($Hasil);     

    }


    private $FormObj = [];

    public function Setup(Request $request) {
        $L = 125;
        $cm = $request->cm;
        fnCrtObjNum($this->FormObj, $cm, 0, 0, "FF", "3", "SMMENUIY", "ID", "", $L, 200, 0);      
        fnCrtObjTxt($this->FormObj, $cm, 1, 1, "FF", "0", "SMNOMR", "No Urut", "", $L, 200, 0, 20, "Big");   
        fnCrtObjTxt($this->FormObj, $cm, 1, 1, "FF", "0", "SMMENU", "Menu Description", "", $L, 200);          
        fnCrtObjTxt($this->FormObj, $cm, 1, 0, "FF", "0", "SMSCUT", "Short Cut", "", $L, 200);    
        
        fnCrtObjChk($this->FormObj, $cm, 1, 1, "FF", "0", "SMACES", "Menu Access", "", $L, "150,150", "1", "MODE");      
        fnCrtObjRad($this->FormObj, $cm, 1, 1, "FF", "0", "SMDPFG", "Status", "", $L, "100", "1", "DSPLY");      

        fnCrtObjTxt($this->FormObj, $cm, 1, 1, "FF", "0", "SMSYFG", "System Flag", "", $L, 200);  
        fnCrtObjNum($this->FormObj, $cm, 1, 0, "FF", "0", "SMBCDT", "Back Date", "", $L, 50, 2, "","Day", 1, 1, 9999);
        fnCrtObjNum($this->FormObj, $cm, 1, 0, "FF", "0", "SMFWDT", "Forward Date", "", $L, 50, 2, "","Day", 1, 1, 9999);
        fnCrtObjTxt($this->FormObj, $cm, 1, 0, "FF", "0", "SMURLW", "URL", "", $L, 200);        
        fnCrtObjTxt($this->FormObj, $cm, 1, 0, "FF", "0", "SMGRUP", "File Group", "", $L, 200);        
        fnCrtObjRmk($this->FormObj, $cm, 1, 0, "FF", "0", "SMUSRM", "User Remark", "User Remark", $L, 200);
        fnCrtObjRmk($this->FormObj, $cm, 1, 0, "FF", "0", "SMREMK", "Remark", "Everything You Want", $L, 200);
            // fnUpdObj($this->FormObj, "SMREMK", array("Helper"=>'Terserah anda mau isi apa?'));

        // fnCrtObjDefault($this->FormObj, $cm, "SM");    
        // dd($this->FormObj);

        // return response()->jSon($this->FormObj);   


        $HasilObj = "";
        foreach ($this->FormObj as $Obj) {
            $HasilObj .= json_encode($Obj).",";
        }

        $this->LoadGrid($request);

        $Hasil  = "";        
        $Hasil .= " 
                var f1 = this.lookupReference('refFrame1'); 
                    f1.add([".fnCrtObjGrd($cm, "refGridForm", "cSYSMNU","loadgrid", $this->GridColumns)."]);
        ";
        $Hasil .= " 
                var f2 = this.lookupReference('refFrame2'); 
                    f2.add([".$HasilObj."]);
        ";
        // $Hasil = "console.log('xxxx')";
        // dd($Hasil);
        $Hasil = fnEnCrypt($Hasil);           
        return response()->jSon($Hasil);   

    }


    public function Action(Request $request) {

        $Hasil = "";
        switch(strtoupper($request->mode)) {
            case strtoupper("A"): // Add Mode
                $Hasil = "";
                break;
            case strtoupper("L"): // View Mode
            case strtoupper("E"): // Edit Mode
                $Hasil  = $this->FillForm($request);
                // dd($Hasil);
                break;
                break;
            case strtoupper("D"):
                $Hasil = "
                    Ext.Msg.alert('Access Denied', 'No permission for this action!!!', Ext.emptyFn);
                    this.onAction('');
                ";
                break;
        }

        $Hasil = fnEnCrypt($Hasil);           
        return response()->jSon($Hasil);  

    }


    public function FillForm(Request $request) {
        $this->Setup($request);
        $FillFormObject = $this->getFormObject($this->FormObj);
        // dd($FillFormObject);
        $SYSMNU = SYSMNU::select( $FillFormObject )
                        ->where([
                            ['SMMENUIY', '=', $request->grid->SMMENUIY],
                            // ['SMMENUIY', '=', '1'],
                          ])->get();
                // dd($SYSMNU);

        $Hasil = $this->setFillForm(true, $SYSMNU, "");
        // dd($Hasil);
        return $Hasil;
        // return response()->jSon($Hasil);        

    }   

    // public function SaveData (Request $request) {

    //     $Hasil = $this->doExecuteQuery( $request->AppUserName, "cSYSMNU@StpSYSMNU");  
    //     // $Hasil->message = ""; 
    //     // $Hasil = array("success"=> $BerHasil, "message"=> " Sukses... ".$message.$b);
    //     return response()->jSon($Hasil);

    // }

    // public function StpSYSMNU(Request $request) {


    //     $fSYSMNU = json_encode($request->frmSYSMNU);
    //     $fSYSMNU = json_decode($fSYSMNU, true);

    //     $Delimiter = "";
    //     $UnikNo = fnGenUnikNo($Delimiter);

    //     $HasilCheckBFCS = fnCheckBFCS (
    //                         array("Table"=>"SYSMNU", 
    //                               "Key"=>"SMMENUIY", 
    //                               "Data"=>$fSYSMNU, 
    //                               "Mode"=>$request->Mode,
    //                               "Menu"=>"", 
    //                               "FieldTransDate"=>""));
    //     if (!$HasilCheckBFCS["success"]) {
    //         return response()->jSon($HasilCheckBFCS);
    //     }


    //     $UserName = $request->AppUserName;

    //     switch ($request->Mode) {
    //         case "1":
    //             $fSYSMNU['SMMENUIY'] = fnTBLNOR('SYSMNU', $UserName);
    //             $FinalField = fnGetSintaxCRUD ($UserName, $fSYSMNU, 
    //                 '1', "SM", 
    //                 ['SMMENUIY','SMNOMR','SMSCUT','SMMENU','SMACES','SMDPFG','SMSYFG',
    //                  'SMBCDT','SMFWDT','SMURLW','SMGRUP','SMUSRM','SMREMK'], 
    //                 $UnikNo );
    //             DB::table('SYSMNU')->insert($FinalField);
    //             break;
    //         case "2":
    //             $FinalField = fnGetSintaxCRUD ($UserName, $fSYSMNU, 
    //                 '2', "SM", 
    //                 ['SMNOMR','SMSCUT','SMMENU','SMACES','SMDPFG','SMSYFG','SMBCDT','SMFWDT',
    //                  'SMURLW','SMGRUP','SMUSRM','SMREMK'], 
    //                 $UnikNo );
    //             DB::table('SYSMNU')
    //                 ->where('SMMENUIY','=',$fSYSMNU['SMMENUIY'])
    //                 ->update($FinalField);
    //             break;
    //         case "3":
    //             DB::table('SYSMNU')
    //                 ->where('SMMENUIY','=',$fSYSMNU['SMMENUIY'])      
    //                 ->delete();
    //             break;
    //     }


    // }

}
