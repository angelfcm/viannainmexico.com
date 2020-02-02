<?
global $ruta;
global $rutaEstaPagina;
global $CONEXION;

$dominio=$_SERVER["SERVER_NAME"];
$dominio=str_replace('www.', '', $dominio);
$ip=substr($dominio,0,-2);
$raiz='http://'.$dominio;
$urlSufijo=$_SERVER["REQUEST_URI"];
$desarrollo=(strrpos($urlSufijo,'desarrollo'))?1:0;
$slash=(strrpos($urlSufijo,'/'))+1;
$ruta=$raiz.substr($urlSufijo,0,$slash);
$rutaEstaPagina=$raiz.$_SERVER["REQUEST_URI"];
$hoy=date('Y-m-d');
$ahora=date('Y-m-d H:i:s');
$debug=0;

$is_rusian_domain = false;

if ($is_rusian_domain) {
	$hostname = "viannainmexico.com";
	$database = "viannain_site";
	$username = "viannain_efra";
	$password = "TD!C]z3,H_Ts";
}
else {
	$hostname = "localhost";
	$database = "viannain_site";
	$username = "viannain_efra";
	$password = "TD!C]z3,H_Ts";
}

if($dominio=='localhost' or strpos($ip, '192.168.') === 0){
	$database = "viannainmexico";
	$username = "root"; // cambié esto antes de poner el respositorio
	$password = "123123"; // y esto también, solo eso.
	//$debug=1;
}elseif($dominio=='efra.biz'){
	$database = "efra_vianna";
	$username = "efra_efra";
	$password = "9ZWryuks";
}

//echo $dominio.'-'.$hostname;
$CONEXION = mysqli_connect($hostname, $username, $password, $database) or die("Error: " . mysqli_error($CONEXION)); 
