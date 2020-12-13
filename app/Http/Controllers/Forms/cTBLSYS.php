<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\TBLSYS;
use DB;

class cTBLSYS extends cSOController {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'TSSYCDIY', 'IY', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'TDDSCD', 'Table', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'TSSYCD', 'Code', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'TSSYNM', 'Description', 100);;
        fnCrtColGrid($this->GridObj, "num", 0, 0, '', 'TSSYV1', 'Value 1', 100);
        fnCrtColGrid($this->GridObj, "num", 0, 0, '', 'TSSYV2', 'Value 2', 100);
        fnCrtColGrid($this->GridObj, "num", 0, 0, '', 'TSSYV3', 'Value 3', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'TSSYT1', 'Text 1', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'TSSYT2', 'Text 2', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'TSSYT3', 'Text 3', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'TSLSV1', 'Label Value 1', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'TSLSV2', 'Label Value 2', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'TSLSV3', 'Label Value 3', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'TSLST1', 'Label Text 1', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'TSLST2', 'Label Text 2', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'TSLST3', 'Label Text 3', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'TSREMK', 'Remark', 100);
        fnCrtColGridDefault($this->GridObj, "TS");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'TDDSCD','direction'=>'asc');
        $this->GridSort[] = array('name'=>'TSSYCD','direction'=>'asc');
        $this->GridColumns = [];

        $TBLSYS = TBLSYS::noLock()
                ->leftJoin('TBLDSC', 'TDDSCDIY', 'TSDSCDIY')
                ->where([
                    ['TSDLFG', '=', '0'],
                  ]);

        $TBLSYS = fnQuerySearchAndPaginate($request, $TBLSYS, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $TBLSYS,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'TSSYCDIY');
        // dd($Hasil);
        return response()->jSon($Hasil);     

    }


    private $FormObj = [];

    public function FormObject(Request $request) {

        fnCrtObjPop($this->FormObj, 1, "FF", "2", "Panel01", "TSDSCDIY", "TDDSCD", "TDDSNM", "Description Code", "", true, "TBLDSC", true, 1);

        fnCrtObjNum($this->FormObj, 0, "FF", "3", "Panel01", "TDLGTH", "Panjang", "", false);
        fnCrtObjRad($this->FormObj, 1, "FF", "0", "Panel01", "TSDPFG", "Status", "", "1", "Radio", "DSPLY");

        fnCrtObjTxt($this->FormObj, 1, "FF", "2", "Panel03", "TSSYCD", "Code", "", true, 0, 0, "Big");
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel03", "TSSYNM", "Description", "", true);

        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel05", "TSSYT1", "Text 1", "", false); 
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel05", "TSLST1", "Label Text 1", "", false);

        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel05", "TSSYT2", "Text 2", "", false); 
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel05", "TSLST2", "Label Text 2", "", false);

        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel05", "TSSYT3", "Text 3", "", false); 
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel05", "TSLST3", "Label Text 3", "", false);

        fnCrtObjNum($this->FormObj, 1, "FF", "0", "Panel05", "TSSYV1", "Value 1", "", false); 
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel05", "TSLSV1", "Label Value 1", "", false);

        fnCrtObjNum($this->FormObj, 1, "FF", "0", "Panel05", "TSSYV2", "Value 2", "", false); 
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel05", "TSLSV2", "Label Value 2", "", false);

        fnCrtObjNum($this->FormObj, 1, "FF", "0", "Panel05", "TSSYV3", "Value 3", "", false); 
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel05", "TSLSV3", "Label Value 3", "", false);

        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel10", "TSREMK", "Remark", "", false, 100);
        fnCrtObjTxt($this->FormObj, 0, "FF", "3", "Panel10", "TSSYCDIY", "IY", "", false);

        fnCrtObjDefault($this->FormObj,"TS");    
        // dd($this->FormObj);

        return response()->jSon($this->FormObj);   
    }


    public function FillForm(Request $request) {
        $this->FormObject($request);
        $FillFormObject = $this->getFormObject($this->FormObj);
        // dd($FillFormObject);

        $TBLSYS = TBLSYS::noLock()
                ->select( $FillFormObject )
                ->leftJoin('TBLDSC', 'TDDSCDIY', 'TSDSCDIY')
                ->where([
                    ['TSSYCDIY', '=', $request->TSSYCDIY],
                    // ['TSSYCDIY', '=', '1'],
                  ])->get();
        // dd($TBLSYS);

        $Hasil = $this->setFillForm(true, $TBLSYS, "");
        // dd($Hasil);
        return response()->jSon($Hasil);        

    }   


    public function SaveData (Request $request) {

        $Hasil = $this->doExecuteQuery( $request->AppUserName, "cTBLSYS@StpTBLSYS");  
        // $Hasil->message = ""; 
        // $Hasil = array("success"=> $BerHasil, "message"=> " Sukses... ".$message.$b);
        return response()->jSon($Hasil);

    }

    public function StpTBLSYS(Request $request) {


        $fTBLSYS = json_encode($request->frmTBLSYS);
        $fTBLSYS = json_decode($fTBLSYS, true);

        $Delimiter = "";
        $UnikNo = fnGenUnikNo($Delimiter);

        $HasilCheckBFCS = fnCheckBFCS (
                            array("Table"=>"TBLSYS", 
                                  "Key"=>"TSSYCDIY", 
                                  "Data"=>$fTBLSYS, 
                                  "Mode"=>$request->Mode,
                                  "Menu"=>"", 
                                  "FieldTransDate"=>""));
        if (!$HasilCheckBFCS["success"]) {
            return response()->jSon($HasilCheckBFCS);
        }

        $UserName = $request->AppUserName;

        switch ($request->Mode) {
            case "1":
                $fTBLSYS['TSSYCDIY'] = fnTBLNOR('TBLSYS', $UserName);
                $FinalField = fnGetSintaxCRUD ($UserName, $fTBLSYS, 
                    '1', "TS", 
                    ['TSSYCDIY','TSDSCDIY','TSSYCD','TSSYNM','TSDPFG','TSREMK',
                     'TSSYT1','TSLST1','TSSYT2','TSLST2','TSSYT3','TSLST3',
                     'TSSYV1','TSLSV1','TSSYV2','TSLSV2','TSSYV3','TSLSV3'], 
                    $UnikNo );
                DB::table('TBLSYS')->insert($FinalField);

                break;
            case "2":
                $FinalField = fnGetSintaxCRUD ($UserName, $fTBLSYS, 
                    '2', "TS", 
                    ['TSDSCDIY','TSSYCD','TSSYNM','TSDPFG','TSREMK',
                     'TSSYT1','TSLST1','TSSYT2','TSLST2','TSSYT3','TSLST3',
                     'TSSYV1','TSLSV1','TSSYV2','TSLSV2','TSSYV3','TSLSV3'], 
                    $UnikNo );
                DB::table('TBLSYS')
                    ->where('TSSYCDIY','=',$fTBLSYS['TSSYCDIY'])
                    ->update($FinalField);

                break;
            case "3":
                DB::table('TBLSYS')
                    ->where('TSSYCDIY','=',$fTBLSYS['TSSYCDIY'])      
                    ->delete();
                break;
        }


    }


}
