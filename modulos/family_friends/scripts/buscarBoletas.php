<?php
class Producto
{
    // Declaración de una propiedad
	public $nombre = '';
	public $marca ='';
	public $codigo = '';
	public $fechaVenc ='';
	public $stock ='';
	public $precio ='';
	public $oferta ='';

	function __construct($marca,$nombre,$codigo,$fechaVenc,$stock,$precio,$oferta){
		$this->nombre = $nombre;
		$this->marca = $marca;
		$this->codigo = $codigo;
		$this->fechaVenc = $fechaVenc;
		$this->stock = $stock;
		$this->precio = $precio;
		$this->oferta = $oferta;
	}
}

$productos=[];
$productos[0]= new Producto ('CHANEL','Labial Rouge Allure Liquid Powder líquido Plaisir','3145891629507','31/07/2021',3,18900,13990);
$productos[1]= new Producto ('CHANEL','Paleta de Ojos Naturelle Deep, Les Beiges Palette Regard Belle Mine','3145891841886','31/07/2021',3,40300,28990);
$productos[2]= new Producto ('CHANEL','Sombra de Ojos Rouge Noir Stylo Ombre Et Contour','3145891822083','31/08/2021',2,20800,14990);
$productos[3]= new Producto ('CHANEL','Sombra de Ojos 4 Colores Candeur Et Experience Les 4 Ombres','3145891642681','31/08/2021',2,38400,26990);
$productos[4]= new Producto ('CHANEL','Labial liquido Volupte Rouge Allure Liquid Powder','3145891629583','31/08/2021',1,18900,13990);
$productos[5]= new Producto ('CHANEL','Labial Impressive Rouge Allure Velvet Extreme','3145891621105','31/08/2021',1,24700,17990);
$productos[6]= new Producto ('CHANEL','LABIAL ROUGE ALLURE LIQUID POWDER','3145891629545','30/09/2021',2,18900,13990);
//$productos[7]= new Producto ('DIOR','Skin Polvo Nude Luminizer','3348901399906','01/07/2021',0,29990,18900);
//$productos[8]= new Producto ('DIOR','Rouge Labial Ultra Rouge Hidratante','3348901408813','01/08/2021',0,23990,14900);
//$productos[9]= new Producto ('DIOR','Rouge Labial Ultra Rouge Hidratante','3348901408714','01/08/2021',0,23990,14900);
$productos[7]= new Producto ('DIOR','Addict Labial Líquido Larga Duración','3348901404990','01/08/2021',3,23990,14900);
$productos[8]= new Producto ('DIOR','Diorskin Nude Polvo Iluminador','3348901399937','01/08/2021',1,29990,19500);
$productos[9]= new Producto ('DIOR','Rouge Labial Ultra Rouge Pigmented Hydra','3348901408769','01/09/2021',12,23990,14900);
$productos[10]= new Producto ('DIOR','Capture Youth Serum Age-delay Anti-redness 30ml','3348901377898','01/09/2021',2,58990,37900);
$productos[11]= new Producto ('DIOR','Rouge Labial Ultra Rouge Pigmented Hydra','3348901408899','01/10/2021',7,23990,14900);
$productos[12]= new Producto ('DIOR','Rouge Labial Ultra Rouge Hidratante','3348901408820','01/10/2021',5,23990,14900);
$productos[13]= new Producto ('DIOR','Rouge Labial Ultra Rouge Pigmented Hydra','3348901408752','01/10/2021',3,23990,14900);

echo (json_encode($productos));
?>