<?php 
session_start();
include '../database/database.php';
include('title/title.php');
$base_path = '/Idmaker/';
$is_logged_in = isset($_SESSION['user']);
$is_admin = isset($_SESSION['admin']); 

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if(!empty($email) && !empty($password)) :

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
        // echo "Username and password did not match or do not exist.";
    }
endif;

mysqli_close($conn);

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
    <section class="container">
        <div class="login-container">
            <div class="circle circle-one"></div>
            <div class="form-container">
                <img src="https://raw.githubusercontent.com/hicodersofficial/glassmorphism-login-form/master/assets/illustration.png" alt="illustration" class="illustration" />
                <h1 class="opacity">LOGIN</h1>
                <form class="" method="post" action="login.php">
                    <input type="email" name="email" id="email" placeholder="USERNAME" />
                    <input type="password" name="password" id="password" placeholder="PASSWORD" />
                    <button type="submit" class="opacity">Login</button>
                </form>
                <div class="register-forget opacity">
                    <a href="">REGISTER</a>
                    <a href="">FORGOT PASSWORD</a>
                </div>
            </div>
            <div class="circle circle-two"></div>
        </div>
        <div class="theme-btn-container"></div>
    </section>
</body>

</html>
<script>
    const themes = [
        {
            background: "#1A1A2E",
            color: "#FFFFFF",
            primaryColor: "#0F3460"
        },
        {
            background: "#461220",
            color: "#FFFFFF",
            primaryColor: "#E94560"
        },
        {
            background: "#192A51",
            color: "#FFFFFF",
            primaryColor: "#967AA1"
        },
        {
            background: "#F7B267",
            color: "#000000",
            primaryColor: "#F4845F"
        },
        {
            background: "#F25F5C",
            color: "#000000",
            primaryColor: "#642B36"
        },
        {
            background: "#231F20",
            color: "#FFF",
            primaryColor: "#BB4430"
        }
    ];

const setTheme = (theme) => {
    const root = document.querySelector(":root");
    root.style.setProperty("--background", theme.background);
    root.style.setProperty("--color", theme.color);
    root.style.setProperty("--primary-color", theme.primaryColor);
    root.style.setProperty("--glass-color", theme.glassColor);
};

const displayThemeButtons = () => {
    const btnContainer = document.querySelector(".theme-btn-container");
    themes.forEach((theme) => {
        const div = document.createElement("div");
        div.className = "theme-btn";
        div.style.cssText = `background: ${theme.background}; width: 25px; height: 25px`;
        btnContainer.appendChild(div);
        div.addEventListener("click", () => setTheme(theme));
    });
};

displayThemeButtons();

</script>

