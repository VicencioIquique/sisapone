<?php 
require_once("../../clases/conexion.php");
require_once("../../clases/funciones.php");

 function cambiarFecha($fecha) {
					  return implode("-", array_reverse(explode("/", $fecha)));
					}
					


$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$rut = int_rut($_POST['rut']);
$fnacimiento = cambiarFecha($_POST['fnacimiento']);
$fcontrato = cambiarFecha($_POST['fcontrato']);
$pais = $_POST['pais'];
$direccion = $_POST['direccion'];
$fono = $_POST['fono'];
$fono2 = $_POST['fono2'];
$email = $_POST['email'];
$nCargas = $_POST['nCargas'];
$cargo = $_POST['cargo'];
$fingreso = cambiarFecha($_POST['fingreso']);
$empresa = $_POST['empresa'];
$sueldoBase = $_POST['sueldoBase'];
$pactado = $_POST['pactado'];
$afp = $_POST['afp'];
$salud = $_POST['salud'];
$cCosto = $_POST['cCosto'];
$activo = $_POST['activo'];
$bodega = $_POST['activo'];


$db = new MySQL();
$insert = $db->insert("INSERT INTO empleado (estadoenEmpresa,
rut,
nombres,
apellidos,
fnacimiento,
fechaIngreso,
fechaContrato,
paisnacionalidad,
cargo,
fono,
fono2,
email,
direccion,
sueldoBase,
nCargas,
centroCosto,
planIsapre,
planAfp,
pactadoSalud,
planta,
afc,
salud_idSalud,
afp_idAfp,
bodega_idBodega,
empresa_idEmpresa)
VALUES(1,'".$rut."','".$nombres."','".$apellidos."','".$fnacimiento."','".$fingreso."','".$fcontrato."',".$pais.",'".$cargo."',".$fono.",".$fono2.",'".$email."',
		'".$direccion."',".$sueldoBase.",".$nCargas.",".$cCosto.",0,0,".$pactado.",".$activo.",0,".$salud.",".$afp.",".$bodega.",".$empresa.")") or die (mysql_error());


?>