<?php
// update_reseller_status.php

// --- 1. Configure Error Reporting ---
// IMPORTANT: For production, set display_errors to 0 and ensure error_log is configured.
// For debugging: uncomment the first two lines, comment out the last three.
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
error_reporting(E_ALL); // Report all errors for logging
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', __DIR__ . '/../logs/php_error.log'); // <-- ABSOLUTELY CHANGE THIS PATH to a writable log file on your server, ideally outside your web root.

session_start();

// --- 2. Set Content-Type Header Early ---
// This ensures the browser expects JSON right away, helping prevent the "<" error.
header('Content-Type: application/json');

// --- 3. Security Check: Superadmin Role ---
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'superadmin') {
    // If unauthorized, return JSON error and exit
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access. Please log in as a superadmin.']);
    exit();
}

// --- 4. Include Database Connection ---
// Adjust this path based on your project's structure.
// __DIR__ refers to the directory of the current file.
// Example: If your database_connection.php is one level up from "Resellers" folder:
require_once __DIR__ . '/../path/to/your/database_connection.php'; 
// Or if it's in a completely different common folder, adjust accordingly.
// e.g., require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/database_connection.php';

// Ensure the $pdo object is available after including the connection file.
// If your connection file directly creates $pdo, great. Otherwise, ensure it does.
if (!isset($pdo) || !$pdo instanceof PDO) {
    error_log("Database connection variable \$pdo not set or not a PDO object in update_reseller_status.php.");
    echo json_encode(['status' => 'error', 'message' => 'Internal server error: Database connection not established.']);
    exit();
}


// --- 5. Process POST Request ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resellerId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT); // 0 for Deactive, 1 for Active

    // Input validation
    if ($resellerId === null || $resellerId === false || ($status !== 0 && $status !== 1)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input parameters. Reseller ID or status is missing/incorrect.']);
        exit();
    }

    try {
        // --- 6. Prepare and Execute SQL Statement ---
        // IMPORTANT: Replace 'your_resellers_table' and 'status_column'
        // with the actual names from your database.
        $stmt = $pdo->prepare("UPDATE your_resellers_table SET status_column = :status WHERE ID = :id");
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':id', $resellerId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                // Success: Dynamic message based on new status
                $action = ($status === 1) ? 'activated' : 'deactivated';
                echo json_encode(['status' => 'success', 'message' => "Reseller successfully {$action}!"]);
            } else {
                // No rows affected: Reseller not found or status already matches
                echo json_encode(['status' => 'error', 'message' => 'Reseller not found or its status is already as requested.']);
            }
        } else {
            // SQL execution failed (e.g., malformed query, but caught by PDO::ATTR_ERRMODE_EXCEPTION usually)
            // This block might be less frequently hit if PDO is set to throw exceptions.
            $errorInfo = $stmt->errorInfo();
            error_log("SQL execution failed for ID {$resellerId}, Status {$status}: " . print_r($errorInfo, true));
            echo json_encode(['status' => 'error', 'message' => 'Failed to update reseller status in database. Please check server logs for details.']);
        }
    } catch (PDOException $e) {
        // --- 7. Catch Database Exceptions ---
        // Log the actual database error for debugging
        error_log("PDO Exception for ID {$resellerId}, Status {$status}: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'A database error occurred during the update process.']);
    }
} else {
    // --- 8. Handle Invalid Request Method ---
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method. Only POST requests are allowed for this operation.']);
}

// --- 9. Omit Closing PHP Tag (Best Practice) ---
// This helps prevent accidental whitespace/newlines after the tag that could
// break JSON output.