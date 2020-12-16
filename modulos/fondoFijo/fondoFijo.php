<script type="text/javascript" src="js/jquery.base64.js"></script>
<script type="text/javascript" src="js/jquery.btechco.excelexport.js"></script>
<?php
require_once("clases/conexionocdb.php");
require_once("clases/funciones.php");

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

//SESSION
$modulo = $_SESSION["usuario_modulo"];
$nombre = $_SESSION["usuario_nombre"];
$rol = $_SESSION["usuario_rol"];
$usuario = $_SESSION["usuario_user"];
$modulo =  $_SESSION["usuario_modulo"];
$idusuario =  $_SESSION["usuario_id"];

$idFondo = "";
$area = "";
$estado = "";
$idArea = "";
$fecha = "";

$idFondo = $_GET['idFondo'];
$area = $_GET['area'];
$estado = $_GET['estado'];
$fecha = $_GET['fecha'];

/* BUSCA A QUE AREA PERTENECE EL USUARIO SEGUN SU ID */
$sql="SELECT [FK_idArea] FROM [RP_VICENCIO].[dbo].[sisap_usuarios] WHERE [usuario_id] = ".$idusuario;
$rs1 = odbc_exec( $conn, $sql );
if(!$rs1) {
  exit("Error en la consulta SQL");
}
else{
  $resultado = odbc_fetch_array($rs1);
  $idArea = $resultado["FK_idArea"];
}

$ultFondoFijo = 0;
$estadoFondo =  0;
$sql = "SELECT MAX(idFondoFijo) AS IDFONDO FROM [SISAP].[dbo].[SI_FondoFijo]";
$rs2 = odbc_exec($conn, $sql);
if (!$rs2 ){
  exit("Error en la consulta SQL");
}else{
  $resultado = odbc_fetch_array($rs2);
  $NuevoFondo = $resultado["IDFONDO"] + 1;
}
$sql = "SELECT * FROM [SISAP].[dbo].[SI_FondoFijo] WHERE idEncargado =".$idusuario." AND FK_idEstado = 1";
$rs3 = odbc_exec($conn, $sql);
if (!$rs3 ){
  exit("Error en la consulta SQL");
}else{
  $resultado = odbc_fetch_array($rs3);
  $ultFondoFijo = $resultado["idFondoFijo"];
  $estadoFondo =  $resultado["FK_idEstado"];
}

function getEncargado($idencargado,$conX){
  $sql="SELECT [usuario_nombre] FROM [RP_VICENCIO].[dbo].[sisap_usuarios] WHERE [usuario_id] = ".$idencargado;
  $rs4 = odbc_exec( $conX, $sql );
  if(!$rs4) {
    exit( "Error en la consulta SQL" );
  }else{
    $resultado = odbc_fetch_array($rs4);
    return($resultado["usuario_nombre"]);
  }
}
?>

<script type="text/javascript">
  $(document).ready(function(){
				//comienza focus en modulo
				$('#numDoc').focus();

        // calendarios en text de fecha inicio fin
        $( "#fecha" ).datepicker({
          dateFormat: 'dd/mm/yy',
          changeMonth: true,
          changeYear: true,

          showButtonPanel: true,

          onClose: function(dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).val($.datepicker.formatDate('mm/yy', new Date(year, month, 1)));
          }
        } );
        $("#fecha").focus(function () {
          $(".ui-datepicker-calendar").hide();
          $("#ui-datepicker-div").position({
            my: "center top",
            at: "center bottom",
            of: $(this)
          });
        });
        //formatos de las fechas

        //PARA QUE SE PUEDA HACER CLICK EN TODAS LAS FILAS
      /* $('table tr').click(function(){
          window.location = $(this).attr('href');
          return false;
        });*/
});
function impExcelGeneral(idFondoFijo){
	var json = {
			id:idFondoFijo
		};
		$.post('modulos/fondoFijo/exportaGeneral.php', {id:json}, function(resPHP){
			var respuesta = $.parseJSON(resPHP);
			var tabla = '<table cellpadding="0" cellspacing="0" border="1" style="display:none;" id="detalle_fondo_fijo">';
                tabla += '<caption>FONDO FIJO N° '+ respuesta[0]['idFondoFijo'] +' RESPONSABLE '+ respuesta[0]['usuario'] +'</caption>';
                tabla += '<thead>';
                tabla += '<tr>';
                tabla += '<th>N°</th><th>FECHA</th><th>N° DOCUMENTO</th><th>TITULO</th><th>COMENTARIO</th><th>COSTO</th><th>NEGOCIO</th><th>CONCEPTO</th><th>Norma de Reparto</th>';
                tabla += '</tr>';
                tabla += '</thead>';
                tabla += '<tbody>';
                tr = '';
 
                for(i=0;i<respuesta.length;i++){
                    tr += '<tr>';
                    tr += '<td>'+respuesta[i]['idDetalleFondoFijo']+'</td><td>'+respuesta[i]['fecha']+'</td><td>'+respuesta[i]['documento']+'</td><td>'+respuesta[i]['titulo']+'</td><td>'+respuesta[i]['descripcion']+'</td><td>'+respuesta[i]['costo']+'</td><td>'+respuesta[i]['negocio']+'</td><td>'+respuesta[i]['concepto']+'</td><td>'+respuesta[i]['norma']+'-'+respuesta[i]['normanombre']+'</td>';
                    tr += '</tr>';
                }
 
                tabla += tr;
                tabla += '</tbody></table>';
 
            $('#detalleFondo').html( tabla );
	});
	$("#detalle_fondo_fijo").btechco_excelexport({
			containerid: "detalle_fondo_fijo"
		   , datatype: $datatype.Table
	});
}
function impExcelConcepto(idFondoFijo){
	var json = {
			id:idFondoFijo
		};
		$.post('modulos/fondoFijo/exportaGeneral.php', {id:json}, function(resPHP){
			var respuesta = $.parseJSON(resPHP);
			var tabla = '<table cellpadding="0" cellspacing="0" border="1" style="display:none;" id="detalle_fondo_fijo">';
                tabla += '<caption>FONDO FIJO N° '+ respuesta[0]['idFondoFijo'] +' RESPONSABLE '+ respuesta[0]['usuario'] +'</caption>';
                tabla += '<thead>';
                tabla += '<tr>';
                tabla += '<th>CONCEPTO</th><th>COSTO</th><th>Norma de Reparto</th>';
                tabla += '</tr>';
                tabla += '</thead>';
                tabla += '<tbody>';
                tr = '';
 
                for(i=0;i<respuesta.length;i++){
                    tr += '<tr>';
                    tr += '<td>'+respuesta[i]['concepto']+'</td><td>'+respuesta[i]['costo']+'</td><td>'+respuesta[i]['norma']+'</td>';
                    tr += '</tr>';
                }
 
                tabla += tr;
                tabla += '</tbody></table>';
 
            $('#detalleFondo').html( tabla );
	});
	$("#detalle_fondo_fijo").btechco_excelexport({
			containerid: "detalle_fondo_fijo"
		   , datatype: $datatype.Table
	});
}

function impSAP(idFondoFijo, Estado){
	if(Estado != 4){
		alert("El Fondo Fijo no esa Terminado");
	}else{
		$.post("modulos/fondoFijo/aceptaFondo.php", {idFondoFijo: idFondoFijo},function(){
				alert("Se ha enviado a SAP el Fondo Fijo con ID: " + idFondoFijo);
				location.href='index.php?opc=fondoFijo';
			});
	}
}
</script>
<?php
echo'
<script type="text/javascript">
function crearNuevoFondo(){
    var estadoF = "'. $estadoFondo .'";
    var ultimoF = "'. $ultFondoFijo .'";
    if(confirm("¿Desea crear un nuevo fondo fijo?") == true){
      if(estadoF == 1){
        alert("Debes finalizar el Fondo Fijo Nº " + ultimoF);
      }else{
        document.getElementById("horizontalFormB").submit();
      }
    }
}
</script>';
?>
<div class="idTabs">
      <ul>
        <li><a href="#one"><img src="images/buscar.png" width="30px" height="30px" /></a></li>
		<?php
            if($idfondo){
                echo '<form action="" method="post" target="_blank" id="FormularioExportacion">
			         <center><img src="images/excel.png" width="30px" height="30px" class="botonExcel"  /> </center>
			         <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
			         </form>';
            }
        ?>
	 </ul>
      <div class="items">
        <div id="one"> <form action="" method="GET" id="horizontalForm">
            <fieldset>
				<legend>Fondo Fijo</legend>
                    <input name="opc" id="opc" type="hidden" size="40" class="required" value="fondoFijo" />
                    <label>Numero:
				            <input  name="idFondo" id="idFondo" type="text" class="styled" size="5" value="<?php echo $idFondo; ?>"  />
                    </label>
                    <label>Fecha:
                    <input id="fecha" name="fecha" type="text" size="40" class="styled" value="<?php echo $fecha; ?>" />
                    </label>
                    <label class="first" for="title1">Area
                    <select id="area" name="area" class="styled" <?php if($idArea != 1) { if ($idusuario != 107){ echo 'disabled'; } }  ?> >
                      <option ></option>
							        <?php
                        $sql = "SELECT [idArea],[description] FROM [SISAP].[dbo].[SI_Area]";
								        $rs5 = odbc_exec( $conn, $sql );
								        if(!$rs5){
								           exit( "Error en la consulta SQL" );
                        }else{
								          while($resultado = odbc_fetch_array($rs5)){
									          echo "<option value=".$resultado['idArea']."> ".utf8_encode($resultado['description'])."</option>";
                          }
                        }
                      ?>
                    </select>
                    </label>
                    <label class="first" for="title1">Estado
                    <select id="estado" name="estado" class="styled">
                      <option ></option>
							        <?php
                        $sql = "SELECT * FROM [SISAP].[dbo].[SI_ESTADO]";
								        $rs5 = odbc_exec( $conn, $sql );
								        if(!$rs5){
								           exit( "Error en la consulta SQL" );
                        }else{
								          while($resultado = odbc_fetch_array($rs5)){
									          echo "<option value=".$resultado['idEstado']."> ".utf8_encode($resultado['name'])."</option>";
                          }
                        }
                      ?>
                    </select>
                    </label>
                    <input name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />
            </fieldset>
        </form>
        </div> <!-- fin div two-->
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->

<div id="usual1" class="usual" >
<div id="tab1">
  <table  id="ssptable2" class="t1" >
    <thead>
        <tr href="#">
          <th style="font-size:14px;" valign="middle" colspan="2">Fondos Fijos</th>
          <th></th>
           <?php
			if($idusuario == 107){
				echo '<th></th>';
			}
		?>
          <th valign="middle" colspan="4">
            <form id="horizontalFormB" name="horizontalFormB" method="GET">
              <input name="opc" id="opc" type="hidden" size="40" class="required" value="detalleFondoFijo" />
              <input name="idArea" id="idArea" type="hidden" size="40" class="required" value="<?php echo $idArea; ?>" />
              <input name="idNuevoFondo" id="idNuevoFondo" type="hidden" size="40" class="required" value="<?php echo $NuevoFondo; ?>" />
              <input name="agregarFondoFijo" id="agregarFondoFijo" type="hidden" size="40" class="required" value="SI" />
              <input name="nuevo" type="button" id="nuevo" class="submit" value="Nuevo Fondo Fijo" onclick="crearNuevoFondo();" />
            </form>
          </th>
        </tr>
    </thead>
    <thead>
      <tr href="#">
        <th>Nº</th>
        <th>RESPONSABLE</th>
		<th>FECHA</th>
        <th>AREA</th>
		<th>ESTADO</th>
      	<th></th>
        <th></th>
        <?php
			if($idusuario == 107){
				echo '<th></th>';
			}
		?>
      </tr>
    </thead>
    <tbody>
                <?php
                    $where_query = '';
                    if($idFondo != ""){
                        $where_query = $where_query . " AND A.idFondoFijo='". $idFondo ."'";
                    }
                    if($area != ""){
                        $where_query = $where_query . " AND A.FK_idArea='". $area ."'";
                    }
                    if($fecha != ""){
                        $where_query = $where_query . " AND CONVERT(CHAR(10),A.createDate,103) LIKE '%' + '". $fecha ."'";
                    }
                    if($estado != ""){
                        $where_query = $where_query . " AND A.FK_idEstado='". $estado ."'";
                    }
					if($idusuario != 107){
						if($rol != 1){
							$where_query = $where_query . " AND idEncargado='".$idusuario."'";
						}
					}
                   $sql = "
                   SELECT
                      A.idFondoFijo
                      ,CONVERT(CHAR(10),A.createDate,103) AS createDate
                      ,A.idEncargado
					  ,A.FK_idEstado
                      ,B.name
                      ,C.description
                   FROM [SISAP].[dbo].[SI_FondoFijo] AS A
                      INNER JOIN [SISAP].[dbo].[SI_Estado] AS B ON A.FK_idEstado = B.idEstado
                      INNER JOIN [SISAP].[dbo].[SI_Area] AS C ON A.FK_idArea = C.idArea
                   WHERE
                      1=1
                   ". $where_query ."
                   ";
                    $rs6 = odbc_exec($conn, $sql);
                    if (!$rs6 ){
                        exit("Error en la consulta SQL");
                    } else{
				        while($resultado = odbc_fetch_array($rs6)){
                    		echo '
                            <tr>
                                <td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center; cursor:pointer;" onclick="location.href=\'index.php?opc=detalleFondoFijo&idFondo='.$resultado["idFondoFijo"].'&estado='.$resultado["FK_idEstado"].'\'">'.$resultado["idFondoFijo"].'</td>
								                <td onclick="location.href=\'index.php?opc=detalleFondoFijo&idFondo='.$resultado["idFondoFijo"].'&estado='.$resultado["FK_idEstado"].'\'"><strong>'.utf8_encode(getEncargado($resultado["idEncargado"],$conn)).'</strong></td>
                                <td onclick="location.href=\'index.php?opc=detalleFondoFijo&idFondo='.$resultado["idFondoFijo"].'&estado='.$resultado["FK_idEstado"].'\'"><strong>'.$resultado["createDate"].'</strong></td>
								                <td><strong>'.utf8_encode($resultado["description"]).'</strong></td>
                                <td onclick="location.href=\'index.php?opc=detalleFondoFijo&idFondo='.$resultado["idFondoFijo"].'&estado='.$resultado["FK_idEstado"].'\'"><strong>'.utf8_encode($resultado["name"]).'</strong></td>
                            	<td width="30"><img src="images/export_excel2.png" width="30px" height="30px" onclick="impExcelGeneral('.$resultado["idFondoFijo"].')" alt="Exportar Detalle" style="cursor:pointer;"  /></td>
								<td width="30"><img src="images/white_excel.png" width="30px" height="30px" onclick="impExcelConcepto('.$resultado["idFondoFijo"].')" alt="Exportar por Concepto" style="cursor:pointer;" /></td>
							';
							if($idusuario == 107 && $resultado["FK_idEstado"] == 4){
								echo '<td width="30"><img src="images/saplogo.png" width="40px" height="20px" onclick="impSAP('.$resultado["idFondoFijo"].",".$resultado["FK_idEstado"].')" /></td>';
							}else if ($idusuario == 107 && $resultado["FK_idEstado"] == 5){
								echo '<td width="30"><img src="images/saplogoGris.png" width="40px" height="20px" /></td>';
							}
							echo '</tr>';
						}
                    }

				?>
                </tbody>
                </td>
                <!-- <tfoot>
                	<tr  style=" border-top:2px double #B5B5B5;">
                    	<td></td>
						<td></td>
                        <td><strong><?php // echo number_format($totalNro, 0, '', '.'); ?></strong></td>
                        <td><strong><?php // echo number_format($totalValor, 2, ',', '.'); ?></strong></td>
                        <td><strong><?php // echo number_format($totalIVA, 2, ',', '.'); ?></strong></td>
                        <td><strong><?php // echo number_format($totalCIF, 2, ',', '.'); ?></strong></td>
                    </tr>
                </tfoot> -->
            </table>
</div>
<div id="detalleFondo"></div>

<script type="text/javascript">
  $("#usual1 ul").idTabs();
</script>
<?php odbc_close( $conn );?>
