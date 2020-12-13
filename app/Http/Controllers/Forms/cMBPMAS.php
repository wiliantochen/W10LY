<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\MBPMAS;
use DB;

class cMBPMAS extends cSOController {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'BPBPNOIY', 'IY', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BPBPNO', 'Kode', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BPNAME', 'Nama', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BPMAIL', 'eMail', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BPCPER', 'Kontak Personal', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BPSUPF', 'Pemasuk', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BPCUSF', 'Pelanggan', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BPREMK', 'Keterangan', 100);
        fnCrtColGridDefault($this->GridObj, "BP");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'BPBPNO','direction'=>'asc');
        $this->GridColumns = [];

        $MBPMAS = MBPMAS::noLock()
                ->where([
                    ['BPCOMPIY', '=', fnGetCompIY($request->AppCompanyCode)],
                    ['BPDLFG', '=', '0'],
                  ]);

        $MBPMAS = fnQuerySearchAndPaginate($request, $MBPMAS, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $MBPMAS,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'BPBPNOIY');
        // dd($Hasil);
        return response()->jSon($Hasil);     

    }


    private $FormObj = [];

    public function FormObject(Request $request) {

        fnCrtObjTxt($this->FormObj, 0, "FF", "3", "Panel1", "BPBPNOIY", "IY", "", false);
        fnCrtObjTxt($this->FormObj, 1, "FF", "2", "Panel1", "BPBPNO", "Kode", "", true, 0, 20, "Big");
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "BPNAME", "Nama", "", true, 0, 100);
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "BPMAIL", "eMail", "", false, 0, 100);
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "BPCPER", "KOntak Personal", "", false, 0, 100);
        fnCrtObjTog($this->FormObj, 1, "FF", "0", "Panel1", "BPSUPF", "Pemasuk", "", "0");
        fnCrtObjTog($this->FormObj, 1, "FF", "0", "Panel1", "BPCUSF", "Pelanggan", "", "0");
        fnCrtObjRad($this->FormObj, 1, "FF", "0", "Panel1", "BPDPFG", "Status", "", "1", "Radio", "DSPLY");
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "BPREMK", "Keterangan", "", false, 100);

        fnCrtObjDefault($this->FormObj,"BP");    

        return response()->jSon($this->FormObj);   
    }


    public function FillForm(Request $request) {
        $this->FormObject($request);
        $FillFormObject = $this->getFormObject($this->FormObj);

        $MBPMAS = MBPMAS::noLock()
                ->select( $FillFormObject )
                ->where([
                    ['BPBPNOIY', '=', $request->BPBPNOIY],
                    // ['BPBPNOIY', '=', '1'],
                  ])->get();

        $Hasil = $this->setFillForm(true, $MBPMAS, "");
        return response()->jSon($Hasil);        

    }   


    public function SaveData (Request $request) {

        $Hasil = $this->doExecuteQuery( $request->AppUserName, "cMBPMAS@StpMBPMAS");  
        // $Hasil->message = ""; 
        // $Hasil = array("success"=> $BerHasil, "message"=> " Sukses... ".$message.$b);
        return response()->jSon($Hasil);

    }

    public function StpMBPMAS(Request $request) {


        $fMBPMAS = json_encode($request->frmMBPMAS);
        $fMBPMAS = json_decode($fMBPMAS, true);

        $Delimiter = "";
        $UnikNo = fnGenUnikNo($Delimiter);

        $HasilCheckBFCS = fnCheckBFCS (
                            array("Table"=>"MBPMAS", 
                                  "Key"=>"BPBPNOIY", 
                                  "Data"=>$fMBPMAS, 
                                  "Mode"=>$request->Mode,
                                  "Menu"=>"", 
                                  "FieldTransDate"=>""));
        if (!$HasilCheckBFCS["success"]) {
            return response()->jSon($HasilCheckBFCS);
        }

        $UserName = $request->AppUserName;
        $fMBPMAS['BPCOMPIY'] = fnGetCompIY($request->AppCompanyCode);

        switch ($request->Mode) {
            case "1":
                $fMBPMAS['BPBPNOIY'] = fnSYSNOR('MBPMAS', $UserName);
                $FinalField = fnGetSintaxCRUD ($UserName, $fMBPMAS, 
                    '1', "BP", 
                    ['BPCOMPIY','BPBPNOIY','BPBPNO','BPNAME','BPMAIL','BPCPER','BPSUPF','BPCUSF','BPDPFG','BPREMK'], 
                    $UnikNo );
                DB::table('MBPMAS')->insert($FinalField);

                break;
            case "2":
                $FinalField = fnGetSintaxCRUD ($UserName, $fMBPMAS, 
                    '2', "BP", 
                    ['BPNAME','BPMAIL','BPCPER','BPSUPF','BPCUSF','BPDPFG','BPREMK'], 
                    $UnikNo );
                DB::table('MBPMAS')
                    ->where('BPBPNOIY','=',$fMBPMAS['BPBPNOIY'])
                    ->update($FinalField);

                break;
            case "3":
                DB::table('MBPMAS')
                    ->where('BPBPNOIY','=',$fMBPMAS['BPBPNOIY'])      
                    ->delete();
                break;
        }


    }



    public function SaveDataXXX(Request $request) {


        $fMBPMAS = json_encode($request->frmMBPMAS);
        $fMBPMAS = json_decode($fMBPMAS, true);

        $Delimiter = "";
        $UnikNo = fnGenUnikNo($Delimiter);

        $HasilCheckBFCS = fnCheckBFCS (
                            array("Table"=>"MBPMAS", 
                                  "Key"=>"BPBPNOIY", 
                                  "Data"=>$fMBPMAS, 
                                  "Mode"=>$request->Mode,
                                  "Menu"=>"", 
                                  "FieldTransDate"=>""));
        if (!$HasilCheckBFCS["success"]) {
            return response()->jSon($HasilCheckBFCS);
        }

        $SqlStm = [];
        switch ($request->Mode) {
            case "1":
                array_push($SqlStm, array(
                                        "UnikNo"=>$UnikNo,
                                        "Mode"=>"I",
                                        "Data"=>$fMBPMAS,
                                        "Table"=>"MBPMAS",
                                        "Field"=>['BPBPNOIY','BPBPNO','BPNAME','BPMAIL','BPDPFG','BPREMK'],
                                        "Where"=>[],
                                        "Iy"=>"BPBPNOIY"
                                    ));
                break;
            case "2":
                array_push($SqlStm, array(
                                        "UnikNo"=>$UnikNo,
                                        "Mode"=>"U",
                                        "Data"=>$fMBPMAS,
                                        "Table"=>"MBPMAS",
                                        "Field"=>['BPNAME','BPMAIL','BPDPFG','BPREMK'],
                                        "Where"=>['BPBPNOIY','=',$fMBPMAS['BPBPNOIY']],
                                    ));
                break;
            case "3":
                array_push($SqlStm, array(
                                        "UnikNo"=>$UnikNo,
                                        "Mode"=>"D",
                                        "Data"=>$fMBPMAS,
                                        "Table"=>"MBPMAS",
                                        "Field"=>['BPBPNOIY'],
                                        "Where"=>['BPBPNOIY','=',$fMBPMAS['BPBPNOIY']],
                                    ));
                break;
        }


        // $Hasil = fnSetExecuteQuery($SqlStm,$Delimiter);    
        $Hasil = $this->doExecuteQuery( $request->AppUserName, $SqlStm, $Delimiter);  
        // $Hasil->message = ""; 
        // $Hasil = array("success"=> $BerHasil, "message"=> " Sukses... ".$message.$b);
        return response()->jSon($Hasil);

    }


}
