<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\TBLSLF;
use DB;

class cTBLSLF extends cSOController {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {

        fnCrtColGrid($this->GridObj, "act", 1, 0, '001', 'ACTION', 'Action', 50);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'TQNOMRIY', 'No', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'TQUSER', 'UserName', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'TQSTMT', 'Statement', 100, "", 200);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'TQREMK', 'Remark', 100, "", 200);
        fnCrtColGridDefault($this->GridObj, "TQ");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'TQNOMRIY','direction'=>'desc');
        $this->GridColumns = [];

        $TBLSLF = TBLSLF::noLock()
                ->where([
                    ['TQCOMPIY', '=', fnGetCompIY($request->AppCompanyCode)],
                    ['TQDLFG', '=', '0'],
                  ]);

        $TBLSLF = fnQuerySearchAndPaginate($request, $TBLSLF, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $TBLSLF,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'TQNOMRIY');
        // return response()->jSon($Hasil);  
        if(is_null($request->ETE)) {
            return response()->jSon($Hasil);     
        } else {
            return response()->jSon($this->ExportToExcel($Hasil));
        }
   

    }

    private $FormObj = [];

    public function FormObject(Request $request) {
        fnCrtObjNum($this->FormObj, 0, "FF", "3", "Panel1", "TQNOMRIY", "ID", "", false, 0);      
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "TQUSER", "User Name", "", true, 0, 50);     
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "TQSTMT", "Statement SQL", "", false, 200);        
            // fnUpdObj($this->FormObj, "TQSTMT", array("Helper"=>'Jika File Group diisi, Maka Menu tersebut akan refer ke file yang sama'));
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "TQREMK", "Remark", "Everything You Want", false, 300);
            // fnUpdObj($this->FormObj, "TQREMK", array("Helper"=>'Terserah anda mau isi apa?'));
        fnCrtObjDefault($this->FormObj,"TQ");    
        return response()->jSon($this->FormObj);   
    }

    public function FillForm(Request $request) {
        $this->FormObject($request);
        $FillFormObject = $this->getFormObject($this->FormObj);
        $TBLSLF = TBLSLF::noLock()
                ->select( $FillFormObject )
                ->where([
                    ['TQNOMRIY', '=', $request->TQNOMRIY],
                  ])->get();

        $Hasil = $this->setFillForm(true, $TBLSLF, "");
        return response()->jSon($Hasil);        
    }   

    public function SaveData(Request $request) {
        $Hasil = array("success"=> false, 
                       "message"=> "No Action For This Menu ");
        return response()->jSon($Hasil);

    }


}
