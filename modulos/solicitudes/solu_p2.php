<?php

if (session_status() === PHP_SESSION_NONE) session_start();

require_once("clases/conexion_pdo.php"); // Usamos la nueva conexión PDO
ini_set('max_execution_time', 600);


$idsol = $_GET['idsol'] ?? null;
$bmarca = $_GET['marca'] ?? null;
$buscar_texto = trim($_GET['buscar_texto'] ?? '');

// Leemos el filtro. Por defecto, será 'regular' (QryGroup1 = 'Y')
$filtro_tipo = $_GET['filtro_tipo'] ?? 'regular';

// --- ¡NUEVO! --- Variables de Paginación ---
$por_pagina = 200; // ¿Cuántos productos mostrar por página?
$pagina_actual = (int)($_GET['pagina'] ?? 1); // Obtiene la pág. de la URL, o 1 por defecto

// -- ¡CAMBIO! -- Calculamos el rango de filas
$inicio_fila = ($pagina_actual - 1) * $por_pagina + 1;
$fin_fila = $pagina_actual * $por_pagina;

// --- Fin de Variables de Paginación ---

// Variables para la plantilla
$estado = null;
$productos_marca = [];
$detalles_solicitud = [];

// Si no hay id de solicitud, no podemos hacer nada
if (!$idsol) {
    die("Error: No se proporcionó un ID de solicitud.");
}

// --- 2. VERIFICACIÓN DE ESTADO DE LA SOLICITUD ---

try {
    // Usamos PREPARED STATEMENTS para evitar Inyección SQL
    $sql_estado = "SELECT estado FROM dbo.sisap_solicitudes WHERE solicitud_id = ?";
    $stmt_estado = $conn->prepare($sql_estado);
    $stmt_estado->execute([$idsol]);
    $resultado = $stmt_estado->fetch(PDO::FETCH_ASSOC); // Obtenemos solo una fila

    if ($resultado) {
        $estado = $resultado["estado"];
    }

    // Redirección limpia con PHP si el estado no es 0
    if ($estado != 0) {
        header('Location: index.php?opc=nuevaSolicitud');
        exit; // Detenemos la ejecución del script
    }

    // --- 3. OBTENER PRODUCTOS POR MARCA (SI APLICA) ---
    // Esto es para el diálogo modal
    if ($bmarca) {
        
        $conAcce = "";
        $filtro_sql = ""; // Esta variable reemplaza a $Wcosto

        switch ($filtro_tipo) {
            case 'regular':
                // Opción 1: ProductoRegular
                $filtro_sql = " AND (dbo.oITM_From_SBO.QryGroup1 = 'Y')";
                break;
            case 'sinvalor':
                // Opción 2: SinValorComercial
                $filtro_sql = " AND (dbo.oITM_From_SBO.QryGroup2 = 'Y')";
                break;
            case 'todos':
                // Opción 3: TodosLosArticulos (no se añade ningún filtro)
                $filtro_sql = "";
                break;
        }

        if ($_SESSION["usuario_modulo"] != 7) {
            $conAcce = " AND (dbo.oITM_From_SBO.ItmsGrpCod <> 104)";
        }


        $sql_marca = "
        WITH ProductosPaginados AS (
            SELECT
                dbo.oITM_From_SBO.ItemCode,
                dbo.oITM_From_SBO.ItemName,
                OMAR.Name,
                TABLA.Cantidad,
                oITM_From_SBO.QryGroup1,
                oITM_From_SBO.QryGroup2,
                ROW_NUMBER() OVER (ORDER BY dbo.oITM_From_SBO.ItemName) AS rn,
                COUNT(*) OVER () AS TotalRows
            FROM dbo.oITM_From_SBO WITH (NOLOCK)
            LEFT JOIN (
                SELECT Alu, Cantidad
                FROM dbo.VerStockTiendas WITH (NOLOCK)
                WHERE Bodega = ?
            ) AS TABLA ON dbo.oITM_From_SBO.ItemCode = TABLA.Alu COLLATE SQL_Latin1_General_CP850_CI_AS
            LEFT JOIN [SAPSQL.DHN.CL].[SBO_Imp_Eximben_SAC].[dbo].[@VK_OMAR] AS OMAR ON OMAR.Code = dbo.oITM_From_SBO.U_VK_Marca
            WHERE
                OMAR.Name = ?
                AND dbo.oITM_From_SBO.ItmsGrpCod NOT IN (103, 100, 106, 107)
                AND dbo.oITM_From_SBO.frozenFor <> 'Y'
                AND oITM_From_SBO.QryGroup3 <> 'Y'
                " . $conAcce . "
                " . $filtro_sql . "
        )
        SELECT ItemCode, ItemName, Name, Cantidad, QryGroup1, QryGroup2, TotalRows
        FROM ProductosPaginados
        WHERE rn BETWEEN ? AND ?
        ORDER BY ItemName";

                      


        
        // 1. Tomamos la bodega: "2"
        $bodega_original = $_SESSION["usuario_modulo"];
        
        // 2. La formateamos a 3 dígitos con ceros a la izquierda: "002"
        $bodega_formateada = str_pad($bodega_original, 3, "0", STR_PAD_LEFT);
        
        // 3. Ejecutamos la consulta con el string "002"
        $stmt_marca = $conn->prepare($sql_marca);
        $stmt_marca->execute([$bodega_formateada, $bmarca, $inicio_fila, $fin_fila]);
        
        // Obtenemos TODOS los resultados en un array
        $productos_marca = $stmt_marca->fetchAll(PDO::FETCH_ASSOC);

        $total_productos = !empty($productos_marca) ? (int)$productos_marca[0]['TotalRows'] : 0;
        $total_paginas = ($total_productos > 0) ? ceil($total_productos / $por_pagina) : 0;

    } elseif ($buscar_texto) {

        $conAcce = "";
        $filtro_sql = "";
        switch ($filtro_tipo) {
            case 'regular':  $filtro_sql = " AND (dbo.oITM_From_SBO.QryGroup1 = 'Y')"; break;
            case 'sinvalor': $filtro_sql = " AND (dbo.oITM_From_SBO.QryGroup2 = 'Y')"; break;
        }
        if ($_SESSION["usuario_modulo"] != 7) {
            $conAcce = " AND (dbo.oITM_From_SBO.ItmsGrpCod <> 104)";
        }

        $bodega_formateada = str_pad($_SESSION["usuario_modulo"], 3, "0", STR_PAD_LEFT);
        $param_texto = '%' . $buscar_texto . '%';

        $sql_marca = "
        WITH ProductosPaginados AS (
            SELECT
                dbo.oITM_From_SBO.ItemCode,
                dbo.oITM_From_SBO.ItemName,
                OMAR.Name,
                TABLA.Cantidad,
                oITM_From_SBO.QryGroup1,
                oITM_From_SBO.QryGroup2,
                ROW_NUMBER() OVER (ORDER BY dbo.oITM_From_SBO.ItemName) AS rn,
                COUNT(*) OVER () AS TotalRows
            FROM dbo.oITM_From_SBO WITH (NOLOCK)
            LEFT JOIN (
                SELECT Alu, Cantidad
                FROM dbo.VerStockTiendas WITH (NOLOCK)
                WHERE Bodega = ?
            ) AS TABLA ON dbo.oITM_From_SBO.ItemCode = TABLA.Alu COLLATE SQL_Latin1_General_CP850_CI_AS
            LEFT JOIN [SAPSQL.DHN.CL].[SBO_Imp_Eximben_SAC].[dbo].[@VK_OMAR] AS OMAR ON OMAR.Code = dbo.oITM_From_SBO.U_VK_Marca
            WHERE
                (dbo.oITM_From_SBO.ItemCode LIKE ? OR dbo.oITM_From_SBO.ItemName LIKE ?)
                AND dbo.oITM_From_SBO.ItmsGrpCod NOT IN (103, 100, 106, 107)
                AND dbo.oITM_From_SBO.frozenFor <> 'Y'
                AND oITM_From_SBO.QryGroup3 <> 'Y'
                " . $conAcce . "
                " . $filtro_sql . "
        )
        SELECT ItemCode, ItemName, Name, Cantidad, QryGroup1, QryGroup2, TotalRows
        FROM ProductosPaginados
        WHERE rn BETWEEN ? AND ?
        ORDER BY ItemName";

        $stmt_marca = $conn->prepare($sql_marca);
        $stmt_marca->execute([$bodega_formateada, $param_texto, $param_texto, $inicio_fila, $fin_fila]);
        $productos_marca = $stmt_marca->fetchAll(PDO::FETCH_ASSOC);

        $total_productos = !empty($productos_marca) ? (int)$productos_marca[0]['TotalRows'] : 0;
        $total_paginas = ($total_productos > 0) ? ceil($total_productos / $por_pagina) : 0;
    }

    // --- 4. OBTENER DETALLES DE LA SOLICITUD ACTUAL ---
    // Esto es para la tabla principal
    
    $sql_detalles = "SELECT
                        dbo.sisap_solicitudes.solicitud_id,
                        dbo.sisap_soldetalle.solicitud_id AS detid,
                        dbo.sisap_soldetalle.marca AS Marca,
                        dbo.sisap_soldetalle.codigo,
                        dbo.sisap_soldetalle.descripcion,
                        dbo.sisap_soldetalle.stock_modulo,
                        dbo.sisap_soldetalle.cant_solicitada,
                        dbo.sisap_soldetalle.cant_aceptada,
                        dbo.sisap_soldetalle.detalle_id
                     FROM dbo.sisap_solicitudes
                     LEFT OUTER JOIN dbo.sisap_soldetalle ON dbo.sisap_solicitudes.solicitud_id = dbo.sisap_soldetalle.solicitud_id
                     WHERE dbo.sisap_solicitudes.solicitud_id = ?
                     ORDER BY dbo.sisap_soldetalle.marca, dbo.sisap_soldetalle.detalle_id";
    
    $stmt_detalles = $conn->prepare($sql_detalles);
    $stmt_detalles->execute([$idsol]);
    $detalles_solicitud = $stmt_detalles->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Manejo de errores de consulta
    die("Error en la consulta SQL: " . $e->getMessage());
}

// Cerramos la conexión (PDO lo hace automáticamente, pero es buena práctica setear a null)
$conn = null;

// --- 5. PASAMOS VARIABLES A JAVASCRIPT DE FORMA SEGURA ---
// Esto reemplaza el "echo" de PHP dentro de <script>
$config_js = [
    'shouldOpenDialog' => (bool)$bmarca || (bool)$buscar_texto,
    'idsol' => $idsol
];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Solicitud</title>

    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css" />
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <style>
        #loadscreen {
            background: url(images/bg.png) repeat;
            height: 1050px;
            width: 100%;
            left: 0;
            top: 0;
            position: fixed;
            text-align: center;
            z-index: 2000;
            display: none; /* Oculto por defecto */
        }
        #loadscreen img {
            position: absolute;
            top: 40%;
            left: 46%;
            margin: -50px 0px 0px -50px;
        }
        input.text { margin-bottom: 0px; width: 20%; padding: .4em; }
        fieldset { padding: 0; border: 0; margin-top: 25px; }
        /* ... (otros estilos) ... */
        /* --- NUEVO: Estilos para la paginación --- */
        .paginacion {
            text-align: center;
            padding-top: 15px; /* Espacio entre la tabla y la paginación */
        }

        .paginacion a, .paginacion strong {
            /* Esto los pone en fila */
            display: inline-block; 
            
            padding: 5px 10px;
            margin: 0 2px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #0073e6;
            border-radius: 4px;
        }

        /* Estilo para la página actual */
        .paginacion strong {
            background-color: #0073e6;
            color: #fff;
            border-color: #0073e6;
        }

        .paginacion a:hover {
            background-color: #f4f4f4;
        }

        #dialog-form #contenido {
            height: 400px; /* <-- Le damos una altura fija al contenedor de la tabla */
            overflow-y: auto; /* <-- ¡La magia! Añade scroll SÓLO a este div */
            border: 1px solid #ccc; /* Opcional: para enmarcar la tabla */
            margin-bottom: 10px; /* Espacio antes de la paginación */
        }
    </style>
</head>
<body>

    <div id="loadscreen">
        <img title="Maxcode" alt="Maxcode" src="images/loader.gif">
    </div>
 
    <div id="dialog-form" title="Agregar a la Lista de Solicitud">
        <form id="addproductoform">
            <fieldset>
                <div id="contenido">
                    <?php if (($bmarca || $buscar_texto) && count($productos_marca) > 0): ?>
                        <table id="table-6" class="lista">
                            <thead>
                                <tr>
                                    <th>código</th>
                                    <th>descripción</th>
                                    <th>stock tienda</th>
                                    <th>reposición</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody id="tablebody">
                                <?php foreach ($productos_marca as $producto): ?>
                                    <?php 
                                        // 1. Limpieza y Preparación de Datos
                                        $itemCode = htmlspecialchars($producto["ItemCode"], ENT_QUOTES, 'UTF-8');
                                        $itemName = htmlspecialchars(utf8_safe($producto["ItemName"]), ENT_QUOTES, 'UTF-8');
                                        $cantidad = (int)$producto["Cantidad"];
                                        $style = ($producto["QryGroup2"] == 'Y') ? 'style="color:#D55C00;"' : '';
                                        

                                    ?>
                                    
                                    <tr <?php echo $style; ?>>
                                        <td><strong><?php echo $itemCode; ?></strong></td>
                                        
                                        <td><?php echo $itemName; ?></td>
                                        
                                        <td><?php echo $cantidad; ?></td>
                                        
                                        <td>
                                            <input type="text" name="name" id="cantsol" class="text ui-widget-content ui-corner-all" maxlength="3" value="0" />
                                        </td>
                                        
                                        <td>
                                            <a class="anade_lista" id="<?php echo $itemCode; ?>"><img src="images/agg.png" /></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        
                    <?php elseif ($bmarca || $buscar_texto): ?>
                        <p class="validateTips">No se encontraron Registros</p>
                    <?php endif; ?>
                </div>
                <div class="paginacion" style="padding: 10px; text-align: center;">
                    <?php if ($total_paginas > 1): ?>
                        <?php 
                            // Mantiene los filtros actuales (marca, costo, etc.)
                            $query_params = $_GET;
                        ?>

                        <?php if ($pagina_actual > 1): ?>
                            <?php $query_params['pagina'] = $pagina_actual - 1; ?>
                            <a href="index.php?<?php echo http_build_query($query_params); ?>">&laquo; Anterior</a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                            <?php $query_params['pagina'] = $i; ?>
                            <?php if ($i == $pagina_actual): ?>
                                <strong style="color: #000; margin: 0 5px;"><?php echo $i; ?></strong>
                            <?php else: ?>
                                <a href="index.php?<?php echo http_build_query($query_params); ?>" style="margin: 0 5px;"><?php echo $i; ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($pagina_actual < $total_paginas): ?>
                            <?php $query_params['pagina'] = $pagina_actual + 1; ?>
                            <a href="index.php?<?php echo http_build_query($query_params); ?>">Siguiente &raquo;</a>
                        <?php endif; ?>

                    <?php endif; ?>
                </div>
            </fieldset>
        </form>
    </div>
    <form id="horizontalForm" name="form" method="get" action="">
        <div id="datosguiad">
            <div class="paso"><a style="color:#FFF;" href="index.php?opc=nuevaSolicitud">1 Paso</a></div>
            <div class="paso_selected">2 Paso</div>
            <div class="paso">3 Paso</div>
            <br /><br /><br />
            <fieldset>
                <legend>Productos para Solicitud: <?php echo htmlspecialchars($idsol, ENT_QUOTES, 'UTF-8'); ?></legend>
                
                <input name="opc" type="hidden" value="pasodos" />
                <input name="idsol" type="hidden" id="idsol" value="<?php echo htmlspecialchars($idsol, ENT_QUOTES, 'UTF-8'); ?>" />
                
                <input name="idarticulo" type="hidden" id="idarticulo" value="" />
                <input name="unidadarticulo" type="hidden" id="unidadarticulo" value="" />
                
                <div style="display: flex; flex-wrap: wrap; align-items: flex-end; gap: 12px;">
                    <label style="display:flex; flex-direction:column; font-size:12px;">Buscar Marca
                        <input type='text' name='marca' id="marca" value='<?php echo htmlspecialchars($bmarca ?? '', ENT_QUOTES, 'UTF-8'); ?>' class='auto' style="width: 180px;">
                    </label>

                    <label style="display:flex; flex-direction:column; font-size:12px;">Código / Descripción
                        <input type='text' name='buscar_texto' id="buscar_texto" value='<?php echo htmlspecialchars($buscar_texto, ENT_QUOTES, 'UTF-8'); ?>' style="width: 180px;" placeholder="ej: 1234 o crema">
                    </label>

                    <div style="display: flex; align-items: center; gap: 12px; padding-bottom: 2px;">
                        <label><input type="radio" name="filtro_tipo" value="regular" <?php echo ($filtro_tipo == 'regular') ? 'checked' : ''; ?>> Productos</label>
                        <label><input type="radio" name="filtro_tipo" value="sinvalor" <?php echo ($filtro_tipo == 'sinvalor') ? 'checked' : ''; ?>> Tester/Publicidad</label>
                        <label><input type="radio" name="filtro_tipo" value="todos" <?php echo ($filtro_tipo == 'todos') ? 'checked' : ''; ?>> Todos los Artículos</label>
                    </div>

                    <input type="submit" value="Buscar" class="submit" id="enviarmarca" style="margin-bottom: 2px;" />
                </div>
            </fieldset>
        </div>
    </form>
    <form id="detailsForm">
        <table id="ssptable" class="lista">
            <thead>
                <tr>
                    <th>Marca</th>
                    <th>código</th>
                    <th>descripción</th>
                    <th>stock tienda</th>
                    <th>cant. solicitada</th>
                    <th>cant. aceptada</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody id="tablebody">
                <?php if (count($detalles_solicitud) > 0): ?>
                    <?php foreach ($detalles_solicitud as $detalle): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($detalle["Marca"] ?? '', ENT_QUOTES, 'UTF-8'); ?></strong></td>
                            <td><strong><?php echo htmlspecialchars($detalle["codigo"] ?? '', ENT_QUOTES, 'UTF-8'); ?></strong></td>
                            <td><?php echo htmlspecialchars(utf8_safe($detalle["descripcion"]), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($detalle["stock_modulo"] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($detalle["cant_solicitada"] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($detalle["cant_aceptada"] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><a class="elimina_lista" id="<?php echo htmlspecialchars($detalle["codigo"], ENT_QUOTES, 'UTF-8'); ?>"><img src="images/delete.png" /></a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No hay detalles para esta solicitud.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <div style="float:right; font-size:30px; margin-right:20px;">
            <?php 
            // El estado ya lo teníamos, no es necesario volver a consultar
            if ($estado == 0) {
                echo '<input type="button" value="Enviar" class="submit" style="float:left; margin-top:0px;" onclick="javascript: fn_finalizar_guia();" />';
            }
            if ($estado == 1) {
                echo '<input type="button" value="Validar" class="submit" style="float:left; margin-top:0px;" onclick="javascript: fn_finalizar_guia();" />';
            }
            ?>
        </div>
    </form>
    <fieldset class="caja" style="width:860px; float:left; margin-left:10px; padding-top:10px;">
        <label style="margin-right:20px;">Mauricio H.<input id="mauricio" type="checkbox" /> </label>
        <label style="margin-right:20px;">Marianela V.<input id="marianela" type="checkbox" /> </label>
        <label style="margin-right:20px;">Rosa Z.<input id="rosa" type="checkbox" /> </label>
        <label style="margin-right:20px;">Marieliza M.<input id="marieliza" type="checkbox" /> </label>
        <label style="margin-right:20px;">Cristina O.<input id="cristina" type="checkbox" /> </label>
        <label style="margin-right:20px;">Maribel D.<input id="maribel" type="checkbox" /> </label>
        <br /><br />
        Todos los pedidos deben ser ingresados antes de las 12:30 horas del día Martes.
    </fieldset>

    <script src='js/jquery.min.js'></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/addboton2.js"></script>

    <script types="text/javascript">
        // Pasamos la configuración de PHP a JavaScript de forma segura
        const APP_CONFIG = <?php echo json_encode($config_js); ?>;

        // Tu código JS original, ahora más limpio
        $(document).ready(function() {
            fn_anade_lista(); //eliminar de lista
            fn_eliminar_articulolista(); //eliminar de lista

            // Lógica para abrir el diálogo (antes mezclada con PHP)
            if (APP_CONFIG.shouldOpenDialog) {
                $("#loadscreen").show();
                
                // Usamos $(window).on('load', ...) que es más moderno
                $(window).on('load', function() {
                    $("#dialog-form").dialog("open");
                    $("#loadscreen").hide();
                });
            }

            // Autocomplete
            $(".auto").autocomplete({
                source: "modulos/solicitudes/bmarcas.php",
                minLength: 1,
            });

            // Diálogo (sin las funciones de validación que no se usaban)
            $("#dialog-form").dialog({
                autoOpen: false,
                height: 600,
                width: 1000,
                modal: true,
                buttons: {
                    "Aceptar": function() {
                        $(this).dialog("close");
                        location.href = 'index.php?opc=pasodos&idsol=' + APP_CONFIG.idsol;
                    },
                    "Cerrar": function() {
                        $(this).dialog("close");
                        location.href = 'index.php?opc=pasodos&idsol=' + APP_CONFIG.idsol;
                    }
                },
                close: function() {
                    // Limpieza al cerrar
                    // allFields.val("").removeClass("ui-state-error"); 
                }
            });

            // Suma de totales (tu lógica original)
            $('#articulo').focus();
            var re;
            var valor = 0
            $('form').children().find('.preciototalu').each(function() {
                re = $(this).val();
                valor += parseFloat(re)
            });
            $('#TOTALFINAL').val(valor.toFixed(0));

        });
        
        // --- NOTA: Debes asegurarte que estas funciones existan ---
        // function fn_finalizar_guia() { ... }
        // function fn_enviar_marca() { 
        //     document.getElementById('horizontalForm').submit(); 
        // }
    </script>
</body>
</html>