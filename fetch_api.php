<?php
// Database credentials
$host = 'sql12.freesqldatabase.com';
$dbname = 'sql12754543';
$username = 'sql12754543';
$password = 'pStI1imTDR';
$port = 3306;

// Connect to the database
try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// API Request
$api_key = 'cMencEEfDGvsQZP+GjG2rg==LB65cLmiM7pTYdPJ';
$api_url = 'https://api.api-ninjas.com/v1/hospitals?name=General Hospital';

$response = file_get_contents($api_url, false, stream_context_create([
    'http' => [
        'header' => "X-Api-Key: $api_key"
    ]
]));

if ($response === FALSE) {
    die('API Request Failed.');
}

$data = json_decode($response, true);

foreach ($data as $hospital) {
    $name = $hospital['name'];
    $state = $hospital['state'];
    $city = $hospital['city'];
    $country = 'USA';
    $details_page = strtolower(str_replace(' ', '_', $name)) . '.html';

    // Insert into the database
    $stmt = $conn->prepare("INSERT INTO hospital (name, state, city, country, details_page) VALUES (:name, :state, :city, :country, :details_page)");
    $stmt->execute([
        ':name' => $name,
        ':state' => $state,
        ':city' => $city,
        ':country' => $country,
        ':details_page' => $details_page
    ]);

    // Generate details page
    ob_start();
    include 'details_generator.php';
    $content = ob_get_clean();

    file_put_contents($details_page, $content);
}

echo "Data fetched and stored successfully.";
?>
