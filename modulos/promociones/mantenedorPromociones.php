<?php 
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
?>
<form action="" method="GET" id="horizontalForm">
        <fieldset>
                    <legend>Ingresar Fechas</legend>
                         
                    <input name="opc" type="hidden" id="opc" size="40" class="required" value="buscarCodigo" />
                     <label for="sku">
                        Codigo de Barra
                    <input name="codbarra" type="text" class="codbarra2" id="codbarra2" size="40"  value="" />
                     </label>
                     <input  style="clear:initial;"name="agregar" type="submit" id="agregar" class="submit" value="Consultar" />
        </fieldset>
</form>