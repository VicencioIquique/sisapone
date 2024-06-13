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
                fn_eliminar_solicitud();
				fn_revisar_solicitud();
				fn_enviar_SAP();
				$('#busqueda').focus();
            });// funcion principal jquery
</script>

<?php
 
      $buscar = $_GET['b'];
	 
	  if ($buscar)// si selecciono modulo, se genera la consulta
	 {
		$wBuscar = "  AND solicitud_id = '".$buscar."'";
		
	 }
	
    
?>
   <form action="" method="GET" id="horizontalForm">
            <fieldset>
				<legend>Buscar Pedido</legend>
					<input name="b" type="text" id="busqueda" size="40"  value="<?php echo $buscar;?>" />
					 <input name="opc" type="hidden" id="opc" size="40" class="required" value="nuevaSolicitudbrand" /> 
                    </label>
                        <input style="clear:initial;" name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />
						  
							
				</fieldset>
            </form>
    
<div  style="margin-bottom:10px;" class="paso"  >1 Paso</div><div style="margin-bottom:10px;" class="paso" >2 Paso</div><div style="margin-bottom:10px;" class="paso_selected"  >3 Paso</div>

        <input name="usuario_id" type="hidden" id="usuario_id" size="40" class="required" value="<?php echo $_SESSION['usuario_id'];?>" />
		
		
            <table  id="ssptable2" class="lista">
              <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre Solicita</th>
                        <th>Estado</th>
                        <th>Fecha Creación</th>
                        <th>Fecha Estado</th>
                       
                        <th>Retail</th>
                        
                        <th>Revisión</th>
						<th WIDTH="40px;">Enviar</th>
						<th WIDTH="20px;">Docs</th>
                    
                    </tr>
                </thead>
                <tbody>
                 <?php
                 
				 	/*$sql="SELECT [solicitud_id]
						  ,[estado]
						  ,[Fecha]
						  ,[fecha_estado]
						  ,[cantidad_total]
						  ,[modulo]
						  ,[vendedor_id]
						  ,[recepcion_id]
						  ,[usuario_nombre]
					  FROM [RP_VICENCIO].[dbo].[SI_SolicitudesMercaderia_ON]";*/
		
		$filaPag =25; 
				
				if(isset($_GET['page']))
				{
					$page= $_GET['page'];
				}
				else
				{
					//SI NO DIGO Q ES LA PRIMERA PÁGINA
					$page=1;
				}		
					$sqlfilas="SELECT     COUNT(solicitud_id) AS Filas
								FROM [RP_VICENCIO].[dbo].[SI_SolicitudesMercaderia_ON]
								WHERE     (estado NOT LIKE 0) ";
					$result = odbc_exec( $conn, $sqlfilas );
					$arr = odbc_fetch_array($result);	
					$filas = $arr['Filas']; //cantidad de registros de tabla
					
					$lastpage= ceil($filas/ $filaPag);
					
					$page=(int)$page;
 
					if($page > $lastpage)
					{
						$page= $lastpage;
					}
					 
					if($page < 1)
					{
						$page=1;
					}
  
					
				 	$sql=" DECLARE @rowsperpage INT

							DECLARE @start INT

							SET @start = ".(($page-1)*25)."
							SET @rowsperpage = ".$filaPag." 

							SELECT * FROM
							(
							SELECT row_number() OVER (ORDER BY estado,solicitud_id DESC) AS rownum, [solicitud_id]
								  ,[estado]
								  ,[Fecha]
								  ,replace(convert(NVARCHAR, [fecha_estado], 103), ' ', '/') as fecha_estado
								
							
								  ,[vendedor_id]
								  ,[recepcion_id]
								  ,[usuario_nombre]
								  ,[bodega]
								  ,[modulo]
								  ,[recepcion_nombre]
								  ,[cantDoc]
							FROM   [RP_VICENCIO].[dbo].[SI_SolicitudesMercaderia_ON]
							WHERE  (estado NOT LIKE 0)  ".$wBuscar."
							) AS A
							WHERE A.rownum 
							BETWEEN (@start) AND (@start + @rowsperpage) ";
							//echo $sql;
					
					$total =0;
					$cantotal =0;

							
							$rs = odbc_exec( $conn, $sql );
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}
							
					     odbc_next_result($rs);
						if (odbc_next_result($rs))
						{

							  while($resultado =  odbc_fetch_array($rs)){ 
							//   echo $resultado["estado"];
							  //<td style="background-color:#146672;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a class="revisar_solicitud" style="color:#fff;" id="'.$resultado["solicitud_id"].'">'.utf8_encode($resultado["solicitud_id"]).'</a></td>
							  if($resultado["estado"]==1)
							  {
							   echo '<tr>
									<td style="background-color:#146672;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a style="color:#fff;" href="index.php?opc=paso2brand&idsol='.$resultado["solicitud_id"].'">'.utf8_encode($resultado["solicitud_id"]).'</a></td>
									<td ><strong>'.utf8_encode($resultado["usuario_nombre"]).'</strong></td>
									<td >'.getestado($resultado["estado"]).'</td>
									<td >'.utf8_encode($resultado["Fecha"]).'</td>
									<td >'.utf8_encode($resultado["fecha_estado"]).'</td>
									
									<td >'.utf8_encode(substr($resultado["bodega"],4,10)).'</td>
									
									<td >'.utf8_encode($resultado["recepcion_nombre"]).'</td>
									<td ></td>
									<td >'.$resultado["cantDoc"].'</td>
									' ;
							  } //fin if 
							  
							    if($resultado["estado"]>1)
							  {
								  if($resultado["estado"]==2)
								  {
							   echo '<tr>
									<td style="background-color:#705249;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a  style="color:#fff;" href="index.php?opc=paso2brand&idsol='.$resultado["solicitud_id"].'">'.utf8_encode($resultado["solicitud_id"]).'</a></td>';
								  }
								  if($resultado["estado"]==3)
								  {
							   echo '<tr>
									<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a  style="color:#fff;" target="_blank" href="modulos/impresiones/listasolicitudpdf.php?idsol='.$resultado["solicitud_id"].'">'.utf8_encode($resultado["solicitud_id"]).'</a></td>';
								  }
								 if($resultado["estado"]==4)
								  {
							   echo '<tr>
									<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a  style="color:#fff;" target="_blank" href="modulos/impresiones/listasolicitudpdf.php?idsol='.$resultado["solicitud_id"].'">'.utf8_encode($resultado["solicitud_id"]).'</a></td>';
								  }
								
									echo '<td ><strong>'.utf8_encode($resultado["usuario_nombre"]).'</strong></td>
									<td >'.getestado($resultado["estado"]).'</td>
									<td >'.utf8_encode($resultado["Fecha"]).'</td>
									<td >'.utf8_encode($resultado["fecha_estado"]).'</td>
									
									<td >'.utf8_encode(substr($resultado["bodega"],4,10)).'</td>
									
									<td >'.utf8_encode($resultado["recepcion_nombre"]).'</td>';
									
									if($resultado["estado"]==3 &&  $_SESSION["usuario_nombre"] != "Mauricio Huerta" &&  $_SESSION["usuario_nombre"] == $resultado["recepcion_nombre"])
								    {
									 echo '<td ><a class="enviar_SAP" id="'.$resultado["solicitud_id"].'" ><img src="images/saplogo.png" width="40px" height="20px" ></a></td>
									 <td >'.$resultado["cantDoc"].'</td>';
									}
									else if($resultado["estado"]==4)
								    {
									 echo '<td ><img src="images/saplogoGris.png" width="40px" height="20px" ></td>
									 <td >'.$resultado["cantDoc"].'</td>';
									}
									else 
									echo '<td ></td>
									      <td >'.$resultado["cantDoc"].'</td>';

							  } //fin if 
						
							echo '</tr>';
								}
						}//fin if de paginacion
?>
                </tbody>
                <tfoot>
                	<tr>
                    	<td colspan="5"><strong>Cantidad:</strong> <span id="span_cantidad">4</span> Solicitudes.</td>
                    </tr>
                </tfoot>
            </table>
 <?php
			//UNA VEZ Q MUESTRO LOS DATOS TENGO Q MOSTRAR EL BLOQUE DE PAGINACIÓN SIEMPRE Y CUANDO HAYA MÁS DE UNA PÁGINA
      
    if($filas != 0)
    {
       $nextpage= $page +1;
       $prevpage= $page -1;
     
       ?><ul id="pagination-clean"><?php
           //SI ES LA PRIMERA PÁGINA DESHABILITO EL BOTON DE PREVIOUS, MUESTRO EL 1 COMO ACTIVO Y MUESTRO EL RESTO DE PÁGINAS
           if ($page == 1) 
           {
            ?>
              <li class="previous-off">&laquo; Anterior</li>
              <li class="active">1</li> 
         <?php
              for($i= $page+1; $i<= $lastpage ; $i++)
              {?>
                <li><a href="?opc=nuevaSolicitudbrand&page=<?php echo $i;?>"><?php echo $i;?></a></li>
        <?php }
           
           //Y SI LA ULTIMA PÁGINA ES MAYOR QUE LA ACTUAL MUESTRO EL BOTON NEXT O LO DESHABILITO
            if($lastpage >$page )
            {?>      
                <li class="next"><a href="?opc=nuevaSolicitudbrand&page=<?php echo $nextpage;?>" >Siguiente &raquo;</a></li><?php
            }
            else
            {?>
                <li class="next-off">Next &raquo;</li>
        <?php
            }
        } 
        else
        {
     
            //EN CAMBIO SI NO ESTAMOS EN LA PÁGINA UNO HABILITO EL BOTON DE PREVIUS Y MUESTRO LAS DEMÁS
        ?>
            <li class="previous"><a href="?opc=nuevaSolicitudbrand&page=<?php echo $prevpage;?>">&laquo; Anterior</a></li><?php
             for($i= 1; $i<= $lastpage ; $i++)
             {
                           //COMPRUEBO SI ES LA PÁGINA ACTIVA O NO
                if($page == $i)
                {
            ?>       <li class="active"><?php echo $i;?></li><?php
                }
                else
                {
            ?>       <li><a href="?opc=nuevaSolicitudbrand&page=<?php echo $i;?>" ><?php echo $i;?></a></li><?php
                }
            }
             //Y SI NO ES LA ÚLTIMA PÁGINA ACTIVO EL BOTON NEXT     
            if($lastpage >$page )
            {   ?>   
                <li class="next"><a href="?opc=nuevaSolicitudbrand&page=<?php echo $nextpage;?>">Siguiente &raquo;</a></li><?php
            }
            else
            {
        ?>       <li class="next-off">Next &raquo;</li><?php
            }
        }     
    ?></ul></div><?php
    } 

?>	       
            
            
            
            
            
            
	<?php odbc_close( $conn );?>
            


   