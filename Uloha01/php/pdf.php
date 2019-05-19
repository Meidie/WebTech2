<?php

require('../fpdf/fpdf.php');
if(isset($_GET['lang']) && $_GET['lang'] == 'sk'){$language = include('../lang/svk.php');
}else if(isset($_GET['lang']) && $_GET['lang'] == 'en'){$language = include('../lang/eng.php');
}else{$language = include('../lang/svk.php');}

if(isset($_GET['lang']) && isset($_GET['subject']) && isset($_GET['year'])){

    require('../php/config.php');
    $conn = new mysqli($hostname, $username, $password, $dbname,4171);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $header = array();
    $rows = array();
    $cols = array();

    $subjectName = $_GET['subject']." ".$_GET['year'];

    $sql = "SHOW columns FROM `$subjectName`";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {

            if( strtolower($row['Field']) != 'rok'){

                if(strtolower($row['Field']) == 'id')
                    array_push($header,'ID');
                else if(strtolower($row['Field']) == 'spolu')
                    array_push($header,$language['sum']);
                else if(strtolower($row['Field']) == 'znamka'){
                    $grade = iconv('UTF-8', 'windows-1252', $language['grade']);
                    array_push($header,$grade);
                }
                else if(strtolower($row['Field']) == 'meno')
                    array_push($header,$language['name']);
                else
                    array_push($header,$row['Field']);
            }
        }
    }

    $sql = "SELECT * FROM `$subjectName`";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {

            $count = 1;

            foreach ($row as $col){

                if($count !=3){
                    array_push($cols,$col);
                }

                $count++;
            }

            array_push($rows,$cols);
            $cols = array();
        }
    }

    //print_r($header);
    //print_r($rows);
}

class PDF extends FPDF
{

    function Header()
    {
        global $subjectName;
        $this->SetFont('Arial','B',15);
        $this->Cell(100); //287
        $this->Cell(87,10,$subjectName,0,0,'C');
        $this->Ln(20);
    }

    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    function Table($header, $data)
    {
        $size = count($header);

        $widthCount = $size - 4;
        $width = 85 + ($widthCount*10);
        $width = (297 - $width);
        $width = $width/2;

        $this->SetFillColor(34,34,34);
        $this->SetTextColor(255);
        $this->SetDrawColor(255);
        $this->SetFont('','B');
        $this->Cell($width); //297

        for($i=0;$i<count($header);$i++)

            if ($i == 0)
                $this->Cell(15, 7, $header[$i], 1, 0, 'C', true);
            else if ($i == 1)
                $this->Cell(40, 7, $header[$i], 1, 0, 'C', true);
            else if ($i >= ($size - 2))
                $this->Cell(15, 7, $header[$i], 1, 0, 'C', true);
            else
                $this->Cell(10, 7, $header[$i], 1, 0, 'C', true);
            $this->Ln();

        $this->SetTextColor(0);
        $this->SetFont('');

        // Data
        $fill = false;
            foreach ($data as $row) {
                $colCount = 0;


                if($fill)
                    $this->SetFillColor(202,202,202);
                else
                    $this->SetFillColor(216,216,216);
                $this->Cell($width); //297
                foreach ($row as $col) {

                    if ($colCount == 0)
                        $this->Cell(15, 7, $col, 1, 0, 'C', true);
                    else if ($colCount == 1)
                        $this->Cell(40, 7, $col, 1, 0, 'C', true);
                    else if ($colCount >= ($size - 2))
                        $this->Cell(15, 7, $col, 1, 0, 'C', true);
                    else
                        $this->Cell(10, 7, $col, 1, 0, 'C', true);


                    $colCount++;

                }
                $fill = !$fill;
                $this->Ln();
            }

    }
}

$pdf = new PDF();
$pdf->SetLeftMargin(0);
$pdf->SetFont('Arial','',10);
$pdf->AliasNbPages();
$pdf->AddPage('L');
$pdf->SetTitle($subjectName."");
$pdf->Table($header,$rows);
$pdf->Output( $subjectName.".pdf","I");


/*
$pdf = new FPDF();
$pdf->AddPage();


$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World');
$pdf->Output();
*/
?>
