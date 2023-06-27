window.datosGlobal = [];
window.buscador = "";
window.nombreTabla;

function buscarZeta(){
    $("#formZeta").on('submit', function(e){

        data = [];
        //Recupera el año y numero del zeta
        var zeta = $('#zeta1').val();
        var anio = $('#anio').val();

        nombreExport(anio,zeta)
        
        data.push({zet: zeta});
        data.push({ano: anio});

        $("#loader").show();
        //Envía los datos a través de un array
        $.ajax({
            type: "POST",
            url: "modulos/ingresos/funciones.php",
            data: {data:data, controlador: "buscar"},
            success: function(e) {
                console.log(e);
                res = e.toString();
                //Si encuentra el Zeta solicita cargar los datos de la tabla ingreso_mercaderia
                if(res === 'ok'){
                    
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
                                //Muestra modal
                                $("#divBuscador").show();
                                console.log(datos);
                                //Carga los datos en una variable global para usarla en otras funciones.
                                window.datosGlobal = datos;
                                //Limpiar tabla
                                $("#ssptable2 tr").find("td").each(function() {
                                    $(this).remove();
                                });
                                html = "";
                                //Cargar datos en tabla.
                                for (let i = 0; i < datos.length; i++) {
                                    
                                    html += `
                                        <tr>
                                            <td>`+datos[i].item+`</td>
                                            <td class="tableexport-string">`+datos[i].codZ+`</td>`;

                                    if(datos[i].codF == ""){
                                        html += `<td style="display: none;"></td><td></td>`;
                                    }else if(datos[i].codZ == datos[i].codF) {
                                        html += `<td style="display: none;">`+datos[i].codF+`</td>
                                                <td style="text-align: center;"><i class="fa-solid fa-check"></i></td>`;
                                    }else if(datos[i].codZ != datos[i].codF){
                                        html += `<td style="display: none;">`+datos[i].codF+`</td>
                                                <td style="text-align: center;"><i class="fa-solid fa-not-equal"></i></td>`;
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
                                $("#ssptable2 tr:last").after(html);
                                //Ocultar el loading.
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
    //Buscar código ingresado
    $("#buscarCodigo").on('submit', function(e){
        e.preventDefault();
        var codigo = $('#codigo').val();
        datosArray = window.datosGlobal;
        codigoFound = "no";
        $("#loader").show();
        //Busca el código en los datos traídos anteriormente al cargar la tabla.
        for (let x = 0; x < datosArray.length; x++) {
            codArray = datosArray[x].codZ;
            
            if(codigo == codArray) {
                $("#loader").hide();
                codigoFound = "si";
                window.buscador = "codigo";
                //Inicia la función agregar con la posición del array;
                agregar(x);
                break;
            }
        }

        if (codigoFound == "no") {
            $("#loader").hide();
            Swal.fire(
                'Error',
                'No se encuentra el Código en este Zeta.',
                'error'
            )
        }        
    });
}

function buscarReferencia(){
    //Permite buscar un producto por el número de referencia.
    $("#buscarReferencia").on('submit', function(e){
        e.preventDefault();
        var codigo = $('#codigoRef').val();
        datosArray = window.datosGlobal;
        var codigoFound = "no";
        $("#loader").show();
        for (let x = 0; x < datosArray.length; x++) {
            codReferencia = datosArray[x].refe;
            //Busca el codigo de referencia en el array de datos obtenido previamente.
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
    //Abre el modal para editar datos del ingreso de mercadería.
    var datosArray2 = window.datosGlobal;
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
    //Limpiar los campos donde se ingresa información.
    $('#codigoM').empty();
    $('#textoM').empty();
    $('#uFacturadas').empty();
    $('#textCodigoF').empty();

    $('#referencia').val("");
    $('#numLote').val("");
    $('#codigoF').val("");
    $('.datosConteo').val("");
 
    //Cargar datos del Zeta
    $('#codigoM').append(datosArray2[x].codZ);
    $('#textoM').append(datosArray2[x].desc);
    $('#referencia').val(datosArray2[x].refe);
    //Si existe código físico lo trae y deshabilita el campo, sino queda el campo abierto para ingresarlo.
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

    //Si no existe numero de referencia deja el campo abierto, sino lo carga desde base de datos.
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

    //Extraer sumatorias de conteos anteriores.
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
    //Mostrar datos en el modal en la sección de Conteo.
    $('#numItem').val(datosArray2[x].item);
    $('#accajas').val(canCaja);
    $('#auxcajas').val(unixcaja);
    $('#ausueltas').val(unisueltas);
    $('#atotalConteo').val(totalConteo);
    $('#uFacturadas').val(totalF);

    
    //Mostrar ubicación física del ítem en bodega.
    if (ubicacion == "") {
        $('#ubiactual').val("Ninguna");
    }else{
        $('#ubiactual').val(ubicacion);
    }

    //Mostrar datos en el modal en la sección de Revision.
    faltantes = parseInt(datosArray2[x].falt);
    sobrantes = parseInt(datosArray2[x].sobr);
    malestado = parseInt(datosArray2[x].mala);
    lote = datosArray2[x].lote;
    
    $('#ufaltantes').val(0);
    $('#usobrantes').val(0);
    $('#malestado').val(0);

    //Cargar datos en modal.
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
    //Actualiza los datos del formulario.
    var codFisico = $('#codigoF').val();
    if(codFisico == ""){
        Swal.fire(
            'Problema!',
            'Ingrese un código físico para continuar.',
            'error'
        )
    }else{  
        //Trae los datos del modal para sumarlos con los datos anteriores.
        var numItem = parseInt($('#numItem').val());
        var dcajas = Number(parseInt($('#ccajas').val()) + parseInt(window.datosGlobal[numItem-1].caja));

        if (parseInt($('#uxcajas').val()) == 0) {
            var duxcaja = parseInt(window.datosGlobal[numItem-1].ucaj);
        }else{
            var duxcaja = Number(parseInt($('#uxcajas').val()));
        }
        
        var dusueltas = Number(parseInt($('#usueltas').val()) + parseInt(window.datosGlobal[numItem-1].suel));
        var dufaltantes = Number(parseInt($('#ufaltantes').val()) + parseInt(window.datosGlobal[numItem-1].falt));
        var dsobrantes = Number(parseInt($('#usobrantes').val()) + parseInt(window.datosGlobal[numItem-1].sobr));
        var dmalas = Number(parseInt($('#malestado').val()) + parseInt(window.datosGlobal[numItem-1].mala));
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
        //Enviar los datos a actualizar a la base de datos.
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
    //Funcion para actualizar la ubicación de un ítem.
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
    //Elimina todos los registros de un ítem.
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
    //Detecta si ingresan datos en algún campo de conteo para llamar a la función calculo()
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
    //Realiza el cálculo del total en tiempo real. 
    var ccajas = parseInt($('#ccajas').val());
    var ucaja = parseInt($('#uxcajas').val());
    var usuel = parseInt($('#usueltas').val());

    var totalConteo = Number((ccajas*ucaja) + usuel);

    $('#totalConteo').val(totalConteo);
}

function recargarTabla(){
    //Realiza la función de solo recargar de datos actualizados la tabla.
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
                //$('#ssptable2 tr').remove();
                $("#ssptable2 tr").find("td").each(function() {
                    $(this).remove();
                });
                html = "";
                for (let i = 0; i < datos.length; i++) {
                    
                    html += `
                        <tr>
                            <td>`+datos[i].item+`</td>
                            <td>`+datos[i].codZ+`</td>`;

                    if(datos[i].codF == ""){
                        html += `<td style="display: none;"></td><td></td>`;
                    }else if(datos[i].codZ == datos[i].codF) {
                        html += `<td style="display: none;">`+datos[i].codF+`</td>
                                <td style="text-align: center;"><i class="fa-solid fa-check"></i></td>`;
                    }else if(datos[i].codZ != datos[i].codF){
                        html += `<td style="display: none;">`+datos[i].codF+`</td>
                                <td style="text-align: center;"><i class="fa-solid fa-not-equal"></i></td>`;
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
                $("#ssptable2 tr:last").after(html);
                
                $("#loader").hide();
                
            }
        }
    });


}

function modal(){
    //Abre y configura el modal para mejor visualización.
    var modal = document.getElementById("myModal");   
    var span = document.getElementsByClassName("close")[0];

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

function nombreExport(a,b){
    //Da formato a las fechas.
    var d = new Date(); var month = d.getMonth()+1; var day = d.getDate();
    var fecha = (day<10 ? '0' : '') + day + '.' + (month<10 ? '0' : '') + month + '.' + d.getFullYear();

    window.nombreTabla = "RepoIngreso Z"+a+"-"+b+" "+fecha;

}

$(document).ready(function(){
    //Esconde las secciones
    $("#divBuscador").hide();
    $("#loader").hide();

    //Carga las funciones
    buscarZeta();
    buscarCodigo();
    buscarReferencia();
    modal();
    calculoConteo();

    $('#zeta1').focus();

    $( document ).tooltip();

    if(tipoUsuario == 1){
        
        //Muestra el botón limpiar
        $("#divLimpiar").show();
        $("#divUbicacion").hide();
        //$("#divUbicacion").show();
    }else{
        $("#divLimpiar").hide();
        $("#divUbicacion").hide();
    }
    //Botón para exportar excel.
    $("#descargarExcel").click(function(){
        $('#ssptable2').tableExport({
            type: 'excel',
            ignoreColumn: [3,15],
            bootstrap: true,
            fileName: window.nombreTabla,
            mso: {
                fileFormat: 'xlsx',
                xlsx: {
                    formatId: {         
                        numbers: 1
                    }
                }
            }
        });
    });

});

