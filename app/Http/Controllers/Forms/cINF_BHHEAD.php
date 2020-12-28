<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\BHHEAD;
use DB;

class cINF_BHHEAD extends cSOController {

    private $GridObj = [];
    private $GridFilter = [];
    private $GridSort = [];
    private $GridColumns = [];

    public function LoadGrid(Request $request) {

        fnCrtColGrid($this->GridObj, "act", 1, 0, '', 'ACTION', 'Action', 50);
        fnCrtColGrid($this->GridObj, "hdn", 1, 1, '', 'BLBLNOIY', 'IY', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BHBHNO', 'No Transaksi', 100);
        fnCrtColGrid($this->GridObj, "dtp", 1, 1, '001', 'BHDATE', 'Tanggal', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'B2NAME', 'Sub Kategori', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'B1NAME', 'Nama Kategori', 100);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BLDESC', 'Deskripsi', 100);
        fnCrtColGrid($this->GridObj, "num", 1, 1, '', 'BLTOTL', '@Total', 100, "", 2);
        fnCrtColGrid($this->GridObj, "txt", 1, 1, '', 'BLREMK', 'Keterangan Detail', 100);
        fnCrtColGrid($this->GridObj, "num", 0, 0, '', 'BHTOTL', 'Total Keseluruhan', 100);
        fnCrtColGrid($this->GridObj, "txt", 0, 0, '', 'BHREMK', 'Keterangan', 100);
        fnCrtColGridDefault($this->GridObj, "BH");

        $this->GridFilter = [];
        $this->GridSort = [];
        $this->GridSort[] = array('name'=>'BHDATE','direction'=>'desc');
        $this->GridColumns = [];

        $BHHEAD = BHHEAD::noLock()
                ->leftJoin('BHLINE', 'BLBHNOIY', 'BHBHNOIY')
                ->leftJoin('MB2MAS', 'B2B2NOIY', 'BLB2NOIY')
                ->leftJoin('MB1MAS', 'B1B1NOIY', 'B2B1NOIY')
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
                        "Key"=> 'BLBLNOIY');
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
