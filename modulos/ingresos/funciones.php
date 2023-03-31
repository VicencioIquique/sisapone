<?php   
    session_start();
    require_once("../../clases/conexionocdb.php");

    //ini_set('max_execution_time', 600); //300 seconds = 5 minutes    
    
    $controlador = $_POST['controlador'];
    
    if($controlador == "buscar"){

        $codzetap = $_POST['data'][0]['zet'];
        $anop = $_POST['data'][1]['ano'];

        //echo "Buscando ingresos de Zeta al registro. \n";
        $sql = "SELECT TOP 1 (numZeta) as conteo FROM [RP_VICENCIO].[dbo].[Ingreso_Mercaderia] 
        WHERE numZeta = '101-".$anop."-".$codzetap."';";
        
        $rs = odbc_exec( $conn, $sql );
        
        $resultado = odbc_fetch_row($rs);
        $largo = $resultado.count();

        if($largo >= 1){ 
            echo "ok";

        }else if($largo == 0){
            //echo "No hay registros. \n";
            
            $sql2= "SELECT t1.U_Lote AS Item, 
                            t1.U_ItemCode AS Codigo, 
                            t3.ItemName AS Descripcion,
                            t3.U_ZF_MODELO AS Referencia,
                            FLOOR(t1.U_Quantity) AS Cantidad
            FROM [SBO_Imp_Eximben_SAC].[dbo].[@SVE3] AS t1
            RIGHT JOIN [SBO_Imp_Eximben_SAC].[dbo].[@OSVE] AS t2 ON t1.DocEntry = t2.DocEntry
            INNER JOIN [SBO_Imp_Eximben_SAC].[dbo].[OITM] AS t3 ON t3.ItemCode = t1.U_ItemCode
            WHERE t2.U_NUMVIS = '".$codzetap."'
            AND YEAR(t2.CreateDate) = '20".$anop."'
            ORDER BY VisOrder;";
            
            $rs2 = odbc_exec( $conn, $sql2 );

            $cadena = "";
            
            $resultado2 = odbc_fetch_row($rs2);
            $largo2 = $resultado2.count();
    
            if($largo2 == 0){ 
                echo "error2";
                exit;
            }else if($largo2 >= 1){
                //echo "Obteniendo datos del Zeta. \n";

                while($resultado2 = odbc_fetch_array($rs2)){
                    //Quitando comillas simples a las descripciones.
                    $descripcion = str_replace("'","_",$resultado2["Descripcion"]);
                    
                    $sqlString = ("('101-".$anop."-".$codzetap."',
                    '".$resultado2["Codigo"]."',
                    '',
                    '".$descripcion."',
                    0,0,0,0,
                    ".$resultado2["Cantidad"]."
                    ,0,0,0,0,'',0,'',
                    ".$resultado2["Item"].",
                    ".$resultado2["Referencia"].",
                    ''),");
                    $cadena .= $sqlString;
                }

                $cadena = trim($cadena, ',');

                //echo "Traspasando datos en tabla Ingreso_Mercaderia. \n";

                $sql3 = "INSERT INTO RP_VICENCIO.dbo.Ingreso_Mercaderia
                        (numZeta
                        ,codigoZeta
                        ,codigoFisico
                        ,descripcion
                        ,cantCajas
                        ,uniPorCaja
                        ,uniSueltas
                        ,total
                        ,uniFacturadas
                        ,uniFaltantes
                        ,uniSobrantes
                        ,uniMalEstado
                        ,uniFisicas
                        ,numLoteProd
                        ,docNum
                        ,ubicacion
                        ,itemZeta
                        ,referencia
                        ,revision)
                        VALUES ".$cadena.";";
                $rs3 = odbc_exec( $conn, $sql3 );

                if(!$rs3){
                    echo "error3";
                    exit;
                }else{
                    echo "ok";
                }

            }

        }else if(!$rs){
            echo "error1";
            exit;
        }

    }else if($controlador == "cargar"){

        $codzetap = $_POST['data'][0]['zet'];
        $anop = $_POST['data'][1]['ano'];
        
        $sql4 = "SELECT [idIngresoMercaderia] as id
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
        ,[referencia] as ref
        ,[ubicacion] as ubi
        FROM [RP_VICENCIO].[dbo].[Ingreso_Mercaderia] 
        WHERE numZeta = '101-".$anop."-".$codzetap."';";
        //echo $sql4;
        $rs4 = odbc_exec( $conn, $sql4 );
        
        if(!$rs4){
            echo "error4";
            exit;
        }else{
            
            $conteo = odbc_num_rows($rs4); 
            $arreglo = array();
            $data = array();
            $i = 0;

            while($resultado4 = odbc_fetch_array($rs4)){

                $cadena = preg_replace("/[^a-zA-Z0-9:_+ ,.ñÑ]/", "/", $resultado4["dsc"]);            
                
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
                                ,"refe" => $resultado4["ref"]
                                ,"ubic" => $resultado4["ubi"]
                );
            }
            //echo $arreglo;
            echo json_encode($data); 
        }
    }else if($controlador == "actualizarConteo"){

        $cantCajas = $_POST['data'][0]['dcajas'];
        $uniPorCaja = $_POST['data'][1]['duxcaja'];
        $uniSueltas = $_POST['data'][2]['dusueltas'];
        $uniFaltantes = $_POST['data'][3]['dufaltantes'];
        $uniSobrantes = $_POST['data'][4]['dsobrantes'];
        $uniMalEstado = $_POST['data'][5]['dmalas'];
        $codzetap = $_POST['data'][6]['idproducto'];
        $codigoProducto = $_POST['data'][7]['codigoP'];
        $numLote = $_POST['data'][8]['numLote'];
        $uniFisicas = $_POST['data'][9]['totalConteo'];
        $revision = $_SESSION["usuario_user"];
        
        $sql5 = "UPDATE RP_VICENCIO.dbo.Ingreso_Mercaderia 
                        SET codigoFisico = '".$codigoProducto."',
                        cantCajas = ".$cantCajas.",
                        uniPorCaja = ".$uniPorCaja.",
                        uniSueltas = ".$uniSueltas.",
                        total = ".$uniFisicas.",
                        uniFaltantes = ".$uniFaltantes.",
                        uniSobrantes = ".$uniSobrantes.",
                        uniMalEstado = ".$uniMalEstado.",
                        uniFisicas = ".$uniFisicas.",
                        numLoteProd = '".$numLote."',
                        revision  = '".$revision."'
                        WHERE idIngresoMercaderia = ".$codzetap.";";

        $rs5 = odbc_exec( $conn, $sql5 );

        if(!$rs5){
            echo "error5";
            exit;
        }else{
            echo 1;
        }

    }else if($controlador == "actualizarUbicacion"){

        $ubicacion = $_POST['data'][0]['ubicacion'];
        $item = $_POST['data'][1]['idproducto'];


        $sql6 = "UPDATE RP_VICENCIO.dbo.Ingreso_Mercaderia 
                        SET ubicacion  = '".$ubicacion."'
                        WHERE idIngresoMercaderia = ".$item.";";

        $rs6 = odbc_exec( $conn, $sql6 );

        if(!$rs6){
            echo "error6";
            exit;
        }else{
            echo 1;
        }

    }elseif($controlador == 'limpiar'){

        $item = $_POST['item'];
        $sql7 = "UPDATE [RP_VICENCIO].[dbo].[Ingreso_Mercaderia] SET
            [cantCajas] = 0
            ,[uniPorCaja] = 0
            ,[uniSueltas] = 0
            ,[total] = 0
            ,[uniFaltantes] = 0
            ,[uniSobrantes] = 0
            ,[uniMalEstado] = 0
            ,[uniFisicas] = 0
            ,codigoFisico = ''
            ,numLoteProd = ''
            ,ubicacion = ''
        where idIngresoMercaderia = ".$item.";";
        $rs7 = odbc_exec( $conn, $sql7 );
        
        if(!$rs7){
            echo "error7";
            exit;
        }else{
            echo 1;
        }
    }
                                 
    odbc_close( $conn );
    
?>