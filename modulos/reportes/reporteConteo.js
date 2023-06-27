function cargarZeta(){
    $("#formZeta").on('submit', function(e){
        e.preventDefault();
        data = [];
        
        var zeta = $('#zeta1').val();
        var anio = $('#anio').val();

        data.push({zet: zeta});
        data.push({ano: anio});

        $("#loader").show();

        $.ajax({
            type: "POST",
            url: "modulos/ingresos/funciones.php",
            dataType:"json",
            data: {data:data, controlador: "cargar"},
            success: function(datos) {
                
                if(datos === 'error'){
                    Swal.fire(
                        'Error',
                        'No se encuentra registro de Zeta.',
                        'error'
                    )
                }else{
                    console.log(datos);
                    
                    sinrevisar = [];
                    otrocodigo = [];
                    faltantes = [];
                    sobrantes = [];
                    malos = [];
                    
                    for (let i = 0; i < datos.length; i++) {

                        if (datos[i].codZ != datos[i].codF) {
                            if (datos[i].codF == '') {
                                sinrevisar.push(datos[i]);
                            }else{
                                otrocodigo.push(datos[i]);
                            }
                        }
                        
                        if (datos[i].falt > 0) {
                            faltantes.push(datos[i]);
                        }

                        if (datos[i].sobr > 0) {
                            sobrantes.push(datos[i]);
                        }
                        
                        if (datos[i].mala > 0) {
                            malos.push(datos[i]);
                        }
                    }
                    
                    //Limpiar divs
                    $("#g1").empty();
                    $('#codFisico').empty();
                    $('#codFaltantes').empty();
                    $('#codSobrantes').empty();
                    $('#codMalos').empty();

                    //Setear información obtenida
                    contados = datos.length - sinrevisar.length;
                    
                    var g1 = new JustGage({
                        id: "g1", 
                        value: contados,
                        min: 0,
                        max: datos.length,
                        title: "Mercadería Ingresada",
                        label: "Revisados"
                    });

                    //CODIGO FISICO DISTINTO
                    if (otrocodigo.length > 0) {
                        html1 = `<div id="html1">
                                    <h4 center> Tabla de productos con código distinto. </h4>
                                    <table id="tabla1" class="tabla" style="table-layout: auto;width: 100%; margin-top: 0px;">
                                        <thead style="letter-spacing: 1px;">
                                                <tr>
                                                    <th style="vertical-align: middle; text-align: center; width: ;">Item</th>        
                                                    <th style="vertical-align: middle; text-align: center; width: ;">Código Zeta</th>
                                                    <th style="vertical-align: middle; text-align: center; width: ;">Código Físico</th>
                                                    <th style="vertical-align: middle; text-align: center; width: ;">Descripcion</th>
                                                    <th class="rotar" style="vertical-align: middle;  width: ;"> Unidades Facturadas</th>
                                                    <th class="rotar" style="vertical-align: middle; width: ;">Total</th>
                                                    <th class="rotar"style="vertical-align: middle; text-align: center; width: ">Lote</th>
                                                    <th class="rotar"style="vertical-align: middle; text-align: center; width: ">Ubicación</th>
                                                </tr>
                                        </thead>
                                        <tbody>`;
                        for (let i = 0; i < otrocodigo.length; i++) {
                
                            html1 += `
                                <tr>
                                    <td>`+otrocodigo[i].item+`</td>
                                    <td>`+otrocodigo[i].codZ+`</td>
                                    <td>`+otrocodigo[i].codF+`</td>
                                    <td>`+otrocodigo[i].desc+`</td>
                                    <td>`+otrocodigo[i].uniF+`</td>
                                    <td>`+otrocodigo[i].totl+`</td>
                                    <td>`+otrocodigo[i].lote+`</td>
                                    <td>`+otrocodigo[i].ubic+`</td>
                                    </td>
                                </tr>`;
                        }
                        html1 += `</tbody></table></div></br>`;   
                        $('#codFisico').append(html1);
                        
                        $('#tabla1').DataTable({
                            paging: false,
                            dom: 'Bfrtip',
                            searching: false,
                            ordering:  false,
                            info: false,
                            buttons: [
                                'excel', 'pdf'
                            ]
                        });
                    }

                    //FALTANTES
                    if (faltantes.length > 0) {
                        html2 = `<div id="html2">
                                        <h4 center> Tabla de productos faltantes. </h4>
                                        <table id="tabla2" class="tabla" style="table-layout: auto;width: 100%; margin-top: 0px;">
                                            <thead style="letter-spacing: 1px;">
                                                <tr>
                                                    <th style="vertical-align: middle; text-align: center; width: ;">Item</th>        
                                                    <th style="vertical-align: middle; text-align: center; width: ;">Código Zeta</th>
                                                    <th style="vertical-align: middle; text-align: center; width: ;">Descripcion</th>
                                                    <th class="rotar" style="vertical-align: middle;  width: ;"> Unidades Facturadas</th>
                                                    <th class="rotar" style="vertical-align: middle; width: ;">Faltantes</th>
                                                    <th class="rotar" style="vertical-align: middle; width: ;">Total</th>
                                                    <th class="rotar"style="vertical-align: middle; text-align: center; width: ">Lote</th>
                                                    <th class="rotar"style="vertical-align: middle; text-align: center; width: ">Ubicación</th>
                                                </tr>
                                            </thead>
                                        <tbody>`;
                        for (let i = 0; i < faltantes.length; i++) {
                
                            html2 += `
                                <tr>
                                    <td>`+faltantes[i].item+`</td>
                                    <td>`+faltantes[i].codZ+`</td>
                                    <td>`+faltantes[i].desc+`</td>
                                    <td>`+faltantes[i].uniF+`</td>
                                    <td>`+faltantes[i].falt+`</td>
                                    <td>`+faltantes[i].totl+`</td>
                                    <td>`+faltantes[i].lote+`</td>
                                    <td>`+faltantes[i].ubic+`</td>
                                </tr>`;
                        }
                        html2 += `</tbody></table></div></br>`;   
                        $('#codFaltantes').append(html2);
                        //var table = $('#').DataTable();
                        $('#tabla2').DataTable({
                            paging: false,
                            dom: 'Bfrtip',
                            searching: false,
                            ordering:  false,
                            info: false,
                            buttons: [
                                'copy', 'excel', 'pdf'
                            ]
                        });
                    }

                    // SOBRANTES
                    if (sobrantes.length > 0) {
                        html3 = `<div id="html3"> 
                                        <h4 center> Tabla de productos sobrantes. </h4>
                                        <table id="tabla3" class="tabla" style="table-layout: auto;width: 100%; margin-top: 0px;">
                                            <thead style="letter-spacing: 1px;">
                                                <tr>
                                                    <th style="vertical-align: middle; text-align: center; width: ;">Item</th>        
                                                    <th style="vertical-align: middle; text-align: center; width: ;">Código Zeta</th>
                                                    <th style="vertical-align: middle; text-align: center; width: ;">Descripcion</th>
                                                    <th class="rotar" style="vertical-align: middle;  width: ;"> Unidades Facturadas</th>
                                                    <th class="rotar" style="vertical-align: middle; width: ;">Sobrantes</th>
                                                    <th class="rotar" style="vertical-align: middle; width: ;">Total</th>
                                                    <th class="rotar"style="vertical-align: middle; text-align: center; width: ">Lote</th>
                                                    <th class="rotar"style="vertical-align: middle; text-align: center; width: ">Ubicación</th>
                                                </tr>
                                            </thead>
                                        <tbody>`;
                        for (let i = 0; i < sobrantes.length; i++) {
                
                            html3 += `
                                <tr>
                                    <td>`+sobrantes[i].item+`</td>
                                    <td>`+sobrantes[i].codZ+`</td>
                                    <td>`+sobrantes[i].desc+`</td>
                                    <td>`+sobrantes[i].uniF+`</td>
                                    <td>`+sobrantes[i].sobr+`</td>
                                    <td>`+sobrantes[i].totl+`</td>
                                    <td>`+sobrantes[i].lote+`</td>
                                    <td>`+sobrantes[i].ubic+`</td>
                                </tr>`;
                        }
                        html3 += `</tbody></table></div>`;   
                        $('#codSobrantes').append(html3);
                        //var table = $('#tabla3').DataTable();
                        $('#tabla3').DataTable({
                            paging: false,
                            dom: 'Bfrtip',
                            searching: false,
                            ordering:  false,
                            info: false,
                            buttons: [
                                'copy', 'excel', 'pdf'
                            ]
                        });
                    }

                    //MALOS
                    if (malos.length > 0) {
                        html4 = `<div id="html4"> 
                                        <h4 center> Tabla de productos malos. </h4>
                                        <table id="tabla4" class="tabla" style="table-layout: auto;width: 100%; margin-top: 0px;">
                                            <thead style="letter-spacing: 1px;">
                                                <tr>
                                                    <th style="vertical-align: middle; text-align: center; width: ;">Item</th>        
                                                    <th style="vertical-align: middle; text-align: center; width: ;">Código Zeta</th>
                                                    <th style="vertical-align: middle; text-align: center; width: ;">Descripcion</th>
                                                    <th class="rotar" style="vertical-align: middle;  width: ;">Unidades Facturadas</th>
                                                    <th class="rotar" style="vertical-align: middle; width: ;">Malos</th>
                                                    <th class="rotar" style="vertical-align: middle; width: ;">Total</th>
                                                    <th class="rotar"style="vertical-align: middle; text-align: center; width: ">Lote</th>
                                                    <th class="rotar"style="vertical-align: middle; text-align: center; width: ">Ubicación</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
                        for (let i = 0; i < malos.length; i++) {
                
                            html4 += `
                                <tr>
                                    <td>`+malos[i].item+`</td>
                                    <td>`+malos[i].codZ+`</td>
                                    <td>`+malos[i].desc+`</td>
                                    <td>`+malos[i].uniF+`</td>
                                    <td>`+malos[i].sobr+`</td>
                                    <td>`+malos[i].totl+`</td>
                                    <td>`+malos[i].lote+`</td>
                                    <td>`+malos[i].ubic+`</td>
                                </tr>`;
                        }
                        html4 += `</tbody></table></div></br>`;   
                        $('#codMalos').append(html4);
                        //var table = $('#tabla4').DataTable();
                        $('#tabla4').DataTable({
                            buttons: [
                                'copy', 'excel', 'pdf'
                            ]
                        });
                    }

                    $('#izeta').empty();
                    $('#iingre').empty();
                    $('#ifisic').empty();

                    $('#izeta').append(datos.length);
                    $('#iingre').append(contados);
                    $('#ifisic').append(otrocodigo.length);

                }
                
                $("#loader").hide();
            }
        });
        
        
    });
}


$(document).ready(function(){
    
    $("#loader").hide();
    $('#zeta1').focus();
    $( document ).tooltip();
    
    cargarZeta();
    ("#descargarExcel").click(function(){
        $("#tabla1").btechco_excelexport({
            containerid: "tabla1"
           , datatype: $datatype.Table
        });
        window.location.reload();
    });
});

