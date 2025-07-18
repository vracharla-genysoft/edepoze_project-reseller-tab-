<?php
// login_process.php

ini_set('display_errors', 0);
error_reporting(0);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

// Get credentials
$username = $_POST['username'] ?? '';
$password = $_POST['passauth'] ?? '';

$response = [
    'status' => false,
    'message' => 'Invalid username or password.'
];

// DB connection
$host = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "edepoze_Db";

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    $response['message'] = 'Database connection failed.';
    echo json_encode($response);
    exit();
}

// Prepare and execute SQL
$stmt = $conn->prepare("SELECT id, username, role FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    // Redirect based on role
    switch ($user['role']) {
        case 'superadmin':
            $response['redirect_url'] = '/EDEPOZE_PROJECT/sandbox.edepoze.com/sbvrr1/superadmin.php';
            break;
        case 'admin':
            $response['redirect_url'] = '/EDEPOZE_PROJECT/sandbox.edepoze.com/sbvrr1/admin.php';
            break;
        case 'user':
            $response['redirect_url'] = '/EDEPOZE_PROJECT/sandbox.edepoze.com/sbvrr1/index.php';
            break;
        default:
            $response['message'] = 'Unauthorized role access.';
            echo json_encode($response);
            exit();
    }

    $response['status'] = true;
    $response['message'] = 'Login successful!';
}

$stmt->close();
$conn->close();

echo json_encode($response);
exit();
