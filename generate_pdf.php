<?php
// This script uses FPDF (http://www.fpdf.org). Place fpdf.php in the project root or adjust include path.
// If you don't have FPDF, download from http://www.fpdf.org and copy fpdf.php here.
if(!file_exists('fpdf.php')){
    echo '<div style="font-family:Arial;padding:20px">FPDF library not found. Please download <a href="http://www.fpdf.org/">FPDF</a> and place fpdf.php in project root.</div>';
    exit;
}
require('fpdf.php');
include('db_connect.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,8,'User List',0,1,'C');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',10);
$headers = ['ID','Name','Mobile','Email','State','City','Description'];
$widths = [10,35,30,50,20,20,25];
foreach($headers as $i=>$h){ $pdf->Cell($widths[$i],7,$h,1,0,'C'); }
$pdf->Ln();
$pdf->SetFont('Arial','',9);
$res = $conn->query('SELECT * FROM users ORDER BY id DESC');
while($row = $res->fetch_assoc()){
    $pdf->Cell($widths[0],6,$row['id'],1);
    $pdf->Cell($widths[1],6,substr($row['name'],0,20),1);
    $pdf->Cell($widths[2],6,$row['mobile'],1);
    $pdf->Cell($widths[3],6,substr($row['email'],0,30),1);
    $pdf->Cell($widths[4],6,substr($row['state'],0,15),1);
    $pdf->Cell($widths[5],6,substr($row['city'],0,15),1);
    $pdf->Cell($widths[6],6,substr(str_replace("\n"," ", $row['description']),0,30),1);
    $pdf->Ln();
}
$pdf->Output('D','users.pdf');