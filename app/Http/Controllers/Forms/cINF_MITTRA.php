<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\MITTRA;
use DB;

class cINF_MITTRA extends cSOController {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'MTNOMRIY', 'IY', 100);
        fnCrtColGrid($this->GridObj, "dtp", 1, 1, '001', 'MTTRDT', 'Tanggal', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'MTTRNO', 'No Transaksi', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'MTLNNO', 'No Baris', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'MMITNO', 'Kode Barang', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'MMDESC', 'Nama Barang', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'MTMODL', 'Module', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'MTBEFQ', 'Qty Awal', 100, "", 2);
        fnCrtColGrid($this->GridObj, "num", 0, 0, '', 'MTQTYS', 'Qty', 100, "", 2);
        fnCrtColGrid($this->GridObj, "num", 0, 0, '', 'MTHARG', 'Harga', 100, "", 2);
        fnCrtColGrid($this->GridObj, "num", 0, 0, '', 'MTTOTL', 'Total', 100, "", 2);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'MTAFTQ', 'Qty Akhir', 100, "", 2);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'MTAVGO', 'Harga Rata Rata Lama', 100, "", 2);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'MTAVGN', 'Harga Rata Rata Baru', 100, "", 2);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'MTTMSX', 'Nomor', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'MTREMK', 'Keterangan', 100);
        fnCrtColGridDefault($this->GridObj, "MT");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'MTTRDT','direction'=>'desc');
        $this->GridSort[] = array('name'=>'MTTMSX','direction'=>'desc');
        $this->GridColumns = [];

        $MITTRA = MITTRA::noLock()
                ->leftJoin('MITMAS','MMITNOIY','MTITNOIY')
                ->where([
                    ['MTCOMPIY', '=', fnGetCompIY($request->AppCompanyCode)],
                    ['MTDLFG', '=', '0'],
                  ]);

        $MITTRA = fnQuerySearchAndPaginate($request, $MITTRA, 
                                           $this->GridObj, 
                                           $this->GridSort, 
                                           $this->GridFilter, 
                                           $this->GridColumns);

        $Hasil = array( "Data"=> $MITTRA,
                        "Column"=> $this->GridColumns,
                        "Sort"=> $this->GridSort,
                        "Filter"=> $this->GridFilter,
                        "Key"=> 'MTNOMRIY');
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
