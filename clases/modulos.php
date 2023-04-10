<?php
require_once("clases/registroLogs.php");
	class modulos{

		public $opcion;

		function mostrar()
		{
			 $id=$_GET['opc']; //se captura la opcion elegida


			if($_SESSION["usuario_rol"] == 1) // Opciones para el ROOT
		  	{
		 		switch ($id)
						{
							case 'login':
								 include("modulos/sesion/index.php");
							   break;
							case 'valida':
								 include("modulos/sesion/doLogin.php");
							   break;
							case 'acerca':
								 include("modulos/acerca/index.php");
							   break;
							case 'logout':
								$accion="USUARIO CIERRA SESION EN EL SISTEMA";
                        		$origen=$_SERVER['REMOTE_ADDR'] .' - '.gethostbyaddr($_SERVER['REMOTE_ADDR']).' - '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                        		generaLogs($_SESSION["usuario_nombre"],$accion,$origen);
								session_unset();
								session_destroy();
								echo '<script languaje="javascript"> window.location="index.php"; </script>';
							   break;
							case 'reporteCaja':
								 include("modulos/caja/reporteCaja.php");
							   break;
							case 'ventven':
								 include("modulos/ventvendedor/index.php");
							   break;
							case 'vendedores':
								 include("modulos/vendedor/ventest.php");
							   break;
							case 'ventest':
								 include("modulos/vendedor/ventest.php");
							   break;
							case 'ventasdet':
								 include("modulos/vendedor/ventasprodet.php");
							   break;
							case 'ventasdetAir':
								 include("modulos/vendedor/ventasprodetAir.php");
							   break;
							case 'ventmarca':
								 include("modulos/vendedor/ventasmarca.php");
							   break;
							case 'ventapormarca':
								 include("modulos/marcas/ventaspormarca.php");
							   break;
							case 'infventa':
								 include("modulos/vendedor/infventas.php");
							   break;
							case 'graficos':
								 include("modulos/graficos.php");
							   break;
							case 'topvendedores':
								 include("modulos/vendedor/ventasVendedor.php");
							   break;
							case 'topvendedoresAir':
								 include("modulos/vendedor/ventasVendedorAir.php");
							   break;
							case 'reporteCaja':
								 include("modulos/caja/reporteCaja.php");
							   break;
							case 'usuarios':
								 include("modulos/usuarios/index.php");
							   break;
							case 'nuevaSolicitud':
								 include("modulos/solicitudes/index.php");
							   break;
							case 'paso2':
								 include("modulos/solicitudes/sol_p2.php");
							   break;
							case 'pasodos':
								 include("modulos/solicitudes/solu_p2.php");
							   break;
							case 'ventaspro':
								 include("modulos/vendedor/ventaspro.php");
							   break;
							case 'ventasproAir':
								 include("modulos/vendedor/ventasproAir.php");
							   break;
							case 'ventasmodulodet':
								 include("modulos/vendedor/ventasdetmod.php");
							   break;
							case 'comparativo':
								 include("modulos/vendedor/comparativo.php");
							   break;
							   case 'comparativoRent':
								 include("modulos/vendedor/comparativoRent.php");
							   break;
							case 'notaCredito':
								 include("modulos/vendedor/notasCpro.php");
							   break;
							 case 'mantenedorProm':
								include("modulos/promociones/mantenedorPromociones.php");
							 break;
							 case 'familyF':
								include("modulos/family_friends/familyF.php");
							 break;
							case 'ventasBM':
								 include("modulos/vendedor/ventasBrand.php");
							   break;
							case 'metasTienda':
								 include("modulos/metas/index.php");
							   break;
							 case 'horaPunta':
								 include("modulos/vendedor/ventaHoraPic.php");
							   break;
							case 'buscarCodigo':
								 include("modulos/vendedor/buscarCodigo.php");
							   break;
							case 'buscarCodigoBodega':
								 include("modulos/vendedor/buscarCodigoBodega.php");
							   break;
							case 'stockMarcaBodega':
								 include("modulos/vendedor/stockMarcaBodega.php");
							   break;
							 case 'stockMarcaBodegaLote':
								 include("modulos/vendedor/stockMarcaBodegaLote.php");
							   break;
						    case 'stockMarca':
								 include("modulos/vendedor/stockMarca.php");
							   break;
							case 'stockMarcaAir':
								 include("modulos/vendedor/stockMarcaAir.php");
							   break;
							case 'bodega':
								 include("modulos/bodega/index.php");
							   break;
							case 'validarDsm':
								 include("modulos/dsm/index.php");
							   break;
							case 'ventaMensual':
								 include("modulos/indicadores/ventasMes.php");
							   break;
							case 'ventaMensualPuig':
								 include("modulos/indicadores/ventasVendedorPuig.php");
							   break;
							case 'ventaDiaria':
								 include("modulos/indicadores/ventasDiarias.php");
							   break;
							case 'ventaDiaMensual':
								 include("modulos/indicadores/ventaDiaMensual.php");
							   break;
							case 'ventasHora':
								 include("modulos/indicadores/ventasHora.php");
							   break;
							case 'ventasHoraAir':
								 include("modulos/indicadores/ventasHoraAir.php");
							   break;
							case 'ventaSemanaHora':
								 include("modulos/indicadores/ventasSemanaHora.php");
							   break;
							case 'transferencias':
								 include("modulos/transferencias/transferencias.php");
							   break;
							case 'transdet':
								 include("modulos/transferencias/transdet.php");
							   break;
							case 'compararCodigos':
								 include("modulos/vendedor/compararCodigos.php");
							   break;
							case 'paretoABC':
								 include("modulos/indicadores/paretoABC.php");
							   break;
							case 'cambioClave':
								 include("modulos/config/cambioClave.php");
							   break;
							case 'dsmAir':
								 include("modulos/dsmAir/index.php");
							   break;
							case 'validarDSMAir':
								 include("modulos/dsmAir/indexdet.php");
							   break;

							case 'avisos':
								 include("modulos/avisos/index.php");
							   break;
							case 'verBoleta':
								 include("modulos/vendedor/verBoleta.php");
							   break;
							 case 'verBoletaAir':
								 include("modulos/vendedor/verBoletaAir.php");
							   break;
							case 'rankMarca':
								 include("modulos/vendedor/rankMarca.php");
							   break;
							case 'genEtiqueta':
								 include("modulos/vendedor/genEtiqueta.php");
							   break;
							case 'estAuto':
								 include("modulos/estadisticos/estAuto.php");
							   break;
							case 'maestroArticulos':
								 include("modulos/estadisticos/maestro.php");
							   break;

							case 'cmando':
								 include("modulos/cmando/cmando.php");
							   break;
						    case 'cmandoBoletas':
								 include("modulos/cmando/cmandoBoletas.php");
							   break;
						    case 'cmandoCompras':
								 include("modulos/cmando/cmandoCompras.php");
							   break;

							 case 'transbank':
								 include("modulos/transbank/index.php");
							   break;
							 case 'abono':
								 include("modulos/transbank/abonar.php");
							   break;
							  case 'kardex':
								 include("modulos/vendedor/kardex.php");
							   break;
							  case 'unidadesVendidasMes':
								 include("modulos/estadisticos/unidadesVendidasMes.php");
							   break;
							  case 'StockPorMes':
								 include("modulos/estadisticos/StockPorMes.php");
							   break;

							  case 'ventasPorBM':
								 include("modulos/estadisticos/ventasPorBM.php");
							   break;

							  case 'ventasPorProveedor':
								 include("modulos/estadisticos/ventasPorProveedor.php");
							   break;
							  case 'ventasPorBodega':
								 include("modulos/estadisticos/ventasPorBodega.php");
							   break;
							  case 'ventasPorVendedor':
								 include("modulos/estadisticos/ventasPorVendedor.php");
							   break;
							  case 'movDoc':
								 include("modulos/vendedor/movdocumentos.php");
							   break;
							   case 'req':
								 include("modulos/requerimientos/index.php");
							   break;
							   case 'procReq':
								 include("modulos/requerimientos/procReq.php");
							   break;
							 case 'reporteStock':
								 include("modulos/vendedor/reporteStock.php");
							   break;
							   case 'reporteHistorico':
								 include("modulos/vendedor/reporteHistorico.php");
							   break;
							   case 'listaPrecio':
								 include("modulos/vendedor/listaPrecio.php");
							   break;
							   case 'listaPrecioMod':
								 include("modulos/vendedor/listaPrecioMod.php");
							   break;
							 case 'ventasPorHistorico':
								 include("modulos/estadisticos/ventasPorHistorico.php");
							   break;
                             case 'fondoFijo':
				 				 include("modulos/fondoFijo/fondoFijo.php");
							   break;
							 case 'detalleFondoFijo':
								 include("modulos/fondoFijo/detalleFondoFijo.php");
								 break;
							 case 'ventasAnuales':
								 include("modulos/estadisticos/ventasHistoricasAnuales.php");
								 break;
							 case 'compaVenta':
								 include("modulos/estadisticos/comparativoVentas.php");
							   break;
							   /***********DEM************/
							 case 'validarDem':
								 include("modulos/dem/index2.php");
							   break;
							case 'dem':
								 include("modulos/dem/index.php");
							   break;
							 case 'validarDEM':
								 include("modulos/dem/index2.php");
							   break;
							 case 'abastecimiento':
								 include("modulos/informes/abastecimiento.php");
							 break;
							 case 'suministro':
								 include("modulos/suministro/index.php");
							   break;
							 case 'dispo':
								 include("modulos/vendedor/dispo.php"); 
							   break;
							 case 'indPos':
								 include("modulos/cmando/indPos.php"); 
							   break;
							 case 'campania':
								 include("modulos/vendedor/campania.php"); 
							   break;
							case 'ingresoMerc':
								include("modulos/ingresos/ingresoMerc.php");
								break;
							   /**********FIN DEM********/
							default:
								  include("modulos/cmando/cmandoBoletas.php");
							   break;
							   
							 case 'VentasDL':
								 include("modulos/vendedor/VentasDL.php"); 
							   break;
							case 'reporteCajaCont':
								 include("modulos/caja/reporteCajaCont.php");
							break;
						 }
		  } // fin opciones de ROOT


		  

			else if($_SESSION["usuario_rol"] == 2) //Opciones para los Vendedores
		  	{
		 		switch ($id)
						{
							case 'login':
								 include("modulos/sesion/index.php");
							   break;
							case 'valida':
								 include("modulos/sesion/doLogin.php");
							   break;
							case 'acerca':
								 include("modulos/acerca/index.php");
							   break;
							case 'logout':
								$accion="USUARIO CIERRA SESION EN EL SISTEMA";
                        		$origen=$_SERVER['REMOTE_ADDR'] .' - '.gethostbyaddr($_SERVER['REMOTE_ADDR']).' - '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                        		generaLogs($_SESSION["usuario_nombre"],$accion,$origen);
								session_unset();
								session_destroy();
							echo '<script languaje="javascript"> window.location="index.php"; </script>';
							   break;
						    case 'reporteCaja':
								 include("modulos/caja/reporteCaja.php");
							   break;
						    case 'vendedores':
								 include("modulos/vendedor/ventest.php");
							   break;
						    case 'ventapormarca':
								 include("modulos/marcas/ventaspormarca.php");
							   break;
							case 'topvendedores':
								 include("modulos/vendedor/ventasVendedor.php");
							   break;
							case 'nuevaSolicitud':
								 include("modulos/solicitudes/index.php");
							   break;
							case 'buscarCodigo':
								 include("modulos/vendedor/buscarCodigo.php");
							   break;
							case 'paso2':
								 include("modulos/solicitudes/sol_p2.php");
							   break;
							case 'ventaspro':
								 include("modulos/vendedor/ventaspro.php");
							   break;
							case 'pasodos':
								 include("modulos/solicitudes/solu_p2.php");
							   break;
							case 'ventest':
							 include("modulos/vendedor/ventest.php");
						       break;
							case 'validarDsm':
								 include("modulos/dsm/index2.php");
							   break;
							case 'dsm':
								 include("modulos/dsm/index.php");
							   break;
							 case 'validarDSM':
								 include("modulos/dsm/index2.php");
							   break;

							case 'verBoleta':
								 include("modulos/vendedor/verBoleta.php");
							   break;
							 case 'stockMarca':
								 include("modulos/vendedor/stockMarca.php");
							   break;
							 case 'kardex':
								 include("modulos/vendedor/kardex.php");
							   break;
							 case 'req':
								 include("modulos/requerimientos/index.php");
							   break;
							   
							 /**** FONDO FIJO ******/
							 case 'fondoFijo':
								 include("modulos/fondoFijo/fondoFijo.php");
								 break;
							 case 'detalleFondoFijo':
								 include("modulos/fondoFijo/detalleFondoFijo.php");
								 break;
							/*******************/
							default:

								 include("modulos/solicitudes/index.php");
							   break;

						 }
		} // fin opciones para ejecutivo
		else if($_SESSION["usuario_rol"] == 3) //Opciones para Visador
		  	{
		 		switch ($id)
						{
								case 'login':
								 include("modulos/sesion/index.php");
							   break;
							case 'valida':
								 include("modulos/sesion/doLogin.php");
							   break;
							case 'acerca':
								 include("modulos/acerca/index.php");
							   break;
							case 'logout':
								$accion="USUARIO CIERRA SESION EN EL SISTEMA";
                        		$origen=$_SERVER['REMOTE_ADDR'] .' - '.gethostbyaddr($_SERVER['REMOTE_ADDR']).' - '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                        		generaLogs($_SESSION["usuario_nombre"],$accion,$origen);
								session_unset();
								session_destroy();
								echo '<script languaje="javascript"> window.location="index.php"; </script>';
							   break;
							  case 'buscarCodigo':
								 include("modulos/vendedor/buscarCodigo.php");
							   break;
							 case 'buscarCodigoBodega':
								 include("modulos/vendedor/buscarCodigoBodega.php");
							   break;
							case 'ventasdet':
								 include("modulos/vendedor/ventasprodet.php");
							   break;
							case 'ventmarca':
								 include("modulos/vendedor/ventasmarca.php");
							   break;
							case 'ventapormarca':
								 include("modulos/marcas/ventaspormarca.php");
							   break;
							case 'graficos':
								 include("modulos/graficos.php");
							   break;
							case 'topvendedores':
								 include("modulos/vendedor/ventasVendedor.php");
							   break;
							   case 'ventaMensual':
								 include("modulos/indicadores/ventasMes.php");
							   break;
							case 'stockMarcaBodega':
								 include("modulos/vendedor/stockMarcaBodega.php");
							   break;
							case 'stockMarca':
								 include("modulos/vendedor/stockMarca.php");
							   break;
							case 'stockMarcaAir':
								 include("modulos/vendedor/stockMarcaAir.php");
							   break;
							   
							case 'VentasDL':
								 include("modulos/vendedor/VentasDL.php"); 
							   break;
							case 'usuarios':
								 include("modulos/usuarios/index.php");
							   break;
    						case 'ventaspro':
								 include("modulos/vendedor/ventaspro.php");
							   break;
							case 'ventasmodulodet':
								 include("modulos/vendedor/ventasdetmod.php");
							   break;
							 /*******/
							 case 'ventaMensual':
								 include("modulos/indicadores/ventasMes.php");
							   break;
							case 'ventaDiaria':
								 include("modulos/indicadores/ventasDiarias.php");
							   break;
							case 'ventaDiaMensual':
								 include("modulos/indicadores/ventaDiaMensual.php");
							   break;
							case 'ventasHora':
								 include("modulos/indicadores/ventasHora.php");
							   break;
							case 'ventaSemanaHora':
								 include("modulos/indicadores/ventasSemanaHora.php");
							   break;
							case 'verBoleta':
								 include("modulos/vendedor/verBoleta.php");
							   break;
							case 'vendedores':
								 include("modulos/vendedor/ventest.php");
							   break;
							case 'ventasdet':
								 include("modulos/vendedor/ventasprodet.php");
							   break;
							case 'ventasdetAir':
								 include("modulos/vendedor/ventasprodetAir.php");
							   break;
							case 'stockMarcaBodegaLote':
								 include("modulos/vendedor/stockMarcaBodegaLote.php");
							case 'ventmarca':
								 include("modulos/vendedor/ventasmarca.php");
							   break;
							case 'ventapormarca':
								 include("modulos/marcas/ventaspormarca.php");
							   break;
							case 'ventasAnuales':
								 include("modulos/estadisticos/ventasHistoricasAnuales.php");
								 break;
							 case 'compaVenta':
								 include("modulos/estadisticos/comparativoVentas.php");
							   break;
							case 'graficos':
								 include("modulos/graficos.php");
							   break;
							case 'topvendedores':
								 include("modulos/vendedor/ventasVendedor.php");
							   break;

							case 'ventasproAir':
								 include("modulos/vendedor/ventasproAir.php");
							   break;
							case 'ventasmodulodet':
								 include("modulos/vendedor/ventasdetmod.php");
							   break;

							case 'ventasBM':
								 include("modulos/vendedor/ventasBrand.php");
							   break;
							 /**************************/
							case 'estAuto':
								 include("modulos/estadisticos/estAuto.php");
							   break;
							case 'maestroArticulos':
								 include("modulos/estadisticos/maestro.php");
							   break;
							 /*****REPORTES ***/
							  case 'kardex':
								 include("modulos/vendedor/kardex.php");
							   break;
							  case 'unidadesVendidasMes':
								 include("modulos/estadisticos/unidadesVendidasMes.php");
							   break;
							  case 'StockPorMes':
								 include("modulos/estadisticos/StockPorMes.php");
							   break;
							 case 'ventasPorBM':
								 include("modulos/estadisticos/ventasPorBM.php");
							   break;
							 case 'ventasPorProveedor':
								 include("modulos/estadisticos/ventasPorProveedor.php");
							   break;
							 case 'comparativo':
								 include("modulos/vendedor/comparativo.php");
							   break;
							case 'infventa':
								 include("modulos/vendedor/infventas.php");
							   break;
							case 'movDoc':
								 include("modulos/vendedor/movdocumentos.php");
							   break;
							case 'req':
								 include("modulos/requerimientos/index.php");
							   break;
							 /**** FONDO FIJO ******/
							 case 'fondoFijo':
								 include("modulos/fondoFijo/fondoFijo.php");
								 break;
							 case 'detalleFondoFijo':
								 include("modulos/fondoFijo/detalleFondoFijo.php");
								 break;
						     case 'campania':
								 include("modulos/vendedor/campania.php"); 
							   break;
							/*******************/
							/**** REPORTE CAJA SALTO FOLIO ***/
							case 'reporteCajaCont':
								 include("modulos/caja/reporteCajaCont.php");
							   break;
							/********************/
							default:
								include("modulos/vendedor/comparativo.php");
							   break;
						 }
			  } // fin opciones Visador
			  else if($_SESSION["usuario_rol"] == 4) //Opciones para Brand Manager
		  {
		 		switch ($id)
			   {
							case 'login':
								 include("modulos/sesion/index.php");
							   break;
							case 'traspasoMercaderia':
								include("modulos/traspasoMercaderia/traspaso.php");
								break;
							case 'valida':
								 include("modulos/sesion/doLogin.php");
							   break;
							case 'acerca':
								 include("modulos/acerca/index.php");
							   break;
							case 'logout':
								$accion="USUARIO CIERRA SESION EN EL SISTEMA";
                        		$origen=$_SERVER['REMOTE_ADDR'] .' - '.gethostbyaddr($_SERVER['REMOTE_ADDR']).' - '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                        		generaLogs($_SESSION["usuario_nombre"],$accion,$origen);
								session_unset();
								session_destroy();
								echo '<script languaje="javascript"> window.location="index.php"; </script>';
							   break;
							  case 'buscarCodigo':
								 include("modulos/vendedor/buscarCodigo.php");
							   break;
							 case 'buscarCodigoBodega':
								 include("modulos/vendedor/buscarCodigoBodega.php");
							   break;
							   case 'mantenedorProm':
								include("modulos/promociones/mantenedorPromociones.php");
							 break;

							case 'ventasdet':
								 include("modulos/vendedor/ventasprodet.php");
							   break;
							case 'ventmarca':
								 include("modulos/vendedor/ventasmarca.php");
							   break;
							case 'ventapormarca':
								 include("modulos/marcas/ventaspormarca.php");
							   break;
							case 'graficos':
								 include("modulos/graficos.php");
							   break;
							case 'topvendedores':
								 include("modulos/vendedor/ventasVendedor.php");
							   break;

							   case 'ventaMensual':
								 include("modulos/indicadores/ventasMes.php");
							   break;
							case 'stockMarcaBodega':
								 include("modulos/vendedor/stockMarcaBodega.php");
							   break;
							case 'stockMarca':
								 include("modulos/vendedor/stockMarca.php");
							   break;
							case 'stockMarcaAir':
								 include("modulos/vendedor/stockMarcaAir.php");
							   break;
							case 'usuarios':
								 include("modulos/usuarios/index.php");
							   break;
							case 'nuevaSolicitudbrand':
								 include("modulos/solicitudes/indexbrand.php");
							   break;
							case 'nuevaSolicitudbrandAir':
								 include("modulos/solicitudesAir/indexbrandAir.php");
							   break;
							case 'paso2brand':
								 include("modulos/solicitudes/sol_p2brand.php");
							   break;
							case 'paso2brandAir':
								 include("modulos/solicitudesAir/sol_p2brand.php");
							   break;
								case 'ventaspro':
								 include("modulos/vendedor/ventaspro.php");
							   break;
							case 'ventasmodulodet':
								 include("modulos/vendedor/ventasdetmod.php");
							   break;
							 /*******/
							 case 'ventaMensual':
								 include("modulos/indicadores/ventasMes.php");
							   break;
							case 'ventaDiaria':
								 include("modulos/indicadores/ventasDiarias.php");
							   break;
							case 'ventaDiaMensual':
								 include("modulos/indicadores/ventaDiaMensual.php");
							   break;
							case 'ventasHora':
								 include("modulos/indicadores/ventasHora.php");
							   break;
							case 'ventaSemanaHora':
								 include("modulos/indicadores/ventasSemanaHora.php");
							   break;
							case 'verBoleta':
								 include("modulos/vendedor/verBoleta.php");
							   break;
							case 'reporteHistorico':
								 include("modulos/vendedor/reporteHistorico.php");
							   break;
							case 'familyF':
								include("modulos/family_friends/familyF.php");
							 break;
							case 'listaPrecio':
								 include("modulos/vendedor/listaPrecio.php");
							   break;
							case 'listaPrecioMod':
								 include("modulos/vendedor/listaPrecioMod.php");
							   break;
							case 'abastecimiento':
								 include("modulos/informes/abastecimiento.php");
							   break;
							 /********/
							 /*************/
							case 'vendedores':
								 include("modulos/vendedor/ventest.php");
							   break;

							case 'ventasdet':
								 include("modulos/vendedor/ventasprodet.php");
							   break;
							case 'ventasdetAir':
								 include("modulos/vendedor/ventasprodetAir.php");
							   break;
							case 'ventmarca':
								 include("modulos/vendedor/ventasmarca.php");
							   break;
							case 'ventapormarca':
								 include("modulos/marcas/ventaspormarca.php");
							   break;
							case 'graficos':
								 include("modulos/graficos.php");
							   break;
							case 'topvendedores':
								 include("modulos/vendedor/ventasVendedor.php");
							   break;
							case 'topvendedoresAir':
								 include("modulos/vendedor/ventasVendedorAir.php");
							   break;
							case 'nuevaSolicitud':
								 include("modulos/solicitudes/index.php");
							   break;
							case 'paso2':
								 include("modulos/solicitudes/sol_p2.php");
							   break;
							case 'pasodos':
								 include("modulos/solicitudes/solu_p2.php");
							   break;
							 case 'comparativoRent':
								 include("modulos/vendedor/comparativoRent.php");
							   break;

							case 'ventasproAir':
								 include("modulos/vendedor/ventasproAir.php");
							   break;
							case 'ventasmodulodet':
								 include("modulos/vendedor/ventasdetmod.php");
							   break;

							case 'ventasBM':
								 include("modulos/vendedor/ventasBrand.php");
							   break;
							 /**************************/

							case 'estAuto':
								 include("modulos/estadisticos/estAuto.php");
							   break;
							case 'maestroArticulos':
								 include("modulos/estadisticos/maestro.php");
							   break;
						   /*****REPORTES ***/
							  case 'kardex':
								 include("modulos/vendedor/kardex.php");
							   break;
							  case 'unidadesVendidasMes':
								 include("modulos/estadisticos/unidadesVendidasMes.php");
							   break;
							  case 'StockPorMes':
								 include("modulos/estadisticos/StockPorMes.php");
							   break;
							 case 'ventasPorBM':
								 include("modulos/estadisticos/ventasPorBM.php");
							   break;
							  case 'ventasPorProveedor':
								 include("modulos/estadisticos/ventasPorProveedor.php");
							   break;
							   case 'req':
								 include("modulos/requerimientos/index.php");
							   break;
							  case 'ventasPorVendedor':
								 include("modulos/estadisticos/ventasPorVendedor.php");
							   break;
							   case 'reporteStock':
								 include("modulos/vendedor/reporteStock.php");
							   break;
							  /**** FONDO FIJO ******/
							 case 'fondoFijo':
								 include("modulos/fondoFijo/fondoFijo.php");
								 break;
							 case 'detalleFondoFijo':
								 include("modulos/fondoFijo/detalleFondoFijo.php");
								 break;
							/*******************/
							 case 'ventasAnuales':
								 include("modulos/estadisticos/ventasHistoricasAnuales.php");
								 break;
							 case 'compaVenta':
								 include("modulos/estadisticos/comparativoVentas.php");
							   break;
							 case 'ventasPorHistorico':
								 include("modulos/estadisticos/ventasPorHistorico.php");
							   break;
							default:
								 include("modulos/solicitudes/indexbrand.php");
							   break;
						 }
			 } // fin opciones para Brand Manager

			else if($_SESSION["usuario_rol"] == 5) //Opciones para personal de Inventario
		  	{
		 		switch ($id)
						{
							case 'login':
								 include("modulos/sesion/index.php");
							   break;
							case 'valida':
								 include("modulos/sesion/doLogin.php");
							   break;
							case 'acerca':
								 include("modulos/acerca/index.php");
							   break;
							case 'logout':
								$accion="USUARIO CIERRA SESION EN EL SISTEMA";
                        		$origen=$_SERVER['REMOTE_ADDR'] .' - '.gethostbyaddr($_SERVER['REMOTE_ADDR']).' - '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                        		generaLogs($_SESSION["usuario_nombre"],$accion,$origen);
								session_unset();
								session_destroy();
								echo '<script languaje="javascript"> window.location="index.php"; </script>';
							   break;
							case 'ventven':
								 include("modulos/ventvendedor/index.php");
							   break;
							case 'vendedores':
								 include("modulos/vendedor/ventest.php");
							   break;
							case 'ventest':
								 include("modulos/vendedor/ventest.php");
							   break;
							case 'ventasdet':
								 include("modulos/vendedor/ventasprodet.php");
							   break;
							case 'ventasdetAir':
								 include("modulos/vendedor/ventasprodetAir.php");
							   break;
							case 'ventmarca':
								 include("modulos/vendedor/ventasmarca.php");
							   break;
							case 'ventapormarca':
								 include("modulos/marcas/ventaspormarca.php");
							   break;
							case 'infventa':
								 include("modulos/vendedor/infventas.php");
							   break;
							case 'graficos':
								 include("modulos/graficos.php");
							   break;
							case 'topvendedores':
								 include("modulos/vendedor/ventasVendedor.php");
							   break;
							case 'topvendedoresAir':
								 include("modulos/vendedor/ventasVendedorAir.php");
							   break;
							case 'reporteCaja':
								 include("modulos/caja/reporteCaja.php");
							   break;
							case 'usuarios':
								 include("modulos/usuarios/index.php");
							   break;
							case 'nuevaSolicitud':
								 include("modulos/solicitudes/index.php");
							   break;
							case 'paso2':
								 include("modulos/solicitudes/sol_p2.php");
							   break;
							case 'pasodos':
								 include("modulos/solicitudes/solu_p2.php");
							   break;
							case 'ventaspro':
								 include("modulos/vendedor/ventaspro.php");
							   break;
							case 'ventasproAir':
								 include("modulos/vendedor/ventasproAir.php");
							   break;
							case 'ventasmodulodet':
								 include("modulos/vendedor/ventasdetmod.php");
							   break;
							case 'notaCredito':
								 include("modulos/vendedor/notasCpro.php");
							   break;
							case 'ventasBM':
								 include("modulos/vendedor/ventasBrand.php");
							   break;
							case 'metasTienda':
								 include("modulos/metas/index.php");
							   break;
							 case 'horaPunta':
								 include("modulos/vendedor/ventaHoraPic.php");
							   break;
							case 'buscarCodigo':
								 include("modulos/vendedor/buscarCodigo.php");
							   break;
							case 'buscarCodigoBodega':
								 include("modulos/vendedor/buscarCodigoBodega.php");
							   break;
							case 'stockMarcaBodega':
								 include("modulos/vendedor/stockMarcaBodega.php");
							   break;
						    case 'stockMarca':
								 include("modulos/vendedor/stockMarca.php");
							   break;
							case 'stockMarcaAir':
								 include("modulos/vendedor/stockMarcaAir.php");
							   break;
							case 'bodega':
								 include("modulos/bodega/index.php");
							   break;
							case 'validarDsm':
								 include("modulos/dsm/index.php");
							   break;
							case 'ventaMensual':
								 include("modulos/indicadores/ventasMes.php");
							   break;
							case 'ventaMensualPuig':
								 include("modulos/indicadores/ventasVendedorPuig.php");
							   break;
							case 'ventaDiaria':
								 include("modulos/indicadores/ventasDiarias.php");
							   break;
							case 'ventaDiaMensual':
								 include("modulos/indicadores/ventaDiaMensual.php");
							   break;
							case 'ventasHora':
								 include("modulos/indicadores/ventasHora.php");
							   break;
							case 'ventasHoraAir':
								 include("modulos/indicadores/ventasHoraAir.php");
							   break;
							case 'ventaSemanaHora':
								 include("modulos/indicadores/ventasSemanaHora.php");
							   break;
							case 'transferencias':
								 include("modulos/transferencias/transferencias.php");
							   break;
							case 'transdet':
								 include("modulos/transferencias/transdet.php");
							   break;
							case 'compararCodigos':
								 include("modulos/vendedor/compararCodigos.php");
							   break;
							case 'avisos':
								 include("modulos/avisos/index.php");
							   break;
							  case 'req':
								 include("modulos/requerimientos/index.php");
							   break;
							  case 'kardex':
								 include("modulos/vendedor/kardex.php");
							   break;
					 		/**** FONDO FIJO ******/
							 case 'fondoFijo':
								 include("modulos/fondoFijo/fondoFijo.php");
								 break;
							 case 'detalleFondoFijo':
								 include("modulos/fondoFijo/detalleFondoFijo.php");
								 break;
							case 'stockMarcaBodegaLote':
								 include("modulos/vendedor/stockMarcaBodegaLote.php");
							   break;
							/*******************/
							  /***********DEM************/
							 case 'validarDem':
								 include("modulos/dem/index2.php");
							   break;
							case 'dem':
								 include("modulos/dem/index.php");
							   break;
							case 'validarDEM':
								 include("modulos/dem/index2.php");
							   break;
							   /**********FIN DEM********/
							default:
								include("modulos/vendedor/kardex.php");
							   break;
						 }
			 } // fin opciones para inventario
			 else if($_SESSION["usuario_rol"] == 6) // Opciones para Bodega
		  	{
		 		switch ($id)
						{
							case 'login':
								 include("modulos/sesion/index.php");
							   break;
							case 'valida':
								 include("modulos/sesion/doLogin.php");
							   break;
							case 'acerca':
								 include("modulos/acerca/index.php");
							   break;
							case 'logout':
								$accion="USUARIO CIERRA SESION EN EL SISTEMA";
                        		$origen=$_SERVER['REMOTE_ADDR'] .' - '.gethostbyaddr($_SERVER['REMOTE_ADDR']).' - '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                        		generaLogs($_SESSION["usuario_nombre"],$accion,$origen);
								session_unset();
								session_destroy();
								echo '<script languaje="javascript"> window.location="index.php"; </script>';
							   break;
		
							case 'buscarCodigo':
								 include("modulos/vendedor/buscarCodigo.php");
							   break;
							case 'buscarCodigoBodega':
								 include("modulos/vendedor/buscarCodigoBodega.php");
							   break;
							case 'stockMarcaBodega':
								 include("modulos/vendedor/stockMarcaBodega.php");
							   break;
							 case 'stockMarcaBodegaLote':
								 include("modulos/vendedor/stockMarcaBodegaLote.php");
							   break;
						    case 'stockMarca':
								 include("modulos/vendedor/stockMarca.php");
							   break;
							case 'stockMarcaAir':
								 include("modulos/vendedor/stockMarcaAir.php");
							   break;
							case 'bodega':
								 include("modulos/bodega/index.php");
							   break;
							
							case 'transferencias':
								 include("modulos/transferencias/transferencias.php");
							   break;
							case 'transdet':
								 include("modulos/transferencias/transdet.php");
							   break;
							case 'compararCodigos':
								 include("modulos/vendedor/compararCodigos.php");
							   break;
							case 'paretoABC':
								 include("modulos/indicadores/paretoABC.php");
							   break;
							case 'genEtiqueta':
								 include("modulos/vendedor/genEtiqueta.php");
							   break;
							case 'estAuto':
								 include("modulos/estadisticos/estAuto.php");
							   break;
							case 'maestroArticulos':
								 include("modulos/estadisticos/maestro.php");
							   break;

							case 'cmando':
								 include("modulos/cmando/cmando.php");
							   break;
						    case 'cmandoBoletas':
								 include("modulos/cmando/cmandoBoletas.php");
							   break;
							
							  case 'kardex':
								 include("modulos/vendedor/kardex.php");
							   break;
							  case 'StockPorMes':
								 include("modulos/estadisticos/StockPorMes.php");
							   break;
							 case 'reporteStock':
								 include("modulos/vendedor/reporteStock.php");
							   break;
							 case 'kardex':
								 include("modulos/vendedor/kardex.php");
							   break;
							 
							 
							default:
								  include("modulos/cmando/cmandoBoletas.php");
							   break;
						 }
		  } // fin opciones de Bodega
		   else if($_SESSION["usuario_rol"] == 9) // Opciones para el  area de finanzas
		  	{
		 		switch ($id)
						{
							case 'login':
								 include("modulos/sesion/index.php");
							   break;
							case 'valida':
								 include("modulos/sesion/doLogin.php");
							   break;
							case 'acerca':
								 include("modulos/acerca/index.php");
							   break;
							case 'logout':
								$accion="USUARIO CIERRA SESION EN EL SISTEMA";
                        		$origen=$_SERVER['REMOTE_ADDR'] .' - '.gethostbyaddr($_SERVER['REMOTE_ADDR']).' - '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                        		generaLogs($_SESSION["usuario_nombre"],$accion,$origen);
								session_unset();
								session_destroy();
								echo '<script languaje="javascript"> window.location="index.php"; </script>';
							   break;
							case 'ventven':
								 include("modulos/ventvendedor/index.php");
							   break;
							case 'vendedores':
								 include("modulos/vendedor/ventest.php");
							   break;
							case 'ventest':
								 include("modulos/vendedor/ventest.php");
							   break;
							case 'ventasdet':
								 include("modulos/vendedor/ventasprodet.php");
							   break;
							case 'ventasdetAir':
								 include("modulos/vendedor/ventasprodetAir.php");
							   break;
							case 'ventmarca':
								 include("modulos/vendedor/ventasmarca.php");
							   break;
							case 'ventapormarca':
								 include("modulos/marcas/ventaspormarca.php");
							   break;
							case 'infventa':
								 include("modulos/vendedor/infventas.php");
							   break;
							case 'graficos':
								 include("modulos/graficos.php");
							   break;
							case 'topvendedores':
								 include("modulos/vendedor/ventasVendedor.php");
							   break;
							case 'topvendedoresAir':
								 include("modulos/vendedor/ventasVendedorAir.php");
							   break;
							case 'reporteCajaCont':
								 include("modulos/caja/reporteCajaCont.php");
							   break;
							case 'ventaspro':
								 include("modulos/vendedor/ventaspro.php");
							   break;
							case 'ventasproAir':
								 include("modulos/vendedor/ventasproAir.php");
							   break;
							case 'ventasmodulodet':
								 include("modulos/vendedor/ventasdetmod.php");
							   break;
							 case 'horaPunta':
								 include("modulos/vendedor/ventaHoraPic.php");
							   break;
							case 'buscarCodigo':
								 include("modulos/vendedor/buscarCodigo.php");
							   break;
							case 'buscarCodigoBodega':
								 include("modulos/vendedor/buscarCodigoBodega.php");
							   break;
							case 'stockMarcaBodega':
								 include("modulos/vendedor/stockMarcaBodega.php");
							   break;
							 case 'stockMarcaBodegaLote':
								 include("modulos/vendedor/stockMarcaBodegaLote.php");
							   break;
						    case 'stockMarca':
								 include("modulos/vendedor/stockMarca.php");
							   break;
							case 'stockMarcaAir':
								 include("modulos/vendedor/stockMarcaAir.php");
							   break;
							case 'bodega':
								 include("modulos/bodega/index.php");
							   break;

							case 'ventaMensual':
								 include("modulos/indicadores/ventasMes.php");
							   break;

							case 'ventaDiaria':
								 include("modulos/indicadores/ventasDiarias.php");
							   break;
							case 'ventaDiaMensual':
								 include("modulos/indicadores/ventaDiaMensual.php");
							   break;
							case 'ventasHora':
								 include("modulos/indicadores/ventasHora.php");
							   break;
							case 'ventasHoraAir':
								 include("modulos/indicadores/ventasHoraAir.php");
							   break;
							case 'ventaSemanaHora':
								 include("modulos/indicadores/ventasSemanaHora.php");
							   break;

							case 'cambioClave':
								 include("modulos/config/cambioClave.php");
							   break;
							case 'avisos':
								 include("modulos/avisos/index.php");
							   break;
							case 'verBoleta':
								 include("modulos/vendedor/verBoleta.php");
							   break;
							case 'verBoletaAir':
								 include("modulos/vendedor/verBoletaAir.php");
							   break;
							case 'rankMarca':
								 include("modulos/vendedor/rankMarca.php");
							   break;

							 case 'transbank':
								 include("modulos/transbank/index.php");
							   break;
							 case 'abono':
								 include("modulos/transbank/abonar.php");
							   break;
							case 'req':
								 include("modulos/requerimientos/index.php");
							   break;
							 case 'movDoc':
								 include("modulos/vendedor/movdocumentos.php");
							   break;
							  /**** FONDO FIJO ******/
							 case 'fondoFijo':
								 include("modulos/fondoFijo/fondoFijo.php");
								 break;
							 case 'detalleFondoFijo':
								 include("modulos/fondoFijo/detalleFondoFijo.php");
								 break;
						     case 'impuesto':
								 include("modulos/vendedor/impuesto.php");
								 break;
							 case 'impuestoMay':
								 include("modulos/vendedor/impuestoMay.php");
								 break;
							/*******************/
							default:
								  include("modulos/transbank/index.php");
							   break;
						 }
		  } // fin opciones de finanzas y contabilidad
		  
		  else if($_SESSION["usuario_rol"] == 10) //Opciones para ejecutivo
		  {
		 		switch ($id)
			   {
							case 'login':
								 include("modulos/sesion/index.php");
							   break;
							  case 'campania':
								 include("modulos/vendedor/campania.php"); 
							   break;
							case 'valida':
								 include("modulos/sesion/doLogin.php");
							   break;
							case 'acerca':
								 include("modulos/acerca/index.php");
							   break;
							case 'logout':
								$accion="USUARIO CIERRA SESION EN EL SISTEMA";
                        		$origen=$_SERVER['REMOTE_ADDR'] .' - '.gethostbyaddr($_SERVER['REMOTE_ADDR']).' - '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                        		generaLogs($_SESSION["usuario_nombre"],$accion,$origen);
								session_unset();
								session_destroy();
								echo '<script languaje="javascript"> window.location="index.php"; </script>';
							   break;
							case 'buscarCodigo':
								 include("modulos/vendedor/buscarCodigo.php");
							   break;
							 case 'buscarCodigoBodega':
								 include("modulos/vendedor/buscarCodigoBodega.php");
							   break;

							case 'ventasdet':
								 include("modulos/vendedor/ventasprodet.php");
							   break;
							case 'ventmarca':
								 include("modulos/vendedor/ventasmarca.php");
							   break;
							case 'ventapormarca':
								 include("modulos/marcas/ventaspormarca.php");
							   break;
							case 'graficos':
								 include("modulos/graficos.php");
							   break;
							case 'topvendedores':
								 include("modulos/vendedor/ventasVendedor.php");
							   break;

							   case 'ventaMensual':
								 include("modulos/indicadores/ventasMes.php");
							   break;
							case 'stockMarcaBodega':
								 include("modulos/vendedor/stockMarcaBodega.php");
							   break;
							case 'stockMarca':
								 include("modulos/vendedor/stockMarca.php");
							   break;
							case 'stockMarcaAir':
								 include("modulos/vendedor/stockMarcaAir.php");
							   break;

							case 'usuarios':
								 include("modulos/usuarios/index.php");
							   break;
    						case 'ventaspro':
								 include("modulos/vendedor/ventaspro.php");
							   break;
							case 'ventasmodulodet':
								 include("modulos/vendedor/ventasdetmod.php");
							   break;
							 /*******/
							 case 'ventaMensual':
								 include("modulos/indicadores/ventasMes.php");
							   break;
							case 'ventaDiaria':
								 include("modulos/indicadores/ventasDiarias.php");
							   break;
							case 'ventaDiaMensual':
								 include("modulos/indicadores/ventaDiaMensual.php");
							   break;
							case 'ventasAnuales':
								 include("modulos/estadisticos/ventasHistoricasAnuales.php");
								 break;
							 case 'compaVenta':
								 include("modulos/estadisticos/comparativoVentas.php");
							   break;
							case 'ventasHora':
								 include("modulos/indicadores/ventasHora.php");
							   break;
							case 'ventaSemanaHora':
								 include("modulos/indicadores/ventasSemanaHora.php");
							   break;
							case 'verBoleta':
								 include("modulos/vendedor/verBoleta.php");
							   break;
							case 'vendedores':
								 include("modulos/vendedor/ventest.php");
							   break;
							case 'ventasdet':
								 include("modulos/vendedor/ventasprodet.php");
							   break;
							case 'ventasdetAir':
								 include("modulos/vendedor/ventasprodetAir.php");
							   break;
							case 'ventmarca':
								 include("modulos/vendedor/ventasmarca.php");
							   break;
							case 'ventapormarca':
								 include("modulos/marcas/ventaspormarca.php");
							   break;

							case 'graficos':
								 include("modulos/graficos.php");
							   break;
							case 'topvendedores':
								 include("modulos/vendedor/ventasVendedor.php");
							   break;
							case 'ventasproAir':
								 include("modulos/vendedor/ventasproAir.php");
							   break;
							case 'ventasmodulodet':
								 include("modulos/vendedor/ventasdetmod.php");
							   break;

							case 'ventasBM':
								 include("modulos/vendedor/ventasBrand.php");
							   break;
							 /**************************/

							case 'estAuto':
								 include("modulos/estadisticos/estAuto.php");
							   break;
							case 'maestroArticulos':
								 include("modulos/estadisticos/maestro.php");
							   break;

							 /*****REPORTES ***/
							  case 'kardex':
								 include("modulos/vendedor/kardex.php");
							   break;
							  case 'unidadesVendidasMes':
								 include("modulos/estadisticos/unidadesVendidasMes.php");
							   break;
							  case 'StockPorMes':
								 include("modulos/estadisticos/StockPorMes.php");
							   break;
							 case 'ventasPorBM':
								 include("modulos/estadisticos/ventasPorBM.php");
							   break;
							 case 'ventasPorProveedor':
								 include("modulos/estadisticos/ventasPorProveedor.php");
							   break;
							 case 'comparativo':
								 include("modulos/vendedor/comparativo.php");
							   break;
							   case 'comparativoRent':
								 include("modulos/vendedor/comparativoRent.php");
							   break;
							case 'reporteHistorico':
								 include("modulos/vendedor/reporteHistorico.php");
							   break;
							case 'req':
								 include("modulos/requerimientos/index.php");
							   break;
							case 'ventasPorHistorico':
								 include("modulos/estadisticos/ventasPorHistorico.php");
							   break;
							 /**** FONDO FIJO ******/
							 case 'fondoFijo':
								 include("modulos/fondoFijo/fondoFijo.php");
								 break;
							 case 'detalleFondoFijo':
								 include("modulos/fondoFijo/detalleFondoFijo.php");
								 break;
							/*******************/
							default:
								   include("modulos/vendedor/ventasdetmod.php");
							   break;
						 }
			 } // fin opciones para Brand ejecutivo

		else if($_SESSION["usuario_rol"] == 11) //Opciones para los Vendedores aeropuerto
		  	{
		 		switch ($id)
						{
							case 'login':
								 include("modulos/sesion/index.php");
							   break;
							case 'valida':
								 include("modulos/sesion/doLogin.php");
							   break;
							case 'acerca':
								 include("modulos/acerca/index.php");
							   break;
							case 'logout':
								$accion="USUARIO CIERRA SESION EN EL SISTEMA";
                        		$origen=$_SERVER['REMOTE_ADDR'] .' - '.gethostbyaddr($_SERVER['REMOTE_ADDR']).' - '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                        		generaLogs($_SESSION["usuario_nombre"],$accion,$origen);
								session_unset();
								session_destroy();
							echo '<script languaje="javascript"> window.location="index.php"; </script>';
							   break;
						    case 'infcaja':
								 include("modulos/caja/infcaja.php");
							   break;
						    case 'vendedores':
								 include("modulos/vendedor/ventest.php");
							   break;
						    case 'ventapormarca':
								 include("modulos/marcas/ventaspormarca.php");
							   break;
							case 'topvendedoresAir':
								 include("modulos/vendedor/ventasVendedorAir.php");
							   break;
							case 'nuevaSolicitud':
								 include("modulos/solicitudesAir/index.php");
							   break;
							case 'paso2':
								 include("modulos/solicitudesAir/sol_p2.php");
							   break;
							case 'ventasproAir':
								 include("modulos/vendedor/ventasproAir.php");
							   break;
							case 'pasodos':
								 include("modulos/solicitudesAir/solu_p2.php");
							   break;
							   	case 'ventest':
								 include("modulos/vendedor/ventest.php");
							   break;
							case 'dsmAir':
								 include("modulos/dsmAir/index.php");
							   break;

							 case 'validarDSMAir':
								 include("modulos/dsmAir/indexdet.php");
							   break;

							 case 'kardex':
								 include("modulos/vendedor/kardex.php");
							   break;
							  case 'req':
								 include("modulos/requerimientos/index.php");
							   break;
 							/**** FONDO FIJO ******/
							 case 'fondoFijo':
								 include("modulos/fondoFijo/fondoFijo.php");
								 break;
							 case 'detalleFondoFijo':
								 include("modulos/fondoFijo/detalleFondoFijo.php");
								 break;
							/*******************/
							default:
								  //include("modulos/vendedor/ventest.php");
								   include("modulos/dsmAir/index.php");
							   break;
						 }
		} // fin opciones para Vendedores AEROPUERTO

		   else if($_SESSION["usuario_rol"] == 15) // Opciones para el  area de finanzas
		  	{
		 		switch ($id)
						{
							case 'login':
								 include("modulos/sesion/index.php");
							   break;
							case 'valida':
								 include("modulos/sesion/doLogin.php");
							   break;
							case 'acerca':
								 include("modulos/acerca/index.php");
							   break;
							case 'logout':
								$accion="USUARIO CIERRA SESION EN EL SISTEMA";
                        		$origen=$_SERVER['REMOTE_ADDR'] .' - '.gethostbyaddr($_SERVER['REMOTE_ADDR']).' - '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                        		generaLogs($_SESSION["usuario_nombre"],$accion,$origen);
								session_unset();
								session_destroy();
								echo '<script languaje="javascript"> window.location="index.php"; </script>';
							   break;
							case 'ventven':
								 include("modulos/ventvendedor/index.php");
							   break;
							case 'vendedores':
								 include("modulos/vendedor/ventest.php");
							   break;
							case 'ventest':
								 include("modulos/vendedor/ventest.php");
							   break;
							case 'ventasdet':
								 include("modulos/vendedor/ventasprodet.php");
							   break;
							case 'ventasdetAir':
								 include("modulos/vendedor/ventasprodetAir.php");
							   break;
							case 'ventmarca':
								 include("modulos/vendedor/ventasmarca.php");
							   break;
							case 'ventapormarca':
								 include("modulos/marcas/ventaspormarca.php");
							   break;
							case 'infventa':
								 include("modulos/vendedor/infventas.php");
							   break;
							case 'graficos':
								 include("modulos/graficos.php");
							   break;
							case 'infcaja':
								 include("modulos/caja/infcaja.php");
							   break;
							case 'topvendedores':
								 include("modulos/vendedor/ventasVendedor.php");
							   break;
							case 'topvendedoresAir':
								 include("modulos/vendedor/ventasVendedorAir.php");
							   break;
							case 'infcaja':
								 include("modulos/caja/infcaja.php");
							   break;

							case 'ventaspro':
								 include("modulos/vendedor/ventaspro.php");
							   break;
							case 'ventasproAir':
								 include("modulos/vendedor/ventasproAir.php");
							   break;
							case 'ventasmodulodet':
								 include("modulos/vendedor/ventasdetmod.php");
							   break;
							 case 'horaPunta':
								 include("modulos/vendedor/ventaHoraPic.php");
							   break;
							case 'buscarCodigo':
								 include("modulos/vendedor/buscarCodigo.php");
							   break;
							case 'buscarCodigoBodega':
								 include("modulos/vendedor/buscarCodigoBodega.php");
							   break;
							case 'stockMarcaBodega':
								 include("modulos/vendedor/stockMarcaBodega.php");
							   break;
							 case 'stockMarcaBodegaLote':
								 include("modulos/vendedor/stockMarcaBodegaLote.php");
							   break;
						    case 'stockMarca':
								 include("modulos/vendedor/stockMarca.php");
							   break;
							case 'stockMarcaAir':
								 include("modulos/vendedor/stockMarcaAir.php");
							   break;
							case 'bodega':
								 include("modulos/bodega/index.php");
							   break;

							case 'ventaMensual':
								 include("modulos/indicadores/ventasMes.php");
							   break;

							case 'ventaDiaria':
								 include("modulos/indicadores/ventasDiarias.php");
							   break;
							case 'ventaDiaMensual':
								 include("modulos/indicadores/ventaDiaMensual.php");
							   break;
							case 'ventasHora':
								 include("modulos/indicadores/ventasHora.php");
							   break;
							case 'ventasHoraAir':
								 include("modulos/indicadores/ventasHoraAir.php");
							   break;
							case 'ventaSemanaHora':
								 include("modulos/indicadores/ventasSemanaHora.php");
							   break;

							case 'cambioClave':
								 include("modulos/config/cambioClave.php");
							   break;
							case 'avisos':
								 include("modulos/avisos/index.php");
							   break;
							case 'verBoleta':
								 include("modulos/vendedor/verBoleta.php");
							   break;
							case 'verBoletaAir':
								 include("modulos/vendedor/verBoletaAir.php");
							   break;
							case 'rankMarca':
								 include("modulos/vendedor/rankMarca.php");
							   break;

							 case 'transbank':
								 include("modulos/transbank/index.php");
							   break;
							 case 'abono':
								 include("modulos/transbank/abonar.php");
							   break;
							case 'req':
								 include("modulos/requerimientos/index.php");
							   break;
							 case 'movDoc':
								 include("modulos/vendedor/movdocumentos.php");
							   break;
							  /**** FONDO FIJO ******/
							 case 'fondoFijo':
								 include("modulos/fondoFijo/fondoFijo.php");
								 break;
							 case 'detalleFondoFijo':
								 include("modulos/fondoFijo/detalleFondoFijo.php");
								 break;
							/*******************/
							default:
								  include("modulos/cmando/cmandoBoletas.php");
							   break;
						 }
		  } // fin opciones de finanzas y contabilidad
		  else if($_SESSION["usuario_rol"] == 16) //Opciones para personal de Bodega
		  	{
		 		switch ($id)
						{
							case 'login':
								 include("modulos/sesion/index.php");
							   break;
							case 'valida':
								 include("modulos/sesion/doLogin.php");
							   break;
							case 'acerca':
								 include("modulos/acerca/index.php");
							   break;
							case 'logout':
								$accion="USUARIO CIERRA SESION EN EL SISTEMA";
                        		$origen=$_SERVER['REMOTE_ADDR'] .' - '.gethostbyaddr($_SERVER['REMOTE_ADDR']).' - '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                        		generaLogs($_SESSION["usuario_nombre"],$accion,$origen);
								session_unset();
								session_destroy();
								echo '<script languaje="javascript"> window.location="index.php"; </script>';
							   break;
							case 'ventven':
								 include("modulos/ventvendedor/index.php");
							   break;
							case 'vendedores':
								 include("modulos/vendedor/ventest.php");
							   break;
							case 'ventest':
								 include("modulos/vendedor/ventest.php");
							   break;
							case 'ventasdet':
								 include("modulos/vendedor/ventasprodet.php");
							   break;
							case 'ventasdetAir':
								 include("modulos/vendedor/ventasprodetAir.php");
							   break;
							case 'ventmarca':
								 include("modulos/vendedor/ventasmarca.php");
							   break;
							case 'ventapormarca':
								 include("modulos/marcas/ventaspormarca.php");
							   break;
							case 'infventa':
								 include("modulos/vendedor/infventas.php");
							   break;
							case 'graficos':
								 include("modulos/graficos.php");
							   break;
							case 'topvendedores':
								 include("modulos/vendedor/ventasVendedor.php");
							   break;
							case 'topvendedoresAir':
								 include("modulos/vendedor/ventasVendedorAir.php");
							   break;
							case 'infcaja':
								 include("modulos/caja/infcaja.php");
							   break;
							case 'usuarios':
								 include("modulos/usuarios/index.php");
							   break;
							case 'nuevaSolicitud':
								 include("modulos/solicitudes/index.php");
							   break;
							case 'paso2':
								 include("modulos/solicitudes/sol_p2.php");
							   break;
							case 'pasodos':
								 include("modulos/solicitudes/solu_p2.php");
							   break;
							case 'ventaspro':
								 include("modulos/vendedor/ventaspro.php");
							   break;
							case 'ventasproAir':
								 include("modulos/vendedor/ventasproAir.php");
							   break;
							case 'ventasmodulodet':
								 include("modulos/vendedor/ventasdetmod.php");
							   break;
							case 'notaCredito':
								 include("modulos/vendedor/notasCpro.php");
							   break;
							case 'ventasBM':
								 include("modulos/vendedor/ventasBrand.php");
							   break;
							case 'metasTienda':
								 include("modulos/metas/index.php");
							   break;
							 case 'horaPunta':
								 include("modulos/vendedor/ventaHoraPic.php");
							   break;
							case 'buscarCodigo':
								 include("modulos/vendedor/buscarCodigo.php");
							   break;
							case 'buscarCodigoBodega':
								 include("modulos/vendedor/buscarCodigoBodega.php");
							   break;
							case 'stockMarcaBodega':
								 include("modulos/vendedor/stockMarcaBodega.php");
							   break;
						    case 'stockMarca':
								 include("modulos/vendedor/stockMarca.php");
							   break;
							case 'stockMarcaAir':
								 include("modulos/vendedor/stockMarcaAir.php");
							   break;
							case 'bodega':
								 include("modulos/bodega/index.php");
							   break;
							case 'validarDsm':
								 include("modulos/dsm/index.php");
							   break;
							case 'ventaMensual':
								 include("modulos/indicadores/ventasMes.php");
							   break;
							case 'ventaMensualPuig':
								 include("modulos/indicadores/ventasVendedorPuig.php");
							   break;
							case 'ventaDiaria':
								 include("modulos/indicadores/ventasDiarias.php");
							   break;
							case 'ventaDiaMensual':
								 include("modulos/indicadores/ventaDiaMensual.php");
							   break;
							case 'ventasHora':
								 include("modulos/indicadores/ventasHora.php");
							   break;
							case 'ventasHoraAir':
								 include("modulos/indicadores/ventasHoraAir.php");
							   break;
							case 'ventaSemanaHora':
								 include("modulos/indicadores/ventasSemanaHora.php");
							   break;
							case 'transferencias':
								 include("modulos/transferencias/transferencias.php");
							   break;
							case 'transdet':
								 include("modulos/transferencias/transdet.php");
							   break;
							case 'compararCodigos':
								 include("modulos/vendedor/compararCodigos.php");
							   break;
							case 'avisos':
								 include("modulos/avisos/index.php");
							   break;
							  case 'req':
								 include("modulos/requerimientos/index.php");
							   break;
							  case 'kardex':
								 include("modulos/vendedor/kardex.php");
							   break;
					 		/**** FONDO FIJO ******/
							 case 'fondoFijo':
								 include("modulos/fondoFijo/fondoFijo.php");
								 break;
							 case 'detalleFondoFijo':
								 include("modulos/fondoFijo/detalleFondoFijo.php");
								 break;
							/*******************/
							  /***********DEM************/
							 case 'validarDem':
								 include("modulos/dem/index2.php");
							   break;
							case 'dem':
								 include("modulos/dem/index.php");
							   break;
							 case 'validarDEM':
								 include("modulos/dem/index2.php");
							   break;
							   /**********FIN DEM********/
							default:
								include("modulos/vendedor/kardex.php");
							   break;
						 }
			 } // fin opciones para inventario

		else
		{
			 switch ($id)
			{
							case 'login':
								 include("modulos/sesion/index.php");
							   break;
							case 'valida':
								 include("modulos/sesion/doLogin.php");
							   break;
							case 'acerca':
								 include("modulos/acerca/index.php");
							   break;
							case 'logout':
								$accion="USUARIO CIERRA SESION EN EL SISTEMA";
                        		$origen=$_SERVER['REMOTE_ADDR'] .' - '.gethostbyaddr($_SERVER['REMOTE_ADDR']).' - '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                        		generaLogs($_SESSION["usuario_nombre"],$accion,$origen);
								session_unset();
								session_destroy();
								echo '<script languaje="javascript"> window.location="index.php"; </script>';
							   break;
							default:
								 include("modulos/sesion/index.php");
							   break;
						 }

		      } // fin else de acceso
		}

}//fin class






?>
