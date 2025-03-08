<?php 
session_start();
$is_logged_in = isset($_SESSION['user']);
$is_admin = isset($_SESSION['admin']); 
include('title/title.php');
?>
<?php include '../database/database.php'; ?>
<?php 
$base_path = '/Idmaker/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $login_title; ?></title>
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/style.css">
</head>
<body>
    <div class="container-fluid sessionWrap">
        <div class="col-4 bg-light">
            <img src="../assets/uploads/download.jpg" class="mt-4" alt="Login Image">
            <h2 class="mb-4"></h2>
            <form class="" method="post" action="login.php">
                <div class="form-group">
                    <!-- <label for="email">Email address</label> -->
                    <input type="email" class="form-control mt-2 w-75 mx-auto" name="email" id="email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <!-- <label for="password">Password</label> -->
                    <input type="password" class="w-75 mx-auto form-control mt-2" name="password" id="password"
                        placeholder="Password">
                </div>
                <button type="submit" class="mb-4 form-control mt-4 w-75 btn btn-primary btn-block">Login</button>
                <a class="btn btn-success p-2 w-75 mb-4" href="<?php echo $base_path; ?>users/form/user.php">Register</a>
            </form>
        </div>
    </div>
</body>
</html>
<?php
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Escaping special characters to prevent SQL injection
$email = mysqli_real_escape_string($conn, $email);
$password = sha1(mysqli_real_escape_string($conn, $password));

$sql = "
    SELECT 
        admin_id AS id, 
        admin_name AS name, 
        admin_email AS email, 
        admin_password AS password, 
        admin_image AS image, 
        admin_phone AS phone, 
        'admin' AS user_type 
    FROM admin 
    WHERE admin_email = '$email' AND admin_password = '$password'
    UNION
    SELECT 
        user_id AS id, 
        user_name AS name, 
        user_email AS email, 
        user_password AS password, 
        NULL AS image,  -- Use NULL if user table does not have an image column
        user_phone AS phone, 
        'user' AS user_type 
    FROM user 
    WHERE user_email = '$email' AND user_password = '$password'
";

$result = mysqli_query($conn, $sql);
// Check if any rows are returned
// Check if any rows are returned
if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    session_regenerate_id(true);
    $_SESSION['userdata'] = $user;  // Store the entire user data in session
    // Redirect based on user type
    if ($user['user_type'] === 'admin') {
        header("Location: http://localhost/idmaker/admin/adminform.php");
    } else {
        header("Location: http://localhost/idmaker/users/form/studentform.php");
    }
    exit();
} else {
    echo "Username and password did not match or do not exist.";
}

mysqli_close($conn);
?>
