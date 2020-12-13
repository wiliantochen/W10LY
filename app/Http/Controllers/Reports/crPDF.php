<?php
namespace App\Http\Controllers\Reports;

use Codedge\Fpdf\Fpdf\Fpdf;

class crPDF extends FPDF {
    // Page header
    function Header() {
        // Arial bold 15
        // $this->SetFont('Arial','B',15);
        $this->SetFont('Courier', 'B', 18);
        // Move to the right
        $this->Cell(10);
        // Title
        $this->Cell(0,10,'Title XXXXX',1,0,'C');
        // Line break
        $this->Ln(10);
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
