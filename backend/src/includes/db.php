<?php
// db.php - Conexión a la base de datos

$servername = "db"; // Cambia por tu servidor de base de datos
$username = "root"; // Cambia por tu usuario de base de datos
$password = "rootpassword"; // Cambia por tu contraseña de base de datos
$dbname = "inventario"; // Nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
