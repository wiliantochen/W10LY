<?php
namespace App\Http\Controllers\Reports;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\PHHEAD;
use App\Models\PHLINE;
use DB;
use Codedge\Fpdf\Fpdf\Fpdf;
// use Illuminate\Support\Facades\File as File;

class crPHHEAD_PDF extends Fpdf {
    public $columns = [];
    public $rows = [];
    // Page header
    function Header() {
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // $this->SetFont('Courier', 'B', 18);
        // Move to the right
        // $this->Cell(10);
        // Title
        $this->Cell(0, 5,'PEMBELIAN',0,0,'C');
        $this->Ln();

        $h = 6; $w = 40; $y = 25; $b = 0;


        $this->setXY(120,$y);
        $this->SetFont('Arial','',12);
        $this->Cell($w , $h , 'No Transaksi : ' , $b , 0 , 'R');
        $this->SetFont('Arial','B',12);
        $this->Cell(($w+5) , $h , $this->rows[0]['PHPHNO'] , $b , 0 , 'R');
        $this->Ln();

        $this->setXY(120,($y+($h*1)));
        $this->SetFont('Arial','',12);
        $this->Cell($w , $h , 'Tanggal : ' , $b , 0 , 'R');
        $this->SetFont('Arial','B',12);
        $this->Cell(($w+5) , $h , fnFormatTanggal($this->rows[0]['PHDATE'],"") , $b , 0 , 'R');
        $this->Ln();

        $this->setXY(120,($y+($h*2)));
        $this->SetFont('Arial','',12);
        $this->Cell($w , $h , 'Term : ' , $b , 0 , 'R');
        $this->SetFont('Arial','B',12);
        $this->Cell(($w+5) , $h , $this->rows[0]['SDNAME'] , $b , 0 , 'R');
        $this->Ln();


        $this->setXY(10,$y);
        $this->SetFont('Arial','',12);
        $this->Cell(($w-5) , $h , 'Nama Pemasok : ' , $b , 0 , 'R');
        $this->SetFont('Arial','B',12);
        $this->Cell(($w+40) , $h , "(".$this->rows[0]['BPBPNO'].") ".$this->rows[0]['BPNAME'] , $b , 0 , 'L');
        $this->Ln();

        $this->setXY(10,($y+($h*1)));
        $this->SetFont('Arial','',12);
        $this->Cell(($w-5) , $h , 'Alamat : ' , $b , 0 , 'R');
        $this->SetFont('Arial','B',12);
        // $this->Cell(($w+40) , $h , $this->rows[0]['PHADDR'] , $b , 0 , 'L');
        $this->multiCell(($w+40) , $h , $this->rows[0]['PHADDR']);
        // $this->Ln();

        $this->Ln();
        $this->SetFont('Arial','B',10);
        fnReportDoHeader($this, $this->columns,5);
        // Line break
        // $this->Ln(10);
    }

    // Page footer
    function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

class crPHHEAD extends cSOController {

    // protected $abc;

    // public function __construct(\App\Http\Controllers\Reports\crPDF $abc)
    // {
    //     $this->abc = $abc;
    //     // dd($this->abc);  
    // }


    // public function PrintForm(Request $request) {
    

    //     $pathFile = storage_path(). '/recipe.pdf';

    //     $this->abc->SetMargins(10, 36.5, 10);
    //     $this->abc->AliasNbPages();

    //     $this->abc->AddPage();
    //     $this->abc->SetFont('Courier', 'B', 18);
    //     $this->abc->Cell(50, 25, 'Hello Wilianxxxto!',0,1,'C');
    //     $this->abc->Cell(50, 25, 'Hello Wilianto!',0,1,'C');
    //     $this->abc->Cell(50, 25, 'Hello Wilianto!',0,1,'C');
    //     $this->abc->Output('F', $pathFile);
    //     $headers = ['Content-Type' => 'application/pdf'];
    //     return response()->file($pathFile, $headers);

    // }   



    protected $pdf;

    public function __construct(\App\Http\Controllers\Reports\crPHHEAD_PDF $pdf)
    {
        $this->pdf = $pdf;
        // dd($this->pdf);  
    }

    public function PrintForm(Request $request) {
    


        $fParams = $request->frmParams;


        $CC = DB::table('SYSDAT')
                    ->leftJoin('SYSTBL','STTABLIY','SDTABLIY')
                    ->where([
                        ['STTABL', '=', 'CC']
                      ]);    

        $PHLINE = PHLINE::noLock()
                ->leftJoin('PHHEAD','PHPHNOIY','PLPHNOIY')
                ->leftJoin('MITMAS','MMITNOIY','PLITNOIY')
                ->leftJoin('MBPMAS','BPBPNOIY','PHBPNOIY')
                ->joinSub($CC, 'CC', function ($join) {
                        $join->on('CC.SDDATA', '=', 'PHHEAD.PHTYPE');
                    })
                ->where([
                    ['PLDLFG', '=', '0'],
                    // ['PLPHNOIY', '=', 1],
                    ['PLPHNOIY', '=', $fParams->PHPHNOIY],
                  ])
                ->get();

        $columns = [];

        $columns[] = array("field"   => "MMITNO", "label" => "Kd\nBrg", 
                           "type"    => "txt",  
                           "length"  => 20, "charLength" => 0,
                           "align"   => "L"); 
        $columns[] = array("field"   => "MMNAME", "label" => "Nama\nBarang", 
                           "type"    => "txt", 
                           "length"  => 90, "charLength" => 10,
                           "align"   => "L"); 
        $columns[] = array("field"   => "REMK", "label" => "Remark", 
                           "type"    => "txt", 
                           "length"  => 25, "charLength" => 0,
                           "align"   => "L"); 
        $columns[] = array("field"   => "PLQTYS", "label" => "Qty", 
                           "type"    => "num", "decimal" => 0, 
                           "length"  => 15, "charLength" => 0,
                           "align"   => "R"); 
        $columns[] = array("field"   => "PLHARG", "label" => "Harga\nSatuan", 
                           "type"    => "num", "decimal" => 2, 
                           "length"  => 20, "charLength" => 0,
                           "align"   => "R"); 
        $columns[] = array("field"   => "PLTOTL", "label" => "Total\nHarga", 
                           "type"    => "num", "decimal" => 2, 
                           "length"  => 25, "charLength" => 0,
                           "align"   => "R"); 

        // dd($PHLINE[0]['PLPHNOIY']);


        $this->pdf->columns = $columns;
        $this->pdf->rows = $PHLINE;
        // $this->pdf->SetMargins(10, 36.5, 10);
        $mT = 10; $mL = 8; $mR = 10; $mB = 0;
        $this->pdf->SetMargins($mL, $mT, $mR, $mB);
        $this->pdf->AliasNbPages();

        // $this->pdf->AddPage();
        $pPosition = "L";
        $pSize = "A5";
        $this->pdf->AddPage($pPosition, $pSize, false);

        $this->pdf->SetFont('Arial', '', 10);
        $rowHeight = 5;
        $rowWrapText = true;
        foreach($PHLINE as $rows) {  // Begin Looping Record SYSMNU 
            // $rows['REMK'] = "abc\ndef\nghi\njklmno";
            // $rows['REMK'] = "abc\ndef\nghi";
            // $rows['REMK'] = "abc\ndef";
            $rows['REMK'] = "abc";
            // $rows['MMNAME'] = $rows['MMNAME']."\nabc\ndef\nghi";
            fnReportDoDetail($this->pdf, $rows, $columns, $rowHeight, $rowWrapText);
        }

        $footerX = 143;
        $footerY = $this->pdf->getY();
        $this->pdf->setX($footerX);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(35 , $rowHeight , 'Sub Total : ' , 1 , 0 , 'R');
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->Cell(25 , $rowHeight , fnFormatNumber($PHLINE[0]['PHSUBT'],2) , 1 , 0 , 'R');
        $this->pdf->ln();
        $this->pdf->setX($footerX);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(35 , $rowHeight , 'Plus/Minus : ' , 1 , 0 , 'R');
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->Cell(25 , $rowHeight , fnFormatNumber($PHLINE[0]['PHEXCT'],2) , 1 , 0 , 'R');
        $this->pdf->ln();
        $this->pdf->setX($footerX);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(35 , $rowHeight , 'Total Keseluruhan : ' , 1 , 0 , 'R');
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->Cell(25 , $rowHeight , fnFormatNumber($PHLINE[0]['PHTOTL'],2) , 1 , 0 , 'R');
        $this->pdf->ln();


        $this->pdf->setXY(8,$footerY);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(17 , $rowHeight , 'Remark : ' , 0 , 0 , 'L');
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->multiCell(115 , $rowHeight , $PHLINE[0]['PHREMK'], 0, 'L');
        $this->pdf->ln();

        $pathFile = storage_path(). '/recipe.pdf';
        $this->pdf->Output('F', $pathFile);
        $headers = ['Content-Type' => 'application/pdf'];
        // return response()->file($pathFile, $headers);
        // return response()->download($pathFile, "abc.pdf");
        $filename = "recipe.pdf";
        return response()->make(file_get_contents($pathFile), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);


        // $Hasil = array( "Path"=> $pathFile);

        // return response()->json($Hasil);

    }   

    public function PrintFormXXXX(Request $request) {
    

        $pathFile = storage_path(). '/recipe.pdf';

        $pdf = new PDF();
        // dd('masuksini');
        $pdf::SetMargins(10, 36.5, 10);
        $pdf::AliasNbPages();

        $pdf::AddPage();
        $pdf::SetFont('Courier', 'B', 18);
        $pdf::Cell(50, 25, 'Hello Wilianxxxto!',0,1,'C');
        $pdf::Cell(50, 25, 'Hello Wilianto!',0,1,'C');
        $pdf::Cell(50, 25, 'Hello Wilianto!',0,1,'C');
        // $pdf::Output();
        $pdf::Output('F', $pathFile);
        $headers = ['Content-Type' => 'application/pdf'];
        return response()->file($pathFile, $headers);

    }   


    public function PrintXXXX(Request $request) {    
        
        Fpdf::AddPage();
        Fpdf::SetFont('Courier', 'B', 18);
        Fpdf::Cell(50, 25, 'Hello World!');
        Fpdf::Output();


    }   

    public function PrintABC(Request $request) {    
        
      echo "abc";
        // $a = File::get(storage_path('app/public/abc.pdf'));
        $a = storage_path(). '/recipe.pdf';
        $a = storage_path('app/public/abc.pdf');
dd($a);

        $headers = ['Content-Type' => 'application/pdf'];
        return response()->file($a,$headers);
    }  

}
