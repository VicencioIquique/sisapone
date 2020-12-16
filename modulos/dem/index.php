<?php 
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes

$criterio = ""; 
if (isset($_POST['moduloid'])){ 
	if($_POST["moduloid"] != ""){
   		$modulo = $_POST["moduloid"]; 
   		$criterio = " AND [TOrigen] = ".$modulo; 
	}
}
?> 
<div class="idTabs">
      <ul>
        <li><a href="#one"><img src="images/agregar.png" width="30px" height="30px" /></a></li>
      </ul>
      <div class="items">
        <div id="two">
     </div><!-- fin two-->
        <div id="one">
         <form action="" method="POST" id="horizontalForm">
          
            <fieldset>
				<legend>Listado de Entradas de Mercadería</legend>
                <input name="opc" type="hidden" id="opc" size="40" class="required" value="dem" />
                	<label class="first" for="title1">
									Retail
									<select id="moduloid" name="moduloid" class="styled" onchange="this.form.submit()" >
									<option ></option>
									<option value="001" <?php if($modulo == 001) { echo 'selected="selected"'; } ?>>Modulo 1010</option>
									<option value="002" <?php if($modulo == 002) { echo 'selected="selected"'; } ?>>Modulo 1132</option>
									<option value="003" <?php if($modulo == 003) { echo 'selected="selected"'; } ?>>Modulo 181</option>
									<option value="004" <?php if($modulo == 004) { echo 'selected="selected"'; } ?>>Modulo 184</option>
									<option value="005" <?php if($modulo == 005) { echo 'selected="selected"'; } ?>>Modulo 2002</option>
									<option value="006" <?php if($modulo == 006) { echo 'selected="selected"'; } ?>>Modulo 6115</option>
									<option value="007" <?php if($modulo == 007) { echo 'selected="selected"'; } ?>>Modulo 6130</option>
									</select>
				     </label>
                    <label for="pais1">
                    <div  style=" width:20px; height:20px; background-color:#5484C7; float:left;margin-left:50px;  ">
								<span style="margin-left:25px; font-weight:normal; color:#333; width:100px; display:block;">Debe Validar</span>
							 </div><!-- fin   -->
                            
                             <div  style=" width:20px; height:20px; background-color:#6C6B6B;float:left;margin-left:130px;">
								<span style="margin-left:25px; font-weight:normal; color:#333; width:60px;  display:block;">Validado</span>
							 </div><!-- fin   -->
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
                 
				 	  $sql="SELECT [NroDSM] ,[TOrigen],[CodModulo] AS modulo, [Bodega] ,CONVERT(varchar, [FechaDoc], 103) AS Fecha,count([NroDSM]) AS TotalItem,Estado 
							  FROM [RP_VICENCIO].[dbo].[RP_DSM] WHERE CodModulo <> 'TP8' AND CodModulo <> 'TP2' ". $criterio ."
							  GROUP BY [NroDSM],[FechaDoc],[CodModulo],[Bodega],[TOrigen],Estado ORDER BY Estado,FechaDoc DESC";
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
									<td style="background-color:#6C6B6B;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a style="color:#fff;"   href="index.php?opc=validarDEM&nDEM='.$resultado["NroDSM"].'">'.utf8_encode($resultado["NroDSM"]).'</a></td>';
									}
									echo '
								    <td ><strong>'.$resultado["Fecha"].'</strong></td>
									<td >'.getmodulo((int)$resultado["TOrigen"]).'</td>
									<td >'.$resultado["Bodega"].'</td>
									<td >'.$resultado["TotalItem"].'</td>'  ;
																
								}
								else if((int)$resultado["Estado"]==0)
								{
							   echo '<tr>
									<td style="background-color:#5484C7;color:#fff;font-weight:bold; font-size:15px; width:23px; text-align:center;" ><a  style="color:#fff;" href="index.php?opc=validarDEM&nDEM='.$resultado["NroDSM"].'">'.utf8_encode($resultado["NroDSM"]).'</a></td>
									<td ><strong>'.$resultado["Fecha"].'</strong></td>
									<td >'.getmodulo((int)$resultado["TOrigen"]).'</td>
									<td >'.$resultado["Bodega"].'</td>
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