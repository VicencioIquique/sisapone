<?php 
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 600); //300 seconds = 5 minutes


$codbarra = $_GET['codbarra'];
$lote = $_GET['lote'];
	
							
?>
<script type="text/javascript">
  $(document).ready(function(){
				//comienza focus en modulo
				$('#codbarra2').focus();
				// calendarios en text de fecha inicio fin
				$( "#inicio" ).datepicker( );
				//formatos de las fechas
			   // $('#inicio').datepicker('option', {dateFormat: 'dd-mm-yy'});
				$( "#fin" ).datepicker(  );
				//$('#fin').datepicker('option', {dateFormat: 'dd-mm-yy'});
				 $( document ).tooltip();
            });

</script>


<form action="" method="GET" id="horizontalForm">
        
            <fieldset>
				<legend>Etiquetas por Código</legend>
							 
							 <input name="opc" type="hidden" id="opc" size="40" class="required" value="genEtiqueta" />

							 <label for="sku">
					            Codigo de Barra
                            <input name="codbarra" type="text" class="codbarra2" id="codbarra2" size="40"  value="<?php echo $codbarra;?>" />
                            </label>
							 <label for="lote">
					            Lote
                            <input name="lote" type="text" class="lote" id="lote" size="40"  value="<?php echo $lote;?>" />
                            </label>
							 <input  style="clear:initial;"name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />

			</fieldset>
</form>

  <?php
	if($codbarra)
	{
		//include (../impresiones/inf_genEtiqueta.php);
		echo '<iframe  width="100%"  height="450px;"  src="http://192.168.3.41:8080/sisap/modulos/impresiones/inf_genEtiqueta.php?codBarra='.$codbarra.'&lote='.$lote.'" frameborder=0></iframe>' ; 
	
	}
	

	?>
<?php odbc_close( $conn );?>