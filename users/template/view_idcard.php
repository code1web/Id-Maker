<?php
// Get POST data
$student_id   = $_POST['id'];
$student_name = $_POST['name'];
$class        = $_POST['class'];
$dob          = $_POST['dob'];
$address      = $_POST['address'];
$school_name  = $_POST['school'];
$image        = $_POST['image'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Student ID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .id-card {
            width: 300px;
            border: 1px solid #ccc;
            padding: 15px;
            text-align: center;
            font-family: Arial, sans-serif;
            margin: 40px auto;
            border-radius: 10px;
            box-shadow: 0 0 6px rgba(0,0,0,0.2);
        }
        .id-card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 2px solid #2c3e50;
        }
        .id-card h3, .id-card p {
            margin: 5px 0;
        }
        .header {
            background: #2c3e50;
            color: #fff;
            padding: 8px;
            font-weight: bold;
            border-radius: 8px 8px 0 0;
        }
    </style>
</head>
<body>

<div class="id-card">
    <div class="header"><?php echo $school_name; ?></div>
    <img src="<?php echo $image; ?>" alt="Student Image">
    <h3><?php echo $student_name; ?></h3>
    <p><strong>ID:</strong> <?php echo $student_id; ?></p>
    <p><strong>Class:</strong> <?php echo $class; ?></p>
    <p><strong>DOB:</strong> <?php echo $dob; ?></p>
    <p><strong>Address:</strong> <?php echo $address; ?></p>
</div>
<div class="container mt-4">
    <div class="d-flex justify-content-center">
        <button type="button" class="btn btn-success me-3" onclick="window.print()">Print</button>
        <form method="POST" action="download.php">
            <input type="hidden" name="id" value="<?php echo $student_id; ?>">
            <input type="hidden" name="name" value="<?php echo $student_name; ?>">
            <input type="hidden" name="class" value="<?php echo $class; ?>">
            <input type="hidden" name="dob" value="<?php echo $dob; ?>">
            <input type="hidden" name="address" value="<?php echo $address; ?>">
            <input type="hidden" name="school" value="<?php echo $school_name; ?>">
            <input type="hidden" name="image" value="<?php echo $image; ?>">
            <button type="submit" class="btn btn-primary">Download</button>
        </form>
    </div>
</div>
</body>
</html>
