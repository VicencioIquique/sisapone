<?php
/*
 * Genera masivamente los informes de caja (mismo formato que reporteCajaCont.php)
 * para todas las combinaciones módulo/caja que tengan documentos en una fecha.
 *
 * Uso por consola:   php modulos/caja/generarInformesCaja.php 2026-09-15
 *                    -> deja los PDF en /informes_caja/<fecha>/ y un .zip en /informes_caja/
 * Uso por navegador: /sisapone/modulos/caja/generarInformesCaja.php?fecha=2026-09-15
 *                    -> descarga un .zip con los PDF
 */
ini_set('max_execution_time', 0);
ini_set('memory_limit', '512M');

$esCli = (php_sapi_name() == 'cli');
if (!$esCli && session_status() == PHP_SESSION_NONE) {
	session_start();
}

$raiz = realpath(__DIR__ . '/../..');
require_once($raiz . '/clases/fpdf/fpdf.php');

$fecha = $esCli ? (isset($argv[1]) ? $argv[1] : '') : (isset($_GET['fecha']) ? $_GET['fecha'] : '');

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
	if ($esCli) {
		exit("Uso: php generarInformesCaja.php AAAA-MM-DD\n");
	}
	echo '<form method="GET">
			Fecha cierre de caja: <input type="date" name="fecha" required>
			<input type="submit" value="Generar ZIP">
		  </form>';
	exit;
}

require_once($raiz . '/clases/conexionocdb.php');

$usuario = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : '';

$modulos = array(
	'000' => '2077', '001' => '1010', '002' => '1132', '003' => '181', '004' => '184',
	'005' => '2002', '006' => '6115', '007' => '6130', '008' => '2077'
);

$tiposDocto = array(
	'1' => 'Boleta Fiscal', '2' => 'Factura', '3' => 'Nota de crédito',
	'4' => 'Boleta manual', '5' => 'Boleta'
);

// ---------------------------------------------------------------------------
// Módulos y cajas con documentos en la fecha
// ---------------------------------------------------------------------------
$sqlCajas = "
	SELECT DISTINCT Bodega, Workstation
	FROM RP_VICENCIO.dbo.RP_ReceiptsCab_SAP
	WHERE FechaDocto > '".$fecha." 00:00:00' AND
		  FechaDocto < '".$fecha." 23:59:59' AND
		  TipoDocto <> '99'
	ORDER BY Bodega, Workstation
";
$rsCajas = odbc_exec($conn, $sqlCajas);
if (!$rsCajas) {
	exit("Error en la consulta SQL de cajas\n");
}
$cajas = array();
while ($fila = odbc_fetch_array($rsCajas)) {
	$cajas[] = array('bodega' => trim($fila['Bodega']), 'workstation' => trim($fila['Workstation']));
}

if (count($cajas) == 0) {
	odbc_close($conn);
	exit("No hay ventas registradas el ".$fecha."\n");
}

// ---------------------------------------------------------------------------
// Carpeta de salida
// ---------------------------------------------------------------------------
if ($esCli) {
	$dirBase = $raiz . '/informes_caja';
} else {
	$dirBase = sys_get_temp_dir() . '/informes_caja_' . uniqid();
}
$dirFecha = $dirBase . '/' . $fecha;
if (!is_dir($dirFecha)) {
	mkdir($dirFecha, 0777, true);
}

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

	$filas = obtenerFilas($conn, $fecha, $bodega, $workstation);
	if ($filas === false) {
		if ($esCli) { echo "ERROR SQL modulo ".$moduloNombre." (".$bodega.") caja ".$workstation."\n"; }
		continue;
	}

	$nombre = 'reporte caja '.$fecha.' modulo '.$moduloNombre.' ('.$bodega.') caja '.$workstation.'.pdf';
	$ruta = $dirFecha . '/' . $nombre;
	generarPdf($filas, $fecha, $moduloNombre, $workstation, $usuario, $ruta);
	$generados[] = $ruta;

	if ($esCli) { echo "OK  ".$nombre."\n"; }
}
odbc_close($conn);

// ZIP
$rutaZip = $dirBase . '/informes_caja_' . $fecha . '.zip';
$zip = new ZipArchive();
if ($zip->open($rutaZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
	exit("No se pudo crear el ZIP\n");
}
foreach ($generados as $ruta) {
	$zip->addFile($ruta, basename($ruta));
}
$zip->close();

if ($esCli) {
	echo "\n".count($generados)." PDF generados en ".$dirFecha."\n";
	echo "ZIP: ".$rutaZip."\n";
	exit;
}

header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="informes_caja_'.$fecha.'.zip"');
header('Content-Length: ' . filesize($rutaZip));
readfile($rutaZip);

// Limpiar temporales
foreach ($generados as $ruta) { @unlink($ruta); }
@unlink($rutaZip);
@rmdir($dirFecha);
@rmdir($dirBase);
