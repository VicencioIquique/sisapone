<?php 
		
class menu{
	
		function mostrar()
		{	
		
			if($_SESSION["usuario_rol"] == 1) // Menu para ROOT
   		    { 
		 	echo "	
				<div class='menu-secondary-wrap'>
						<ul class='menus menu-secondary'>
							
							<li><a href='index.php'>Inicio</a>
							  <ul class='children'>
							  <li><a href='index.php?opc=cmando'>Cuadro de Mando</a></li>
							  <li><a href='index.php?opc=cmandoBoletas'>Cuadro de Mando Centralización de Boletas</a></li>
							  <li><a href='index.php?opc=cmandoCompras'>Cuadro de Mando Compras</a></li>
							  <li><a href='index.php?opc=cambioClave'>Cambiar Clave</a></li>
							  <li><a href='index.php?opc=suministro'>Suministro</a></li>
							  <li><a href='index.php?opc=dispo'>Disponibilidad</a></li>
							  <li><a href='index.php?opc=indPos'>Indicadores POS</a></li>
							  <li><a href='index.php?opc=campania'>Campaña Fin de Año</a></li>							  
							  <li><a href='index.php?opc=logout'>Salir del Sistema</a></li>								
							  </ul>
							</li>
							
							<li><a href='#'>Vendedores</a>
								 <ul class='children'>
										<li><a href='index.php?opc=ventaspro'>Ventas Det. Zofri</a></li>
										<li><a href='index.php?opc=ventasproAir'>Ventas Det. Aeropuerto</a></li>
										<li><a href='index.php?opc=ventasmodulodet'>Ventas Modulos</a>
											<ul class='children'>
												<li><a href='index.php?opc=ventasdet'>Ventas Det.(Cif,USD,CANT)</a></li>
											</ul>
										</li>
									    <li><a href='index.php?opc=topvendedores'>Top Venta Vendedores</a>
											 <ul class='children'>
												<li><a href='index.php?opc=topvendedoresAir'>Top Venta Vendedores Aero.</a></li>
											 </ul>
										</li>
										<li><a href='index.php?opc=horaPunta'>Hora Punta</a></li>
										<li><a href='index.php?opc=ventmarca'>Venta por Marca</a></li>
										<li><a href='index.php?opc=infventa'>Informe de Ventas</a></li>
										<li><a href='index.php?opc=buscarCodigo'>Buscar Por Codigo</a></li>
										<li><a href='index.php?opc=buscarCodigoBodega'>Buscar Por Codigo Bodega</a></li>
										<li><a href='index.php?opc=stockMarcaBodega'>Stock por Marca Bodega</a>
										<li><a href='index.php?opc=stockMarcaBodegaLote'>Stock Bodega Lote</a>
										<li><a href='index.php?opc=stockMarca'>Stock por Marca</a>
											<ul class='children'>
									    		 <li><a href='index.php?opc=stockMarcaAir'>Stock por Marca Apto.</a></li>
											 </ul>	
										</li>
										<li><a href='index.php?opc=VentasDL'>Inf. Ventas Diarias DL</a></li>
										
										
										<!-- <li><a href='index.php?opc=infcaja'>Informe de Cajas</a></li>-->
								 </ul>
							</li>
							
						  <!--  <li><a href='#'>Marcas</a>
								 <ul class='children'>
									     <li><a href='index.php?opc=ventapormarca'>Ventas por Marca</a></li>
								 </ul>
							</li>-->
							
							<li><a href='#'>Notas de Credito</a>
								 <ul class='children'>
									     <li><a href='index.php?opc=notaCredito'>Detalle N. Credito</a></li>
								 </ul>
							</li>
							
							<!--<li><a href='#'>Bodega</a>
								 <ul class='children'>
									     <li><a href='index.php?opc=bodega'>Bodega</a></li>
								 </ul>
							</li>-->
							
							<li><a href='#'>Graficos</a>
								 <ul class='children'>
									     <li><a href='index.php?opc=ventaMensual'>Venta del Año por Meses</a></li>
										  <!--<li><a href='index.php?opc=ventaMensualPuig'>Venta en meses PUIGs</a></li>-->
										 <li><a href='index.php?opc=ventaDiaMensual'>Venta Mensual por Días</a></li>
										 <li><a href='index.php?opc=ventaDiaria'>Venta Por Día de Semana</a></li>
										 <li><a href='index.php?opc=ventasHora'>Venta Mensual por Hora</a>
										 <li><a href='index.php?opc=ventasHoraAir'>Venta Mensual por Hora Aero.</a>
											 <ul class='children'>
												<!--<li><a href='index.php?opc=ventaSemanaHora'>Venta Semanal por Hora</a></li>-->
											 </ul>
										 </li>
										 <!--<li><a href='index.php?opc=paretoABC'>Clasificación de Productos</a></li>-->
								 </ul>
							</li>
								<li><a href='index.php?opc=reporteCajaCont'>Caja</a>
									 <ul class='children'>
											<li><a href='index.php?opc=reporteCajaCont'>Informe de Cajas</a></li>
									 </ul>
							</li>
							
					     	<li><a href='#'>Brand Manager</a>
								 <ul class='children'>
										<li><a href='index.php?opc=ventasBM'>Ventas BM</a></li>
										<li><a href='index.php?opc=mantenedorProm'>Promociones</a></li>
							 	</ul>
							 
							 <!--<li><a href='#'>DSM</a>
								 <ul class='children'>
										<li><a href='index.php?opc=validarDsm'>Validar</a></li>
										<li><a href='index.php?opc=historialDsm'>Historial</a></li>
							 </ul>-->
							
							<!--<li><a href='#'>ZETA</a>
								<ul class='children'>
										<li><a href='index.php?opc=consultarzeta'>Consultar Zeta</a>
										<li><a href='index.php?opc=#'>Otro</a>
								</ul>
							</li>-->
							<!--<li>
							<a href='#'>Metas</a>
								<ul class='children'>
										<li><a href='index.php?opc=metasTienda'>Metas por Tienda</a></li>
									
								</ul>
							</li>-->
							
							<li><a href='#'>Usuarios</a>
								 <ul class='children'>
										<li><a href='index.php?opc=usuarios'>Usuarios</a></li>
								 </ul>
							</li>
							<!--<li><a href='#' id='solestado'>Solicitudes</a>
								 <ul class='children'>
										<li><a href='index.php?opc=nuevaSolicitud'>Nueva Solicitud</a></li>
								 </ul>
							</li>-->
								
							<li><a  href='index.php?opc=#'>LVT</a>
								<ul class='children'>
									<li><a href='index.php?opc=ventasAnuales'>VENTAS HISTORICAS US$ - L</a></li>
									<li><a href='index.php?opc=compaVenta'>COMPARATIVO DE VENTAS MENSUALES EN PESOS MODULOS - L</a></li>
									<li><a href='index.php?opc=reporteHistorico'>Reporte Histórico</a>
										<ul class='children'>
											<li><a href='#'>AGOSTO 2016</a>
												<ul class='children'>
													<li><a href='historicos/Agosto2016/BPI_2016-08.zip'>BPI</a>
													<li><a href='historicos/Agosto2016/C.DIOR_2016-08.zip'>C.DIOR</a>
													<li><a href='historicos/Agosto2016/CLARINS_2016-08.zip'>CLARINS</a>
													<li><a href='historicos/Agosto2016/COTY_2016-08.zip'>COTY</a>
													<li><a href='historicos/Agosto2016/ESSENCE_2016-08.zip'>ESSENCE</a>
													<li><a href='historicos/Agosto2016/EUROITALIA_2016-08.zip'>EUROITALIA</a>
													<li><a href='historicos/Agosto2016/HERMES_2016-08.zip'>HERMES</a>
													<li><a href='historicos/Agosto2016/IDESA_2016-08.zip'>IDESA</a>
													<li><a href='historicos/Agosto2016/INTER_P_2016-08.zip'>INTER_P</a>
													<li><a href='historicos/Agosto2016/LOEWE_2016-08.zip'>LOEWE</a>
													<li><a href='historicos/Agosto2016/MAVIVE_2016-08.zip'>MAVIVE</a>
													<li><a href='historicos/Agosto2016/MILLENIUM_2016-08.zip'>MILLENIUM</a>
													<li><a href='historicos/Agosto2016/PARBEL_2016-08.zip'>PARBEL</a>
													<li><a href='historicos/Agosto2016/PUIG_2016-08.zip'>PUIG</a>
													<li><a href='historicos/Agosto2016/REVLON_2016-08.zip'>REVLON</a>
													<li><a href='historicos/Agosto2016/RICHEMONT_2016-08.zip'>RICHEMONT</a>
													<li><a href='historicos/Agosto2016/SALVATORE_FERRAGAMO_2016-08.zip'>SALVATORE_FERRAGAMO</a>
													<li><a href='historicos/Agosto2016/ST.HONORE_2016-08.zip'>ST.HONORE</a>
													<li><a href='historicos/Agosto2016/ELIZABETH_ARDEN_2016-08.zip'>ELIZABETH_ARDEN</a>
													<li><a href='historicos/Agosto2016/BERDOUES_2016-08.zip'>BERDOUES</a>
													<li><a href='historicos/Agosto2016/LVMH_2016-08.zip'>LVMH</a>
													<li><a href='historicos/Agosto2016/MOURE_2016-08.zip'>MOURE</a>
													<li><a href='historicos/Agosto2016/BVLGARI_2016-08.zip'>BVLGARI</a>
													<li><a href='historicos/Agosto2016/TED_LAPIDUS_2016-08.zip'>TED_LAPIDUS</a>
													<li><a href='historicos/Agosto2016/EUROCOSMESI_2016-08.zip'>EUROCOSMESI</a>
												</ul>
											</li>
										</ul>
									</li> 
									<li><a href='index.php?opc=ventasPorHistorico'>Ventas Historico Segmento/Status</a></li>
									<li><a href='index.php?opc=comparativoRent'>Comparativo Rentabilidad</a></li>
								</ul>
							</li>
							
							<!--<li><a  href='index.php?opc=avisos'>Avisos</a></li>-->	
							<!--<li><a  href='index.php?opc=verBoleta'>Ver Boleta</a></li>-->
							<!--<li><a  href='index.php?opc=transferencias'>transferencias</a></li>-->
							 
							 <li><a href='#'>Pruebas</a>
								 <ul class='children'>
										<li><a href='index.php?opc=reporteCaja'>Nuevo Reporte Caja</a></li>
										<li><a href='index.php?opc=abastecimiento'>Reporte Abastecimiento</a></li>
										<li><a href='index.php?opc=reporteHistorico'>Reporte Histórico</a></li>
										<li><a href=''>Listas de precios</a>
											<ul class='children'>
												<li><a href='index.php?opc=listaPrecio'>Lista de precio Área Comercial / Comité Ejecutivo</a></li>
												<li><a href='index.php?opc=listaPrecioMod'>Lista de precio Módulo</a></li>
											</ul>
										</li>
										<li><a href='index.php?opc=rankMarca'>Ranking Marcas</a></li>
									    <li><a href='index.php?opc=genEtiqueta'>Generar Etiqueta</a></li>
										<li><a href='index.php?opc=estAuto'>Estadistico Automatico</a>
											<ul class='children'>
											    <li><a href='index.php?opc=estAuto'>Año 2014</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisap/archivos/Nov2014.xlsx'>Nov. 2014</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Dic2014.xlsx'>Dic. 2014</a></li>
													</ul>
												</li>
												<li><a href='index.php?opc=estAuto'>Año 2015</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisap/archivos/Ene2015.xlsx'>Ene. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Feb2015.xlsx'>Feb. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Mar2015.xlsx'>Mar. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Abr2015.xlsx'>Abr. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/May2015.xlsx'>May. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Jun2015.xlsx'>Jun. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Jul2015.xlsx'>Jul. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Ago2015.xlsx'>Ago. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Sep2015.xlsx'>Sep. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Oct2015.xlsx'>Oct. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Nov2015.xlsx'>Nov. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Dic2015.xlsx'>Dic. 2015</a></li>
												    </ul>
												</li>
												<li><a href='index.php?opc=estAuto'>Año 2016</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisap/archivos/Ene2016.xlsx'>Ene. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Feb2016.xlsx'>Feb. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Mar2016.xlsx'>Mar. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Abr2016.xlsx'>Abr. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/May2016.xlsx'>May. 2016</a></li> 
													 <li><a target'_blank' href='../sisap/archivos/Jun2016.xlsx'>Jun. 2016</a></li> 
													 <li><a target'_blank' href='../sisap/archivos/Jul2016.xlsx'>Jul. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Ago2016.xlsx'>Ago. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Sep2016.xlsx'>Sep. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Oct2016.xlsx'>Oct. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Nov2016.xlsx'>Nov. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Dic2016.xlsx'>Dic. 2016</a></li>
												    </ul>
												</li>
												<li><a href='index.php?opc=estAuto'>Año 2017</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisap/archivos/Ene2017.xlsx'>Ene. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Feb2017.xlsx'>Feb. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Mar2017.xlsx'>Mar. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Abr2017.xlsx'>Abr. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/May2017.xlsx'>May. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Jun2017.xlsx'>Jun. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Jul2017.xlsx'>Jul. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Ago2017.xlsx'>Ago. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/sep2017.xlsx'>Sep. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/oct2017.xlsx'>Oct. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/nov2017.xlsx'>Nov. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/dic2017.xlsx'>Dic. 2017</a></li>
													 
													 
												    </ul>
												</li>
												<li><a href='index.php?opc=estAuto'>Año 2018</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisap/archivos/ene2018.xlsx'>Ene. 2018</a></li>
													 <li><a target'_blank' href='../sisap/archivos/feb2018.xlsx'>Feb. 2018</a></li>
													 <li><a target'_blank' href='../sisap/archivos/mar2018.xlsx'>Mar. 2018</a></li>
												    </ul>
												</li>
												
												<li><a href='index.php?opc=estAuto'>Año 2020</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisapone/archivos/Oct2020.xlsx'>Oct. 2020</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Nov2020.xlsx'>Nov. 2020</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Dic2020.xlsx'>Dic. 2020</a></li>
												    </ul>
												</li>
												<li><a href='index.php?opc=estAuto'>Año 2021</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisapone/archivos/Ene2021.xlsx'>Ene. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Feb2021.xlsx'>Feb. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Mar2021.xlsx'>Mar. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Abr2021.xlsx'>Abr. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/May2021.xlsx'>May. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Jun2021.xlsx'>Jun. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Jul2021.xlsx'>Jul. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Ago2021.xlsx'>Ago. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Sep2021.xlsx'>Sep. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Oct2021.xlsx'>Oct. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Nov2021.xlsx'>Nov. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Dic2021.xlsx'>Dic. 2021</a></li>
													</ul>
												</li>
												<li><a href='index.php?opc=estAuto'>Año 2022</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisapone/archivos/Ene2022.xlsx'>Ene. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Feb2022.xlsx'>Feb. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Mar2022.xlsx'>Mar. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Abr2022.xlsx'>Abr. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/May2022.xlsx'>May. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Jun2022.xlsx'>Jun. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Jul2022.xlsx'>Jul. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Ago2022.xlsx'>Ago. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Sep2022.xlsx'>Sep. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Oct2022.xlsx'>Oct. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Nov2022.xlsx'>Nov. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Dic2022.xlsx'>Dic. 2022</a></li>
													</ul>
												</li>
												<li><a href='index.php?opc=estAuto'>Año 2023</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisapone/archivos/Ene2023.xlsx'>Ene. 2022</a></li>
													</ul>
												</li>
										    
										    </ul>
										</li>
										<li><a href='index.php?opc=maestroArticulos'>Maestro de Articulos</a></li>
										<li><a href='index.php?opc=transbank'>TransBank</a></li>
										<li><a href='index.php?opc=kardex'>Kardex</a></li>
										<li><a href='index.php?opc=unidadesVendidasMes'>Venta Unidades Mes</a></li>
										<li><a href='index.php?opc=StockPorMes'>Stock Por Mes</a></li>
										<li><a href='index.php?opc=ventasPorBM'>Ventas Por BM</a></li>
										<li><a href='index.php?opc=ventasPorProveedor'>Ventas Por Proveedor</a></li>
										<li><a href='index.php?opc=ventasPorBodega'>Ventas Por Bodega</a></li>
										<li><a href='index.php?opc=ventasPorVendedor'>Ventas Poor Vendedor</a></li>
										<li><a href='index.php?opc=comparativo'>Comparativo Ventas</a></li>
										<li><a href='index.php?opc=movDoc'>Mov Doc</a></li>
										<li><a href='index.php?opc=req'>Requerimientos</a></li>
										<li><a href='index.php?opc=procReq'>Procesar Requerimiento</a></li>
										<li><a href='index.php?opc=reporteStock'>reporteStock</a></li>
										<li><a href='index.php?opc=ventasPorHistorico'>Ventas Por Historico</a></li>
                                        <li><a href='index.php?opc=fondoFijo'>Fondos Fijos</a></li>
										<li><a href='index.php?opc=ventasAnuales'>Ventas Anuales</a></li>
										<li><a href='index.php?opc=compaVenta'>Inf Comparativo Ventas</a></li>
										<li><a href='index.php?opc=validarDEM'>Validar DEM</a></li>
										<li><a href='index.php?opc=dem'>Listado Documentos DEM</a></li>
										<li><a href='index.php?opc=dem'>Reporte Abastecimiento</a></li>
								 </ul>
							</li>
							
							 
						 </ul>
					</div> <!-- fin menu -->";
			} 
			// fin menu para ROOT
			
			else if($_SESSION["usuario_rol"] == 2) //Menu para Vendedores
		  	{ 
		 
			  echo "	
					<div class='menu-secondary-wrap'>
							<ul class='menus menu-secondary'>
								
								<li><a href='index.php'>Inicio</a>
									 <ul class='children'>";
											if($_SESSION["linkPersonal"])
											{
												echo"<li><a href='".$_SESSION["linkPersonal"]."'>Documentos Personal</a></li>";
											}
								     echo"
									 <li><a href='index.php?opc=logout'>Salir del Sistema</a></li>
									 </ul>
								</li>
								
								<li><a href='#'>Vendedores</a>
									 <ul class='children'>
											<li><a href='index.php?opc=ventaspro'>Ventas por Fecha</a></li>
											<li><a href='index.php?opc=topvendedores'>Top Venta Vendedores</a></li>
											
									 </ul>
								</li>
								
								 <li><a href='#'>DSM</a>
								 <ul class='children'>
										<li><a href='index.php?opc=validarDsm'>Validar</a></li>
										<li><a  href='index.php?opc=dsm'>Listado Documentos DSM</a></li>
										<!--<li><a href='index.php?opc=historialDsm'>Historial</a></li>-->
						    	 </ul>
								
								<li><a href='index.php?opc=reporteCaja'>Caja</a>
									 <ul class='children'>
											<li><a href='index.php?opc=reporteCaja'>Informe de Cajas</a></li>
									 </ul>
								</li>
							<li><a href='#'>Stocks</a>
								 <ul class='children'>
										<li><a href='index.php?opc=kardex'>Kardex</a></li>
										<li><a href='index.php?opc=buscarCodigo'>Buscar Por Codigo</a></li>
										<li><a href='index.php?opc=stockMarca'>Stock por Marca</a>
								 </ul>
							</li>
								
								<li><a href='index.php?opc=nuevaSolicitud' id='solestado' >Solicitudes</a></li>
								<li><a href='#'>Requerimientos</a>
								 <ul class='children'>
										<li><a href='index.php?opc=req'>Solicitar Nuevo Requerimiento</a></li>
										<li><a target='_blank' href='../sisap/docs/Manual%20Requerimientos'  >Manual Requerimientos</a></li>
								 </ul>
							</li>
							<li><a href='#'>Fondo Fijo</a></li>
						  </ul>
						  
				   </div> <!-- Menu Vendedores --> ";
		 } // fin menu para vendedores
			
			
			 else if($_SESSION["usuario_rol"] == 3) //Menu para Visador
		 { 
				 echo "	
				<div class='menu-secondary-wrap'>
						<ul class='menus menu-secondary'>
							
							<li><a href='index.php'>Inicio</a>
							  <ul class='children'>
								<li><a href='index.php?opc=logout'>Salir del Sistema</a></li>
							  </ul>
							</li>
							
							<li><a href='#'>Ventas</a>
								 <ul class='children'>
										<li><a href='index.php?opc=ventaspro'>Ventas Det. Zofri</a></li>
										<li><a href='index.php?opc=ventasproAir'>Ventas Det. Aeropuerto</a></li>
										<li><a href='index.php?opc=movDoc'>Mov. de Documentos Módulo</a></li>
										<li><a href='index.php?opc=comparativo'>Análisi Comparativo Ventas</a></li>
										<li><a href='index.php?opc=ventasmodulodet'>Ventas Modulos</a>
											<ul class='children'>
												<li><a href='index.php?opc=ventasdet'>Ventas Det.(Cif,USD,CANT)</a></li>
											</ul>
										</li>
										
										<li><a href='index.php?opc=ventmarca'>Venta por Marca</a></li>
									    <li><a href='index.php?opc=topvendedores'>Top Venta Vendedores</a>
											 <ul class='children'>
												<li><a href='index.php?opc=topvendedoresAir'>Top Venta Vendedores Aeropuerto</a></li>
											 </ul>
										</li>
										<li><a href='index.php?opc=infventa'>Informe de Ventas</a></li>
										<li><a href='index.php?opc=VentasDL'>Inf. Ventas Diarias DL</a></li>
								 </ul>
							</li>
							
							<li><a href='#'>Indicadores</a>
								 <ul class='children'>
									     <li><a href='index.php?opc=ventaMensual'>Venta del Año por Meses</a></li>
										 <li><a href='index.php?opc=ventaDiaMensual'>Venta Mensual por Días</a></li>
										 <li><a href='index.php?opc=ventaDiaria'>Venta Por Día de Semana</a></li>
										 <li><a href='index.php?opc=ventasHora'>Venta Mensual por Hora</a>
											 <ul class='children'>
												<li><a href='index.php?opc=ventaSemanaHora'>Venta Semanal por Hora</a></li>
											 </ul>
										 </li>
										 <li><a href='index.php?opc=ventmarca'>Venta por Marca</a></li>
								 </ul>
							</li>
							<li><a href='#'>Stocks</a>
								 <ul class='children'>
										<li><a href='index.php?opc=buscarCodigo'>Buscar Por Codigo</a></li>
										 <li><a href='index.php?opc=buscarCodigoBodega'>Buscar Por Codigo Bodega</a></li>
										 <li><a href='index.php?opc=stockMarcaBodega'>Stock por Marca Bodega</a>
										<li><a href='index.php?opc=stockMarca'>Stock por Marca</a>
										  <ul class='children'>
									    		 <li><a href='index.php?opc=stockMarcaAir'>Stock por Marca Apto.</a></li>
											 </ul>	
										</li>
										<li><a href='index.php?opc=stockMarcaBodegaLote'>Stock Bodega Lote</a>
										<li><a href='index.php?opc=kardex'>Kardex</a></li>
								 </ul>
							</li>
							 <li><a href='#'>Reportes Comerciales</a>
								 <ul class='children'>
										<li><a href='index.php?opc=estAuto'>Año 2020</a>
										<ul class='children'>
										<li><a target'_blank' href='../sisapone/archivos/Oct2020.xlsx'>Oct. 2020</a></li>
										<li><a target'_blank' href='../sisapone/archivos/Nov2020.xlsx'>Nov. 2020</a></li>
										<li><a target'_blank' href='../sisapone/archivos/Dic2020.xlsx'>Dic. 2020</a></li>
									   </ul>
										</li>
										<li><a href='index.php?opc=estAuto'>Año 2021</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisapone/archivos/Ene2021.xlsx'>Ene. 2021</a></li>
													</ul>
												</li>

										<li><a href='index.php?opc=maestroArticulos'>Maestro de Articulos</a></li>
										<li><a href='index.php?opc=unidadesVendidasMes'>Venta Unidades Mes</a></li>
										<li><a href='index.php?opc=StockPorMes'>Stock Por Mes</a></li>
										<li><a href='index.php?opc=ventasPorBM'>Ventas Por Brand Manager</a></li>
										<li><a href='index.php?opc=ventasPorProveedor'>Ventas Por Proveedor</a></li>
								 </ul>
							</li>
							<li><a href='index.php?opc=reporteCajaCont'>Caja</a>
									 <ul class='children'>
											<li><a href='index.php?opc=reporteCajaCont'>Informe de Cajas</a></li>
									 </ul>
							</li>
							<li><a href='#'>Requerimientos</a>
								 <ul class='children'>
										<li><a href='index.php?opc=req'>Solicitar Nuevo Requerimiento</a></li>
								 </ul>
							</li>
							<li><a href='#'>Docs</a>
								 <ul class='children'>
										<li><a target='_blank' href='../sisap/docs/manual%20Sistema%20de%20PEdidos'  >Manual Pedidos</a></li>
										<li><a target='_blank' href='../sisap/docs/Manual%20Requerimientos'  >Manual Requerimientos</a></li>
								 </ul>
							</li>
							
					   </ul>
				</div> ";
				
		} // fin menu para Visador
		
		 else if($_SESSION["usuario_rol"] == 4) //Menu para Brand Manager
		{ 
		   echo "	
				<div class='menu-secondary-wrap'>
						<ul class='menus menu-secondary'>
							
							<li><a href='index.php'>Inicio</a>
							  <ul class='children'>
							 	<li><a href='index.php?opc=traspasoMercaderia'>Traspaso Mercaderia</a></li>
								<li><a target='_blank' href='../sisap/docs/manual%20Sistema%20de%20PEdidos'  >Manual Pedidos</a></li>
								<li><a target='_blank' href='../sisap/docs/Manual%20Requerimientos'  >Manual Requerimientos</a></li>
								<li><a href='index.php?opc=logout'>Salir del Sistema</a></li>
							  </ul>
							</li>
							
							<li><a href='#'>Ventas</a>
								 <ul class='children'>
										<li><a href='index.php?opc=ventaspro'>Ventas Det. Zofri</a></li>
										<li><a href='index.php?opc=ventasproAir'>Ventas Det. Aeropuerto</a></li>
										<li><a href='index.php?opc=ventasmodulodet'>Ventas Modulos</a>
											<ul class='children'>
												<li><a href='index.php?opc=ventasdet'>Ventas Det.(Cif,USD,CANT)</a></li>
											</ul>
										</li>
										<li><a href='index.php?opc=comparativoRent'>Análisis Comparativo de Ventas con Rentabilidad</a></li>
									    <li><a href='index.php?opc=topvendedores'>Top Venta Vendedores</a>
											 <ul class='children'>
												<li><a href='index.php?opc=topvendedoresAir'>Top Venta Vendedores Aeropuerto</a></li>
											 </ul>
										</li>
								 </ul>
							</li>
							
							<li><a href='#'>Indicadores</a>
								 <ul class='children'>
									     <li><a href='index.php?opc=ventaMensual'>Venta del Año por Meses</a></li>
										 <li><a href='index.php?opc=ventaDiaMensual'>Venta Mensual por Días</a></li>
										 <li><a href='index.php?opc=ventaDiaria'>Venta Por Día de Semana</a></li>
										 <li><a href='index.php?opc=ventasHora'>Venta Mensual por Hora</a>
											 <ul class='children'>
												<li><a href='index.php?opc=ventaSemanaHora'>Venta Semanal por Hora</a></li>
											 </ul>
										 </li>
										 <li><a href='index.php?opc=ventmarca'>Venta por Marca</a></li>
								 </ul>
							</li>
							
						   
							
							<li><a href='#'>Stocks</a>
								 <ul class='children'>
										<li><a href='index.php?opc=buscarCodigo'>Buscar Por Codigo</a></li>
										 <li><a href='index.php?opc=buscarCodigoBodega'>Buscar Por Codigo Bodega</a></li>
										 <li><a href='index.php?opc=stockMarcaBodega'>Stock por Marca Bodega</a>
										<li><a href='index.php?opc=stockMarca'>Stock por Marca</a>
										  <ul class='children'>
									    		 <li><a href='index.php?opc=stockMarcaAir'>Stock por Marca Apto.</a></li>
											 </ul>	
										</li>
										<li><a href='index.php?opc=kardex'>Kardex</a></li>
								 </ul>
							</li>
							
							
							<li><a href='index.php?opc=nuevaSolicitudbrand' >Solicitudes <span class='burbuja'>0</span></a>
							</li>
							<li><a href='#'>Promociones</a>
								<ul class='children'>
								<li><a href='index.php?opc=mantenedorProm'>Promociones</a></li>
								<li><a href='index.php?opc=familyF'>Family and Friends</a></li>
								</ul>
							</li>
							
							
							  <li><a href='#'>Reportes Comerciales</a>
								 <ul class='children'>
										<li><a href='index.php?opc=estAuto'>Estadistico Automatico</a>
											<ul class='children'>
											    <li><a href='index.php?opc=estAuto'>Año 2014</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisap/archivos/Nov2014.xlsx'>Nov. 2014</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Dic2014.xlsx'>Dic. 2014</a></li>
													</ul>
												</li>
												<li><a href='index.php?opc=estAuto'>Año 2015</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisap/archivos/Ene2015.xlsx'>Ene. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Feb2015.xlsx'>Feb. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Mar2015.xlsx'>Mar. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Abr2015.xlsx'>Abr. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/May2015.xlsx'>May. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Jun2015.xlsx'>Jun. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Jul2015.xlsx'>Jul. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Ago2015.xlsx'>Ago. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Sep2015.xlsx'>Sep. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Oct2015.xlsx'>Oct. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Nov2015.xlsx'>Nov. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Dic2015.xlsx'>Dic. 2015</a></li>
												    </ul>
												</li>
												<li><a href='index.php?opc=estAuto'>Año 2016</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisap/archivos/Ene2016.xlsx'>Ene. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Feb2016.xlsx'>Feb. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Mar2016.xlsx'>Mar. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Abr2016.xlsx'>Abr. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/May2016.xlsx'>May. 2016</a></li>  
													 <li><a target'_blank' href='../sisap/archivos/Jun2016.xlsx'>Jun. 2016</a></li>  
													 <li><a target'_blank' href='../sisap/archivos/Jul2016.xlsx'>Jul. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Ago2016.xlsx'>Ago. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Sep2016.xlsx'>Sep. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Oct2016.xlsx'>Oct. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Nov2016.xlsx'>Nov. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Dic2016.xlsx'>Dic. 2016</a></li>
												    </ul>
												</li>
												<li><a href='index.php?opc=estAuto'>Año 2017</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisap/archivos/Ene2017.xlsx'>Ene. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Feb2017.xlsx'>Feb. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Mar2017.xlsx'>Mar. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Abr2017.xlsx'>Abr. 2017</a></li>													 
													 <li><a target'_blank' href='../sisap/archivos/May2017.xlsx'>May. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Jun2017.xlsx'>Jun. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Jul2017.xlsx'>Jul. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Ago2017.xlsx'>ago. 2017</a></li>
													  <li><a target'_blank' href='../sisap/archivos/sep2017.xlsx'>Sep. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/oct2017.xlsx'>Oct. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/nov2017.xlsx'>Nov. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/dic2017.xlsx'>Dic. 2017</a></li>
												    </ul>
												</li>
										        <li><a href='index.php?opc=estAuto'>Año 2018</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisap/archivos/ene2018.xlsx'>Ene. 2018</a></li>
													  <li><a target'_blank' href='../sisap/archivos/feb2018.xlsx'>Feb. 2018</a></li>
													 <li><a target'_blank' href='../sisap/archivos/mar2018.xlsx'>Mar. 2018</a></li>
												    </ul>
												</li>
												<li><a href='index.php?opc=estAuto'>Año 2020</a>
												<ul class='children'>
												<li><a target'_blank' href='../sisapone/archivos/Oct2020.xlsx'>Oct. 2020</a></li>
												<li><a target'_blank' href='../sisapone/archivos/Nov2020.xlsx'>Nov. 2020</a></li>
												<li><a target'_blank' href='../sisapone/archivos/Dic2020.xlsx'>Dic. 2020</a></li>
											   </ul>
												</li>
												<li><a href='index.php?opc=estAuto'>Año 2021</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisapone/archivos/Ene2021.xlsx'>Ene. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Feb2021.xlsx'>Feb. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Mar2021.xlsx'>Mar. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Abr2021.xlsx'>Abr. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/May2021.xlsx'>May. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Jun2021.xlsx'>Jun. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Jul2021.xlsx'>Jul. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Ago2021.xlsx'>Ago. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Sep2021.xlsx'>Sep. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Oct2021.xlsx'>Oct. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Nov2021.xlsx'>Nov. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Dic2021.xlsx'>Dic. 2021</a></li>
													 </ul>
												</li>
												<li><a href='index.php?opc=estAuto'>Año 2022</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisapone/archivos/Ene2022.xlsx'>Ene. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Feb2022.xlsx'>Feb. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Mar2022.xlsx'>Mar. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Abr2022.xlsx'>Abr. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/May2022.xlsx'>May. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Jun2022.xlsx'>Jun. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Jul2022.xlsx'>Jul. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Ago2022.xlsx'>Ago. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Sep2022.xlsx'>Sep. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Oct2022.xlsx'>Oct. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Nov2022.xlsx'>Nov. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Dic2022.xlsx'>Dic. 2022</a></li>
													</ul>
												</li>
												<li><a href='index.php?opc=estAuto'>Año 2023</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisapone/archivos/Ene2023.xlsx'>Ene. 2022</a></li>
													</ul>
												</li>
										    </ul>
										</li>
																			
										
										<li><a href='../sisap/archivos/ComMarcas.xlsx'>Comparativo Marcas</a></li>
										<li><a href='index.php?opc=maestroArticulos'>Maestro de Articulos</a></li>
										<li><a href='index.php?opc=unidadesVendidasMes'>Venta Unidades Mes</a></li>
										<li><a href='index.php?opc=StockPorMes'>Stock Por Mes</a></li>
										<li><a href='index.php?opc=ventasPorBM'>Ventas Por BM</a></li>
										<li><a href='index.php?opc=ventasPorProveedor'>Ventas Por Proveedor</a></li>
										<li><a href='index.php?opc=ventasPorVendedor'>Ventas Por Vendedor</a></li>
										<li><a href='index.php?opc=reporteStock'>Reporte Stock & Ventas</a></li>
										<li><a href='index.php?opc=ventasAnuales'>Ventas Anuales</a></li>
										<li><a href='index.php?opc=compaVenta'>Informe Comparativo de Ventas</a></li>
										<li><a href='index.php?opc=ventasPorHistorico'>Ventas Por Historico</a></li>
										<li><a href='index.php?opc=reporteHistorico'>Reporte Histórico</a></li>
								 </ul>
							</li>
							<!--<li><a href='#'>R. Automatizados</a>
								 <ul class='children'>
										<li><a href='index.php?opc=reporteHistorico'>Reporte Histórico</a></li>
										<li><a href='index.php?opc=listaPrecio'>Lista de precio Área comercial / Comite ejecutivo</a></li>
										<li><a href='index.php?opc=listaPrecioMod'>Lista de precio Módulos</a></li>
										<li><a href='index.php?opc=abastecimiento'>Reporte de Abastecimiento</a></li>
								 </ul>
							</li>-->
							<li><a href='#'>Reqs</a>
								 <ul class='children'>
										<li><a href='index.php?opc=req'>Solicitar Nuevo Requerimiento</a></li>
								 </ul>
							</li>
							<li><a href='#'>Cannes 2016</a>
										<ul class='children'>
											<li><a href='#'>AGOSTO 2016</a>
												<ul class='children'>
													<li><a href='historicos/Agosto2016/BPI_2016-08.zip'>BPI</a>
													<li><a href='historicos/Agosto2016/C.DIOR_2016-08.zip'>C.DIOR</a>
													<li><a href='historicos/Agosto2016/CLARINS_2016-08.zip'>CLARINS</a>
													<li><a href='historicos/Agosto2016/COTY_2016-08.zip'>COTY</a>
													<li><a href='historicos/Agosto2016/ESSENCE_2016-08.zip'>ESSENCE</a>
													<li><a href='historicos/Agosto2016/EUROITALIA_2016-08.zip'>EUROITALIA</a>
													<li><a href='historicos/Agosto2016/HERMES_2016-08.zip'>HERMES</a>
													<li><a href='historicos/Agosto2016/IDESA_2016-08.zip'>IDESA</a>
													<li><a href='historicos/Agosto2016/INTER_P_2016-08.zip'>INTER_P</a>
													<li><a href='historicos/Agosto2016/LOEWE_2016-08.zip'>LOEWE</a>
													<li><a href='historicos/Agosto2016/MAVIVE_2016-08.zip'>MAVIVE</a>
													<li><a href='historicos/Agosto2016/MILLENIUM_2016-08.zip'>MILLENIUM</a>
													<li><a href='historicos/Agosto2016/PARBEL_2016-08.zip'>PARBEL</a>
													<li><a href='historicos/Agosto2016/PUIG_2016-08.zip'>PUIG</a>
													<li><a href='historicos/Agosto2016/REVLON_2016-08.zip'>REVLON</a>
													<li><a href='historicos/Agosto2016/RICHEMONT_2016-08.zip'>RICHEMONT</a>
													<li><a href='historicos/Agosto2016/SALVATORE_FERRAGAMO_2016-08.zip'>SALVATORE_FERRAGAMO</a>
													<li><a href='historicos/Agosto2016/ST.HONORE_2016-08.zip'>ST.HONORE</a>
													<li><a href='historicos/Agosto2016/ELIZABETH_ARDEN_2016-08.zip'>ELIZABETH_ARDEN</a>
													<li><a href='historicos/Agosto2016/BERDOUES_2016-08.zip'>BERDOUES</a>
													<li><a href='historicos/Agosto2016/LVMH_2016-08.zip'>LVMH</a>
													<li><a href='historicos/Agosto2016/MOURE_2016-08.zip'>MOURE</a>
													<li><a href='historicos/Agosto2016/BVLGARI_2016-08.zip'>BVLGARI</a>
													<li><a href='historicos/Agosto2016/TED_LAPIDUS_2016-08.zip'>TED_LAPIDUS</a>
													<li><a href='historicos/Agosto2016/EUROCOSMESI_2016-08.zip'>EUROCOSMESI</a>
												</ul>
											</li>
										</ul>
							</li>
							
					   </ul>
				</div> <!-- Menu Brand Manager --> ";
				
		 } // fin menu brand manager
		 
		 else if($_SESSION["usuario_rol"] == 5) //Menu para Inventario
		  { 
		 	echo "	
				<div class='menu-secondary-wrap'>
						<ul class='menus menu-secondary'>
							
							<li><a href='index.php'>Inicio</a>
							  <ul class='children'>
								<li><a href='index.php?opc=logout'>Salir del Sistema</a></li>
							  </ul>
							</li>
							<li><a href='#'>Vendedores</a>
								 <ul class='children'>
										<li><a href='index.php?opc=ventaspro'>Ventas Det. Zofri</a></li>
										<li><a href='index.php?opc=ventasproAir'>Ventas Det. Aeropuerto</a></li>
										<li><a href='index.php?opc=ventasmodulodet'>Ventas Modulos</a>
											<ul class='children'>
												<li><a href='index.php?opc=ventasdet'>Ventas Det.(Cif,USD,CANT)</a></li>
											</ul>
										</li>
									    <li><a href='index.php?opc=topvendedores'>Top Venta Vendedores</a>
											 <ul class='children'>
												<li><a href='index.php?opc=topvendedoresAir'>Top Venta Vendedores Aero.</a></li>
											 </ul>
										</li>
										<li><a href='index.php?opc=horaPunta'>Hora Punta</a></li>
										<li><a href='index.php?opc=ventmarca'>Venta por Marca</a></li>
										<li><a href='index.php?opc=infventa'>Informe de Ventas</a></li>
										<li><a href='index.php?opc=buscarCodigo'>Buscar Por Codigo</a></li>
										<li><a href='index.php?opc=buscarCodigoBodega'>Buscar Por Codigo Bodega</a></li>
										<li><a href='index.php?opc=stockMarcaBodega'>Stock por Marca Bodega</a>
										<li><a href='index.php?opc=stockMarca'>Stock por Marca</a>
											<ul class='children'>
									    		 <li><a href='index.php?opc=stockMarcaAir'>Stock por Marca Apto.</a></li>
											 </ul>	
										</li>
										<li><a href='index.php?opc=compararCodigos'>Comparar Codigos</a></li>
										<li><a href='index.php?opc=stockMarcaBodegaLote'>Stock Bodega Lote</a>
										<!-- <li><a href='index.php?opc=infcaja'>Informe de Cajas</a></li>-->
								 </ul>
							</li>
							
						  <!--  <li><a href='#'>Marcas</a>
								 <ul class='children'>
									     <li><a href='index.php?opc=ventapormarca'>Ventas por Marca</a></li>
								 </ul>
							</li>-->
							
							<!--<li><a href='#'>Notas de Credito</a>
								 <ul class='children'>
									     <li><a href='index.php?opc=notaCredito'>Detalle N. Credito</a></li>
								 </ul>
							</li>-->
							
							<!--<li><a href='#'>Bodega</a>
								 <ul class='children'>
									     <li><a href='index.php?opc=bodega'>Bodega</a></li>
										 
								 </ul>
							</li>-->
							
							<li><a href='#'>Graficos</a>
								 <ul class='children'>
									     <li><a href='index.php?opc=ventaMensual'>Venta del Año por Meses</a></li>
										  <!--<li><a href='index.php?opc=ventaMensualPuig'>Venta en meses PUIGs</a></li>-->
										 <li><a href='index.php?opc=ventaDiaMensual'>Venta Mensual por Días</a></li>
										 <li><a href='index.php?opc=ventaDiaria'>Venta Por Día de Semana</a></li>
										 <li><a href='index.php?opc=ventasHora'>Venta Mensual por Hora</a>
										 <li><a href='index.php?opc=ventasHoraAir'>Venta Mensual por Hora Aero.</a>
											 <ul class='children'>
												<!--<li><a href='index.php?opc=ventaSemanaHora'>Venta Semanal por Hora</a></li>-->
											 </ul>
										 </li>
								 </ul>
							</li>
							<li><a href='index.php?opc=kardex'>Kardex</a></li>
							<li><a href='index.php?opc=infcaja'>Caja</a>
									 <ul class='children'>
											<li><a href='index.php?opc=infcaja'>Informe de Cajas</a></li>
									 </ul>
								</li>
							
							
					     	<li><a href='#'>Brand Manager</a>
								 <ul class='children'>
										<li><a href='index.php?opc=ventasBM'>Ventas BM</a></li>
							 </ul>
							 
							 <!--<li><a href='#'>DSM</a>
								 <ul class='children'>
										<li><a href='index.php?opc=validarDsm'>Validar</a></li>
										<li><a href='index.php?opc=historialDsm'>Historial</a></li>
							 </ul>-->
							<li><a href='#'>DEM</a>
								 <ul class='children'>
										<li><a href='index.php?opc=validarDEM'>Validar DEM</a></li>
										<li><a href='index.php?opc=dem'>Listado Documentos DEM</a></li>
							 	</ul>
								</li>
							<!--<li><a href='#'>ZETA</a>
								<ul class='children'>
										<li><a href='index.php?opc=consultarzeta'>Consultar Zeta</a>
										<li><a href='index.php?opc=#'>Otro</a>
								</ul>
							</li>-->
							<!--<li>
							<a href='#'>Metas</a>
								<ul class='children'>
										<li><a href='index.php?opc=metasTienda'>Metas por Tienda</a></li>
									
								</ul>
							</li>-->
							
							<li><a href='#'>Usuarios</a>
								 <ul class='children'>
										<li><a href='index.php?opc=usuarios'>Usuarios</a></li>
								 </ul>
							</li>
							<!--<li><a href='#' id='solestado'>Solicitudes</a>
								 <ul class='children'>
										<li><a href='index.php?opc=nuevaSolicitud'>Nueva Solicitud</a></li>
								 </ul>
							</li>-->
							
							<li><a href='#'>Requerimientos</a>
								 <ul class='children'>
										<li><a href='index.php?opc=req'>Solicitar Nuevo Requerimiento</a></li>
										<li><a target='_blank' href='../sisap/docs/Manual%20Requerimientos'  >Manual Requerimientos</a></li>
								 </ul>
							</li>	
							
							<li><a  href='index.php?opc=avisos'>Avisos</a></li>
							<!--<li><a  href='index.php?opc=transferencias'>transferencias</a></li>-->
							 
						 </ul>
					</div> <!-- fin menu -->";
		 } // fin menu Inventario else
		 else if($_SESSION["usuario_rol"] == 6) // Menu para Bodega
   		    { 
		 	echo "	
				<div class='menu-secondary-wrap'>
						<ul class='menus menu-secondary'>
							
							<li><a href='index.php'>Inicio</a>
							  <ul class='children'>
							  <li><a href='index.php?opc=cmando'>Cuadro de Mando</a></li>
							  <li><a href='index.php?opc=cmandoBoletas'>Cuadro de Mando Centralización de Boletas</a></li>
							  <li><a href='index.php?opc=logout'>Salir del Sistema</a></li>								
							  </ul>
							</li>
							
							<li><a href='#'>Bodega</a>
								 <ul class='children'>
										<li><a href='index.php?opc=maestroArticulos'>Maestro de Articulos</a></li>
										<li><a href='index.php?opc=genEtiqueta'>Generar Etiqueta</a></li>
										<li><a href='index.php?opc=compararCodigos'>Comparar Codigos</a></li>
										<li><a href='index.php?opc=buscarCodigo'>Buscar Por Codigo</a></li>
										<li><a href='index.php?opc=buscarCodigoBodega'>Buscar Por Codigo Bodega</a></li>
										<li><a href='index.php?opc=stockMarcaBodega'>Stock por Marca Bodega</a>
										<li><a href='index.php?opc=stockMarcaBodegaLote'>Stock Bodega Lote</a>
										<li><a href='index.php?opc=stockMarca'>Stock por Marca</a>
											<ul class='children'>
									    		 <li><a href='index.php?opc=stockMarcaAir'>Stock por Marca Apto.</a></li>
											 </ul>	
										</li>
										<li><a href='index.php?opc=kardex'>Kardex</a></li>
								 </ul>
							</li>
							

					</div> <!-- fin menu -->";
			} 
			// fin menu para Bodega
		  if($_SESSION["usuario_rol"] == 9) // Menu para Finanzas
   		    { 
		 	echo "	
				<div class='menu-secondary-wrap'>
						<ul class='menus menu-secondary'>
							
							<li><a href='index.php'>Inicio</a>
							    <ul class='children'>
								 <li><a href='index.php?opc=logout'>Salir del Sistema</a></li>
							  </ul>
							</li>
							
							<li><a href='#'>Vendedores</a>
							  <ul class='children'>
									<li><a href='index.php?opc=ventaspro'>Ventas Det. Zofri</a></li>
									<li><a href='index.php?opc=ventasproAir'>Ventas Det. Aeropuerto</a></li>
									<li><a href='index.php?opc=ventasmodulodet'>Ventas Modulos</a>
										<ul class='children'>
											<li><a href='index.php?opc=ventasdet'>Ventas Det.(Cif,USD,CANT)</a></li>
										</ul>
									</li>
									<li><a href='index.php?opc=movDoc'>Mov. de Documentos Módulo</a></li>
									<li><a href='index.php?opc=topvendedores'>Top Venta Vendedores</a>
										<ul class='children'>
											<li><a href='index.php?opc=topvendedoresAir'>Top Venta Vendedores Aero.</a></li>
										</ul>
									</li>
										
										<li><a href='index.php?opc=horaPunta'>Hora Punta</a></li>
										<li><a href='index.php?opc=ventmarca'>Venta por Marca</a></li>
										<li><a href='index.php?opc=infventa'>Informe de Ventas</a></li>
										<li><a href='index.php?opc=buscarCodigo'>Buscar Por Codigo</a></li>
										<li><a href='index.php?opc=buscarCodigoBodega'>Buscar Por Codigo Bodega</a></li>
										<li><a href='index.php?opc=stockMarcaBodega'>Stock por Marca Bodega</a>
										<li><a href='index.php?opc=stockMarcaBodegaLote'>Stock Bodega Lote</a>
										<li><a href='index.php?opc=stockMarca'>Stock por Marca</a>
											<ul class='children'>
									    		 <li><a href='index.php?opc=stockMarcaAir'>Stock por Marca Apto.</a></li>
											 </ul>	
										</li>
										<li><a href='index.php?opc=compararCodigos'>Comparar Codigos</a></li>
										<!-- <li><a href='index.php?opc=infcaja'>Informe de Cajas</a></li>-->
								 </ul>
							</li>
							
						 	<li><a href='#'>TransBank</a>
								<ul class='children'>
										<li><a href='index.php?opc=transbank'>TransBank</a></li>
										<li><a href='index.php?opc=abono'>Abonar</a></li>
								</ul>
							</li>				
							
														
							<li><a href='#'>Graficos</a>
								 <ul class='children'>
									     <li><a href='index.php?opc=ventaMensual'>Venta del Año por Meses</a></li>
										  <!--<li><a href='index.php?opc=ventaMensualPuig'>Venta en meses PUIGs</a></li>-->
										 <li><a href='index.php?opc=ventaDiaMensual'>Venta Mensual por Días</a></li>
										 <li><a href='index.php?opc=ventaDiaria'>Venta Por Día de Semana</a></li>
										 <li><a href='index.php?opc=ventasHora'>Venta Mensual por Hora</a>
										 <li><a href='index.php?opc=ventasHoraAir'>Venta Mensual por Hora Aero.</a>
											 <ul class='children'>
												<!--<li><a href='index.php?opc=ventaSemanaHora'>Venta Semanal por Hora</a></li>-->
											 </ul>
										 </li>
										 <!--<li><a href='index.php?opc=paretoABC'>Clasificación de Productos</a></li>-->
								 </ul>
							</li>
							
							<li><a href='index.php?opc=reporteCajaCont'>Caja</a>
									 <ul class='children'>
											<li><a href='index.php?opc=reporteCajaCont'>Informe de Cajas</a></li>
									 </ul>
							</li>
							
							<li><a href='index.php?opc=impuesto'>Impuestos</a>
									 <ul class='children'>
											<li><a href='index.php?opc=impuestoMay'>Impuesto Mayorista</a></li>
									 </ul> 
							</li>
							
							
					     	<li><a href='#'>Requerimientos</a>
								 <ul class='children'>
										<li><a href='index.php?opc=req'>Solicitar Nuevo Requerimiento</a></li>
										<li><a target='_blank' href='../sisap/docs/Manual%20Requerimientos'  >Manual Requerimientos</a></li>
								 </ul>
							</li>								
							
							<li><a  href='index.php?opc=avisos'>Avisos</a></li>
							
							 
							
						 </ul>
					</div> <!-- fin menu -->";
			} // fin menu Contabilidad y finanzas
			else if($_SESSION["usuario_rol"] == 10) //Ejecutivo menu
   		    { 
		 	 echo "	
				<div class='menu-secondary-wrap'>
						<ul class='menus menu-secondary'>
							
							<li><a href='index.php'>Inicio</a>
							  <ul class='children'>
								<li><a href='index.php?opc=logout'>Salir del Sistema</a></li>
							  </ul>
							</li>
							
							<li><a href='#'>Ventas</a>
								 <ul class='children'>
										<li><a href='index.php?opc=ventaspro'>Ventas Det. Zofri</a></li>
										<li><a href='index.php?opc=ventasproAir'>Ventas Det. Aeropuerto</a></li>
										<li><a href='index.php?opc=comparativo'>Análisi Comparativo Ventas Rent</a></li>
										<!-- <li><a href='index.php?opc=comparativoRent'>Análisis Comparativo de Ventas con Rentabilidad</a></li> -->
										<li><a href='index.php?opc=ventasmodulodet'>Ventas Modulos</a>
											<ul class='children'>
												<li><a href='index.php?opc=ventasdet'>Ventas Det.(Cif,USD,CANT)</a></li>
											</ul>
										</li>
										<li><a href='index.php?opc=ventmarca'>Venta por Marca</a></li>
									    <li><a href='index.php?opc=topvendedores'>Top Venta Vendedores</a>
											 <ul class='children'>
												<li><a href='index.php?opc=topvendedoresAir'>Top Venta Vendedores Aeropuerto</a></li>
											 </ul>
										</li>
										
								 </ul>
							</li>
							
							<li><a href='#'>Indicadores</a>
								 <ul class='children'>
								         <li><a href='index.php?opc=campania'>Campaña Fin de Año</a></li>	
									     <li><a href='index.php?opc=ventaMensual'>Venta del Año por Meses</a></li>
										 <li><a href='index.php?opc=ventaDiaMensual'>Venta Mensual por Días</a></li>
										 <li><a href='index.php?opc=ventaDiaria'>Venta Por Día de Semana</a></li>
										 <li><a href='index.php?opc=ventasHora'>Venta Mensual por Hora</a>
											 <ul class='children'>
												<li><a href='index.php?opc=ventaSemanaHora'>Venta Semanal por Hora</a></li>
											 </ul>
										 </li>
										 <li><a href='index.php?opc=ventmarca'>Venta por Marca</a></li>
								 </ul>
							</li>
							
						   
							
							<li><a href='#'>Stocks</a>
								 <ul class='children'>
										<li><a href='index.php?opc=buscarCodigo'>Buscar Por Codigo</a></li>
										 <li><a href='index.php?opc=buscarCodigoBodega'>Buscar Por Codigo Bodega</a></li>
										 <li><a href='index.php?opc=stockMarcaBodega'>Stock por Marca Bodega</a>
										<li><a href='index.php?opc=stockMarca'>Stock por Marca</a>
										  <ul class='children'>
									    		 <li><a href='index.php?opc=stockMarcaAir'>Stock por Marca Apto.</a></li>
											 </ul>	
										</li>
										<li><a href='index.php?opc=kardex'>Kardex</a></li>
								 </ul>
							</li>
							
							
							
							
							 <li><a href='#'>Reportes Comerciales</a>
								 <ul class='children'>
										<li><a href='index.php?opc=estAuto'>Estadistico Automatico</a>
											<ul class='children'>
											    <li><a href='index.php?opc=estAuto'>Año 2014</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisap/archivos/Nov2014.xlsx'>Nov. 2014</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Dic2014.xlsx'>Dic. 2014</a></li>
													</ul>
												</li>
												<li><a href='index.php?opc=estAuto'>Año 2015</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisap/archivos/Ene2015.xlsx'>Ene. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Feb2015.xlsx'>Feb. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Mar2015.xlsx'>Mar. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Abr2015.xlsx'>Abr. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/May2015.xlsx'>May. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Jun2015.xlsx'>Jun. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Jul2015.xlsx'>Jul. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Ago2015.xlsx'>Ago. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Sep2015.xlsx'>Sep. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Oct2015.xlsx'>Oct. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Nov2015.xlsx'>Nov. 2015</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Dic2015.xlsx'>Dic. 2015</a></li>
												    </ul>
												</li>
												<li><a href='index.php?opc=estAuto'>Año 2016</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisap/archivos/Ene2016.xlsx'>Ene. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Feb2016.xlsx'>Feb. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Mar2016.xlsx'>Mar. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Abr2016.xlsx'>Abr. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/May2016.xlsx'>May. 2016</a></li>  
													 <li><a target'_blank' href='../sisap/archivos/Jun2016.xlsx'>Jun. 2016</a></li>  
													 <li><a target'_blank' href='../sisap/archivos/Jul2016.xlsx'>Jul. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Ago2016.xlsx'>Ago. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Sep2016.xlsx'>Sep. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Oct2016.xlsx'>Oct. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Nov2016.xlsx'>Nov. 2016</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Dic2016.xlsx'>Dic. 2016</a></li>
												    </ul>
												</li>
												<li><a href='index.php?opc=estAuto'>Año 2017</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisap/archivos/Ene2017.xlsx'>Ene. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Feb2017.xlsx'>Feb. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Mar2017.xlsx'>Mar. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Abr2017.xlsx'>Abr. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/May2017.xlsx'>May. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Jun2017.xlsx'>Jun. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Jul2017.xlsx'>Jul. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/Ago2017.xlsx'>ago. 2017</a></li>
													  <li><a target'_blank' href='../sisap/archivos/sep2017.xlsx'>Sep. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/oct2017.xlsx'>Oct. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/nov2017.xlsx'>Nov. 2017</a></li>
													 <li><a target'_blank' href='../sisap/archivos/dic2017.xlsx'>Dic. 2017</a></li>
												    </ul>
												</li>
												<li><a href='index.php?opc=estAuto'>Año 2018</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisap/archivos/ene2018.xlsx'>Ene. 2018</a></li>
													  <li><a target'_blank' href='../sisap/archivos/feb2018.xlsx'>Feb. 2018</a></li>
													 <li><a target'_blank' href='../sisap/archivos/mar2018.xlsx'>Mar. 2018</a></li>
												    </ul>
												</li>
												
												<li><a href='index.php?opc=estAuto'>Año 2020</a>
												<ul class='children'>
												<li><a target'_blank' href='../sisapone/archivos/Oct2020.xlsx'>Oct. 2020</a></li>
												<li><a target'_blank' href='../sisapone/archivos/Nov2020.xlsx'>Nov. 2020</a></li>
												<li><a target'_blank' href='../sisapone/archivos/Dic2020.xlsx'>Dic. 2020</a></li>
											   </ul>
												</li>
												<li><a href='index.php?opc=estAuto'>Año 2021</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisapone/archivos/Ene2021.xlsx'>Ene. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Feb2021.xlsx'>Feb. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Mar2021.xlsx'>Mar. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Abr2021.xlsx'>Abr. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/May2021.xlsx'>May. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Jun2021.xlsx'>Jun. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Jul2021.xlsx'>Jul. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Ago2021.xlsx'>Ago. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Sep2021.xlsx'>Sep. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Oct2021.xlsx'>Oct. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Nov2021.xlsx'>Nov. 2021</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Dic2021.xlsx'>Dic. 2021</a></li>
													</ul>
												</li>
										    	<li><a href='index.php?opc=estAuto'>Año 2022</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisapone/archivos/Ene2022.xlsx'>Ene. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Feb2022.xlsx'>Feb. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Mar2022.xlsx'>Mar. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Abr2022.xlsx'>Abr. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/May2022.xlsx'>May. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Jun2022.xlsx'>Jun. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Jul2022.xlsx'>Jul. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Ago2022.xlsx'>Ago. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Sep2022.xlsx'>Sep. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Oct2022.xlsx'>Oct. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Nov2022.xlsx'>Nov. 2022</a></li>
													 <li><a target'_blank' href='../sisapone/archivos/Dic2022.xlsx'>Dic. 2022</a></li>
													</ul>
												</li>
												<li><a href='index.php?opc=estAuto'>Año 2023</a>
													<ul class='children'>
													 <li><a target'_blank' href='../sisapone/archivos/Ene2023.xlsx'>Ene. 2022</a></li>
													</ul>
												</li>
										    </ul>
										</li>
										<li><a href='../sisap/archivos/ComMarcas.xlsx'>Comparativo Marcas</a></li>
										<li><a href='index.php?opc=ventasPorHistorico'>Informe Historico</a></li>
										<li><a href='index.php?opc=maestroArticulos'>Maestro de Articulos</a></li>
										<li><a href='index.php?opc=unidadesVendidasMes'>Venta Unidades Mes</a></li>
										<li><a href='index.php?opc=StockPorMes'>Stock Por Mes</a></li>
										<li><a href='index.php?opc=ventasPorBM'>Ventas Por Brand Manager</a></li>
										<li><a href='index.php?opc=ventasPorProveedor'>Ventas Por Proveedor</a></li>
										<li><a href='index.php?opc=reporteHistorico'>Reporte Histórico</a></li>
										<li><a href='index.php?opc=ventasAnuales'>VENTAS HISTORICAS US$ - LVT</a></li>
									<li><a href='index.php?opc=compaVenta'>COMPARATIVO DE VENTAS MENSUALES EN PESOS MODULOS - LVT</a></li>
								 </ul>
							</li>
							<li><a href='#'>Requerimientos</a>
								 <ul class='children'>
										<li><a href='index.php?opc=req'>Solicitar Nuevo Requerimiento</a></li>
								 </ul>
							</li>
							<li><a href='#'>Docs</a>
								 <ul class='children'>
										<li><a target='_blank' href='../sisap/docs/manual%20Sistema%20de%20PEdidos'  >Manual Pedidos</a></li>
										<li><a target='_blank' href='../sisap/docs/Manual%20Requerimientos'  >Manual Requerimientos</a></li>
								 </ul>
							</li>
							<li><a href='#'>Reportes Cannes 2016</a>
										<ul class='children'>
											<li><a href='#'>AGOSTO 2016</a>
												<ul class='children'>
													<li><a href='historicos/Agosto2016/BPI_2016-08.zip'>BPI</a>
													<li><a href='historicos/Agosto2016/C.DIOR_2016-08.zip'>C.DIOR</a>
													<li><a href='historicos/Agosto2016/CLARINS_2016-08.zip'>CLARINS</a>
													<li><a href='historicos/Agosto2016/COTY_2016-08.zip'>COTY</a>
													<li><a href='historicos/Agosto2016/ESSENCE_2016-08.zip'>ESSENCE</a>
													<li><a href='historicos/Agosto2016/EUROITALIA_2016-08.zip'>EUROITALIA</a>
													<li><a href='historicos/Agosto2016/HERMES_2016-08.zip'>HERMES</a>
													<li><a href='historicos/Agosto2016/IDESA_2016-08.zip'>IDESA</a>
													<li><a href='historicos/Agosto2016/INTER_P_2016-08.zip'>INTER_P</a>
													<li><a href='historicos/Agosto2016/LOEWE_2016-08.zip'>LOEWE</a>
													<li><a href='historicos/Agosto2016/LVMH_2016-08.zip'>LVMH</a>
													<li><a href='historicos/Agosto2016/MAVIVE_2016-08.zip'>MAVIVE</a>
													<li><a href='historicos/Agosto2016/MILLENIUM_2016-08.zip'>MILLENIUM</a>
													<li><a href='historicos/Agosto2016/PARBEL_2016-08.zip'>PARBEL</a>
													<li><a href='historicos/Agosto2016/PUIG_2016-08.zip'>PUIG</a>
													<li><a href='historicos/Agosto2016/REVLON_2016-08.zip'>REVLON</a>
													<li><a href='historicos/Agosto2016/RICHEMONT_2016-08.zip'>RICHEMONT</a>
													<li><a href='historicos/Agosto2016/SALVATORE_FERRAGAMO_2016-08.zip'>SALVATORE_FERRAGAMO</a>
													<li><a href='historicos/Agosto2016/ST.HONORE_2016-08.zip'>ST.HONORE</a>
													<li><a href='historicos/Agosto2016/ELIZABETH_ARDEN_2016-08.zip'>ELIZABETH_ARDEN</a>
													<li><a href='historicos/Agosto2016/BERDOUES_2016-08.zip'>BERDOUES</a>
													<li><a href='historicos/Agosto2016/LVMH_2016-08.zip'>LVMH</a>
													<li><a href='historicos/Agosto2016/MOURE_2016-08.zip'>MOURE</a>
													<li><a href='historicos/Agosto2016/BVLGARI_2016-08.zip'>BVLGARI</a>
													<li><a href='historicos/Agosto2016/TED_LAPIDUS_2016-08.zip'>TED_LAPIDUS</a>
													<li><a href='historicos/Agosto2016/EUROCOSMESI_2016-08.zip'>EUROCOSMESI</a>
												</ul>
											</li>
										</ul>
									</li>
					   </ul>
				</div> ";
			} // fin menu para Ejecutivo
			  
			
		 
		 
		 else if($_SESSION["usuario_rol"] == 11) //Menu para Vendedores de AEROPUERTO
		  	{ 
		 
			  echo "	
					<div class='menu-secondary-wrap'>
							<ul class='menus menu-secondary'>
								
								<li><a href='index.php'>Inicio</a>
									 <ul class='children'>
										    <li><a href='index.php?opc=logout'>Salir del Sistema</a></li>
								     </ul>
								</li>
								
								<li><a href='#'>Vendedores</a>
									 <ul class='children'>
											<li><a href='index.php?opc=ventasproAir'>Ventas por Fecha</a></li>
											<li><a href='index.php?opc=topvendedoresAir'>Top Vendedores Aero.</a></li>
											
									 </ul>
								</li>
								
								 <li><a href='#'>DSM</a>
								 <ul class='children'>
										<li><a  href='index.php?opc=dsmAir'>Validar Documentos</a></li>
						    	 </ul>
								
								<li><a href='index.php?opc=infcaja'>Caja</a>
									 <ul class='children'>
											<li><a href='index.php?opc=infcaja'>Informe de Cajas</a></li>
									 </ul>
								</li>
								
								<li><a href='#'>Stocks</a>
								 <ul class='children'>
										<li><a href='index.php?opc=buscarCodigo'>Buscar Por Codigo</a></li>
										<li><a href='index.php?opc=stockMarcaAir'>Stock por Marca</a>
										<li><a href='index.php?opc=kardex'>Kardex</a></li>
								 </ul>
							</li>
								
								<li><a href='index.php?opc=nuevaSolicitud' id='solestado' >SolicitudesAir</a></li>
								<li><a target='_blank' href='http://192.168.3.41:8080/sisap/docs/manual%20Sistema%20de%20PEdidos'  >Manual Pedidos</a></li>
								<li><a href='#'>Requerimientos</a>
									<ul class='children'>
										<li><a href='index.php?opc=req'>Solicitar Nuevo Requerimiento</a></li>
										<li><a target='_blank' href='../sisap/docs/Manual%20Requerimientos'  >Manual Requerimientos</a></li>
									</ul>
								</li>
						  </ul>
						  
				   </div> <!-- Menu Vendedores --> ";
		 } // fin menu para vendedores
		 
			if($_SESSION["usuario_rol"] == 15) // Menu para Finanzas
   		    { 
		 	echo "	
				<div class='menu-secondary-wrap'>
						<ul class='menus menu-secondary'>
							
							<li><a href='index.php'>Inicio</a>
							    <ul class='children'>
								 <li><a href='index.php?opc=logout'>Salir del Sistema</a></li>
							  </ul>
							</li>
							
							<li><a href='#'>Vendedores</a>
							  <ul class='children'>
									<li><a href='index.php?opc=ventaspro'>Ventas Det. Zofri</a></li>
									<li><a href='index.php?opc=ventasproAir'>Ventas Det. Aeropuerto</a></li>
									<li><a href='index.php?opc=ventasmodulodet'>Ventas Modulos</a>
										<ul class='children'>
											<li><a href='index.php?opc=ventasdet'>Ventas Det.(Cif,USD,CANT)</a></li>
										</ul>
									</li>
									<li><a href='index.php?opc=movDoc'>Mov. de Documentos Módulo</a></li>
									<li><a href='index.php?opc=topvendedores'>Top Venta Vendedores</a>
										<ul class='children'>
											<li><a href='index.php?opc=topvendedoresAir'>Top Venta Vendedores Aero.</a></li>
										</ul>
									</li>
										
										<li><a href='index.php?opc=horaPunta'>Hora Punta</a></li>
										<li><a href='index.php?opc=ventmarca'>Venta por Marca</a></li>
										<li><a href='index.php?opc=infventa'>Informe de Ventas</a></li>
										<li><a href='index.php?opc=buscarCodigo'>Buscar Por Codigo</a></li>
										<li><a href='index.php?opc=buscarCodigoBodega'>Buscar Por Codigo Bodega</a></li>
										<li><a href='index.php?opc=stockMarcaBodega'>Stock por Marca Bodega</a>
										<li><a href='index.php?opc=stockMarcaBodegaLote'>Stock Bodega Lote</a>
										<li><a href='index.php?opc=stockMarca'>Stock por Marca</a>
											<ul class='children'>
									    		 <li><a href='index.php?opc=stockMarcaAir'>Stock por Marca Apto.</a></li>
											 </ul>	
										</li>
										<li><a href='index.php?opc=compararCodigos'>Comparar Codigos</a></li>
										<li><a href='index.php?opc=kardex'>Kardex</a></li>
										<!-- <li><a href='index.php?opc=infcaja'>Informe de Cajas</a></li>-->
								 </ul>
							</li>
							
						 	<li><a href='#'>TransBank</a>
								<ul class='children'>
										<li><a href='index.php?opc=transbank'>TransBank</a></li>
										<li><a href='index.php?opc=abono'>Abonar</a></li>
								</ul>
							</li>				
							
														
							<li><a href='#'>Graficos</a>
								 <ul class='children'>
									     <li><a href='index.php?opc=ventaMensual'>Venta del Año por Meses</a></li>
										  <!--<li><a href='index.php?opc=ventaMensualPuig'>Venta en meses PUIGs</a></li>-->
										 <li><a href='index.php?opc=ventaDiaMensual'>Venta Mensual por Días</a></li>
										 <li><a href='index.php?opc=ventaDiaria'>Venta Por Día de Semana</a></li>
										 <li><a href='index.php?opc=ventasHora'>Venta Mensual por Hora</a>
										 <li><a href='index.php?opc=ventasHoraAir'>Venta Mensual por Hora Aero.</a>
											 <ul class='children'>
												<!--<li><a href='index.php?opc=ventaSemanaHora'>Venta Semanal por Hora</a></li>-->
											 </ul>
										 </li>
										 <!--<li><a href='index.php?opc=paretoABC'>Clasificación de Productos</a></li>-->
								 </ul>
							</li>
							
							<li><a href='index.php?opc=infcaja'>Caja</a>
									 <ul class='children'>
											<li><a href='index.php?opc=infcaja'>Informe de Cajas</a></li>
									 </ul>
							</li>
							
							
					     	<li><a href='#'>Requerimientos</a>
								 <ul class='children'>
										<li><a href='index.php?opc=req'>Solicitar Nuevo Requerimiento</a></li>
										<li><a target='_blank' href='../sisap/docs/Manual%20Requerimientos'  >Manual Requerimientos</a></li>
								 </ul>
							</li>								
							
							<li><a  href='index.php?opc=avisos'>Avisos</a></li>
							
							 
							
						 </ul>
					</div> <!-- fin menu -->";
			} // fin menu Contabilidad y finanzas
			
	}// fin funcion mostrar menu
	
}// Fin class Menu	

?>