<?php 

require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes

//$criterio = ""; 
if (isset($_GET['criterio'])){ 
   	$txt_criterio = $_GET["criterio"]; 
   	$criterio = " AND (usuario_nombre like '%" . $txt_criterio . "%')"; 
}
?>
<script type="text/javascript" language="javascript" src="modulos/requerimientos/js/select2.js"></script>
<link rel="stylesheet" type="text/css" href="modulos/requerimientos/css/select2.css"><!-- estilos geneales-->
<link rel="stylesheet" type="text/css" href="modulos/requerimientos/css/tooltip-form.css">
<link rel="stylesheet" type="text/css" href="modulos/requerimientos/css/jquery-ui-timepicker-addon.css">
<script type="text/javascript">
  $(document).ready(function(){
				fn_cantidad_req();
				fn_cantidad_fin();
				fn_asignar_requerimiento();
				fn_editar_pais();
				$('#busqueda').focus();
				$("#dialogRevReq").dialog({
					autoOpen: false,
					title: "Revisión de Requerimiento.",
					width: 450,
					height: 600
				});
				$("#dialogFinReq").dialog({
					autoOpen: false,
					title: "Revisión de Requerimiento.",
					width: 450,
					height: 310
				});
				$('#areaSolicitaDesc').select2();
				$('#datepicker').datetimepicker();
				
				$('#datepicker').datetimepicker(
					$.timepicker.regional['es']
				);
});				
		
</script>
<script type="text/javascript">
	$(function(){
		$("a.revisarReq").click(function(){
			window.id = $(this).attr("id");
			$.post('modulos/requerimientos/seleccionarAreaRecep.php',{idReq : id},function(resPHP){
				var res = $.parseJSON(resPHP);
				$("#areaRecepcion").val(res['areaRecepcion']); 
				var idArea = res['idAreaRecepcion'];
				
			
				$.post('modulos/requerimientos/cargarUsuariosArea.php',{idArea : idArea}, function(resPHPUser){
					var resUser = $.parseJSON(resPHPUser);
					
					$("#usuarioRecepcion").empty();
					cadena = "<option value=''></td>";
					cadena = cadena + "<option value= " + resUser[0]['usuario_id'] + ">" + resUser[0]['usuario_nombre'] + " </td>";			
					for( i =1; i < (resUser.length); i++){
						cadena = cadena + "<option value= " + resUser[i]['usuario_id'] + ">" + resUser[i]['usuario_nombre'] + " </td>";
					}
					$("#usuarioRecepcion").append(cadena);
					$("#dialogRevReq").dialog("open");
				});
				
				$.post('modulos/requerimientos/cargarRequerimiento.php', {idReq : id}, function(resPHPReq){
					var resReq = $.parseJSON(resPHPReq);
					$("#title").val(resReq['title']);
					$("#description").val(resReq['description']);
				});
				
			});
			$("#categoria").change(function(){
				var idCategoria = $("#categoria").val();
				$.post('modulos/requerimientos/cargarServicio.php', {idCategoria : idCategoria}, function(resPHPSer){
						var resSer = $.parseJSON(resPHPSer);
						
						$("#descCategoria").empty();
						
						cadena = "<option value=''></td>";
						cadena = cadena + "<option value= " + resSer[0]['idServicio'] + ">" + resSer[0]['description'] + " </td>";			
						for( i =1; i < (resSer.length); i++){
							cadena = cadena + "<option value= " + resSer[i]['idServicio'] + ">" + resSer[i]['description'] + " </td>";
						}
						$("#descCategoria").append(cadena);
				});
			});
			$("#aceptar").click(function(){
				if(($("#usuarioRecepcion").val() == "") || ($("#categoria").val() == "") || ($("#descCategoria").val() == "")|| ($("#datepicker").val() == "")){
					alert("Por favor primero complete todos los datos");
				}else{
					var fecha = $('#datepicker').val();
					var idRecepcion = $("#usuarioRecepcion").val();
					var idServicio = $("#descCategoria").val();
					var json = {
						idReq : window.id,
						idRecepcion : idRecepcion,
						idServicio : idServicio,
						fecha : fecha
					};
					
					$.post('modulos/requerimientos/actualizarEstadoReq.php', {datos : json});
					location.href = 'index.php?opc=procReq';
					
					/*var jsonSolicitante = {
							idReq: window.id
					};
					
					$.post('modulos/requerimientos/cargarSolicitante.php', {idReq : window.id}, function(resPHPSolicitante){
							var resSolicitante = $.parseJSON(resPHPSolicitante);
							var idRecepcion = $("#usuarioRecepcion").val();
							
							var jsonCorreo = {
								idReq : window.id,
								idSolicitante : resSolicitante,
								idRecepcion : idRecepcion
							};
							
							$.post('modulos/requerimientos/enviarEmail.php', {datos : jsonCorreo}, function(){
									location.href = 'index.php?opc=procReq';
							});
							
							
					});*/
				}
			});
		});	
		
		$(".comenzarReq").click(function(){
			
			window.id = $(this).attr("id");
			var jsonReq = {
				idReq : window.id
			};
			$.post('modulos/requerimientos/cargarDescReq.php',{datosReq:jsonReq}, function(resPHPDescription){
				var resDescription = $.parseJSON(resPHPDescription);
				
				respuesta = confirm("El requerimiento número "+ id+ " tiene la siguiente descripcion: \n\n" + resDescription['description'] + 
				"\n\nDesea iniciar el requerimiento");
				if (respuesta){
					var json={
						idReq : window.id
					};
					$.post('modulos/requerimientos/comenzarReq.php',{datos:json}, function(){
						location.href = 'index.php?opc=procReq';
					});
					
					/*$(this).children("img").fadeOut("normal", function(){
						$(this).remove();*/
						/*$.post("modulos/solicitudes/estadoEnviarSAP.php", {idsol: id})
						//location.href = 'index.php?opc=nuevaSolicitudbrand';
						})*/
				}
			});
			
		});
		
		$(".terminarReq").click(function(){
			window.id = $(this).attr("id");
			respuesta = confirm("Desea dar por finalizado el requerimiento número: " + id);
			if (respuesta){
				var json={
					idReq : window.id
				};
				$.post('modulos/requerimientos/finalizarReq.php',{datos:json},function(){
					location.href = 'index.php?opc=procReq';
				});
			}
		});
		
		$(".revisarFinalizado").click(function(){
			window.id = $(this).attr("id");
			var json={
					idReq : window.id
				};
			$.post('modulos/requerimientos/cargarFeedback.php',{datos:json},function(resPHPFeedback){
				var resFeedback = $.parseJSON(resPHPFeedback);
				$("#feedback").val(resFeedback['feedback']);
			});
			$("#dialogFinReq").dialog("open");
		});
		
		$("#aceptarFinReq").click(function(){
			$("#dialogFinReq").dialog("close");
		});
	});
</script>
<?php
 
      $buscar = $_POST['b'];
    
?>
<!--<div class="paso_selected" >1 Paso</div><div class="paso" >2 Paso</div><div class="paso" >3 Paso</div><br /><br /><br />-->	 
<div class="idTabs">
      <ul>
        <li><a href="#one"><img src="images/agregar.png" width="30px" height="30px" /></a></li>
         <!--<li><a href="#two"><img src="images/agregar.png" width="30px" height="30px" /></a></li>
        <li><a href="#tree"><img src="images/editmod.png" width="30px" height="30px" /></a></li>-->
        <!-- Try adding this <br/> tag here
        <li><a href="#three">3</a></li>
        <li><a href="#four">4</a></li> -->
      </ul>
      <div class="items">
        <div id="two">
     </div><!-- fin two-->
        <div id="one">
         <form action="javascript: fn_agregar_nuevoRequerimiento();" method="post" id="horizontalForm">
		 
		 
         <div id="dialog-form" title="Agregar a la Lista de Solicitud">
		 </div>
		 
		 
            <fieldset>
				<legend>Nueva Solicitud <?php echo getmodulo($_SESSION['usuario_modulo']);?> </legend>
                    <label for="pais1">
					         <div  style=" width:20px; height:20px; background-color:#5484C7; float:left;margin-left:50px;  ">
								<span style=" margin-left:25px; font-weight:normal; color:#333; width:60px; display:block;  ">Creado</span>
							 </div><!-- fin   -->
                             <div  style=" width:20px; height:20px; background-color:#146672; float:left;margin-left:100px;">
								<span style=" margin-left:25px; font-weight:normal; color:#333; width:60px; display:block; ">Espera de Revisión</span>
							 </div><!-- fin   -->
                             <div  style=" width:20px; height:20px; background-color:#705249;float:left;margin-left:100px;">
								<span style=" margin-left:25px; font-weight:normal; color:#333; width:60px;  display:block;">En Revisión</span>
							 </div><!-- fin   -->
                             <div  style=" width:20px; height:20px; background-color:#6C6B6B;float:left;margin-left:100px;">
								<span style=" margin-left:25px; font-weight:normal; color:#333; width:60px;  display:block;">Finalizado</span>
							 </div><!-- fin   -->
							 <div  style=" width:20px; height:20px; background-color:#41C316;float:left;margin-left:100px;">
								<span style=" margin-left:25px; font-weight:normal; color:#333; width:60px;  display:block;">Aceptado</span>
							 </div><!-- fin   -->
							 <div  style=" width:20px; height:20px; background-color:#FA132E;float:left;margin-left:100px;">
								<span style=" margin-left:25px; font-weight:normal; color:#333; width:60px;  display:block;">Rechazado</span>
							 </div><!-- fin   -->
        				    <input name="usuario_id" type="hidden" id="usuario_id" size="40" class="required" value="<?php echo $_SESSION['usuario_id'];?>" />
                             <input name="modulo" type="hidden" id="modulo" size="40" class="required" value="<?php echo $_SESSION['usuario_modulo'];?>" />
                     </label>
                            
				</fieldset>
            </form>
			<!-- FORM PARA LOS REQUERIMIENTOS --> 
					<div id="dialogRevReq" title="Revisión y Asignación de Requerimientos">
						<form action="" method="post" id="">
							<label>Area de Recepción:</label>
							<input type="text" id="areaRecepcion" style="width: 100%;" disabled />
														
							<label>Usuario de Recepción:</label>
							<select name="usuarioRecepcion" id="usuarioRecepcion" style="width: 100%;">
							<!-- SELECT LLENADO POR AJAX -->	
							</select>
							
							<label>Título:</label>
							<input id="title" name="title" type="text" disabled >
							<label>Descripción del Req:</label>
							<textarea rows="10" cols="500" id="description" name="description" style="resize: vertical;" disabled>
							</textarea>
							
							<label>Categoría</label>
							<select name="categoria" id="categoria" style="width:100%;">
							<?php
								$sql = "SELECT idCategoria, name FROM SISAP.dbo.SI_Categoria";
								$rs = odbc_exec( $conn, $sql );
								if ( !$rs )
								{
								exit( "Error en la consulta SQL" );
								}
									echo "<option value = ''> </option>";
								  while($resultado = odbc_fetch_array($rs)){
									  echo "<option value = ".$resultado['idCategoria']."> ".$resultado['name']."</option>";
								  }
								
							?>
							</select>
							
							<label> Servicio </label>
							<select name="descCategoria" id="descCategoria" style="width:100%;">
							<!-- LLENADO POR AJAX -->
							</select>
							<label>Fecha de programación del Requerimiento</label>
							<input type="text" id="datepicker">
							<input id="aceptar" class="submit" value="Aceptar">
						</form>
					</div>
					
					<div id="dialogFinReq" title="Revisión y Asignación de Requerimientos">
						<form action="" method="post" id="">
							<label>Retroalimentación del Requerimiento:</label>
							<textarea rows="10" cols="48" id="feedback" name="feedback" style="resize: vertical;" disabled>
							</textarea>
							<br><br>
							<input type="button" id="aceptarFinReq" class="submit" value="Aceptar">
						</form>
					</div>
			
			<!-- FIN FORM REQUERIMIENTOS -->
         </div> <!-- fin one -->
 	  </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
  <table  id="ssptable2" class="lista listaProc">
              <thead>
                    <tr>
                        <th>Id Req</th>
                        <th>Fecha Creación</th>
						<th>Fecha Revisión</th>
                        <th>Nombre Solicitante</th>
						<th>Area solicitante</th>
						<th>Título Req.</th>
                        <th>Nombre Recepción</th>
						<th>Servicio Destinado</th>
						<th>Calendarizacion Req</th>
						<th>Fecha Inicio Req</th>
						<th>Fecha Termino Req</th>
						<th>Tiempo máx.</th>
						<th>Adjunto</th>
                    </tr>
                </thead>
                <tbody>
                 <?php
                 
				 	$sql="SELECT 
							RE.idRequerimiento
							,CONVERT(varchar(20),RE.createDate,13) [createDate]
							,RE.title
							,RE.description			[reqDesc]
							,RE.idSolicitante
							,RE.FK_idEstado
							,RE.VBSolicitante
							,RE.adjunto
							,RE.calendarizacion
							,USS.usuario_nombre      [nombreSolicita]
							,USR.usuario_nombre		 [nombreRecibe]
							,CONVERT(varchar(20),RE.revDate,13) [revDate]
							,CONVERT(varchar(20),RE.startDate,13) [startDate]
							,ES.idEstado
							,ES.name               [estadoName]
							,SE.idServicio
							,SE.description        [descServicio]
							,CONVERT(varchar(10),SE.waitTime,108) [waitTime]
							,CONVERT(varchar(20),RE.endDate,13) [endDate]
							,ARE.description		[areaSolicitaDesc]
							,ARR.description		[areaRecibeDesc]
						  FROM SISAP.dbo.SI_Requerimiento RE
							 LEFT JOIN SISAP.dbo.SI_Estado ES ON ES.idEstado = RE.FK_idEstado
							 LEFT JOIN SISAP.dbo.SI_Servicio SE ON RE.FK_idServicio = SE.idServicio
							 LEFT JOIN SISAP.dbo.SI_Area ARE ON RE.FK_idAreaEmision = ARE.idArea
							 LEFT JOIN SISAP.dbo.SI_Area ARR ON RE.FK_idAreaRecepcion = ARR.idArea
							 LEFT JOIN RP_VICENCIO.dbo.sisap_usuarios USS ON RE.idSolicitante = USS.usuario_id
							 LEFT JOIN RP_VICENCIO.dbo.sisap_usuarios USR ON RE.idRecepcion = USR.usuario_id
							 WHERE RE.VBSolicitante IS NULL OR RE.VBRecepcion IS NULL
							 ORDER BY SE.levelPriority ASC";

					
					$total =0;
					$cantotal =0;

							//echo $sql;	
							$rs = odbc_exec( $conn, $sql );
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}

							  while($resultado = odbc_fetch_array($rs)){ 
								if($resultado["FK_idEstado"]>1)
								{
									  if($resultado["FK_idEstado"] == 4)
										  
								  {
							   echo '<tr>
									<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a style="color:#fff;" target="_blank" >'.utf8_encode($resultado["idRequerimiento"]).'</a></td>';
								  }
								  else if($resultado["FK_idEstado"] == 5 && $resultado["VBSolicitante"] == 1){
									  echo '<td></td>';
									  /*echo'<tr>
									<td style="background-color:#41C316;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a style="color:#fff;" target="_blank" >'.utf8_encode($resultado["idRequerimiento"]).'</a></td>';*/
								  }
								  /*else if($resultado["FK_idEstado"] == 5 && $resultado["VBSolicitante"] == 0){
									  echo'<tr>
									<td style="background-color:#FA132E;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a style="color:#fff;" target="_blank" >'.utf8_encode($resultado["idRequerimiento"]).'</a></td>';
								  }*/
								else if($resultado["FK_idEstado"]==2)
								  {
							   echo '<tr>
									<td  style="background-color:#146672;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a class="comenzarReq" style="color:#fff;" target="_blank"  id='.$resultado["idRequerimiento"].' ">'.utf8_encode($resultado["idRequerimiento"]).'</a></td>';
								  }
								else if($resultado["FK_idEstado"]==3)
								  {
							   echo '<tr>
									<td  style="background-color:#705249;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a class="terminarReq" style="color:#fff;" target="_blank"  id='.$resultado["idRequerimiento"].' ">'.utf8_encode($resultado["idRequerimiento"]).'</a></td>';
								  }
									echo '
									<td >'.($resultado["createDate"]).'</td>
									<td >'.($resultado["revDate"]).'</td> 
									<td >'.utf8_decode($resultado["nombreSolicita"]).'</td>
									<td>'.utf8_decode($resultado["areaSolicitaDesc"]).'</td>
									<td >'.utf8_decode($resultado["title"]).'</td>';
									if($resultado["nombreRecibe"] == ""){
										echo '<td >En espera</td>';
									}else{
										echo '<td >'.utf8_decode($resultado["nombreRecibe"]).'</td>';
									}
									echo '
										<td> '.utf8_decode($resultado["descServicio"]).'</td>';
									
									if($resultado["calendarizacion"] == ""){
										echo '<td >En espera</td>';
									}else{
										echo '<td >'.($resultado["calendarizacion"]).'</td>';
									}
									if($resultado["startDate"] == ""){
										echo '<td >En espera</td>';
									}else{
										echo '<td >'.($resultado["startDate"]).'</td>';
									}
									if($resultado["endDate"] == ""){
										echo '<td>En espera</td>';
									}else{
										echo '<td> '.($resultado["endDate"]).'</td>	';
									}								
									echo '
										<td> '.($resultado["waitTime"]).'</td>';
									if(	$resultado['adjunto'] == ""){
										echo '<td>Sin adj</td>';
									}else{
										echo '<td><a href="modulos/requerimientos/adjuntos/'.$resultado['adjunto'].'" target="_blank">Click</td>';
									}										
								}
								else if((int)$resultado["FK_idEstado"]==1)
								{
							   echo '<tr>
									<td style="background-color:#5484C7;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a class="revisarReq" style="color:#fff;" id="'.$resultado["idRequerimiento"].'">'.utf8_encode($resultado["idRequerimiento"]).'</a></td>
									<td >'.($resultado["createDate"]).'</td>';
									if($resultado["revDate"] == ""){
										echo '<td>En espera</td>';
									}else{
										echo '<td> '.($resultado["revDate"]).'</td>	';
									}
								echo'	
									<td >'.utf8_decode($resultado["nombreSolicita"]).'</td>
									<td>'.utf8_decode($resultado["areaSolicitaDesc"]).'</td>
									<td >'.utf8_decode($resultado["title"]).'</td>';
									if($resultado["nombreRecibe"] == ""){
										echo '<td >En espera</td>';
									}else{
										echo '<td >'.utf8_decode($resultado["nombreRecibe"]).'</td>';
									}
									if($resultado["descServicio"] == ""){
										echo '<td >En espera</td>';
									}else{
										echo '<td >'.utf8_decode($resultado["descServicio"]).'</td>';
									}
									if($resultado["calendarizacion"] == ""){
										echo '<td >En espera</td>';
									}else{
										echo '<td >'.($resultado["calendarizacion"]).'</td>';
									}
									if($resultado["startDate"] == ""){
										echo '<td >En espera</td>';
									}else{
										echo '<td >'.($resultado["startDate"]).'</td>';
									}
									if($resultado["endDate"] == ""){
										echo '<td >En espera</td>';
									}else{
										echo '<td >'.($resultado["endDate"]).'</td>';
									}
									echo '
										<td> '.($resultado["waitTime"]).'</td>';
									if(	$resultado['adjunto'] == ""){
										echo '<td>Sin adj</td>';
									}else{
										echo '<td><a href="modulos/requerimientos/adjuntos/'.$resultado['adjunto'].'" target="_blank">Click</td>';
									}
									
									//echo '<td ><a class="elimina_requerimiento" id="'.$resultado["idRequerimiento"].'"><img src="images/delete.png" /></a></td>' ;
								}
						
							?>
						<?php echo '</tr>';
								}
							

				             ?>
                </tbody>
                <tfoot>
                	<tr>
                    	<td colspan="5"><strong>Cantidad:</strong> <span id="span_cantidadReq">4</span> Solicitudes en proceso.</td>
                    </tr>
                </tfoot>
            </table>
			<table  id="ssptable2" class="lista listaRes">
				<thead>
                    <tr>
                        <th>Id Req</th>
                        <th>Fecha Creación</th>
						<th>Fecha Revisión</th>
                        <th>Nombre Solicitante</th>
						<th>Area solicitante</th>
						<th>Título Req.</th>
                        <th>Nombre Recepción</th>
						<th>Servicio Destinado</th>
						<th>Fecha Inicio Req</th>
						<th>Fecha Termino Req</th>
						<th>Tiempo Realizado</th>
						<th>Adjunto</th>
                    </tr>
                </thead>
                <tbody>
                 <?php
                 
				 	$sql="SELECT 
							RE.idRequerimiento
							,CONVERT(varchar(20),RE.createDate,13) [createDate]
							,RE.title
							,RE.description			[reqDesc]
							,RE.idSolicitante
							,RE.FK_idEstado
							,RE.VBSolicitante
							,RE.adjunto
							,USS.usuario_nombre      [nombreSolicita]
							,USR.usuario_nombre		 [nombreRecibe]
							,CONVERT(varchar(20),RE.revDate,13) [revDate]
							,CONVERT(varchar(20),RE.startDate,13) [startDate]
							,ES.idEstado
							,ES.name               [estadoName]
							,SE.idServicio
							,SE.description        [descServicio]
							,CONVERT(varchar(10),SE.waitTime,108) [waitTime]
							,CONVERT(varchar(20),RE.endDate,13) [endDate]
							,ARE.description		[areaSolicitaDesc]
							,ARR.description		[areaRecibeDesc]
						  FROM SISAP.dbo.SI_Requerimiento RE
							 LEFT JOIN SISAP.dbo.SI_Estado ES ON ES.idEstado = RE.FK_idEstado
							 LEFT JOIN SISAP.dbo.SI_Servicio SE ON RE.FK_idServicio = SE.idServicio
							 LEFT JOIN SISAP.dbo.SI_Area ARE ON RE.FK_idAreaEmision = ARE.idArea
							 LEFT JOIN SISAP.dbo.SI_Area ARR ON RE.FK_idAreaRecepcion = ARR.idArea
							 LEFT JOIN RP_VICENCIO.dbo.sisap_usuarios USS ON RE.idSolicitante = USS.usuario_id
							 LEFT JOIN RP_VICENCIO.dbo.sisap_usuarios USR ON RE.idRecepcion = USR.usuario_id
							WHERE RE.VBSolicitante >= 0 AND RE.VBRecepcion >= 0 
							 ORDER BY SE.levelPriority ASC";

					
					$total =0;
					$cantotal =0;

							//echo $sql;	
							$rs = odbc_exec( $conn, $sql );
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}

							  while($resultado = odbc_fetch_array($rs)){ 
								if($resultado["FK_idEstado"]>1)
								{
								
								  if($resultado["FK_idEstado"] == 5 && $resultado["VBSolicitante"] == 1){
									 
									  echo'<tr>
									<td style="background-color:#41C316;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a class="revisarFinalizado" style="color:#fff;" target="_blank" id="'.$resultado["idRequerimiento"].'">'.utf8_encode($resultado["idRequerimiento"]).'</a></td>';
								  }
								  else if($resultado["FK_idEstado"] == 5 && $resultado["VBSolicitante"] == 0){
									  echo'<tr>
									<td style="background-color:#FA132E;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a class="revisarFinalizado" style="color:#fff;" target="_blank" id="'.$resultado["idRequerimiento"].'">'.utf8_encode($resultado["idRequerimiento"]).'</a></td>';
								  }
								
									echo '
									<td >'.($resultado["createDate"]).'</td>
									<td >'.($resultado["revDate"]).'</td> 
									<td >'.utf8_decode($resultado["nombreSolicita"]).'</td>
									<td>'.utf8_decode($resultado["areaSolicitaDesc"]).'</td>
									<td >'.utf8_decode($resultado["title"]).'</td>';
									if($resultado["nombreRecibe"] == ""){
										echo '<td >En espera</td>';
									}else{
										echo '<td >'.utf8_decode($resultado["nombreRecibe"]).'</td>';
									}
									echo '
										<td> '.utf8_decode($resultado["descServicio"]).'</td>';
									
									if($resultado["startDate"] == ""){
										echo '<td >En espera</td>';
									}else{
										echo '<td >'.($resultado["startDate"]).'</td>';
									}
									if($resultado["endDate"] == ""){
										echo '<td>En espera</td>';
									}else{
										echo '<td> '.($resultado["endDate"]).'</td>	';
									}								
									echo '
										<td> '.($resultado["waitTime"]).'</td>';
									if(	$resultado['adjunto'] == ""){
										echo '<td>Sin adj</td>';
									}else{
										echo '<td><a href="modulos/requerimientos/adjuntos/'.$resultado['adjunto'].'" target="_blank">Click</td>';
									}										
								}
						
							?>
						<?php echo '</tr>';
								}
							

				             ?>
                </tbody>
                <tfoot>
                	<tr>
                    	<td colspan="5"><strong>Cantidad:</strong> <span id="span_cantidadFin">4</span> Solicitudes finalizadas y evaluadas.</td>
                    </tr>
                </tfoot>
			</table>
	<?php odbc_close( $conn );?>
            


   