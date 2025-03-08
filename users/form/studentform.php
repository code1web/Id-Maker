<?php
include('../layouts/header.php');
// Redirect to login page if the user is not logged in
if (!isset($_SESSION['userdata']) || empty($_SESSION['userdata'])) {
    header('Location: /Idmaker/users/login.php');
    exit; // Stop further execution
}
include '../../database/database.php';
include('../title/title.php');
?>
<button class="btn btn-primary m-2" id="single-data">Single Form</button>
<button class="btn btn-success m-2" id="multiple-data">Multiple Form</button>
<div class="container mt-5 mb-5 w-50 border">
    <h3 class="modal-title text-center text-info" id="exampleModalLabel"><?php echo $student_form; ?></h3>
    <div class="">
        <div class="single">
            <form class="" action="studentform.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="studentName" class="form-label">School Name</label>
                    <input type="text" name="schoolname" class="form-control" id="schoolName"
                        placeholder="Enter School Name">
                </div>
                <div class="mb-3">
                    <label for="studentName" class="form-label">Student Name</label>
                    <input type="text" name="studentname" class="form-control" id="studentName"
                        placeholder="Enter student's full name">
                </div>
                <div class="mb-3">
                    <label for="studentID" class="form-label">Student ID</label>
                    <input type="text" name="studentid" class="form-control" id="studentID" placeholder="Enter student ID">
                </div>
                <div class="mb-3">
                    <label for="class" class="form-label">Class</label>
                    <input type="text" name="studentclass" class="form-control" id="class" placeholder="Enter class">
                </div>
                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" name="studentdob" class="form-control" id="dob">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" name="studentaddress" id="address" rows="3"
                        placeholder="Enter address"></textarea>
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Upload Photo</label>
                    <input type="file" class="form-control" name="studentphoto" id="photo">
                </div>
                <button type="submit" name="submit" class="btn btn-primary w-50 mx-auto d-block mb-3">Submit</button>
            </form>
        </div>

        <div class="multiple-data" style="display:none;">
            <hr>
            <h4 class="text-center">Upload Multiple Students (CSV)</h4>
            <form action="studentform.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="csvFile" class="form-label">Upload CSV File</label>
                    <input type="file" class="form-control" name="csvfile" id="csvFile" accept=".csv">
                </div>
                <button type="submit" name="submit_csv" class="btn btn-primary w-50 mx-auto d-block mb-3">Upload CSV</button>
            </form>
        </div>
    </div>
</div>
<?php 
// student form functionality to insert student data start from here
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
        echo 'Student id created successfully';
    } else {
        echo 'Form not stored: ' . mysqli_error($conn);
    }
}
mysqli_close($conn);
// student form functionality end from here
?>
<?php include '../layouts/footer.php'; ?>