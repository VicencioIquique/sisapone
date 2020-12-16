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
<script type="text/javascript">

function subirArchivo(){
	var file = document.getElementById("afile");
     
      /* Create a FormData instance */
      var fd = new FormData();
	  /* Add the file */ 
      var fileS = file.files[0];
	  
	  fd.append('afile', fileS);
	  var xhr = new XMLHttpRequest();;

      xhr.open("post", "modulos/requerimientos/upload.php", true);
     // xhr.setRequestHeader("Content-Type", "multipart/form-data");
		//client.send(formData);  /* Send to server */ 
		xhr.send(fd);
		alert("Nuevo Requerimiento Creado");
		location.href = 'index.php?opc=req';
}
  $(document).ready(function(){
				fn_cantidad_req();
				fn_insertar_nuevoRequerimiento();
				fn_agregar_nuevoRequerimiento();
                fn_eliminar_requerimiento();
				//fn_editar_pais();
				$('#busqueda').focus();
				$("#dialog").dialog({
					autoOpen: false,
					title: "Formulario de Nuevo Requerimiento.",
					width: 450,
					height: 500
				});
				$('#areaSolicitaDesc').select2();
				
				$("#dialog-confirmarReq").dialog({
					autoOpen: false,
					title: "Confirmar Requerimiento Completado.",
					width: 450,
					height: 400
				});
				
				$(".confirmarReq").click(function(){
					$("#dialog-confirmarReq").dialog("open");
					window.id = $(this).attr("id");
				});
				$("#btn-confirmarReq").click(function(){
					var VBSolRadioVal = $("input:radio[name='group1']:checked").val();
					var VBSolRadio = $("input:radio[name='group1']").is(':checked');
					
					if(!VBSolRadio){
						alert("Por favor seleccione si la resulución del requerimiento fue satisfecha");
					}else{
						var feedback = $("#feedback").val();
						if(VBSolRadioVal == "Si"){
							var VBSolicitante = 1;
						}else{
							var VBSolicitante = 0;
						}
						var json = {
							idReq : window.id,
							VBSolicitante : VBSolicitante,
							feedback : feedback
						};
						$.post('modulos/requerimientos/aceptarReq.php', {datos:json}, function(){
							
							location.href = 'index.php?opc=req';
						});
					}
						
					
				});
				$('#agregarReq').click(function(){
					if(($("#title").val() == "") || ($("#description").val() == "")){
						alert("Por favor rellene todos los campos obligatorios antes de continuar");
					}else{
						var asd = $("a.revisarReq")
						var idSolicitante = $("#usuario_id").val();
						var title = $("#title").val();
						var description = $("#description").val();
						var areaRecibeDesc = $("#areaRecibeDesc").val();
						var json = {
								idSolicitante : idSolicitante,
								title : title,
								description : description,
								areaRecibeDesc: areaRecibeDesc
						};
						$.post("modulos/requerimientos/agregar.php", {datos:json});   
							subirArchivo();
							fn_cantidad_req();
						}
				});
});
		
</script>

<?php
 
      $buscar = $_POST['b'];
    
?>
<!--<div class="paso_selected" >1 Paso</div><div class="paso" >2 Paso</div><div class="paso" >3 Paso</div><br /><br /><br />	 -->
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
                             <div  style=" width:20px; height:20px; background-color:#146672; float:left;margin-left:130px;">
								<span style=" margin-left:25px; font-weight:normal; color:#333; width:60px; display:block; ">Espera de Revisión</span>
							 </div><!-- fin   -->
                             <div  style=" width:20px; height:20px; background-color:#705249;float:left;margin-left:130px;">
								<span style=" margin-left:25px; font-weight:normal; color:#333; width:60px;  display:block;">En Revisión</span>
							 </div><!-- fin   -->
                             <div  style=" width:20px; height:20px; background-color:#6C6B6B;float:left;margin-left:130px;">
								<span style=" margin-left:25px; font-weight:normal; color:#333; width:60px;  display:block;">Finalizado</span>
							 </div><!-- fin   -->
        				    <input name="usuario_id" type="hidden" id="usuario_id" size="40" class="required" value="<?php echo $_SESSION['usuario_id'];?>" />
                             <input name="modulo" type="hidden" id="modulo" size="40" class="required" value="<?php echo $_SESSION['usuario_modulo'];?>" />
                     </label>
                            <input style="clear:initial;" name="agregar" type="submit" id="agregar" class="submit" value="Comenzar" />
				</fieldset>
            </form>
			<!-- FORM PARA LOS REQUERIMIENTOS --> 
					<div id="dialog" title="Dialog Form">
						<!--<form action="modulos/requerimientos/agregar.php" method="post" id="">-->
							<label>Área a solicitar:</label>
							<select name="areaRecibeDesc" id="areaRecibeDesc" style="width: 100%;" disabled>
								<?php
									$sql = "SELECT idArea, description FROM SISAP.dbo.SI_Area";
									$rs = odbc_exec( $conn, $sql );
									if ( !$rs ){
										exit( "Error en la consulta SQL" );
									}
									//echo '<option value=''></option>';
									
									while($resultado = odbc_fetch_array($rs)){ 
										echo '<option value='.utf8_encode($resultado['idArea']).'>'.utf8_encode($resultado['description']).'</option>';
								}
								?>
							</select>
							<label>Título del Requerimiento: (Obligatorio)</label>
							<input id="title" name="title" type="text">
							<label>Descripción del Requerimiento: (Obligatorio)</label>
							<textarea rows="10" cols="500" id="description" name="description"></textarea>
							
							<form id="cargar" enctype="multipart/form-data">
								<label>Adjuntar archivo: (Opcional)</label>
								<input id="afile" name="afile" type="file" />
							</form>
							<br>
							<input id="agregarReq" class="submit" type="button" value="Aceptar">
						<!--</form>-->
					</div>
			
			<!-- FIN FORM REQUERIMIENTOS -->
			
			<div id="dialog-confirmarReq" title="Dialog Form">
						<!--<form action="modulos/requerimientos/agregar.php" method="post" id="">-->
							<label>Está satisfecho con la resolución de su Requerimiento:</label><br>
							<input type="radio" name="group1" value="Si"> Sí
							<input type="radio" name="group1" value="No"> No<br><br>
							<label>Anote aquí sus comentarios (Opcional):</label>
							<br>	
							 <textarea id="feedback" rows="10" cols="50"></textarea> 
							<br><br>
							<input id="btn-confirmarReq" class="submit" type="button" value="Aceptar">
						<!--</form>-->
					</div>
			
			
         </div> <!-- fin one -->
 	  </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
  <table  id="ssptable2" class="lista">
              <thead>
                    <tr>
                        <th>Id Req</th>
                        <th>Fecha Creación</th>
                        <th>Nombre Solicitante</th>
						<th>Requerimiento</th>
                        <th>Nombre Recepción</th>
                        <th>Área Recepción</th>
						<th>Fecha revisión</th>
						<th>Fecha inicio req </th>
						<th>Fecha termino req</th>
                        <th>&nbsp;</th>
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
							,USS.usuario_nombre      [nombreSolicita]
							,USR.usuario_nombre		 [nombreRecibe]
							,CONVERT(varchar(20),RE.revDate,13) [revDate]
							,CONVERT(varchar(20),RE.startDate,13) [startDate]
							,CONVERT(varchar(20),RE.endDate,13) [endDate]
							,ES.idEstado
							,ES.name               [estadoName]
							,SE.idServicio
							,SE.description        [descServicio]
							,CONVERT(varchar(10),SE.waitTime,108) [waitTime]
							,ARE.description		[areaSolicitaDesc]
							,ARR.description		[areaRecibeDesc]
						  FROM SISAP.dbo.SI_Requerimiento RE
							 LEFT JOIN SISAP.dbo.SI_Estado ES ON ES.idEstado = RE.FK_idEstado
							 LEFT JOIN SISAP.dbo.SI_Area ARE ON RE.FK_idAreaEmision = ARE.idArea
							 LEFT JOIN SISAP.dbo.SI_Area ARR ON RE.FK_idAreaRecepcion = ARR.idArea
							 LEFT JOIN SISAP.dbo.SI_Servicio SE ON RE.FK_idServicio = SE.idServicio
							 LEFT JOIN RP_VICENCIO.dbo.sisap_usuarios USS ON RE.idSolicitante = USS.usuario_id
							 LEFT JOIN RP_VICENCIO.dbo.sisap_usuarios USR ON RE.idRecepcion = USR.usuario_id
							 WHERE  USS.FK_idArea IN (SELECT REA.FK_idArea FROM RP_VICENCIO.dbo.sisap_usuarios REA WHERE usuario_id = ".$_SESSION['usuario_id'].") AND USS.FK_idArea = RE.FK_idAreaEmision 
							 ORDER BY RE.idRequerimiento DESC";

					
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
									  if($resultado["FK_idEstado"] == 4 && $resultado["idSolicitante"] == $_SESSION['usuario_id'])
								  {
							   echo '<tr>
									<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a class="confirmarReq" style="color:#fff;" target="_blank"  id='.$resultado["idRequerimiento"].' ">'.utf8_encode($resultado["idRequerimiento"]).'</a></td>';
								  }
								  else if($resultado["FK_idEstado"] == 4 && $resultado["idSolicitante"] != $_SESSION['usuario_id'])
								  {
									echo '<tr>
									<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a style="color:#fff;" target="_blank"  id='.$resultado["idRequerimiento"].' ">'.utf8_encode($resultado["idRequerimiento"]).'</a></td>';  
								  }
								  else if($resultado["FK_idEstado"] == 5){
									  echo'
										<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a class="reqFinalizado" style="color:#fff;" target="_blank" >'.utf8_encode($resultado["idRequerimiento"]).'</a></td>';
										echo '<script type="text/javascript">
											$(".reqFinalizado").parents("tr").remove();
										</script>
									  ';
								  }
								else if($resultado["FK_idEstado"] == 2)
								  {
							   echo '<tr>
									<td  style="background-color:#146672;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a style="color:#fff;" target="_blank" >'.utf8_encode($resultado["idRequerimiento"]).'</a></td>';
								  }
								else if($resultado["FK_idEstado"] == 3)
								  {
							   echo '<tr>
									<td  style="background-color:#705249;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a style="color:#fff;" target="_blank" >'.utf8_encode($resultado["idRequerimiento"]).'</a></td>';
								  }
									echo '
									<td >'.($resultado["createDate"]).'</td>
									<td >'.utf8_decode($resultado["nombreSolicita"]).'</td>
									<td >'.utf8_decode($resultado["title"]).'</td>';
									if($resultado["nombreRecibe"] == ""){
										echo '<td >En espera</td>';
									}else{
										echo '<td >'.utf8_decode($resultado["nombreRecibe"]).'</td>';
									}
									if($resultado["areaRecibeDesc"] == ""){
										echo '<td >En espera</td>';
									}else{
										echo '<td >'.utf8_decode($resultado["areaRecibeDesc"]).'</td>';
									}
									if($resultado["revDate"] == ""){
										echo '<td >En espera</td>';
									}else{
										echo '<td >'.utf8_decode($resultado["revDate"]).'</td>';
									}
									if($resultado["startDate"] == ""){
										echo '<td >En espera</td>';
									}else{
										echo '<td >'.utf8_decode($resultado["startDate"]).'</td>';
									}
									if($resultado["endDate"] == ""){
										echo '<td >En espera</td>';
									}else{
										echo '<td >'.utf8_decode($resultado["endDate"]).'</td>';
									}
									
									
									'<td ></td>' ;
																
								}
								else if($resultado["FK_idEstado"] == 1)
								{
							   echo '<tr>
									<td style="background-color:#5484C7;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a  style="color:#fff;">'.utf8_encode($resultado["idRequerimiento"]).'</a></td>
									<td >'.($resultado["createDate"]).'</td>
									<td >'.utf8_decode($resultado["nombreSolicita"]).'</td>
									<td >'.utf8_decode($resultado["title"]).'</td>';
									if($resultado["nombreRecibe"] == ""){
										echo '<td >En espera</td>';
									}else{
										echo '<td >'.utf8_decode($resultado["nombreRecibe"]).'</td>';
									}
									if($resultado["areaRecibeDesc"] == ""){
										echo '<td >En espera</td>';
									}else{
										echo '<td >'.utf8_decode($resultado["areaRecibeDesc"]).'</td>';
									}
									if($resultado["revDate"] == ""){
										echo '<td >En espera</td>';
									}else{
										echo '<td >'.utf8_decode($resultado["revDate"]).'</td>';
									}
									if($resultado["startDate"] == ""){
										echo '<td >En espera</td>';
									}else{
										echo '<td >'.utf8_decode($resultado["startDate"]).'</td>';
									}
									if($resultado["endDate"] == ""){
										echo '<td >En espera</td>';
									}else{
										echo '<td >'.utf8_decode($resultado["endDate"]).'</td>';
									}
									if($resultado["idSolicitante"] == $_SESSION['usuario_id']){
										echo '<td ><a class="elimina_requerimiento" id="'.$resultado["idRequerimiento"].'"><img src="images/delete.png" /></a></td>' ;
									}
									echo '' ;
								}
						
							?>
						<?php echo '</tr>';
								}
							

				             ?>
                </tbody>
                <tfoot>
                	<tr>
                    	<td colspan="5"><strong>Cantidad:</strong> 
						<span id="span_cantidadReq"></span> Solicitudes.</td>
                    </tr>
                </tfoot>
            </table>
	<?php odbc_close( $conn );?>
            


   