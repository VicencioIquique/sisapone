<?php 
require_once("../../clases/conexion.php");

$id = $_POST['ide'];


$db = new MySQL();
$delete = $db->delete("DELETE FROM ciudad WHERE idCiudad = '$id'") or die (mysql_error());


?>