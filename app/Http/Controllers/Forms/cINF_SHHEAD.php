<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\SHHEAD;
use DB;

class cINF_SHHEAD extends cSOController {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'SLSLNOIY', 'IY', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'SHSHNO', 'No Transaksi', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'SHNOTA', 'No Referensi', 100);
        fnCrtColGrid($this->GridObj, "dtp", 1, 1, '001', 'SHDATE', 'Tanggal', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'BPBPNO', 'Kode Pelanggan', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BPNAME', 'Nama Pelanggan', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'MMITNO', 'Kode Barang', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'MMDESC', 'Nama Barang', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'SLQTYS', 'Qty', 100, "", 2);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'SLHARG', 'Harga', 100, "", 2);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'SLTOTL', '@Total', 100, "", 2);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'SLREMK', 'Keterangan Detail', 100);
        fnCrtColGrid($this->GridObj, "num", 0, 0, '', 'SHSUBT', 'Sub Total', 100);
        fnCrtColGrid($this->GridObj, "num", 0, 0, '', 'SHEXCT', 'Slus/Minus', 100);
        fnCrtColGrid($this->GridObj, "num", 0, 0, '', 'SHTOTL', 'Total Keseluruhan', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'SHREMK', 'Keterangan', 100);
        fnCrtColGridDefault($this->GridObj, "SH");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'SHDATE','direction'=>'desc');
        $this->GridColumns = [];

        $SHHEAD = SHHEAD::noLock()
                ->leftJoin('MBPMAS', 'BPBPNOIY', 'SHBPNOIY')
                ->leftJoin('SHLINE', 'SLSHNOIY', 'SHSHNOIY')
                ->leftJoin('MITMAS','MMITNOIY','SLITNOIY')
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
                        "Key"=> 'SLSLNOIY');
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
