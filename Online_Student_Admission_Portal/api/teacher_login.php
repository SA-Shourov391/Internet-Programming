<?php
session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $teacher_id = trim($_POST["teacher_id"]);
    $password   = trim($_POST["password"]);

    // ========= Temporary Hardcoded Login (DEV MODE) =========
    $allowed_teachers = [
        "Teacher1" => "123456",
        "Admin1" => "123456",
        "Shourov" => "123456"
    ];

    if (isset($allowed_teachers[$teacher_id]) && $allowed_teachers[$teacher_id] === $password) {
        $_SESSION["teacher_id"] = $teacher_id;
        header("Location: ../teacher-dashboard.html");
        exit;
    }
    // =========================================================

    // == PRODUCTION LOGIN (FROM DATABASE) ==
    $sql = "SELECT * FROM teachers WHERE teacher_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $row = $result->fetch_assoc();

        if (password_verify($password, $row["password"])) {
            $_SESSION["teacher_id"] = $teacher_id;
            header("Location: ../teacher-dashboard.html");
            exit;
        }
    }

    echo "<script>alert('Invalid Teacher ID or Password'); window.location.href='../teacher-login.html';</script>";
}
?>
