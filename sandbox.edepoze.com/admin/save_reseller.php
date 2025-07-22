<?php
// Set headers for JSON response and CORS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Be more restrictive in production
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Basic security check (ensure only superadmin can add/edit)
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'superadmin') {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
    exit();
}

// Database connection parameters
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "";     // Your MySQL password (empty string as provided)
$dbname = "edepoze_Db"; // The database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Get POST data
// Using null coalescing operator (??) for cleaner access and default empty string
$id = $_POST['ID'] ?? null; // Will be null for new records, set for updates
$reseller_name = $_POST['name'] ?? '';
$type = $_POST['resellerClass'] ?? '';
$level = $_POST['resellerLevel'] ?? '';
$primary_contact_name = $_POST['contactName'] ?? '';
$primary_contact_email = $_POST['contactEmail'] ?? '';
$primary_contact_phone = $_POST['contactPhone'] ?? '';
$reseller_since_raw = $_POST['startDate'] ?? ''; // Format: MM/DD/YYYY
$status = ($_POST['deactivated'] ?? '0') === '0' ? TRUE : FALSE; // '0' for Active, '1' for Deactivated
$video_conf_enabled = ($_POST['videoDeactivated'] ?? '0') === '0' ? TRUE : FALSE; // '0' for Enabled, '1' for Disabled
$live_transcripts_email = $_POST['liveTranscriptsEmail'] ?? null;
$address1 = $_POST['address1'] ?? '';
$address2 = $_POST['address2'] ?? null;
$city = $_POST['city'] ?? '';
$country_code = $_POST['countryCode'] ?? '';

// Determine state/province/region and zip/postal code based on country_code
$state_province_region = null;
$zip_postal_code = null;

if ($country_code === 'US') {
    $state_province_region = $_POST['state'] ?? null;
    $zip_postal_code = $_POST['ZIP'] ?? null;
} elseif ($country_code === 'CA') {
    $state_province_region = $_POST['province'] ?? null;
    $zip_postal_code = $_POST['postCode'] ?? null;
} elseif ($country_code === 'OT') { // Other
    $state_province_region = $_POST['region'] ?? null;
    $zip_postal_code = $_POST['postCode'] ?? null;
}

$sales_rep = $_POST['salesRep'] ?? null;
$url_slug = $_POST['URL'] ?? '';
$description = $_POST['description'] ?? null;
$banner_color = $_POST['bannerColor'] ?? '#FFFFFF';
$banner_text_color = $_POST['bannerTextColor'] ?? '#000000';
$logo_name = $_POST['logoName'] ?? null; // Assuming logo upload is handled separately or just the name is passed

// Convert reseller_since date from MM/DD/YYYY to YYYY-MM-DD for MySQL
$reseller_since = null;
if (!empty($reseller_since_raw)) {
    $date_obj = DateTime::createFromFormat('m/d/Y', $reseller_since_raw);
    if ($date_obj) {
        $reseller_since = $date_obj->format('Y-m-d');
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid "Reseller Since" date format. Expected MM/DD/YYYY.']);
        exit();
    }
}

// Basic validation (add more robust validation as needed)
$errors = [];
if (empty($reseller_name)) $errors[] = 'Reseller Name is required.';
if (empty($type)) $errors[] = 'Reseller Type is required.';
if (empty($primary_contact_name)) $errors[] = 'Primary Contact Name is required.';
if (empty($primary_contact_email) || !filter_var($primary_contact_email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid Primary Contact Email is required.';
if (empty($primary_contact_phone)) $errors[] = 'Primary Contact Phone is required.';
if (empty($reseller_since)) $errors[] = 'Reseller Since date is required.';
if (empty($address1)) $errors[] = 'Address Line 1 is required.';
if (empty($city)) $errors[] = 'City is required.';
if (empty($country_code)) $errors[] = 'Country is required.';
if (empty($url_slug)) $errors[] = 'URL is required.';

if ($country_code === 'US' && empty($state_province_region)) $errors[] = 'State is required for US.';
if ($country_code === 'US' && empty($zip_postal_code)) $errors[] = 'ZIP is required for US.';
if ($country_code === 'CA' && empty($state_province_region)) $errors[] = 'Province is required for Canada.';
if ($country_code === 'CA' && empty($zip_postal_code)) $errors[] = 'Postal Code is required for Canada.';
if ($country_code === 'OT' && empty($state_province_region)) $errors[] = 'Region is required for Other countries.';
if ($country_code === 'OT' && empty($zip_postal_code)) $errors[] = 'Postal Code is required for Other countries.';


if (!empty($errors)) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Validation failed: ' . implode(' ', $errors)]);
    exit();
}

// Check for URL slug uniqueness only if adding a new reseller or if URL slug is changed
$is_new_record = empty($id);
$url_slug_check_sql = "SELECT id FROM resellers WHERE url_slug = ?";
if (!$is_new_record) {
    $url_slug_check_sql .= " AND id != ?";
}
$stmt_check_url = $conn->prepare($url_slug_check_sql);

if (!$stmt_check_url) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database prepare error (URL check): ' . $conn->error]);
    exit();
}

if ($is_new_record) {
    $stmt_check_url->bind_param("s", $url_slug);
} else {
    $stmt_check_url->bind_param("si", $url_slug, $id);
}
$stmt_check_url->execute();
$result_check_url = $stmt_check_url->get_result();

if ($result_check_url->num_rows > 0) {
    http_response_code(409); // Conflict
    echo json_encode(['status' => 'error', 'message' => 'The provided URL slug is already in use. Please choose a different one.', 'error_field' => 'URL']);
    exit();
}
$stmt_check_url->close();


// Prepare SQL statement for insert or update
if ($is_new_record) {
    // Insert new reseller
    $sql = "INSERT INTO resellers (
                reseller_name, type, level, primary_contact_name, primary_contact_email,
                primary_contact_phone, reseller_since, status, video_conf_enabled,
                live_transcripts_email, address1, address2, city, country_code,
                state_province_region, zip_postal_code, sales_rep, url_slug, description,
                banner_color, banner_text_color, logo_name
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Database prepare error (insert): ' . $conn->error]);
        exit();
    }
    $stmt->bind_param("sssssssissssssssssssss",
        $reseller_name, $type, $level, $primary_contact_name, $primary_contact_email,
        $primary_contact_phone, $reseller_since, $status, $video_conf_enabled,
        $live_transcripts_email, $address1, $address2, $city, $country_code,
        $state_province_region, $zip_postal_code, $sales_rep, $url_slug, $description,
        $banner_color, $banner_text_color, $logo_name
    );
} else {
    // Update existing reseller
    $sql = "UPDATE resellers SET
                reseller_name = ?, type = ?, level = ?, primary_contact_name = ?, primary_contact_email = ?,
                primary_contact_phone = ?, reseller_since = ?, status = ?, video_conf_enabled = ?,
                live_transcripts_email = ?, address1 = ?, address2 = ?, city = ?, country_code = ?,
                state_province_region = ?, zip_postal_code = ?, sales_rep = ?, url_slug = ?, description = ?,
                banner_color = ?, banner_text_color = ?, logo_name = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Database prepare error (update): ' . $conn->error]);
        exit();
    }
    $stmt->bind_param("sssssssissssssssssssssi",
        $reseller_name, $type, $level, $primary_contact_name, $primary_contact_email,
        $primary_contact_phone, $reseller_since, $status, $video_conf_enabled,
        $live_transcripts_email, $address1, $address2, $city, $country_code,
        $state_province_region, $zip_postal_code, $sales_rep, $url_slug, $description,
        $banner_color, $banner_text_color, $logo_name, $id
    );
}

if ($stmt->execute()) {
    $response = ['status' => 'success', 'message' => 'Reseller saved successfully.'];
    if ($is_new_record) {
        $response['new_id'] = $conn->insert_id;
        // Redirect to superadmin.php after successful add
        $response['redirect_url'] = '/EDEPOZE_PROJECT/sandbox.edepoze.com/sbvrr1/superadmin.php';
    } else {
        // Redirect to superadmin.php after successful edit
        $response['redirect_url'] = '/EDEPOZE_PROJECT/sandbox.edepoze.com/sbvrr1/superadmin.php';
    }
} else {
    http_response_code(500);
    $response = ['status' => 'error', 'message' => 'Failed to save reseller: ' . $stmt->error];
}

$stmt->close();
$conn->close();

echo json_encode($response);
// No closing PHP tag to prevent accidental whitespace output
