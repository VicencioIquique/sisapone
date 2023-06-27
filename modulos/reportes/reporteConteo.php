<?php   
    session_start();
    require_once("../../clases/conexionocdb.php");
    
    $controlador = $_POST['controlador'];
    
    if($controlador == "cargar")

        $codzetap = $_POST['data'][0]['zet'];
        $anop = $_POST['data'][1]['ano'];
        
        $sql = "SELECT [idIngresoMercaderia] as id
        ,[itemZeta] as itm
        ,[codigoZeta] as cze
        ,[codigoFisico] as cfi
        ,[descripcion] as dsc
        ,[uniFacturadas] as ufa
        ,[cantCajas] as cca
        ,[uniPorCaja] as uca
        ,[uniSueltas] as usu
        ,[total] as ttl
        ,[uniFaltantes] as ufl
        ,[uniSobrantes] as uso
        ,[uniMalEstado] as uma
        ,[numLoteProd] as lot
        ,[revision] as rev
        ,[referencia] as ref
        ,[ubicacion] as ubi
        FROM [RP_VICENCIO].[dbo].[Ingreso_Mercaderia] 
        WHERE numZeta = '101-".$anop."-".$codzetap."';";
        //echo $sql4;
        $rs = odbc_exec( $conn, $sql );
        
        if(!$rs){
            echo "error";
            exit;
        }else{
            
            $conteo = odbc_num_rows($rs); 
            $arreglo = array();
            $data = array();
            $i = 0;

            while($resultado = odbc_fetch_array($rs4)){

                $cadena = preg_replace("/[^a-zA-Z0-9:_+ ,.ñÑ]/", "/", $resultado["dsc"]);            
                
                $data[] = array(
                                "id" => $resultado4["id"]
                                ,"item" => $resultado4["itm"]
                                ,"codZ" => $resultado4["cze"]
                                ,"codF" => $resultado4["cfi"]
                                ,"desc" => $cadena
                                ,"uniF" => $resultado4["ufa"]
                                ,"caja" => $resultado4["cca"]
                                ,"ucaj" => $resultado4["uca"]
                                ,"suel" => $resultado4["usu"]
                                ,"totl" => $resultado4["ttl"]
                                ,"falt" => $resultado4["ufl"]
                                ,"sobr" => $resultado4["uso"]
                                ,"mala" => $resultado4["uma"]
                                ,"lote" => $resultado4["lot"]
                                ,"revi" => $resultado4["rev"]
                                ,"refe" => $resultado4["ref"]
                                ,"ubic" => $resultado4["ubi"]
                );
            }
            //echo $arreglo;
            echo json_encode($data); 
        }
    
                                 
    odbc_close( $conn );
    
?>