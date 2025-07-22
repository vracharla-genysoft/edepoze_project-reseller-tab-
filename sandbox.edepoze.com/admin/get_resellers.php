<?php
// Set headers for JSON response and CORS (if your frontend is on a different domain/port)
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Be more restrictive in production, e.g., 'http://your-superadmin-domain.com'
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Basic security check (you might integrate this with your session_start() logic later)
// For now, we'll keep it simple as the request is to fetch data for superadmin dashboard.
// In a real application, you'd check if the user is logged in and has 'superadmin' role.
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'superadmin') {
    // Return an error if not authorized
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
    exit();
}

// Database connection parameters from your login_process.php
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "";     // Your MySQL password (empty string as provided)
$dbname = "edepoze_Db"; // The database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// SQL query to fetch reseller data
// We select the columns matching the frontend table headers
$sql = "SELECT
            id AS ID,
            reseller_name AS `Reseller Name`,
            type AS `Type`,
            level AS `Level`,
            primary_contact_name AS `Primary Contact`,
            DATE_FORMAT(reseller_since, '%m/%d/%Y') AS `Reseller Since`,
            CASE
                WHEN status = TRUE THEN 'Active'
                ELSE 'Deactivated'
            END AS `Status`,
            CASE
                WHEN video_conf_enabled = TRUE THEN 'Enabled'
                ELSE 'Disabled'
            END AS `Video Conf`
        FROM resellers";

$result = $conn->query($sql);

$resellers = [];
if ($result->num_rows > 0) {
    // Fetch all rows as associative arrays
    while($row = $result->fetch_assoc()) {
        $resellers[] = $row;
    }
}

$conn->close();

// Return data as JSON
echo json_encode(['status' => 'success', 'data' => $resellers]);

// No closing PHP tag to prevent accidental whitespace output
