<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use DB;
use Illuminate\Support\Facades\Storage as Storage;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class cSOController extends Controller 
{
	

    public function getFormObject($FormObj, $Tipe="") {
      switch ($Tipe) {
        case '1':
          break;        
        default:
          $Hasil = array_filter(array_keys($FormObj), function ($k) use($FormObj) { return $FormObj[$k]['FFTipe'] === "FF"; }); 
          $a = array_filter($FormObj, function ($k) { return $k['Tipe'] === "pop"; }); 
          foreach ($a as $k => $o) {
                array_push($Hasil, $o['PopCode']);
                array_push($Hasil, $o['PopDesc']);
          }
          // dd($Hasil);
          break;
      }
      return $Hasil;

    }


    public function setFillForm($Sukses, $Hasil, $Message) {   
        if ($Hasil == "") {
            $Data = [];
        } else {
            $Data = $Hasil->count() != 0 ? $Hasil[0] : [];
        }
        return array( "success"=> $Sukses, "data"=> $Data, "message"=> $Message);
    }

    public function doExecuteQuery($UserName, $cm) {

        $Hasil = fnSetExecuteQuery($UserName, $cm); 
        // return $Hasil;

        if(!$Hasil['success']) {
          if (!isset($Hasil['eCode'])) {
            $Data = ["success"=>false,
                     "message"=>$Hasil['message'],
                     "code"=>"", ];
          } else {
            $Data = ["success"=>false,
                     "message"=>$this->getErrorMessage($Hasil['eCode']),
                     "code"=>$Hasil['eCode']['error_code'], ];
          }
        } else {
          $Data = ["success"=>true,
                   "message"=>$Hasil['message'],
                   "code"=>"", ];
        }
        return $Data;

    }

    public function getErrorMessage($err) {
        $msg = "";
        switch ($err['error_code']) {
            case "1406":
            case "22001":
                $msg = "[Field] Data value is too long";
                break;
            case "1062":
            case "23000":
                $msg = "[Primary Key] Duplicate Data, Please check again!!!";
                break;
            default:
                // $trace = $err->getTrace();
                // $message =  $err->getMessage().' in '.$err->getFile().' on line '.$err->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
                $msg = $err['message'];
                break;
        }
        return $msg;
    }

    public function prosesMittra($TRDT, $ITNOIY) {
        $SHLINE = DB::table('SHLINE')
                    ->select('SLITNOIY As MTITNOIY',
                             '-1*SLQTYS As MTQTYS',
                             'SLHARG As MTHARG',
                             'SLTOTL As MTTOTL'
                             )
                    ->leftJoin('SHHEAD','SHSHNOIY','SLSHNOIY')
                    ->where(function($query) use($TRDT, $ITNOIY) {
                        if ($TRDT != "") {
                          $query->where('SHDATE','>=', $TRDT);
                        }
                        if ($ITNOIY != "") {
                          $query->where('SLITNOIY',$ITNOIY);
                        }
                    });
        // dd($SHLINE->get());

        $PHLINE = DB::table('PHLINE')
                    ->select('PLITNOIY As MTITNOIY',                          
                             'PLQTYS As MTQTYS',
                             'PLHARG As MTHARG',
                             'PLTOTL As MTTOTL')
                    ->leftJoin('PHHEAD','PHPHNOIY','PLPHNOIY')
                    ->where(function($query) use($TRDT, $ITNOIY) {
                        if ($TRDT != "") {
                          $query->where('PHDATE','>=', $TRDT);
                        }
                        if ($ITNOIY != "") {
                          $query->where('PLITNOIY',$ITNOIY);
                        }
                    });
        // dd($PHLINE->get());

        $A = $SHLINE->unionall($PHLINE);
        dd($A->get());

    }

    public function ExportToExcel($Hasil) {
      $d = date('YmdHis'); //dd($d);

      $excelKolom = ",A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z";
      $arrExcelKolom = explode(",",$excelKolom);
        for($i=1; $i<27; $i++){ 
          $kolom = $arrExcelKolom[$i];
          for($A=1; $A<27; $A++){ 
            $arrExcelKolom[] = $kolom.$arrExcelKolom[$A];
        }     
      } 
      // dd($arrExcelKolom);

      // dd($Hasil);
      // dd($Hasil['Column']);
      // dd($Hasil['Data']);


if (1==0) {
      $directory = storage_path(). '/tempExcel/';

      // Open a directory, and read its contents
      if (is_dir($directory)){
        if ($opendirectory = opendir($directory)){
          while (($file = readdir($opendirectory)) !== false){
            if (strpos($file, 'GridETE')>1) {
              if (substr($file,0,8) != substr($d,0,8) ) {
                echo "masuk4".$directory.$file."<br>";
                // unlink($directory.$file);
              }
            }
          }
          closedir($opendirectory);
        }
      }
  dd('Hapus Done');
}

if (1==0) {
      // echo count($Hasil['Column']);
      foreach($Hasil['Column'] as $colkey => $columns) {
        if ($columns['tipe']!="act") {
          $c = $colkey+1;
          $cr = $arrExcelKolom[$c]."1";
          echo $cr." ==> ".$columns['label'];
          echo "<br>";
        }
      }
      echo "<hr>";
      foreach ($Hasil['Data'] as $rowkey => $rows) {
          // echo "{$rowkey} => {$rows} <br>";
          foreach($Hasil['Column'] as $colkey => $columns) {
            if ($columns['tipe']!="act") {
            // echo "{$colkey} => {$columns} <br>";
              // echo $r[$c['name']];
              // echo $rowkey."-".$colkey;
              $c = $colkey+1;
              $r = $rowkey+2;
              $cr = $arrExcelKolom[$c].$r;
              echo $cr." ==> ".$rows[$columns['name']];
              // $sheet->setCellValue($cr, $rows[$columns['name']]);

              switch (strtoupper($columns['label'])) {
                case "ENTRY DATE":
                case "CHANGE DATE":
                case "CHANGE SYSTEM DATE":
                  echo "xxxxx";
                  // echo date_format($rows[$columns['name']], 'd-f-Y h:i:s');
                  echo date("d-M-Y h:i:s", strtotime($rows[$columns['name']]) );
                  break;
              }

              switch (strtoupper($columns['tipe'])) {
                case "NUM":
                  $a = fnNumberOfDecimals($rows[$columns['name']]);
                  echo str_repeat("0", 9);
                  echo "Decimal Point ".fnNumberOfDecimals($rows[$columns['name']]);
                  break;
              }
              echo "<br>";
            }
          }
          echo "<hr>";
          //print_r($arr);
      }
      dd('Done');
}      


      $spreadsheet = new Spreadsheet();
      $spreadsheet->getProperties()
                  ->setCreator("wilianto chen")
                  ->setLastModifiedBy("sistem-online")
                  ->setTitle("Office 2007 XLSX Test Document")
                  ->setSubject("Office 2007 XLSX Test Document")
                  ->setDescription(
                      "document sistem-online."
                  )
                  ->setKeywords("sistem-online") //office 2007 openxml php
                  ->setCategory("sistem-online aplikasi toko");

      $sheet = $spreadsheet->getActiveSheet();
      $sheet->getStyle('1:1')->getFont()->setBold(true); //Set Title Bold

      // $sheet->getActiveSheet()->getStyle('1:1')->getFont()->setBold(true); //Set Title Bold
      // $sheet->setCellValue('A1', 'Hello World !');

      //Begin Cetak Column Header
      $c = 0;
      foreach($Hasil['Column'] as $colkey => $columns) {
        if ($columns['tipe']!="act") {
          // $c = $colkey+1;
          $c++;
          $cr = $arrExcelKolom[$c]."1";
          // echo $cr." ==> ".$columns['label'];
          $sheet->setCellValue($cr, $columns['label']);
        }
      }
      //End Cetak Column Header

      //Begin Cetak Data 
      $i = 0; 
      foreach ($Hasil['Data'] as $rowkey => $rows) {
          $i++; $c = 0;
          // echo "{$rowkey} => {$rows} <br>";
          foreach($Hasil['Column'] as $colkey => $columns) {
          // echo "{$colkey} => {$columns} <br>";
            if ($columns['tipe']!="act") {
              // $c = $colkey+1; 
              $c++;
              $r = $rowkey+2;
              $cr = $arrExcelKolom[$c].$r;
              // echo $cr." ==> ".$rows[$columns['name']];
              $nilai = $rows[$columns['name']];


              switch (strtoupper($columns['tipe'])) {
                case "NUM":
                  $a = fnNumberOfDecimals($rows[$columns['name']]);
                  $DecimalPoint = "";
                  if($a!=0) {
                    $DecimalPoint = ".".str_repeat("0", $a);
                  }
                  $sheet->getStyle($cr)->getNumberFormat()->setFormatCode('#,##0'.$DecimalPoint);
                  break;
                case "TXT":
                  $sheet->setCellValueExplicit($cr, $nilai,
                                \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
                            );
                  break;
                default:
                  $sheet->setCellValue($cr, $nilai);                                  
                  break;
              }

              switch (strtoupper($columns['label'])) {
                case "ENTRY DATE":
                case "CHANGE DATE":
                case "CHANGE SYSTEM DATE":
                  $nilai = date("d-M-Y h:i:s", strtotime($nilai));
                  $sheet->getStyle($cr)->getNumberFormat()->setFormatCode('dd-mmm-yyyy hh:mm:ss');
                  $sheet->setCellValue($cr, $nilai);
                  break;
              }

            }            
          }  

          if(($i % 2) == 0) { 
            $Awal = 1;
            $Akhir = count($Hasil['Column']);
            // $sheet->getStyle($arrExcelKolom[$Awal].$i.":".$arrExcelKolom[$Akhir].$i)->applyFromArray($BackColor);
            $sheet->getStyle($arrExcelKolom[$Awal].$i.":".$arrExcelKolom[$Akhir].$i)->getFill()
                  ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                  ->getStartColor()->setARGB('d4e2d4');
          }                  
      }
      //End Cetak Data 


      // Begin Delete Temporary File      
      $directory = storage_path(). '/tempExcel/';
      // Open a directory, and read its contents
      if (is_dir($directory)){
        if ($opendirectory = opendir($directory)){
          while (($file = readdir($opendirectory)) !== false){
            if (strpos($file, 'GridETE')>1) {
              if (substr($file,0,8) != substr($d,0,8) ) {
                // echo "masuk4".$directory.$file."<br>";
                unlink($directory.$file);
              }
            }
          }
          closedir($opendirectory);
        }
      }
      // End Delete Temporary File


      $writer = new Xlsx($spreadsheet);

      $fileName = $d."GridETE.xlsx";
      $pathFile = $directory.$fileName;
      $writer->save($pathFile);

      return array("path" => $pathFile);

      // $headers = ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
      // return response()->download($pathFile, "hello world.xlsx", $headers);

      //   return response()->make(file_get_contents($pathFile), 200, [
      //       'Content-Type' => 'application/vnd.ms-excel',
      //       'Content-Disposition' => 'attachment; filename="hello world.xlsx"'
      //   ]);


    }

}
