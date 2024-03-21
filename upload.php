<?php
// Include database connection constants
require_once('config.php');

// Establish database connection
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME) or die("Unable to connect to MySQL");

// Sanitize and validate input values
$temperature = isset($_POST['temperature']) ? floatval($_POST['temperature']) : null;
$humidity = isset($_POST['humidity']) ? floatval($_POST['humidity']) : null;
$pressure = isset($_POST['pressure']) ? floatval($_POST['pressure']) : null;
$light = isset($_POST['light']) ? floatval($_POST['light']) : null;

$logdate = date("Y-m-d H:i:s");

// Prepare and execute the SQL query using prepared statements
$insertSQL = "INSERT INTO " . TB_ENV . " (logdate, temperature, humidity, pressure, light) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $insertSQL);
mysqli_stmt_bind_param($stmt, 'sddds', $logdate, $temperature, $humidity, $pressure, $light);

if (mysqli_stmt_execute($stmt)) {
    echo "Data inserted successfully!";
} else {
    echo "Failed to insert data: " . mysqli_error($conn);
}

// Close statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>