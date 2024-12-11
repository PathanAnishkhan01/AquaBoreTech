<?php
// Extend the FPDF class to add rotation functionality
class PDF_Rotate extends FPDF
{
    var $angle = 0;

    function Rotate($angle, $x = -1, $y = -1)
    {
        if ($x == -1) {
            $x = $this->GetX();
        }
        if ($y == -1) {
            $y = $this->GetY();
        }

        $this->_out(sprintf(
            'q %.4f 0 0 %.4f %.4f %.4f cm',
            cos($angle * M_PI / 180), 
            sin($angle * M_PI / 180),
            -sin($angle * M_PI / 180),
            cos($angle * M_PI / 180),
            $x, $y
        ));
        $this->angle = $angle;
    }

    function _out($s)
    {
        // Add the output to the page content
        if ($this->state == 2) {
            $this->pages[$this->page] .= $s . "\n";
        } else {
            $this->buffer .= $s . "\n";
        }
    }

    function ResetRotation()
    {
        $this->angle = 0;
        $this->_out('Q');
    }
}
?>
