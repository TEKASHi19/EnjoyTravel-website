<?php
$host = "localhost";
$user = "root";
$pass = ""; // Por defecto en XAMPP es vacío
$db   = "enjoy_travel";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>