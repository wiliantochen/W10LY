<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\SHHEAD;
use App\Models\SHLINE;
use DB;

class cSHHEAD extends cSOController {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'SHSHNOIY', 'IY', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'SHSHNO', 'No Transaksi', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'SHNOTA', 'No Referensi', 100);
        fnCrtColGrid($this->GridObj, "dtp", 1, 1, '', 'SHDATE', 'Tanggal', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BPBPNO', 'Kode Plg', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BPNAME', 'Nama Plg', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'SHSUBT', 'Sub Total', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'SHEXCT', 'Plus/Minus', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'SHTOTL', 'Total Keseluruhan', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'SHREMK', 'Keterangan', 100);
        fnCrtColGridDefault($this->GridObj, "SH");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'SHDATE','direction'=>'desc');
        $this->GridColumns = [];

        $SHHEAD = SHHEAD::noLock()
                ->leftJoin('MBPMAS', 'BPBPNOIY', 'SHBPNOIY')
                ->where([
                    ['SHCOMPIY', '=', fnGetCompIY($request->AppCompanyCode)],
                    ['SHDLFG', '=', '0'],
                  ]);

        $SHHEAD = fnQuerySearchAndPaginate($request, $SHHEAD, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $SHHEAD,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'SHSHNOIY');
        // dd($Hasil);
        return response()->jSon($Hasil);     

    }


    private $FormObj = [];

    public function FormObject(Request $request) {

        fnCrtObjTxt($this->FormObj, 0, "FF", "3", "Panel1", "SHSHNOIY", "IY", "", false);
        fnCrtObjTxt($this->FormObj, 1, "FF", "3", "Panel1", "SHSHNO", "No Transaksi", "", false);
        fnCrtObjDtp($this->FormObj, 1, "FF", "2", "Panel1", "SHDATE", "Tanggal Transaksi", "", true);     
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "SHNOTA", "No Referensi", "", false, "0", "30");       
        fnCrtObjRad($this->FormObj, 1, "FF", "2", "Panel1", "SHTYPE", "Tipe Transaksi", "", "T", "Radio", "CC");
        fnCrtObjPop($this->FormObj, 1, "FF", "2", "Panel1", "SHBPNOIY", "BPBPNO", "BPNAME", "Pelanggan", "", true, "MBPMAS", true, 1);
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "SHADDR", "Alamat", "", false, 100);
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "SHCITY", "Kota", "", false, 0, 100);
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "SHTELP", "Telepon", "", false, 0, 100);
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "SHCPER", "KOntak Personal", "", false, 0, 100);

        fnCrtObjNum($this->FormObj, 1, "FF", "3", "Panel1", "SHSUBT", "Sub Total", "", false, 0, "","IDR", 1);
        fnCrtObjNum($this->FormObj, 1, "FF", "0", "Panel1", "SHEXCT", "Plus / Minus", "", false, 0, "","IDR", 1);
        fnCrtObjNum($this->FormObj, 1, "FF", "3", "Panel1", "SHTOTL", "Total Keseluruhan", "", false, 0, "","IDR", 1);
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "SHREMK", "Keterangan", "", false, 100);

        fnCrtObjGrd($this->FormObj, 1, "XX", "0", "Panel5", "SHLINE", "Detail Penjualan", true
                            , "AEDL", "SHHEAD", "LoadSHLINE");
            // fnUpdObj($this->FormObj, "SHREMK", array("Helper"=>'Terserah anda mau isi apa?'));

        // fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "SHDATE", "Description", "", true, 0, 0, "", "Awal", "Akhir");
        // fnCrtObjNum($this->FormObj, 1, "FF", "0", "Panel1", "SHBPNOIY", "Length Character", "", false, 2, "Num"," Char", 1, 1, 99);
        // fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "SHREMK", "Remark", "Everything You Want", false, 100);
        //     fnUpdObj($this->FormObj, "SHREMK", array("Helper"=>'Terserah anda mau isi apa?'));

        fnCrtObjDefault($this->FormObj,"SH");    
        // dd($this->FormObj);

        return response()->jSon($this->FormObj);   
    }


    public function FillForm(Request $request) {
        $this->FormObject($request);
        $FillFormObject = $this->getFormObject($this->FormObj);
        // dd($FillFormObject);

        $SHHEAD = SHHEAD::noLock()
                ->select( $FillFormObject )
                ->leftJoin('MBPMAS', 'BPBPNOIY', 'SHBPNOIY')
                ->where([
                    ['SHSHNOIY', '=', $request->SHSHNOIY],
                    // ['SHSHNOIY', '=', '1'],
                  ])->get();
        // dd($SHHEAD);

        $SHHEAD[0]['SHLINE'] = fnFillGrid($this->LoadSHLINE($request));
        $Hasil = $this->setFillForm(true, $SHHEAD, "");
        // dd($Hasil);
        return response()->jSon($Hasil);        

    }   



    private $FormObjDetail = [];

    public function FormObjectDetail(Request $request) {

        fnCrtObjTxt($this->FormObjDetail, 0, "FF", "3", "Panel11", "SLSLNOIY", "Line IY", "", false);
        fnCrtObjTxt($this->FormObjDetail, 0, "FF", "3", "Panel11", "SLSHNOIY", "Head IY", "", false);
        // fnCrtObjTxt($this->FormObjDetail, 0, "FF", "3", "Panel11", "SLITNOIY", "Item IY", "", false);
        fnCrtObjPop($this->FormObjDetail, 1, "FF", "2", "Panel11", "SLITNOIY", "MMITNO", "MMDESC", "Barang", "", true, "MITMAS", true, 1);
        fnCrtObjNum($this->FormObjDetail, 1, "FF", "0", "Panel11", "SLQTYS", "Qty", "", false, 0, "","", 1);
        fnCrtObjNum($this->FormObjDetail, 1, "FF", "0", "Panel11", "SLHARG", "Harga", "", false, 0, "","IDR", 1);
        fnCrtObjNum($this->FormObjDetail, 1, "FF", "3", "Panel11", "SLTOTL", "Total", "", false, 0, "","IDR", 1);
        fnCrtObjRmk($this->FormObjDetail, 1, "FF", "0", "Panel11", "SLREMK", "Keterangan", "", false, 100);
            // fnUpdObj($this->FormObj, "SHREMK", array("Helper"=>'Terserah anda mau isi apa?'));


        return response()->jSon($this->FormObjDetail);   
    }

    public function LoadSHLINE(Request $request) {


        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'SLSLNOIY', 'Line IY', 100);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'SLSHNOIY', 'Head IY', 100);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'SLITNOIY', 'Item IY', 100);
        // fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'SLSLNO', 'Nomor', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'MMITNO', 'Kode Brg', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 0, '', 'MMDESC', 'Nama Brg', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'SLQTYS', 'Qty', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'SLHARG', 'Harga', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'SLTOTL', 'Total', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'SLREMK', 'Keterangan', 100);

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        // fnCrtColGridDefault($this->GridObj, "TU");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'SLSLNOIY','direction'=>'asc');
        $this->GridColumns = [];

        $SHLINE = SHLINE::noLock()
                ->leftJoin('MITMAS','MMITNOIY','SLITNOIY')
                ->where([
                    ['SLDLFG', '=', '0'],
                    ['SLSHNOIY', '=', $request->SHSHNOIY],
                  ]);

        $SHLINE = fnQuerySearchAndPaginate($request, $SHLINE, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $SHLINE,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'SLSLNOIY');
        // dd($Hasil);
        return response()->jSon($Hasil);     

    }


    public function SaveData (Request $request) {


        // $Hasil = fnSetExecuteQuery($SqlStm,$Delimiter);    
        $Hasil = $this->doExecuteQuery( $request->AppUserName, "cSHHEAD@StpSHHEAD");  
        // $Hasil->message = ""; 
        // $Hasil = array("success"=> $BerHasil, "message"=> " Sukses... ".$message.$b);
        return response()->jSon($Hasil);

    }


    public function StpSHHEAD(Request $request) {


        $fSHHEAD = json_encode($request->frmSHHEAD);
        $fSHHEAD = json_decode($fSHHEAD, true);

        $Delimiter = "";
        $UnikNo = fnGenUnikNo($Delimiter);

        $HasilCheckBFCS = fnCheckBFCS (
                            array("Table"=>"SHHEAD", 
                                  "Key"=>"SHSHNOIY", 
                                  "Data"=>$fSHHEAD, 
                                  "Mode"=>$request->Mode,
                                  "Menu"=>"", 
                                  "FieldTransDate"=>""));
        if (!$HasilCheckBFCS["success"]) {
            return response()->jSon($HasilCheckBFCS);
        }

        $UserName = $request->AppUserName;
        $fSHHEAD['SHCOMPIY'] = fnGetCompIY($request->AppCompanyCode);

        switch ($request->Mode) {
            case "1":
                $NO = DB::Table('SHHEAD')->max('SHSHNOIY');
                // $fSHHEAD['SHSHNO'] = 'SLS/'.substr('0000000'.($NO+1),-6);
                // $fSHHEAD['SHSHNO'] = 'SALES/000025';

                $fSHHEAD['SHSHNO'] = fnTBLTRN($fSHHEAD['SHCOMPIY'], $UserName, 
                                        "SLS-".substr($fSHHEAD['SHDATE'],0,6),
                                        "SLS/".substr($fSHHEAD['SHDATE'],0,6)."/", 6);

                $fSHHEAD['SHSHNOIY'] = fnSYSNOR('SHHEAD', $UserName);
                $FinalField = fnGetSintaxCRUD ($UserName, $fSHHEAD, 
                    '1', "SH", 
                    ['SHCOMPIY','SHSHNOIY','SHSHNO','SHDATE','SHTYPE','SHBPNOIY','SHADDR','SHCITY','SHTELP','SHCPER','SHSUBT','SHEXCT','SHTOTL','SHREMK','SHNOTA'], 
                    $UnikNo );
                DB::table('SHHEAD')->insert($FinalField);


                $DataDetail = $fSHHEAD['SHLINE']; 
                foreach($DataDetail as $key => $value) {
                    $fSHLINE = $DataDetail[$key];
                    $fSHLINE['SLDESC'] = "";
                    $fSHLINE['SLSLNO'] = ($key+1);
                    $fSHLINE['SLSHNOIY'] = $fSHHEAD['SHSHNOIY'];
                    $fSHLINE['SLSLNOIY'] = fnSYSNOR('SHLINE', $UserName);
                    $FinalField = fnGetSintaxCRUD ($UserName, $fSHLINE, 
                        '1', "SL", 
                        ['SLSLNOIY','SLSLNO','SLSHNOIY','SLITNOIY','SLDESC','SLQTYS','SLHARG','SLTOTL','SLREMK'], 
                        $UnikNo );
                    DB::table('SHLINE')->insert($FinalField);
                } 

                DB::select("call StpProsesMittraByTransaksi('".$UserName."','".$fSHHEAD['SHCOMPIY']."','SLS','".$fSHHEAD['SHSHNOIY']."','')");

                $Hasil = array("success"=> true, "message"=> " No Transaksi : ".$fSHHEAD['SHSHNO']);
                return response()->jSon($Hasil);

                break;
            case "2":
                $FinalField = fnGetSintaxCRUD ($UserName, $fSHHEAD, 
                    '2', "SH", 
                    ['SHBPNOIY','SHADDR','SHCITY','SHTELP','SHCPER','SHSUBT','SHEXCT','SHTOTL','SHREMK','SHNOTA'], 
                    $UnikNo );
                DB::table('SHHEAD')
                    ->where('SHSHNOIY','=',$fSHHEAD['SHSHNOIY'])                    
                    ->update($FinalField);

                DB::table('SHLINE')
                    ->where('SLSHNOIY','=',$fSHHEAD['SHSHNOIY'])      
                    ->delete();

                $DataDetail = $fSHHEAD['SHLINE']; 
                foreach($DataDetail as $key => $value) {
                    $fSHLINE = $DataDetail[$key];
                    $fSHLINE['SLDESC'] = "";         
                    $fSHLINE['SLSLNO'] = ($key+1);           
                    $fSHLINE['SLSHNOIY'] = $fSHHEAD['SHSHNOIY'];
                    $fSHLINE['SLSLNOIY'] = fnSYSNOR('SHLINE', $UserName);
                    $FinalField = fnGetSintaxCRUD ($UserName, $fSHLINE, 
                        '1', "SL", 
                        ['SLSLNOIY','SLSLNO','SLSHNOIY','SLITNOIY','SLDESC','SLQTYS','SLHARG','SLTOTL','SLREMK'], 
                        $UnikNo );
                    DB::table('SHLINE')->insert($FinalField);
                } 

                DB::select("call StpProsesMittraByTransaksi('".$UserName."','".$fSHHEAD['SHCOMPIY']."','SLS','".$fSHHEAD['SHSHNOIY']."','')");
                break;
            case "3":
                DB::table('SHLINE')
                    ->where('SLSHNOIY','=',$fSHHEAD['SHSHNOIY'])      
                    ->update(array('SLDLFG'=>'1'));
                DB::table('SHHEAD')
                    ->where('SHSHNOIY','=',$fSHHEAD['SHSHNOIY'])      
                    ->update(array('SHDLFG'=>'1'));
                DB::select("call StpProsesMittraByTransaksi('".$UserName."','".$fSHHEAD['SHCOMPIY']."','SLS','".$fSHHEAD['SHSHNOIY']."','')");
                break;
        }


    }


}
