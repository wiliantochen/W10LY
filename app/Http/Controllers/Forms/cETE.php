<?php
namespace App\Http\Controllers\Forms;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
// use App\Models\TBLSYS;
// use App\Models\TBLDSC;
use App\Models\SYSCOM;
use App\Models\SYSTBL;
use App\Models\SYSDAT;
use App\Models\SYSNOR;
use DB;

class cETE extends cSOController {

    public function getData(Request $request) {
      /*
        ini dipanggil di file quasar (Auth-extportToExcel)
      */
      $pathFile = fnDecrypt($request->kunci)->path;

      $headers = ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
      return response()->download($pathFile, "DataGrid.xlsx", $headers);

    }

}
