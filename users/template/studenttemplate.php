<?php include '../../database/database.php'; ?>
<?php include '../title/title.php'; ?>
<?php include '../layouts/header.php'; 
// Check if user is logged in and retrieve their user type
$is_logged_in = isset($_SESSION['userdata']['user_type']) ? $_SESSION['userdata']['user_type'] : null;

// Redirect logic
if ($is_logged_in === 'admin') {
    // Redirect admin users to the admin page
    header('Location: /Idmaker/users/login.php');
    exit;
} elseif ($is_logged_in !== 'user') {
    // Redirect unauthenticated users or others to the login page
    header('Location: /Idmaker/users/login.php');
    exit;
}
?>
<style>
    .id-card {
        width: 350px;
        border: 1px solid #ccc;
        padding: 20px;
        text-align: center;
        font-family: Arial, sans-serif;
        margin: 10px;
        display: inline-block;
        vertical-align: top;
    }
    .id-card img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
    }
    .id-card h3, .id-card p {
        margin: 10px 0;
    }

    .modal-content {
        background: transparent !important;
        border: none;
    }
</style>

<?php
// Fetch the logged-in user's ID
$user_id = $_SESSION['userdata']['id'];  
// Fetch all student data
$sql = "SELECT * FROM student_data WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    echo '<table class="table table-striped container mt-5">
    <tr>
        <th>ID</th>
        <th>Student Name</th>
        <th>Action</th>
    </tr>';
    while ($row = mysqli_fetch_assoc($result)) {
        // session_regenerate_id(true);
        $school_name = $row['schoolname'];
        $student_name = $row['Student_name'];
        $student_id = $row['Student_id'];
        $class = $row['Class'];
        $dob = $row['Dob'];
        $address = $row['Address'];
        $image = '../../assets/uploads/' . $row['Student_image'];
?>
    <tr>
        <td><?php echo $student_id; ?></td>
        <td><?php echo $student_name; ?></td>
        <td><button class="btn btn-success"  data-bs-toggle="modal" data-bs-target="#exampleModal<?php print_r($row['Id']);?>">View</button></td>
    </tr>
<div class="modal fade" id="exampleModal<?php print_r($row['Id']);?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body mx-auto">
            <div class="id-card bg-light">
                <div class="school-name"><?php echo $school_name; ?></div>
                <img src="<?php echo $image; ?>" alt="Student Photo">
                <h3><?php echo $student_name; ?></h3>
                <p>ID: <?php echo $student_id; ?></p>
                <p>Class: <?php echo $class; ?></p>
                <p>Date of Birth: <?php echo $dob; ?></p>
                <p>Address: <?php echo $address; ?></p>
            </div>
        </div>
    </div>
  </div>
</div>
<?php
    }
    echo'</table>';
} else {
    echo "No student data found.";
}
?>
<?php include '../layouts/footer.php'; ?>