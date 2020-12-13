<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\MI1MAS;
use DB;

class cMI1MAS extends cSOController {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'M1M1NOIY', 'IY', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'M1M1NO', 'Kode', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'M1NAME', 'Nama', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'M1REMK', 'Keterangan', 100);
        fnCrtColGridDefault($this->GridObj, "M1");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'M1M1NO','direction'=>'asc');
        $this->GridColumns = [];

        $MI1MAS = MI1MAS::noLock()
                ->where([
                    ['M1COMPIY', '=', fnGetCompIY($request->AppCompanyCode)],
                    ['M1DLFG', '=', '0'],
                  ]);

        $MI1MAS = fnQuerySearchAndPaginate($request, $MI1MAS, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $MI1MAS,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'M1M1NOIY');
        // dd($Hasil);
        return response()->jSon($Hasil);     

    }


    private $FormObj = [];

    public function FormObject(Request $request) {

        fnCrtObjTxt($this->FormObj, 0, "FF", "3", "Panel1", "M1M1NOIY", "IY", "", false);
        fnCrtObjTxt($this->FormObj, 1, "FF", "2", "Panel1", "M1M1NO", "Kode", "", true, 0, 20, "Big");
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "M1NAME", "Nama", "", true, 0, 100);
        fnCrtObjRad($this->FormObj, 1, "FF", "0", "Panel1", "M1DPFG", "Status", "", "1", "Radio", "DSPLY");
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "M1REMK", "Keterangan", "", false, 100);

        fnCrtObjDefault($this->FormObj,"M1");    

        return response()->jSon($this->FormObj);   
    }


    public function FillForm(Request $request) {
        $this->FormObject($request);
        $FillFormObject = $this->getFormObject($this->FormObj);

        $MI1MAS = MI1MAS::noLock()
                ->select( $FillFormObject )
                ->where([
                    ['M1M1NOIY', '=', $request->M1M1NOIY],
                  ])->get();

        $Hasil = $this->setFillForm(true, $MI1MAS, "");

        return response()->jSon($Hasil);        

    }   



    public function SaveData (Request $request) {

        $Hasil = $this->doExecuteQuery( $request->AppUserName, "cMI1MAS@StpMI1MAS");  
        // $Hasil->message = ""; 
        // $Hasil = array("success"=> $BerHasil, "message"=> " Sukses... ".$message.$b);
        return response()->jSon($Hasil);

    }

    public function StpMI1MAS(Request $request) {


        $fMI1MAS = json_encode($request->frmMI1MAS);
        $fMI1MAS = json_decode($fMI1MAS, true);

        $Delimiter = "";
        $UnikNo = fnGenUnikNo($Delimiter);

        $HasilCheckBFCS = fnCheckBFCS (
                            array("Table"=>"MI1MAS", 
                                  "Key"=>"M1M1NOIY", 
                                  "Data"=>$fMI1MAS, 
                                  "Mode"=>$request->Mode,
                                  "Menu"=>"", 
                                  "FieldTransDate"=>""));
        if (!$HasilCheckBFCS["success"]) {
            return response()->jSon($HasilCheckBFCS);
        }

        $UserName = $request->AppUserName;
        $fMI1MAS['M1COMPIY'] = fnGetCompIY($request->AppCompanyCode);

        switch ($request->Mode) {
            case "1":
                $fMI1MAS['M1M1NOIY'] = fnSYSNOR('MI1MAS', $UserName);
                $FinalField = fnGetSintaxCRUD ($UserName, $fMI1MAS, 
                    '1', "M1", 
                    ['M1COMPIY','M1M1NOIY','M1M1NO','M1NAME','M1DPFG','M1REMK'], 
                    $UnikNo );
                DB::table('MI1MAS')->insert($FinalField);

                break;
            case "2":
                $FinalField = fnGetSintaxCRUD ($UserName, $fMI1MAS, 
                    '2', "M1", 
                    ['M1NAME','M1DPFG','M1REMK'], 
                    $UnikNo );
                DB::table('MI1MAS')
                    ->where('M1M1NOIY','=',$fMI1MAS['M1M1NOIY'])
                    ->update($FinalField);

                break;
            case "3":
                DB::table('MI1MAS')
                    ->where('M1M1NOIY','=',$fMI1MAS['M1M1NOIY'])      
                    ->delete();
                break;
        }


    }



}
