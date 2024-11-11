
<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = ""; // Usually, there is no password for the root user in XAMPP
$dbname = "db_portfolio";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 3306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
