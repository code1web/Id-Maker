<?php

include('../layouts/header.php');

// Check login
if (!isset($_SESSION['userdata']) || empty($_SESSION['userdata'])) {
    header('Location: /IDMAKER/users/login.php');
    exit;
}

include '../../database/database.php';

?>

<!-- Buttons -->
<button class="btn btn-primary m-2" id="single-data">Single Form</button>
<button class="btn btn-success m-2" id="multiple-data">Multiple Form</button>

<!-- Container -->
<div class="container mt-5 mb-5 w-50">
    <div class="row">
        <!-- Single Form -->
        <div class="student-form border" style="display:none;">
            <h3 class="text-center text-info">Single Student Entry</h3>
            <form action="" method="POST" enctype="multipart/form-data">
                <!-- School Name -->
                <div class="mb-3">
                    <label for="schoolName" class="form-label">School Name</label>
                    <input type="text" name="schoolname" class="form-control" id="schoolName" placeholder="Enter School Name">
                </div>
                <!-- Student Name -->
                <div class="mb-3">
                    <label for="studentName" class="form-label">Student Name</label>
                    <input type="text" name="studentname" class="form-control" id="studentName" placeholder="Enter Student's Full Name">
                </div>
                <!-- Student ID -->
                <div class="mb-3">
                    <label for="studentID" class="form-label">Student ID</label>
                    <input type="text" name="studentid" class="form-control" id="studentID" placeholder="Enter Student ID">
                </div>
                <!-- Class -->
                <div class="mb-3">
                    <label for="class" class="form-label">Class</label>
                    <input type="text" name="studentclass" class="form-control" id="class" placeholder="Enter Class">
                </div>
                <!-- DOB -->
                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" name="studentdob" class="form-control" id="dob">
                </div>
                <!-- Address -->
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" name="studentaddress" id="address" rows="3" placeholder="Enter Address"></textarea>
                </div>
                <!-- Photo -->
                <div class="mb-3">
                    <label for="photo" class="form-label">Upload Photo</label>
                    <input type="file" class="form-control" name="studentphoto" id="photo">
                </div>
                <button type="submit" name="submit" class="btn btn-primary w-50 mx-auto d-block mb-3">Submit</button>
            </form>
        </div>

        <!-- CSV Upload Form -->
        <div class="multiple-data border" style="display:none;">
            <hr>
            <h4 class="text-center">Upload Multiple Students (CSV)</h4>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="csvFile" class="form-label">Upload CSV File</label>
                    <input type="file" class="form-control" name="csvfile" id="csvFile" accept=".csv">
                </div>
                <button type="submit" name="upload_csv" class="btn btn-primary w-50 mx-auto d-block mb-3">Upload CSV</button>
            </form>
        </div>
    </div>
</div>

<?php
// ---------- SINGLE FORM SUBMISSION ----------
if (isset($_POST['submit'])) {
    // Retrieve form data and sanitize
    $schoolname = mysqli_real_escape_string($conn, $_POST["schoolname"]);
    $studentname = mysqli_real_escape_string($conn, $_POST["studentname"]);
    $studentid = mysqli_real_escape_string($conn, $_POST["studentid"]);
    $studentclass = mysqli_real_escape_string($conn, $_POST["studentclass"]);
    $studentdob = mysqli_real_escape_string($conn, $_POST["studentdob"]);
    $studentaddress = mysqli_real_escape_string($conn, $_POST["studentaddress"]);
    $user_id = isset($_SESSION['userdata']) ? $_SESSION['userdata']['id'] : '';

    // Handle photo upload
    if (isset($_FILES['studentphoto'])) {
        $photo = $_FILES['studentphoto'];
        $filename = basename($photo['name']);
        $photoPath = '../../assets/uploads/' . $filename;
        if (move_uploaded_file($photo['tmp_name'], $photoPath)) {
            $studentphoto = mysqli_real_escape_string($conn, $filename);
        } else {
            echo "Error uploading photo.";
            exit;
        }
    } else {
        echo "No photo uploaded.";
        exit;
    }

    // Insert query
    $sql = "INSERT INTO student_data (`Schoolname`,`Student_name`, `Class`, `Dob`, `Student_id`, `Address`, `Student_image`, `user_id`) 
            VALUES ('$schoolname','$studentname', '$studentclass', '$studentdob', '$studentid', '$studentaddress', '$studentphoto', '$user_id')";

    // Execute query
    if (mysqli_query($conn, $sql)) {
        echo 'Student id created succ   essfully';
    } else {
        echo 'Form not stored: ' . mysqli_error($conn);
    }
}

// ---------- MULTIPLE CSV SUBMISSION ----------
if (isset($_POST['upload_csv'])) {
    if ($_FILES['csvfile']['error'] == 0 && $_FILES['csvfile']['type'] == "text/csv") {
        $file = $_FILES['csvfile']['tmp_name'];
        $handle = fopen($file, "r");

        $rowCount = 0;

        // Skip header row (optional)
        fgetcsv($handle);

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Map CSV fields to variables
            $schoolname     = mysqli_real_escape_string($conn, $data[0]);
            $studentname    = mysqli_real_escape_string($conn, $data[1]);
            $studentid      = mysqli_real_escape_string($conn, $data[2]);
            $studentclass   = mysqli_real_escape_string($conn, $data[3]);
            $studentdob     = mysqli_real_escape_string($conn, $data[4]);
            $studentaddress = mysqli_real_escape_string($conn, $data[5]);
            $user_id        = $_SESSION['userdata']['id'] ?? 0;

            // Insert into database
            $sql = "INSERT INTO student_data (`Schoolname`, `Student_name`, `Class`, `Dob`, `Student_id`, `Address`, `user_id`) 
                    VALUES ('$schoolname', '$studentname', '$studentclass', '$studentdob', '$studentid', '$studentaddress', '$user_id')";

            mysqli_query($conn, $sql);
            $rowCount++;
        }

        fclose($handle);
        echo "<div class='alert alert-success'>Successfully imported $rowCount student(s).</div>";
    } else {
        echo "<div class='alert alert-danger'>Invalid CSV file.</div>";
    }
}

mysqli_close($conn);
include('../layouts/footer.php');
?>
