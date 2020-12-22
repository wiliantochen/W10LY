<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\TBLDSC;
use DB;

class cTBLDSC extends cSOController {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'TDDSCDIY', 'IY', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'TDDSCD', 'Code', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'TDDSNM', 'Description', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'TDLGTH', 'Panjang Karakter', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'TDREMK', 'Remark', 100);
        fnCrtColGridDefault($this->GridObj, "TD");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'TDDSCD','direction'=>'asc');
        $this->GridColumns = [];

        $TBLDSC = TBLDSC::noLock()
                ->where([
                    ['TDDLFG', '=', '0'],
                  ]);

        $TBLDSC = fnQuerySearchAndPaginate($request, $TBLDSC, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $TBLDSC,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'TDDSCDIY');
        // dd($Hasil);
        return response()->jSon($Hasil);     

    }


    private $FormObj = [];

    public function FormObject(Request $request) {

        fnCrtObjTxt($this->FormObj, 0, "FF", "3", "Panel1", "TDDSCDIY", "IY", "", false);
        fnCrtObjTxt($this->FormObj, 1, "FF", "2", "Panel1", "TDDSCD", "Code", "", true, 0, 0, "Big");
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "TDDSNM", "Description", "", true);
        fnCrtObjNum($this->FormObj, 1, "FF", "0", "Panel1", "TDLGTH", "Length Character", "", false, 0, ""," Char", 1, 1, 20);
        fnCrtObjRad($this->FormObj, 1, "FF", "0", "Panel1", "TDDPFG", "Status", "", "1", "Radio", "DSPLY");
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "TDREMK", "Remark", "", false, 100);
            // fnUpdObj($this->FormObj, "TDREMK", array("Helper"=>'Terserah anda mau isi apa?'));

        fnCrtObjDefault($this->FormObj,"TD");    
        // dd($this->FormObj);

        return response()->jSon($this->FormObj);   
    }


    public function FillForm(Request $request) {
        $this->FormObject($request);
        $FillFormObject = $this->getFormObject($this->FormObj);
        // dd($FillFormObject);

        $TBLDSC = TBLDSC::noLock()
                ->select( $FillFormObject )
                ->where([
                    ['TDDSCDIY', '=', $request->TDDSCDIY],
                    // ['TDDSCDIY', '=', '1'],
                  ])->get();
        // dd($TBLDSC);

        $Hasil = $this->setFillForm(true, $TBLDSC, "");
        // dd($Hasil);
        return response()->jSon($Hasil);        

    }   



    public function SaveData (Request $request) {

        $Hasil = $this->doExecuteQuery( $request->AppUserName, "cTBLDSC@StpTBLDSC");  
        // $Hasil->message = ""; 
        // $Hasil = array("success"=> $BerHasil, "message"=> " Sukses... ".$message.$b);
        return response()->jSon($Hasil);

    }

    public function StpTBLDSC(Request $request) {


        $fTBLDSC = json_encode($request->frmTBLDSC);
        $fTBLDSC = json_decode($fTBLDSC, true);

        $Delimiter = "";
        $UnikNo = fnGenUnikNo($Delimiter);

        $HasilCheckBFCS = fnCheckBFCS (
                            array("Table"=>"TBLDSC", 
                                  "Key"=>"TDDSCDIY", 
                                  "Data"=>$fTBLDSC, 
                                  "Mode"=>$request->Mode,
                                  "Menu"=>"", 
                                  "FieldTransDate"=>""));
        if (!$HasilCheckBFCS["success"]) {
            return response()->jSon($HasilCheckBFCS);
        }

        $TBLUSR = $request->user();
        $UserName = $TBLUSR->TUUSER;
        // $UserName = $request->AppUserName;

        switch ($request->Mode) {
            case "1":
                $fTBLDSC['TDDSCDIY'] = fnTBLNOR('TBLDSC', $UserName);
                $FinalField = fnGetSintaxCRUD ($UserName, $fTBLDSC, 
                    '1', "TD", 
                    ['TDDSCDIY','TDDSCD','TDDSNM','TDLGTH','TDDPFG','TDREMK'], 
                    $UnikNo );
                DB::table('TBLDSC')->insert($FinalField);

                break;
            case "2":
                $FinalField = fnGetSintaxCRUD ($UserName, $fTBLDSC, 
                    '2', "TD", 
                    ['TDDSNM','TDLGTH','TDDPFG','TDREMK'], 
                    $UnikNo );
                DB::table('TBLDSC')
                    ->where('TDDSCDIY','=',$fTBLDSC['TDDSCDIY'])
                    ->update($FinalField);

                break;
            case "3":
                DB::table('TBLDSC')
                    ->where('TDDSCDIY','=',$fTBLDSC['TDDSCDIY'])      
                    ->delete();
                break;
        }


    }


    public function LoadGridXXXX(Request $request) {
        echo "Masuk<br>";


        $TBLDSC = TBLDSC::noLock()
                ->where([
                    ['TDDLFG', '=', '0'],
                  ])
                ->get();
        return response()->jSon($TBLDSC);  

        $TBLDSC = TBLDSC::noLock()
                ->where([
                    ['TDDLFG', '=', '0'],
                  ])
                ->get()->first()->tblsys;
        

    // public function scopeGetTableColumns() {
    //     return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    // }  

        $ABC = TBLDSC::getConnection()->get();
        dd($ABC);

        foreach ($TBLDSC as $key => $value) {
            # code...
            echo $key; echo $value; echo "<br>";
            print_r($TBLDSC[$key]);
            echo "<hr>";

            foreach ($TBLDSC[$key]->toArray() as $k => $v) {
                echo $k."-".$v." (".getType($v).") "; echo "<br>";
            }
        }
        echo "<hr>";
        $TBLDSC = TBLDSC::noLock()->find(1);
        echo $TBLDSC;

        echo "<hr>";
        $TBLDSC = TBLDSC::noLock()->get();
        dd($TBLDSC);

        return $TBLDSC;

        return response()->jSon($TBLDSC);    

    }

}
