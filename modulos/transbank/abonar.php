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

                fn_eliminar_abonoTransbank();
				$('#busqueda').focus();

            });

</script>

<?php
 
      $buscar = $_POST['b'];
    
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
         <form action="javascript: fn_agregar_abono();" method="post" id="horizontalForm">
          
            <fieldset>
				<legend>Nueva Abono</legend>
                    <label for="pais1">
					        
        				 <input name="usuario_id" type="hidden" id="usuario_id" size="40" class="required" value="<?php echo $_SESSION['usuario_id'];?>" />
                         <input name="usuario" type="hidden" id="usuario" size="40" class="required" value="<?php echo $_SESSION['usuario_nombre'];?>" />
					</label>	 
						<label class="first" for="title1">
									Retail
									<select id="retail" name="retail"    class="styled" >
									
									<option value="LOCAL.2">Local 2</option>
									<option value="LOCAL.8">Local 8</option>
									<option value="ZFI.1010">Modulo 1010</option>
									<option value="ZFI.1132">Modulo 1132</option>
									<option value="ZFI.181">Modulo 181</option>
									<option value="ZFI.184">Modulo 184</option>
									<option value="ZFI.2002">Modulo 2002</option>
									<option value="ZFI.6115">Modulo 6115</option>
									<option value="ZFI.6130">Modulo 6130</option>
									<option value="ZFI.2077">Modulo 2077</option>
									</select>
					     </label>
						 
						 <label class="first" for="title1">
									Tipo de Pago
									<select id="tipoPago" name="tipoPago"   class="required" >
									<option value="CreditCard">T. Credito</option>
									<option value="DebitCard">T. Debito</option>
									</select>
					     </label>
						 
						 <label for="fecha1">
					            Monto a Abonar
                            <input name="monto" type="text" id="monto" size="40" class="required"   />
                         </label>
                     
                            <input style="clear:initial;" name="agregar" type="submit" id="agregar" class="submit" value="Abonar" />
				</fieldset>
            </form>
         </div> <!-- fin one -->
 	  </div> <!-- fin items -->
    </div> <!-- fin idTabs -->
  <table  id="ssptable2" class="lista">
              <thead>
                    <tr>
                        <th>ID</th>
                        <th>Retail</th>
                        <th>Tipo Pago</th>
                        <th>Fecha</th>
                        <th>Monto</th>
						 <th>Responsable</th>
                       <?php
						if($_SESSION['usuario_id']== 101)
							echo '<th>&nbsp;</th>'; ?>
                    </tr>
                </thead>
                <tbody>
                 <?php
                 
				 	$sql="SELECT 
					       [abono_id]
						  ,[bodega]
						  ,[tipoPago]
						  ,[monto]
						  ,[descripcion]
						  ,[fechaCreacion]
						  ,[fechaDoc]
						  ,[usuario]
					  FROM [RP_VICENCIO].[dbo].[sisap_abonosTransbank]
					  ORDER BY FechaCreacion DESC";

					
					$total =0;
					$cantotal =0;

							//echo $sql;	
							$rs = odbc_exec( $conn, $sql );
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}

							  while($resultado = odbc_fetch_array($rs))
							  { 
							  
							
							   echo '<tr>
									<td style="background-color:#5484C7;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" >'.$resultado["abono_id"].'</td>
									<td ><strong>'.utf8_encode($resultado["bodega"]).'</strong></td>
									<td >'.$resultado["tipoPago"].'</td>
									<td >'.utf8_encode($resultado["fechaCreacion"]).'</td>
									<td >'.number_format($resultado["monto"], 0, '', '.').'</td>
									<td >'.utf8_encode($resultado["usuario"]).'</td>';
									if($_SESSION['usuario_id']== 101)
									{	
										echo'<td ><a class="elimina_abono" id="'.$resultado["abono_id"].'"><img src="images/delete.png" /></a></td>';
									}
									echo'</tr>' ;
							
								}
							

				             ?>
                </tbody>
                <tfoot>
                	<tr>
                    	<td colspan="5"><strong>Cantidad:</strong> <span id="span_cantidad">4</span> Abonos.</td>
                    </tr>
                </tfoot>
            </table>
	<?php odbc_close( $conn );?>
            


   