<?php 
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
?>
<div  id="horizontalForm">
    <center><h2>Family & Friends</h2></center>
        <div>
            <table id="ssptable2" class="lista">
                        <thead>
                            <tr>
                                <th><center>Marca</center></th>
                                <th><center>Producto</center></th>
                                <th><center>Código</center></th>
                                <th><center>Fecha Venc.</center></th>
                                <th><center>Unids</center></th>
                                <th><center>Precio Regular</center></th>
                                <th><center>Precio Especial</center></th>
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
            </table>
        </div>
</div>
<script type="text/javascript" src="modulos/family_friends/js/familyF.js"></script>