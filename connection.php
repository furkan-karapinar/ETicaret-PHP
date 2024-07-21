<?php
$servername = "localhost";
$username = "php_root"; 
$password = "password"; 
$database = "eticaret";

// MySQL veritabanına bağlantı oluşturma
$conn = new mysqli($servername, $username, $password, $database);

// Bağlantıyı kontrol etme
if ($conn->connect_error) {
    die("Connection Error: " . $conn->connect_error);
}

?>
