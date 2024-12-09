<?php
// Include database connection
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $repeat_password = trim($_POST['confirm_password']);

    // Validate input
    if (empty($name) || empty($email) || empty($password) || empty($repeat_password)) {
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    if ($password !== $repeat_password) {
        die("Passwords do not match.");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if the email already exists
    $sql_check = "SELECT id FROM users WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        die("Email is already registered.");
    }
    $stmt_check->close();

    // Insert user into the database
    $sql_insert = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sss", $name, $email, $hashed_password);

    if ($stmt_insert->execute()) {
        echo "<script>alert('User Register Successfully');</script>";
    } else {
        echo "Error: " . $stmt_insert->error;
    }

    $stmt_insert->close();
}

$conn->close();
?>
