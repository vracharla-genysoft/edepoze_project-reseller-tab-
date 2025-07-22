<?php
// Set headers for JSON response and CORS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Be more restrictive in production, e.g., 'http://your-superadmin-domain.com'
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

// Database connection parameters (ensure these match your actual database credentials)
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "";     // Your MySQL password (empty string as provided in your other scripts)
$dbname = "edepoze_Db"; // The database name

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if connection was successful
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// SQL query to fetch client data
// Adjust column names and aliases as needed to match your actual 'clients' table structure
$sql = "SELECT
            id AS ID,
            client_name AS `Client Name`,
            type AS `Type`,
            contact_person AS `Primary Contact`,
            contact_email AS `Primary Contact Email`,
            DATE_FORMAT(created_at, '%m/%d/%Y') AS `Client Since`,
            CASE
                WHEN status = TRUE THEN 'Active'
                ELSE 'Deactivated'
            END AS `Status`
        FROM clients
        ORDER BY `Client Name` ASC"; // Order by client name for a sorted list

$result = $conn->query($sql);

$clients = [];
if ($result->num_rows > 0) {
    // Fetch all rows as associative arrays
    while($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
}

// Close the database connection
$conn->close();

// Return the fetched data as JSON
echo json_encode(['status' => 'success', 'data' => $clients]);

// No closing PHP tag to prevent accidental whitespace output
