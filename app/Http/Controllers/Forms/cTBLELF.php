<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\TBLELF;
use DB;

class cTBLELF extends cSOController {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {
        
        fnCrtColGrid($this->GridObj, "act", 1, 0, '001', 'ACTION', 'Action', 50);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'TENOMRIY', 'No', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'TEERNO', 'Error Code', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'TEERST', 'Error State', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'TEERMS', 'Error Message', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 1, '', 'TESTMT', 'Error Sql', 100, "", 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'TEREMK', 'Remark', 100, "", 100);
        fnCrtColGridDefault($this->GridObj, "TE");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'TENOMRIY','direction'=>'desc');
        $this->GridColumns = [];

        $TBLELF = TBLELF::noLock()
                ->where([
                    ['TECOMPIY', '=', fnGetCompIY($request->AppCompanyCode)],
                    ['TEDLFG', '=', '0'],
                  ]);

        $TBLELF = fnQuerySearchAndPaginate($request, $TBLELF, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $TBLELF,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'TENOMRIY');
        return response()->jSon($Hasil);     

    }

    private $FormObj = [];

    public function FormObject(Request $request) {
        fnCrtObjNum($this->FormObj, 0, "FF", "3", "Panel1", "TENOMRIY", "ID", "", false, 0);      
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "TEUSER", "UserName", "", true, 0, 50);     
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "TEERNO", "Error Code", "", false);    
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "TEERST", "Error State", "", true);        
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "TEERMS", "Error Message", "", false, 100);
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "TESTMT", "Error Sql", "", false, 200);
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "TEREMK", "Remark", "Everything You Want", false, 300);
            // fnUpdObj($this->FormObj, "TEREMK", array("Helper"=>'Terserah anda mau isi apa?'));
        fnCrtObjDefault($this->FormObj,"TE");    
        return response()->jSon($this->FormObj);   
    }

    public function FillForm(Request $request) {
        $this->FormObject($request);
        $FillFormObject = $this->getFormObject($this->FormObj);
        $TBLELF = TBLELF::noLock()
                ->select( $FillFormObject )
                ->where([
                    ['TENOMRIY', '=', $request->TENOMRIY],
                  ])->get();
        $Hasil = $this->setFillForm(true, $TBLELF, "");
        return response()->jSon($Hasil);        

    }   

    public function SaveData(Request $request) {
        $Hasil = array("success"=> false, 
                       "message"=> "No Action For This Menu ");
        return response()->jSon($Hasil);

    }


}
