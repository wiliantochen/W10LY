<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\SYSMNU;
use DB;

class cSYSMNU extends cSOController {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
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
        $this->GridSort[] = array('name'=>'SMNOMR','direction'=>'asc');
        $this->GridColumns = [];

        $SYSMNU = SYSMNU::noLock()
                ->where([
                    ['SMDLFG', '=', '0'],
                  ]);

        $SYSMNU = fnQuerySearchAndPaginate($request, $SYSMNU, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $SYSMNU,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'SMMENUIY');
        // dd($Hasil);
        return response()->jSon($Hasil);     

    }


    private $FormObj = [];

    public function FormObject(Request $request) {

        fnCrtObjNum($this->FormObj, 0, "FF", "3", "Panel1", "SMMENUIY", "ID", "", false, 0);      
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "PanelA", "SMNOMR", "Code Menu", "", true, 0, 20, "Big");     
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "PanelA", "SMSCUT", "Short Cut", "", false);    
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "PanelB", "SMMENU", "Description", "", true);        
        fnCrtObjRad($this->FormObj, 1, "FF", "0", "Panel1", "SMACES", "Menu Access", "", "1", "toggle", "MODE", false);
        fnCrtObjRad($this->FormObj, 1, "FF", "0", "Panel1", "SMDPFG", "Status", "", "1", "Radio", "DSPLY");      
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel2", "SMSYFG", "System Flag", "", true);  
        fnCrtObjNum($this->FormObj, 1, "FF", "0", "Panel2", "SMBCDT", "Back Date", "", false, 2, "","Day", 1, 1, 9999);
        fnCrtObjNum($this->FormObj, 1, "FF", "0", "Panel2", "SMFWDT", "Forward Date", "", false, 2, "","Day", 1, 1, 9999);
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel3", "SMURLW", "URL", "", false);        
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel3", "SMGRUP", "File Group", "", false);        
            fnUpdObj($this->FormObj, "SMGRUP", array("Helper"=>'Jika File Group diisi, Maka Menu tersebut akan refer ke file yang sama'));
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel4", "SMUSRM", "User Remark", "User Remark", false, 100);
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel4", "SMREMK", "Remark", "Everything You Want", false, 100);
            fnUpdObj($this->FormObj, "SMREMK", array("Helper"=>'Terserah anda mau isi apa?'));

        fnCrtObjDefault($this->FormObj,"SM");    
        // dd($this->FormObj);

        return response()->jSon($this->FormObj);   
    }


    public function FillForm(Request $request) {
        $this->FormObject($request);
        $FillFormObject = $this->getFormObject($this->FormObj);
        // dd($FillFormObject);

        $SYSMNU = SYSMNU::noLock()
                ->select( $FillFormObject )
                ->where([
                    ['SMMENUIY', '=', $request->SMMENUIY],
                    // ['SMMENUIY', '=', '1'],
                  ])->get();
        // dd($SYSMNU);

        $Hasil = $this->setFillForm(true, $SYSMNU, "");
        // dd($Hasil);
        return response()->jSon($Hasil);        

    }   

    public function SaveData (Request $request) {

        $Hasil = $this->doExecuteQuery( $request->AppUserName, "cSYSMNU@StpSYSMNU");  
        // $Hasil->message = ""; 
        // $Hasil = array("success"=> $BerHasil, "message"=> " Sukses... ".$message.$b);
        return response()->jSon($Hasil);

    }

    public function StpSYSMNU(Request $request) {


        $fSYSMNU = json_encode($request->frmSYSMNU);
        $fSYSMNU = json_decode($fSYSMNU, true);

        $Delimiter = "";
        $UnikNo = fnGenUnikNo($Delimiter);

        $HasilCheckBFCS = fnCheckBFCS (
                            array("Table"=>"SYSMNU", 
                                  "Key"=>"SMMENUIY", 
                                  "Data"=>$fSYSMNU, 
                                  "Mode"=>$request->Mode,
                                  "Menu"=>"", 
                                  "FieldTransDate"=>""));
        if (!$HasilCheckBFCS["success"]) {
            return response()->jSon($HasilCheckBFCS);
        }

        $TBLUSR = $request->user();
        $UserName = $TBLUSR->TUUSER;
        // $UserName = $request->AppUserName;

        switch ($request->Mode) {
            case "1":
                $fSYSMNU['SMMENUIY'] = fnTBLNOR('SYSMNU', $UserName);
                $FinalField = fnGetSintaxCRUD ($UserName, $fSYSMNU, 
                    '1', "SM", 
                    ['SMMENUIY','SMNOMR','SMSCUT','SMMENU','SMACES','SMDPFG','SMSYFG',
                     'SMBCDT','SMFWDT','SMURLW','SMGRUP','SMUSRM','SMREMK'], 
                    $UnikNo );
                DB::table('SYSMNU')->insert($FinalField);
                break;
            case "2":
                $FinalField = fnGetSintaxCRUD ($UserName, $fSYSMNU, 
                    '2', "SM", 
                    ['SMNOMR','SMSCUT','SMMENU','SMACES','SMDPFG','SMSYFG','SMBCDT','SMFWDT',
                     'SMURLW','SMGRUP','SMUSRM','SMREMK'], 
                    $UnikNo );
                DB::table('SYSMNU')
                    ->where('SMMENUIY','=',$fSYSMNU['SMMENUIY'])
                    ->update($FinalField);
                break;
            case "3":
                DB::table('SYSMNU')
                    ->where('SMMENUIY','=',$fSYSMNU['SMMENUIY'])      
                    ->delete();
                break;
        }


    }

}
