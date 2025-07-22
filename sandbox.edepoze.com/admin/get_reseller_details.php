<?php
// Set headers for JSON response and CORS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Be more restrictive in production
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Basic security check
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'superadmin') {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
    exit();
}

// Database connection parameters
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "";     // Your MySQL password
$dbname = "edepoze_Db"; // The database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Get the Reseller ID from the GET request
$resellerId = $_GET['ID'] ?? null;

if (empty($resellerId) || !is_numeric($resellerId)) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Invalid or missing Reseller ID.']);
    exit();
}

// SQL query to fetch all details for a specific reseller
$sql = "SELECT
            id AS ID,
            reseller_name AS `Reseller Name`,
            type AS `Type`,
            level AS `Level`,
            primary_contact_name AS `Primary Contact`,
            primary_contact_email AS `PrimaryContactEmail`,
            primary_contact_phone AS `PrimaryContactPhone`,
            DATE_FORMAT(reseller_since, '%m/%d/%Y') AS `Reseller Since`,
            CASE
                WHEN status = TRUE THEN 'Active'
                ELSE 'Deactivated'
            END AS `Status`,
            CASE
                WHEN video_conf_enabled = TRUE THEN 'Enabled'
                ELSE 'Disabled'
            END AS `Video Conf`,
            live_transcripts_email AS `LiveTranscriptsEmail`,
            address1 AS `Address1`,
            address2 AS `Address2`,
            city AS `City`,
            country_code AS `CountryCode`,
            state_province_region AS `StateProvinceRegion`,
            zip_postal_code AS `ZipPostalCode`,
            sales_rep AS `SalesRep`,
            url_slug AS `UrlSlug`,
            description AS `Description`,
            banner_color AS `BannerColor`,
            banner_text_color AS `BannerTextColor`,
            logo_name AS `LogoName`,
            -- Assuming subscription_fee is a column in your resellers table
            subscription_fee AS `SubscriptionFee`,
            -- Placeholder for admin user details if they are part of the reseller object.
            -- If admin users are in a separate table, you'd need a JOIN or separate API.
            -- For now, these are illustrative and assume they are direct fields or can be derived.
            NULL AS AdminFirstName, -- Replace with actual column if exists or join
            NULL AS AdminLastName,  -- Replace with actual column if exists or join
            NULL AS AdminEmail,     -- Replace with actual column if exists or join
            NULL AS AdminUsername   -- Replace with actual column if exists or join
        FROM resellers
        WHERE id = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database prepare error: ' . $conn->error]);
    exit();
}

$stmt->bind_param("i", $resellerId);
$stmt->execute();
$result = $stmt->get_result();

$resellerData = null;
if ($result->num_rows === 1) {
    $resellerData = $result->fetch_assoc();
}

$stmt->close();
$conn->close();

if ($resellerData) {
    echo json_encode(['status' => 'success', 'data' => $resellerData]);
} else {
    http_response_code(404); // Not Found
    echo json_encode(['status' => 'error', 'message' => 'Reseller not found.']);
}
// No closing PHP tag to prevent accidental whitespace output
