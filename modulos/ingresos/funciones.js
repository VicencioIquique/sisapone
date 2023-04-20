window.datosGlobal = [];
window.buscador = "";
function buscarZeta(){
    $("#formZeta").on('submit', function(e){

        data = [];
        
        var zeta = $('#zeta1').val();
        var anio = $('#anio').val();

        data.push({zet: zeta});
        data.push({ano: anio});

        $.ajax({
            type: "POST",
            url: "modulos/ingresos/funciones.php",
            data: {data:data, controlador: "buscar"},
            success: function(e) {
                console.log(e);
                res = e.toString();
                if(res === 'ok'){
                    $("#loader").show();
                    $.ajax({
                        type: "POST",
                        url: "modulos/ingresos/funciones.php",
                        dataType:"json",
                        data: {data:data, controlador: "cargar"},
                        success: function(datos) {
                            
                            if(datos === 'error4'){
                                Swal.fire(
                                    'Error',
                                    'No se encuentra registro de Zeta.',
                                    'error'
                                )
                            }else{
                                $("#divBuscador").show();
                                console.log(datos);
                                window.datosGlobal = datos;
                                $('#tabla').empty();
                                
                                html = `                          
                                <div id="usual1"> 
                                    <div id="tab1">
                                        <table  id="ssptable2" class="lista" style="table-layout: auto;width: 100%; margin-top: 0px;">
                                            <thead style="letter-spacing: 1px;">
                                                    <tr>
                                                        <th style="vertical-align: middle; text-align: center; width: 3%;">N°</th>        
                                                        <th style="vertical-align: middle; text-align: center; width: 10%;">Código Zeta</th>
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
                                            <tbody>`;

                                for (let i = 0; i < datos.length; i++) {
                                    
                                    html += `
                                        <tr>
                                            <td>`+datos[i].item+`</td>
                                            <td>`+datos[i].codZ+`</td>`;

                                    if(datos[i].codF == ""){
                                        html += `<td></td>`;
                                    }else if(datos[i].codZ == datos[i].codF) {
                                        html += `<td style="text-align: center;"><i class="fa-solid fa-check"></i></td>`;
                                    }else if(datos[i].codZ != datos[i].codF){
                                        html += `<td style="text-align: center;"><i class="fa-solid fa-not-equal"></i></td>`;
                                    }
                                            
                                            
                                    html += `<td>`+datos[i].desc+`</td>
                                            <td>`+datos[i].uniF+`</td>
                                            <td>`+datos[i].caja+`</td>
                                            <td>`+datos[i].ucaj+`</td>
                                            <td>`+datos[i].suel+`</td>
                                            <td>`+datos[i].totl+`</td>
                                            <td>`+datos[i].falt+`</td>
                                            <td>`+datos[i].sobr+`</td>
                                            <td>`+datos[i].mala+`</td>
                                            <td>`+datos[i].lote+`</td>
                                            <td>`+datos[i].ubic+`</td>
                                            <td style="vertical-align: middle; text-align: center;">
                                                <button type="button" onclick="agregar(`+i+`)" class="btn btn-warning">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                            </td>
                                        </tr>`;
                                }

                                html += `</tbody></table></div></div>`;   
                                $('#tabla').append(html);
                                $("#loader").hide();
                            }
                        }
                    });

                }else if(res === 'error1'){
                    $("#loader").hide();
                    Swal.fire(
                        'Error SQL',
                        'Contactar a informática.',
                        'error'
                    )
                }else if(res === 'error2'){
                    $("#loader").hide();
                    Swal.fire(
                        'Error',
                        'No se encuentra registro de Zeta en SVE.',
                        'error'
                    )
                }else if(res === 'error3'){
                    $("#loader").hide();
                    Swal.fire(
                        'Error SQL',
                        'No se puede insertar registro.',
                        'error'
                    )
                }else if(res === 'error4'){
                    $("#loader").hide();
                    Swal.fire(
                        'Error',
                        'No se encuentra registro de Zeta.',
                        'error'
                    )
                }
                
                        
            }
        });
        return false;
    });
}

function buscarCodigo(){
   
    $("#buscarCodigo").on('submit', function(e){
        e.preventDefault();
        var codigo = $('#codigo').val();
        datosArray = window.datosGlobal;
        codigoFound = "no";
        $("#loader").show();
        for (let x = 0; x < datosArray.length; x++) {
            codArray = datosArray[x].codZ;
            
            if(codigo == codArray) {
                $("#loader").hide();
                codigoFound = "si";
                window.buscador = "codigo";
                agregar(x);
                break;
            }
        }

        if (codigoFound == "no") {
            Swal.fire(
                'Error',
                'No se encuentra el Código en este Zeta.',
                'error'
            )
        }        
    });
}

function buscarReferencia(){
    $("#buscarReferencia").on('submit', function(e){
        e.preventDefault();
        var codigo = $('#codigoRef').val();
        datosArray = window.datosGlobal;
        var codigoFound = "no";
        $("#loader").show();
        for (let x = 0; x < datosArray.length; x++) {
            codReferencia = datosArray[x].refe;
            
            if(codigo == codReferencia) {
                $("#loader").hide();
                var modal2 = document.getElementById("myModal2"); 
                modal2.style.display = "none";
                codigoFound = "si";
                window.buscador = "referencia";
                agregar(x);
                break;
            }
        }

        if (codigoFound == "no") {
            $("#loader").hide();
            Swal.fire(
                'Error',
                'No se encuentra el Código buscado.',
                'error'
            )
        }
    });
}

function agregar(x){
    
    var datosArray2 = window.datosGlobal;
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
    $('#codigoM').empty();
    $('#textoM').empty();
    $('#uFacturadas').empty();
    $('#textCodigoF').empty();

    $('#referencia').val("");
    $('#numLote').val("");
    $('#codigoF').val("");
    $('.datosConteo').val("");
 
    //Datos Zeta
    $('#codigoM').append(datosArray2[x].codZ);
    $('#textoM').append(datosArray2[x].desc);
    $('#referencia').val(datosArray2[x].refe);
    
    if (window.buscador == "codigo") {
        if (datosArray2[x].codF == "") {
            $('#codigoF').val(datosArray2[x].codZ);
            $("#codigoF").prop("disabled", true);
        }else if (datosArray2[x].codF == datosArray2[x].codZ) {
            $('#codigoF').val(datosArray2[x].codF);
            $("#codigoF").prop("disabled", true);
        }else if (datosArray2[x].codF != datosArray2[x].codZ){
            $('#codigoF').val(datosArray2[x].codF);
            $("#codigoF").prop("disabled", true);
        }
    }

    if (window.buscador == "referencia") {
        if (datosArray2[x].codF == "") {
            $('#textCodigoF').append("Ingrese nuevo código aquí.");
            $("#codigoF").prop("disabled", false);
        }else{
            $('#codigoF').val(datosArray2[x].codF);
            $("#codigoF").prop("disabled", true);
        }
    }

    if (window.buscador == "") {
        if (datosArray2[x].codF == "") {
            $('#textCodigoF').append("Ingrese nuevo código aquí.");
            $("#codigoF").prop("disabled", false);
        }else{
            $('#codigoF').val(datosArray2[x].codF);
            $("#codigoF").prop("disabled", true);
        }
    }

    //Conteo
    var canCaja = parseInt(datosArray2[x].caja);
    var unixcaja = parseInt(datosArray2[x].ucaj);
    var unisueltas = parseInt(datosArray2[x].suel);
    var totalConteo = Number((canCaja*unixcaja) + unisueltas);
    var totalF = parseInt(datosArray2[x].uniF);
    var ubicacion = datosArray2[x].ubic;
    console.log("total conteo: "+totalConteo);

    $('#ccajas').val(0);
    $('#uxcajas').val(0);
    $('#usueltas').val(0);
    $('#totalConteo').val(0);

    $('#numItem').val(datosArray2[x].item);
    $('#accajas').val(canCaja);
    $('#auxcajas').val(unixcaja);
    $('#ausueltas').val(unisueltas);
    $('#atotalConteo').val(totalConteo);
    $('#uFacturadas').val(totalF);

    

    if (ubicacion == "") {
        $('#ubiactual').val("Ninguna");
    }else{
        $('#ubiactual').val(ubicacion);
    }

    //Revision 
    faltantes = parseInt(datosArray2[x].falt);
    sobrantes = parseInt(datosArray2[x].sobr);
    malestado = parseInt(datosArray2[x].mala);
    lote = datosArray2[x].lote;
    
    $('#ufaltantes').val(0);
    $('#usobrantes').val(0);
    $('#malestado').val(0);

    $('#numLote').val(lote);
    $('#aufaltantes').val(faltantes);
    $('#ausobrantes').val(sobrantes);
    $('#amalestado').val(malestado);
    
    $('#idProducto').val(datosArray2[x].id);
    $('#codigoP').val(datosArray2[x].codZ);
    window.buscador = "";
    console.log("Cargar Datos Producto");
}

function actualizarConteo(){

    var codFisico = $('#codigoF').val();
    if(codFisico == ""){
        Swal.fire(
            'Problema!',
            'Ingrese un código físico para continuar.',
            'error'
        )
    }else{  

        var numItem = parseInt($('#numItem').val());
        var dcajas = Number(parseInt($('#ccajas').val()) + parseInt(window.datosGlobal[numItem].caja));

        if (parseInt($('#uxcajas').val()) == 0) {
            var duxcaja = parseInt(window.datosGlobal[numItem].ucaj);
        }else{
            var duxcaja = Number(parseInt($('#uxcajas').val()));
        }
        
        var dusueltas = Number(parseInt($('#usueltas').val()) + parseInt(window.datosGlobal[numItem].suel));
        var dufaltantes = Number(parseInt($('#ufaltantes').val()) + parseInt(window.datosGlobal[numItem].falt));
        var dsobrantes = Number(parseInt($('#usobrantes').val()) + parseInt(window.datosGlobal[numItem].sobr));
        var dmalas = Number(parseInt($('#malestado').val()) + parseInt(window.datosGlobal[numItem].mala));
        var idproducto = parseInt($('#idProducto').val());

       var codigoP = parseInt(codFisico);

        console.log("codigoP: "+codigoP);

        var numLote = $('#numLote').val();
        
        data = [];

        data.push({dcajas: dcajas});
        data.push({duxcaja: duxcaja});
        data.push({dusueltas: dusueltas});
        data.push({dufaltantes: dufaltantes});
        data.push({dsobrantes: dsobrantes});
        data.push({dmalas: dmalas});
        data.push({idproducto: idproducto});
        data.push({codigoP: codigoP});
        data.push({numLote: numLote});
        
        var totalConteo = Number((dcajas*duxcaja) + dusueltas);

        data.push({totalConteo: totalConteo});
        
        console.log(data);

        $.ajax({
            type: "POST",
            url: "modulos/ingresos/funciones.php",
            data: {data:data, controlador: "actualizarConteo"},
            success: function(datos) {
                console.log(datos);
                if(datos == 1){
                    buscarZeta();
                    var modal = document.getElementById("myModal");  
                    modal.style.display = "none";
                    Swal.fire(
                        'Bien',
                        'Registro actualizado',
                        'success'
                    )
                    recargarTabla();
                    $('#codigo').val("");
                    $('#codigo').focus();

                }
            }
        });
    }
}

function actualizarUbi(){

    var galUbi = $('#galUbi option:selected').val();
    var numUbi = $('#numUbi option:selected').val();
    var colUbi = $('#colUbi option:selected').val();
    var nivUbi = $('#nivUbi option:selected').val();
    var ubicacion = galUbi+numUbi+colUbi+nivUbi;

    var idproducto = parseInt($('#idProducto').val());

    data = [];

    data.push({ubicacion: ubicacion});
    data.push({idproducto: idproducto});

    $.ajax({
        type: "POST",
        url: "modulos/ingresos/funciones.php",
        data: {data:data, controlador: "actualizarUbicacion"},
        success: function(datos) {
            console.log(datos);
            if(datos == 1){
                buscarZeta();
                var modal = document.getElementById("myModal");  
                modal.style.display = "none";
                Swal.fire(
                    'Bien',
                    'Ubicación actualizada.',
                    'success'
                )
                recargarTabla();
                $('#codigo').val("");
                $('#codigo').focus();
            }
        }
    });
}

function limpiar(){
    var idproducto = parseInt($('#idProducto').val());
    $.ajax({
        type: "POST",
        url: "modulos/ingresos/funciones.php",
        data: {item:idproducto, controlador: "limpiar"},
        success: function(datos) {
            console.log(datos);
            if(datos == 1){
                var modal = document.getElementById("myModal");  
                modal.style.display = "none";
                Swal.fire(
                    'Bien',
                    'Se han dejado los contadores en 0.',
                    'success'
                )
                recargarTabla();
            }
        }
    });
}

function calculoConteo(){
    const varcajas = document.getElementById('ccajas');
    const varunixcaja = document.getElementById('uxcajas');
    const varsueltas = document.getElementById('usueltas');

    varcajas.addEventListener('input', (event) => {
        const nuevoValor = event.target.value;
        calculo();
    });

    varunixcaja.addEventListener('input', (event) => {
        const nuevoValor = event.target.value;
        calculo();
    });

    varsueltas.addEventListener('input', (event) => {
        const nuevoValor = event.target.value;
        calculo();
    });

}

function calculo(){
    var ccajas = parseInt($('#ccajas').val());
    var ucaja = parseInt($('#uxcajas').val());
    var usuel = parseInt($('#usueltas').val());

    var totalConteo = Number((ccajas*ucaja) + usuel);

    $('#totalConteo').val(totalConteo);
}

function recargarTabla(){
    $("#loader").show();
    data = [];
        
    var zeta = $('#zeta1').val();
    var anio = $('#anio').val();

    data.push({zet: zeta});
    data.push({ano: anio});
    
    $.ajax({
        type: "POST",
        url: "modulos/ingresos/funciones.php",
        dataType:"json",
        data: {data:data, controlador: "cargar"},
        success: function(datos) {
            if(datos === 'error4'){
                Swal.fire(
                    'Error',
                    'No se encuentra registro de Zeta.',
                    'error'
                )
            }else{
                $("#divBuscador").show();
                console.log(datos);
                console.log("recargando");
                window.datosGlobal = datos;
                $('#tabla').empty();
                
                html = `                          
                <div id="usual1"> 
                    <div id="tab1">
                        <table  id="ssptable2" class="lista" style="table-layout: auto;width: 100%; margin-top: 0px;">
                            <thead style="letter-spacing: 1px;">
                                    <tr>
                                        <th style="vertical-align: middle; text-align: center; width: 3%;">N°</th>        
                                        <th style="vertical-align: middle; text-align: center; width: 10%;">Código Zeta</th>
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
                            <tbody>`;

                for (let i = 0; i < datos.length; i++) {
                    
                    html += `
                        <tr>
                            <td>`+datos[i].item+`</td>
                            <td>`+datos[i].codZ+`</td>`;

                    if(datos[i].codF == ""){
                        html += `<td></td>`;
                    }else if(datos[i].codZ == datos[i].codF) {
                        html += `<td style="text-align: center;"><i class="fa-solid fa-check"></i></td>`;
                    }else if(datos[i].codZ != datos[i].codF){
                        html += `<td style="text-align: center;"><i class="fa-solid fa-not-equal"></i></td>`;
                    }
                            
                            
                    html += `<td>`+datos[i].desc+`</td>
                            <td>`+datos[i].uniF+`</td>
                            <td>`+datos[i].caja+`</td>
                            <td>`+datos[i].ucaj+`</td>
                            <td>`+datos[i].suel+`</td>
                            <td>`+datos[i].totl+`</td>
                            <td>`+datos[i].falt+`</td>
                            <td>`+datos[i].sobr+`</td>
                            <td>`+datos[i].mala+`</td>
                            <td>`+datos[i].lote+`</td>
                            <td>`+datos[i].ubic+`</td>
                            <td style="vertical-align: middle; text-align: center;">
                                <button type="button" onclick="agregar(`+i+`)" class="btn btn-warning">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </td>
                        </tr>`;
                }

                html += `</tbody></table></div></div>`;   
                $('#tabla').append(html);
                $("#loader").hide();
            }
        }
    });


}

function modal(){
    var modal = document.getElementById("myModal");   
    var span = document.getElementsByClassName("close")[0];

    //Botón para abrir modal
    // var btn = document.getElementById("myBtn");
    // btn.onclick = function() {
    //     modal.style.display = "block";
    // }

    //Cerrar modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    //Boton para agregar datos
    var btn2 = document.getElementById("btnAdd");
    btn2.onclick = function() {
        actualizarConteo();
    }

    //Botón para actualizar Ubicación
    var btn3 = document.getElementById("btnUpdate");
    btn3.onclick = function() {
        actualizarUbi();
    }

    //Botón para actualizar Ubicación
    var btn4 = document.getElementById("btnLimpiar");
    btn4.onclick = function() {
        limpiar();
    }

    //Botón para salir del modal
    var btn5 = document.getElementById("btnSalir");
    btn5.onclick = function() {
        modal.style.display = "none";
    }

    //Botón para ingresar a modal2 buscar por referencia
    var modal2 = document.getElementById("myModal2"); 
    var btn6 = document.getElementById("btnSinCod");
    btn6.onclick = function() {
        console.log("hola");
        modal2.style.display = "block";
    }

    //Botón para salir del modal2
    var btn7 = document.getElementById("btnSalir2");
    btn7.onclick = function() {
        modal2.style.display = "none";
    }
    //Restringe que se ingresen letras en los input numéricos.
    $('.datosConteo').keypress(function(event) {
        console.log("keypress");
        // Permitir solo números
        if(event.which < 48 || event.which > 57) {
          event.preventDefault();
        }
    
        // Verificar que el número sea mayor que cero
        var currentValue = $(this).val();
        if(currentValue < 0){
            $(this).val(0);
        }
    });
}

$(document).ready(function(){
    $("#divBuscador").hide();
    $("#loader").hide();
    buscarZeta();
    buscarCodigo();
    buscarReferencia();
    modal();
    calculoConteo();

    $('#zeta1').focus();

    $( document ).tooltip();
    $("#btnExport").click(function(){
        console.log("exportando");
        $("#ssptable2").btechco_excelexport({
            containerid: "ssptable2",
            datatype: $datatype.Table,
            worksheetName: "Mi Hoja de Cálculo"
        });
    });
    

});

