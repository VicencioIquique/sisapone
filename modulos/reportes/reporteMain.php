<script type="text/javascript" src="js/jquery.base64.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="js/datatables.min.css" rel="stylesheet"/>
<link href="js\Buttons-2.3.6\css\buttons.bootstrap.min.css" rel="stylesheet"/>

<script src="js/datatables.min.js"></script>
<script src="js\Buttons-2.3.6\js\buttons.bootstrap.min.js"></script>
<script type="text/javascript" src="modulos/reportes/reporteConteo.js"></script>

<link rel="stylesheet" href="css/fa6.3.0/css/all.css"></link>
<link rel="stylesheet" href="css/bootstrap.css"></link>


<style type="text/css">

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

    .tabla {
		margin: 0 auto 0 auto;
		 clear: both;
		position:relative;
		background:#F2F6F6;
		margin-bottom:15px;
		margin-top:15px;
		width:98%;
		overflow:auto;		}
	.tabla thead {
        background:#444;
        color:#eff4f4;
        font-weight:bold;
        text-transform:uppercase;
        font-size:12px;
        letter-spacing:-1px;
        text-align:left;
    }
	.tabla #celdcolor {
        background:#d4d4d4;
        color:#444;
        font-weight:bold;
        text-transform:uppercase;
        font-family:"Myriad Pro", Verdana, Arial;
        font-size:9px;
        letter-spacing:-1px;
        text-align:left;
    }

    .tabla #celdcolor2 {
        background:#444;
        color:#FFF;
        font-weight:bold;
        text-transform:uppercase;
        font-family:"Myriad Pro", Verdana, Arial;
        font-size:9px;
        letter-spacing:-1px;
        text-align:left;
    }

	.tabla th,
	.tabla td {
		padding:10px;
		border-bottom:1px solid #F0F0F0;
		font-size:11px;
		vertical-align:text-top;
	}

	.tabla td {
		border-right: 1px dashed #C7C7C7;
	}

	.tabla tr:nth-child(even) {
        background: #e1e1e1;
    }

    .tabla tbody tr:hover {
        background: #649ebf;
        color:#FFF;
        border-right: 1px dashed #D0EEFF;
    }

</style>
<div class="p-2">
    <div class="">
        <form action="" method="GET" id="formZeta">
            <fieldset style="padding: 12px;">
                <div class="row">
                    <div class="col-3 row">
                        <div class="col-8"><div style="text-align: center;"> Año (2 dígitos) </div></div>
                        <div class="col-4"><input name="anio" type="tel" id="anio" class="required" style="width: 100%;" value="22" /></div>
                    </div>
                    <div class="col-5 row">
                        <div class="col-4"><div style="text-align: center;">Zeta</div></div>
                        <div class="col-8"><input name="zeta1" type="tel" class="required" id="zeta1" style="width: 100%;" value="037909" /></div>
                    </div>
                    <div class="col-4">
                        <div style="text-align: center; padding: 10px;">
                            <input name="agregar" type="submit" id="agregar" class="submit btn btn-primary" value="Buscar Zeta" style="width:50%;"/>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="row m-2" style="vertical-align: center;">
                <div class="col-8">Items Zeta</div>
                <div class="col-4" align="right" id="izeta">0</div>
                <div class="col-8">Items ingresados</div>
                <div class="col-4" align="right" id="iingre">0</div>
                <div class="col-8">Códigos Físicos Distintos</div>
                <div class="col-4" align="right" id="ifisic">0</div>
                <div class="col-8"></div>
                <div class="col-4"></div>
            </div>
        </div>
        <div class="col-8">
            <div id="Datos" class="m-2">
                <div id="g1">

                </div>
            </div>
        </div>
    </div>

    <div id="codFisico" style="padding: 0px 10px 0px 10px;">

    </div>

    <div id="codFaltantes" style="padding: 0px 10px 0px 10px;">

    </div>

    <div id="codSobrantes" style="padding: 0px 10px 0px 10px;">

    </div>

    <div id="codMalos" style="padding: 0px 10px 0px 10px;">

    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <button id="descargarExcel" class="btn btn-info" style="display:none; padding: 10px 25px 10px 25px;">Exportar a Excel</button>
    </div>
</div>
<div id="loader">
    <div class="spinner-border text-info" role="status">
        <span class="sr-only">Cargando...</span>
    </div>
</div>
