<?php
// File path: C:\xampp\htdocs\EDEPOZE_PROJECT\sandbox.edepoze.com\Resellers\update_reseller_status.php

// --- CRITICAL: PHP Error Reporting Configuration (TEMPORARY FOR DEBUGGING) ---
// For debugging, set display_errors to 1. REMEMBER TO CHANGE IT BACK TO 0 FOR PRODUCTION!
ini_set('display_errors', 1);         // TEMPORARILY display errors on the page
ini_set('display_startup_errors', 1);   // TEMPORARILY display startup errors
error_reporting(E_ALL);                // Report all types of errors
ini_set('log_errors', 1);              // Enable error logging
// Ensure this path is correct and writable by your web server (Apache/PHP user)
ini_set('error_log', __DIR__ . '/../logs/php_error.log');


session_start();

// Set Content-Type header immediately to ensure valid JSON response
header('Content-Type: application/json');

// --- Security Check: Superadmin Role ---
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'superadmin') {
    error_log("Unauthorized access attempt to update_reseller_status.php by user: " . ($_SESSION['username'] ?? 'N/A') . ". Role: " . ($_SESSION['role'] ?? 'N/A') . " from IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'N/A'));
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access. Please log in as a superadmin.']);
    exit(); // Stop execution
}

// --- Database Connection (Using MySQLi, as your other files use it) ---
// You mentioned your other files use MySQLi, so let's stick to that for consistency.
// If you have a separate database_connection.php that sets up PDO, you'd use that.
// For now, I'll put the MySQLi connection directly here.

$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "";     // Your MySQL password
$dbname = "edepoze_Db"; // The database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Database Connection Failed in update_reseller_status.php: " . $conn->connect_error);
    echo json_encode(['status' => 'error', 'message' => 'Internal server error: Could not connect to the database.']);
    exit();
}


// --- Handle POST Request ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input from the AJAX request
    $resellerId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    // The status from JS is 0 for Deactivate, 1 for Activate.
    // Your DB 'status' column is BOOLEAN, which maps to 1 for TRUE (Active) and 0 for FALSE (Deactivated).
    $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

    // Detailed input validation to help debug
    if ($resellerId === null || $resellerId === false) {
        error_log("Invalid or missing 'id' parameter received: " . var_export($_POST['id'] ?? 'N/A', true) . " from IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'N/A'));
        echo json_encode(['status' => 'error', 'message' => 'Invalid or missing Reseller ID.']);
        $conn->close(); // Close connection before exiting
        exit();
    }
    if ($status !== 0 && $status !== 1) { // Checks if status is strictly 0 or 1
        error_log("Invalid or missing 'status' parameter received for ID {$resellerId}: " . var_export($_POST['status'] ?? 'N/A', true) . " from IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'N/A'));
        echo json_encode(['status' => 'error', 'message' => 'Invalid or missing status value.']);
        $conn->close(); // Close connection before exiting
        exit();
    }

    try {
        // --- Prepare and Execute the SQL Statement ---
        // CORRECTED: Using 'resellers' table and 'status' column
        $sql = "UPDATE resellers SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            error_log("MySQLi Prepare Failed: " . $conn->error);
            echo json_encode(['status' => 'error', 'message' => 'Database prepare error.']);
            $conn->close();
            exit();
        }

        // Bind parameters securely (s for string, i for integer)
        $stmt->bind_param("ii", $status, $resellerId); // Both are integers (0 or 1, and the ID)

        // Execute the statement
        $stmt->execute();

        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            $actionMessage = ($status === 1) ? 'activated' : 'deactivated';
            echo json_encode(['status' => 'success', 'message' => "Reseller ID {$resellerId} successfully {$actionMessage}!"]);
        } else {
            // No rows affected: This could mean the ID doesn't exist, or the status was already the requested value.
            error_log("No rows affected for ID {$resellerId}, new status {$status}. Reseller may not exist or status is already set. IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'N/A'));
            echo json_encode(['status' => 'error', 'message' => 'Reseller not found or its status is already as requested.']);
        }

        $stmt->close(); // Close the statement
        $conn->close(); // Close the connection

    } catch (Exception $e) { // Catch any general exceptions
        error_log("General Error for ID {$resellerId}, Status {$status}: " . $e->getMessage() . " | SQL: " . $sql . " | IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'N/A'));
        echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred during the update process.']);
        $conn->close(); // Ensure connection is closed on error
    }

} else {
    // Handle cases where the request method is not POST
    error_log("Invalid request method: " . $_SERVER['REQUEST_METHOD'] . " received for update_reseller_status.php from IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'N/A'));
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method. Only POST requests are allowed.']);
}
