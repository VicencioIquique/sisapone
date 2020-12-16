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
//VARIABLES QUE VIENEN DE fondoFijo.php

$idArea = $_GET['idArea'];
$estado = "";
$idNuevoFondo = $_GET['idNuevoFondo'];
$agregarFondoFijo = $_GET['agregarFondoFijo'];

//VARIABLE QUE VIENE CUANDO SELECCIONAN UN FONDO EN LA PAGINA fondoFijo.php
$idFondo = $_GET['idFondo'];

if($agregarFondoFijo == "SI"){
	$idFondo = $idNuevoFondo;
	$sql="INSERT INTO SISAP.dbo.SI_FondoFijo
	([idFondoFijo]
  ,[idEncargado]
	,[createDate]
	,[FK_idArea]
	,[FK_idEstado]
	)
	VALUES
	('". $idNuevoFondo ."'
  ,'". $idusuario ."'
	,GETDATE()
	,'". $idArea ."'
	,'1'
	)";
	$rs = odbc_exec( $conn, $sql );
	if(!$rs){
		exit( "Error en la consulta SQL" );
	}
	odbc_close( $conn );
}else{
	$numDocBus = $_GET['numDocBus'];
	$conceptoBus = $_GET['conceptoBus'];
	$negocioBus = $_GET['negocioBus'];
	$fechaBus = $_GET['fechaBus'];
	
	//VERIFICO EL ESTADO DEL FONDO FIJO
	$sql = "SELECT FK_idEstado AS Estado FROM [SISAP].[dbo].[SI_FondoFijo] WHERE idFondoFijo =".$idFondo;
	$rs = odbc_exec( $conn, $sql );
	if(!$rs){
		exit( "Error en la consulta SQL" );
	} else{
		$resultado = odbc_fetch_array($rs);
		$estado = $resultado["Estado"];
	}
}

$sql = "SELECT idEncargado AS Usuario FROM [SISAP].[dbo].[SI_FondoFijo] WHERE idFondoFijo =".$idFondo;
	$rs = odbc_exec( $conn, $sql );
	if(!$rs){
		exit( "Error en la consulta SQL" );
	} else{
		$resultado = odbc_fetch_array($rs);
		if($idusuario != $resultado["Usuario"] && $rol != 1 && $rol != 9){
			echo '<script>location.href="index.php?opc=fondoFijo";</script>';	
		}
	}
?>
<link rel="stylesheet" type="text/css" href="modulos/requerimientos/css/select2.css"><!-- estilos geneales-->
<link rel="stylesheet" type="text/css" href="modulos/requerimientos/css/tooltip-form.css">


<script type="text/javascript">
$(document).ready(function(){
	  //comienza focus en modulo
	  $('#numDoc').focus();

//SOLO NUMEROS
	  $("#costo").keydown(function(event) {
		  if(event.shiftKey){
			  event.preventDefault();
		  } 
		  if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 ){
		  
		  }
		  else {
			  if (event.keyCode < 95) {
				  if (event.keyCode < 48 || event.keyCode > 57) {
					  event.preventDefault();
				  }
			  } 
			  else {	
				  if (event.keyCode < 96 || event.keyCode > 105) {
					  event.preventDefault();
				  }
			  }
		  }
	  });
	  $("#costoEdit").keydown(function(event) {
		  if(event.shiftKey){
			  event.preventDefault();
		  }
		  if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 ){
		  
		  }
		  else {
			  if (event.keyCode < 95) {
				  if (event.keyCode < 48 || event.keyCode > 57) {
					  event.preventDefault();
				  }
			  } 
			  else {
				  if (event.keyCode < 96 || event.keyCode > 105) {
					  event.preventDefault();
				  }
			  }
		  }
	  });
	  //ABRE EL POPUP PARA RENDIR EL FONDO FIJO
	  $("#dialogRendir").dialog({
				  autoOpen: false,
				  title: "Agregar Rendición.",
				  width: 450,
				  height: 700
			  });

	  //ABRE EL POPUP PARA EDITAR RENDICION DEL FONDO FIJO
	  $("#dialogEditar").dialog({
		autoOpen: false,
		title: "Editar Rendición.",
		width: 450,
		height: 700
	  });

	  // calendarios en text de fecha inicio fin
	  $( "#fechaBus" ).datepicker({
		  dateFormat: 'mm/yy',
		  changeMonth: true,
		  changeYear: true,
		  showButtonPanel: true,
		  onClose: function(dateText, inst) {
			  var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			  var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			  $(this).val($.datepicker.formatDate('mm/yy', new Date(year, month, 1)));
		  }
	  });

	  $("#fechaBus").focus(function () {
		  $(".ui-datepicker-calendar").hide();
		  $("#ui-datepicker-div").position({
			  my: "center top",
			  at: "center bottom",
			  of: $(this)
		  });
	  });
});
</script>

<!-- SSCRIPT PARA MANTENER FONDO FIJO -->
<script type="text/javascript">
function editarRendicion(idFondoDetalle, idFondoFijo, negocio, numDoc, titulo, comentario, costo, concepto, normaReparto, empresa){
	$("#idFondoDetalleEdit").val(idFondoDetalle);
    $("#idFondoFijoEdit").val(idFondoFijo);
    $("#negocioEdit").val(negocio);
    $("#numDocEdit").val(numDoc);
    $("#tituloEdit").val(titulo);
    $("#comentarioEdit").val(comentario);
    $("#costoEdit").val(costo);
    $("#conceptoEdit").val(concepto);
	$("#normaRepartoEdit").val(normaReparto);
	$("#EmpresaEdit").val(empresa);
    $("#dialogEditar").dialog("open");
}
$(function(){
	$("#actualizar").click(function(){
		if( ($("#numDocEdit").val() == "") || ($("#tituloEdit").val() == "") || ($("#comentarioEdit").val() == "") || ($("#costoEdit").val() == "") ){
			alert("Por favor primero complete todos los datos");
		}else{
			var idFondoFijo = $('#idFondoFijoEdit').val();
			var idFondoDetalle = $('#idFondoDetalleEdit').val();
			var numDoc = $('#numDocEdit').val();
			var titulo = $("#tituloEdit").val();
			var comentario = $("#comentarioEdit").val();
			var costo = $("#costoEdit").val();
			var concepto = $("#conceptoEdit").val();
			var normaRepartoEdit = $("#normaRepartoEdit").val();
			var EmpresaEdit = $("#EmpresaEdit").val();
			var negocio = $("#negocioEdit").val();
			var json={
				idFondoFijo : idFondoFijo,
				idFondoDetalle : idFondoDetalle,
				numDoc : numDoc,
				titulo : titulo,
				comentario : comentario,
				costo : costo,
				concepto : concepto,
				normaReparto: normaRepartoEdit,
				empresa: EmpresaEdit,
				negocio : negocio
			};
			$.post('modulos/fondoFijo/actualizaRendicion.php', {datos : json},function(){
				location.href='index.php?opc=detalleFondoFijo&idFondo=' + idFondoFijo;
				});
			
		}
	});
	$("#eliminar").click(function(){
		if(($("#idFondoFijo").val() == "") || ($("#idFondoDetalle").val() == "")){
			alert("Por favor primero complete todos los datos");
		}else{
			if(confirm("¿Seguro en eliminar la rendición?") == true){
				var idFondoFijo = $('#idFondoFijoEdit').val();
				var idFondoDetalle = $('#idFondoDetalleEdit').val();
				var json={
					idFondoFijo : idFondoFijo,
					idFondoDetalle : idFondoDetalle
				};
				$.post('modulos/fondoFijo/eliminaRendicion.php', {datos : json},function(){
					location.href='index.php?opc=detalleFondoFijo&idFondo=' + idFondoFijo;
					});
				
			}
		}
	});
	$("#finaliza").click(function(){
		if(($("#idFondoFijo").val() == "")){
			alert("No se encuentra el Fondo Fijo para Finalizar");
		}else{
			if(confirm("¿Seguro en finalizar el Fondo Fijo?") == true){
				var idFondoFijo = $('#idFondoFijoEdit').val();
				var idFondoDetalle = $('#idFondoDetalleEdit').val();
				var json={
					idFondoFijo : idFondoFijo,
					idFondoDetalle : idFondoDetalle
				};
				$.post('modulos/fondoFijo/finalizaFondo.php', {datos : json},function(){
					location.href='index.php?opc=fondoFijo';
				});
				
			}
		}
	});
	$("#nuevo").click(function(){
		$("#dialogRendir").dialog("open");
	});
	$("#aceptar").click(function(){
		if( ($("#numDoc").val() == "") || ($("#titulo").val() == "") || ($("#comentario").val() == "") || ($("#costo").val() == "") ){
			alert("Por favor primero complete todos los datos");
		}else{
			//$.post('modulos/fondoFijo/agregaRendicion.php', {datos : json});
			$.post("modulos/fondoFijo/agregaRendicion.php", {idFondoFijo: $("#idFondoFijo").val(), numDoc: $('#numDoc').val(), titulo: $("#titulo").val(), comentario: $("#comentario").val(), costo: $("#costo").val(), concepto: $("#concepto").val(), normaReparto: $("#normaReparto").val(), negocio: $("#negocio").val(), empresa: $("#EmpresaEdit").val()},function(){
				location.href='index.php?opc=detalleFondoFijo&idFondo=' + $("#idFondoFijo").val();
			});
		}
	});
});
</script>
<!-- FIN SCRIPT PARA MANTENER FONDO FIJO -->

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
        <div id="one">
          <form action="" method="GET" id="horizontalForm">
            <fieldset>
				        <legend>Detalle Fondo Fijo</legend>
                        <input id="opc" name="opc" type="hidden" value="detalleFondoFijo" />
                        <input id="idFondo" name="idFondo" type="hidden" value="<?php echo $idFondo; ?>" />
                        <label for="numDocBus">Numero Documento:
				                <input id="numDocBus" name="numDocBus" type="text" value="<?php echo $numDoc; ?>"  />
                        </label>
                        <label for="fechaBus">Fecha:
                        <input id="fechaBus" name="fechaBus" type="text" value="<?php echo $fecha; ?>" />
                        </label>
                        <label for="conceptoBus">Concepto:
                        <select id="conceptoBus" name="conceptoBus" style="margin-top:5px; height: 23px;">
                            <option></option>
                        <?php
                            $sql = "SELECT [AcctCode] ,[AcctName] ,[Segment_0] FROM [SBO_Imp_Eximben_SAC].[dbo].[OACT] WHERE [Segment_0] LIKE '61%'";
							$rs = odbc_exec( $conn, $sql );
							  if(!$rs){
								exit( "Error en la consulta SQL" );
							  }
							  echo "<option value = ''> </option>";
							  while($resultado = odbc_fetch_array($rs)){
								echo "<option value=".$resultado['AcctCode'].">".utf8_encode($resultado['AcctName'])."</option>";
							  }
                        ?>
                        </select>
                        </label>
                        <label for="negocioBus">Negocio:
                        <input id="negocioBus" name="negocioBus" type="text" value="<?php echo $negocio; ?>"  />
                        </label>
                        <input id="consultar"  name="consultar" type="submit" class="submit" value="Consultar" />
            </fieldset>
          </form>
      </div> <!-- fin div one-->
      </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
<div id="usual1" class="usual" >
  <div id="tab1">
    <table  id="ssptable2" class="t1" >
      <thead>
        <tr>
          <th style="font-size:14px;" valign="middle" <?php 
		  	if($idusuario == 107){
		  		echo 'colspan="7"';
		  	}else{
				echo 'colspan="6"';
			}
		  ?> >Detalle del Fondo Fijo Nº <?php echo $idFondo; ?> </th>
          <th></th>
          <th valign="middle" colspan="2"><form id="horizontalForm" method="GET" action="">
            <input name="nuevo" type="button" id="nuevo" class="submit" value="Agregar Rendición" <?php if($estado == 4){ echo "disabled"; } ?> />
          </form></th>
        </tr>
      </thead>
      <thead>
        <tr>
          <th>Nº</th>
          <th>Fecha Rendida</th>
		  <th>Nº Documento</th>
          <th>Titulo</th>
		  <th>Comentario</th>
          <th>Costo</th>
          <th>Negocio</th>
          <th>Concepto</th>
          <th>Centro de Costo</th>
          <?php 
		  	if($idusuario == 107){
		  		echo '<th>Empresa</th>';
		  	}
		  ?>
        </tr>
      </thead>
      <tbody>
        <?php
          $where_query = '';
          if($idFondo != ""){ $where_query = $where_query . " AND A.FK_idFondoFijo=". $idFondo.""; }
          if($numDocBus != ""){ $where_query = $where_query . " AND A.numDoc LIKE '%". $numDocBus ."%'"; }
          if($fechaBus != ""){ $where_query = $where_query . " AND CONVERT(CHAR(10),A.rinDate,103) LIKE '%' + '". $fechaBus ."'"; }
          if($negocioBus != ""){ $where_query = $where_query . " AND A.business LIKE '%". $negocioBus ."%'"; }
          if($conceptoBus != ""){ $where_query = $where_query . " AND A.AcctCode=". $conceptoBus .""; }
          $sql = "SELECT A.idDetalleFondoFijo, A.FK_idFondoFijo, A.rinDate, A.numDoc, A.title, A.description, A.cost, A.AcctCode, B.AcctName, A.OcrCode, A.business, A.baseDatos 
FROM [SISAP].[dbo].[SI_DetalleFondoFijo] AS A INNER JOIN [SBO_Imp_Eximben_SAC].[dbo].[OACT] AS B ON A.AcctCode = B.AcctCode COLLATE SQL_Latin1_General_CP850_CI_AS WHERE 1=1 ". $where_query ." ORDER BY idDetalleFondoFijo";
          
		  $rs2 = odbc_exec($conn, $sql);
          if (!$rs2 ){
            exit("Error en la consulta SQL");
          }else{
                $totalFondo = 0;
				        while($resultado = odbc_fetch_array($rs2)){
				          ?>
                  <tr <?php echo'style="cursor: pointer; cursor: hand;" onClick="'; echo "editarRendicion(".$resultado["idDetalleFondoFijo"].",".$resultado["FK_idFondoFijo"].",'".$resultado["business"]."','".$resultado["numDoc"]."','".$resultado["title"]."','".$resultado["description"]."',".$resultado["cost"].",'".$resultado["AcctCode"]."','".$resultado["OcrCode"]."','".$resultado["baseDatos"].'\')"';  ?>>
                    <td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; text-align:center;" ><?php echo utf8_encode($resultado["idDetalleFondoFijo"]); ?></td>
							      <td><strong><?php echo $resultado["rinDate"]; ?></strong></td>
								    <td><strong><?php echo $resultado["numDoc"]; ?></strong></td>
								    <td><strong><?php echo $resultado["title"]; ?></strong></td>
								    <td><strong><?php echo $resultado["description"]; ?></strong></td>
                    <td><strong><?php echo number_format($resultado["cost"], 0, '', '.'); ?></strong></td>
                    <td><strong><?php echo $resultado["business"]; ?></strong></td>
                    <td><strong><?php echo utf8_encode($resultado["AcctName"]); ?></strong></td>
                    <td><strong><?php echo utf8_encode($resultado["OcrCode"]); ?></strong></td>
                     <?php 
		  	if($idusuario == 107){
		  		echo '<td><strong>'. $resultado["baseDatos"] .'</strong></td>';
		  	}
		  ?>
                  </tr>
                  <?php
                  $totalFondo = $totalFondo + $resultado["cost"];
                }
          }
				?>
      </tbody>
                <tfoot>
                	<tr  style=" border-top:2px double #B5B5B5;">
                        <td><strong><?php // echo number_format($totalNro, 0, '', '.'); ?></strong></td>
                        <td><strong><?php // echo number_format($totalValor, 2, ',', '.'); ?></strong></td>
                        <td><strong><?php // echo number_format($totalIVA, 2, ',', '.'); ?></strong></td>
                        <td><strong><?php // echo number_format($totalCIF, 2, ',', '.'); ?></strong></td>
                        <td style="font-size:16px;" align="right" valign="middle"><strong>TOTAL</strong></td>
                        <td style="font-size:16px;" valign="middle"><strong><?php echo number_format($totalFondo, 0, '', '.'); ?></strong></td>
                        <td colspan="2"><form id="horizontalForm" method="GET" action="">
                          <input id="finaliza" name="finaliza" type="button" class="submit" <?php 
						  if($estado == 4 || $estado == 5){ 
						  	echo 'value="Fondo Finalizado" disabled'; 
						  }else{ 
						  	echo 'value="Finalizar Fondo"';
						  }
						  ?> />
                        </form></td>
                        <td></td>
                         <?php 
		  	if($idusuario == 107){
		  		echo '<td></td>';
		  	}
		  ?>
                    </tr>
                </tfoot>
    </table>
</div>

<!-- FORM PARA RENDIR FONDO FIJO -->
<div id="dialogRendir" title="Rendición de Fondo Fijo">
  <form action="" method="post" id="">
    <input type="hidden" id="idFondoFijo" name="idFondoFijo" style="width: 100%;" value=<?php echo '"'. $idFondo . '"'; ?> />
    <label>Nº Docuemnto:</label>
    <input type="text" id="numDoc" name="numDoc" style="width: 100%;" />
    <label>Título:</label>
    <input type="text" id="titulo" name="titulo" style="width: 100%;" />
    <label>Comentario:</label>
    <textarea rows="10" cols="47" id="comentario" name="comentario" style="resize: vertical;" ></textarea>
    <br>
    <label>Costo:</label>
    <input type="text" id="costo" name="costo" style="width: 100%;" />
    <label>Negocio:</label>
    <input type="text" id="negocio" name="negocio" style="width: 100%;" />
    <label>Concepto:</label>
    <select name="concepto" id="concepto" style="width:100%;">
      <?php
        $sql = "SELECT [AcctCode] ,[AcctName] ,[Segment_0] FROM [SBO_Imp_Eximben_SAC].[dbo].[OACT] WHERE [Segment_0] LIKE '61%' ORDER BY AcctName";
        $rs = odbc_exec( $conn, $sql );
          if(!$rs){
            exit( "Error en la consulta SQL" );
          }
          echo "<option value = ''> </option>";
          while($resultado = odbc_fetch_array($rs)){
            echo "<option value=".$resultado['AcctCode'].">".utf8_encode($resultado['AcctName'])."</option>";
          }
      ?>
    </select>
    <label>Centro de Costo:</label>
    <select name="normaReparto" id="normaReparto" style="width:100%;">
    <?php
        $sql = "SELECT [OcrCode],[OcrName] FROM [SBO_Imp_Eximben_SAC].[dbo].[OOCR] ORDER BY OcrCode";
        $rs = odbc_exec( $conn, $sql );
          if(!$rs){
            exit( "Error en la consulta SQL" );
          }
          echo "<option value = ''> </option>";
          while($resultado = odbc_fetch_array($rs)){
            echo "<option value=".$resultado['OcrCode'].">".utf8_encode($resultado['OcrCode'])." - ". utf8_encode($resultado['OcrName']) ."</option>";
          }
      ?>
    </select>
    <input type="button" id="aceptar" class="submit" value="Aceptar">
  </form>
</div>
<!-- FIN FORM RENDIR FONDO FIJO -->

<!-- FORM PARA EDITAR RENDICION FONDO FIJO -->
<div id="dialogEditar" title="Editar Rendición de Fondo Fijo">
  <form action="" method="post" id="">
    <input type="hidden" id="idFondoFijoEdit" name="idFondoFijoEdit" style="width: 100%;" value=<?php echo '"'. $idFondo . '"'; ?> />
    <input type="hidden" id="idFondoDetalleEdit" name="idFondoDetalleEdit" style="width: 100%;" value=<?php echo '"'. $idFondoDetalle . '"'; ?> />
    <label>Nº Docuemnto:</label>
    <input type="text" id="numDocEdit" name="numDocEdit" style="width: 100%;" />
    <label>Título:</label>
    <input type="text" id="tituloEdit" name="tituloEdit" style="width: 100%;" />
    <label>Comentario:</label>
    <textarea rows="10" cols="47" id="comentarioEdit" name="comentarioEdit" style="resize: vertical;" ></textarea>
    <br>
    <label>Costo:</label>
    <input type="text" id="costoEdit" name="costoEdit" style="width: 100%;" />
    <label>Negocio:</label>
    <input type="text" id="negocioEdit" name="negocioEdit" style="width: 100%;" />
    <label>Concepto</label>
    <select name="conceptoEdit" id="conceptoEdit" style="width:100%;">
      <?php
        $sql = "SELECT [AcctCode] ,[AcctName] ,[Segment_0] FROM [SBO_PRUEBA_HUGOBOSS].[dbo].[OACT] WHERE [Segment_0] LIKE '61%' ORDER BY AcctName";
        $rs = odbc_exec( $conn, $sql );
          if(!$rs){
            exit( "Error en la consulta SQL" );
          }
          echo "<option value = ''> </option>";
          while($resultado = odbc_fetch_array($rs)){
            echo "<option value=".$resultado['AcctCode'].">".utf8_encode($resultado['AcctName'])."</option>";
          }
      ?>
    </select>
    <label>Centro de Costo:</label>
    <select name="normaRepartoEdit" id="normaRepartoEdit" style="width:100%;">
    <?php
        $sql = "SELECT [OcrCode],[OcrName] FROM [SBO_PRUEBA_HUGOBOSS].[dbo].[OOCR] ORDER BY OcrCode";
        $rs = odbc_exec( $conn, $sql );
          if(!$rs){
            exit( "Error en la consulta SQL" );
          }
          echo "<option value = ''> </option>";
          while($resultado = odbc_fetch_array($rs)){
            echo "<option value=".$resultado['OcrCode'].">".utf8_encode($resultado['OcrCode'])." - ". utf8_encode($resultado['OcrName']) ."</option>";
          }
      ?>
    </select>
    <label style=" <?php if($idusuario == 107 || $rol == 1) { echo ' visibility:visible; '; } else{ echo ' visibility:hidden; '; } ?> " >Empresa:</label>
    <select name="EmpresaEdit" id="EmpresaEdit" style="width:100%; <?php if($idusuario == 107) { echo ' visibility:visible; '; } else if ($rol == 1){ echo ' visibility:visible; '; } else{ echo ' visibility:hidden; '; } ?> " >
    	<option value = 'Eximben'>Eximben</option>
        <option value = 'Servimex'>Servimex</option>
        <option value = 'Aeropuerto'>Aeropuerto</option>
    </select>
    <input type="button" id="actualizar" class="submit" value="Actualizar" <?php 
						  if($idusuario == 107 || $rol == 1){ 
						
						  }elseif($estado == 5 || $estado == 4){
						  	echo 'disabled';
						  }
						  ?>
                          >
    <input type="button" id="eliminar" class="submit" value="Eliminar" <?php 
						  if($idusuario == 107 || $rol == 1){ 
						  	
						  }elseif($estado == 5 || $estado == 4){
						  	echo 'disabled';
						  }
						  ?>
                          >
  </form>
</div>
<!-- FIN FORM EDITAR RENDICION FONDO FIJO -->

<script type="text/javascript">
  $("#usual1 ul").idTabs();
</script>