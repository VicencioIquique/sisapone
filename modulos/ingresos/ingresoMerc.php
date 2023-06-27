<?php
    session_start();
    $revision = $_SESSION["usuario_user"];
    //print_r($_SESSION);
    echo '<script> var tipoUsuario = '.$_SESSION[usuario_rol].'; </script>';
?>

<script type="text/javascript" src="js/jquery.base64.js"></script>
<script type="text/javascript" src="js/tabla/xlsx.core.min.js"></script>
<script type="text/javascript" src="js/tabla/FileSaver.js"></script>

<script type="text/javascript" src="js/tabla/tableExport.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript" src="modulos/ingresos/funciones.js"></script>

<link rel="stylesheet" href="css/fa6.3.0/css/all.css"></link>
<link rel="stylesheet" href="css/bootstrap.css"></link>
<style type="text/css">


    .rotar {
        writing-mode: vertical-lr;
        transform: rotate(180deg);
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%;
        overflow: auto; 
        background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 70%;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover, .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .datosConteo{
        width: 100%; 
        text-align: right;
    }

    #loader{
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #anio, #zeta1{
        text-align: center;
    }

    #ssptable2 tr:nth-child(2n) {
        background: transparent;
    }

</style>

<div class="">
    <form action="" method="GET" id="formZeta">
        <fieldset style="padding: 12px;">
            <div class="row">
                <div class="col-3 row">
                    <div class="col-8"><div style="text-align: center;"> Año (2 dígitos) </div></div>
                    <div class="col-4"><input name="anio" type="tel" id="anio" class="required" style="width: 100%;" value=""/></div>
                </div>
                <div class="col-5 row">
                    <div class="col-4"><div style="text-align: center;">Zeta</div></div>
                    <div class="col-8"><input name="zeta1" type="tel" class="required" id="zeta1" style="width: 100%;" value="" /></div>
                </div>
                <div class="col-4">
                <div style="text-align: center; padding: 10px;">
                    <input name="agregar" type="submit" id="agregar" class="submit btn btn-primary" value="Buscar Zeta" style="width:50%;"/>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<div id="divBuscador" class="row" style="padding: 5px 10px 5px 10px;">
    <hr>
    <div class="col-2">
        <button id="descargarExcel" class="btn btn-success btn-block">Exportar Excel</button>
    </div>
    
    <div class="col-8">
        <form action="" method="GET" id="buscarCodigo">
            <div align="center">
                <label for="codigo">
                    Ingrese código de producto:
                    <input name="codigo" type="text" id="codigo" value="" />
                </label>
                <input name="buscar" style="clear:initial;"  type="submit" id="buscar" class="submit btn btn-dark" value="Buscar" />
            </div>
        </form>
    </div>
    <div class="col-2">
        <div align="right">
            <button id="btnSinCod" type="button" class="btn btn-warning btn-block"><text style="color: white;">Buscar Sin Código</text></button>
        </div>
    </div>
</div>

<div id="tabla" style="padding: 0px 5px 0px 5px;">
    <table  id="ssptable2" class="lista table" style="table-layout: auto;width: 100%; margin-top: 0px;">
        <thead>
            <tr>
                <th style="vertical-align: middle; text-align: center; width: 3%;">N°</th>        
                <th style="vertical-align: middle; text-align: center; width: 10%;">Código Zeta</th>
                <th style="display: none;">Código Físico</th>
                <th style="vertical-align: middle; text-align: center; width: 5%;">Código Físico</th>
                <th style="vertical-align: middle; text-align: center; width: 30%;">Descripcion</th>
                <th class="rotar" style="vertical-align: middle;  width: 4%;"> Unidades Facturadas</th>
                <th class="rotar" style="vertical-align: middle; height: 80px; width: 4%;">Cajas</th>
                <th class="rotar" style="vertical-align: middle; width: 4%;">Unidades Por Caja</th>
                <th class="rotar" style="vertical-align: middle; width: 4%;">Unidades Sueltas</th>
                <th class="rotar" style="vertical-align: middle; width: 4%;">Total</th>
                <th class="rotar" style="vertical-align: middle; width: 4%;">Faltantes</th>
                <th class="rotar" style="vertical-align: middle; width: 4%;">Sobrantes</th>
                <th class="rotar" style="vertical-align: middle; width: 4%;">Mal Estado</th>
                <th class="rotar"style="vertical-align: middle; text-align: center; width: 5%">Lote</th>
                <th class="rotar"style="vertical-align: middle; text-align: center; width: 8%">Ubicación</th>
                <th style="vertical-align: middle; text-align: center; width: 7%">Operaciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<!-- <button id="myBtn">Open Modal</button> -->

<div id="myModal" class="modal">
    <div class="modal-content" style="margin: 5% auto; margin-top: 5%; margin-right: auto; margin-bottom: 5%; margin-left: auto;">
        <div class="row">
            <div class="col-6">
                <input id="idProducto" type="hidden">
                <input id="codigoP" type="hidden">
            </div>
            <div class="col-6">
                <span class="close">&times;</span>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="col-12 row">
                    <div class="col-6"><h4>Datos Zeta</h4></div>
                    <div class="col-6">

                    </div>
                </div>
                <div class="row">
                    <div class="col-6 row">
                        <div class="col-4"><b>Código Zeta:</b></div>
                        <div class="col-6" id="codigoM"></div>
                    </div>
                    <div class="col-6 row">
                        <div class="col-4"><b>Código Físico:</b></div>
                        <div class="col-6">
                            <label for="codigoF" id="textCodigoF" style="color: red;"></label>
                            <input type="text" id="codigoF">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2"><b>Descripción:</b></div>
                    <div class="col-10"  id="textoM"></div>
                </div>
                <div class="row">
                    <div class="col-6 row">
                        <div class="col-4">
                            <b>Nº Item: </b>
                        </div>
                        <div class="col-4" id="item">
                            <input class="datosConteo" id="numItem" type="text" disabled>  
                        </div>
                        <div class="col-4" id="item"></div>
                    </div>
                    <div class="col-6 row">
                        <div class="col-4">
                            <b>Referencia: </b>
                        </div>
                        <div class="col-4" id="item">
                            <input class="datosConteo" id="referencia" type="text" disabled>  
                        </div>
                        <div class="col-4" id="item"></div>
                    </div>
                </div>
                </br>
            </div>
            <br>
            <hr>
            <div class="col-md-6 col-xs-12 p-2" style=" border-right-color: rgba(33, 37, 41, 0.5); border-right-style: solid; border-right-width: 1px;">
                <div class="row">
                    <div class="col-4"><h5><b>Conteo</b></h5></div>
                    <div class="col-4"></div>
                    <div class="col-4" align="center"><h6>Acumulado</h6></div>
                </div>
                <div class="row p-1">
                    <div class="col-4">Cajas</div>
                    <div class="col-4"><input type="number"  class="datosConteo calculo" id="ccajas" min="0"></div>
                    <div class="col-4"><input type="number"  class="datosConteo" id="accajas" disabled></div>
                </div>
                <div class="row p-1">
                    <div class="col-4">Unidades/Caja</div>
                    <div class="col-4"><input type="number" class="datosConteo calculo " id="uxcajas" min="0"></div>
                    <div class="col-4"><input type="number"  class="datosConteo" id="auxcajas" disabled></div>
                </div>
                <div class="row p-1">
                    <div class="col-4">Unidades Sueltas</div>
                    <div class="col-4"><input type="number" class="datosConteo calculo" id="usueltas" min="0"></div>
                    <div class="col-4"><input type="number"  class="datosConteo" id="ausueltas" disabled></div>
                </div>
                <div class="row p-1">
                    <div class="col-4">Total Conteo</div>
                    <div class="col-4"><input type="number" class="datosConteo" id="totalConteo" disabled></div>
                    <div class="col-4"><input type="number" class="datosConteo" id="atotalConteo" disabled></div>
                </div>
                <div class="row p-1">
                    <div class="col-8"><b>Unidades Zeta</b></div>
                    <div class="col-4"><input type="number" class="datosConteo" id="uFacturadas" disabled></div>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 p-2">
                <div class="row p-1">
                    <div class="col-4"><h5><b>Revisión</b></h5></div>
                    <div class="col-4"></div>
                    <div class="col-4" align="center"><h6>Acumulado</h6></div>
                </div>
                
                <div class="row p-1">
                    <div class="col-4">Faltantes</div>
                    <div class="col-4"><input type="number" class="datosConteo" id="ufaltantes" min="0"></div>
                    <div class="col-4"><input type="number"  class="datosConteo" id="aufaltantes" disabled></div>
                </div>
                <div class="row p-1">
                    <div class="col-4">Sobrantes</div>
                    <div class="col-4"><input type="number" class="datosConteo" id="usobrantes" min="0"></div>
                    <div class="col-4"><input type="number"  class="datosConteo" id="ausobrantes" disabled></div>
                </div>
                <div class="row p-1">
                    <div class="col-4">Mal Estado</div>
                    <div class="col-4"><input type="number" class="datosConteo" id="malestado" min="0"></div>
                    <div class="col-4"><input type="number"  class="datosConteo" id="amalestado" disabled></div>
                </div>
                <div class="row p-1">   
                    <div class="col-8">Numero Lote</div>
                    <div class="col-4"><input type="text" id="numLote" style="width: 100%; text-align: right;"></div>
                </div>

                <div class="row p-1" id="divLimpiar">
                    <div class="col-8">Limpiar</div>
                    <div class="col-4"><button id="btnLimpiar" type="button" class="btn btn-info btn-block">
                            <text style="color: white;">Limpiar datos</text>
                        </button>
                    </div>
                </div> 
                
            </div>
            <div class="col-12">
                <div align="right" style="padding: 10px;">
                    <button id="btnSalir" type="button" class="btn btn-info btn-danger"><text style="color: white;">Cancelar</text></button>
                    <button id="btnAdd" type="button" class="btn btn-info btn-block"><text style="color: white;">Agregar Datos</text></button>
                </div>
            </div>
        </div> 
        <hr>
        <div class="col-12" id="divUbicacion" type="hidden">
            <div class="row">
                <div class="col-12 row">
                    <div class="col-lg-3 col-xs-12 p-1 row"  style="border-right-color: rgba(33, 37, 41, 0.5); border-right-style: solid; border-right-width: 1px;">
                        <div class="col-12" style="text-align: center;"><b>Ubicacion Actual</b></div>
                        <div class="col-12"><input type="text" id="ubiactual" style="width: 100%; text-align: center;" disabled></div>
                    </div>
                    <div class="col-lg-7 col-xs-12 row" align="center">
                    <div class="col-12"  style="text-align: center;"><b>Ingresar nueva ubicación</b></div>
                        <div class="col-3">
                            <div>Galpon</div>
                            <div>
                                <select name="galUbi" id="galUbi">
                                    <option value="G4">4</option>
                                    <option value="G5">5</option>
                                    <option value="G6">6</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="col-3">
                            <div>
                                Rack
                            </div>
                            <div>
                                <select name="numUbi" id="numUbi">
                                    <option value="R1">1</option>
                                    <option value="R2">2</option>
                                    <option value="R3">3</option>
                                    <option value="R4">4</option>
                                    <option value="R5">5</option>
                                    <option value="R6">6</option>
                                    <option value="R7">7</option>
                                    <option value="R8">8</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div>
                                Columna
                            </div>
                            <div>
                                <select name="colUbi" id="colUbi">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="col-3">
                            <div>
                                Nivel
                            </div>
                            <div>
                                <select name="nivUbi" id="nivUbi">
                                    <option value="1">1 - Base</option>
                                    <option value="2">2 - Medio</option>
                                    <option value="3">3 - Arriba</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-xs-12 p-1">
                        <div class="col-12" align="center"><button id="btnUpdate" type="button" class="btn btn-success btn-block"><text style="color: white;">Actualizar ubicación</text></button></div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="col-12">

        </div>
    </div>
</div> 


<div id="myModal2" class="modal">
    <div class="modal-content" style="margin: 5% auto; margin-top: 5%; margin-right: auto; margin-bottom: 5%; margin-left: auto;">
        <div class="row">
            <div class="col-12">
                <span class="close">&times;</span>
            </div>
            <div class="col-12">
                <form action="" method="GET" id="buscarReferencia">
                    <div align="center">
                        <label for="codigoRef">
                            Ingrese código de referencia:
                            <input name="codigoRef" type="text" id="codigoRef" value="" />
                        </label>
                        <input name="buscarRef" style="clear:initial;"  type="submit" id="buscarRef" class="submit btn btn-dark" value="Buscar Referencia" />
                    </div>
                </form>
            </div>
            <div class="col-12">
                <div align="right" style="padding: 10px;">
                    <button id="btnSalir2" type="button" class="btn btn-info btn-danger"><text style="color: white;">Cancelar</text></button>
                </div>
            </div>
        </div>
    </div>
</div> 

<div id="loader">
    <div class="spinner-border text-info" role="status">
        <span class="sr-only">Cargando...</span>
    </div>
</div>
