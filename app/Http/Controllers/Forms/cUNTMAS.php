<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\UNTMAS;
use DB;

class cUNTMAS extends cSOController {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'UMUNMSIY', 'IY', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'UMUNMS', 'Kode', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'UMNAME', 'Nama', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'UMREMK', 'Keterangan', 100);
        fnCrtColGridDefault($this->GridObj, "UM");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'UMUNMS','direction'=>'asc');
        $this->GridColumns = [];

        $UNTMAS = UNTMAS::noLock()
                ->where([
                    ['UMCOMPIY', '=', fnGetCompIY($request->AppCompanyCode)],
                    ['UMDLFG', '=', '0'],
                  ]);

        $UNTMAS = fnQuerySearchAndPaginate($request, $UNTMAS, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $UNTMAS,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'UMUNMSIY');
        // dd($Hasil);
        return response()->jSon($Hasil);     

    }


    private $FormObj = [];

    public function FormObject(Request $request) {

        fnCrtObjTxt($this->FormObj, 0, "FF", "3", "Panel1", "UMUNMSIY", "IY", "", false);
        fnCrtObjTxt($this->FormObj, 1, "FF", "2", "Panel1", "UMUNMS", "Kode", "", true, 0, 20, "Big");
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "UMNAME", "Nama", "", true, 0, 100);
        fnCrtObjRad($this->FormObj, 1, "FF", "0", "Panel1", "UMDPFG", "Status", "", "1", "Radio", "DSPLY");
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "UMREMK", "Keterangan", "", false, 100);

        fnCrtObjDefault($this->FormObj,"UM");    

        return response()->jSon($this->FormObj);   
    }


    public function FillForm(Request $request) {
        $this->FormObject($request);
        $FillFormObject = $this->getFormObject($this->FormObj);

        $UNTMAS = UNTMAS::noLock()
                ->select( $FillFormObject )
                ->where([
                    ['UMUNMSIY', '=', $request->UMUNMSIY],
                  ])->get();

        $Hasil = $this->setFillForm(true, $UNTMAS, "");
        return response()->jSon($Hasil);        

    }   



    public function SaveData (Request $request) {

        $Hasil = $this->doExecuteQuery( $request->AppUserName, "cUNTMAS@StpUNTMAS");  
        // $Hasil->message = ""; 
        // $Hasil = array("success"=> $BerHasil, "message"=> " Sukses... ".$message.$b);
        return response()->jSon($Hasil);

    }

    public function StpUNTMAS(Request $request) {


        $fUNTMAS = json_encode($request->frmUNTMAS);
        $fUNTMAS = json_decode($fUNTMAS, true);

        $Delimiter = "";
        $UnikNo = fnGenUnikNo($Delimiter);

        $HasilCheckBFCS = fnCheckBFCS (
                            array("Table"=>"UNTMAS", 
                                  "Key"=>"UMUNMSIY", 
                                  "Data"=>$fUNTMAS, 
                                  "Mode"=>$request->Mode,
                                  "Menu"=>"", 
                                  "FieldTransDate"=>""));
        if (!$HasilCheckBFCS["success"]) {
            return response()->jSon($HasilCheckBFCS);
        }

        $UserName = $request->AppUserName;
        $fUNTMAS['UMCOMPIY'] = fnGetCompIY($request->AppCompanyCode);

        switch ($request->Mode) {
            case "1":
                $fUNTMAS['UMUNMSIY'] = fnSYSNOR('UNTMAS', $UserName);
                $FinalField = fnGetSintaxCRUD ($UserName, $fUNTMAS, 
                    '1', "UM", 
                    ['UMCOMPIY','UMUNMSIY','UMUNMS','UMNAME','UMDPFG','UMREMK'], 
                    $UnikNo );
                DB::table('UNTMAS')->insert($FinalField);

                break;
            case "2":
                $FinalField = fnGetSintaxCRUD ($UserName, $fUNTMAS, 
                    '2', "UM", 
                    ['UMNAME','UMDPFG','UMREMK'], 
                    $UnikNo );
                DB::table('UNTMAS')
                    ->where('UMUNMSIY','=',$fUNTMAS['UMUNMSIY'])
                    ->update($FinalField);

                break;
            case "3":
                DB::table('UNTMAS')
                    ->where('UMUNMSIY','=',$fUNTMAS['UMUNMSIY'])      
                    ->delete();
                break;
        }


    }



}
