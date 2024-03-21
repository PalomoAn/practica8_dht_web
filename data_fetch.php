<?php
// Include database connection constants
require_once('config.php');

// Establish database connection
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME) or die("Unable to connect to MySQL");

// Prepare and execute the SQL query to fetch all data
$sql = "SELECT temperature, humidity, pressure, light, logdate FROM " . TB_ENV;
$result = mysqli_query($conn, $sql);

// Fetch all data
$allData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $allData[] = $row;
}

// Close connection
mysqli_close($conn);

// Pass the data array to JavaScript
echo json_encode($allData);
?>