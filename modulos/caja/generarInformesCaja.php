<?php
/*
 * Genera masivamente los informes de caja (mismo formato que reporteCajaCont.php)
 * para todas las combinaciones módulo/caja que tengan documentos en una fecha.
 *
 * Uso por consola:   php modulos/caja/generarInformesCaja.php 2026-09-15 [bodega]
 *                    -> sin bodega genera todos los módulos
 * Uso por navegador: menú Caja > Descargar Informes de Cajas (requiere sesión)
 *                    -> rol 1 (ROOT) puede elegir un módulo o todos
 *                    -> el resto de los roles solo su módulo ($_SESSION["bodega"])
 *
 * Los PDF quedan en /informes_caja/<fecha>/, el ZIP en /informes_caja/ y un log en /informes_caja/<fecha>/log.txt
 */
set_time_limit(0);
ini_set('memory_limit', '512M');
ignore_user_abort(true); // si el navegador o un proxy corta la conexión, el script sigue generando

$esCli = (php_sapi_name() == 'cli');
$raiz = realpath(__DIR__ . '/../..');
$dirBase = $raiz . '/informes_caja';

$modulos = array(
	'000' => '2077', '001' => '1010', '002' => '1132', '003' => '181', '004' => '184',
	'005' => '2002', '006' => '6115', '007' => '6130', '008' => '2077'
);
// Mismo orden y opciones que el formulario de reporteCajaCont.php
$modulosSelect = array('003' => '181', '004' => '184', '001' => '1010', '002' => '1132', '005' => '2002', '008' => '2077', '006' => '6115', '007' => '6130');

$tiposDocto = array(
	'1' => 'Boleta Fiscal', '2' => 'Factura', '3' => 'Nota de crédito',
	'4' => 'Boleta manual', '5' => 'Boleta'
);

// ---------------------------------------------------------------------------
// Parámetros y permisos
// ---------------------------------------------------------------------------
if ($esCli) {
	$fecha = isset($argv[1]) ? $argv[1] : '';
	$filtroBodega = isset($argv[2]) ? $argv[2] : '';
	$usuarioSesion = '';
	$esAdmin = true;
} else {
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	header('Content-Type: text/html; charset=utf-8');

	if (empty($_SESSION['usuario_rol'])) {
		exit('Sesión expirada. <a href="../../index.php">Ingresar al sistema</a>');
	}
	$esAdmin = ($_SESSION['usuario_rol'] == 1);
	$bodegaUsuario = isset($_SESSION['bodega']) ? trim($_SESSION['bodega']) : '';
	$usuarioSesion = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : '';
	// Liberar la sesión para no bloquear otras pestañas del sistema mientras genera
	session_write_close();

	if (!$esAdmin && $bodegaUsuario === '') {
		exit('Tu usuario no tiene un módulo asignado.');
	}

	$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';
	// Solo ROOT elige módulo ('' = todos); el resto queda fijo en su bodega
	$filtroBodega = $esAdmin ? (isset($_GET['modulo']) ? $_GET['modulo'] : '') : $bodegaUsuario;
}

if ($filtroBodega !== '' && !preg_match('/^\d{3}$/', $filtroBodega)) {
	exit("Módulo inválido\n");
}

// ---------------------------------------------------------------------------
// Descarga de un ZIP ya generado (validando que corresponda al módulo del usuario)
// ---------------------------------------------------------------------------
if (!$esCli && isset($_GET['descargar'])) {
	$archivo = $_GET['descargar'];
	if (!preg_match('/^informes_caja_\d{4}-\d{2}-\d{2}_(todos|\d{3})\.zip$/', $archivo, $m)) {
		exit('Archivo inválido');
	}
	if (!$esAdmin && $m[1] !== $bodegaUsuario) {
		exit('No tienes permiso para descargar este archivo');
	}
	$rutaDescarga = $dirBase . '/' . $archivo;
	if (!is_file($rutaDescarga)) {
		exit('El archivo no existe');
	}
	header('Content-Type: application/zip');
	header('Content-Disposition: attachment; filename="'.$archivo.'"');
	header('Content-Length: ' . filesize($rutaDescarga));
	readfile($rutaDescarga);
	exit;
}

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
	if ($esCli) {
		exit("Uso: php generarInformesCaja.php AAAA-MM-DD [bodega]\n");
	}
	echo '<title>Descargar Informes de Cajas</title>
		<div style="font-family:Arial,sans-serif; max-width:420px; margin:40px auto;">
		<h3>Descargar Informes de Cajas</h3>
		<form method="GET">
			<p>Fecha cierre de caja<br><input type="date" name="fecha" required></p>
			<p>Módulo<br>';
	if ($esAdmin) {
		echo '<select name="modulo"><option value="">Todos los módulos</option>';
		foreach ($modulosSelect as $codigo => $nombre) {
			echo '<option value="'.$codigo.'">'.$nombre.'</option>';
		}
		echo '</select>';
	} else {
		$nombreModulo = isset($modulos[$bodegaUsuario]) ? $modulos[$bodegaUsuario] : $bodegaUsuario;
		echo '<b>'.htmlspecialchars($nombreModulo).'</b> (todas las cajas)';
	}
	echo '	</p>
			<input type="submit" value="Generar informes">
		</form>
		<p style="color:#666; font-size:12px;">La generación puede tardar varios minutos. No cierres la ventana.</p>
		</div>';
	exit;
}

if (!$esCli) {
	// Enviar el avance al navegador a medida que se genera
	@ini_set('zlib.output_compression', '0');
	@ini_set('implicit_flush', '1');
	while (ob_get_level() > 0) {
		ob_end_flush();
	}
}

$logArchivo = null;
function mensaje($txt) {
	global $esCli, $logArchivo;
	if ($logArchivo) {
		file_put_contents($logArchivo, date('Y-m-d H:i:s').'  '.$txt."\n", FILE_APPEND);
	}
	if ($esCli) {
		echo $txt."\n";
	} else {
		echo htmlspecialchars($txt, ENT_QUOTES, 'UTF-8')."<br>\n";
		flush();
	}
}

require_once($raiz . '/clases/fpdf/fpdf.php');

$sufijo = ($filtroBodega === '') ? 'todos' : $filtroBodega;

// ---------------------------------------------------------------------------
// Carpeta de salida y log
// ---------------------------------------------------------------------------
$dirFecha = $dirBase . '/' . $fecha;
if (!is_dir($dirFecha) && !@mkdir($dirFecha, 0777, true)) {
	exit("No se pudo crear la carpeta ".$dirFecha." (revisar permisos)\n");
}
$logArchivo = $dirFecha . '/log.txt';

if (!$esCli) {
	echo str_repeat(' ', 1024); // algunos navegadores no muestran nada hasta recibir 1KB
}
mensaje('Inicio generación informes de caja '.$fecha.' - módulo: '.($filtroBodega === '' ? 'todos' : (isset($modulos[$filtroBodega]) ? $modulos[$filtroBodega] : '?').' ('.$filtroBodega.')').($usuarioSesion ? ' - usuario: '.$usuarioSesion : ''));
mensaje('Carpeta de salida: '.$dirFecha);

require_once($raiz . '/clases/conexionocdb.php');
mensaje('Conectado a la base de datos');

$usuario = $usuarioSesion;

// ---------------------------------------------------------------------------
// Módulos y cajas con documentos en la fecha
// ---------------------------------------------------------------------------
$sqlCajas = "
	SELECT DISTINCT Bodega, Workstation
	FROM RP_VICENCIO.dbo.RP_ReceiptsCab_SAP
	WHERE FechaDocto > '".$fecha." 00:00:00' AND
		  FechaDocto < '".$fecha." 23:59:59' AND
		  TipoDocto <> '99'
		  ".($filtroBodega !== '' ? "AND Bodega = '".$filtroBodega."'" : "")."
	ORDER BY Bodega, Workstation
";
$rsCajas = odbc_exec($conn, $sqlCajas);
if (!$rsCajas) {
	mensaje('ERROR en la consulta SQL de cajas: '.odbc_errormsg($conn));
	exit;
}
$cajas = array();
while ($fila = odbc_fetch_array($rsCajas)) {
	$cajas[] = array('bodega' => trim($fila['Bodega']), 'workstation' => trim($fila['Workstation']));
}

if (count($cajas) == 0) {
	odbc_close($conn);
	mensaje('No hay ventas registradas el '.$fecha);
	exit;
}
mensaje(count($cajas).' cajas con ventas encontradas');

// ---------------------------------------------------------------------------
// Funciones
// ---------------------------------------------------------------------------
function fmt($n) {
	return number_format((float)$n, 0, ',', '.');
}

function latin($txt) {
	return mb_convert_encoding($txt, 'ISO-8859-1', 'UTF-8');
}

function filaSaltoFolio() {
	return array('estilo' => 'salto', 'celdas' => array('SALTO DE FOLIO', '-', '-', '-', '-', '-', '-', '-', '-', '-'));
}

function sinPago($r) {
	return fmt($r['Monto_Cash']) == 0 && fmt($r['Monto_DebitCard']) == 0 && fmt($r['Monto_CreditCard']) == 0
		&& fmt($r['Monto_Check']) == 0 && fmt($r['Monto_Payments']) == 0 && fmt($r['Monto_StoreCredit']) == 0;
}

function filaDocumento($r, $tipoTexto, $aplicaSinPago) {
	global $tiposDocto;
	$docNum = trim($r['DocNum']);
	if ($aplicaSinPago && sinPago($r)) {
		$docNum = 'SIN PAGO';
	}
	$tipo = '';
	if ($tipoTexto && isset($tiposDocto[$r['TipoDocto']])) {
		$tipo = $tiposDocto[$r['TipoDocto']];
	}
	return array('estilo' => 'normal', 'celdas' => array(
		$tipo, $r['NumeroDocto'], $docNum, fmt($r['Total']), fmt($r['Monto_Cash']),
		fmt($r['Monto_DebitCard']), fmt($r['Monto_CreditCard']), fmt($r['Monto_Check']),
		fmt($r['Monto_Payments']), fmt($r['Monto_StoreCredit'])
	));
}

/*
 * Replica la lógica de filas de reporteCajaCont.php (subtotales por tipo,
 * saltos de folio y totales con descuento de notas de crédito).
 */
function obtenerFilas($conn, $fecha, $bodega, $workstation) {
	$baseSap = ($bodega == '000')
		? "SBO_Inv_Servimex.dbo.OINV"
		: "[SAPSQL.DHN.CL].[SBO_Imp_Eximben_SAC].[dbo].OINV";

	$sql = "
		SELECT Tabla.* FROM
		(SELECT
			T1.WorkStation,
			T1.TipoDocto,
			T1.NumeroDocto,
			CASE WHEN T3.DocNum IS NULL THEN 'Pendiente' ELSE CONVERT(CHAR(10),T3.DocNum) END as DocNum,
			T1.Total,
			ISNULL((SELECT SUM(Monto) FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T3 WHERE TipoPago = 'Cash' AND T1.ID = T3.ID GROUP BY TipoPago),'0') as Monto_Cash,
			ISNULL((SELECT SUM(Monto) FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T3 WHERE TipoPago IN ('DebitCard', 'GNDeb') AND T1.ID = T3.ID GROUP BY TipoPago),'0') as Monto_DebitCard,
			ISNULL((SELECT SUM(Monto) FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T3 WHERE TipoPago IN ('CreditCard', 'GNCred') AND T1.ID = T3.ID GROUP BY TipoPago),'0') as Monto_CreditCard,
			ISNULL((SELECT SUM(Monto) FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T3 WHERE TipoPago = 'Check' AND T1.ID = T3.ID GROUP BY TipoPago),'0') as Monto_Check,
			ISNULL((SELECT SUM(Monto) FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T3 WHERE TipoPago = 'Payments' AND T1.ID = T3.ID GROUP BY TipoPago),'0') as Monto_Payments,
			ISNULL((SELECT SUM(Monto) FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T3 WHERE TipoPago = 'CreditStore' AND T1.ID = T3.ID GROUP BY TipoPago),'0') as Monto_StoreCredit
		FROM RP_VICENCIO.dbo.RP_ReceiptsCab_SAP as T1
		LEFT JOIN RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as T2 ON T1.ID = T2.ID
		LEFT JOIN ".$baseSap." T3 ON T1.BaseEntry = T3.DocEntry
		WHERE
			T1.FechaDocto > '".$fecha." 00:00:00' AND
			T1.FechaDocto < '".$fecha." 23:59:59' AND
			T1.Bodega = '".$bodega."' AND
			T1.Workstation = '".$workstation."' AND
			T1.TipoDocto <> '99'
		) as Tabla
		GROUP BY Tabla.Workstation, Tabla.TipoDocto, Tabla.NumeroDocto, Tabla.DocNum, Tabla.Total, Tabla.Monto_Cash, Tabla.Monto_DebitCard, Tabla.Monto_CreditCard, Tabla.Monto_Check, Tabla.Monto_Payments, Tabla.Monto_StoreCredit
		ORDER BY Tabla.TipoDocto, Tabla.NumeroDocto ASC
	";

	// Último folio del día anterior por tipo de documento
	$ultimos = array();
	foreach (array('1', '2', '3', '4', '5', '99') as $t) {
		$sqlUlt = "SELECT TOP 1 NumeroDocto FROM RP_VICENCIO.dbo.RP_ReceiptsCab_SAP
			WHERE TipoDocto = '".$t."' AND FechaDocto > DATEADD(day,-1,'".$fecha." 00:00:00') AND FechaDocto < DATEADD(day,-1,'".$fecha." 23:59:59')
			AND Bodega = '".$bodega."' AND Workstation = '".$workstation."' ORDER BY NumeroDocto DESC";
		$rsUlt = odbc_exec($conn, $sqlUlt);
		$filaUlt = $rsUlt ? odbc_fetch_array($rsUlt) : false;
		$ultimos[$t] = $filaUlt ? $filaUlt['NumeroDocto'] : NULL;
	}

	$rs = odbc_exec($conn, $sql);
	if (!$rs) {
		return false;
	}

	$filas = array();
	$acum = array('Total' => 0, 'Monto_Cash' => 0, 'Monto_DebitCard' => 0, 'Monto_CreditCard' => 0, 'Monto_Check' => 0, 'Monto_Payments' => 0, 'Monto_StoreCredit' => 0);
	$sub = $acum;
	$nc = array('Total' => 0, 'Monto_Cash' => 0, 'Monto_StoreCredit' => 0);
	$numeroDoctoAnt = "";
	$tipoDoctoAnt = "";
	$tipoDoctoAnte = "";
	$primeraFila = true;

	while ($r = odbc_fetch_array($rs)) {
		if ($tipoDoctoAnt != "" && $tipoDoctoAnt != $r['TipoDocto']) {
			$numeroDoctoAnt = "";
		}

		// Salto de folio respecto al último documento del día anterior (solo primera fila, igual que el reporte)
		if ($primeraFila) {
			$t = $r['TipoDocto'];
			if (array_key_exists($t, $ultimos) && $ultimos[$t] !== NULL && ($r['NumeroDocto'] - 1) != $ultimos[$t]) {
				$filas[] = filaSaltoFolio();
			}
			$primeraFila = false;
		}

		if ($tipoDoctoAnte != "" && $tipoDoctoAnte != $r['TipoDocto']) {
			// Cambio de tipo de documento: cerrar subtotal
			$filas[] = array('estilo' => 'sub', 'celdas' => array('Sub total', '', '', fmt($sub['Total']), fmt($sub['Monto_Cash']), fmt($sub['Monto_DebitCard']), fmt($sub['Monto_CreditCard']), fmt($sub['Monto_Check']), fmt($sub['Monto_Payments']), fmt($sub['Monto_StoreCredit'])));
			foreach ($sub as $k => $v) { $sub[$k] = 0; }
			$filas[] = filaDocumento($r, true, false);
		} else {
			$mostrarTipo = ($tipoDoctoAnte == "");
			if ($numeroDoctoAnt != "" && ($numeroDoctoAnt + 1) != $r['NumeroDocto']) {
				$filas[] = filaSaltoFolio();
				$filas[] = filaDocumento($r, $mostrarTipo, $mostrarTipo);
			} else {
				$filas[] = filaDocumento($r, $mostrarTipo, true);
			}
		}

		foreach ($sub as $k => $v) {
			$sub[$k] += $r[$k];
			$acum[$k] += $r[$k];
		}
		if ($r['TipoDocto'] == '3') {
			$nc['Total'] += $r['Total'];
			$nc['Monto_Cash'] += $r['Monto_Cash'];
			$nc['Monto_StoreCredit'] += $r['Monto_StoreCredit'];
		}

		$tipoDoctoAnte = $r['TipoDocto'];
		$numeroDoctoAnt = $r['NumeroDocto'];
		$tipoDoctoAnt = $r['TipoDocto'];
	}

	$filas[] = array('estilo' => 'sub', 'celdas' => array('Sub total', '', '', fmt($sub['Total']), fmt($sub['Monto_Cash']), fmt($sub['Monto_DebitCard']), fmt($sub['Monto_CreditCard']), fmt($sub['Monto_Check']), fmt($sub['Monto_Payments']), fmt($sub['Monto_StoreCredit'])));
	$filas[] = array('estilo' => 'total', 'celdas' => array(
		'Totales', '', '',
		fmt(($acum['Total'] - $nc['Total']) - $nc['Total']),
		fmt(($acum['Monto_Cash'] - $nc['Monto_Cash']) - $nc['Monto_Cash']),
		fmt($acum['Monto_DebitCard']), fmt($acum['Monto_CreditCard']), fmt($acum['Monto_Check']), fmt($acum['Monto_Payments']),
		fmt(($acum['Monto_StoreCredit'] - $nc['Monto_StoreCredit']) - $nc['Monto_StoreCredit'])
	));

	return $filas;
}

/*
 * Dibuja el PDF con las mismas posiciones que el jsPDF de reporteCajaCont.php
 * (carta horizontal, puntos, Times 8).
 */
function generarPdf($filas, $fecha, $moduloNombre, $workstation, $usuario, $rutaArchivo) {
	$columnasX = array(20, 100, 200, 265, 310, 380, 450, 520, 600, 700);
	$titulos = array('Tipo de documento', 'Numero de documento', 'Numero SAP', 'Total', 'Monto efectivo', 'Monto debito', 'Monto credito', 'Monto cheque', 'Monto cheque a fecha', 'Monto credito tienda');

	$pdf = new FPDF('L', 'pt', 'Letter');
	$pdf->SetAutoPageBreak(false);
	$pdf->AddPage();

	$pdf->SetFont('Times', '', 8);
	$pdf->Text(20, 20, 'CAJA: ');
	$pdf->Text(45, 20, $workstation);
	$pdf->Text(20, 30, 'MODULO:');
	$pdf->Text(60, 30, $moduloNombre);
	$pdf->Text(350, 30, 'INFORME DE CAJA - ');
	$pdf->Text(430, 30, latin($usuario));
	$pdf->Text(20, 40, 'DIA DE INFORME:');
	$pdf->Text(90, 40, $fecha);

	$dibujarCabecera = function ($y) use ($pdf, $columnasX, $titulos) {
		$pdf->SetFont('Times', 'B', 8);
		foreach ($titulos as $i => $titulo) {
			$pdf->Text($columnasX[$i], $y, $titulo);
		}
	};
	$dibujarCabecera(80);

	$alto = 90;
	// En el reporte original las filas de datos empiezan en el índice 5 de la tabla y hay salto de página cada 50
	foreach ($filas as $n => $fila) {
		$i = $n + 5;
		if ($i % 50 == 0) {
			$pdf->AddPage();
			$dibujarCabecera(20);
			$alto = 35;
		}
		if ($fila['estilo'] == 'sub') {
			$pdf->SetFont('Times', 'B', 8);
		} else if ($fila['estilo'] == 'total') {
			$pdf->SetFont('Times', 'B', 10);
		} else {
			$pdf->SetFont('Times', '', 8);
		}
		foreach ($fila['celdas'] as $c => $valor) {
			$pdf->Text($columnasX[$c], $alto, latin((string)$valor));
		}
		$alto += 10;
	}

	$pdf->Output($rutaArchivo, 'F'); // FPDF 1.6: Output(nombre, destino)
}

// ---------------------------------------------------------------------------
// Generación
// ---------------------------------------------------------------------------
$generados = array();
foreach ($cajas as $caja) {
	$bodega = $caja['bodega'];
	$workstation = $caja['workstation'];
	$moduloNombre = isset($modulos[$bodega]) ? $modulos[$bodega] : $bodega;

	$etiqueta = 'modulo '.$moduloNombre.' ('.$bodega.') caja '.$workstation;
	mensaje('Procesando '.$etiqueta.'...');
	$inicioCaja = microtime(true);

	$filas = obtenerFilas($conn, $fecha, $bodega, $workstation);
	if ($filas === false) {
		mensaje('  ERROR SQL '.$etiqueta.': '.odbc_errormsg($conn));
		continue;
	}

	$nombre = 'reporte caja '.$fecha.' '.$etiqueta.'.pdf';
	$ruta = $dirFecha . '/' . $nombre;
	generarPdf($filas, $fecha, $moduloNombre, $workstation, $usuario, $ruta);
	$generados[] = $ruta;

	mensaje('  OK '.$nombre.' ('.round(microtime(true) - $inicioCaja, 1).' s)');
}
odbc_close($conn);

// ZIP
$nombreZip = 'informes_caja_' . $fecha . '_' . $sufijo . '.zip';
$rutaZip = $dirBase . '/' . $nombreZip;
$zip = new ZipArchive();
if ($zip->open($rutaZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
	mensaje('ERROR: no se pudo crear el ZIP '.$rutaZip);
	exit;
}
foreach ($generados as $ruta) {
	$zip->addFile($ruta, basename($ruta));
}
$zip->close();

mensaje(count($generados).' PDF generados en '.$dirFecha);
mensaje('ZIP: '.$rutaZip);

if (!$esCli) {
	echo '<br><a href="?descargar='.rawurlencode($nombreZip).'" style="font-size:16px;">Descargar '.$nombreZip.'</a>';
}
