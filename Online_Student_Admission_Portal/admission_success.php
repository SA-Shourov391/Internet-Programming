<?php
if (!isset($_GET['id'])) {
    die("Invalid Request!");
}

$app_id = $_GET['id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admission Successful</title>
</head>
<body>
    <h2>🎉 Admission Application Submitted Successfully!</h2>

    <p>Your application has been received.</p>

    <a href="api/generate_pdf.php?id=<?php echo $last_id; ?>" target="_blank">
    Download Admission Slip (PDF) </a>

</body>
</html>
