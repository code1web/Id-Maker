<?php include '../../database/database.php'; ?>
<?php include '../title/title.php'; ?>
<?php include('../layouts/header.php'); 
$is_logged_in = $_SESSION['userdata']['user_type'];
if (!$is_logged_in == 'admin') {
    header('Location: /Idmaker/users/login.php'); 
    exit;
} elseif($is_logged_in == 'user') {
    header('Location: /Idmaker/users/login.php'); 
    exit;
}
?>
<style>
  .id-card {
    width: 300px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: auto;
    border: 2px solid #2c3e50;
  }

  .id-header {
    background: #2c3e50;
    color: #fff;
    text-align: center;
    padding: 15px 10px;
    position: relative;
  }

  .school-logo img {
    width: 40px;
    height: 40px;
    position: absolute;
    left: 15px;
    top: 15px;
  }

  .school-name {
    font-size: 18px;
    font-weight: bold;
  }

  .id-photo {
    display: flex;
    justify-content: center;
    padding: 15px 0;
    background: #f4f6f8;
  }

  .id-photo img {
    width: 100px;
    height: 100px;
    border-radius: 8px;
    object-fit: cover;
    border: 3px solid #2c3e50;
  }

  .id-details {
    padding: 15px;
    text-align: left;
    font-size: 14px;
    color: #333;
  }

  .id-details h3 {
    margin-top: 0;
    font-size: 18px;
    color: #2c3e50;
  }
</style>
<?php
$sql = "SELECT * FROM student_data";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<table class="table table-striped container mt-4 mb-4 border bordered-light">
            <tr>
                <th class="text-light">ID</th>
                <th class="text-light">Student Name</th>
                <th class="text-light">Action</th>
            </tr>';
    while ($row = mysqli_fetch_assoc($result)) {
        $school_name = $row['schoolname'];
        $student_name = $row['Student_name'];
        $student_id = $row['Student_id'];
        $class = $row['Class'];
        $dob = $row['Dob'];
        $address = $row['Address'];
        $image = '../../assets/uploads/' . $row['Student_image'];
?>
    <tr>
        <td class="text-light"><?php echo $student_id; ?></td>
        <td class="text-light"><?php echo $student_name; ?></td>
        <td class="text-light">
          <form method="POST" action="view_idcard.php" target="_blank" style="display:inline;">
              <input type="hidden" name="id" value="<?php echo $student_id; ?>">
              <input type="hidden" name="name" value="<?php echo $student_name; ?>">
              <input type="hidden" name="class" value="<?php echo $class; ?>">
              <input type="hidden" name="dob" value="<?php echo $dob; ?>">
              <input type="hidden" name="address" value="<?php echo $address; ?>">
              <input type="hidden" name="school" value="<?php echo $school_name; ?>">
              <input type="hidden" name="image" value="<?php echo $image; ?>">
              <button type="submit" class="btn btn-success">View</button>
          </form>
        </td>
    </tr>

<?php
    }
    echo'</table>';
} else {
    echo "No student data found.";
}
?>
<?php include '../layouts/footer.php'; ?>