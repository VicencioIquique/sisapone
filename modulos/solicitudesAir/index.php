<?php 
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes

//$criterio = ""; 
if (isset($_GET['criterio'])){ 
   	$txt_criterio = $_GET["criterio"]; 
   	$criterio = " AND (usuario_nombre like '%" . $txt_criterio . "%')"; 
}
?>
<script type="text/javascript">
  $(document).ready(function(){

                fn_eliminar_solicitudAir();
				fn_editar_paisAir();
				$('#busqueda').focus();

            });

</script>

<?php
 
      $buscar = $_POST['b'];
	  $modulo = $_SESSION["usuario_modulo"];
	if($modulo== 42)
	{
		$modulo=1;
	}
	else if ($modulo== 48)
	{
		$modulo=2;
	}
    
?>
<div class="paso_selected" >1 Paso</div><div class="paso" >2 Paso</div><div class="paso" >3 Paso</div><br /><br /><br />	 
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
         <form action="javascript: fn_agregar_nuevaSolicitudAir();" method="post" id="horizontalForm">
          
            <fieldset>
				<legend>Nueva Solicitud <?php echo getmoduloAir($modulo);?> </legend>
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
								<span style=" margin-left:25px; font-weight:normal; color:#333; width:60px;  display:block;">Aceptado</span>
							 </div><!-- fin   -->
					         
        				    <input name="usuario_id" type="hidden" id="usuario_id" size="40" class="required" value="<?php echo $_SESSION['usuario_id'];?>" />
                             <input name="modulo" type="hidden" id="modulo" size="40" class="required" value="<?php echo $modulo;?>" />
                             </label>
                            <input style="clear:initial;" name="agregar" type="submit" id="agregar" class="submit" value="Comenzar" />
				</fieldset>
            </form>
         </div> <!-- fin one -->
 	  </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
  <table  id="ssptable" class="lista">
              <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre Solicita</th>
                        <th>Estado</th>
                        <th>Fecha Creación</th>
                        <th>Modulo</th>
                        <th>Revisión</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                 <?php
                 
				 	$sql="SELECT  RP_REGGEN.dbo.sisap_solicitudes.solicitud_id,  RP_REGGEN.dbo.sisap_solicitudes.estado, CONVERT(varchar,  RP_REGGEN.dbo.sisap_solicitudes.fecha_crea, 103) AS Fecha,  RP_REGGEN.dbo.sisap_solicitudes.fecha_estado, 
                       RP_REGGEN.dbo.sisap_solicitudes.cantidad_total,  RP_REGGEN.dbo.sisap_solicitudes.modulo,  RP_REGGEN.dbo.sisap_solicitudes.vendedor_id,  RP_REGGEN.dbo.sisap_solicitudes.recepcion_id, 
                       RP_REGGEN.dbo.sisap_usuarios.usuario_nombre
FROM          RP_REGGEN.dbo.sisap_solicitudes LEFT OUTER JOIN
                       RP_REGGEN.dbo.sisap_usuarios ON  RP_REGGEN.dbo.sisap_solicitudes.vendedor_id =  RP_REGGEN.dbo.sisap_usuarios.usuario_id WHERE  ".$modulo." LIKE   RP_REGGEN.dbo.sisap_solicitudes.modulo
					ORDER BY  RP_REGGEN.dbo.sisap_solicitudes.estado,  RP_REGGEN.dbo.sisap_solicitudes.fecha_estado DESC";

					
					$total =0;
					$cantotal =0;

							//echo $sql;	
							$rs = odbc_exec( $conn, $sql );
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}

							  while($resultado = odbc_fetch_array($rs)){ 
							  
							//  echo $resultado["estado"];
							  
								if($resultado["estado"]>0)
								{
									  if($resultado["estado"]==3)
								  {
							   echo '<tr>
									<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a style="color:#fff;" target="_blank"  href="modulos/impresiones/listasolicitudpdfAir.php?idsol='.$resultado["solicitud_id"].' ">'.utf8_encode($resultado["solicitud_id"]).'</a></td>';
								  }
								else if($resultado["estado"]==1)
								  {
							   echo '<tr>
									<td  style="background-color:#146672;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a style="color:#fff;" target="_blank"  href="modulos/impresiones/listasolicitudpdfAir.php?idsol='.$resultado["solicitud_id"].' ">'.utf8_encode($resultado["solicitud_id"]).'</a></td>';
								  }
								else if($resultado["estado"]==2)
								  {
							   echo '<tr>
									<td  style="background-color:#705249;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a style="color:#fff;" target="_blank"  href="modulos/impresiones/listasolicitudpdfAir.php?idsol='.$resultado["solicitud_id"].' ">'.utf8_encode($resultado["solicitud_id"]).'</a></td>';
								  }
									echo '
								    <td ><strong>'.utf8_encode(getusuario($resultado["vendedor_id"])).'</strong></td>
									<td >'.getestado($resultado["estado"]).'</td>
									<td >'.utf8_encode($resultado["Fecha"]).'</td>
									<td >'.utf8_encode(getmoduloAir($resultado["modulo"])).'</td>
									
									<td >'.utf8_encode(getusuario($resultado["recepcion_id"])).'</td>
									<td ></td>' ;
																
								}
								else if((int)$resultado["estado"]==0)
								{
							   echo '<tr>
									<td style="background-color:#5484C7;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a  style="color:#fff;" href="index.php?opc=pasodos&idsol='.$resultado["solicitud_id"].'">'.utf8_encode($resultado["solicitud_id"]).'</a></td>
									<td ><strong>'.utf8_encode(getusuario($resultado["vendedor_id"])).'</strong></td>
									<td >'.getestado($resultado["estado"]).'</td>
									<td >'.utf8_encode($resultado["Fecha"]).'</td>
									<td >'.utf8_encode(getmoduloAir($resultado["modulo"])).'</td>
									
									<td >'.utf8_encode(getusuario($resultado["recepcion_id"])).'</td>
									<td ><a class="elimina_solicitud" id="'.$resultado["solicitud_id"].'"><img src="images/delete.png" /></a></td>' ;
								}
						
							?>
						<?php echo '</tr>';
								}
							
?>                </tbody>
                <tfoot>
                	<tr>
                    	<td colspan="5"><strong>Cantidad:</strong> <span id="span_cantidad">4</span> Solicitudes.</td>
                    </tr>
                </tfoot>
            </table>
	<?php odbc_close( $conn );?>
            


   