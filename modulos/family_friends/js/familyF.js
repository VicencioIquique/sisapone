$(document).ready(function(){
    $.post('modulos/family_friends/scripts/buscarBoletas.php', function(res){
        var resInfo = $.parseJSON(res);
        console.log(resInfo[1]);
        $("#ssptable2 tbody tr").remove();
        resInfo.map((i)=>{
            //console.log(i.nombre);
            //console.log(i.precio +""+'tipo:'+format(i.precio));
            $("#ssptable2 tbody").append('<tr>'+	
            '<td><center>'+i.marca+'</center></td>'+
            '<td><center>'+i.nombre+'</center></td>'+
            '<td><center>'+i.codigo+'</center></td>'+
            '<td><center>'+i.fechaVenc+'</center></td>'+
            '<td><center>'+i.stock+'</center></td>'+
            '<td><center>$'+format(i.precio)+'</center></td>'+
            '<td><center>$'+format(i.oferta)+'</center></td>'+
            '</tr>');
        });
    });
});

function format(input)
{
var num = input.toString().replace(/\./g,'');
if(!isNaN(num)){
num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
num = num.split('').reverse().join('').replace(/^[\.]/,'');
return(num);
}
else{ alert('Solo se permiten numeros');
}
}