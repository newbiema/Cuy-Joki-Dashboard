<?php
// db.php
$host = 'localhost';
$dbname = 'cuyjoki'; 
$user = 'root';
$password = '';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
