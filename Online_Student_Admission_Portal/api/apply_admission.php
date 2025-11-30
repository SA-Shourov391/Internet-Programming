<?php
// DEBUG 1 — Check request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("<h3>ERROR: This page only accepts POST!</h3>");
}

echo "<h3>DEBUG: POST request received ✔</h3>";

// Include DB
require_once "config.php";
require_once "db.php";

// DEBUG 2 — Check DB connection
if (!$conn) {
    die("<h3>DB Connection Failed!</h3>");
}

echo "<h3>DEBUG: DB Connected ✔</h3>";

// Collect form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$dob = $_POST['dob'] ?? '';
$ssc_gpa = $_POST['ssc_gpa'] ?? '';
$hsc_gpa = $_POST['hsc_gpa'] ?? '';
$department = $_POST['department'] ?? '';
$address = $_POST['address'] ?? '';
$photo = $_POST['photo'] ?? '';

echo "<h3>DEBUG: Data Received — $name, $email, $phone, $dob, $ssc_gpa, $hsc_gpa, $department, $address, $photo ✔</h3>";

// Insert query
$sql = "INSERT INTO admission_applications(name, email, phone, dob, ssc_gpa, hsc_gpa, department, address, photo)
        VALUES('$name', '$email', '$phone', '$dob', '$ssc_gpa', '$hsc_gpa', '$department', '$address', '$photo')";

if ($conn->query($sql) === TRUE) {

    $last_id = $conn->insert_id;

    echo "<h3>DEBUG: Insert Successful! ID = $last_id ✔</h3>";

    // Redirect to success page
    header("Location: ../admission_success.php?id=$last_id");
    exit;
} 
else {
    echo "<h3>ERROR: " . $conn->error . "</h3>";
}
?>
