<?php
// Include the TCPDF library
require_once('../../tcpdf/tcpdf.php');

// Get POST data
$student_id = $_POST['id'];
$student_name = $_POST['name'];
$class = $_POST['class'];
$dob = $_POST['dob'];
$address = $_POST['address'];
$school_name = $_POST['school'];
$image = $_POST['image'];

// Create new PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your School');
$pdf->SetTitle('Student ID Card');
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();

// ID Card HTML Design
$html = '
    <style>
        .id-card {
            width: 300px;
            border: 1px solid #ccc;
            padding: 15px;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .id-card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }
        .id-card h3, .id-card p {
            margin: 5px 0;
        }
    </style>

    <div class="id-card">
        <h2>' . $school_name . '</h2>
        <img src="' . $image . '" alt="Student Image">
        <h3>' . $student_name . '</h3>
        <p><strong>ID:</strong> ' . $student_id . '</p>
        <p><strong>Class:</strong> ' . $class . '</p>
        <p><strong>DOB:</strong> ' . $dob . '</p>
        <p><strong>Address:</strong> ' . $address . '</p>
    </div>
';

// Write HTML to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF (force download)
$pdf->Output('student_id_card_' . $student_id . '.pdf', 'D');  // 'D' forces download

exit;
?>
