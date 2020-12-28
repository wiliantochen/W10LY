<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\MB2MAS;
use DB;

class cMB2MAS extends cSOController {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'B2B2NOIY', 'IY', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'B1NAME', 'Kategori', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'B2B2NO', 'Kode', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'B2NAME', 'Nama', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'B2REMK', 'Remark', 100);
        fnCrtColGridDefault($this->GridObj, "B2");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'B1NAME','direction'=>'asc');
        $this->GridSort[] = array('name'=>'B2B2NO','direction'=>'asc');
        $this->GridColumns = [];

        $MB2MAS = MB2MAS::noLock()
                ->leftJoin('MB1MAS', 'B1B1NOIY', 'B2B1NOIY')
                ->where([
                    ['B2COMPIY', '=', fnGetCompIY($request->AppCompanyCode)],
                    ['B2DLFG', '=', '0'],
                  ]);

        $MB2MAS = fnQuerySearchAndPaginate($request, $MB2MAS, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $MB2MAS,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'B2B2NOIY');
        // dd($Hasil);
        // return response()->jSon($Hasil);  
        if(is_null($request->ETE)) {
            return response()->jSon($Hasil);     
        } else {
            return response()->jSon($this->ExportToExcel($Hasil));
        }
   

    }


    private $FormObj = [];

    public function FormObject(Request $request) {

        fnCrtObjTxt($this->FormObj, 0, "FF", "3", "Panel1", "B2B2NOIY", "IY", "", false);
        fnCrtObjPop($this->FormObj, 1, "FF", "2", "Panel1", "B2B1NOIY", "B1B1NO", "B1NAME", "Kategori", "", true, "MB1MAS", true, 1);
        fnCrtObjTxt($this->FormObj, 1, "FF", "2", "Panel1", "B2B2NO", "Kode", "", true, 0, 20, "Big");
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "B2NAME", "Nama", "", true, 0, 100);
        fnCrtObjRad($this->FormObj, 1, "FF", "0", "Panel1", "B2DPFG", "Status", "", "1", "Radio", "DSPLY");
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "B2REMK", "Keterangan", "", false, 100);

        fnCrtObjDefault($this->FormObj,"B2");    
        // dd($this->FormObj);

        return response()->jSon($this->FormObj);   
    }


    public function FillForm(Request $request) {
        $this->FormObject($request);
        $FillFormObject = $this->getFormObject($this->FormObj);
        // dd($FillFormObject);

        $MB2MAS = MB2MAS::noLock()
                ->select( $FillFormObject )
                ->leftJoin('MB1MAS', 'B1B1NOIY', 'B2B1NOIY')
                ->where([
                    ['B2B2NOIY', '=', $request->B2B2NOIY],
                    // ['B2B2NOIY', '=', '1'],
                  ])->get();
        // dd($MB2MAS);

        $Hasil = $this->setFillForm(true, $MB2MAS, "");
        // dd($Hasil);
        return response()->jSon($Hasil);        

    }   


    public function SaveData (Request $request) {

        $Hasil = $this->doExecuteQuery( $request->AppUserName, "cMB2MAS@StpMB2MAS");  
        // $Hasil->message = ""; 
        // $Hasil = array("success"=> $BerHasil, "message"=> " Sukses... ".$message.$b);
        return response()->jSon($Hasil);

    }

    public function StpMB2MAS(Request $request) {


        $fMB2MAS = json_encode($request->frmMB2MAS);
        $fMB2MAS = json_decode($fMB2MAS, true);

        $Delimiter = "";
        $UnikNo = fnGenUnikNo($Delimiter);

        $HasilCheckBFCS = fnCheckBFCS (
                            array("Table"=>"MB2MAS", 
                                  "Key"=>"B2B2NOIY", 
                                  "Data"=>$fMB2MAS, 
                                  "Mode"=>$request->Mode,
                                  "Menu"=>"", 
                                  "FieldTransDate"=>""));
        if (!$HasilCheckBFCS["success"]) {
            return response()->jSon($HasilCheckBFCS);
        }

        $TBLUSR = $request->user();
        $UserName = $TBLUSR->TUUSER;
        $fMB2MAS['B2COMPIY'] = $TBLUSR->TUCOMPIY;
        // $UserName = $request->AppUserName;
        // $fMB2MAS['B2COMPIY'] = fnGetCompIY($request->AppCompanyCode);

        switch ($request->Mode) {
            case "1":
                $fMB2MAS['B2B2NOIY'] = fnSYSNOR('MB2MAS', $UserName);
                $FinalField = fnGetSintaxCRUD ($UserName, $fMB2MAS, 
                    '1', "B2", 
                    ['B2COMPIY','B2B2NOIY','B2B1NOIY','B2B2NO','B2NAME','B2DPFG','B2REMK'], 
                    $UnikNo );
                DB::table('MB2MAS')->insert($FinalField);

                break;
            case "2":
                $FinalField = fnGetSintaxCRUD ($UserName, $fMB2MAS, 
                    '2', "B2", 
                    ['B2B1NOIY','B2B2NO','B2NAME','B2DPFG','B2REMK'], 
                    $UnikNo );
                DB::table('MB2MAS')
                    ->where('B2B2NOIY','=',$fMB2MAS['B2B2NOIY'])
                    ->update($FinalField);

                break;
            case "3":
                DB::table('MB2MAS')
                    ->where('B2B2NOIY','=',$fMB2MAS['B2B2NOIY'])      
                    ->delete();
                break;
        }


    }


}
