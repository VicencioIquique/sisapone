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
				<legend>Listado de Entradas de Mercadería <?php echo getmoduloAir((int)$modulo);?> </legend>
                    <label for="pais1">
                    <div  style=" width:20px; height:20px; background-color:#5484C7; float:left;margin-left:50px;  ">
								<span style=" margin-left:25px; font-weight:normal; color:#333; width:100px; display:block;  ">Debe Validar</span>
							 </div><!-- fin   -->
                            
                             <div  style=" width:20px; height:20px; background-color:#6C6B6B;float:left;margin-left:130px;">
								<span style=" margin-left:25px; font-weight:normal; color:#333; width:60px;  display:block;">Validado</span>
							 </div><!-- fin   -->
					         
        				    <input name="usuario_id" type="hidden" id="usuario_id" size="40" class="required" value="<?php echo $_SESSION['usuario_id'];?>" />
                             <input name="modulo" type="hidden" id="modulo" size="40" class="required" value="<?php echo $modulo;?>" />
                             </label>

				</fieldset>
            </form>
         </div> <!-- fin one -->
 	  </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
  <table  id="ssptable2" class="lista">
              <thead>
                    <tr>
                        <th>Id</th>
						<th>Fecha</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Items</th>               
                        
                    </tr>
                </thead>
                <tbody>
                 <?php
                 
				 	  $sql="SELECT [NroDEM] ,[TOrigen],[CodModulo] AS modulo ,CONVERT(varchar, [FechaDoc], 103) AS Fecha,count([NroDEM]) AS TotalItem,Estado 
							  FROM [RP_REGGEN].[dbo].[RP_DEM] WHERE [CodModulo] = ".$modulo." AND CodModulo <> 'TP8' AND CodModulo <> 'TP2' 
							  GROUP BY NroDEM,[FechaDoc],[CodModulo],[TOrigen],Estado ORDER BY Estado,FechaDoc DESC";
//echo $sql;	
					
					$total =0;
					$cantotal =0;

							
							$rs = odbc_exec( $conn, $sql );
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}

							  while($resultado = odbc_fetch_array($rs)){ 
							  
							//  echo $resultado["estado"];
							  
								if($resultado["Estado"]>0)
								{
									  if($resultado["Estado"]==1)
									{
							   echo '<tr>
									<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a style="color:#fff;"   href="index.php?opc=validarDSMAir&nDsm='.$resultado["NroDEM"].'">'.utf8_encode($resultado["NroDEM"]).'</a></td>';
									}
									echo '
								    <td ><strong>'.$resultado["Fecha"].'</strong></td>
									<td >'.$resultado["TOrigen"].'</td>
									<td >'.getmoduloAir((int)$resultado["modulo"]).'</td>
									<td >'.$resultado["TotalItem"].'</td>'  ;
																
								}
								else if((int)$resultado["Estado"]==0)
								{
							   echo '<tr>
									<td style="background-color:#5484C7;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a  style="color:#fff;" href="index.php?opc=validarDSMAir&nDsm='.$resultado["NroDEM"].'">'.utf8_encode($resultado["NroDEM"]).'</a></td>
									<td ><strong>'.$resultado["Fecha"].'</strong></td>
									<td >'.$resultado["TOrigen"].'</td>
									<td >'.getmoduloAir((int)$resultado["modulo"]).'</td>
									<td >'.$resultado["TotalItem"].'</td>' ;
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