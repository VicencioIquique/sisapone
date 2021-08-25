const url = "http://192.168.3.41:9095";//productiva
//const url = "https://localhost:44397";//prueba
$(document).ready(function(){
    $("#validar").hide();
	$("#consultar").click(async function (){
		$("#ssptable tbody tr").remove();
        let codModulo=$("#modulo").val();
		let dsm = $("#nroTraslado").val();
		if(dsm || codModulo){buscarDsm(dsm,codModulo);}else{alert("Ingrese un valor");}	
	});
	$("#validar").click(async function(){
		$('#validar').hide();
		$("#ssptable tbody tr").remove();
		let dem = $("#nroTraslado").val();
        let codModulo=$("#modulo").val();
		validarTraspaso({"nroDsm": `${dem}`,"codModulo":`${codModulo}`});
	});
});

const buscarDsm = async(dsm,codModulo)=>{
	try{
		const respuesta = await fetch(`${url}/api/rp_dsm/${dsm},${codModulo}`);
		console.log (respuesta);
		if(respuesta.ok){
			$("#validar").show();
			const datos = await respuesta.json();
			console.log(datos);
			datos.map(value=>{
				$("#ssptable tbody").append('<tr>'+
						`<td style ="font-size:15px;"><center>${value.nroDsm}</center></td>`+
						`<td style ="font-size:15px;"><center>${value.torigen}</center></td>`+
						`<td style ="font-size:15px;"><center>${value.codModulo}</center></td>`+
						`<td style ="font-size:15px;"><center>${value.codigoProducto}</center></td>`+
						`<td style ="font-size:15px;"><center>${value.descripcionProducto}</center></td>`+
						`<td style ="font-size:15px;"><center>${value.cantidad}</center></td>`+
						`<td style ="font-size:15px;"><center>---</center></td>`+
						'</tr>');
			});
		}
		else{
			const res = await respuesta.text();
			alert(res);
		}
	}catch(err){alert(err.message);}
}

const validarTraspaso = async (data)=>{
	//console.log(data);
	try{
		const respuesta = await fetch(`${url}/api/TraspasoMercaderia`,{
			method:'POST',
			body :JSON.stringify(data),
			headers:{ 'Accept':'application/json','Content-Type': 'application/json'}	
		});
		console.log(respuesta);
		if(respuesta.ok){
			const datos = await respuesta.json();
			console.log(datos);
			datos.map(value=>{
				console.log(value);
				$("#ssptable tbody").append('<tr>'+
						`<td style ="font-size:15px;"><center>${value.nroDem}</center></td>`+
						`<td style ="font-size:15px;"><center>${value.torigen}</center></td>`+
						`<td style ="font-size:15px;"><center>${value.codModulo}</center></td>`+
						`<td style ="font-size:15px;"><center>${value.codigoProducto}</center></td>`+
						`<td style ="font-size:15px;"><center>${value.descripcionProducto}</center></td>`+
						`<td style ="font-size:15px;"><center>${value.cantidad}</center></td>`+
						`<td style ="font-size:15px;"><center>Completado</center></td>`+
						'</tr>');	
			});
		}else{
			const res = await respuesta.text();
			alert(res);
		}
	}catch(err){alert(err.message);}
}
