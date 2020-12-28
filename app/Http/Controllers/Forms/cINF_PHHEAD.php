<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\PHHEAD;
use DB;

class cINF_PHHEAD extends cSOController {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'PLPLNOIY', 'IY', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'PHPHNO', 'No Transaksi', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'PHNOTA', 'No Referensi', 100);
        fnCrtColGrid($this->GridObj, "dtp", 1, 1, '001', 'PHDATE', 'Tanggal', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'BPBPNO', 'Kode Pemasok', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BPNAME', 'Nama Pemasok', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'MMITNO', 'Kode Barang', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'MMDESC', 'Nama Barang', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'PLQTYS', 'Qty', 100, "", 2);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'PLHARG', 'Harga', 100, "", 2);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'PLTOTL', '@Total', 100, "", 2);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'PLREMK', 'Keterangan Detail', 100);
        fnCrtColGrid($this->GridObj, "num", 0, 0, '', 'PHSUBT', 'Sub Total', 100);
        fnCrtColGrid($this->GridObj, "num", 0, 0, '', 'PHEXCT', 'Plus/Minus', 100);
        fnCrtColGrid($this->GridObj, "num", 0, 0, '', 'PHTOTL', 'Total Keseluruhan', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'PHREMK', 'Keterangan', 100);
        fnCrtColGridDefault($this->GridObj, "PH");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'PHDATE','direction'=>'desc');
        $this->GridColumns = [];

        $PHHEAD = PHHEAD::noLock()
                ->leftJoin('MBPMAS', 'BPBPNOIY', 'PHBPNOIY')
                ->leftJoin('PHLINE', 'PLPHNOIY', 'PHPHNOIY')
                ->leftJoin('MITMAS','MMITNOIY','PLITNOIY')
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
                        "Key"=> 'PLPLNOIY');
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
        $Hasil = array("success"=> false, 
                       "message"=> "No Action For This Menu ");
        return response()->jSon($Hasil); 
    }

    public function FillForm(Request $request) {
        $Hasil = array("success"=> false, 
                       "message"=> "No Action For This Menu ");
        return response()->jSon($Hasil);
    }   

    public function SaveData(Request $request) {
        $Hasil = array("success"=> false, 
                       "message"=> "No Action For This Menu ");
        return response()->jSon($Hasil);

    }


}
