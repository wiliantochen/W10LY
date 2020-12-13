<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\MB1MAS;
use DB;

class cMB1MAS extends cSOController {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'B1B1NOIY', 'IY', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'B1B1NO', 'Kode', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'B1NAME', 'Nama', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'B1REMK', 'Keterangan', 100);
        fnCrtColGridDefault($this->GridObj, "B1");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'B1B1NO','direction'=>'asc');
        $this->GridColumns = [];

        $MB1MAS = MB1MAS::noLock()
                ->where([
                    ['B1COMPIY', '=', fnGetCompIY($request->AppCompanyCode)],
                    ['B1DLFG', '=', '0'],
                  ]);

        $MB1MAS = fnQuerySearchAndPaginate($request, $MB1MAS, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $MB1MAS,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'B1B1NOIY');
        // dd($Hasil);
        return response()->jSon($Hasil);     

    }


    private $FormObj = [];

    public function FormObject(Request $request) {

        fnCrtObjTxt($this->FormObj, 0, "FF", "3", "Panel1", "B1B1NOIY", "IY", "", false);
        fnCrtObjTxt($this->FormObj, 1, "FF", "2", "Panel1", "B1B1NO", "Kode", "", true, 0, 20, "Big");
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "B1NAME", "Nama", "", true, 0, 100);
        fnCrtObjRad($this->FormObj, 1, "FF", "0", "Panel1", "B1DPFG", "Status", "", "1", "Radio", "DSPLY");
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "B1REMK", "Keterangan", "", false, 100);

        fnCrtObjDefault($this->FormObj,"B1");    

        return response()->jSon($this->FormObj);   
    }


    public function FillForm(Request $request) {
        $this->FormObject($request);
        $FillFormObject = $this->getFormObject($this->FormObj);

        $MB1MAS = MB1MAS::noLock()
                ->select( $FillFormObject )
                ->where([
                    ['B1B1NOIY', '=', $request->B1B1NOIY],
                  ])->get();

        $Hasil = $this->setFillForm(true, $MB1MAS, "");

        return response()->jSon($Hasil);        

    }   



    public function SaveData (Request $request) {

        $Hasil = $this->doExecuteQuery( $request->AppUserName, "cMB1MAS@StpMB1MAS");  
        // $Hasil->message = ""; 
        // $Hasil = array("success"=> $BerHasil, "message"=> " Sukses... ".$message.$b);
        return response()->jSon($Hasil);

    }

    public function StpMB1MAS(Request $request) {


        $fMB1MAS = json_encode($request->frmMB1MAS);
        $fMB1MAS = json_decode($fMB1MAS, true);

        $Delimiter = "";
        $UnikNo = fnGenUnikNo($Delimiter);

        $HasilCheckBFCS = fnCheckBFCS (
                            array("Table"=>"MB1MAS", 
                                  "Key"=>"B1B1NOIY", 
                                  "Data"=>$fMB1MAS, 
                                  "Mode"=>$request->Mode,
                                  "Menu"=>"", 
                                  "FieldTransDate"=>""));
        if (!$HasilCheckBFCS["success"]) {
            return response()->jSon($HasilCheckBFCS);
        }

        $UserName = $request->AppUserName;
        $fMB1MAS['B1COMPIY'] = fnGetCompIY($request->AppCompanyCode);

        switch ($request->Mode) {
            case "1":
                $fMB1MAS['B1B1NOIY'] = fnSYSNOR('MB1MAS', $UserName);
                $FinalField = fnGetSintaxCRUD ($UserName, $fMB1MAS, 
                    '1', "B1", 
                    ['B1COMPIY','B1B1NOIY','B1B1NO','B1NAME','B1DPFG','B1REMK'], 
                    $UnikNo );
                DB::table('MB1MAS')->insert($FinalField);

                break;
            case "2":
                $FinalField = fnGetSintaxCRUD ($UserName, $fMB1MAS, 
                    '2', "B1", 
                    ['B1NAME','B1DPFG','B1REMK'], 
                    $UnikNo );
                DB::table('MB1MAS')
                    ->where('B1B1NOIY','=',$fMB1MAS['B1B1NOIY'])
                    ->update($FinalField);

                break;
            case "3":
                DB::table('MB1MAS')
                    ->where('B1B1NOIY','=',$fMB1MAS['B1B1NOIY'])      
                    ->delete();
                break;
        }


    }



}
