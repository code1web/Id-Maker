<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Start the session if it's not already started
}
session_regenerate_id(true); 
$is_logged_in = isset($_SESSION['userdata']) ? $_SESSION['userdata']['user_type'] : 'Guest'; // Assuming 'userdata' 
$base_path = '/Idmaker/';
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="<?php //echo $base_path; ?>assets/css/style.css"> -->

    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/sidebar.css">
    <script src="<?php echo $base_path; ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $base_path; ?>assets/js/sidebar.js"></script>

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
  <body id="body-pd">
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand text-light" href="<?php echo $base_path; ?>users/form/studentform.php">Student Form</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php if ($is_logged_in == 'admin'): ?>
              <li class="nav-item">
                <a class="nav-link text-light" href="<?php echo $base_path; ?>admin/adminform.php">Admin</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-light" href="<?php echo $base_path; ?>users/form/user.php">User</a>
              </li>
            <?php endif; ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Templates
              </a>
              <ul class="dropdown-menu">
                <?php if ($is_logged_in == 'admin'): ?>
                  <li><a class="dropdown-item" href="<?php echo $base_path; ?>users/template/schoolidtemplate.php">Student id card</a></li>
                <?php endif; ?>
                <?php if ($is_logged_in == 'user'): ?>
                  <li><a class="dropdown-item" href="<?php echo $base_path; ?>users/template/studenttemplate.php">student template</a></li>
                <?php endif; ?>
              </ul>
            </li>
            <li class="nav-item d-flex">
              <a class="nav-link text-light" href="<?php echo $base_path; ?>users/logout.php">
                Logout
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>