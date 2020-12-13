<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\TBLUSR;
use DB;

class cTBLUSR extends cSOController {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
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
        $this->GridSort[] = array('name'=>'TUUSER','direction'=>'asc');
        $this->GridColumns = [];

        $TBLUSR = TBLUSR::noLock()
                ->where([
                    ['TUCOMPIY', '=', fnGetCompIY($request->AppCompanyCode)],
                    ['TUDLFG', '=', '0'],
                  ]);

        $TBLUSR = fnQuerySearchAndPaginate($request, $TBLUSR, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $TBLUSR,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'TUUSERIY');
        // dd($Hasil);
        return response()->jSon($Hasil);     

    }


    private $FormObj = [];

    public function FormObject(Request $request) {

        fnCrtObjNum($this->FormObj, 0, "FF", "3", "Panel4", "TUUSERIY", "ID", "", false, 0);     
        fnCrtObjTxt($this->FormObj, 1, "FF", "2", "Panel1", "TUUSER", "Login Name", "", true, 0, 50);     
            // fnUpdObj($this->FormObj, "TUUSER", array("Helper"=>'Dipakai saat login'));
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "TUNAME", "Full Name", "", true);        
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "TUPSWD", "Password", "", true);    
        fnCrtObjRad($this->FormObj, 1, "FF", "0", "Panel1", "TUDPFG", "Status User", "", "1", "Radio", "DSPLY");      
        fnCrtObjRad($this->FormObj, 1, "FF", "0", "Panel1", "TUEXPP", "Expire Password", "", "1", "Radio", "YN");      
        fnCrtObjDtp($this->FormObj, 1, "FF", "0", "Panel1A", "TUEXPD", "Expire Password Date", "", true);         
        fnCrtObjNum($this->FormObj, 1, "FF", "0", "Panel1B", "TUEXPV", "Expire Password Value", "", false, 0, "","Day", 1, 1, 9999);
        
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel2", "TUEMID", "Employee ID", "", true);        
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel2", "TUDEPT", "Department", "", false);    
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel2", "TUMAIL", "Email", "", false);    
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel2", "TUWELC", "Welcome Text", "", false, 100);        
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel2", "TUUSRM", "User Remark", "User Remark", false, 200);
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel2", "TUREMK", "Remark", "", false, 300);
        fnCrtObjGrd($this->FormObj, 1, "XX", "0", "Panel5", "TBLUAM", "Detail Access", false
                            , "AEL", "TBLUSR", "LoadTBLUAM");
        fnCrtObjDefault($this->FormObj,"TU");    
        return response()->jSon($this->FormObj);   
    }


    public function FillForm(Request $request) {
        $this->FormObject($request);
        $FillFormObject = $this->getFormObject($this->FormObj);
        // dd($FillFormObject);
        $TBLUSR = TBLUSR::noLock()
                ->select( $FillFormObject )
                ->where([
                    ['TUUSERIY', '=', $request->TUUSERIY],
                    // ['TUUSERIY', '=', '1'],
                  ])->get();
        // dd($TBLUSR);
        $TBLUSR[0]['TBLUAM'] = fnFillGrid($this->LoadTBLUAM($request));
        $Hasil = $this->setFillForm(true, $TBLUSR, "");
        return response()->jSon($Hasil);        

    }   


    public function SaveData (Request $request) {

        $Hasil = $this->doExecuteQuery( $request->AppUserName, "cTBLUSR@StpTBLUSR");  
        // $Hasil->message = ""; 
        // $Hasil = array("success"=> $BerHasil, "message"=> " Sukses... ".$message.$b);
        return response()->jSon($Hasil);

    }

    public function StpTBLUSR(Request $request) {


        $fTBLUSR = json_encode($request->frmTBLUSR);
        $fTBLUSR = json_decode($fTBLUSR, true);

        $Delimiter = "";
        $UnikNo = fnGenUnikNo($Delimiter);

        $HasilCheckBFCS = fnCheckBFCS (
                            array("Table"=>"TBLUSR", 
                                  "Key"=>"TUUSERIY", 
                                  "Data"=>$fTBLUSR, 
                                  "Mode"=>$request->Mode,
                                  "Menu"=>"", 
                                  "FieldTransDate"=>""));
        if (!$HasilCheckBFCS["success"]) {
            return response()->jSon($HasilCheckBFCS);
        }

        $UserName = $request->AppUserName;


        switch ($request->Mode) {
            case "1":
                $fTBLUSR['TUUSERIY'] = fnTBLNOR('TBLUSR', $UserName);
                $FinalField = fnGetSintaxCRUD ($UserName, $fTBLUSR, 
                    '1', "TU", 
                    ['TUUSERIY','TUUSER','TUNAME','TUPSWD','TUEMID','TUDEPT','TUMAIL','TUWELC',
                     'TUEXPP','TUEXPD','TUEXPV','TUDPFG','TUUSRM','TUREMK'], 
                    $UnikNo );
                DB::table('TBLUSR')->insert($FinalField);

                break;
            case "2":
                $FinalField = fnGetSintaxCRUD ($UserName, $fTBLUSR, 
                    '2', "TU", 
                    ['TUUSERIY','TUUSER','TUNAME','TUPSWD','TUEMID','TUDEPT','TUMAIL','TUWELC',
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


        // Begin Insert Detail Hak Akses
        switch ($request->Mode) {
            case "1":
            case "2":

                $DataDetail = $fTBLUSR['TBLUAM']; 
                foreach($DataDetail as $key => $value) {
                    $fTBLUAM = $DataDetail[$key];
                    $TBL = DB::table('TBLUAM')
                        ->select('TANOMRIY')
                        ->where([
                                ['TAMENUIY','=',$fTBLUAM['TAMENUIY']],
                                ['TAUSERIY','=',$fTBLUSR['TUUSERIY']]
                                ])
                        ->first();
                    if (is_null($TBL)) { 
                        $fTBLUAM['TAUSERIY'] = $fTBLUSR['TUUSERIY'];
                        $FinalField = fnGetSintaxCRUD ($UserName, $fTBLUAM, 
                            '1', "TA", 
                            ['TAMENUIY','TAUSERIY','TAACES'], 
                            $UnikNo );
                        DB::table('TBLUAM')->insert($FinalField);
                    } else {
                        $fTBLUAM['TANOMRIY'] = $TBL->TANOMRIY;
                        $FinalField = fnGetSintaxCRUD ($UserName, $fTBLUAM, 
                            '2', "TA", 
                            ['TAACES'], 
                            $UnikNo );
                        DB::table('TBLUAM')
                            ->where('TANOMRIY','=',$fTBLUAM['TANOMRIY'])
                            ->update($FinalField);
                    } 
                } 

                break;
        }
        // END Insert Detail Hak Akses

    }


    private $FormObjDetail = [];

    public function FormObjectDetail(Request $request) {

        // fnCrtObjTxt($this->FormObjDetail, 0, "FF", "3", "Panel11", "TANOMRIY", "Line IY", "", false);
        fnCrtObjTxt($this->FormObjDetail, 0, "FF", "3", "Panel11", "TAMENUIY", "Menu IY", "", false);
        fnCrtObjPop($this->FormObjDetail, 1, "FF", "2", "Panel12", "TAUSERIY", "TUUSER", "TUUSER", "User", "", false, "TBLUSR", true, 1);
        // fnCrtObjTxt($this->FormObjDetail, 0, "FF", "3", "Panel13", "SMNOMR", "Nomor", "", false);
        fnCrtObjTxt($this->FormObjDetail, 1, "FF", "3", "Panel13", "SMMENU", "Menu", "", false);
        fnCrtObjTxt($this->FormObjDetail, 1, "FF", "3", "Panel13", "SMSCUT", "Short Cut", "", false);
        // fnCrtObjTxt($this->FormObjDetail, 0, "FF", "3", "Panel13", "SMACES", "Access Original", "", false);
        // fnCrtObjTxt($this->FormObjDetail, 1, "FF", "0", "Panel13", "TAACES", "Access", "", false);
        fnCrtObjRad($this->FormObjDetail, 1, "FF", "0", "Panel13", "TAACES", "Access", "", "1", "toggle", "MODE", false);
        // fnCrtObjRmk($this->FormObjDetail, 1, "FF", "0", "Panel13", "SLREMK", "Remark", "", false, 100);
            // fnUpdObj($this->FormObj, "SHREMK", array("Helper"=>'Terserah anda mau isi apa?'));


        return response()->jSon($this->FormObjDetail);   
    }

    public function LoadTBLUAM(Request $request) {

        // fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'TANOMRIY', 'User Access IY', 100);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'TAMENUIY', 'Menu IY', 100);
        // fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'TAUSERIY', 'User IY', 100);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'SMNOMR', 'Nomor', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'SMMENU', 'Menu', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 0, '', 'SMSCUT', 'Short Cut', 100);
        fnCrtColGrid($this->GridObj, "hdn", 0, 0, '', 'SMACES', 'TipeAccess', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'TAACES', 'Access', 100);
        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        // fnCrtColGridDefault($this->GridObj, "TU");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'SMNOMR','direction'=>'asc');
        $this->GridColumns = [];

        $TBLUSR = TBLUSR::noLock()
                ->leftJoin('TBLUAM','TAUSERIY','TUUSERIY')
                ->leftJoin('SYSMNU','SMMENUIY','TAMENUIY')
                ->where([
                    ['TUDLFG', '=', '0'],
                    ['TUUSERIY', '=', $request->TUUSERIY],
                  ]);

        $TBLUSR = fnQuerySearchAndPaginate($request, $TBLUSR, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $TBLUSR,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'TANOMRIY');
        // dd($Hasil);
        return response()->jSon($Hasil);     

    }


}
