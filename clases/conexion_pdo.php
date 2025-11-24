<?php
// En: clases/conexion_pdo.php
$host = '192.168.3.40';
$dbName = 'RP_VICENCIO';
$user = 'sa';
$pass = 'U4xyyBLk56';

try {
    // DSN para SQL Server
    $conn = new PDO("sqlsrv:Server=$host,1433;Database=$dbName", $user, $pass);
    
    // Configurar PDO para que lance excepciones en caso de error
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Manejo de error de conexión
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}
?>