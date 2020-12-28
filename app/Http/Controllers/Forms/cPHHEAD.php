<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\PHHEAD;
use App\Models\PHLINE;
use DB;
use Codedge\Fpdf\Facades\Fpdf;

class cPHHEAD extends cSOController {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'PHPHNOIY', 'IY', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'PHPHNO', 'No Transaksi', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'PHNOTA', 'No Referensi', 100);
        fnCrtColGrid($this->GridObj, "dtp", 1, 1, '', 'PHDATE', 'Tanggal', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BPBPNO', 'Kode Plg', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BPNAME', 'Nama Plg', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'PHSUBT', 'Sub Total', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'PHEXCT', 'Plus/Minus', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'PHTOTL', 'Total Keseluruhan', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'PHREMK', 'Keterangan', 100);
        fnCrtColGridDefault($this->GridObj, "PH");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'PHDATE','direction'=>'desc');
        $this->GridColumns = [];

        $PHHEAD = PHHEAD::noLock()
                ->leftJoin('MBPMAS', 'BPBPNOIY', 'PHBPNOIY')
                ->where([
                    ['PHCOMPIY', '=', fnGetCompIY($request->AppCompanyCode)],
                    ['PHDLFG', '=', '0'],
                  ]);

        $PHHEAD = fnQuerySearchAndPaginate($request, $PHHEAD, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $PHHEAD,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'PHPHNOIY');
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

        fnCrtObjTxt($this->FormObj, 0, "FF", "3", "Panel1", "PHPHNOIY", "IY", "", false);
        fnCrtObjTxt($this->FormObj, 1, "FF", "3", "Panel1", "PHPHNO", "No Transaksi", "", false);
        fnCrtObjDtp($this->FormObj, 1, "FF", "2", "Panel1", "PHDATE", "Tanggal Transaksi", "", true);   
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "PHNOTA", "No Referensi", "", false, "0", "30");        
        fnCrtObjRad($this->FormObj, 1, "FF", "2", "Panel1", "PHTYPE", "Tipe Transaksi", "", "T", "Radio", "CC");
        fnCrtObjPop($this->FormObj, 1, "FF", "2", "Panel1", "PHBPNOIY", "BPBPNO", "BPNAME", "Pemasuk", "", true, "MBPMAS", true, 1);
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "PHADDR", "Alamat", "", false, 100);
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "PHCITY", "Kota", "", false, 0, 100);
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "PHTELP", "Telepon", "", false, 0, 100);
        fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "PHCPER", "KOntak Personal", "", false, 0, 100);

        fnCrtObjNum($this->FormObj, 1, "FF", "3", "Panel1", "PHSUBT", "Sub Total", "", false, 0, "","IDR", 1);
        fnCrtObjNum($this->FormObj, 1, "FF", "0", "Panel1", "PHEXCT", "Plus / Minus", "", false, 0, "","IDR", 1);
        fnCrtObjNum($this->FormObj, 1, "FF", "3", "Panel1", "PHTOTL", "Total Keseluruhan", "", false, 0, "","IDR", 1);
        fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "PHREMK", "Keterangan", "", false, 100);

        fnCrtObjGrd($this->FormObj, 1, "XX", "0", "Panel5", "PHLINE", "Detail Pembelian", true
                            , "AEDL", "PHHEAD", "LoadPHLINE");
            // fnUpdObj($this->FormObj, "PHREMK", array("Helper"=>'Terserah anda mau isi apa?'));

        // fnCrtObjTxt($this->FormObj, 1, "FF", "0", "Panel1", "PHDATE", "Description", "", true, 0, 0, "", "Awal", "Akhir");
        // fnCrtObjNum($this->FormObj, 1, "FF", "0", "Panel1", "PHBPNOIY", "Length Character", "", false, 2, "Num"," Char", 1, 1, 99);
        // fnCrtObjRmk($this->FormObj, 1, "FF", "0", "Panel1", "PHREMK", "Remark", "Everything You Want", false, 100);
        //     fnUpdObj($this->FormObj, "PHREMK", array("Helper"=>'Terserah anda mau isi apa?'));

        fnCrtObjDefault($this->FormObj,"PH");    
        // dd($this->FormObj);

        return response()->jSon($this->FormObj);   
    }


    public function FillForm(Request $request) {
        $this->FormObject($request);
        $FillFormObject = $this->getFormObject($this->FormObj);
        // dd($FillFormObject);

        $PHHEAD = PHHEAD::noLock()
                ->select( $FillFormObject )
                ->leftJoin('MBPMAS', 'BPBPNOIY', 'PHBPNOIY')
                ->where([
                    ['PHPHNOIY', '=', $request->PHPHNOIY],
                    // ['PHPHNOIY', '=', '1'],
                  ])->get();
        // dd($PHHEAD);

        $PHHEAD[0]['PHLINE'] = fnFillGrid($this->LoadPHLINE($request));
        $Hasil = $this->setFillForm(true, $PHHEAD, "");
        // dd($Hasil);
        return response()->jSon($Hasil);        

    }   



    private $FormObjDetail = [];

    public function FormObjectDetail(Request $request) {

        fnCrtObjTxt($this->FormObjDetail, 0, "FF", "3", "Panel11", "PLPLNOIY", "Line IY", "", false);
        fnCrtObjTxt($this->FormObjDetail, 0, "FF", "3", "Panel11", "PLPHNOIY", "Head IY", "", false);
        // fnCrtObjTxt($this->FormObjDetail, 0, "FF", "3", "Panel11", "PLITNOIY", "Item IY", "", false);
        fnCrtObjPop($this->FormObjDetail, 1, "FF", "2", "Panel11", "PLITNOIY", "MMITNO", "MMDESC", "Barang", "", true, "MITMAS", true, 1);
        fnCrtObjNum($this->FormObjDetail, 1, "FF", "0", "Panel11", "PLQTYS", "Qty", "", false, 0, "","", 1);
        fnCrtObjNum($this->FormObjDetail, 1, "FF", "0", "Panel11", "PLHARG", "Harga", "", false, 0, "","IDR", 1);
        fnCrtObjNum($this->FormObjDetail, 1, "FF", "3", "Panel11", "PLTOTL", "Total", "", false, 0, "","IDR", 1);
        fnCrtObjRmk($this->FormObjDetail, 1, "FF", "0", "Panel11", "PLREMK", "Keterangan", "", false, 100);
            // fnUpdObj($this->FormObj, "PHREMK", array("Helper"=>'Terserah anda mau isi apa?'));


        return response()->jSon($this->FormObjDetail);   
    }

    public function LoadPHLINE(Request $request) {


        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'PLPLNOIY', 'Line IY', 100);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'PLPHNOIY', 'Head IY', 100);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'PLITNOIY', 'Item IY', 100);
        // fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'PLPLNO', 'Nomor', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'MMITNO', 'Kode Brg', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 0, '', 'MMDESC', 'Nama Brg', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'PLQTYS', 'Qty', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'PLHARG', 'Harga', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'PLTOTL', 'Total', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'PLREMK', 'Keterangan', 100);

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        // fnCrtColGridDefault($this->GridObj, "TU");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'PLPLNOIY','direction'=>'asc');
        $this->GridColumns = [];

        $PHLINE = PHLINE::noLock()
                ->leftJoin('MITMAS','MMITNOIY','PLITNOIY')
                ->where([
                    ['PLDLFG', '=', '0'],
                    ['PLPHNOIY', '=', $request->PHPHNOIY],
                  ]);

        $PHLINE = fnQuerySearchAndPaginate($request, $PHLINE, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $PHLINE,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'PLPLNOIY');
        // dd($Hasil);
        return response()->jSon($Hasil);     

    }


    public function SaveData (Request $request) {


        // $Hasil = fnSetExecuteQuery($SqlStm,$Delimiter);    
        $Hasil = $this->doExecuteQuery( $request->AppUserName, "cPHHEAD@StpPHHEAD");  
        // $Hasil->message = ""; 
        // $Hasil = array("success"=> $BerHasil, "message"=> " Sukses... ".$message.$b);
        return response()->jSon($Hasil);

    }


    public function StpPHHEAD(Request $request) {


        $fPHHEAD = json_encode($request->frmPHHEAD);
        $fPHHEAD = json_decode($fPHHEAD, true);

        $Delimiter = "";
        $UnikNo = fnGenUnikNo($Delimiter);

        $HasilCheckBFCS = fnCheckBFCS (
                            array("Table"=>"PHHEAD", 
                                  "Key"=>"PHPHNOIY", 
                                  "Data"=>$fPHHEAD, 
                                  "Mode"=>$request->Mode,
                                  "Menu"=>"", 
                                  "FieldTransDate"=>""));
        if (!$HasilCheckBFCS["success"]) {
            return response()->jSon($HasilCheckBFCS);
        }

        $TBLUSR = $request->user();
        $UserName = $TBLUSR->TUUSER;
        $fPHHEAD['PHCOMPIY'] = $TBLUSR->TUCOMPIY;
        // $UserName = $request->AppUserName;
        // $fPHHEAD['PHCOMPIY'] = fnGetCompIY($request->AppCompanyCode);

        switch ($request->Mode) {
            case "1":
                $NO = DB::Table('PHHEAD')->max('PHPHNOIY');
                // $fPHHEAD['PHPHNO'] = 'PCH/'.substr('0000000'.($NO+1),-6);
                // $fPHHEAD['PHPHNO'] = 'SALES/000025';

                $fPHHEAD['PHPHNO'] = fnTBLTRN($fPHHEAD['PHCOMPIY'], $UserName, 
                                        "PCH-".substr($fPHHEAD['PHDATE'],0,6),
                                        "PCH/".substr($fPHHEAD['PHDATE'],0,6)."/", 6);

                $fPHHEAD['PHPHNOIY'] = fnSYSNOR('PHHEAD', $UserName);
                $FinalField = fnGetSintaxCRUD ($UserName, $fPHHEAD, 
                    '1', "PH", 
                    ['PHCOMPIY','PHPHNOIY','PHPHNO','PHDATE','PHTYPE','PHBPNOIY','PHADDR','PHCITY','PHTELP','PHCPER','PHSUBT','PHEXCT','PHTOTL','PHREMK','PHNOTA'], 
                    $UnikNo );
                DB::table('PHHEAD')->insert($FinalField);


                $DataDetail = $fPHHEAD['PHLINE']; 
                foreach($DataDetail as $key => $value) {
                    $fPHLINE = $DataDetail[$key];
                    $fPHLINE['PLDESC'] = "";
                    $fPHLINE['PLPLNO'] = ($key+1);
                    $fPHLINE['PLPHNOIY'] = $fPHHEAD['PHPHNOIY'];
                    $fPHLINE['PLPLNOIY'] = fnSYSNOR('PHLINE', $UserName);
                    $FinalField = fnGetSintaxCRUD ($UserName, $fPHLINE, 
                        '1', "PL", 
                        ['PLPLNOIY','PLPLNO','PLPHNOIY','PLITNOIY','PLDESC','PLQTYS','PLHARG','PLTOTL','PLREMK'], 
                        $UnikNo );
                    DB::table('PHLINE')->insert($FinalField);
                } 

                DB::select("call StpProsesMittraByTransaksi('".$UserName."','".$fPHHEAD['PHCOMPIY']."','PCH','".$fPHHEAD['PHPHNOIY']."','')");

                $Hasil = array("success"=> true, "message"=> " No Transaksi : ".$fPHHEAD['PHPHNO']);
                return response()->jSon($Hasil);


                break;
            case "2":
                $FinalField = fnGetSintaxCRUD ($UserName, $fPHHEAD, 
                    '2', "PH", 
                    ['PHBPNOIY','PHADDR','PHCITY','PHTELP','PHCPER','PHSUBT','PHEXCT','PHTOTL','PHREMK','PHNOTA'], 
                    $UnikNo );
                DB::table('PHHEAD')
                    ->where('PHPHNOIY','=',$fPHHEAD['PHPHNOIY'])                    
                    ->update($FinalField);

                DB::table('PHLINE')
                    ->where('PLPHNOIY','=',$fPHHEAD['PHPHNOIY'])      
                    ->delete();

                $DataDetail = $fPHHEAD['PHLINE']; 
                foreach($DataDetail as $key => $value) {
                    $fPHLINE = $DataDetail[$key];
                    $fPHLINE['PLDESC'] = "";                    
                    $fPHLINE['PLPLNO'] = ($key+1);
                    $fPHLINE['PLPHNOIY'] = $fPHHEAD['PHPHNOIY'];
                    $fPHLINE['PLPLNOIY'] = fnSYSNOR('PHLINE', $UserName);
                    $FinalField = fnGetSintaxCRUD ($UserName, $fPHLINE, 
                        '1', "PL", 
                        ['PLPLNOIY','PLPLNO','PLPHNOIY','PLITNOIY','PLDESC','PLQTYS','PLHARG','PLTOTL','PLREMK'], 
                        $UnikNo );
                    DB::table('PHLINE')->insert($FinalField);
                } 
                DB::select("call StpProsesMittraByTransaksi('".$UserName."','".$fPHHEAD['PHCOMPIY']."','PCH','".$fPHHEAD['PHPHNOIY']."','')");

                break;
            case "3":
                DB::table('PHLINE')
                    ->where('PLPHNOIY','=',$fPHHEAD['PHPHNOIY'])      
                    ->update(array('PLDLFG'=>'1'));
                DB::table('PHHEAD')
                    ->where('PHPHNOIY','=',$fPHHEAD['PHPHNOIY'])      
                    ->update(array('PHDLFG'=>'1'));
                DB::select("call StpProsesMittraByTransaksi('".$UserName."','".$fPHHEAD['PHCOMPIY']."','PCH','".$fPHHEAD['PHPHNOIY']."','')");
                break;
        }


    }

    public function PrintForm(Request $request) {    
        
        $pathFile = storage_path(). '/recipe.pdf';
        Fpdf::AddPage();
        Fpdf::SetFont('Courier', 'B', 18);
        Fpdf::Cell(50, 25, 'Hello World!');
        // Fpdf::Output();
        Fpdf::Output('F', $pathFile);
        $headers = ['Content-Type' => 'application/pdf'];
        return response()->file($pathFile, $headers);


    }   

}
