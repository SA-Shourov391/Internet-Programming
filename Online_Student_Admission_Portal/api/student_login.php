<?php
session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $student_id = trim($_POST["student_id"]);
    $password   = trim($_POST["password"]);

    // ========= Temporary Hardcoded Login (DEV MODE) =========
    $allowed_ids = [
        "2223081033" => "2223081033",
        "2223081027" => "2223081027",
        "2223081036" => "2223081036"
    ];

    if (isset($allowed_ids[$student_id]) && $allowed_ids[$student_id] === $password) {
        $_SESSION["student_id"] = $student_id;
        header("Location: ../student-dashboard.html");
        exit;
    }
    // =========================================================

    // == PRODUCTION LOGIN (FROM DATABASE) ==
    $sql = "SELECT * FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $row = $result->fetch_assoc();

        if (password_verify($password, $row["password"])) {
            $_SESSION["student_id"] = $student_id;
            header("Location: ../student-dashboard.html");
            exit;
        }
    }

    // If fails
    echo "<script>alert('Invalid Student ID or Password'); window.location.href='../student-login.html';</script>";
}
?>
