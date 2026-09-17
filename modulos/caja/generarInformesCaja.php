<?php
/*
 * Genera masivamente los informes de caja (mismo formato que reporteCajaCont.php)
 * para todas las cajas con ventas en un rango de fechas.
 *
 * Uso por consola:   php modulos/caja/generarInformesCaja.php 2026-09-01 [2026-09-15] [bodega]
 *                    -> sin fecha hasta usa la misma fecha; sin bodega genera todos los módulos
 * Uso por navegador: menú Caja > Descargar Informes de Cajas (requiere sesión)
 *                    -> rol 1 (ROOT) puede elegir un local o todos
 *                    -> el resto de los roles solo su local ($_SESSION["bodega"])
 *
 * Los PDF quedan en /informes_caja/<fecha>/, el ZIP en /informes_caja/ y el log en /informes_caja/log.txt
 */
set_time_limit(0);
ini_set('memory_limit', '512M');
ignore_user_abort(true); // si el navegador o un proxy corta la conexión, el script sigue generando

$esCli = (php_sapi_name() == 'cli');
$raiz = realpath(__DIR__ . '/../..');
$dirBase = $raiz . '/informes_caja';
$maxDias = 92; // tope del rango para no dejar consultas eternas

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
// Página HTML con el estilo del tema minimalplomo
// ---------------------------------------------------------------------------
$paginaAbierta = false;
$logAbierto = false;
function abrirPagina() {
	global $paginaAbierta, $usuarioSesion;
	if ($paginaAbierta) {
		return;
	}
	$paginaAbierta = true;
	echo '<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>.: SISAP :. Descargar Informes de Cajas</title>
<link rel="stylesheet" type="text/css" href="../../temas/minimalplomo/minimalplomo.css">
<style>
	#cuerpo { padding: 15px 0; }
	#header h1 { font-size: 24px; float: left; }
	#header .usuario { color: #3D9DE2; float: right; margin-top: 7px; margin-right: 5px; }
	#header .usuario img { width: 16px; height: 16px; vertical-align: middle; margin-right: 4px; }
	#horizontalForm label.first { margin: 5px 20px 0 0; line-height: 18px; }
	#horizontalForm fieldset:after { content: ""; display: block; clear: both; }
	#horizontalForm .moduloFijo { display: block; height: 20px; line-height: 20px; font-weight: bold; color: #649ebf; }
	.nota { width: 95%; margin: 8px auto 0 auto; color: #7b7b7b; }
	.aviso { width: 95%; margin: 0 auto; padding: 12px; border: 1px solid #dedede; border-radius: 5px; background-color: #F0F0F0; box-sizing: border-box; font-size: 13px; }
	.aviso a, .volver { color: #649ebf; }
	.log { width: 95%; margin: 0 auto; padding: 10px; border: 1px solid #dedede; border-radius: 5px; background-color: #F0F0F0; box-sizing: border-box; font-family: Consolas, monospace; font-size: 12px; line-height: 18px; }
	.log .ok { color: #3c8d3c; }
	.log .error { color: #cc0000; font-weight: bold; }
	.log .dia { color: #649ebf; font-weight: bold; margin-top: 6px; }
	.acciones { width: 95%; margin: 12px auto 0 auto; }
	.boton { display: inline-block; background-color: #649ebf; color: #fff; border-radius: 5px; padding: 7px 14px; font-size: 15px; text-shadow: 0px 1px 1px #c0c0c0; }
	.boton:hover { text-decoration: none; background-color: #5a8fad; }
</style>
</head>
<body>
<div id="contenedor">
	<div id="header">
		<h1>Descargar Informes de Cajas</h1>';
	if ($usuarioSesion !== '') {
		echo '<span class="usuario"><img src="../../images/user1.png">'.htmlspecialchars($usuarioSesion).'</span>';
	}
	echo '
	</div>
	<div id="cuerpo">
';
	register_shutdown_function(function () {
		global $logAbierto;
		if ($logAbierto) {
			echo '</div><div class="acciones"><a class="volver" href="generarInformesCaja.php">&laquo; Volver</a></div>';
		}
		echo "\n\t</div>\n</div>\n</body>\n</html>";
	});
}

function salir($html, $sinVolver = false) {
	global $esCli;
	if ($esCli) {
		exit(strip_tags($html)."\n");
	}
	abrirPagina();
	echo '<div class="aviso">'.$html.'</div>';
	if (!$sinVolver) {
		echo '<div class="acciones"><a class="volver" href="generarInformesCaja.php">&laquo; Volver</a></div>';
	}
	exit;
}

// ---------------------------------------------------------------------------
// Parámetros y permisos
// ---------------------------------------------------------------------------
if ($esCli) {
	$fechaDesde = isset($argv[1]) ? $argv[1] : '';
	$fechaHasta = isset($argv[2]) ? $argv[2] : '';
	$filtroBodega = isset($argv[3]) ? $argv[3] : '';
	$usuarioSesion = '';
	$esAdmin = true;
} else {
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	header('Content-Type: text/html; charset=utf-8');

	$usuarioSesion = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : '';
	if (empty($_SESSION['usuario_rol'])) {
		salir('Sesión expirada. <a href="../../index.php">Ingresar al sistema</a>', true);
	}
	$esAdmin = ($_SESSION['usuario_rol'] == 1);
	$bodegaUsuario = isset($_SESSION['bodega']) ? trim($_SESSION['bodega']) : '';
	// Liberar la sesión para no bloquear otras pestañas del sistema mientras genera
	session_write_close();

	if (!$esAdmin && $bodegaUsuario === '') {
		salir('Tu usuario no tiene un local asignado.');
	}

	$fechaDesde = isset($_GET['desde']) ? $_GET['desde'] : '';
	$fechaHasta = isset($_GET['hasta']) ? $_GET['hasta'] : '';
	// Solo ROOT elige local ('' = todos); el resto queda fijo en su bodega
	$filtroBodega = $esAdmin ? (isset($_GET['modulo']) ? $_GET['modulo'] : '') : $bodegaUsuario;
}

if ($filtroBodega !== '' && !preg_match('/^\d{3}$/', $filtroBodega)) {
	salir('Local inválido');
}

// ---------------------------------------------------------------------------
// Descarga de un ZIP ya generado (validando que corresponda al local del usuario)
// ---------------------------------------------------------------------------
if (!$esCli && isset($_GET['descargar'])) {
	$archivo = $_GET['descargar'];
	if (!preg_match('/^informes_caja_\d{4}-\d{2}-\d{2}(_a_\d{4}-\d{2}-\d{2})?_(todos|\d{3})\.zip$/', $archivo, $m)) {
		salir('Archivo inválido');
	}
	if (!$esAdmin && $m[2] !== $bodegaUsuario) {
		salir('No tienes permiso para descargar este archivo');
	}
	$rutaDescarga = $dirBase . '/' . $archivo;
	if (!is_file($rutaDescarga)) {
		salir('El archivo no existe');
	}
	header('Content-Type: application/zip');
	header('Content-Disposition: attachment; filename="'.$archivo.'"');
	header('Content-Length: ' . filesize($rutaDescarga));
	readfile($rutaDescarga);
	exit;
}

// ---------------------------------------------------------------------------
// Formulario
// ---------------------------------------------------------------------------
function fechaValida($f) {
	if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $f, $p)) {
		return false;
	}
	return checkdate((int)$p[2], (int)$p[3], (int)$p[1]);
}

if ($fechaHasta === '') {
	$fechaHasta = $fechaDesde; // un solo día
}

if (!fechaValida($fechaDesde) || !fechaValida($fechaHasta)) {
	if ($esCli) {
		exit("Uso: php generarInformesCaja.php AAAA-MM-DD [AAAA-MM-DD] [bodega]\n");
	}
	abrirPagina();
	$ayer = date('Y-m-d', strtotime('-1 day'));
	echo '
		<form action="" method="GET" id="horizontalForm">
			<fieldset>
				<legend>Seleccionar local y rango de fechas</legend>
				<label class="first">
					Local';
	if ($esAdmin) {
		echo '
					<select name="modulo" style="width:150px;">
						<option value="">Todos los locales</option>';
		foreach ($modulosSelect as $codigo => $nombre) {
			echo '<option value="'.$codigo.'">'.$nombre.'</option>';
		}
		echo '</select>';
	} else {
		$nombreModulo = isset($modulos[$bodegaUsuario]) ? $modulos[$bodegaUsuario] : $bodegaUsuario;
		echo '<span class="moduloFijo">'.htmlspecialchars($nombreModulo).' (todas las cajas)</span>';
	}
	echo '
				</label>
				<label class="first">
					Desde
					<input type="date" name="desde" value="'.$ayer.'" required />
				</label>
				<label class="first">
					Hasta
					<input type="date" name="hasta" value="'.$ayer.'" required />
				</label>
				<input type="submit" class="submit" value="Generar informes" />
			</fieldset>
		</form>
		<p class="nota">Se genera un PDF por cada caja con ventas en cada día del rango y se entregan en un archivo ZIP, con una carpeta por fecha. Máximo '.$maxDias.' días por descarga.</p>';
	exit;
}

if ($fechaHasta < $fechaDesde) {
	salir('La fecha "hasta" no puede ser anterior a la fecha "desde".');
}
$diasRango = (int)round((strtotime($fechaHasta) - strtotime($fechaDesde)) / 86400) + 1;
if ($diasRango > $maxDias) {
	salir('El rango no puede superar '.$maxDias.' días (pediste '.$diasRango.').');
}

if (!$esCli) {
	// Enviar el avance al navegador a medida que se genera
	@ini_set('zlib.output_compression', '0');
	@ini_set('implicit_flush', '1');
	while (ob_get_level() > 0) {
		ob_end_flush();
	}
}

// ---------------------------------------------------------------------------
// Log y carpeta de salida
// ---------------------------------------------------------------------------
$logArchivo = null;
function mensaje($txt, $clase = '') {
	global $esCli, $logArchivo;
	if ($logArchivo) {
		file_put_contents($logArchivo, date('Y-m-d H:i:s').'  '.$txt."\n", FILE_APPEND);
	}
	if ($esCli) {
		echo $txt."\n";
	} else {
		if ($clase === '') {
			$clase = (strpos($txt, 'ERROR') !== false) ? 'error' : ((strpos(ltrim($txt), 'OK ') === 0) ? 'ok' : '');
		}
		echo '<div class="'.$clase.'">'.htmlspecialchars($txt, ENT_QUOTES, 'UTF-8')."</div>\n";
		flush();
	}
}

require_once($raiz . '/clases/fpdf/fpdf.php');

if (!is_dir($dirBase) && !@mkdir($dirBase, 0777, true)) {
	salir('No se pudo crear la carpeta '.htmlspecialchars($dirBase).' (revisar permisos)');
}
$logArchivo = $dirBase . '/log.txt';
$sufijo = ($filtroBodega === '') ? 'todos' : $filtroBodega;

if (!$esCli) {
	abrirPagina();
	echo str_repeat(' ', 1024); // algunos navegadores no muestran nada hasta recibir 1KB
	echo '<div class="log">';
	$logAbierto = true;
}

$rangoTexto = ($fechaDesde == $fechaHasta) ? $fechaDesde : $fechaDesde.' a '.$fechaHasta;
$localTexto = ($filtroBodega === '') ? 'todos' : (isset($modulos[$filtroBodega]) ? $modulos[$filtroBodega] : '?').' ('.$filtroBodega.')';
mensaje('Inicio generación informes de caja '.$rangoTexto.' - local: '.$localTexto.($usuarioSesion ? ' - usuario: '.$usuarioSesion : ''));

require_once($raiz . '/clases/conexionocdb.php');
mensaje('Conectado a la base de datos');

$usuario = $usuarioSesion;
$inicioTodo = microtime(true);

// ---------------------------------------------------------------------------
// Funciones de armado del informe
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
 * Consulta en UNA sola pasada todos los documentos del local en el rango.
 * Antes se hacía una consulta por caja y por día, más 6 consultas de folio anterior
 * y 6 subconsultas por cada documento; ahora los pagos se agrupan una vez y el resto
 * se arma en PHP.
 */
function consultarDocumentos($conn, $bodega, $fechaDesde, $fechaHasta) {
	$baseSap = ($bodega == '000')
		? "SBO_Inv_Servimex.dbo.OINV"
		: "[SAPSQL.DHN.CL].[SBO_Imp_Eximben_SAC].[dbo].OINV";

	$sql = "
		SELECT
			CONVERT(CHAR(10), T1.FechaDocto, 120) as Dia,
			T1.WorkStation,
			T1.TipoDocto,
			T1.NumeroDocto,
			CASE WHEN T3.DocNum IS NULL THEN 'Pendiente' ELSE CONVERT(CHAR(10),T3.DocNum) END as DocNum,
			T1.Total,
			ISNULL(P.Monto_Cash,0) as Monto_Cash,
			ISNULL(P.Monto_DebitCard,0) as Monto_DebitCard,
			ISNULL(P.Monto_CreditCard,0) as Monto_CreditCard,
			ISNULL(P.Monto_Check,0) as Monto_Check,
			ISNULL(P.Monto_Payments,0) as Monto_Payments,
			ISNULL(P.Monto_StoreCredit,0) as Monto_StoreCredit
		FROM RP_VICENCIO.dbo.RP_ReceiptsCab_SAP as T1
		LEFT JOIN (
			SELECT
				P1.ID,
				SUM(CASE WHEN P1.TipoPago = 'Cash' THEN P1.Monto ELSE 0 END) as Monto_Cash,
				SUM(CASE WHEN P1.TipoPago IN ('DebitCard','GNDeb') THEN P1.Monto ELSE 0 END) as Monto_DebitCard,
				SUM(CASE WHEN P1.TipoPago IN ('CreditCard','GNCred') THEN P1.Monto ELSE 0 END) as Monto_CreditCard,
				SUM(CASE WHEN P1.TipoPago = 'Check' THEN P1.Monto ELSE 0 END) as Monto_Check,
				SUM(CASE WHEN P1.TipoPago = 'Payments' THEN P1.Monto ELSE 0 END) as Monto_Payments,
				SUM(CASE WHEN P1.TipoPago = 'CreditStore' THEN P1.Monto ELSE 0 END) as Monto_StoreCredit
			FROM RP_VICENCIO.dbo.RP_ReceiptsPagos_SAP as P1
			INNER JOIN RP_VICENCIO.dbo.RP_ReceiptsCab_SAP as C1 ON C1.ID = P1.ID
			WHERE C1.FechaDocto > '".$fechaDesde." 00:00:00' AND
				  C1.FechaDocto < '".$fechaHasta." 23:59:59' AND
				  C1.Bodega = '".$bodega."'
			GROUP BY P1.ID
		) as P ON T1.ID = P.ID
		LEFT JOIN ".$baseSap." T3 ON T1.BaseEntry = T3.DocEntry
		WHERE
			T1.FechaDocto > '".$fechaDesde." 00:00:00' AND
			T1.FechaDocto < '".$fechaHasta." 23:59:59' AND
			T1.Bodega = '".$bodega."' AND
			T1.TipoDocto <> '99'
		ORDER BY Dia, T1.WorkStation, T1.TipoDocto, T1.NumeroDocto ASC
	";

	$rs = odbc_exec($conn, $sql);
	if (!$rs) {
		return false;
	}

	// [dia][workstation][] = documento
	$docs = array();
	while ($r = odbc_fetch_array($rs)) {
		$docs[$r['Dia']][trim($r['WorkStation'])][] = $r;
	}
	return $docs;
}

/*
 * Último folio de cada día / caja / tipo de documento, en una sola consulta.
 * Se incluye el día anterior al rango para poder comparar el primer día.
 */
function consultarUltimosFolios($conn, $bodega, $fechaDesde, $fechaHasta) {
	$diaAnterior = date('Y-m-d', strtotime($fechaDesde.' -1 day'));
	$sql = "
		SELECT
			CONVERT(CHAR(10), FechaDocto, 120) as Dia,
			WorkStation,
			TipoDocto,
			MAX(NumeroDocto) as Ultimo
		FROM RP_VICENCIO.dbo.RP_ReceiptsCab_SAP
		WHERE FechaDocto > '".$diaAnterior." 00:00:00' AND
			  FechaDocto < '".$fechaHasta." 23:59:59' AND
			  Bodega = '".$bodega."'
		GROUP BY CONVERT(CHAR(10), FechaDocto, 120), WorkStation, TipoDocto
	";
	$rs = odbc_exec($conn, $sql);
	if (!$rs) {
		return false;
	}
	$ultimos = array();
	while ($r = odbc_fetch_array($rs)) {
		$ultimos[$r['Dia']][trim($r['WorkStation'])][trim($r['TipoDocto'])] = $r['Ultimo'];
	}
	return $ultimos;
}

/*
 * Replica la lógica de filas de reporteCajaCont.php (subtotales por tipo,
 * saltos de folio y totales con descuento de notas de crédito).
 * $ultimosDiaAnterior = array(tipoDocto => último folio del día anterior)
 */
function construirFilas($documentos, $ultimosDiaAnterior) {
	$filas = array();
	$acum = array('Total' => 0, 'Monto_Cash' => 0, 'Monto_DebitCard' => 0, 'Monto_CreditCard' => 0, 'Monto_Check' => 0, 'Monto_Payments' => 0, 'Monto_StoreCredit' => 0);
	$sub = $acum;
	$nc = array('Total' => 0, 'Monto_Cash' => 0, 'Monto_StoreCredit' => 0);
	$numeroDoctoAnt = "";
	$tipoDoctoAnt = "";
	$tipoDoctoAnte = "";
	$primeraFila = true;

	foreach ($documentos as $r) {
		if ($tipoDoctoAnt != "" && $tipoDoctoAnt != $r['TipoDocto']) {
			$numeroDoctoAnt = "";
		}

		// Salto de folio respecto al último documento del día anterior (solo primera fila, igual que el reporte)
		if ($primeraFila) {
			$t = trim($r['TipoDocto']);
			if (isset($ultimosDiaAnterior[$t]) && ($r['NumeroDocto'] - 1) != $ultimosDiaAnterior[$t]) {
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
// Locales a procesar
// ---------------------------------------------------------------------------
if ($filtroBodega !== '') {
	$bodegas = array($filtroBodega);
} else {
	$sqlBodegas = "
		SELECT DISTINCT Bodega
		FROM RP_VICENCIO.dbo.RP_ReceiptsCab_SAP
		WHERE FechaDocto > '".$fechaDesde." 00:00:00' AND
			  FechaDocto < '".$fechaHasta." 23:59:59' AND
			  TipoDocto <> '99'
		ORDER BY Bodega
	";
	$rsBodegas = odbc_exec($conn, $sqlBodegas);
	if (!$rsBodegas) {
		mensaje('ERROR en la consulta de locales: '.odbc_errormsg($conn));
		exit;
	}
	$bodegas = array();
	while ($r = odbc_fetch_array($rsBodegas)) {
		$bodegas[] = trim($r['Bodega']);
	}
}

// ---------------------------------------------------------------------------
// Generación
// ---------------------------------------------------------------------------
$generados = array(); // ruta => nombre dentro del ZIP
foreach ($bodegas as $bodega) {
	$moduloNombre = isset($modulos[$bodega]) ? $modulos[$bodega] : $bodega;
	mensaje('Local '.$moduloNombre.' ('.$bodega.')', 'dia');

	$inicioConsulta = microtime(true);
	$docsPorDia = consultarDocumentos($conn, $bodega, $fechaDesde, $fechaHasta);
	if ($docsPorDia === false) {
		mensaje('  ERROR SQL en documentos del local '.$moduloNombre.': '.odbc_errormsg($conn));
		continue;
	}
	$ultimos = consultarUltimosFolios($conn, $bodega, $fechaDesde, $fechaHasta);
	if ($ultimos === false) {
		mensaje('  ERROR SQL en folios del local '.$moduloNombre.': '.odbc_errormsg($conn));
		continue;
	}
	mensaje('  Datos leídos en '.round(microtime(true) - $inicioConsulta, 1).' s');

	if (count($docsPorDia) == 0) {
		mensaje('  Sin ventas en el rango');
		continue;
	}

	ksort($docsPorDia);
	foreach ($docsPorDia as $dia => $cajas) {
		$dirDia = $dirBase . '/' . $dia;
		if (!is_dir($dirDia) && !@mkdir($dirDia, 0777, true)) {
			mensaje('  ERROR: no se pudo crear la carpeta '.$dirDia);
			continue;
		}
		$diaAnterior = date('Y-m-d', strtotime($dia.' -1 day'));

		ksort($cajas);
		foreach ($cajas as $workstation => $documentos) {
			$inicioCaja = microtime(true);
			$ultimosCaja = isset($ultimos[$diaAnterior][$workstation]) ? $ultimos[$diaAnterior][$workstation] : array();
			$filas = construirFilas($documentos, $ultimosCaja);

			$nombre = 'reporte caja '.$dia.' modulo '.$moduloNombre.' ('.$bodega.') caja '.$workstation.'.pdf';
			$ruta = $dirDia . '/' . $nombre;
			generarPdf($filas, $dia, $moduloNombre, $workstation, $usuario, $ruta);
			$generados[$ruta] = ($fechaDesde == $fechaHasta) ? $nombre : $dia.'/'.$nombre;

			mensaje('  OK '.$nombre.' ('.round(microtime(true) - $inicioCaja, 1).' s)');
		}
	}
}
odbc_close($conn);

if (count($generados) == 0) {
	mensaje('No se generó ningún informe: no hay ventas en el rango '.$rangoTexto);
	exit;
}

// ---------------------------------------------------------------------------
// ZIP
// ---------------------------------------------------------------------------
$nombreZip = 'informes_caja_' . $fechaDesde . (($fechaDesde == $fechaHasta) ? '' : '_a_'.$fechaHasta) . '_' . $sufijo . '.zip';
$rutaZip = $dirBase . '/' . $nombreZip;
$zip = new ZipArchive();
if ($zip->open($rutaZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
	mensaje('ERROR: no se pudo crear el ZIP '.$rutaZip);
	exit;
}
foreach ($generados as $ruta => $nombreEnZip) {
	$zip->addFile($ruta, $nombreEnZip);
}
$zip->close();

mensaje(count($generados).' PDF generados en '.round(microtime(true) - $inicioTodo, 1).' s');
mensaje('ZIP: '.$rutaZip);

if (!$esCli) {
	$logAbierto = false;
	echo '</div>
		<div class="acciones">
			<a class="boton" href="?descargar='.rawurlencode($nombreZip).'">Descargar '.$nombreZip.'</a>
			&nbsp;&nbsp;<a class="volver" href="generarInformesCaja.php">Generar otro rango</a>
		</div>';
}
