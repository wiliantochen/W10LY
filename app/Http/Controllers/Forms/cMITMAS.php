<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\MITMAS;
use DB;

class cMITMAS extends cSOController {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'MMITNOIY', 'IY', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'MMITNO', 'Kode', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'MMNAME', 'Nama', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'MMDESC', 'Deskripsi', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'MMQTYS', 'Stock', 100, "", 2);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'UMUNMS', 'Satuan', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'M1NAME', 'Kategori', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'M2NAME', 'Sub Kategori', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'MMREMK', 'Remark', 100, '', 100);
        fnCrtColGridDefault($this->GridObj, "MM");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'MMITNO','direction'=>'asc');
        $this->GridColumns = [];

        $MITMAS = MITMAS::noLock()
                ->leftJoin('MI2MAS', 'M2M2NOIY', 'MMM2NOIY')
                ->leftJoin('MI1MAS', 'M1M1NOIY', 'M2M1NOIY')
                ->leftJoin('UNTMAS', 'UMUNMSIY', 'MMUNMSIY')
                ->where([
                    ['MMCOMPIY', '=', fnGetCompIY($request->AppCompanyCode)],
                    ['MMDLFG', '=', '0'],
                  ]);

        $MITMAS = fnQuerySearchAndPaginate($request, $MITMAS, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $MITMAS,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'MMITNOIY');
        return response()->jSon($Hasil);     

    }


    private $FormObj = [];

    public function FormObject(Request $request) {

        fnCrtObjTxt($this->FormObj, 0, "FF", "3", "Panel1", "MMITNOIY", "IY", "", false);
        fnCrtObjTxt($this->FormObj, 1, "FF", "2", "Panel1", "MMITNO", "Kode", "", true, 0, 20, "Big");
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "MMNAME", "Nama", "", true, 0, 100);
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "MMDESC", "Deskripsi", "", true, 0, 200);
        fnCrtObjPop($this->FormObj, 1, "FF", "0", "Panel1", "MMUNMSIY", "UMUNMS", "UMNAME", "Satuan", "", true, "UNTMAS", true, 1);        
        fnCrtObjPop($this->FormObj, 1, "FF", "0", "Panel1", "MMM2NOIY", "M2M2NO", "M2NAME", "Sub Kategori", "", true, "MI2MAS", true, 1);        
        fnCrtObjNum($this->FormObj, 1, "FF", "0", "Panel1", "MMHARG", "Harga Jual", "", false, 0);
        fnCrtObjNum($this->FormObj, 1, "FF", "3", "Panel1", "MMQTYS", "Stock", "", false, 0);

        fnCrtObjRad($this->FormObj, 1, "FF", "0", "Panel1", "MMDPFG", "Status", "", "1", "Radio", "DSPLY");
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "MMREMK", "Keterangan", "", false, 100);

        fnCrtObjDefault($this->FormObj,"MM");    

        return response()->jSon($this->FormObj);   
    }


    public function FillForm(Request $request) {
        $this->FormObject($request);
        $FillFormObject = $this->getFormObject($this->FormObj);

        $MITMAS = MITMAS::noLock()
                ->select( $FillFormObject )
                ->leftJoin('MI2MAS', 'M2M2NOIY', 'MMM2NOIY')
                ->leftJoin('UNTMAS', 'UMUNMSIY', 'MMUNMSIY')
                ->where([
                    ['MMITNOIY', '=', $request->MMITNOIY],
                    // ['MMITNOIY', '=', '1'],
                  ])->get();

        $Hasil = $this->setFillForm(true, $MITMAS, "");
        return response()->jSon($Hasil);        

    }   

    public function SaveData (Request $request) {

        $Hasil = $this->doExecuteQuery( $request->AppUserName, "cMITMAS@StpMITMAS");  
        // $Hasil->message = ""; 
        // $Hasil = array("success"=> $BerHasil, "message"=> " Sukses... ".$message.$b);
        return response()->jSon($Hasil);

    }

    public function StpMITMAS(Request $request) {


        $fMITMAS = json_encode($request->frmMITMAS);
        $fMITMAS = json_decode($fMITMAS, true);

        $Delimiter = "";
        $UnikNo = fnGenUnikNo($Delimiter);

        $HasilCheckBFCS = fnCheckBFCS (
                            array("Table"=>"MITMAS", 
                                  "Key"=>"MMITNOIY", 
                                  "Data"=>$fMITMAS, 
                                  "Mode"=>$request->Mode,
                                  "Menu"=>"", 
                                  "FieldTransDate"=>""));
        if (!$HasilCheckBFCS["success"]) {
            return response()->jSon($HasilCheckBFCS);
        }

        $TBLUSR = $request->user();
        $UserName = $TBLUSR->TUUSER;
        $fMITMAS['MMCOMPIY'] = $TBLUSR->TUCOMPIY;
        // $UserName = $request->AppUserName;
        // $fMITMAS['MMCOMPIY'] = fnGetCompIY($request->AppCompanyCode);

        switch ($request->Mode) {
            case "1":
                $fMITMAS['MMITNOIY'] = fnSYSNOR('MITMAS', $UserName);
                $fMITMAS['MMQTYS'] = '0';
                $FinalField = fnGetSintaxCRUD ($UserName, $fMITMAS, 
                    '1', "MM", 
                    ['MMCOMPIY','MMITNOIY','MMITNO','MMNAME','MMDESC','MMUNMSIY','MMM2NOIY','MMHARG','MMQTYS','MMDPFG','MMREMK'], 
                    $UnikNo );
                DB::table('MITMAS')->insert($FinalField);

                break;
            case "2":
                $FinalField = fnGetSintaxCRUD ($UserName, $fMITMAS, 
                    '2', "MM", 
                    ['MMNAME','MMDESC','MMUNMSIY','MMM2NOIY','MMHARG','MMDPFG','MMREMK'], 
                    $UnikNo );
                DB::table('MITMAS')
                    ->where('MMITNOIY','=',$fMITMAS['MMITNOIY'])
                    ->update($FinalField);

                break;
            case "3":
                DB::table('MITMAS')
                    ->where('MMITNOIY','=',$fMITMAS['MMITNOIY'])      
                    ->delete();
                break;
        }


    }




}
