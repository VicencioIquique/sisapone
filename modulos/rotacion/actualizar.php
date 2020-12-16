<link rel="stylesheet" type="text/css" href="../../temas/minimalverde/minimalverde.css"><!-- estilos geneales-->
<?php 
require_once("../../clases/conexion.php"); 
require_once("../../clases/funciones.php");

 function cambiarFecha($fecha) {
					  return implode("-", array_reverse(explode("/", $fecha)));
					}
					

$idEmp = $_POST['idEmp'];
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
$bodega = $_POST['bodega'];
$planta = $_POST['fijo'];
$sexo = $_POST['sexo'];
$afc = $_POST['afc'];

echo "<div id='mensajeactualizado'>Datos Actualizados</div>";
$db = new MySQL();
$update = $db->update("UPDATE  empleado
						SET 
						estadoenEmpresa = $activo,
						rut='$rut' ,
						nombres='$nombres' ,
						apellidos='$apellidos' ,
						sexo='$sexo' ,
						fnacimiento='$fnacimiento' ,
						fechaIngreso='$fingreso' ,
						fechaContrato='$fcontrato' ,
						paisnacionalidad= $pais,
						cargo='$cargo' ,
						fono=$fono ,
						fono2=$fono2 ,
						email='$email' ,
						direccion='$direccion' ,
						sueldoBase=$sueldoBase ,
						nCargas=$nCargas ,
						centroCosto=$cCosto ,
						planIsapre=0 ,
						planAfp=0 ,
						pactadoSalud=$pactado ,
						planta=$planta ,
						afc=$afc ,
						salud_idSalud=$salud ,
						afp_idAfp=$afp ,
						bodega_idBodega=$bodega ,
						empresa_idEmpresa=$empresa 						
						WHERE   idEmpleado = $idEmp ") or die (mysql_error());




?>
