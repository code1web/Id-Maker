<?php 
include('../users/layouts/header.php');
$is_logged_in = $_SESSION['userdata']['user_type'];
if (!$is_logged_in == 'admin') {
    header('Location: /Idmaker/users/login.php'); // Adjust the path to your login page
    exit; // Stop further execution
} elseif($is_logged_in == 'user') {
    header('Location: /Idmaker/users/login.php'); // Adjust the path to your login page
    exit;
}
include '../database/database.php';
include('../users/title/title.php'); 
?>
<div class="container mt-5 mb-5 border w-50">
    <h2 class="text-center text-info mt-2"><?php echo $admin_title; ?></h2>
    <form action="adminform.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="adminName" class="form-label">Admin Name</label>
            <input type="text" name="admin_name" class="form-control" id="adminName" placeholder="Enter Admin Name">
        </div>
        <div class="mb-3">
            <label for="adminEmail" class="form-label">Admin Email</label>
            <input type="email" name="admin_email" class="form-control" id="adminEmail" placeholder="Enter Admin Email">
        </div>
        <div class="mb-3">
            <label for="adminPassword" class="form-label">Admin Password</label>
            <input type="password" name="admin_password" class="form-control" id="adminPassword" placeholder="Enter Admin Password">
        </div>
        <div class="mb-3">
            <label for="adminPhoto" class="form-label">Upload Photo</label>
            <input type="file" class="form-control" name="admin_photo" id="adminPhoto">
        </div>
        <div class="mb-3">
            <label for="adminPhone" class="form-label">Admin Phone</label>
            <input type="number" name="admin_phone" class="form-control" id="adminPhone" placeholder="Enter Admin Phone">
        </div>
        <button type="submit" name="submit" class="btn btn-primary w-100">Submit</button>
    </form>
</div>
<?php 
// student form functionality to insert student data start from here
if (isset($_POST['submit'])) {
    // Retrieve form data and sanitize
    $admin_name = mysqli_real_escape_string($conn, $_POST["admin_name"]);
    $admin_email = mysqli_real_escape_string($conn, $_POST["admin_email"]);
    $admin_password = mysqli_real_escape_string($conn, $_POST["admin_password"]);
    $admin_phone = mysqli_real_escape_string($conn, $_POST["admin_phone"]);
    $adminpassword = sha1($admin_password);
    // Handle photo upload
    if (isset($_FILES['admin_photo'])) {
        $photo = $_FILES['admin_photo'];
        $filename = basename($photo['name']);
        $photoPath = '../assets/uploads/' . $filename;
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
    $sql = "INSERT INTO admin(`admin_name`, `admin_email`, `admin_password`, `admin_phone`, `admin_image`) 
            VALUES ('$admin_name', '$admin_email', '$adminpassword', '$admin_phone', '$studentphoto')";

    // Execute query
    if (mysqli_query($conn, $sql)) {
        echo header('Location: ../users/form/thankyou.php');
    } else {
        echo 'Form not stored: ' . mysqli_error($conn);
    }
}
mysqli_close($conn);
// student form functionality end from here
?>
<?php include('../users/layouts/footer.php');?>