<?php
//#####################################//
//INFORME DESARROLLADO POR JULIO CORTES//
//#####PARA EXIMBEN SAC 26/09/2013####//
//#####################################//
require('../../clases/fpdf/fpdf.php'); // libreria para generar pdf
require_once("../../clases/conexionocdb.php"); // conexion con obcd driver
require_once("../../clases/funciones.php"); // funciones propias
ini_set('max_execution_time', 300); // Forzar más tiempo de ejecucion

//Recibo los parametros desde la url
(INT)$modulo = $_GET['modulo'];
$finicio = $_GET['inicio'];
$ffin =  $_GET['fin'];
$idsol =  $_GET['idsol'];

 function cambiarFecha($fecha) // funcion para cambiar el formato de la fecha y orden
 {
	 return implode("-", array_reverse(explode("-", $fecha)));
 }					
	$date = strtotime($finicio);
	$finicio2 = cambiarFecha($finicio);
	$ffin2 = cambiarFecha($ffin);
	
	
	
	 
$sql="SELECT  [solicitud_id]
      ,[estado]
      , CONVERT(varchar, [fecha_crea], 103)as Fecha
      ,[fecha_estado]
      ,[cantidad_total]
      ,[modulo]
      ,[vendedor_id]
      ,[recepcion_id]
  FROM [RP_REGGEN].[dbo].[sisap_solicitudes]
             
 WHERE [solicitud_id]  =	".$idsol."	 ";
 
 	$rs = odbc_exec( $conn, $sql );
							if ( !$rs )
							{
							exit( "Error en la consulta SQL" );
							}

							  while($resultado = odbc_fetch_array($rs)){ 
							  
							  	$fechacrea = $resultado["Fecha"];
								$modulo	 = $resultado["modulo"];
								$vendedor = $resultado["vendedor_id"];
								$recepcion = $resultado["recepcion_id"];
							  
							  }

	 

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

/********** ZOFRI S.A. **************/
$pdf->SetFillColor(68,68,68);
$pdf->SetDrawColor(0,0,255);
$pdf->SetTextColor(255,255,255);
$pdf->SetXY(9, 8);//posicion 
$pdf->SetFont('Helvetica','B',12); // tamaño fuente header
$pdf->Cell(0,10,' SOLICITUD DE PRODUCTOS '.strtoupper(getmoduloAir($modulo)).'                                                             '.$fechacrea,0,0,'L','true');
$pdf->SetFillColor(0,0,0);
$pdf->SetDrawColor(0,0,0);
$pdf->SetTextColor(0,0,0);
/********** Fin Zofri del header **************/
$pdf->SetFont('Helvetica','B',9);
$pdf->SetXY(9, 19);//posicion dia
    $pdf->Cell(0,5,utf8_decode('Número Solicitud: '.$idsol),0,1);// dia
	
$pdf->SetXY(65, 19);//posicion dia
$pdf->Cell(0,5,utf8_decode('Solicitante: '.getusuario($vendedor)),0,1);// dia


$pdf->SetXY(145, 19);//posicion dia
$pdf->Cell(0,5,utf8_decode('Válida: '.getusuario($recepcion)),0,1);// dia
	
$caby = 20;

//Fields Name position
$Y_Fields_Name_position = 30;
//Table position, under Fields Name
$Y_Table_Position =36;




/**************************************************************************************** SEGUNDA HOJA******************************************************/

$sql3=" SELECT       [RP_REGGEN].dbo.sisap_soldetalle.detalle_id,   [RP_REGGEN].dbo.sisap_soldetalle.descripcion,   [RP_REGGEN].dbo.sisap_soldetalle.marca,   [RP_REGGEN].dbo.sisap_soldetalle.stock_modulo, 
                        [RP_REGGEN].dbo.sisap_soldetalle.cant_solicitada,   [RP_REGGEN].dbo.sisap_soldetalle.cant_aceptada,   [RP_REGGEN].dbo.sisap_soldetalle.solicitud_id,   [RP_REGGEN].dbo.sisap_soldetalle.codigo 
                     
FROM         [RP_REGGEN].[dbo].[sisap_soldetalle]
WHERE     (  [RP_REGGEN].dbo.sisap_soldetalle.solicitud_id = ".$idsol.") ";

		
			
		//echo $sql3;	
		$rs3 = odbc_exec( $conn, $sql3 );
		if ( !$rs3 )
		{
		exit( "Error en la consulta SQL" );
		}
						  
				$Y_Fields_Name_position =  27;

				$Y_Table_Position = 27;
				
				
				$pdf->SetFillColor(232,232,232);
				
				//Cabecera
				$pdf->SetFont('Arial','B',8);
				$pdf->SetY($Y_Fields_Name_position);
				$pdf->SetX(9);
				$pdf->Cell(25,6,utf8_decode('Código'),1,0,'C',1);
				$pdf->SetX(34);
				$pdf->Cell(125,6,utf8_decode('Descripción'),1,0,'C',1);
				$pdf->SetX(145);
				$pdf->Cell(10,6,'Cant/P',1,0,'C',1);
				$pdf->SetX(155);
				$pdf->Cell(10,6,'13-1',1,0,'C',1);
				$pdf->SetX(165);
				$pdf->Cell(10,6,'14-6',1,0,'C',1);
				$pdf->SetX(175);
				$pdf->Cell(10,6,'13-6',1,0,'C',1);
				$pdf->SetX(185);
				$pdf->Cell(10,6,'17SZ',1,0,'C',1);
				$pdf->SetX(195);
				$pdf->Cell(10,6,'1623',1,0,'C',1);
				
				$pdf->Ln();
				$saltador=0;
				while($row = odbc_fetch_array($rs3)){ 
					
					if($saltador==35){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}	
					if($saltador==70){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==105){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==140){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==175){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==210){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==245){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==280){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==315){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==350){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==385){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==420){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==455){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==490){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==525){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==560){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==595){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==630){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==665){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==700){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==735){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==770){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==805){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==840){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==875){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==910){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==945){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==980){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==1015){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==1050){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==1085){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==1120){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==1155){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==1190){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==1225){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==1260){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==1295){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					if($saltador==1330){
					$pdf->AddPage('P','Letter');
					$Y_Table_Position = 15;}
					
					$bod = explode("-",getBodegaStock($row["codigo"]));
					$Y_Table_Position =$Y_Table_Position+ 6;
					$pdf->SetFont('Arial','',8);
					$pdf->SetY($Y_Table_Position);
					$pdf->SetX(9);
					$pdf->Cell(25,6,$row["codigo"],1,0,'C',0);
					$pdf->SetY($Y_Table_Position);
					$pdf->SetX(34);
					$pdf->SetFont('Arial','',6.5);
					$pdf->Cell(125,6,utf8_decode($row["descripcion"]),1,0,'L',0);
					$pdf->SetFont('Arial','',8);
					$pdf->SetY($Y_Table_Position);
					$pdf->SetX(145);
					$pdf->Cell(10,6,$row["cant_aceptada"],1,0,'C',0);
					$pdf->SetX(155);
					$pdf->Cell(10,6,$bod[0],1,0,'C',1);
					$pdf->SetX(165);
					$pdf->Cell(10,6,$bod[1],1,0,'C',1);
					$pdf->SetX(175);
					$pdf->Cell(10,6,$bod[2],1,0,'C',1);
					$pdf->SetX(185);
					$pdf->Cell(10,6,$bod[3],1,0,'C',1);
					$pdf->SetX(195);
					$pdf->Cell(10,6,$bod[4],1,0,'C',1);
				
				
					$pdf->Ln();
					$saltador++;
				 }//fin while de la tabla detalles cheques


$pdf->Output();

?>