<?php $base_path = '/Idmaker/'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/thankyou.css">
    <title>Document</title>
</head>
<body>
    <div class="thankyouSectionWrapper">
        <div class="secHeadingContent">
        <img src="../../assets/uploads/thankyou_img.svg" alt="thanku image">
        <h2 class="secHeadingTitle">Thank You for <br> Registering!</h2>
        <p class="secContent">Thankyou For submitting your detail.</p>
        <div class="btnWrap">
            <a href="<?php echo $base_path; ?>users/login.php" class="btn btn-success" style="background-color:green;">Back to home</a>
        </div>
        <div class="contactUsLink">
            <p>If you have any issues</p> <a href="javascript:void(0);" class="btn-link">Contact Us.</a>
        </div>
    </div>
</div>
</body>
</html>
