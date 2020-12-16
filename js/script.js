// JavaScript Document para tabla magica de agregar y eliminar

            $(document).ready(function(){
				

				$("#horizontalForm").validate();
				fn_cantidad();
				fn_contar_estado();
				fn_contar_estadoInterval();
				
				fn_contar_estadoAir();
				fn_contar_estadoIntervalAir();
				
				$('a').css('cursor', 'pointer');
				
				$("input").focus(function(){ 
						this.select(); 
					}); 
				$("textarea").mouseup(function(e){ 
					e.preventDefault(); 
				}); 
				
				 
            });
			
			function fn_cantidad(){
				cantidad = $("#ssptable tbody").find("tr").length;
				$("#span_cantidad").html(cantidad);
			};
			function fn_cantidad_req(){
				cantidad = $(".listaProc tbody").find("tr").length;
				$("#span_cantidadReq").html(cantidad);
			};
			function fn_cantidad_fin(){
				cantidad = $(".listaRes tbody").find("tr").length;
				$("#span_cantidadFin").html(cantidad);
			};
/***************************** PAIS ************************************************************************************/ 
		 function fn_agregar_usuario(){
			
				$.get("modulos/usuarios/obtenerid.php",function(data){
					//	$('#idpais').attr("id",data);
						data++;
						alert("Usuario agregado con el id "+data +" exitosamente!");
						cadena = "<tr>";
				 		cadena = cadena + "<td>" + $("#usuario").val() + "</td>"; 
						cadena = cadena + "<td>" + $("#nombre").val() + "</td>"; 
						cadena = cadena + "<td>" + $("#rol").val() + "</td>"; 
						cadena = cadena + "<td>" + $("#modulo option:selected").text()+ "</td>"; 
				 		
						$("#ssptable tbody").append(cadena);
						$.post("modulos/usuarios/agregar.php", {ide: data, usuario: $("#usuario").val(),nombre: $("#nombre").val(),rol: $("#rol").val(),modulo: $("#modulo").val(),pass: $("#pass").val()});
						fn_eliminar_pais().flush();
						fn_cantidad();
						
					});
					
            }; // fin funcion agregar usuario
			
  function fn_agregar_nuevaSolicitud(){
                              
                    //aqui puedes enviar un conunto de tados ajax para agregar al usuairo
                    $.post("modulos/solicitudes/agregar.php", {usuario_id: $("#usuario_id").val(),modulo: $("#modulo").val()});
                    
                fn_eliminar_tipo();
				fn_cantidad();
                alert("Nueva Solicitud Creada");
				location.href = 'index.php?opc=nuevaSolicitud' ;
            };
 function fn_agregar_nuevaSolicitudAir(){
                              
                    //aqui puedes enviar un conunto de tados ajax para agregar al usuairo
                    $.post("modulos/solicitudesAir/agregar.php", {usuario_id: $("#usuario_id").val(),modulo: $("#modulo").val()});
                    
                fn_eliminar_tipo();
				fn_cantidad();
                alert("Nueva Solicitud Creada");
				location.href = 'index.php?opc=nuevaSolicitud' ;
            };
			
	function fn_eliminar_solicitud(){
                $("a.elimina_solicitud").click(function(){
                    id = $(this).attr("id");
                    respuesta = confirm("Desea eliminar esta solicitud : " + id);
                    if (respuesta){
                        $(this).parents("tr").fadeOut("normal", function(){
                            $(this).remove();
                             //alert("cliente " + id + " eliminado");
                            
                                //aqui puedes enviar un conjunto de datos por ajax
                                $.post("modulos/solicitudes/eliminar.php", {id_sol: id})
                            fn_cantidad();
                        })
                    }
                });
            };
	function fn_eliminar_solicitudAir(){
                $("a.elimina_solicitud").click(function(){
                    id = $(this).attr("id");
                    respuesta = confirm("Desea eliminar esta solicitud : " + id);
                    if (respuesta){
                        $(this).parents("tr").fadeOut("normal", function(){
                            $(this).remove();
                             //alert("cliente " + id + " eliminado");
                            
                                //aqui puedes enviar un conjunto de datos por ajax
                                $.post("modulos/solicitudesAir/eliminar.php", {id_sol: id})
                            
                        })
                    }
                });
            };
	function fn_agregar_nuevoRequerimiento(){
		$('#agregar').click(function(){
			$("#dialog").dialog("open");	
		});
		
				
    };	
	function fn_insertar_nuevoRequerimiento(){
		
	}
	
	
	
	function fn_asignar_requerimiento(){
			
	}
	
	
	function fn_revisar_requerimiento(){
				
					
	};
			
			
	function fn_eliminar_requerimiento(){
                $("a.elimina_requerimiento").click(function(){
                    id = $(this).attr("id");
                    respuesta = confirm("Desea eliminar este requerimiento : " + id);
                    if (respuesta){
                        $(this).parents("tr").fadeOut("normal", function(){
                            $(this).remove();
                             //alert("cliente " + id + " eliminado");
                            
                                //aqui puedes enviar un conjunto de datos por ajax
                                $.post("modulos/requerimientos/eliminar.php", {id_sol: id})
								fn_cantidad_req();
                        })
                    }
                });
            };		
			
         function fn_agregar_lista(){
				
				if($("#cant").val() >0)
				{
					
					
				 var articulo = $("#articulo").val().split('|');
				 var sku = articulo[1];
				 var descrip = articulo[0];
				 //alert (sku);
					
				$.get("modulos/solicitudes/productoenlista.php?sku="+sku+"&idsol="+$("#idsol").val(),function(idart){ // para preguntar si esta la guia de despacho creada anteriormente
																											  
				//alert (idart);
				
				 if(idart == 1)
				 {
						$.post("modulos/solicitudes/agregarlistamas.php", { idsol: $("#idsol").val(), cant: $("#cant").val(), sku: sku});
						alert("Articulo Sumado");
						location.href = 'index.php?opc=paso2&idsol='+ $("#idsol").val() ;
				 }
				 else if(idart == 0) // el producto no ha sido ingresado anteriormente
				 {
						cadena = "<tr>";
						cadena = cadena + "<td>" +sku + "</td>";
						cadena = cadena + "<td>" + descrip + "</td>";
						cadena = cadena + "<td>" + $("#stock").val() + "</td>";
						cadena = cadena + "<td>" + $("#cant").val() + "</td>";
						cadena = cadena + "<td>" + $("#cant").val() + "</td>";
						cadena = cadena + "<td><a class='elimina_lista' id='"+sku+"'><img src='images/delete.png' /></a></td>";
						$("#ssptable tbody").append(cadena);
						
							//aqui puedes enviar un conunto de tados ajax para agregar al usuairo
							$.post("modulos/solicitudes/agregarlista.php", { idsol: $("#idsol").val(), sku: sku, stock: $("#stock").val(), cant: $("#cant").val(), descrip:descrip, total: $("#total").val()});
						
						fn_eliminar_articulolista();
						fn_cantidad();
						alert("Articulo agregado a la Lista");
						 $("#articulo").val("");
						 $("#articulo").focus();
						
				
				 }//fin else
   					}); // fin get
				
				}//fin cantidad mayor quie cero
				else
				{
					alert("No se puede agregar el articulo, debe especificar una cantidad mayor a 0");
				}//fin sino de menor que cero
            };
	
	
            
			
			 function fn_buscar_stock(){
				 
				  var articulo = $("#articulo").val().split('|');
				 var sku = articulo[1];
				
               //alert ("hola mundo");
			   $.get("modulos/solicitudes/obtenerstock.php?sku="+sku,function(data){
					//	$('#idpais').attr("id",data);
						$('#stock').val(data);
			
						
					});
            };
			
			/* ########### BURBUJA PARA VER LOS ESTADOS PENDIENTES EN EL MENU #########*/
			function fn_contar_estado(){
				
			   //var burbuja = $('.burbuja').parent().parent().html();	
              //alert (burbuja);
			         setTimeout(function(){  $.get("modulos/solicitudes/obtenerEstado.php",function(data){
						$('.burbuja').html(data);
		
					});; }, 100);
			  
            };
			
			function fn_contar_estadoInterval(){
				
			   //var burbuja = $('.burbuja').parent().parent().html();	
              //alert (burbuja);
			         setInterval(function(){  $.get("modulos/solicitudes/obtenerEstado.php",function(data){
						$('.burbuja').html(data);
		
					});; }, 50000);
			  
            };
            /* ########### BURBUJA AIR PARA VER LOS ESTADOS PENDIENTES EN EL MENU #########*/
			function fn_contar_estadoAir(){
				
			   
			         setTimeout(function(){  $.get("modulos/solicitudesAir/obtenerEstadoAir.php",function(data){
						$('.burbujaAir').html(data);
		
					});; }, 100);
			  
            };
			
			function fn_contar_estadoIntervalAir(){
			
			         setInterval(function(){  $.get("modulos/solicitudesAir/obtenerEstadoAir.php",function(data){
						$('.burbujaAir').html(data);
		
					});; }, 50000);
			  
            };
			
           
            function fn_agregar_pais(){
			
				$.get("modulos/pais/obtenerid.php",function(data){
					//	$('#idpais').attr("id",data);
						data++;
						alert("País agregado con el id "+ data +" exitosamente!");
						cadena = "<tr>";
				 		cadena = cadena + "<td>" + $("#valor_uno").val() + "</td>"; 
				 		cadena = cadena + "<td><a class='elimina_pais' id='"+ data +"' ><img src='images/delete.png' /></a></td>";
				 		cadena = cadena + "<td><a class='editar_pais'  id='" + data + "' ><img src='images/modificar.png' /></a></td></tr>";
						$("#ssptable tbody").append(cadena);
						$.post("modulos/pais/agregar.php", {ide_usu: data, nom_usu: $("#valor_uno").val()});
						fn_eliminar_pais().flush();
						fn_cantidad();
						
					});
	
            };
            
            function fn_eliminar_pais(){
                $("a.elimina_pais").click(function(){
                    id = $(this).attr("id");// trae lo que esta en id
				    nombre = $(this).parents("tr").find("td").html(); 
                    respuesta = confirm("Desea eliminar el pais: " + nombre);
                    if (respuesta){
                        $(this).parents("tr").fadeOut("normal", function(){
                            $(this).remove();
                           //  alert("Usuario " + id + " eliminado");
                            
                                //aqui puedes enviar un conjunto de datos por ajax
                                $.post("modulos/pais/eliminar.php", {ide_usu: id})
                            
                        })
                    }
                });
            };
			
			 function fn_editar_pais(){
                $("a.editar_pais").click(function(){
                    id = $(this).attr("id");
					$( ".idTabs" ).tabs({ active: 2 });
					valor = $(this).parents("tr").find("td").html();  
					$("#nomedit").val(valor);
					  
                  //  respuesta = confirm("Desea editar el usuario: " + id);
                    if (respuesta){
                        $(this).parents("tr").fadeOut("normal", function(){
                            $(this).remove();
                             alert("Usuario " + id + " eliminado");
                            
                                //aqui puedes enviar un conjunto de datos por ajax
                                $.post("modulos/pais/eliminar.php", {ide_usu: id})
                            
                        })
                    }
                });
            };
			
/***************************** COMUNA ************************************************************************************/            
            function fn_agregar_comuna(){
				
				
				$.get("modulos/comuna/obtenerid.php",function(data2){
						
						data2++;
						alert("Comuna agregada con el id "+ data2 +" exitosamente!");
							
							cadena = "<tr>";
							cadena = cadena + "<td>" + $("#nombreComuna").val() + "</td>";
						    cadena = cadena + "<td>" + $("#idpais option:selected").text() + "</td>";
							cadena = cadena + "<td><a class='elimina_comuna' id='"+ data2 +"' ><img src='images/delete.png' /></a></td></tr>";
						
							
							$("#ssptable tbody").append(cadena);
				 
							 $.post("modulos/comuna/agregar.php", {id_comuna: data2, nom_comuna: $("#nombreComuna").val(), ide_pais: $("#idpais").val()});
                
                fn_eliminar_comuna();
				fn_cantidad();
               
				});
				
            };
            
            function fn_eliminar_comuna(){
                $("a.elimina_comuna").click(function(){
                    id = $(this).attr("id");
                    respuesta = confirm("Desea eliminar la comuna: " + id);
                    if (respuesta){
                        $(this).parents("tr").fadeOut("normal", function(){
                            $(this).remove();
                             //alert("Usuario " + id + " eliminado");
                            
                                //aqui puedes enviar un conjunto de datos por ajax
                                $.post("modulos/comuna/eliminar.php", {ide: id})
                            
                        })
                    }
                });
            };
			
			 function fn_editar_comuna(){
                $("a.elimina_comuna").click(function(){
                    id = $(this).attr("id");
					
                    respuesta = confirm("Desea eliminar el usuario: " + id);
                    if (respuesta){
                        $(this).parents("tr").fadeOut("normal", function(){
                            $(this).remove();
                             alert("Usuario " + id + " eliminado");
                            
                                //aqui puedes enviar un conjunto de datos por ajax
                                $.post("modulos/pais/eliminar.php", {ide_usu: id})
                            
                        })
                    }
                });
            };
			
/***************************** ARTICULOS ************************************************************************************/            
            function fn_agregar_articulo(){
               
               
                    //aqui puedes enviar un conjunto de datos ajax para agregar el articulo
                    $.post("modulos/articulos/agregar.php", {tipo: $("#select_uno").val(),nombre: $("#valor_uno_a").val(),enguia: $("#select_impreso option:selected").val(),  medida: $("#select_medida").val(), preciou: $("#valor_dos_a").val(), descripcion: $("#valor_tres_a").val(), comentario: $("#valor_cuatro_a").val()});
                
                fn_eliminar_articulo();
				fn_cantidad();
                alert("Articulo agregado");
				location.reload();
            };
               
			 function fn_eliminar_articulo(){
                $("a.elimina_articulo").click(function(){
                    id = $(this).attr("id");
                    respuesta = confirm("Desea eliminar el articulo: " + id);
                    if (respuesta){
                        $(this).parents("tr").fadeOut("normal", function(){
                            $(this).remove();
                             //alert("Articulo " + id + " eliminado");
                            
                                //aqui puedes enviar un conjunto de datos por ajax
                                $.post("modulos/articulos/eliminar.php", {ide_usu: id})
                            
                        })
                    }
                });
            };

/***************************** CLIENTES ************************************************************************************/            
            function fn_agregar_clientes(){
                cadena = "<tr>";
               	cadena = cadena + "<td>" + $("#valor_rut").val() + "</td>";
                cadena = cadena + "<td>" + $("#valor_uno").val() + "</td>";
				cadena = cadena + "<td>" + $("#valor_telefono").val() + "</td>";
               	cadena = cadena + "<td>" + $("#valor_dos").val() + "</td>";
                cadena = cadena + "<td>" + $("#valor_tres").val() + "</td>";
                cadena = cadena + "<td><a class='elimina_cliente' id='"+$("#valor_rut").val()+"'><img src='images/delete.png' /></a></td>";
                $("#ssptable tbody").append(cadena);
               
                    //aqui puedes enviar un conunto de tados ajax para agregar al usuairo
                    $.post("modulos/clientes/agregar.php", {rut: $("#valor_rut").val(), nombre: $("#valor_uno").val(), telefono: $("#valor_telefono").val(), direccion: $("#valor_dos").val(), giro: $("#valor_tres").val()});
                
                fn_eliminar_cliente();
				fn_cantidad();
                alert("Cliente agregado");
            };
            
            function fn_eliminar_cliente(){
                $("a.elimina_cliente").click(function(){
                    id = $(this).attr("id");
                    respuesta = confirm("Desea eliminar el cliente: " + id);
                    if (respuesta){
                        $(this).parents("tr").fadeOut("normal", function(){
                            $(this).remove();
                             //alert("cliente " + id + " eliminado");
                            
                                //aqui puedes enviar un conjunto de datos por ajax
                                $.post("modulos/clientes/eliminar.php", {ide_usu: id})
                            
                        })
                    }
                });
            };
			
/***************************** UNIDAD MEDIDA ************************************************************************************/            
            function fn_agregar_medida(){
                cadena = "<tr>";
               	cadena = cadena + "<td>" + $("#nombre").val() + "</td>";
                cadena = cadena + "<td>" + $("#unidad").val() + "</td>";
                cadena = cadena + "<td><a class='elimina_medida'><img src='images/delete.png' /></a></td>";
                $("#ssptable tbody").append(cadena);
               
                    //aqui puedes enviar un conunto de tados ajax para agregar al usuairo
                    $.post("modulos/medidas/agregar.php", {nombre: $("#nombre").val(), unidad: $("#unidad").val()});
                
                fn_eliminar_medida();
				fn_cantidad();
                alert("Unidad Medida agregada");
            };
            
            function fn_eliminar_medida(){
                $("a.elimina_medida").click(function(){
                    id = $(this).attr("id");
                    respuesta = confirm("Desea eliminar Unidad Medida: " + id);
                    if (respuesta){
                        $(this).parents("tr").fadeOut("normal", function(){
                            $(this).remove();
                             //alert("cliente " + id + " eliminado");
                            
                                //aqui puedes enviar un conjunto de datos por ajax
                                $.post("modulos/medidas/eliminar.php", {ide_usu: id})
                            
                        })
                    }
                });
            };
			
/***************************** TIPO ************************************************************************************/            
            function fn_agregar_tipo(){
                cadena = "<tr>";
               	cadena = cadena + "<td>" + $("#nombre").val() + "</td>";
                cadena = cadena + "<td>" + $("#descripcion").val() + "</td>";
                cadena = cadena + "<td><a class='elimina_tipo'><img src='images/delete.png' /></a></td>";
                $("#ssptable tbody").append(cadena);
               
                    //aqui puedes enviar un conunto de tados ajax para agregar al usuairo
                    $.post("modulos/tipo/agregar.php", {nombre: $("#nombre").val(), unidad: $("#descripcion").val()});
                
                fn_eliminar_tipo();
				fn_cantidad();
                alert("Tipo agregado");
            };
            
            function fn_eliminar_tipo(){
                $("a.elimina_tipo").click(function(){
                    id = $(this).attr("id");
                    respuesta = confirm("Desea eliminar Tipo: " + id);
                    if (respuesta){
                        $(this).parents("tr").fadeOut("normal", function(){
                            $(this).remove();
                             //alert("cliente " + id + " eliminado");
                            
                                //aqui puedes enviar un conjunto de datos por ajax
                                $.post("modulos/tipo/eliminar.php", {ide_usu: id})
                            
                        })
                    }
                });
            };
			
/***************************** EMBARCACION ************************************************************************************/            
            function fn_agregar_embarcacion(){
                cadena = "<tr>";
               	cadena = cadena + "<td>" + $("#rut").val() + "</td>";
                cadena = cadena + "<td>" + $("#nombre").val() + "</td>";
				cadena = cadena + "<td>" + $("#representante").val() + "</td>";
               	cadena = cadena + "<td>" + $("#barco").val() + "</td>";
                cadena = cadena + "<td>" + $("#direccion").val() + "</td>";
				cadena = cadena + "<td>" + $("#telefono").val() + "</td>";
				cadena = cadena + "<td>" + $("#celular").val() + "</td>";
				cadena = cadena + "<td>" + $("#comuna").val() + "</td>";
				cadena = cadena + "<td>" + $("#clientes").val() + "</td>";
				cadena = cadena + "<td>" + $("#giro").val() + "</td>";
                cadena = cadena + "<td><a class='elimina_embarcacion' id='"+$("#rut").val()+"'><img src='images/delete.png' /></a></td>";
                $("#ssptable tbody").append(cadena);
                
				    //aqui puedes enviar un conunto de tados ajax para agregar al usuairo
                    $.post("modulos/embarcacion/agregar.php", {rut: $("#rut").val(), nombre: $("#nombre").val(), representante: $("#representante").val(), barco: $("#barco").val(), direccion: $("#direccion").val(), telefono: $("#telefono").val(), celular: $("#celular").val(), comuna: $("#comuna").val(), clientes: $("#clientes").val(), giro: $("#giro").val()});
                
                fn_eliminar_embarcacion();
				fn_cantidad();
                alert("Embarcación agregada");
            };
            
            function fn_eliminar_embarcacion(){
                $("a.elimina_embarcacion").click(function(){
                    id = $(this).attr("id");
                    respuesta = confirm("Desea eliminar la embarcación: " + id);
                    if (respuesta){
                        $(this).parents("tr").fadeOut("normal", function(){
                            $(this).remove();
                             //alert("cliente " + id + " eliminado");
                            
                                //aqui puedes enviar un conjunto de datos por ajax
                                $.post("modulos/embarcacion/eliminar.php", {ide_usu: id})
                            
                        })
                    }
                });
            };
			
			
/***************************** GUIADEDESPACHO ************************************************************************************/            
             function fn_agregar_guia(){
				 
				$.get("modulos/guiadespacho2/obteneridguia.php?idguia="+$("#guianumero").val(),function(idguia){ // para preguntar si esta la guia de despacho creada anteriormente
																																								
                 if(idguia == 1)
				 {
					alert("Este numero de guia ya ha sido utilizado"); 
				 }
				 else if (idguia == 0)
				 {
						cadena = "<tr>";               	
						cadena = cadena + "<td><a href='index.php?opc=paso2&guianumero=" + $("#guianumero").val() + "'>" + $("#guianumero").val() + "</td>";
						cadena = cadena + "<td>PENDIENTE</td>";
						cadena = cadena + "<td>" + $("#dia").val()+" "+$("#mes").val()+" "+$("#anio").val()+"</td>";
						cadena = cadena + "<td>" + $("#barco").val() + "</td>";
						cadena = cadena + "<td>" + $("#senior").val() + "</td>";
						cadena = cadena + "<td  style=' font-weight:bold;'>$0</td>";
						cadena = cadena + "<td><a class='elimina_guiadespacho' id='"+$("#guianumero").val()+"'><img src='images/delete.png' /></a></td>";
						$("#ssptable tbody").append(cadena);
						
							//aqui puedes enviar un conunto de tados ajax para agregar al usuairo
							$.post("modulos/guiadespacho2/agregar.php", { guianumero: $("#guianumero").val(), barco: $("#barco").val(), puestaen: $("#puestaen").val()});
						
						fn_eliminar_guiapendiente();
						fn_cantidad();
						alert("Guia Creada");
				
				 }//fin if else
				}); // fin get

            };
            
            function fn_eliminar_guiapendiente(){
                $("a.elimina_guiapendiente").click(function(){
                    id = $(this).attr("id");
                    respuesta = confirm("Desea eliminar la guia : " + id);
                    if (respuesta){
                        $(this).parents("tr").fadeOut("normal", function(){
                            $(this).remove();
                             //alert("cliente " + id + " eliminado");
                            
                                //aqui puedes enviar un conjunto de datos por ajax
                                $.post("modulos/guiadespacho2/eliminarguia.php", {guianumero: id})
                            
                        })
                    }
                });
            };
			
			/***************************** DUPLICARGUIADEDESPACHO ************************************************************************************/            
             function fn_duplicar_guia(){
				 
				$.get("modulos/guiadespacho2/obteneridguia.php?idguia="+$("#guianumero").val(),function(idguia){ // para preguntar si esta la guia de despacho creada anteriormente
																																								
                 if(idguia == 1)
				 {
					alert("Este numero de guia ya ha sido utilizado"); 
				 }
				 else if (idguia == 0)
				 {
						
						//aqui puedes enviar un conunto de tados ajax para agregar al usuairo
						$.post("modulos/guiadespacho2/agregarduplicado.php", {total: $("#total").val(), numeroguiacopia: $("#numeroguia").val(), guianumero: $("#guianumero").val(), barco: $("#barco").val(), puestaen: $("#puestaen").val()});
						
						fn_eliminar_guiapendiente();
						fn_cantidad();
						alert("Guia Duplicada Correctamente");
						location.href = 'index.php?opc=despachosE' ;
				
				 }//fin if else
				}); // fin get

            };
            
            function fn_eliminar_guiapendiente(){
                $("a.elimina_guiapendiente").click(function(){
                    id = $(this).attr("id");
                    respuesta = confirm("Desea eliminar la guia : " + id);
                    if (respuesta){
                        $(this).parents("tr").fadeOut("normal", function(){
                            $(this).remove();
                             //alert("cliente " + id + " eliminado");
                            
                                //aqui puedes enviar un conjunto de datos por ajax
                                $.post("modulos/guiadespacho2/eliminarguia.php", {guianumero: id})
                            
                        })
                    }
                });
            };
			

            
              function fn_eliminar_articulolista(){
                $("a.elimina_lista").click(function(){
                    id = $(this).attr("id");
					
                    respuesta = confirm("Desea eliminar de la lista : " + id);
                    if (respuesta){
                        $(this).parents("tr").fadeOut("normal", function(){
                            $(this).remove();
                             //alert("cliente " + id + " eliminado");
                            
                                //aqui puedes enviar un conjunto de datos por ajax
                                $.post("modulos/solicitudes/eliminardelista.php", {sku: id,idsol: $("#idsol").val()})
                            
                        })
                    }
                });
            };
			
			 function fn_eliminar_articulolistaAir(){
                $("a.elimina_lista").click(function(){
                    id = $(this).attr("id");
					
                    respuesta = confirm("Desea eliminar de la lista : " + id);
                    if (respuesta){
                        $(this).parents("tr").fadeOut("normal", function(){
                            $(this).remove();
                             //alert("cliente " + id + " eliminado");
                            
                                //aqui puedes enviar un conjunto de datos por ajax
                                $.post("modulos/solicitudesAir/eliminardelista.php", {sku: id,idsol: $("#idsol").val()})
                            
                        })
                    }
                });
            };
			
/***************************** enviar solicitud  ************************************************************************************/            
             function fn_finalizar_guia(){
				 
				 
				if($("#mauricio").is(':checked')) {  
          			 var correo1 = "mauriciohuerta@eximben.cl,"; 
       			 } 
				 else
				 	var correo1 = ""; 
			    if($("#marianela").is(':checked')) {  
          			 var correo2 = "marianelavidal@eximben.cl,"; 
       			 } 
				  else
				 	var correo2 = ""; 
				if($("#rosa").is(':checked')) {  
          			 var correo3 = "rosazamora@eximben.cl,"; 
       			 } 
				  else
				 	var correo3 = ""; 
				if($("#marieliza").is(':checked')) {  
          			 var correo4 = "marielizamarquez@eximben.cl,"; 
       			 } 
				  else
				 	var correo4 = ""; 
					
				if($("#cristina").is(':checked')) {  
          			 var correo5 = "cristinaortiz@eximben.cl,"; 
       			 } 
				  else
				 	var correo5 = ""; 
					
				if($("#maribel").is(':checked')) {  
          			 var correo6 = "maribeldiaz@eximben.cl,"; 
       			 } 
				  else
				 	var correo6 = ""; 
				   		   
				listacorreo = correo1;
				listacorreo = listacorreo + correo2;   
				listacorreo = listacorreo + correo3; 
				listacorreo = listacorreo + correo4; 
				listacorreo = listacorreo + correo5; 
				listacorreo = listacorreo + correo6; 
				
				//alert (listacorreo);
				   
             
                if( $("#TOTALFINAL").val() == "0")
				{
					 alert("No puede continuar, agregue almenos un articulo.");
				}
				else
				{
					  respuesta = confirm("¿Desea enviar para revisión? ");
					   if (respuesta){
						   //alert($("#brand").val());
						//$.post("modulos/solicitudes/enviarmail.php", { idsol: $("#idsol").val(),correos:listacorreo});
						$.post("modulos/solicitudes/enviarlista.php", { idsol: $("#idsol").val()});
						//alert("Su solicitud se ha enviado para revisión");
						
						setTimeout(function(){
										url = 'index.php?opc=nuevaSolicitud' ;
										$(location).attr('href',url);
										},2000);
						
						//location.href = 'index.php?opc=nuevaSolicitud' ;
						//location.href = 'index.php?opc=paso3&guianumero='+ $("#guianumero").val() ;
					   }
					}
};

/***************************** enviar solicitud  ************************************************************************************/            
             function fn_finalizar_guiaAir(){
				 
				 
				if($("#mauricio").is(':checked')) {  
          			 var correo1 = "mauriciohuerta@eximben.cl,"; 
       			 } 
				 else
				 	var correo1 = ""; 
			    if($("#marianela").is(':checked')) {  
          			 var correo2 = "marianelavidal@eximben.cl,"; 
       			 } 
				  else
				 	var correo2 = ""; 
				if($("#rosa").is(':checked')) {  
          			 var correo3 = "rosazamora@eximben.cl,"; 
       			 } 
				  else
				 	var correo3 = ""; 
				if($("#marieliza").is(':checked')) {  
          			 var correo4 = "marielizamarquez@eximben.cl,"; 
       			 } 
				  else
				 	var correo4 = ""; 
					
				if($("#cristina").is(':checked')) {  
          			 var correo5 = "cristinaortiz@eximben.cl,"; 
       			 } 
				  else
				 	var correo5 = ""; 
					
				if($("#maribel").is(':checked')) {  
          			 var correo6 = "maribeldiaz@eximben.cl,"; 
       			 } 
				  else
				 	var correo6 = ""; 
				   		   
				listacorreo = correo1;
				listacorreo = listacorreo + correo2;   
				listacorreo = listacorreo + correo3; 
				listacorreo = listacorreo + correo4; 
				listacorreo = listacorreo + correo5; 
				listacorreo = listacorreo + correo6; 
				
				//alert (listacorreo);
				   
             
                if( $("#TOTALFINAL").val() == "0")
				{
					 alert("No puede continuar, agregue almenos un articulo.");
				}
				else
				{
					  respuesta = confirm("¿Desea enviar para revisión? Air ");
					   if (respuesta){
						  // alert($("#brand").val());
						$.post("modulos/solicitudesAir/enviarmail.php", { idsol: $("#idsol").val(),correos:listacorreo});
						$.post("modulos/solicitudesAir/enviarlista.php", { idsol: $("#idsol").val()});
						//alert("Su solicitud se ha enviado para revisión");
						
						setTimeout(function(){
										url = 'index.php?opc=nuevaSolicitud' ;
										$(location).attr('href',url);
										},2000);
						//location.href = 'index.php?opc=paso3&guianumero='+ $("#guianumero").val() ;
					   }
					}
				};
				
			 function fn_revisar_solicitudAir(){
               $("a.revisar_solicitud").click(function(){
                    id = $(this).attr("id");
                    respuesta = confirm("Desea Revisar esta solicitud? " + id);
					//alert($(this).children().html());
                    if (respuesta){
                        $(this).children("img").fadeOut("normal", function(){
                            $(this).remove();
                             //alert("cliente " + id + " eliminado");
                            
                                //cambiar el estado de solicitud a revisando
                                $.post("modulos/solicitudesAir/estadosolicitud.php", {idsol: id,usuario_id: $("#usuario_id").val()})
								location.href = 'index.php?opc=paso2brandAir&idsol='+id;
                            
                        })
                    }
                });
            };
				
            function fn_revisar_solicitud(){
                $("a.revisar_solicitud").click(function(){
                    id = $(this).attr("id");
                    respuesta = confirm("Desea Revisar esta solicitud? " + id);
					//alert($(this).children().html());
                    if (respuesta){
                        $(this).children("img").fadeOut("normal", function(){
                            $(this).remove();
                             //alert("cliente " + id + " eliminado");
                            
                                //cambiar el estado de solicitud a revisando
                                $.post("modulos/solicitudes/estadosolicitud.php", {idsol: id,usuario_id: $("#usuario_id").val()})
								location.href = 'index.php?opc=paso2brand&idsol='+id;
                            
                        })
                    }
                });
            };
			
			
			
			 function fn_validar_sol(){
             
                if( $("#TOTALFINAL").val() == "0")
				{
					 alert("No puede continuar, agregue almenos un articulo.");
				}
				else
				{
					  respuesta = confirm("¿Desea Validar esta Solicitud? ");
					   if (respuesta){
						
						$.post("modulos/solicitudes/validarsol.php", { idsol: $("#idsol").val()});
						alert("Su solicitud se ha Validado!");
					//	$.post("modulos/solicitudes/enviarmail.php", { idsol: $("#idsol").val()});
						location.href = 'index.php?opc=nuevaSolicitudbrand' ;
						//location.href = 'index.php?opc=paso3&guianumero='+ $("#guianumero").val() ;
					   }
					}
				};
function fn_validar_solAir(){
             
                if( $("#TOTALFINAL").val() == "0")
				{
					 alert("No puede continuar, agregue almenos un articulo.");
				}
				else
				{
					  respuesta = confirm("¿Desea Validar esta Solicitud? ");
					   if (respuesta){
						
						$.post("modulos/solicitudesAir/validarsol.php", { idsol: $("#idsol").val()});
						alert("Su solicitud se ha Validado!");
					//	$.post("modulos/solicitudes/enviarmail.php", { idsol: $("#idsol").val()});
						location.href = 'index.php?opc=nuevaSolicitudbrandAir' ;
						//location.href = 'index.php?opc=paso3&guianumero='+ $("#guianumero").val() ;
					   }
					}
				};
				
			 function fn_enviar_marca(){
					marca = $("#articulo").val();
					if(marca)
					{
						if($("#costo").is(':checked'))
						{
						 var costo=1;
						}
						else
						{
							 var costo=0;
						}
					
						location.href = 'index.php?opc=pasodos&idsol='+ $("#idsol").val()+'&marca='+encodeURIComponent(marca)+'&costo='+costo ;
						//$.post("modulos/solicitudes/solu_p2.php", { marca: marca});
					}
				};
				
           function fn_anade_lista(){
                $("a.anade_lista").click(function(){
                    id = $(this).attr("id");
						
						
					cantsol = $(this).parent().parent().find("#cantsol").val();
					descrip = $(this).parent().parent().find("td:eq(1)").text();
					stock = $(this).parent().parent().find("td:eq(2)").text();
					idsol =$("#idsol").val();
					fila = $(this).parents("tr"); 
					if(cantsol>0)
					{$.get("modulos/solicitudes/productoenlista.php?sku="+id+"&idsol="+idsol,function(idart){ // para preguntar si esta la guia de despacho creada anteriormente
						
																											  
							//alert (idart);
							
							 if(idart == 1)
							 {
									//$.post("modulos/solicitudes/agregarlistamas.php", { idsol: idsol, cant: cantsol, sku: id});
									alert("Este producto ya fue ingresado enla lista");
									//location.href = 'index.php?opc=pasodos&idsol='+ $("#idsol").val() ;
							 }
							 else if(idart == 0) // el producto no ha sido ingresado anteriormente
								 {
									
									 /*respuesta = confirm("Desea Agregar este Producto?" );
										if (respuesta){*/
								
										fila.css("background-color", "#e7fddc");
											
											$.post("modulos/solicitudes/agregarlista.php", { idsol: idsol, sku: id, stock: stock, cant: cantsol, descrip:descrip});
												  $( "#ssptable tbody" ).append( "<tr>" +
												  "<td>" + id + "</td>" +
												   "<td>" + descrip + "</td>" +
												  "<td>" + stock + "</td>" +
												  "<td>" + cantsol + "</td>" +
												  "<td>" + cantsol+ "</td>" +
												  "<td><a class=\"anade_lista\" id="+id+"><img src=\"images/delete.png\" /></a></td>" +
												"</tr>" );
										//}//fin if de respuesta
					
			    	           }//fin elsesi es que es primera ves
   					}); // fin get	
					
					}//fin if si es mayor que cero
					else
					{
						alert("Debe ingresar una cantidad mayor que cero");
					}//fin else para que muestre mensaje que no puede ingresar menor que cero
                });
            };
			
function fn_anade_listaAir(){
                $("a.anade_lista").click(function(){
                    id = $(this).attr("id");
						
						
					cantsol = $(this).parent().parent().find("#cantsol").val();
					descrip = $(this).parent().parent().find("td:eq(1)").text();
					stock = $(this).parent().parent().find("td:eq(2)").text();
					idsol =$("#idsol").val();
					fila = $(this).parents("tr"); 
					if(cantsol>0)
					{$.get("modulos/solicitudesAir/productoenlista.php?sku="+id+"&idsol="+idsol,function(idart){ // para preguntar si esta la guia de despacho creada anteriormente
						
																											  
							//alert (idart);
							
							 if(idart == 1)
							 {
									$.post("modulos/solicitudesAir/agregarlistamas.php", { idsol: idsol, cant: cantsol, sku: id});
									alert("Articulo Sumado");
									location.href = 'index.php?opc=pasodos&idsol='+ $("#idsol").val() ;
							 }
							 else if(idart == 0) // el producto no ha sido ingresado anteriormente
								 {
									
									 /*respuesta = confirm("Desea Agregar este Producto?" );
										if (respuesta){*/
								
										fila.css("background-color", "#e7fddc");
											
											$.post("modulos/solicitudesAir/agregarlista.php", { idsol: idsol, sku: id, stock: stock, cant: cantsol, descrip:descrip});
												  $( "#ssptable tbody" ).append( "<tr>" +
												  "<td>" + id + "</td>" +
												   "<td>" + descrip + "</td>" +
												  "<td>" + stock + "</td>" +
												  "<td>" + cantsol + "</td>" +
												  "<td>" + cantsol+ "</td>" +
												  "<td><a class=\"anade_lista\" id="+id+"><img src=\"images/delete.png\" /></a></td>" +
												"</tr>" );
										//}//fin if de respuesta
					
			    	           }//fin elsesi es que es primera ves
   					}); // fin get	
					
					}//fin if si es mayor que cero
					else
					{
						alert("Debe ingresar una cantidad mayor que cero");
					}//fin else para que muestre mensaje que no puede ingresar menor que cero
                });
            };
				


 function fn_anade_lista2(){
                $("a.anade_lista2").click(function(){
                    id = $("#codBarra").val();
						
						
					cantsol =$("#cantsol").val();
					descrip = $("#descrip").val();
					
					stock = $("#cantidadStock").val();
					
					idsol =$("#idsol").val();
					fila = $(this).parents("tr"); 
					if(cantsol>0)
					{
					
					$.get("modulos/solicitudes/productoenlista.php?sku="+id+"&idsol="+idsol,function(idart){ // para preguntar si esta la guia de despacho creada anteriormente
						
																											  
							//alert (idart);
							
							 if(idart == 1)
							 {
									$.post("modulos/solicitudes/agregarlistamas.php", { idsol: idsol, cant: cantsol, sku: id});
									alert("Articulo Sumado");
									location.href = 'index.php?opc=pasodos&idsol='+ $("#idsol").val() ;
							 }
							 else if(idart == 0) // el producto no ha sido ingresado anteriormente
								 {
									
									 /*respuesta = confirm("Desea Agregar este Producto?" );
										if (respuesta){*/
								
										fila.css("background-color", "#e7fddc");
											
											$.post("modulos/solicitudes/agregarlista.php", { idsol: idsol, sku: id, stock: stock, cant: cantsol, descrip:descrip});
												  $( "#ssptable tbody" ).append( "<tr>" +
												  "<td>" + id + "</td>" +
												   "<td>" + descrip + "</td>" +
												  "<td>" + stock + "</td>" +
												  "<td>" + cantsol + "</td>" +
												  "<td>" + cantsol+ "</td>" +
												  "<td><a class=\"anade_lista\" id="+id+"><img src=\"images/delete.png\" /></a></td>" +
												"</tr>" );
										//}//fin if de respuesta
					
			    	           }//fin elsesi es que es primera ves
   					}); // fin get	
					
					}//fin if si es mayor que cero
					else
					{
						alert("Debe ingresar una cantidad mayor que cero");
					}//fin else para que muestre mensaje que no puede ingresar menor que cero
                });
            };				

/*##################################################################################################################################*/

function Imponible()
        {	
            $('#criterio').bind('keyup', function (e) {
								  var key = e.keyCode || e.which;
								  if (key === 13) 
								  {
									alert("ikasdsadsjoda");
									dias = $("#diasTrabajados").val();
									if(dias>0)
									{
										$.get("modulos/remuneraciones/obtenerSueldo.php?id="+id,function(sueldo){
												//alert(sueldo);
												var sueldoB=sueldo;
												$("#sueldoBaseTemp").val(sueldo);
												var sueldo = (sueldo/30)*dias;												
												$("#sueldoBase").val(sueldo.toFixed(0));
										
												$.get("modulos/remuneraciones/obtenerGratif.php",function(sueldoMin){
														var gratMax = (((sueldoMin*4.75)/12)/30)*dias;
														
														//var grat = (sueldoB*25)/100;
														//alert(grat);
														
														var grat = (calcularImpSinGrat()*25)/100;
														//alert(grat);
														
														if(grat<gratMax)
														{
															$("#gratifi").val(grat.toFixed(0));
															
														}
														else 
														{
															$("#gratifi").val(gratMax.toFixed(0));
														}
															calcularImp();
															
														$('#bonoGral').focus();
														calcularDsctos();
												});	//fin funcion obtener gratificacion
												
												
										});//fin funcion obtener sueldobase
										
									
										
									}//fin mayor que 0 dias
									else
									{
										$("#sueldoBase").val("");
									}
								  };
								}); //fin captura dias trabajado
 }//fin funcion imponible		

function fn_agregar_deAuno(){
                $("a.deAuno").click(function(){
					//alert("hola");
					$("#liquidacion").dialog( "open" );
				}); //fin captura dias trabajado
 }//fin funcion imponible		
				
				
function buscarCod()
        {	
            $('#codBarra').bind('keyup', function (e) {
								  var key = e.keyCode || e.which;
								  if (key === 13) 
								  {
								  idsol =$("#idsol").val();
								  id = $("#codBarra").val();
								  
								  // alert("hola");
										$.get("modulos/solicitudes/obtenerstockUno.php?sku="+id+"&idsol="+idsol,function(datosProd){
													var arr = JSON.parse(datosProd);
													//alert(datosProd);
											       $("#cantidadStock").val(arr.cantidad);
													$("#descrip").val(arr.name);
													
														
										});	//fin funcion obtener gratificacion
								   
								   };
								}); //fin captura dias trabajado
 }//fin funcion imponible		
 
 
  function fn_validar_dsm(){
				
            
            $(".on_off").click(function(){
			
			 // alert($("#on_off_on").is(':checked'));
	
				if (!$("#on_off_on").is(':checked')) {
						
							ndsm = $("#nDsm").val();//$(this).parent().find("td:eq(0)").text();
							listacorreo = "juliocortes@eximben.cl;";
									
									okguard();
									
									$(".on_off").parents("tr").fadeOut(3000, function(){
									$(this).remove();
                             
										$.post("modulos/dsm/cambiarEstado.php", {ndsm: ndsm})
										 $.post("modulos/dsm/enviarDsmMail.php", { ndsm: ndsm,correos:listacorreo});
									})
									
									setTimeout(function(){
										url = 'index.php?opc=validarDsm&nDsm' ;
										$(location).attr('href',url);
										},3000);
						 }//fin if checked		
				else 
				{
					NOguard();
				}//fin else
            });
};
  function fn_validar_dem(){
				
            
            $(".on_off").click(function(){
			
			 // alert($("#on_off_on").is(':checked'));
	
				if (!$("#on_off_on").is(':checked')) {
						
							ndem = $("#nDEM").val();//$(this).parent().find("td:eq(0)").text();
							listacorreo = "sergiolagos@eximben.cl;";
									
									okguard();
									
									$(".on_off").parents("tr").fadeOut(3000, function(){
									$(this).remove();
                             
										$.post("modulos/dem/cambiarEstado.php", {ndem: ndem})
										 $.post("modulos/dem/enviarDemMail.php", { ndem: ndem,correos:listacorreo});
									})
									
									setTimeout(function(){
										url = 'index.php?opc=validarDem&nDem' ;
										$(location).attr('href',url);
										},6000);
						 }//fin if checked		
				else 
				{
					NOguard();
				}//fin else
            });
};

  function fn_validar_dsmAir(){
				
            
            $(".on_off").click(function(){
			
			 // alert($("#on_off_on").is(':checked'));
	
				if (!$("#on_off_on").is(':checked')) {
						
							ndsm = $("#nDsm").val();//$(this).parent().find("td:eq(0)").text();
							listacorreo = "juliocortes@eximben.cl;";
									
									okguard();
									
									$(".on_off").parents("tr").fadeOut(3000, function(){
									$(this).remove();
                             
										$.post("modulos/dsmAir/cambiarEstado.php", {ndsm: ndsm})
										// $.post("modulos/dsmAir/enviarDsmMail.php", { ndsm: ndsm,correos:listacorreo});
									})
									
									setTimeout(function(){
										url = 'index.php?opc=dsmAir' ;
										$(location).attr('href',url);
										},3000);
						 }//fin if checked		
				else 
				{
					NOguard();
				}//fin else
            });
};

function okguard(){ //muestra mensaje que se guardo correctamente
	function create( template, vars, opts ){
					return $container.notify("create", template, vars, opts);
				}
				$container = $("#container").notify();
				create("guardado", { title:'Muy Bien!', text:'El Documento se ha Validado!'});	

};

function NOguard(){ //muestra mensaje que se guardo correctamente
	function create( template, vars, opts ){
					return $container.notify("create", template, vars, opts);
				}
				$container = $("#container").notify();
				create("guardado", { title:':(', text:'El Documento ya fue Validado!'});	

};


function fn_detalle_dsm(){
                $("a.mostrar_dsm").click(function(){
                    id = $(this).attr("id");
						$("#dsmDetalle").dialog( "open" );
					});
};

/********************************* 5-11-2014 Tranbank **********************************/

function fn_agregar_abono(){
			
				 respuesta = confirm("Desea Abonar esta Cantidad? " + $("#monto").val());
                    if (respuesta){
										
						$.post("modulos/transbank/agregar.php", { bodega: $("#retail").val(),tipoPago: $("#tipoPago").val(),monto: $("#monto").val(),usuario: $("#usuario").val()});
						
						fn_cantidad();
						setTimeout(function(){
										url = 'index.php?opc=abono' ;
										$(location).attr('href',url);
										},1000);	
				 }//End Confirm
					
       }; // fin funcion agregar usuario
	   
function fn_eliminar_abonoTransbank(){
                $("a.elimina_abono").click(function(){
                    id = $(this).attr("id");
                    respuesta = confirm("Desea eliminar realmente este abono?");
                    if (respuesta){
                        $(this).parents("tr").fadeOut("normal", function(){
                            $(this).remove();
                             //alert("cliente " + id + " eliminado");
                            
                                //aqui puedes enviar un conjunto de datos por ajax
                                $.post("modulos/transbank/eliminar.php", {id_abono: id})
                            
                        })
                    }
                });
 };
 
 function fn_enviar_SAP(){
                $("a.enviar_SAP").click(function(){
                    id = $(this).attr("id");
						//alert("Se ha enviado a SAP "+id);
						respuesta = confirm("Desea enviar como solicitud a SAP? " + id);			
						if (respuesta){
							$(this).children("img").fadeOut("normal", function(){
								$(this).remove();
							
									$.post("modulos/solicitudes/estadoEnviarSAP.php", {idsol: id})
									//location.href = 'index.php?opc=nuevaSolicitudbrand';
								
							})
						}
						
						
		});
};
 
 function fn_enviar_SAPAIR(){
                $("a.enviar_SAPAIR").click(function(){
                    id = $(this).attr("id");
						//alert("Se ha enviado a SAP "+id);
						respuesta = confirm("Desea enviar como solicitud a SAP? " + id);			
						if (respuesta){
							$(this).children("img").fadeOut("normal", function(){
								$(this).remove();
							
									$.post("modulos/solicitudesAir/estadoEnviarSAP.php", {idsol: id})
									//location.href = 'index.php?opc=nuevaSolicitudbrand';
								
							})
						}
						
						
		});
};