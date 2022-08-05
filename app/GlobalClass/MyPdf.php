<?php
namespace App\GlobalClass;

use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Support\Facades\Config;

class MYPDF extends TCPDF {
    //Page header
    public function Header() {
       // Get the current page break margin
        $bMargin = $this->getBreakMargin();

        // Get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;

        // Disable auto-page-break
        $this->SetAutoPageBreak(false, 0);

        // Define the path to the image that you want to use as watermark.
        $img_file = Config::get('tcpdf.image_background');
        // Render the image
        $this->Image($img_file, 0, 0, 210, 295, '', '', '', false, 300, '', false, false, 0);

        // Restore the auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);

        // set the starting point for the page content
        $this->setPageMark();
    }
    // Page footer
    public function Footer() {
        // Set font
        $this->SetFont('helvetica', 'I', 8);

        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}