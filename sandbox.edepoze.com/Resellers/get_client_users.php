<?php
// Set headers for JSON response and CORS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Be more restrictive in production
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Start the session to check for superadmin authentication
session_start();

// Basic security check: Ensure the user is logged in and has the 'superadmin' role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'superadmin') {
    http_response_code(401); // Unauthorized
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
    exit();
}

// Database connection parameters
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "";     // Your MySQL password
$dbname = "edepoze_Db"; // The database name

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if connection was successful
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Get the Client Admin ID from the GET request
$clientAdminId = $_GET['client_admin_id'] ?? null;

if (empty($clientAdminId) || !is_numeric($clientAdminId)) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Invalid or missing Client Admin ID.']);
    exit();
}

// SQL query to fetch client user data for a specific client admin
// Adjust column names and aliases as needed to match your actual 'client_users' table structure
$sql = "SELECT
            id AS ID,
            user_name AS username, -- Assuming 'user_name' is the column for the user's name
            status AS Status -- Assuming 'status' column exists
        FROM client_users
        WHERE client_admin_id = ?
        ORDER BY user_name ASC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database prepare error: ' . $conn->error]);
    exit();
}

$stmt->bind_param("i", $clientAdminId);
$stmt->execute();
$result = $stmt->get_result();

$clientUsers = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $clientUsers[] = $row;
    }
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Return the fetched data as JSON
echo json_encode(['status' => 'success', 'data' => $clientUsers]);

?>
