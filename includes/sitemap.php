<?php
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="utf-8"?>
<?xml-stylesheet href="css/general.css"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

$arreglo=array('es','en','ja','ru','pt','it');
foreach ($arreglo as $key) {
	echo '
	<url><loc>http://'.$dominio.'/'.$key.'</loc></url>
	<url><loc>http://'.$dominio.'/'.$key.'/seminarios</loc></url>
	<url><loc>http://'.$dominio.'/'.$key.'/inscripcion</loc></url>
	<url><loc>http://'.$dominio.'/'.$key.'/pagos</loc></url>
	<url><loc>http://'.$dominio.'/'.$key.'/sede</loc></url>
	<url><loc>http://'.$dominio.'/'.$key.'/hyt</loc></url>
	<url><loc>http://'.$dominio.'/'.$key.'/hospedaje</loc></url>
	<url><loc>http://'.$dominio.'/'.$key.'/transporte</loc></url>';
}
echo'
</urlset>';
?>