$(document).ready(function(){
    $("#consultar").click(function(){
        if(controlInput($("#codbarra2").val())){
            $.post('modulos/promociones/scripts/buscarPromo.php', {codigo:$("#codbarra2").val()}, function(res){
                $("#ssptable tbody tr").remove();
                var resInfo = $.parseJSON(res);
                if(resInfo['descripcion']==null){
                    $("#addPromo").hide();
                    $("#ssptable tbody tr").remove();
                    alert("no se encontro un producto asociado a este sku")
                }else{
                    $("#addPromo").show();
                    $("#ssptable tbody").append('<tr>'+	
                    '<td><center>'+$("#codbarra2").val()+'</center></td>'+
                    '<td><center>'+resInfo['descripcion']+'</center></td>'+
                    '<td><center>'+resInfo['precio']+'</center></td>'+
                    '<td><center>'+resInfo['oferta']+'</center></td>'+
                    '</tr>');
                }

            });
        }
    else {  
            alert("ingrese un codigo valido");  
            $("#ssptable tbody tr").remove(); 
            $("#addPromo").hide();
        }    
    });

    $("#agregar").click(function(){
      var codigo =$("#ssptable tbody tr:eq(0)").find("td").eq(0).text();
      var precio =$("#txt_oferta").val();

      if($("#ssptable tbody tr:eq(0)").find("td").eq(3).text()=='NO'){ // comprobar si ya tiene una oferta o no
        $.post('modulos/promociones/scripts/agregarPromo.php', {codigo:codigo,precio:precio}, function(res){
            if (res==1){
                $("#txt_oferta").val('');
                $("#consultar").click();
            }else{
                alert(res);
            }
        });
      }else{
        $.post('modulos/promociones/scripts/actualizarPromo.php', {codigo:codigo,precio:precio}, function(res){
            if (res==1){
                $("#txt_oferta").val('');
                $("#consultar").click();
            }else{
                alert(res);
            }
        });
       
      }
    });
    $("#eliminar").click(function(){
        var codigo =$("#ssptable tbody tr:eq(0)").find("td").eq(0).text();
        $.post('modulos/promociones/scripts/eliminarPromo.php', {codigo:codigo}, function(res){   
            $("#consultar").click();
        });
    });
});

function controlInput(campo){
    if (campo==''){
        return false;
    }else {
        return true;
    }

}