<?php
//#####################################//
//INFORME DESARROLLADO POR JULIO CORTES//
//#####PARA EXIMBEN SAC 26/09/20013####//
//#####################################//
require('../../clases/fpdf/fpdf.php'); // libreria para generar pdf
require_once("../../clases/conexionocdb.php"); // conexion con obcd driver
require_once("../../clases/funciones.php"); // funciones propias
ini_set('max_execution_time', 300); // Forzar más tiempo de ejecucion

//Recibo los parametros desde la url
$modulo = $_GET['modulo'];
$finicio = $_GET['inicio'];
$ffin =  $_GET['fin'];

if(!$finicio)
{
	 $finicio = date("m/d/Y");
	 $ffin= date("m/d/Y");
}


 function cambiarFecha($fecha) // funcion para cambiar el formato de la fecha y orden
 {
	 return implode("-", array_reverse(explode("-", $fecha)));
 }					
	$date = strtotime($finicio);
	$finicio2 = cambiarFecha($finicio);
	$ffin2 = cambiarFecha($ffin);
	 
    $total=$total1=$total2=$total3=$total4=$total5=$total6=$total7 =0;// acumulador
	$cantotal=$cantotal1=$cantotal2=$cantotal3=$cantotal4=$cantotal5=$cantotal6=$cantotal7 =0;//contador
					
			$sql= "SELECT     TOP (100) PERCENT SUM(dbo.RP_ReceiptsPagos_SAP.Monto) AS TOTAL, CONVERT(varchar, dbo.RP_ReceiptsPagos_SAP.FechaDoc, 103) AS fpago, 
                      dbo.RP_ReceiptsPagos_SAP.TipoPago, dbo.RP_ReceiptsPagos_SAP.WorkStation, CONVERT(varchar, dbo.RP_ReceiptsCab_SAP.FechaDocto, 103) AS fcompra, 
                      DATEDIFF(day, dbo.RP_ReceiptsCab_SAP.FechaDocto, dbo.RP_ReceiptsPagos_SAP.FechaDoc) AS Dias, dbo.RP_ReceiptsCab_SAP.RutCliente, 
                      dbo.RP_ReceiptsPagos_SAP.NumeroDoc, DATEDIFF(day,'".$finicio2."', dbo.RP_ReceiptsPagos_SAP.FechaDoc) AS QUEDAN, dbo.RP_ReceiptsCab_SAP.Bodega

FROM         dbo.RP_ReceiptsPagos_SAP INNER JOIN
                      dbo.RP_ReceiptsCab_SAP ON dbo.RP_ReceiptsPagos_SAP.ID = dbo.RP_ReceiptsCab_SAP.ID
WHERE     (dbo.RP_ReceiptsPagos_SAP.TipoDocto NOT LIKE 3) AND (dbo.RP_ReceiptsPagos_SAP.TipoPago LIKE 'Payments') AND 
                      (dbo.RP_ReceiptsPagos_SAP.FechaDoc >= '".$finicio2."') ".$Wmodulo." ".$Wndocto."
GROUP BY dbo.RP_ReceiptsPagos_SAP.TipoDocto, dbo.RP_ReceiptsPagos_SAP.FechaDoc, dbo.RP_ReceiptsPagos_SAP.TipoPago, dbo.RP_ReceiptsPagos_SAP.WorkStation, 
                      dbo.RP_ReceiptsCab_SAP.FechaDocto, dbo.RP_ReceiptsCab_SAP.RutCliente, dbo.RP_ReceiptsPagos_SAP.NumeroDoc, dbo.RP_ReceiptsCab_SAP.Bodega

ORDER BY dbo.RP_ReceiptsCab_SAP.Bodega,dbo.RP_ReceiptsPagos_SAP.FechaDoc, dbo.RP_ReceiptsPagos_SAP.TipoDocto, dbo.RP_ReceiptsPagos_SAP.TipoPago DESC" ;
	
	
							$rs = odbc_exec( $conn, $sql );
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}

							 while($resultado = odbc_fetch_array($rs)){ 
							 
								//	echo (int)$resultado["Bodega"];
									if((int)$resultado["Bodega"] == 1)
									{
										$total1 = $total1 + $resultado["TOTAL"];
										$cantotal1++;
										continue;
									}
									else if((int)$resultado["Bodega"] == 2)
									{
										$total2 = $total2 + $resultado["TOTAL"];
										$cantotal2++;
										continue;
									}
									else if((int)$resultado["Bodega"] == 3)
									{
										$total3 = $total3 + $resultado["TOTAL"];
										$cantotal3++;
										continue;
									}
									else if((int)$resultado["Bodega"] == 4)
									{
										$total4 = $total4 + $resultado["TOTAL"];
										$cantotal4++;
										continue;
									}
									else if((int)$resultado["Bodega"] == 5)
									{
										$total5 = $total5 + $resultado["TOTAL"];
										$cantotal5++;
										continue;
									}
									else if((int)$resultado["Bodega"] == 6)
									{
										$total6 = $total6 + $resultado["TOTAL"];
										$cantotal6++;
										continue;
									}
									else if((int)$resultado["Bodega"] == 7)
									{
										$total7 = $total7 + $resultado["TOTAL"];
										$cantotal7++;
										continue;
									}
									
								}//fin  while	
								$total = $total1+$total2+$total3+$total4+$total5+$total6+$total7;
								$cantotal=$cantotal1+$cantotal2+$cantotal3+$cantotal4+$cantotal5+$cantotal6+$cantotal7;
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
		 $this->Image('logoSISAP.jpg',12,195,9,9);
}
}

//Instanciation of inherited class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('L','Letter');  
$pdf->SetFont('Times','',12);


/********** ZOFRI S.A. **************/
$pdf->SetFillColor(68,68,68);
$pdf->SetDrawColor(0,0,255);
$pdf->SetTextColor(255,255,255);
$pdf->SetXY(9, 8);//posicion 
$pdf->SetFont('Helvetica','B',12); // tamaño fuente header
$pdf->Cell(0,10,' SISAP PRONTO TE SORPRENDERÁ                                                                                                                                 '.date("d").'/'.date("m").'/'.date("Y"),0,0,'L','true');
$pdf->SetFillColor(0,0,0);
$pdf->SetDrawColor(0,0,0);
$pdf->SetTextColor(0,0,0);
/********** Fin Zofri del header **************/

	
$caby = 20;


/********** ZOFRI S.A. **************/
$pdf->SetFillColor(238,238,238);
$pdf->SetDrawColor(0,0,255);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(9, $caby);//posicion 
$pdf->SetFont('Helvetica','B',9); // tamaño fuente header
$pdf->Cell(0,1,'',0,0,'L','true');
$pdf->SetFillColor(0,0,0);
$pdf->SetDrawColor(0,0,0);
$pdf->SetTextColor(0,0,0);
/********** Fin Zofri del header **************/
$pdf->SetFont('Helvetica','B',12); // tamaño fuente header
$caby = $caby+7;
/********** solo fecha del header **************/
	$fecha1 = "26/08/2013";
	$fecha2= "31/08/2013";







$pdf->Output();

?>