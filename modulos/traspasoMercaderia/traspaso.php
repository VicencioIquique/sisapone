<div  id="horizontalForm">
        <fieldset>
                    <legend>Traspaso Mercaderia</legend>
                    <input name="opc" type="hidden" id="opc" size="40" class="required" value="buscarCodigo" />
                     <label for="sku">Numero de Traspaso
                    <input name="codbarra" type="text" class="codbarra2" id="nroTraslado" size="40"  value="" />
                    </label>
                    <label class="first" for="title1">
							Módulo Destino
							<select id="modulo" style="width:120px;" name="modulo">
								<option value="004">184</option>
								<option value="001">1010</option>
								<option value="002">1132</option>
								<option value="005">2002</option>
								<option value="008">2077</option>
								<option value="006">6115</option>
								<option value="007">6130</option>
                                <option value="009">E-C</option>
							</select>
				        </label>
                  
                    <input  style="clear:initial; background-color: #45BB4A;"name="agregar" type="submit" id="validar" class="submit" value="Validar" />
                    <input  style="clear:initial;"name="agregar" type="submit" id="consultar" class="submit" value="Consultar"/>
                     
                   
                                    </fieldset>



    
            <table id="ssptable" class="lista">
                        <thead>
                            <tr>
                                <th><center>Nro</center></th>
                                <th><center>Origen</center></th>
                                <th><center>Destino</center></th>
                                <th><center>SKU</center></th>
                                <th><center>Producto</center></th>
                                <th><center>Cantidad</center></th>
                                <th><center>Estado</center></th>
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
            </table>
        </div>
</div>	
<script type="text/javascript" src="modulos/traspasoMercaderia/js/traspaso.js"></script>