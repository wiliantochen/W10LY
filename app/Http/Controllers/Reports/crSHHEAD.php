<?php
namespace App\Http\Controllers\Reports;

use App\Http\Controllers\cSOController; //as cSOController
use Illuminate\Http\Request;
use App\Models\SHLINE;
use DB;
use Codedge\Fpdf\Fpdf\Fpdf;
// use Illuminate\Support\Facades\File as File;

class crSHHEAD_PDF extends Fpdf {
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
        $this->Cell(0, 5,'PENJUALAN',0,0,'C');
        $this->Ln();

        $h = 6; $w = 40; $y = 25; $b = 0;


        $this->setXY(120,$y);
        $this->SetFont('Arial','',12);
        $this->Cell($w , $h , 'No Transaksi : ' , $b , 0 , 'R');
        $this->SetFont('Arial','B',12);
        $this->Cell(($w+5) , $h , $this->rows[0]['SHSHNO'] , $b , 0 , 'R');
        $this->Ln();

        $this->setXY(120,($y+($h*1)));
        $this->SetFont('Arial','',12);
        $this->Cell($w , $h , 'Tanggal : ' , $b , 0 , 'R');
        $this->SetFont('Arial','B',12);
        $this->Cell(($w+5) , $h , fnFormatTanggal($this->rows[0]['SHDATE'],"") , $b , 0 , 'R');
        $this->Ln();


        $this->setXY(10,$y);
        $this->SetFont('Arial','',12);
        $this->Cell(($w-5) , $h , 'Nama Pelanggan : ' , $b , 0 , 'R');
        $this->SetFont('Arial','B',12);
        $this->Cell(($w+40) , $h , "(".$this->rows[0]['BPBPNO'].") ".$this->rows[0]['BPNAME'] , $b , 0 , 'L');
        $this->Ln();

        $this->setXY(10,($y+($h*1)));
        $this->SetFont('Arial','',12);
        $this->Cell(($w-5) , $h , 'Alamat : ' , $b , 0 , 'R');
        $this->SetFont('Arial','B',12);
        // $this->Cell(($w+40) , $h , $this->rows[0]['SHADDR'] , $b , 0 , 'L');
        $this->multiCell(($w+40) , $h , $this->rows[0]['SHADDR']);
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

class crSHHEAD extends cSOController {


    protected $pdf;

    public function __construct(\App\Http\Controllers\Reports\crSHHEAD_PDF $pdf)
    {
        $this->pdf = $pdf;
        // dd($this->pdf);  
    }

    public function PrintForm(Request $request) {
    


        $fParams = $request->frmParams;

        $SHLINE = SHLINE::noLock()
                ->leftJoin('SHHEAD','SHSHNOIY','SLSHNOIY')
                ->leftJoin('MITMAS','MMITNOIY','SLITNOIY')
                ->leftJoin('MBPMAS','BPBPNOIY','SHBPNOIY')
                ->where([
                    ['SLDLFG', '=', '0'],
                    // ['SLSHNOIY', '=', 1],
                    ['SLSHNOIY', '=', $fParams->SHSHNOIY],
                  ])
                ->get();


        $columns = [];

        $columns[] = array("field"   => "MMITNO", "label" => "Kd\nBrg", 
                           "type"    => "txt",  
                           "length"  => 20, "charLength" => 0,
                           "align"   => "L"); 
        $columns[] = array("field"   => "MMNAME", "label" => "Nama\nBarang", 
                           "type"    => "txt", 
                           "length"  => 90, "charLength" => 0,
                           "align"   => "L"); 
        $columns[] = array("field"   => "REMK", "label" => "Remark", 
                           "type"    => "txt", 
                           "length"  => 25, "charLength" => 0,
                           "align"   => "L"); 
        $columns[] = array("field"   => "SLQTYS", "label" => "Qty", 
                           "type"    => "num", "decimal" => 0, 
                           "length"  => 15, "charLength" => 0,
                           "align"   => "R"); 
        $columns[] = array("field"   => "SLHARG", "label" => "Harga\nSatuan", 
                           "type"    => "num", "decimal" => 2, 
                           "length"  => 20, "charLength" => 0,
                           "align"   => "R"); 
        $columns[] = array("field"   => "SLTOTL", "label" => "Total\nHarga", 
                           "type"    => "num", "decimal" => 2, 
                           "length"  => 25, "charLength" => 0,
                           "align"   => "R"); 

        // dd($SHLINE[0]['SLSHNOIY']);


        $this->pdf->columns = $columns;
        $this->pdf->rows = $SHLINE;
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
        foreach($SHLINE as $rows) {  // Begin Looping Record Detail
            // $rows['REMK'] = "abc\ndef\nghi\njklmno";
            // $rows['REMK'] = "abc\ndef\nghi";
            // $rows['REMK'] = "abc\ndef";
            $rows['REMK'] = "abc";
            // $rows['MMNAME'] = $rows['MMNAME']."\nabc\ndef\nghi";
            fnReportDoDetail($this->pdf, $rows, $columns, $rowHeight, $rowWrapText);
        } // End Looping Record Detail

        $footerX = 143;
        $footerY = $this->pdf->getY();
        $this->pdf->setX($footerX);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(35 , $rowHeight , 'Sub Total : ' , 1 , 0 , 'R');
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->Cell(25 , $rowHeight , fnFormatNumber($SHLINE[0]['SHSUBT'],2) , 1 , 0 , 'R');
        $this->pdf->ln();
        $this->pdf->setX($footerX);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(35 , $rowHeight , 'Slus/Minus : ' , 1 , 0 , 'R');
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->Cell(25 , $rowHeight , fnFormatNumber($SHLINE[0]['SHEXCT'],2) , 1 , 0 , 'R');
        $this->pdf->ln();
        $this->pdf->setX($footerX);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(35 , $rowHeight , 'Total Keseluruhan : ' , 1 , 0 , 'R');
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->Cell(25 , $rowHeight , fnFormatNumber($SHLINE[0]['SHTOTL'],2) , 1 , 0 , 'R');
        $this->pdf->ln();


        $this->pdf->setXY(8,$footerY);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(17 , $rowHeight , 'Remark : ' , 0 , 0 , 'L');
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->multiCell(115 , $rowHeight , $SHLINE[0]['SHREMK'], 0, 'L');
        $this->pdf->ln();


        // Begin OutPut
        $pathFile = storage_path(). '/recipe.pdf';
        $this->pdf->Output('F', $pathFile);
        $headers = ['Content-Type' => 'application/pdf'];
        return response()->file($pathFile, $headers);
        // End OutPut


        // $Hasil = array( "Path"=> $pathFile);

        // return response()->json($Hasil);

    }   


}
