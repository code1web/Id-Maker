<?php
session_start(); 
session_regenerate_id(true); 
include '../../database/database.php';
$is_logged_in = isset($_SESSION['userdata']) ? $_SESSION['userdata']['user_type'] : 'Guest'; // Assuming 'userdata' 

if($is_logged_in == 'admin'){
    include('../layouts/header.php'); 
}

include('../title/title.php'); 
$base_path = '/Idmaker/';

// student form functionality to insert student data start from here
if (isset($_POST['submit'])) {
    // Retrieve form data and sanitize
    $user_name = mysqli_real_escape_string($conn, $_POST["user_name"]);
    $user_email = mysqli_real_escape_string($conn, $_POST["user_email"]);
    $user_password = mysqli_real_escape_string($conn, $_POST["user_password"]);
    $user_phone = mysqli_real_escape_string($conn, $_POST["user_phone"]);
    $userpassword = sha1($user_password);
    // Handle photo upload
    if (isset($_FILES['user_photo'])) {
        $photo = $_FILES['user_photo'];
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
    $sql = "INSERT INTO user(`user_name`, `user_email`, `user_password`, `user_phone`, `user_photo`) 
            VALUES ('$user_name', '$user_email', '$userpassword', '$user_phone', '$studentphoto')";

    // Execute query
    if (mysqli_query($conn, $sql)) {
        echo header('Location: thankyou.php');
    } else {
        echo 'Form not stored: ' . mysqli_error($conn);
    }
}
mysqli_close($conn);
// student form functionality end from here
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/bootstrap.min.css">
    <title>Document</title>
    <style>
        :root {
            --background: #1a1a2e;
            --color: #ffffff;
            --primary-color: #0f3460;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            box-sizing: border-box;
            font-family: "poppins";
            background: var(--background);
            color: var(--color);
            letter-spacing: 1px;
            transition: background 0.2s ease;
            -webkit-transition: background 0.2s ease;
            -moz-transition: background 0.2s ease;
            -ms-transition: background 0.2s ease;
            -o-transition: background 0.2s ease;
        }
    </style>
</head>
<body>
    <div class="container mt-5 mb-5 border w-50">
        <h2 class="text-center text-info mt-2"><?php echo $user_title; ?></h2>
        <form action="user.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="userName" class="form-label">User Name</label>
                <input type="text" name="user_name" class="form-control" id="userName" placeholder="Enter User Name">
            </div>
            <div class="mb-3">
                <label for="userEmail" class="form-label">User Email</label>
                <input type="email" name="user_email" class="form-control" id="userEmail" placeholder="Enter User Email">
            </div>
            <div class="mb-3">
                <label for="userPassword" class="form-label">User Password</label>
                <input type="password" name="user_password" class="form-control" id="userPassword" placeholder="Enter User Password">
            </div>
            <div class="mb-3">
                <label for="userPhoto" class="form-label">Upload Photo</label>
                <input type="file" class="form-control" name="user_photo" id="userPhoto">
            </div>
            <div class="mb-3">
                <label for="userPhone" class="form-label">User Phone</label>
                <input type="text" name="user_phone" class="form-control" id="userPhone" placeholder="Enter User Phone">
            </div>
            <button type="submit" name="submit" class="btn btn-primary w-50 mx-auto d-block">Submit</button>
        </form>
    </div>
</body>
</html>

<?php include('../../users/layouts/footer.php');?>