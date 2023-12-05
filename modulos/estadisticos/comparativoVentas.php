<script type="text/javascript" src="js/jquery.base64.js"></script>
<script type="text/javascript" src="js/jquery.btechco.excelexport.js"></script>
 
<script language="javascript">
$(document).ready(function() {
	//  $("#descargarExcel").click(function(){
	// 	$("#ssptable2").btechco_excelexport({
	// 		containerid: "ssptable2"
	// 	   , datatype: $datatype.Table
	// 	});
	// });
	// $("#dialogDescarga").dialog({
	// 	autoOpen: false,
	// 	title: 'a',
	// 	resizable: false,
	// 	width: 200,
	// 	height: 205
	// }).dialog("widget").find(".ui-dialog-title").hide();
	// $("#dialogDescarga:eq(0)")
	// 	.dialog("widget")
	// 	.find(".ui-dialog-titlebar").css({ "float": "right", border: 0, padding: 0 })
	// 	.find(".ui-dialog-title").css({ display: "none" }).end()
	// 	.find(".ui-dialog-titlebar-close").css({ top: 0, right: 0, margin: 0, "z-index": 999
	// });
	// $("#dialogDescarga").dialog("open");
});
</script>
<script language="javascript"> 
$(document).ready(function() { 
     $(".botonExcel").click(function(event) { 
     $("#datos_a_enviar").val( $("<div>").append( $("#ssptable2").eq(0).clone()).html()); 
     $("#FormularioExportacion").submit(); 
	}); 
}); 
</script> 
<?php
require_once("clases/conexionocdb.php");
ini_set('max_execution_time', 600);
$anio = date("Y");
$mes = date("m");
$cont = 1;

//AREO
$LOCAL2 = array();
$LOCAL8 = array();

$LOCAL2[2014][1] = 24988800; $LOCAL8[2014][1] = 21778614;
$LOCAL2[2014][2] = 34104469; $LOCAL8[2014][2] = 24953582;
$LOCAL2[2014][3] = 30279315; $LOCAL8[2014][3] = 26726800;
$LOCAL2[2014][4] = 48808504; $LOCAL8[2014][4] = 30395301;
$LOCAL2[2014][5] = 38004940; $LOCAL8[2014][5] = 30725303;
$LOCAL2[2014][6] = 31444811; $LOCAL8[2014][6] = 25761454;
$LOCAL2[2014][7] = 27526288; $LOCAL8[2014][7] = 22575776;
$LOCAL2[2014][8] = 31622381; $LOCAL8[2014][8] = 35219401;
$LOCAL2[2014][9] = 22659700; $LOCAL8[2014][9] = 27815051;
$LOCAL2[2014][10] = 25764511; $LOCAL8[2014][10] = 35155600;
$LOCAL2[2014][11] = 31597802; $LOCAL8[2014][11] = 28150300;
$LOCAL2[2014][12] = 29102089; $LOCAL8[2014][12] = 31863650;

//MODULOS
$ZFI1010 = array();
$ZFI1132 = array();
$ZFI181 = array();
$ZFI184 = array();
$ZFI2002 = array();
$ZFI2077 = array();
$ZFI6115 = array(); //HUGO BOSS
$ZFI6130 = array(); //COSMETICOS
$ECM2002 = array(); //E-Commerce

$ZFI181[2011][1] = 44404450; $ZFI181[2012][1] = 53568424; $ZFI181[2013][1] = 49542604; $ZFI181[2014][1] = 54639050;
$ZFI181[2011][2] = 74402360; $ZFI181[2012][2] = 74076909; $ZFI181[2013][2] = 73599261; $ZFI181[2014][2] = 64376696;
$ZFI181[2011][3] = 48780810; $ZFI181[2012][3] = 61791778; $ZFI181[2013][3] = 60956508; $ZFI181[2014][3] = 49285500;
$ZFI181[2011][4] = 72445951; $ZFI181[2012][4] = 72943677; $ZFI181[2013][4] = 59574740; $ZFI181[2014][4] = 26389950;
$ZFI181[2011][5] = 72410670; $ZFI181[2012][5] = 66568782; $ZFI181[2013][5] = 70777852; $ZFI181[2014][5] = 58892421;
$ZFI181[2011][6] = 56951738; $ZFI181[2012][6] = 67429300; $ZFI181[2013][6] = 65568550; $ZFI181[2014][6] = 47569800;
$ZFI181[2011][7] = 89270650; $ZFI181[2012][7] = 89003561; $ZFI181[2013][7] = 72539106; $ZFI181[2014][7] = 71631140;
$ZFI181[2011][8] = 68696395; $ZFI181[2012][8] = 74431690; $ZFI181[2013][8] = 62776756; $ZFI181[2014][8] = 57960870;
$ZFI181[2011][9] = 66049250; $ZFI181[2012][9] = 64843410; $ZFI181[2013][9] = 52959950; $ZFI181[2014][9] = 49648858;
$ZFI181[2011][10] = 92245716; $ZFI181[2012][10] = 69290130; $ZFI181[2013][10] = 66152296; $ZFI181[2014][10] = 67261020;
$ZFI181[2011][11] = 80028556; $ZFI181[2012][11] = 80989150; $ZFI181[2013][11] = 87268400; $ZFI181[2014][11] = 68935300;
$ZFI181[2011][12] = 131361226; $ZFI181[2012][12] = 144536094; $ZFI181[2013][12] = 110759498; $ZFI181[2014][12] = 134172250;

$ZFI181[2015][1] = 50482800; $ZFI181[2016][1] = 40234772;
$ZFI181[2015][2] = 58343065; $ZFI181[2016][2] = 54514050;
$ZFI181[2015][3] = 46932200; $ZFI181[2016][3] = 41246272;
$ZFI181[2015][4] = 50142830; $ZFI181[2016][4] = 39855328;
$ZFI181[2015][5] = 58580042; $ZFI181[2016][5] = 36456760;
$ZFI181[2015][6] = 32650180; $ZFI181[2016][6] = 36062760;
$ZFI181[2015][7] = 67912960; $ZFI181[2016][7] = 50394460;
$ZFI181[2015][8] = 45390150; $ZFI181[2016][8] = 16714359;
$ZFI181[2015][9] = 35726919;
$ZFI181[2015][10] = 53712370;
$ZFI181[2015][11] = 54437270;
$ZFI181[2015][12] = 98016783;

$ZFI184[2011][1] = 21705540; $ZFI184[2012][1] = 26164638; $ZFI184[2013][1] = 29715541; $ZFI184[2014][1] = 35154902; $ZFI184[2015][1] = 28084650; 
$ZFI184[2011][2] = 36125310; $ZFI184[2012][2] = 38890050; $ZFI184[2013][2] = 35755100; $ZFI184[2014][2] = 43225103; $ZFI184[2015][2] = 31013336;
$ZFI184[2011][3] = 26572090; $ZFI184[2012][3] = 27823360; $ZFI184[2013][3] = 38435760; $ZFI184[2014][3] = 30441459; $ZFI184[2015][3] = 20071260;
$ZFI184[2011][4] = 25575920; $ZFI184[2012][4] = 27776000; $ZFI184[2013][4] = 36705280; $ZFI184[2014][4] = 15206490; $ZFI184[2015][4] = 26096458;
$ZFI184[2011][5] = 30021860; $ZFI184[2012][5] = 24597970; $ZFI184[2013][5] = 43163070; $ZFI184[2014][5] = 35068402; $ZFI184[2015][5] = 33519296;
$ZFI184[2011][6] = 25386910; $ZFI184[2012][6] = 24590603; $ZFI184[2013][6] = 35389450; $ZFI184[2014][6] = 30430587; $ZFI184[2015][6] = 18288610;
$ZFI184[2011][7] = 37295790; $ZFI184[2012][7] = 36155338; $ZFI184[2013][7] = 41347188; $ZFI184[2014][7] = 37487577; $ZFI184[2015][7] = 38195025;
$ZFI184[2011][8] = 30240610; $ZFI184[2012][8] = 27678581; $ZFI184[2013][8] = 32490450; $ZFI184[2014][8] = 31788111; $ZFI184[2015][8] = 23859024;
$ZFI184[2011][9] = 27708170; $ZFI184[2012][9] = 27610790; $ZFI184[2013][9] = 30561200; $ZFI184[2014][9] = 27373253; $ZFI184[2015][9] = 20133523;
$ZFI184[2011][10] = 44657864; $ZFI184[2012][10] = 31613430; $ZFI184[2013][10] = 37135047; $ZFI184[2014][10] = 35176411; $ZFI184[2015][10] = 27479528;
$ZFI184[2011][11] = 41812350; $ZFI184[2012][11] = 37562100; $ZFI184[2013][11] = 53058360; $ZFI184[2014][11] = 42064755; $ZFI184[2015][11] = 37334155;
$ZFI184[2011][12] = 71593390; $ZFI184[2012][12] = 75920842; $ZFI184[2013][12] = 65377172; $ZFI184[2014][12] = 75529770; $ZFI184[2015][12] = 63344640;

$ZFI184[2016][1] = 22121770 ; $ZFI184[2017][1] = 35418052; $ZFI184[2018][1] = 33854310; $ZFI184[2019][1] = 24672620;
$ZFI184[2016][2] = 30413034 ; $ZFI184[2017][2] = 39443040; $ZFI184[2018][2] = 30068562; $ZFI184[2019][2] = 28566294;
$ZFI184[2016][3] = 24944915 ; $ZFI184[2017][3] = 25624140; $ZFI184[2018][3] = 25414141; $ZFI184[2019][3] = 21659506;
$ZFI184[2016][4] = 24123335 ; $ZFI184[2017][4] = 29645965; $ZFI184[2018][4] = 20897130; $ZFI184[2019][4] = 22808500;
$ZFI184[2016][5] = 28481270 ; $ZFI184[2017][5] = 30063746; $ZFI184[2018][5] = 23962880; $ZFI184[2019][5] = 28414190;
$ZFI184[2016][6] = 25580801 ; $ZFI184[2017][6] = 28321853; $ZFI184[2018][6] = 20932455; $ZFI184[2019][6] = 20863440;
$ZFI184[2016][7] = 30176270 ; $ZFI184[2017][7] = 38049600; $ZFI184[2018][7] = 27195736; $ZFI184[2019][7] = 35280370;
$ZFI184[2016][8] = 30484770 ; $ZFI184[2017][8] = 25971812; $ZFI184[2018][8] = 20131900; $ZFI184[2019][8] = 27412490;
$ZFI184[2016][9] = 40585034 ; $ZFI184[2017][9] = 28301200; $ZFI184[2018][9] = 21959533; $ZFI184[2019][9] = 25929661;
$ZFI184[2016][10] = 43124530 ; $ZFI184[2017][10] = 39798880; $ZFI184[2018][10] = 25523351; $ZFI184[2019][10] = 21345210;
$ZFI184[2016][11] = 34595621 ; $ZFI184[2017][11] = 31796120; $ZFI184[2018][11] = 34458558; $ZFI184[2019][11] = 25412130;
$ZFI184[2016][12] = 70229201 ; $ZFI184[2017][12] = 61496258; $ZFI184[2018][12] = 50801327; $ZFI184[2019][12] = 59175597;



$ZFI1010[2011][1] = 38041560; $ZFI1010[2012][1] = 51489821; $ZFI1010[2013][1] = 64110170; $ZFI1010[2014][1] = 70188334; $ZFI1010[2015][1] = 67503560;
$ZFI1010[2011][2] = 56892400; $ZFI1010[2012][2] = 74000628; $ZFI1010[2013][2] = 82341616; $ZFI1010[2014][2] = 94553326; $ZFI1010[2015][2] = 72171579;
$ZFI1010[2011][3] = 45837270; $ZFI1010[2012][3] = 61924442; $ZFI1010[2013][3] = 71560687; $ZFI1010[2014][3] = 70734245; $ZFI1010[2015][3] = 63886698;
$ZFI1010[2011][4] = 55760340; $ZFI1010[2012][4] = 62178534; $ZFI1010[2013][4] = 61467410; $ZFI1010[2014][4] = 31078104; $ZFI1010[2015][4] = 62855736;
$ZFI1010[2011][5] = 60431020; $ZFI1010[2012][5] = 63056312; $ZFI1010[2013][5] = 73943477; $ZFI1010[2014][5] = 86569813; $ZFI1010[2015][5] = 88432446;
$ZFI1010[2011][6] = 52169350; $ZFI1010[2012][6] = 60102928; $ZFI1010[2013][6] = 76263551; $ZFI1010[2014][6] = 66631285; $ZFI1010[2015][6] = 47871551;
$ZFI1010[2011][7] = 68453870; $ZFI1010[2012][7] = 77279326; $ZFI1010[2013][7] = 88142386; $ZFI1010[2014][7] = 102557650; $ZFI1010[2015][7] = 98387113;
$ZFI1010[2011][8] = 57441390; $ZFI1010[2012][8] = 62847521; $ZFI1010[2013][8] = 84167605; $ZFI1010[2014][8] = 91437503; $ZFI1010[2015][8] = 70596068;
$ZFI1010[2011][9] = 51492762; $ZFI1010[2012][9] = 58956013; $ZFI1010[2013][9] = 62661394; $ZFI1010[2014][9] = 72531518; $ZFI1010[2015][9] = 54126770;
$ZFI1010[2011][10] = 82810170; $ZFI1010[2012][10] = 75819813; $ZFI1010[2013][10] = 88170296; $ZFI1010[2014][10] = 88312585; $ZFI1010[2015][10] = 79904643;
$ZFI1010[2011][11] = 77226310; $ZFI1010[2012][11] = 93713066; $ZFI1010[2013][11] = 105446580; $ZFI1010[2014][11] = 89748659; $ZFI1010[2015][11] = 82005643;
$ZFI1010[2011][12] = 156800672; $ZFI1010[2012][12] = 182787088; $ZFI1010[2013][12] = 154013683; $ZFI1010[2014][12] = 188611922; $ZFI1010[2015][12] = 145771545;

$ZFI1010[2016][1] = 60508654 ; $ZFI1010[2017][1] = 57444983; $ZFI1010[2018][1] = 63030532; $ZFI1010[2019][1] = 38983370;
$ZFI1010[2016][2] = 74813405 ; $ZFI1010[2017][2] = 67068606; $ZFI1010[2018][2] = 63533710; $ZFI1010[2019][2] = 44559710;
$ZFI1010[2016][3] = 54952539 ; $ZFI1010[2017][3] = 50123440; $ZFI1010[2018][3] = 52442630; $ZFI1010[2019][3] = 41383656;
$ZFI1010[2016][4] = 54497660 ; $ZFI1010[2017][4] = 58084392; $ZFI1010[2018][4] = 45336600; $ZFI1010[2019][4] = 42526781;
$ZFI1010[2016][5] = 61571911 ; $ZFI1010[2017][5] = 58966885; $ZFI1010[2018][5] = 54431949; $ZFI1010[2019][5] = 48511870;
$ZFI1010[2016][6] = 52505360 ; $ZFI1010[2017][6] = 52192310; $ZFI1010[2018][6] = 43088700; $ZFI1010[2019][6] = 40585061;
$ZFI1010[2016][7] = 65330300 ; $ZFI1010[2017][7] = 71238191; $ZFI1010[2018][7] = 54135051; $ZFI1010[2019][7] = 64867570;
$ZFI1010[2016][8] = 63909944 ; $ZFI1010[2017][8] = 57537000; $ZFI1010[2018][8] = 41995370; $ZFI1010[2019][8] = 53252648;
$ZFI1010[2016][9] = 63134800 ; $ZFI1010[2017][9] = 46749430; $ZFI1010[2018][9] = 41488112; $ZFI1010[2019][9] = 41316762;
$ZFI1010[2016][10] = 75421940 ; $ZFI1010[2017][10] = 70503435; $ZFI1010[2018][10] = 61385321; $ZFI1010[2019][10] = 37135200;
$ZFI1010[2016][11] = 60845431 ; $ZFI1010[2017][11] = 56220983; $ZFI1010[2018][11] = 54563543; $ZFI1010[2019][11] = 43993810;
$ZFI1010[2016][12] = 123451173 ; $ZFI1010[2017][12] = 136705690; $ZFI1010[2018][12] = 110715372; $ZFI1010[2019][12] = 110732990;

$ZFI1132[2011][1] = 179556360; $ZFI1132[2012][1] = 200236960; $ZFI1132[2013][1] = 207041661; $ZFI1132[2014][1] = 248627819; $ZFI1132[2015][1] = 299845198;
$ZFI1132[2011][2] = 238229910; $ZFI1132[2012][2] = 273642673; $ZFI1132[2013][2] = 291874181; $ZFI1132[2014][2] = 329922569; $ZFI1132[2015][2] = 380610566;
$ZFI1132[2011][3] = 197128270; $ZFI1132[2012][3] = 208625033; $ZFI1132[2013][3] = 280408554; $ZFI1132[2014][3] = 223685158; $ZFI1132[2015][3] = 281337700;
$ZFI1132[2011][4] = 230733590; $ZFI1132[2012][4] = 246182801; $ZFI1132[2013][4] = 239146661; $ZFI1132[2014][4] = 114729072; $ZFI1132[2015][4] = 289295230;
$ZFI1132[2011][5] = 215367720; $ZFI1132[2012][5] = 278455041; $ZFI1132[2013][5] = 289378805; $ZFI1132[2014][5] = 307357297; $ZFI1132[2015][5] = 382481812;
$ZFI1132[2011][6] = 207418270; $ZFI1132[2012][6] = 256744438; $ZFI1132[2013][6] = 260926340; $ZFI1132[2014][6] = 249424333; $ZFI1132[2015][6] = 219516446;
$ZFI1132[2011][7] = 249864615; $ZFI1132[2012][7] = 311474213; $ZFI1132[2013][7] = 295669857; $ZFI1132[2014][7] = 347428480; $ZFI1132[2015][7] = 419620020;
$ZFI1132[2011][8] = 238855580; $ZFI1132[2012][8] = 268173717; $ZFI1132[2013][8] = 255485707; $ZFI1132[2014][8] = 307111566; $ZFI1132[2015][8] = 325630546;
$ZFI1132[2011][9] = 240560526; $ZFI1132[2012][9] = 282795653; $ZFI1132[2013][9] = 217539450; $ZFI1132[2014][9] = 274439713; $ZFI1132[2015][9] = 284874826;
$ZFI1132[2011][10] = 326298631; $ZFI1132[2012][10] = 317251321; $ZFI1132[2013][10] = 219900094; $ZFI1132[2014][10] = 252375894; $ZFI1132[2015][10] = 355457792;
$ZFI1132[2011][11] = 285422600; $ZFI1132[2012][11] = 350339208; $ZFI1132[2013][11] = 329805333; $ZFI1132[2014][11] = 338419699; $ZFI1132[2015][11] = 360864561;
$ZFI1132[2011][12] = 492840345; $ZFI1132[2012][12] = 608787248; $ZFI1132[2013][12] = 499860706; $ZFI1132[2014][12] = 667177400; $ZFI1132[2015][12] = 697912387;

$ZFI1132[2016][1] = 341085775; $ZFI1132[2017][1] = 340760260; $ZFI1132[2018][1] = 419190117; $ZFI1132[2019][1] = 398933391;
$ZFI1132[2016][2] = 407562424; $ZFI1132[2017][2] = 459166028; $ZFI1132[2018][2] = 460687841; $ZFI1132[2019][2] = 454899963;
$ZFI1132[2016][3] = 317798030; $ZFI1132[2017][3] = 328564715; $ZFI1132[2018][3] = 370840841; $ZFI1132[2019][3] = 406865545;
$ZFI1132[2016][4] = 304321368; $ZFI1132[2017][4] = 350478039; $ZFI1132[2018][4] = 338658090; $ZFI1132[2019][4] = 391247944;
$ZFI1132[2016][5] = 342174576; $ZFI1132[2017][5] = 391877454; $ZFI1132[2018][5] = 431812905; $ZFI1132[2019][5] = 457978321;
$ZFI1132[2016][6] = 317147649; $ZFI1132[2017][6] = 362964198; $ZFI1132[2018][6] = 377844648; $ZFI1132[2019][6] = 390962356;
$ZFI1132[2016][7] = 360282443; $ZFI1132[2017][7] = 462577785; $ZFI1132[2018][7] = 460977500; $ZFI1132[2019][7] = 516416134;
$ZFI1132[2016][8] = 339741319; $ZFI1132[2017][8] = 349422547; $ZFI1132[2018][8] = 415230958; $ZFI1132[2019][8] = 481448496;
$ZFI1132[2016][9] = 345415409; $ZFI1132[2017][9] = 360879604; $ZFI1132[2018][9] = 413104963; $ZFI1132[2019][9] = 402076989;
$ZFI1132[2016][10] = 442981991; $ZFI1132[2017][10] = 443499843; $ZFI1132[2018][10] = 482437378; $ZFI1132[2019][10] = 334199490;
$ZFI1132[2016][11] = 366933657; $ZFI1132[2017][11] = 403963782; $ZFI1132[2018][11] = 537694237; $ZFI1132[2019][11] = 459908645;
$ZFI1132[2016][12] = 721958224; $ZFI1132[2017][12] = 819970417; $ZFI1132[2018][12] = 913397543; $ZFI1132[2019][12] = 940745068;

$ZFI2002[2011][1] = 69755910; $ZFI2002[2012][1] = 85422816; $ZFI2002[2013][1] = 95531102; $ZFI2002[2014][1] = 94455451; $ZFI2002[2015][1] = 88344819;
$ZFI2002[2011][2] = 94113330; $ZFI2002[2012][2] = 105244801; $ZFI2002[2013][2] = 133533263; $ZFI2002[2014][2] = 123673359; $ZFI2002[2015][2] = 103681202;
$ZFI2002[2011][3] = 70844840; $ZFI2002[2012][3] = 94250901; $ZFI2002[2013][3] = 117221074; $ZFI2002[2014][3] = 93721957; $ZFI2002[2015][3] = 67375645;
$ZFI2002[2011][4] = 75081160; $ZFI2002[2012][4] = 106517904; $ZFI2002[2013][4] = 102455700; $ZFI2002[2014][4] = 5693800; $ZFI2002[2015][4] = 68413827;
$ZFI2002[2011][5] = 92783790; $ZFI2002[2012][5] = 101762635; $ZFI2002[2013][5] = 125774361; $ZFI2002[2014][5] = 114094508; $ZFI2002[2015][5] = 91097894;
$ZFI2002[2011][6] = 85021890; $ZFI2002[2012][6] = 104833963; $ZFI2002[2013][6] = 110366151; $ZFI2002[2014][6] = 84859872; $ZFI2002[2015][6] = 50061505;
$ZFI2002[2011][7] = 101853250; $ZFI2002[2012][7] = 131560382; $ZFI2002[2013][7] = 121478753; $ZFI2002[2014][7] = 128428326; $ZFI2002[2015][7] = 108901576;
$ZFI2002[2011][8] = 91581600; $ZFI2002[2012][8] = 108356994; $ZFI2002[2013][8] = 110222042; $ZFI2002[2014][8] = 107038234; $ZFI2002[2015][8] = 66466739;
$ZFI2002[2011][9] = 77322008; $ZFI2002[2012][9] = 98303591; $ZFI2002[2013][9] = 81600289; $ZFI2002[2014][9] = 78705545; $ZFI2002[2015][9] = 62086128;
$ZFI2002[2011][10] = 124587181; $ZFI2002[2012][10] = 138777548; $ZFI2002[2013][10] = 109653137; $ZFI2002[2014][10] = 112716161; $ZFI2002[2015][10] = 78849822;
$ZFI2002[2011][11] = 114831253; $ZFI2002[2012][11] = 148427232; $ZFI2002[2013][11] = 151353831; $ZFI2002[2014][11] = 120010836; $ZFI2002[2015][11] = 96608536;
$ZFI2002[2011][12] = 213347570; $ZFI2002[2012][12] = 262289669; $ZFI2002[2013][12] = 220137316; $ZFI2002[2014][12] = 234214756; $ZFI2002[2015][12] = 172560280;

$ZFI2002[2016][1] = 66095801; $ZFI2002[2017][1] = 77191102; $ZFI2002[2018][1] = 77409615; $ZFI2002[2019][1] = 51918730;
$ZFI2002[2016][2] = 93078042; $ZFI2002[2017][2] = 99273200; $ZFI2002[2018][2] = 88696544; $ZFI2002[2019][2] = 52274352;
$ZFI2002[2016][3] = 65759600; $ZFI2002[2017][3] = 70909363; $ZFI2002[2018][3] = 65359869; $ZFI2002[2019][3] = 43227597;
$ZFI2002[2016][4] = 62125113; $ZFI2002[2017][4] = 68854620; $ZFI2002[2018][4] = 55426802; $ZFI2002[2019][4] = 54877361;
$ZFI2002[2016][5] = 70575026; $ZFI2002[2017][5] = 76982909; $ZFI2002[2018][5] = 69651366; $ZFI2002[2019][5] = 63832441;
$ZFI2002[2016][6] = 64223074; $ZFI2002[2017][6] = 65008140; $ZFI2002[2018][6] = 50388731; $ZFI2002[2019][6] = 49132731;
$ZFI2002[2016][7] = 80971785; $ZFI2002[2017][7] = 93065457; $ZFI2002[2018][7] = 64255574; $ZFI2002[2019][7] = 77187711;
$ZFI2002[2016][8] = 80007349; $ZFI2002[2017][8] = 64318206; $ZFI2002[2018][8] = 48635920; $ZFI2002[2019][8] = 60976459;
$ZFI2002[2016][9] = 89258538; $ZFI2002[2017][9] = 68625032; $ZFI2002[2018][9] = 52450823; $ZFI2002[2019][9] = 59631859;
$ZFI2002[2016][10] = 119401075; $ZFI2002[2017][10] = 84032619; $ZFI2002[2018][10] = 64647661; $ZFI2002[2019][10] = 41301910;
$ZFI2002[2016][11] = 94110195; $ZFI2002[2017][11] = 84037187; $ZFI2002[2018][11] = 72026247; $ZFI2002[2019][11] = 59256150;
$ZFI2002[2016][12] = 169897579; $ZFI2002[2017][12] = 161020889; $ZFI2002[2018][12] = 133037804; $ZFI2002[2019][12] = 140873921;

$ZFI2077[2011][1] = 61971680; $ZFI2077[2012][1] = 76551679; $ZFI2077[2013][1] = 91342431; $ZFI2077[2014][1] = 81437060; $ZFI2077[2015][1] = 71804170;
$ZFI2077[2011][2] = 91638840; $ZFI2077[2012][2] = 93048099; $ZFI2077[2013][2] = 123111503; $ZFI2077[2014][2] = 108543832; $ZFI2077[2015][2] = 84322131;
$ZFI2077[2011][3] = 66400570; $ZFI2077[2012][3] = 72743875; $ZFI2077[2013][3] = 94942570; $ZFI2077[2014][3] = 76453607; $ZFI2077[2015][3] = 64256060;
$ZFI2077[2011][4] = 84950560; $ZFI2077[2012][4] = 84343429; $ZFI2077[2013][4] = 88369640; $ZFI2077[2014][4] = 7899750; $ZFI2077[2015][4] = 74028391;
$ZFI2077[2011][5] = 85183240; $ZFI2077[2012][5] = 84523555; $ZFI2077[2013][5] = 92466709; $ZFI2077[2014][5] = 97194701; $ZFI2077[2015][5] = 89247984;
$ZFI2077[2011][6] = 73964510; $ZFI2077[2012][6] = 80783754; $ZFI2077[2013][6] = 82794580; $ZFI2077[2014][6] = 71174297; $ZFI2077[2015][6] = 51801721;
$ZFI2077[2011][7] = 94771630; $ZFI2077[2012][7] = 106971269; $ZFI2077[2013][7] = 99472470; $ZFI2077[2014][7] = 93162385; $ZFI2077[2015][7] = 104248105;
$ZFI2077[2011][8] = 80228860; $ZFI2077[2012][8] = 84697330; $ZFI2077[2013][8] = 90363906; $ZFI2077[2014][8] = 92643789; $ZFI2077[2015][8] = 78099970;
$ZFI2077[2011][9] = 69835150; $ZFI2077[2012][9] = 82950382; $ZFI2077[2013][9] = 86891403; $ZFI2077[2014][9] = 77617619; $ZFI2077[2015][9] = 68696895;
$ZFI2077[2011][10] = 98704370; $ZFI2077[2012][10] = 96341470; $ZFI2077[2013][10] = 111815402; $ZFI2077[2014][10] = 105647327; $ZFI2077[2015][10] = 81276200;
$ZFI2077[2011][11] = 90706913; $ZFI2077[2012][11] = 104368066; $ZFI2077[2013][11] = 136604606; $ZFI2077[2014][11] = 95385082; $ZFI2077[2015][11] = 87091511;
$ZFI2077[2011][12] = 184196890; $ZFI2077[2012][12] = 210862031; $ZFI2077[2013][12] = 191337869; $ZFI2077[2014][12] = 174960220; $ZFI2077[2015][12] = 159871260;

$ZFI2077[2016][1] = 66704810; $ZFI2077[2017][1] = 99447272; $ZFI2077[2018][1] = 128767836; $ZFI2077[2019][1] = 108033760; 
$ZFI2077[2016][2] = 74133480; $ZFI2077[2017][2] = 107715732; $ZFI2077[2018][2] = 147581066; $ZFI2077[2019][2] = 127445011; 
$ZFI2077[2016][3] = 54675911; $ZFI2077[2017][3] = 80715571; $ZFI2077[2018][3] = 108752767; $ZFI2077[2019][3] = 110658751; 
$ZFI2077[2016][4] = 59533851; $ZFI2077[2017][4] = 80172621; $ZFI2077[2018][4] = 94527189; $ZFI2077[2019][4] = 102984621; 
$ZFI2077[2016][5] = 66110614; $ZFI2077[2017][5] = 85797854; $ZFI2077[2018][5] = 113830181; $ZFI2077[2019][5] = 127179272; 
$ZFI2077[2016][6] = 61859130; $ZFI2077[2017][6] = 77474930; $ZFI2077[2018][6] = 100708750; $ZFI2077[2019][6] = 105964904; 
$ZFI2077[2016][7] = 68949539; $ZFI2077[2017][7] = 102939592; $ZFI2077[2018][7] = 126097827; $ZFI2077[2019][7] = 147190117; 
$ZFI2077[2016][8] = 18283424; $ZFI2077[2017][8] = 85593199; $ZFI2077[2018][8] = 100462830; $ZFI2077[2019][8] = 126381693; 
$ZFI2077[2016][9] = 0; $ZFI2077[2017][9] = 91942040; $ZFI2077[2018][9] = 105687907; $ZFI2077[2019][9] = 105004913; 
$ZFI2077[2016][10] = 0; $ZFI2077[2017][10] = 135348898; $ZFI2077[2018][10] = 128179770; $ZFI2077[2019][10] = 93923700; 
$ZFI2077[2016][11] = 0; $ZFI2077[2017][11] = 120992540; $ZFI2077[2018][11] = 140476367; $ZFI2077[2019][11] = 112283131; 
$ZFI2077[2016][12] = 175449235; $ZFI2077[2017][12] = 235414311; $ZFI2077[2018][12] = 243621220; $ZFI2077[2019][12] = 249668593; 

$ZFI6115[2014][1] = 21691771; $ZFI6115[2015][1] = 31447030; $ZFI6130[2014][1] = 33019010; $ZFI6130[2015][1] = 29860350;
$ZFI6115[2014][2] = 24398670; $ZFI6115[2015][2] = 32912740; $ZFI6130[2014][2] = 38626064; $ZFI6130[2015][2] = 34650920;
$ZFI6115[2014][3] = 26752220; $ZFI6115[2015][3] = 32971620; $ZFI6130[2014][3] = 23671698; $ZFI6130[2015][3] = 25019699;
$ZFI6115[2014][4] = 7983370; $ZFI6115[2015][4] = 33784415; $ZFI6130[2014][4] = 5149500; $ZFI6130[2015][4] = 22849566;
$ZFI6115[2014][5] = 34365436; $ZFI6115[2015][5] = 39648400; $ZFI6130[2014][5] = 33105094; $ZFI6130[2015][5] = 27987521;
$ZFI6115[2014][6] = 37369570; $ZFI6115[2015][6] = 17307510; $ZFI6130[2014][6] = 24457471; $ZFI6130[2015][6] = 17166902;
$ZFI6115[2014][7] = 40778615; $ZFI6115[2015][7] = 28786400; $ZFI6130[2014][7] = 33328307; $ZFI6130[2015][7] = 32111154;
$ZFI6115[2014][8] = 33544580; $ZFI6115[2015][8] = 30649266; $ZFI6130[2014][8] = 34589231; $ZFI6130[2015][8] = 24604801;
$ZFI6115[2014][9] = 30012400; $ZFI6115[2015][9] = 20452900; $ZFI6130[2014][9] = 27223762; $ZFI6130[2015][9] = 21651615;
$ZFI6115[2014][10] = 44514540; $ZFI6115[2015][10] =33383900; $ZFI6130[2014][10] = 30566420; $ZFI6130[2015][10] =28860135;
$ZFI6115[2014][11] = 33850425; $ZFI6115[2015][11] =30966100; $ZFI6130[2014][11] = 28315554; $ZFI6130[2015][11] =30604930;
$ZFI6115[2014][12] = 59293750; $ZFI6115[2015][12] =56186025; $ZFI6130[2014][12] = 67315892; $ZFI6130[2015][12] =64353840;

$ZFI6115[2016][1] = 22419535; $ZFI6115[2017][1] = 26366830; $ZFI6115[2018][1] = 16400700; $ZFI6115[2019][1] = 16953500;
$ZFI6115[2016][2] = 21861760; $ZFI6115[2017][2] = 26590210; $ZFI6115[2018][2] = 13340800; $ZFI6115[2019][2] = 23425600;
$ZFI6115[2016][3] = 25685110; $ZFI6115[2017][3] = 19684100; $ZFI6115[2018][3] = 31112400; $ZFI6115[2019][3] = 26801900;
$ZFI6115[2016][4] = 36486400; $ZFI6115[2017][4] = 23486070; $ZFI6115[2018][4] = 26031700; $ZFI6115[2019][4] = 20315600;
$ZFI6115[2016][5] = 29019764; $ZFI6115[2017][5] = 17150150; $ZFI6115[2018][5] = 22929100; $ZFI6115[2019][5] = 20693800;
$ZFI6115[2016][6] = 26948008; $ZFI6115[2017][6] = 33742850; $ZFI6115[2018][6] = 25919600; $ZFI6115[2019][6] = 18447100;
$ZFI6115[2016][7] = 25465000; $ZFI6115[2017][7] = 16825700; $ZFI6115[2018][7] = 19502400; $ZFI6115[2019][7] = 13794800;
$ZFI6115[2016][8] = 36480300; $ZFI6115[2017][8] = 14849700; $ZFI6115[2018][8] = 23014101; $ZFI6115[2019][8] = 16664400;
$ZFI6115[2016][9] = 31414220; $ZFI6115[2017][9] = 16964100; $ZFI6115[2018][9] = 25840800; $ZFI6115[2019][9] = 11071900;
$ZFI6115[2016][10] = 24435800; $ZFI6115[2017][10] = 20981250; $ZFI6115[2018][10] = 24941900; $ZFI6115[2019][10] = 10184900;
$ZFI6115[2016][11] = 21854170; $ZFI6115[2017][11] = 24835204; $ZFI6115[2018][11] = 24073500; $ZFI6115[2019][11] = 23873300;
$ZFI6115[2016][12] = 53478170; $ZFI6115[2017][12] = 46798500; $ZFI6115[2018][12] = 41894600; $ZFI6115[2019][12] = 38929102;

$ZFI6130[2016][1] = 28559240; $ZFI6130[2017][1] = 28347090; $ZFI6130[2018][1] = 30341180; $ZFI6130[2019][1] = 19467460;
$ZFI6130[2016][2] = 38902320; $ZFI6130[2017][2] = 26633570; $ZFI6130[2018][2] = 34968820; $ZFI6130[2019][2] = 24516280;
$ZFI6130[2016][3] = 27318220; $ZFI6130[2017][3] = 25565900; $ZFI6130[2018][3] = 24566570; $ZFI6130[2019][3] = 20746790;
$ZFI6130[2016][4] = 22485070; $ZFI6130[2017][4] = 27154810; $ZFI6130[2018][4] = 21227730; $ZFI6130[2019][4] = 17400080;
$ZFI6130[2016][5] = 24418850; $ZFI6130[2017][5] = 28814020; $ZFI6130[2018][5] = 19110900; $ZFI6130[2019][5] = 19013530;
$ZFI6130[2016][6] = 23441780; $ZFI6130[2017][6] = 19843520; $ZFI6130[2018][6] = 19191080; $ZFI6130[2019][6] = 17792560;
$ZFI6130[2016][7] = 24445404; $ZFI6130[2017][7] = 29346730; $ZFI6130[2018][7] = 18762850; $ZFI6130[2019][7] = 22633400;
$ZFI6130[2016][8] = 20507640; $ZFI6130[2017][8] = 26245980; $ZFI6130[2018][8] = 17168830; $ZFI6130[2019][8] = 22084110;
$ZFI6130[2016][9] = 24445410; $ZFI6130[2017][9] = 28581730; $ZFI6130[2018][9] = 17121210; $ZFI6130[2019][9] = 19566769;
$ZFI6130[2016][10] = 27785395; $ZFI6130[2017][10] = 32912490; $ZFI6130[2018][10] = 20358470; $ZFI6130[2019][10] = 15366958;
$ZFI6130[2016][11] = 22024696; $ZFI6130[2017][11] = 26895150; $ZFI6130[2018][11] = 21161680; $ZFI6130[2019][11] = 19201530;
$ZFI6130[2016][12] = 45994840; $ZFI6130[2017][12] = 56003530; $ZFI6130[2018][12] = 41185170; $ZFI6130[2019][12] = 47531730;

$sql="SELECT
	WhsCode
	,Periodo
	,SUM(CtoVtaCIF) AS CIF
	,SUM(Total_CLP) AS TOTAL_PESO
	,SUM(Total_USD) AS TOTAL_DOLAR
FROM SBO_Imp_Eximben_SAC.[dbo].[VIC_VW_Ventas]
WHERE 
	Periodo BETWEEN '2020-01' AND '2500-12'
GROUP BY WhsCode, Periodo
ORDER BY Periodo ASC;";
$rs = odbc_exec( $conn, $sql );
if ( !$rs){
	exit( "Error en la consulta SQL" );
}
while($resultado = odbc_fetch_array($rs)){
	list($periodoAnio, $periodoMes) = preg_split('[-]', $resultado["Periodo"]);
	$periodoMes=(string)(int)$periodoMes; //QUITAMOS EL CERO DEL MES ES DECIR 01 queda en 1
	switch($resultado["WhsCode"]){
		case 'LOCAL.2':
				$LOCAL2[$periodoAnio][$periodoMes] = round($resultado["TOTAL_PESO"]);
				break;
		case 'LOCAL.8':
				$LOCAL8[$periodoAnio][$periodoMes] = round($resultado["TOTAL_PESO"]);
				break;
		case 'ZFI.1010':
				$ZFI1010[$periodoAnio][$periodoMes] = round($resultado["TOTAL_PESO"]);
				break;
		case 'ZFI.1132':
				$ZFI1132[$periodoAnio][$periodoMes] = round($resultado["TOTAL_PESO"]);
				break;
		case 'ZFI.13-1': //GALPON 1
				break;
		case 'ZFI.13-2': //GALPON 1
				break;
		case 'ZFI.13-6': //GALPON 6
				break;
		case 'ZFI.1623': //GALPON 23
				break;
		case 'ZFI.17SZ': //GALPON 23
				break;
		case 'ZFI.181':
				$ZFI181[$periodoAnio][$periodoMes] = round($resultado["TOTAL_PESO"]);
				break;
		case 'ZFI.184':
				$ZFI184[$periodoAnio][$periodoMes] = round($resultado["TOTAL_PESO"]);
				break;
		case 'ZFI.2002':
				$ZFI2002[$periodoAnio][$periodoMes] = round($resultado["TOTAL_PESO"]);
				break;
		case 'ZFI.2077':
				$ZFI2077[$periodoAnio][$periodoMes] = round($resultado["TOTAL_PESO"]);
				break;
		case 'ZFI.6115':
				$ZFI6115[$periodoAnio][$periodoMes] = round($resultado["TOTAL_PESO"]);
				break;
		case 'ZFI.6130':
				$ZFI6130[$periodoAnio][$periodoMes] = round($resultado["TOTAL_PESO"]);
				break;
		case 'ECM.2002':
        $ECM2002[$periodoAnio][$periodoMes] = round($resultado["TOTAL_PESO"]);
				break;
	}
	 
}
echo $sql;
//TOTALES
$TOTAL_ZFI181 = array();
$TOTAL_ZFI184 = array();
$TOTAL_ZFI1010 = array();
$TOTAL_ZFI1132 = array();
$TOTAL_ZFI2002 = array();
$TOTAL_ZFI2077 = array();
$TOTAL_LOCAL2 = array();
$TOTAL_LOCAL8 = array();
$TOTAL_ZFI6115 = array();
$TOTAL_ZFI6130 = array();
$TOTAL_ECM2002 = array();
//SUBTOTALES
$SUBTOTAL_ZFI181 = array();
$SUBTOTAL_ZFI184 = array();
$SUBTOTAL_ZFI1010 = array();
$SUBTOTAL_ZFI1132 = array();
$SUBTOTAL_ZFI2002 = array();
$SUBTOTAL_ZFI2077 = array();
$SUBTOTAL_LOCAL2 = array();
$SUBTOTAL_LOCAL8 = array();
$SUBTOTAL_ZFI6115 = array();
$SUBTOTAL_ZFI6130 = array();
$SUBTOTAL_ECM2002 = array();
//TOTAL DE TOTALES
$TOTAL = array();
//TOTAL DE SUBTOTALES
$SUBTOTAL = array();

$hasta = $anio - 5;
$hasta2 = $anio - 2;
for($ianio = $anio;$ianio > $hasta;$ianio--){
	$TOTAL_ZFI181[$ianio] = 0;
	$TOTAL_ZFI184[$ianio] = 0;
	$TOTAL_ZFI1010[$ianio] = 0;
	$TOTAL_ZFI1132[$ianio] = 0;
	$TOTAL_ZFI2002[$ianio] = 0;
	$TOTAL_ZFI2077[$ianio] = 0;
	$TOTAL_ECM2002[$ianio] = 0;
	$SUBTOTAL[$ianio] = 0;
	$SUBTOTAL_ZFI181[$ianio] = 0;
	$SUBTOTAL_ZFI184[$ianio] = 0;
	$SUBTOTAL_ZFI1010[$ianio] = 0;
	$SUBTOTAL_ZFI1132[$ianio] = 0;
	$SUBTOTAL_ZFI2002[$ianio] = 0;
	$SUBTOTAL_ZFI2077[$ianio] = 0;
	$SUBTOTAL_ECM2002[$ianio] = 0;
	for($imes=1;$imes<13;$imes++){
		$TOTAL_ZFI181[$ianio]=$TOTAL_ZFI181[$ianio] + $ZFI181[$ianio][$imes];
		$TOTAL_ZFI184[$ianio]=$TOTAL_ZFI184[$ianio] + $ZFI184[$ianio][$imes];
		$TOTAL_ZFI1010[$ianio]=$TOTAL_ZFI1010[$ianio] + $ZFI1010[$ianio][$imes];
		$TOTAL_ZFI1132[$ianio]=$TOTAL_ZFI1132[$ianio] + $ZFI1132[$ianio][$imes];
		$TOTAL_ZFI2002[$ianio]=$TOTAL_ZFI2002[$ianio] + $ZFI2002[$ianio][$imes];
		$TOTAL_ZFI2077[$ianio]=$TOTAL_ZFI2077[$ianio] + $ZFI2077[$ianio][$imes];
		$TOTAL_ECM2002[$ianio]=$TOTAL_ECM2002[$ianio] + $ECM2002[$ianio][$imes];
	}
	for($imes=1;$imes<=$mes;$imes++){
		$SUBTOTAL_ZFI181[$ianio]=$SUBTOTAL_ZFI181[$ianio] + $ZFI181[$ianio][$imes];
		$SUBTOTAL_ZFI184[$ianio]=$SUBTOTAL_ZFI184[$ianio] + $ZFI184[$ianio][$imes];
		$SUBTOTAL_ZFI1010[$ianio]=$SUBTOTAL_ZFI1010[$ianio] + $ZFI1010[$ianio][$imes];
		$SUBTOTAL_ZFI1132[$ianio]=$SUBTOTAL_ZFI1132[$ianio] + $ZFI1132[$ianio][$imes];
		$SUBTOTAL_ZFI2002[$ianio]=$SUBTOTAL_ZFI2002[$ianio] + $ZFI2002[$ianio][$imes];
		$SUBTOTAL_ZFI2077[$ianio]=$SUBTOTAL_ZFI2077[$ianio] + $ZFI2077[$ianio][$imes];
		$SUBTOTAL_ECM2002[$ianio]=$SUBTOTAL_ECM2002[$ianio] + $ECM2002[$ianio][$imes];
	}
}
for($ianio = $anio;$ianio > $hasta2;$ianio--){
	$TOTAL_LOCAL2[$ianio] = 0;
	$TOTAL_LOCAL8[$ianio] = 0;
	$TOTAL_ZFI6115[$ianio] = 0;
	$TOTAL_ZFI6130[$ianio] = 0;
	$SUBTOTAL_LOCAL2[$ianio] = 0;
	$SUBTOTAL_LOCAL8[$ianio] = 0;
	$SUBTOTAL_ZFI6115[$ianio] = 0;
	$SUBTOTAL_ZFI6130[$ianio] = 0;
	for($imes=1;$imes<13;$imes++){
		$TOTAL_LOCAL2[$ianio]=$TOTAL_LOCAL2[$ianio] + $LOCAL2[$ianio][$imes];
		$TOTAL_LOCAL8[$ianio]=$TOTAL_LOCAL8[$ianio] + $LOCAL8[$ianio][$imes];
		$TOTAL_ZFI6115[$ianio]=$TOTAL_ZFI6115[$ianio] + $ZFI6115[$ianio][$imes];
		$TOTAL_ZFI6130[$ianio]=$TOTAL_ZFI6130[$ianio] + $ZFI6130[$ianio][$imes];
	}
	for($imes=1;$imes<=$mes;$imes++){
		$SUBTOTAL_LOCAL2[$ianio]=$SUBTOTAL_LOCAL2[$ianio] + $LOCAL2[$ianio][$imes];
		$SUBTOTAL_LOCAL8[$ianio]=$SUBTOTAL_LOCAL8[$ianio] + $LOCAL8[$ianio][$imes];
		$SUBTOTAL_ZFI6115[$ianio]=$SUBTOTAL_ZFI6115[$ianio] + $ZFI6115[$ianio][$imes];
		$SUBTOTAL_ZFI6130[$ianio]=$SUBTOTAL_ZFI6130[$ianio] + $ZFI6130[$ianio][$imes];
	}
}
for($imes = 1; $imes < 13; $imes++){
	$TOTAL[$anio-4] = $TOTAL[$anio-4] + $ECM2002[$anio-4][$imes]+$ZFI184[$anio-4][$imes]+$ZFI1010[$anio-4][$imes]+$ZFI1132[$anio-4][$imes]+$ZFI2002[$anio-4][$imes]+$ZFI2077[$anio-4][$imes];
	$TOTAL[$anio-3] = $TOTAL[$anio-3] + $ECM2002[$anio-3][$imes]+$ZFI184[$anio-3][$imes]+$ZFI1010[$anio-3][$imes]+$ZFI1132[$anio-3][$imes]+$ZFI2002[$anio-3][$imes]+$ZFI2077[$anio-3][$imes];
	$TOTAL[$anio-2] = $TOTAL[$anio-2] + $ECM2002[$anio-2][$imes]+$ZFI184[$anio-2][$imes]+$ZFI1010[$anio-2][$imes]+$ZFI1132[$anio-2][$imes]+$ZFI2002[$anio-2][$imes]+$ZFI2077[$anio-2][$imes];
	$TOTAL[$anio-1] = $TOTAL[$anio-1] + $ECM2002[$anio-1][$imes]+$ZFI184[$anio-1][$imes]+$ZFI1010[$anio-1][$imes]+$ZFI1132[$anio-1][$imes]+$ZFI2002[$anio-1][$imes]+$ZFI2077[$anio-1][$imes];
	$TOTAL[$anio] = $TOTAL[$anio] + $ECM2002[$anio][$imes]+$ZFI184[$anio][$imes]+$ZFI1010[$anio][$imes]+$ZFI1132[$anio][$imes]+$ZFI2002[$anio][$imes]+$ZFI2077[$anio][$imes];
}
for($imes = 1; $imes <= $mes; $imes++){
	$SUBTOTAL[$anio-4] = $SUBTOTAL[$anio-4] + $ECM2002[$anio-4][$imes]+$ZFI184[$anio-4][$imes]+$ZFI1010[$anio-4][$imes]+$ZFI1132[$anio-4][$imes]+$ZFI2002[$anio-4][$imes]+$ZFI2077[$anio-4][$imes];
	$SUBTOTAL[$anio-3] = $SUBTOTAL[$anio-3] + $ECM2002[$anio-3][$imes]+$ZFI184[$anio-3][$imes]+$ZFI1010[$anio-3][$imes]+$ZFI1132[$anio-3][$imes]+$ZFI2002[$anio-3][$imes]+$ZFI2077[$anio-3][$imes];
	$SUBTOTAL[$anio-2] = $SUBTOTAL[$anio-2] + $ECM2002[$anio-2][$imes]+$ZFI184[$anio-2][$imes]+$ZFI1010[$anio-2][$imes]+$ZFI1132[$anio-2][$imes]+$ZFI2002[$anio-2][$imes]+$ZFI2077[$anio-2][$imes];
	$SUBTOTAL[$anio-1] = $SUBTOTAL[$anio-1] + $ECM2002[$anio-1][$imes]+$ZFI184[$anio-1][$imes]+$ZFI1010[$anio-1][$imes]+$ZFI1132[$anio-1][$imes]+$ZFI2002[$anio-1][$imes]+$ZFI2077[$anio-1][$imes];
	$SUBTOTAL[$anio]   = $SUBTOTAL[$anio]   + $ECM2002[$anio][$imes]  +$ZFI184[$anio][$imes]  +$ZFI1010[$anio][$imes]  +$ZFI1132[$anio][$imes]  +$ZFI2002[$anio][$imes]  +$ZFI2077[$anio][$imes];
}
?>
<div id="dialogDescarga" title="Ventas Historicas por Marca">
		<!-- <img src="images/export_excel.png" id="descargarExcel" style="display: block; margin-left: auto; margin-right: auto; cursor:pointer;"/>
		<p style="text-align:center;">Click en la imagen <br>para descargar</p> -->

    <!-- <img src="images/export_excel.png" id="descargarExcel" style="display: block; margin-left: auto; margin-right: auto; cursor:pointer;"/>
		<p style="text-align:center;">Click en la imagen <br>para descargar</p> -->

		<?php // pregunta si ha ingresado una fecha para que se muestre el imagen link de generar Excel
		
		// if($finicio2){
		
		echo'<form action="clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion"> 
			<center><img src="images/export_excel.png"  class="botonExcel"  /> </center>
			<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /> 
			<p style="text-align:center;">Click en la imagen <br>para descargar</p> -->
			</form> ';
		
		
		?>

</div>
<table id="ssptable2" class="lista" style="" > 
  <tr>
  	<td></td>
    <td colspan="15" align="center" width="608" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; background-color:#DCE6F1;">INFORME: COMPARATIVO DE VENTAS MENSUALES EN PESOS * MODULOS IQUIQUE *</td>
  </tr>
  <tr>
  	<td></td>
    <td style="border-left: 2px solid #689DED; background-color:#DCE6F1;"></td>
    <td align="right" style="background-color:#DCE6F1;"><?php echo date('d/m/Y'); ?></td>
    <td style="background-color:#DCE6F1;"></td>
    <td style="background-color:#DCE6F1;"></td>
    <td style="background-color:#DCE6F1;"></td>
    <td style="background-color:#DCE6F1;" align="right">NOTA :</td>
    <td colspan="8" style="background-color:#DCE6F1;">SE   UTILIZA DOLAR OBSERVADO DIARIO Y NO CONTEMPLA IVA</td>
    <td style="border-right: 2px solid #689DED; background-color:#DCE6F1;"></td>
  </tr>
  <tr>
	<td></td>
    <td style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"></td>
    <td style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;"></td>
    <td style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;"></td>
    <td style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;"></td>
    <td style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;"></td>
    <td style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;"></td>
    <td style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;"></td>
    <td style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;"></td>
    <td style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;"></td>
    <td style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;"></td>
    <td style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;"></td>
    <td style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;"></td>
    <td style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;"></td>
    <td style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;"></td>
    <td style="border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"></td>
  </tr>
  <tr>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" colspan="5" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">E-COMMERCE</td>
    <td align="center" colspan="5" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">MODULO 184</td>
    <td align="center" colspan="5" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; background-color:#DCE6F1;">MODULO 1010</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-4; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-3; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-2; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-1; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y'); ?></td>
    <td align="center" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-4; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-3; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-2; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-1; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y'); ?></td>
   	<td align="center" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-4; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-3; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-2; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-1; ?></td>
    <td align="center" style="border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y'); ?></td>
  </tr>
  <tr>
    <td style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">ENERO</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED; width:100px;"><?php echo number_format($ECM2002[$anio-4][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED; width:100px;"><?php echo number_format($ECM2002[$anio-3][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED; width:100px;"><?php echo number_format($ECM2002[$anio-2][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED; width:100px;"><?php echo number_format($ECM2002[$anio-1][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED; width:100px;"><?php echo number_format($ECM2002[$anio][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED; width:100px;"><?php echo number_format($ZFI184[$anio-4][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED; width:100px;"><?php echo number_format($ZFI184[$anio-3][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED; width:100px;"><?php echo number_format($ZFI184[$anio-2][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED; width:100px;"><?php echo number_format($ZFI184[$anio-1][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED; width:100px;"><?php echo number_format($ZFI184[$anio][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED; width:100px;"><?php echo number_format($ZFI1010[$anio-4][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED; width:100px;"><?php echo number_format($ZFI1010[$anio-3][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED; width:100px;"><?php echo number_format($ZFI1010[$anio-2][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED; width:100px;"><?php echo number_format($ZFI1010[$anio-1][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED; width:100px;"><?php echo number_format($ZFI1010[$anio][1], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">FEBRERO</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-4][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-3][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-2][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-1][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-4][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-3][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-2][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-1][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio][2], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">MARZO</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-4][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-3][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-2][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-1][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-4][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-3][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-2][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-1][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio][3], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">ABRIL</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-4][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-3][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-2][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-1][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-4][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-3][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-2][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-1][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio][4], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">MAYO</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-4][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-3][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-2][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-1][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-4][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-3][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-2][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-1][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio][5], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">JUNIO</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-4][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-3][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-2][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-1][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-4][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-3][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-2][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-1][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio][6], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">JULIO</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-4][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-3][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-2][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-1][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-4][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-3][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-2][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-1][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio][7], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">AGOSTO</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-4][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-3][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-2][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-1][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-4][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-3][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-2][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-1][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio][8], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">SEPTIEMBRE</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-4][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-3][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-2][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-1][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-4][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-3][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-2][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-1][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio][9], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">OCTUBRE</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-4][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-3][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-2][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-1][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-4][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-3][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-2][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-1][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio][10], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">NOVIEMBRE</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-4][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-3][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-2][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-1][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-4][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-3][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-2][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-1][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio][11], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">DICIEMBRE</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-4][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-3][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-2][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio-1][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI184[$anio][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-4][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-3][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-2][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio-1][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1010[$anio][12], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">SUB TOTAL</td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ECM2002[$anio-4],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ECM2002[$anio-3],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ECM2002[$anio-2],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ECM2002[$anio-1],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ECM2002[$anio],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI184[$anio-4],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI184[$anio-3],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI184[$anio-2],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI184[$anio-1],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI184[$anio],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI1010[$anio-4],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI1010[$anio-3],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI1010[$anio-2],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI1010[$anio-1],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI1010[$anio],0,',','.'); ?></td>
  </tr>
  <tr>
    <td colspan="2">SUB CRECIMIENTO ANUAL</td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ECM2002[$anio-2]-$SUBTOTAL_ECM2002[$anio-3])/$SUBTOTAL_ECM2002[$anio-3])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ECM2002[$anio-1]-$SUBTOTAL_ECM2002[$anio-2])/$SUBTOTAL_ECM2002[$anio-2])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php  echo number_format(0,0,',','.')."%";?></td>
    <td></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI184[$anio-3]-$SUBTOTAL_ZFI184[$anio-4])/$SUBTOTAL_ZFI184[$anio-4])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI184[$anio-2]-$SUBTOTAL_ZFI184[$anio-3])/$SUBTOTAL_ZFI184[$anio-3])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI184[$anio-1]-$SUBTOTAL_ZFI184[$anio-2])/$SUBTOTAL_ZFI184[$anio-2])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI184[$anio]-$SUBTOTAL_ZFI184[$anio-1])/$SUBTOTAL_ZFI184[$anio-1])*100,0,',','.')."%"; ?></td>
    <td></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI1010[$anio-3]-$SUBTOTAL_ZFI1010[$anio-4])/$SUBTOTAL_ZFI1010[$anio-4])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI1010[$anio-2]-$SUBTOTAL_ZFI1010[$anio-3])/$SUBTOTAL_ZFI1010[$anio-3])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI1010[$anio-1]-$SUBTOTAL_ZFI1010[$anio-2])/$SUBTOTAL_ZFI1010[$anio-2])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI1010[$anio]-$SUBTOTAL_ZFI1010[$anio-1])/$SUBTOTAL_ZFI1010[$anio-1])*100,0,',','.')."%"; ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-top: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">TOTAL</td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ECM2002[$anio-4],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ECM2002[$anio-3],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ECM2002[$anio-2],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ECM2002[$anio-1],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ECM2002[$anio],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI184[$anio-4],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI184[$anio-3],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI184[$anio-2],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI184[$anio-1],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI184[$anio],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI1010[$anio-4],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI1010[$anio-3],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI1010[$anio-2],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI1010[$anio-1],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI1010[$anio],0,',','.'); ?></td>
  </tr>
  <tr>
    <td colspan="2">CRECIMIENTO ANUAL</td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ECM2002[$anio-3]-$TOTAL_ECM2002[$anio-4])/$TOTAL_ECM2002[$anio-4])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ECM2002[$anio-2]-$TOTAL_ECM2002[$anio-3])/$TOTAL_ECM2002[$anio-3])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ECM2002[$anio-1]-$TOTAL_ECM2002[$anio-2])/$TOTAL_ECM2002[$anio-2])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format(0,0,',','.')."%"; ?></td>
    <td></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI184[$anio-3]-$TOTAL_ZFI184[$anio-4])/$TOTAL_ZFI184[$anio-4])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI184[$anio-2]-$TOTAL_ZFI184[$anio-3])/$TOTAL_ZFI184[$anio-3])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI184[$anio-1]-$TOTAL_ZFI184[$anio-2])/$TOTAL_ZFI184[$anio-2])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI184[$anio]-$TOTAL_ZFI184[$anio-1])/$TOTAL_ZFI184[$anio-1])*100,0,',','.')."%"; ?></td>
    <td></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI1010[$anio-3]-$TOTAL_ZFI1010[$anio-4])/$TOTAL_ZFI1010[$anio-4])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI1010[$anio-2]-$TOTAL_ZFI1010[$anio-3])/$TOTAL_ZFI1010[$anio-3])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI1010[$anio-1]-$TOTAL_ZFI1010[$anio-2])/$TOTAL_ZFI1010[$anio-2])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI1010[$anio]-$TOTAL_ZFI1010[$anio-1])/$TOTAL_ZFI1010[$anio-1])*100,0,',','.')."%"; ?></td>
  </tr>
  <tr>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" colspan="5" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">MODULO 1132</td>
    <td align="center" colspan="5" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">MODULO 2002</td>
    <td align="center" colspan="5" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; background-color:#DCE6F1;">MODULO 2077</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-4; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-3; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-2; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-1; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y'); ?></td>
    <td align="center" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-4; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-3; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-2; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-1; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y'); ?></td>
   	<td align="center" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-4; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-3; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-2; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-1; ?></td>
    <td align="center" style="border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y'); ?></td>
  </tr>
  <tr>
    <td style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">ENERO</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-4][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-3][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-2][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-1][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-4][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-3][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-2][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-1][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-4][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-3][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-2][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-1][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio][1], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">FEBRERO</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-4][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-3][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-2][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-1][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-4][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-3][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-2][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-1][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-4][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-3][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-2][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-1][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio][2], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">MARZO</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-4][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-3][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-2][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-1][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-4][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-3][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-2][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-1][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-4][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-3][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-2][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-1][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio][3], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">ABRIL</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-4][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-3][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-2][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-1][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-4][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-3][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-2][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-1][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-4][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-3][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-2][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-1][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio][4], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">MAYO</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-4][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-3][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-2][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-1][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-4][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-3][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-2][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-1][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-4][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-3][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-2][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-1][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio][5], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">JUNIO</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-4][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-3][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-2][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-1][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-4][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-3][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-2][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-1][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-4][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-3][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-2][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-1][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio][6], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">JULIO</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-4][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-3][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-2][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-1][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-4][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-3][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-2][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-1][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-4][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-3][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-2][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-1][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio][7], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">AGOSTO</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-4][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-3][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-2][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-1][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-4][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-3][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-2][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-1][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-4][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-3][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-2][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-1][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio][8], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">SEPTIEMBRE</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-4][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-3][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-2][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-1][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-4][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-3][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-2][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-1][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-4][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-3][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-2][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-1][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio][9], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">OCTUBRE</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-4][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-3][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-2][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-1][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-4][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-3][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-2][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-1][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-4][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-3][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-2][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-1][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio][10], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">NOVIEMBRE</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-4][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-3][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-2][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-1][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-4][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-3][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-2][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-1][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-4][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-3][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-2][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-1][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio][11], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">DICIEMBRE</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-4][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-3][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-2][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio-1][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI1132[$anio][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-4][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-3][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-2][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio-1][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2002[$anio][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-4][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-3][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-2][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio-1][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-right: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI2077[$anio][12], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">SUB TOTAL</td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI1132[$anio-4],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI1132[$anio-3],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI1132[$anio-2],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI1132[$anio-1],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI1132[$anio],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI2002[$anio-4],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI2002[$anio-3],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI2002[$anio-2],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI2002[$anio-1],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI2002[$anio],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI2077[$anio-4],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI2077[$anio-3],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI2077[$anio-2],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI2077[$anio-1],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI2077[$anio],0,',','.'); ?></td>
  </tr>
  <tr>
    <td colspan="2">SUB CRECIMIENTO ANUAL</td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI1132[$anio-3]-$SUBTOTAL_ZFI1132[$anio-4])/$SUBTOTAL_ZFI1132[$anio-4])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI1132[$anio-2]-$SUBTOTAL_ZFI1132[$anio-3])/$SUBTOTAL_ZFI1132[$anio-3])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI1132[$anio-1]-$SUBTOTAL_ZFI1132[$anio-2])/$SUBTOTAL_ZFI1132[$anio-2])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI1132[$anio]-$SUBTOTAL_ZFI1132[$anio-1])/$SUBTOTAL_ZFI1132[$anio-1])*100,0,',','.')."%"; ?></td>
    <td></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI2002[$anio-3]-$SUBTOTAL_ZFI2002[$anio-4])/$SUBTOTAL_ZFI2002[$anio-4])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI2002[$anio-2]-$SUBTOTAL_ZFI2002[$anio-3])/$SUBTOTAL_ZFI2002[$anio-3])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI2002[$anio-1]-$SUBTOTAL_ZFI2002[$anio-2])/$SUBTOTAL_ZFI2002[$anio-2])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI2002[$anio]-$SUBTOTAL_ZFI2002[$anio-1])/$SUBTOTAL_ZFI2002[$anio-1])*100,0,',','.')."%"; ?></td>
    <td></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI2077[$anio-3]-$SUBTOTAL_ZFI2077[$anio-4])/$SUBTOTAL_ZFI2077[$anio-4])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI2077[$anio-2]-$SUBTOTAL_ZFI2077[$anio-3])/$SUBTOTAL_ZFI2077[$anio-3])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI2077[$anio-1]-$SUBTOTAL_ZFI2077[$anio-2])/$SUBTOTAL_ZFI2077[$anio-2])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI2077[$anio]-$SUBTOTAL_ZFI2077[$anio-1])/$SUBTOTAL_ZFI2077[$anio-1])*100,0,',','.')."%"; ?></td>
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-top: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">TOTAL</td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI1132[$anio-4],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI1132[$anio-3],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI1132[$anio-2],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI1132[$anio-1],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI1132[$anio],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI2002[$anio-4],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI2002[$anio-3],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI2002[$anio-2],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI2002[$anio-1],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI2002[$anio],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI2077[$anio-4],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI2077[$anio-3],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI2077[$anio-2],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI2077[$anio-1],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI2077[$anio],0,',','.'); ?></td>
  </tr>
  <tr>
    <td colspan="2">CRECIMIENTO ANUAL</td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI1132[$anio-3]-$TOTAL_ZFI1132[$anio-4])/$TOTAL_ZFI1132[$anio-4])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI1132[$anio-2]-$TOTAL_ZFI1132[$anio-3])/$TOTAL_ZFI1132[$anio-3])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI1132[$anio-1]-$TOTAL_ZFI1132[$anio-2])/$TOTAL_ZFI1132[$anio-2])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI1132[$anio]-$TOTAL_ZFI1132[$anio-1])/$TOTAL_ZFI1132[$anio-1])*100,0,',','.')."%"; ?></td>
    <td></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI2002[$anio-3]-$TOTAL_ZFI2002[$anio-4])/$TOTAL_ZFI2002[$anio-4])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI2002[$anio-2]-$TOTAL_ZFI2002[$anio-3])/$TOTAL_ZFI2002[$anio-3])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI2002[$anio-1]-$TOTAL_ZFI2002[$anio-2])/$TOTAL_ZFI2002[$anio-2])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI2002[$anio]-$TOTAL_ZFI2002[$anio-1])/$TOTAL_ZFI2002[$anio-1])*100,0,',','.')."%"; ?></td>
    <td></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI2077[$anio-3]-$TOTAL_ZFI2077[$anio-4])/$TOTAL_ZFI2077[$anio-4])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI2077[$anio-2]-$TOTAL_ZFI2077[$anio-3])/$TOTAL_ZFI2077[$anio-3])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI2077[$anio-1]-$TOTAL_ZFI2077[$anio-2])/$TOTAL_ZFI2077[$anio-2])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI2077[$anio]-$TOTAL_ZFI2077[$anio-1])/$TOTAL_ZFI2077[$anio-1])*100,0,',','.')."%"; ?></td>
  </tr>
  <!--VENTA TOTAL POR AÑOS PERFUMES ZOFRI -->
  
  <tr>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
    <td height="30"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" colspan="5" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">VENTAS TOTAL POR AÑOS PERFUMES ZOFRI</td>
    <td align="center" colspan="2" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">MODULO 6115</td>
    <td align="center" colspan="2" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1;">MODULO 6130</td>
    <td align="center" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; background-color:#DCE6F1; border-right: 2px solid #689DED;">TOT-ZOFRI</td>

  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-4; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-3; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-2; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-1; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y'); ?></td>
    <td align="center" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-1; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y'); ?></td>
    <td align="center" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y')-1; ?></td>
    <td align="center" style="border-bottom: 2px solid #689DED; background-color:#DCE6F1;">VTA, <?php echo date('y'); ?></td>
    <td align="center" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1; border-right: 2px solid #689DED;">VTA, <?php echo date('y'); ?></td>
 
  </tr>
  <tr>
    <td style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">ENERO</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][1]+$ZFI184[$anio-4][1]+$ZFI1010[$anio-4][1]+$ZFI1132[$anio-4][1]+$ZFI2002[$anio-4][1]+$ZFI2077[$anio-4][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][1]+$ZFI184[$anio-3][1]+$ZFI1010[$anio-3][1]+$ZFI1132[$anio-3][1]+$ZFI2002[$anio-3][1]+$ZFI2077[$anio-3][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][1]+$ZFI184[$anio-2][1]+$ZFI1010[$anio-2][1]+$ZFI1132[$anio-2][1]+$ZFI2002[$anio-2][1]+$ZFI2077[$anio-2][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][1]+$ZFI184[$anio-1][1]+$ZFI1010[$anio-1][1]+$ZFI1132[$anio-1][1]+$ZFI2002[$anio-1][1]+$ZFI2077[$anio-1][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][1]+$ZFI184[$anio][1]+$ZFI1010[$anio][1]+$ZFI1132[$anio][1]+$ZFI2002[$anio][1]+$ZFI2077[$anio][1], 0, ',', '.'); ?></td>
    <!-- -->
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio-1][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio-1][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio][1], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED; border-right: 2px solid #689DED;"><?php echo number_format($ZFI6115[$anio][1]+$ZFI6130[$anio][1], 0, ',', '.'); ?></td>

  </tr>
  
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">FEBRERO</td>
   <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][2]+$ZFI184[$anio-4][2]+$ZFI1010[$anio-4][2]+$ZFI1132[$anio-4][2]+$ZFI2002[$anio-4][2]+$ZFI2077[$anio-4][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][2]+$ZFI184[$anio-3][2]+$ZFI1010[$anio-3][2]+$ZFI1132[$anio-3][2]+$ZFI2002[$anio-3][2]+$ZFI2077[$anio-3][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][2]+$ZFI184[$anio-2][2]+$ZFI1010[$anio-2][2]+$ZFI1132[$anio-2][2]+$ZFI2002[$anio-2][2]+$ZFI2077[$anio-2][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][2]+$ZFI184[$anio-1][2]+$ZFI1010[$anio-1][2]+$ZFI1132[$anio-1][2]+$ZFI2002[$anio-1][2]+$ZFI2077[$anio-1][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][2]+$ZFI184[$anio][2]+$ZFI1010[$anio][2]+$ZFI1132[$anio][2]+$ZFI2002[$anio][2]+$ZFI2077[$anio][2], 0, ',', '.'); ?></td>
    <!-- -->
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio-1][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio-1][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio][2], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED; border-right: 2px solid #689DED;"><?php echo number_format($ZFI6115[$anio][2]+$ZFI6130[$anio][2], 0, ',', '.'); ?></td>

  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">MARZO</td>
     <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][3]+$ZFI184[$anio-4][3]+$ZFI1010[$anio-4][3]+$ZFI1132[$anio-4][3]+$ZFI2002[$anio-4][3]+$ZFI2077[$anio-4][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][3]+$ZFI184[$anio-3][3]+$ZFI1010[$anio-3][3]+$ZFI1132[$anio-3][3]+$ZFI2002[$anio-3][3]+$ZFI2077[$anio-3][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][3]+$ZFI184[$anio-2][3]+$ZFI1010[$anio-2][3]+$ZFI1132[$anio-2][3]+$ZFI2002[$anio-2][3]+$ZFI2077[$anio-2][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][3]+$ZFI184[$anio-1][3]+$ZFI1010[$anio-1][3]+$ZFI1132[$anio-1][3]+$ZFI2002[$anio-1][3]+$ZFI2077[$anio-1][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][3]+$ZFI184[$anio][3]+$ZFI1010[$anio][3]+$ZFI1132[$anio][3]+$ZFI2002[$anio][3]+$ZFI2077[$anio][3], 0, ',', '.'); ?></td>
    <!-- -->
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio-1][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio-1][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio][3], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED; border-right: 2px solid #689DED;"><?php echo number_format($ZFI6115[$anio][3]+$ZFI6130[$anio][3], 0, ',', '.'); ?></td>
  
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">ABRIL</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][4]+$ZFI184[$anio-4][4]+$ZFI1010[$anio-4][4]+$ZFI1132[$anio-4][4]+$ZFI2002[$anio-4][4]+$ZFI2077[$anio-4][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][4]+$ZFI184[$anio-3][4]+$ZFI1010[$anio-3][4]+$ZFI1132[$anio-3][4]+$ZFI2002[$anio-3][4]+$ZFI2077[$anio-3][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][4]+$ZFI184[$anio-2][4]+$ZFI1010[$anio-2][4]+$ZFI1132[$anio-2][4]+$ZFI2002[$anio-2][4]+$ZFI2077[$anio-2][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][4]+$ZFI184[$anio-1][4]+$ZFI1010[$anio-1][4]+$ZFI1132[$anio-1][4]+$ZFI2002[$anio-1][4]+$ZFI2077[$anio-1][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][4]+$ZFI184[$anio][4]+$ZFI1010[$anio][4]+$ZFI1132[$anio][4]+$ZFI2002[$anio][4]+$ZFI2077[$anio][4], 0, ',', '.'); ?></td>
    <!-- -->
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio-1][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio-1][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio][4], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED; border-right: 2px solid #689DED;"><?php echo number_format($ZFI6115[$anio][4]+$ZFI6130[$anio][4], 0, ',', '.'); ?></td>
  
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">MAYO</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][5]+$ZFI184[$anio-4][5]+$ZFI1010[$anio-4][5]+$ZFI1132[$anio-4][5]+$ZFI2002[$anio-4][5]+$ZFI2077[$anio-4][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][5]+$ZFI184[$anio-3][5]+$ZFI1010[$anio-3][5]+$ZFI1132[$anio-3][5]+$ZFI2002[$anio-3][5]+$ZFI2077[$anio-3][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][5]+$ZFI184[$anio-2][5]+$ZFI1010[$anio-2][5]+$ZFI1132[$anio-2][5]+$ZFI2002[$anio-2][5]+$ZFI2077[$anio-2][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][5]+$ZFI184[$anio-1][5]+$ZFI1010[$anio-1][5]+$ZFI1132[$anio-1][5]+$ZFI2002[$anio-1][5]+$ZFI2077[$anio-1][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][5]+$ZFI184[$anio][5]+$ZFI1010[$anio][5]+$ZFI1132[$anio][5]+$ZFI2002[$anio][5]+$ZFI2077[$anio][5], 0, ',', '.'); ?></td>
    <!-- -->
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio-1][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio-1][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio][5], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED; border-right: 2px solid #689DED;"><?php echo number_format($ZFI6115[$anio][5]+$ZFI6130[$anio][5], 0, ',', '.'); ?></td>

  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">JUNIO</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][6]+$ZFI184[$anio-4][6]+$ZFI1010[$anio-4][6]+$ZFI1132[$anio-4][6]+$ZFI2002[$anio-4][6]+$ZFI2077[$anio-4][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][6]+$ZFI184[$anio-3][6]+$ZFI1010[$anio-3][6]+$ZFI1132[$anio-3][6]+$ZFI2002[$anio-3][6]+$ZFI2077[$anio-3][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][6]+$ZFI184[$anio-2][6]+$ZFI1010[$anio-2][6]+$ZFI1132[$anio-2][6]+$ZFI2002[$anio-2][6]+$ZFI2077[$anio-2][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][6]+$ZFI184[$anio-1][6]+$ZFI1010[$anio-1][6]+$ZFI1132[$anio-1][6]+$ZFI2002[$anio-1][6]+$ZFI2077[$anio-1][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][6]+$ZFI184[$anio][6]+$ZFI1010[$anio][6]+$ZFI1132[$anio][6]+$ZFI2002[$anio][6]+$ZFI2077[$anio][6], 0, ',', '.'); ?></td>
    <!-- -->
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio-1][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio-1][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio][6], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED; border-right: 2px solid #689DED;"><?php echo number_format($ZFI6115[$anio][6]+$ZFI6130[$anio][6], 0, ',', '.'); ?></td>
 
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">JULIO</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][7]+$ZFI184[$anio-4][7]+$ZFI1010[$anio-4][7]+$ZFI1132[$anio-4][7]+$ZFI2002[$anio-4][7]+$ZFI2077[$anio-4][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][7]+$ZFI184[$anio-3][7]+$ZFI1010[$anio-3][7]+$ZFI1132[$anio-3][7]+$ZFI2002[$anio-3][7]+$ZFI2077[$anio-3][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][7]+$ZFI184[$anio-2][7]+$ZFI1010[$anio-2][7]+$ZFI1132[$anio-2][7]+$ZFI2002[$anio-2][7]+$ZFI2077[$anio-2][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][7]+$ZFI184[$anio-1][7]+$ZFI1010[$anio-1][7]+$ZFI1132[$anio-1][7]+$ZFI2002[$anio-1][7]+$ZFI2077[$anio-1][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][7]+$ZFI184[$anio][7]+$ZFI1010[$anio][7]+$ZFI1132[$anio][7]+$ZFI2002[$anio][7]+$ZFI2077[$anio][7], 0, ',', '.'); ?></td>
    <!-- -->
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio-1][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio-1][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio][7], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED; border-right: 2px solid #689DED;"><?php echo number_format($ZFI6115[$anio][7]+$ZFI6130[$anio][7], 0, ',', '.'); ?></td>

  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">AGOSTO</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][8]+$ZFI184[$anio-4][8]+$ZFI1010[$anio-4][8]+$ZFI1132[$anio-4][8]+$ZFI2002[$anio-4][8]+$ZFI2077[$anio-4][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][8]+$ZFI184[$anio-3][8]+$ZFI1010[$anio-3][8]+$ZFI1132[$anio-3][8]+$ZFI2002[$anio-3][8]+$ZFI2077[$anio-3][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][8]+$ZFI184[$anio-2][8]+$ZFI1010[$anio-2][8]+$ZFI1132[$anio-2][8]+$ZFI2002[$anio-2][8]+$ZFI2077[$anio-2][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][8]+$ZFI184[$anio-1][8]+$ZFI1010[$anio-1][8]+$ZFI1132[$anio-1][8]+$ZFI2002[$anio-1][8]+$ZFI2077[$anio-1][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][8]+$ZFI184[$anio][8]+$ZFI1010[$anio][8]+$ZFI1132[$anio][8]+$ZFI2002[$anio][8]+$ZFI2077[$anio][8], 0, ',', '.'); ?></td>
    <!-- -->
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio-1][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio-1][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio][8], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED; border-right: 2px solid #689DED;"><?php echo number_format($ZFI6115[$anio][8]+$ZFI6130[$anio][8], 0, ',', '.'); ?></td>

  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">SEPTIEMBRE</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][9]+$ZFI184[$anio-4][9]+$ZFI1010[$anio-4][9]+$ZFI1132[$anio-4][9]+$ZFI2002[$anio-4][9]+$ZFI2077[$anio-4][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][9]+$ZFI184[$anio-3][9]+$ZFI1010[$anio-3][9]+$ZFI1132[$anio-3][9]+$ZFI2002[$anio-3][9]+$ZFI2077[$anio-3][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][9]+$ZFI184[$anio-2][9]+$ZFI1010[$anio-2][9]+$ZFI1132[$anio-2][9]+$ZFI2002[$anio-2][9]+$ZFI2077[$anio-2][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][9]+$ZFI184[$anio-1][9]+$ZFI1010[$anio-1][9]+$ZFI1132[$anio-1][9]+$ZFI2002[$anio-1][9]+$ZFI2077[$anio-1][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][9]+$ZFI184[$anio][9]+$ZFI1010[$anio][9]+$ZFI1132[$anio][9]+$ZFI2002[$anio][9]+$ZFI2077[$anio][9], 0, ',', '.'); ?></td>
    <!-- -->
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio-1][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio-1][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio][9], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED; border-right: 2px solid #689DED;"><?php echo number_format($ZFI6115[$anio][9]+$ZFI6130[$anio][9], 0, ',', '.'); ?></td>

  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">OCTUBRE</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][10]+$ZFI184[$anio-4][10]+$ZFI1010[$anio-4][10]+$ZFI1132[$anio-4][10]+$ZFI2002[$anio-4][10]+$ZFI2077[$anio-4][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][10]+$ZFI184[$anio-3][10]+$ZFI1010[$anio-3][10]+$ZFI1132[$anio-3][10]+$ZFI2002[$anio-3][10]+$ZFI2077[$anio-3][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][10]+$ZFI184[$anio-2][10]+$ZFI1010[$anio-2][10]+$ZFI1132[$anio-2][10]+$ZFI2002[$anio-2][10]+$ZFI2077[$anio-2][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][10]+$ZFI184[$anio-1][10]+$ZFI1010[$anio-1][10]+$ZFI1132[$anio-1][10]+$ZFI2002[$anio-1][10]+$ZFI2077[$anio-1][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][10]+$ZFI184[$anio][10]+$ZFI1010[$anio][10]+$ZFI1132[$anio][10]+$ZFI2002[$anio][10]+$ZFI2077[$anio][10], 0, ',', '.'); ?></td>
    <!-- -->
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio-1][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio-1][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio][10], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED; border-right: 2px solid #689DED;"><?php echo number_format($ZFI6115[$anio][10]+$ZFI6130[$anio][10], 0, ',', '.'); ?></td>

  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">NOVIEMBRE</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][11]+$ZFI184[$anio-4][11]+$ZFI1010[$anio-4][11]+$ZFI1132[$anio-4][11]+$ZFI2002[$anio-4][11]+$ZFI2077[$anio-4][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][11]+$ZFI184[$anio-3][11]+$ZFI1010[$anio-3][11]+$ZFI1132[$anio-3][11]+$ZFI2002[$anio-3][11]+$ZFI2077[$anio-3][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][11]+$ZFI184[$anio-2][11]+$ZFI1010[$anio-2][11]+$ZFI1132[$anio-2][11]+$ZFI2002[$anio-2][11]+$ZFI2077[$anio-2][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][11]+$ZFI184[$anio-1][11]+$ZFI1010[$anio-1][11]+$ZFI1132[$anio-1][11]+$ZFI2002[$anio-1][11]+$ZFI2077[$anio-1][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][11]+$ZFI184[$anio][11]+$ZFI1010[$anio][11]+$ZFI1132[$anio][11]+$ZFI2002[$anio][11]+$ZFI2077[$anio][11], 0, ',', '.'); ?></td>
    <!-- -->
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio-1][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio-1][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio][11], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED; border-right: 2px solid #689DED;"><?php echo number_format($ZFI6115[$anio][11]+$ZFI6130[$anio][11], 0, ',', '.'); ?></td>

  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">DICIEMBRE</td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-4][12]+$ZFI184[$anio-4][12]+$ZFI1010[$anio-4][12]+$ZFI1132[$anio-4][12]+$ZFI2002[$anio-4][12]+$ZFI2077[$anio-4][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-3][12]+$ZFI184[$anio-3][12]+$ZFI1010[$anio-3][12]+$ZFI1132[$anio-3][12]+$ZFI2002[$anio-3][12]+$ZFI2077[$anio-3][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-2][12]+$ZFI184[$anio-2][12]+$ZFI1010[$anio-2][12]+$ZFI1132[$anio-2][12]+$ZFI2002[$anio-2][12]+$ZFI2077[$anio-2][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio-1][12]+$ZFI184[$anio-1][12]+$ZFI1010[$anio-1][12]+$ZFI1132[$anio-1][12]+$ZFI2002[$anio-1][12]+$ZFI2077[$anio-1][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ECM2002[$anio][12]+$ZFI184[$anio][12]+$ZFI1010[$anio][12]+$ZFI1132[$anio][12]+$ZFI2002[$anio][12]+$ZFI2077[$anio][12], 0, ',', '.'); ?></td>
    <!-- -->
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio-1][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6115[$anio][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio-1][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 1px dotted #689DED; border-bottom: 1px dotted #689DED;"><?php echo number_format($ZFI6130[$anio][12], 0, ',', '.'); ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 1px dotted #689DED; border-right: 2px solid #689DED;"><?php echo number_format($ZFI6115[$anio][12]+$ZFI6130[$anio][12], 0, ',', '.'); ?></td>
 
  </tr>
  <tr>
    <td style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">SUB TOTAL </td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL[$anio-4],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL[$anio-3],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL[$anio-2],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL[$anio-1],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL[$anio],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI6115[$anio-1],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI6115[$anio],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI6130[$anio-1],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($SUBTOTAL_ZFI6130[$anio],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1; border-right: 2px solid #689DED;"><?php echo number_format($SUBTOTAL_ZFI6130[$anio]+$TOTAL_ZFI6115[$anio],0,',','.'); ?></td>
  
  </tr>
  <tr>
    <td colspan="2">SUB CRECIMIENTO ANUAL</td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL[$anio-3]-$SUBTOTAL[$anio-4])/$SUBTOTAL[$anio-4])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL[$anio-2]-$SUBTOTAL[$anio-3])/$SUBTOTAL[$anio-3])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL[$anio-1]-$SUBTOTAL[$anio-2])/$SUBTOTAL[$anio-2])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL[$anio]-$SUBTOTAL[$anio-1])/$SUBTOTAL[$anio-1])*100,0,',','.')."%"; ?></td>
    <td></td>
    <td align="right" style="border-left: 2px solid #689DED;  border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI6115[$anio]-$SUBTOTAL_ZFI6115[$anio-1])/$SUBTOTAL_ZFI6115[$anio-1])*100,0,',','.')."%"; ?></td>
    <td></td>
    <td align="right" style="border-left: 2px solid #689DED;  border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($SUBTOTAL_ZFI6130[$anio]-$SUBTOTAL_ZFI6130[$anio-1])/$SUBTOTAL_ZFI6130[$anio-1])*100,0,',','.')."%"; ?></td>
    <td></td>
    
  </tr>
  
  <tr>
    <td style="border-left: 2px solid #689DED; border-top: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;">TOTAL</td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL[$anio-4],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL[$anio-3],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL[$anio-2],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL[$anio-1],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL[$anio],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI6115[$anio-1],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI6115[$anio],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI6130[$anio-1],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format($TOTAL_ZFI6130[$anio],0,',','.'); ?></td>
    <td align="right" style="border-top: 2px solid #689DED; border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1; border-right: 2px solid #689DED;"><?php echo number_format($TOTAL_ZFI6130[$anio]+$TOTAL_ZFI6115[$anio],0,',','.'); ?></td>

  </tr>
  <tr>
    <td colspan="2">CRECIMIENTO ANUAL</td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL[$anio-3]-$TOTAL[$anio-4])/$TOTAL[$anio-4])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL[$anio-2]-$TOTAL[$anio-3])/$TOTAL[$anio-3])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL[$anio-1]-$TOTAL[$anio-2])/$TOTAL[$anio-2])*100,0,',','.')."%"; ?></td>
    <td align="right" style="border-left: 2px solid #689DED; border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL[$anio]-$TOTAL[$anio-1])/$TOTAL[$anio-1])*100,0,',','.')."%"; ?></td>
    <td></td>
    <td align="right" style="border-left: 2px solid #689DED;  border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI6115[$anio]-$TOTAL_ZFI6115[$anio-1])/$TOTAL_ZFI6115[$anio-1])*100,0,',','.')."%"; ?></td>
    <td></td>
    <td align="right" style="border-left: 2px solid #689DED;  border-right: 2px solid #689DED; border-bottom: 2px solid #689DED; background-color:#DCE6F1;"><?php echo number_format((($TOTAL_ZFI6130[$anio]-$TOTAL_ZFI6130[$anio-1])/$TOTAL_ZFI6130[$anio-1])*100,0,',','.')."%"; ?></td>
    <td></td>
    <td></td>
 
  </tr> 
</table>