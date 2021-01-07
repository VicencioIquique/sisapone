<?php 
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
?>
<div  id="horizontalForm">
        <fieldset>
                    <legend>Promociones</legend>
                    <input name="opc" type="hidden" id="opc" size="40" class="required" value="buscarCodigo" />
                     <label for="sku">
                        Codigo de Barra
                    <input name="codbarra" type="text" class="codbarra2" id="codbarra2" size="40"  value="" />
                     </label>
                     <input  style="clear:initial;"name="agregar" type="submit" id="consultar" class="submit" value="Consultar" />
        </fieldset>
        <div>
            <table id="ssptable" class="lista">
                        <thead>
                            <tr>
                                <th><center>SKU</center></th>
                                <th><center>Descripcion</center></th>
                                <th><center>Precio Lista</center></th>
                                <th><center>Oferta</center></th>
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
            </table>
        </div>
        <div id='addPromo' hidden>
            <fieldset>
                <legend>Nueva Oferta</legend>
                <label>Precio <input name="opc"id="txt_oferta" size="40" class="required"/></label>
                <input  style="clear:initial; margin-right :83.5%;"name="agregar" type="submit" id="agregar" class="submit" value="Agregar/Actualizar" />
                <input  style=" margin-right :65%; margin-top:-2.9%;  background-color: #D8492A;"name="agregar" type="submit" id="eliminar" class="submit" value="Eliminar" />
            </fieldset>
        </div>
</div>	
<script type="text/javascript" src="modulos/promociones/js/promos.js"></script>
