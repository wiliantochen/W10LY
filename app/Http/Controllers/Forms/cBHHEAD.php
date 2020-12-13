<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\BHHEAD;
use App\Models\BHLINE;
use DB;

class cBHHEAD extends cSOController {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'BHBHNOIY', 'IY', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BHBHNO', 'No Transaksi', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BHNOTA', 'No Referensi', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BHDESC', 'No Referensi', 100);
        fnCrtColGrid($this->GridObj, "dtp", 1, 1, '', 'BHDATE', 'Tanggal', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'BHTOTL', 'Total Keseluruhan', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BHREMK', 'Keterangan', 100);
        fnCrtColGridDefault($this->GridObj, "BH");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'BHDATE','direction'=>'desc');
        $this->GridColumns = [];

        $BHHEAD = BHHEAD::noLock()
                ->where([
                    ['BHCOMPIY', '=', fnGetCompIY($request->AppCompanyCode)],
                    ['BHDLFG', '=', '0'],
                  ]);

        $BHHEAD = fnQuerySearchAndPaginate($request, $BHHEAD, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $BHHEAD,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'BHBHNOIY');
        // dd($Hasil);
        return response()->jSon($Hasil);     

    }


    private $FormObj = [];

    public function FormObject(Request $request) {

        fnCrtObjTxt($this->FormObj, 0, "FF", "3", "Panel1", "BHBHNOIY", "IY", "", false);
        fnCrtObjTxt($this->FormObj, 1, "FF", "3", "Panel1", "BHBHNO", "No Transaksi", "", false);
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "BHNOTA", "No Referensi", "", false, "0", "30");   
        fnCrtObjDtp($this->FormObj, 1, "FF", "2", "Panel1", "BHDATE", "Tanggal Transaksi", "", true);         
        fnCrtObjNum($this->FormObj, 1, "FF", "3", "Panel1", "BHTOTL", "Total Keseluruhan", "", false, 0, "","IDR", 1);
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "BHREMK", "Keterangan", "", false, 100);
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "BHDESC", "Dekripsi", "", false, 100);

        fnCrtObjGrd($this->FormObj, 1, "XX", "0", "Panel5", "BHLINE", "Detail Biaya", true
                            , "AEDL", "BHHEAD", "LoadBHLINE");
            // fnUpdObj($this->FormObj, "BHREMK", array("Helper"=>'Terserah anda mau isi apa?'));

        // fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "BHDATE", "Description", "", true, 0, 0, "", "Awal", "Akhir");
        // fnCrtObjNum($this->FormObj, 1, "FF", "0", "Panel1", "BHBPNOIY", "Length Character", "", false, 2, "Num"," Char", 1, 1, 99);
        // fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "BHREMK", "Remark", "Everything You Want", false, 100);
        //     fnUpdObj($this->FormObj, "BHREMK", array("Helper"=>'Terserah anda mau isi apa?'));

        fnCrtObjDefault($this->FormObj,"BH");    
        // dd($this->FormObj);

        return response()->jSon($this->FormObj);   
    }


    public function FillForm(Request $request) {
        $this->FormObject($request);
        $FillFormObject = $this->getFormObject($this->FormObj);
        // dd($FillFormObject);

        $BHHEAD = BHHEAD::noLock()
                ->select( $FillFormObject )
                ->where([
                    ['BHBHNOIY', '=', $request->BHBHNOIY],
                    // ['BHBHNOIY', '=', '1'],
                  ])->get();
        // dd($BHHEAD);

        $BHHEAD[0]['BHLINE'] = fnFillGrid($this->LoadBHLINE($request));
        $Hasil = $this->setFillForm(true, $BHHEAD, "");
        // dd($Hasil);
        return response()->jSon($Hasil);        

    }   



    private $FormObjDetail = [];

    public function FormObjectDetail(Request $request) {

        fnCrtObjTxt($this->FormObjDetail, 0, "FF", "3", "Panel11", "BLBLNOIY", "Line IY", "", false);
        fnCrtObjTxt($this->FormObjDetail, 0, "FF", "3", "Panel11", "BLBHNOIY", "Head IY", "", false);
        fnCrtObjPop($this->FormObjDetail, 1, "FF", "2", "Panel11", "BLB2NOIY", "B2B2NO", "B2NAME", "Sub Kategori", "", true, "MB2MAS", true, 1);
        fnCrtObjTxt($this->FormObjDetail, 1, "FF", "0", "Panel11", "BLDESC", "Deskripsi", "", false);
        fnCrtObjNum($this->FormObjDetail, 1, "FF", "0", "Panel11", "BLTOTL", "Nilai", "", false, 0, "","IDR", 1);
        fnCrtObjRmk($this->FormObjDetail, 1, "FF", "0", "Panel11", "BLREMK", "Keterangan", "", false, 100);
            // fnUpdObj($this->FormObj, "BHREMK", array("Helper"=>'Terserah anda mau isi apa?'));


        return response()->jSon($this->FormObjDetail);   
    }

    public function LoadBHLINE(Request $request) {


        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'BLBLNOIY', 'Line IY', 100);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'BLBHNOIY', 'Head IY', 100);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'BLB2NOIY', 'Item IY', 100);
        // fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BLBLNO', 'Nomor', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'B2B2NO', 'Kode Sub Kategori', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 0, '', 'B2NAME', 'Nama Sub Kategori', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'BLTOTL', 'Nilai', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BLREMK', 'Keterangan', 100);

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        // fnCrtColGridDefault($this->GridObj, "TU");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'BLBLNOIY','direction'=>'asc');
        $this->GridColumns = [];

        $BHLINE = BHLINE::noLock()
                ->leftJoin('MB2MAS','B2B2NOIY','BLB2NOIY')
                ->where([
                    ['BLDLFG', '=', '0'],
                    ['BLBHNOIY', '=', $request->BHBHNOIY],
                  ]);

        $BHLINE = fnQuerySearchAndPaginate($request, $BHLINE, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $BHLINE,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'BLBLNOIY');
        // dd($Hasil);
        return response()->jSon($Hasil);     

    }


    public function SaveData (Request $request) {


        // $Hasil = fnSetExecuteQuery($SqlStm,$Delimiter);    
        $Hasil = $this->doExecuteQuery( $request->AppUserName, "cBHHEAD@StpBHHEAD");  
        // $Hasil->message = ""; 
        // $Hasil = array("success"=> $BerHasil, "message"=> " Sukses... ".$message.$b);
        return response()->jSon($Hasil);

    }


    public function StpBHHEAD(Request $request) {


        $fBHHEAD = json_encode($request->frmBHHEAD);
        $fBHHEAD = json_decode($fBHHEAD, true);

        $Delimiter = "";
        $UnikNo = fnGenUnikNo($Delimiter);

        $HasilCheckBFCS = fnCheckBFCS (
                            array("Table"=>"BHHEAD", 
                                  "Key"=>"BHBHNOIY", 
                                  "Data"=>$fBHHEAD, 
                                  "Mode"=>$request->Mode,
                                  "Menu"=>"", 
                                  "FieldTransDate"=>""));
        if (!$HasilCheckBFCS["success"]) {
            return response()->jSon($HasilCheckBFCS);
        }

        $UserName = $request->AppUserName;
        $fBHHEAD['BHCOMPIY'] = fnGetCompIY($request->AppCompanyCode);

        switch ($request->Mode) {
            case "1":
                $NO = DB::Table('BHHEAD')->max('BHBHNOIY');
                // $fBHHEAD['BHBHNO'] = 'CST/'.substr('0000000'.($NO+1),-6);
                // $fBHHEAD['BHBHNO'] = 'SALES/000025';

                $fBHHEAD['BHBHNO'] = fnTBLTRN($fBHHEAD['BHCOMPIY'], $UserName, 
                                        "BYA-".substr($fBHHEAD['BHDATE'],0,6),
                                        "BYA/".substr($fBHHEAD['BHDATE'],0,6)."/", 6);

                $fBHHEAD['BHBHNOIY'] = fnSYSNOR('BHHEAD', $UserName);
                $FinalField = fnGetSintaxCRUD ($UserName, $fBHHEAD, 
                    '1', "BH", 
                    ['BHCOMPIY','BHBHNOIY','BHBHNO','BHDATE','BHTOTL','BHREMK','BHNOTA','BHDESC'], 
                    $UnikNo );
                DB::table('BHHEAD')->insert($FinalField);


                $DataDetail = $fBHHEAD['BHLINE']; 
                foreach($DataDetail as $key => $value) {
                    $fBHLINE = $DataDetail[$key];
                    $fBHLINE['BLDESC'] = "";
                    $fBHLINE['BLBLNO'] = ($key+1);
                    $fBHLINE['BLBHNOIY'] = $fBHHEAD['BHBHNOIY'];
                    $fBHLINE['BLBLNOIY'] = fnSYSNOR('BHLINE', $UserName);
                    $FinalField = fnGetSintaxCRUD ($UserName, $fBHLINE, 
                        '1', "BL", 
                        ['BLBLNOIY','BLBLNO','BLBHNOIY','BLB2NOIY','BLDESC','BLTOTL','BLREMK'], 
                        $UnikNo );
                    DB::table('BHLINE')->insert($FinalField);
                } 


                $Hasil = array("success"=> true, "message"=> " No Transaksi : ".$fBHHEAD['BHBHNO']);
                return response()->jSon($Hasil);


                break;
            case "2":
                $FinalField = fnGetSintaxCRUD ($UserName, $fBHHEAD, 
                    '2', "BH", 
                    ['BHTOTL','BHREMK','BHNOTA','BHDESC'], 
                    $UnikNo );
                DB::table('BHHEAD')
                    ->where('BHBHNOIY','=',$fBHHEAD['BHBHNOIY'])                    
                    ->update($FinalField);

                DB::table('BHLINE')
                    ->where('BLBHNOIY','=',$fBHHEAD['BHBHNOIY'])      
                    ->delete();

                $DataDetail = $fBHHEAD['BHLINE']; 
                foreach($DataDetail as $key => $value) {
                    $fBHLINE = $DataDetail[$key];
                    $fBHLINE['BLDESC'] = "";      
                    $fBHLINE['BLBLNO'] = ($key+1);   
                    $fBHLINE['BLBHNOIY'] = $fBHHEAD['BHBHNOIY'];
                    $fBHLINE['BLBLNOIY'] = fnSYSNOR('BHLINE', $UserName);
                    $FinalField = fnGetSintaxCRUD ($UserName, $fBHLINE, 
                        '1', "BL", 
                        ['BLBLNOIY','BLBLNO','BLBHNOIY','BLB2NOIY','BLDESC','BLTOTL','BLREMK'], 
                        $UnikNo );
                    DB::table('BHLINE')->insert($FinalField);
                } 

                break;
            case "3":
                DB::table('BHLINE')
                    ->where('BLBHNOIY','=',$fBHHEAD['BHBHNOIY'])      
                    ->delete();
                DB::table('BHHEAD')
                    ->where('BHBHNOIY','=',$fBHHEAD['BHBHNOIY'])      
                    ->delete();
                break;
        }


    }


}
