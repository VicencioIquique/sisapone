<?php
//#####################################//
//INFORME DESARROLLADO POR JULIO CORTES//
//#####PARA EXIMBEN SAC 26/09/20013####//
//#####################################//
require('../../clases/fpdf/fpdf.php'); // libreria para generar pdf
require_once("../../clases/conexionocdb.php"); // conexion con obcd driver
ini_set('max_execution_time', 300); // Forzar más tiempo de ejecucion
$codbarra = $_REQUEST['codBarra'];
$lote = $_REQUEST['lote'];

$sql= "SELECT    ItemName
FROM     SBO_Imp_Eximben_SAC..OITM 
WHERE   ItemCode = '".$codbarra."' ";

$rs = odbc_exec( $conn, $sql );
	if ( !$rs )
	{
		exit( "Error en la consulta SQL" );
	}

	$arr = odbc_fetch_array($rs);
	
	$descripcion = $arr['ItemName'];
					
$pdf=new FPDF();
$pdf->AddPage();

class PDF extends FPDF
{


//pie de pagina
function Footer()
	{
		//Position at 1.5 cm from bottom
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//Page number
		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
			$this->setX(10);
			 $this->Cell(0,10,'Reportes',0,0,'L');
			 $this->Image('logoSISAP.jpg',12,258,9,9);
	}
}

//Instanciation of inherited class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','Letter');  
$pdf->SetFont('Times','',12);



	
$caby = 12;


	
	$caby = $caby+0;
	$cabx = 6;
	
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',20);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,$codbarra,0,'C','false');
	
	$caby = $caby+8;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',12);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,5, $descripcion,0,'C','false');

	$caby = $caby+13;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',18);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,'LOTE - '.$lote,0,'C','false');
	
	
	$caby = $caby+20;
	$cabx = 6;
	
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',20);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,$codbarra,0,'C','false');
	
	$caby = $caby+8;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',12);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,5, $descripcion,0,'C','false');

	$caby = $caby+13;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',18);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,'LOTE - '.$lote,0,'C','false');
	
	$caby = $caby+20;
	$cabx = 6;
	
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',20);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,$codbarra,0,'C','false');
	
	$caby = $caby+8;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',12);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,5, $descripcion,0,'C','false');

	$caby = $caby+13;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',18);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,'LOTE - '.$lote,0,'C','false');
	
	$caby = $caby+20;
	$cabx = 6;
	
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',20);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,$codbarra,0,'C','false');
	
	$caby = $caby+8;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',12);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,5, $descripcion,0,'C','false');

	$caby = $caby+13;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',18);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,'LOTE - '.$lote,0,'C','false');
	
	
	$caby = $caby+20;
	$cabx = 6;
	
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',20);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,$codbarra,0,'C','false');
	
	$caby = $caby+8;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',12);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,5, $descripcion,0,'C','false');

	$caby = $caby+13;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',18);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,'LOTE - '.$lote,0,'C','false');
	
	
	$caby = $caby+20;
	$cabx = 6;
	
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',20);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,$codbarra,0,'C','false');
	
	$caby = $caby+8;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',12);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,5, $descripcion,0,'C','false');

	$caby = $caby+13;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',18);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,'LOTE - '.$lote,0,'C','false');
	
/****** lado derecho ************/
	$caby=12;
	$caby = $caby+0;
	$cabx = 110;
	
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',20);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,$codbarra,0,'C','false');
	
	$caby = $caby+8;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',12);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,5, $descripcion,0,'C','false');

	$caby = $caby+13;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',18);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,'LOTE - '.$lote,0,'C','false');
	
	$caby = $caby+20; /*  parte otro */

	
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',20);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,$codbarra,0,'C','false');
	
	$caby = $caby+8;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',12);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,5, $descripcion,0,'C','false');

	$caby = $caby+13;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',18);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,'LOTE - '.$lote,0,'C','false');
	
	$caby = $caby+20; /*  parte otro */

	
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',20);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,$codbarra,0,'C','false');
	
	$caby = $caby+8;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',12);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,5, $descripcion,0,'C','false');

	$caby = $caby+13;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',18);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,'LOTE - '.$lote,0,'C','false');
	
	$caby = $caby+20; /*  parte otro */

	
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',20);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,$codbarra,0,'C','false');
	
	$caby = $caby+8;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',12);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,5, $descripcion,0,'C','false');

	$caby = $caby+13;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',18);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,'LOTE - '.$lote,0,'C','false');
	
	$caby = $caby+20; /*  parte otro */

	
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',20);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,$codbarra,0,'C','false');
	
	$caby = $caby+8;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',12);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,5, $descripcion,0,'C','false');

	$caby = $caby+13;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',18);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,'LOTE - '.$lote,0,'C','false');
	
	$caby = $caby+20; /*  parte otro */

	
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',20);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,$codbarra,0,'C','false');
	
	$caby = $caby+8;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',12);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,5, $descripcion,0,'C','false');

	$caby = $caby+13;
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',18);
	$pdf->SetY($caby);
	$pdf->SetX($cabx);
	$pdf->MultiCell(100,6,'LOTE - '.$lote,0,'C','false');
	


$pdf->Output();

?>