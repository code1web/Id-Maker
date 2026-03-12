<?php
require_once('../../tcpdf/tcpdf.php');

// Get POST data
$student_id   = $_POST['id'];
$student_name = $_POST['name'];
$class        = $_POST['class'];
$dob          = $_POST['dob'];
$address      = $_POST['address'];
$school_name  = $_POST['school'];
$image        = $_POST['image'];

// Create new PDF document (CR80 card size)
$pdf = new TCPDF('P', 'mm', array(54, 86), true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your School');
$pdf->SetTitle('Student ID Card');
$pdf->SetMargins(3, 3, 3);
$pdf->AddPage();

// ID Card HTML Design
$html = '
<style>
    .id-card {
        width: 100%;
        border: 1px solid #2c3e50;
        border-radius: 8px;
        text-align: center;
        font-family: Arial, sans-serif;
        padding: 6px;
    }
    .header {
        background-color: #2c3e50;
        color: #fff;
        padding: 4px;
        font-size: 12px;
        font-weight: bold;
    }
    .id-card img {
        width: 60px;
        height: 60px;
        border-radius: 6px;
        border: 2px solid #2c3e50;
        margin: 6px 0;
    }
    .id-card h3 {
        font-size: 12px;
        margin: 4px 0;
        color: #2c3e50;
    }
    .id-card p {
        margin: 2px 0;
        font-size: 10px;
        color: #333;
    }
</style>

<div class="id-card">
    <div class="header">'.$school_name.'</div>
    <img src="'.$image.'" alt="Student Image">
    <h3>'.$student_name.'</h3>
    <p><strong>ID:</strong> '.$student_id.'</p>
    <p><strong>Class:</strong> '.$class.'</p>
    <p><strong>DOB:</strong> '.$dob.'</p>
    <p><strong>Address:</strong> '.$address.'</p>
</div>
';

// Write HTML to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Force download
$pdf->Output('student_id_card_'.$student_id.'.pdf', 'D');
exit;
?>
