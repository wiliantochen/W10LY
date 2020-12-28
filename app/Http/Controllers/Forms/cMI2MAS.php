<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\MI2MAS;
use DB;

class cMI2MAS extends cSOController {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'M2M2NOIY', 'IY', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'M1NAME', 'Kategori', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'M2M2NO', 'Kode', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'M2NAME', 'Nama', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'M2REMK', 'Remark', 100);
        fnCrtColGridDefault($this->GridObj, "M2");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'M1NAME','direction'=>'asc');
        $this->GridSort[] = array('name'=>'M2M2NO','direction'=>'asc');
        $this->GridColumns = [];

        $MI2MAS = MI2MAS::noLock()
                ->leftJoin('MI1MAS', 'M1M1NOIY', 'M2M1NOIY')
                ->where([
                    ['M2COMPIY', '=', fnGetCompIY($request->AppCompanyCode)],
                    ['M2DLFG', '=', '0'],
                  ]);

        $MI2MAS = fnQuerySearchAndPaginate($request, $MI2MAS, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $MI2MAS,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'M2M2NOIY');
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

        fnCrtObjTxt($this->FormObj, 0, "FF", "3", "Panel1", "M2M2NOIY", "IY", "", false);
        fnCrtObjPop($this->FormObj, 1, "FF", "2", "Panel1", "M2M1NOIY", "M1M1NO", "M1NAME", "Kategori", "", true, "MI1MAS", true, 1);
        fnCrtObjTxt($this->FormObj, 1, "FF", "2", "Panel1", "M2M2NO", "Kode", "", true, 0, 20, "Big");
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "M2NAME", "Nama", "", true, 0, 100);
        fnCrtObjRad($this->FormObj, 1, "FF", "0", "Panel1", "M2DPFG", "Status", "", "1", "Radio", "DSPLY");
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "M2REMK", "Keterangan", "", false, 100);

        fnCrtObjDefault($this->FormObj,"M2");    
        // dd($this->FormObj);

        return response()->jSon($this->FormObj);   
    }


    public function FillForm(Request $request) {
        $this->FormObject($request);
        $FillFormObject = $this->getFormObject($this->FormObj);
        // dd($FillFormObject);

        $MI2MAS = MI2MAS::noLock()
                ->select( $FillFormObject )
                ->leftJoin('MI1MAS', 'M1M1NOIY', 'M2M1NOIY')
                ->where([
                    ['M2M2NOIY', '=', $request->M2M2NOIY],
                    // ['M2M2NOIY', '=', '1'],
                  ])->get();
        // dd($MI2MAS);

        $Hasil = $this->setFillForm(true, $MI2MAS, "");
        // dd($Hasil);
        return response()->jSon($Hasil);        

    }   


    public function SaveData (Request $request) {

        $Hasil = $this->doExecuteQuery( $request->AppUserName, "cMI2MAS@StpMI2MAS");  
        // $Hasil->message = ""; 
        // $Hasil = array("success"=> $BerHasil, "message"=> " Sukses... ".$message.$b);
        return response()->jSon($Hasil);

    }

    public function StpMI2MAS(Request $request) {


        $fMI2MAS = json_encode($request->frmMI2MAS);
        $fMI2MAS = json_decode($fMI2MAS, true);

        $Delimiter = "";
        $UnikNo = fnGenUnikNo($Delimiter);

        $HasilCheckBFCS = fnCheckBFCS (
                            array("Table"=>"MI2MAS", 
                                  "Key"=>"M2M2NOIY", 
                                  "Data"=>$fMI2MAS, 
                                  "Mode"=>$request->Mode,
                                  "Menu"=>"", 
                                  "FieldTransDate"=>""));
        if (!$HasilCheckBFCS["success"]) {
            return response()->jSon($HasilCheckBFCS);
        }

        $TBLUSR = $request->user();
        $UserName = $TBLUSR->TUUSER;
        $fMI2MAS['M2COMPIY'] = $TBLUSR->TUCOMPIY;
        // $UserName = $request->AppUserName;
        // $fMI2MAS['M2COMPIY'] = fnGetCompIY($request->AppCompanyCode);

        switch ($request->Mode) {
            case "1":
                $fMI2MAS['M2M2NOIY'] = fnSYSNOR('MI2MAS', $UserName);
                $FinalField = fnGetSintaxCRUD ($UserName, $fMI2MAS, 
                    '1', "M2", 
                    ['M2COMPIY','M2M2NOIY','M2M1NOIY','M2M2NO','M2NAME','M2DPFG','M2REMK'], 
                    $UnikNo );
                DB::table('MI2MAS')->insert($FinalField);

                break;
            case "2":
                $FinalField = fnGetSintaxCRUD ($UserName, $fMI2MAS, 
                    '2', "M2", 
                    ['M2M1NOIY','M2M2NO','M2NAME','M2DPFG','M2REMK'], 
                    $UnikNo );
                DB::table('MI2MAS')
                    ->where('M2M2NOIY','=',$fMI2MAS['M2M2NOIY'])
                    ->update($FinalField);

                break;
            case "3":
                DB::table('MI2MAS')
                    ->where('M2M2NOIY','=',$fMI2MAS['M2M2NOIY'])      
                    ->delete();
                break;
        }


    }


}
