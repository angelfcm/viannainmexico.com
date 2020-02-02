<?
header('Content-Type: text/csv";" charset=utf-8');

$caracteres_si_validos  = array('','','','','a','A','e','E','i','I','o','O','u','U','n','N','');
$caracteres_no_validos  = array('|','/','®','¿','á','Á','é','É','í','Í','ó','Ó','ú','Ú','ñ','Ñ','"');

$csv = '"ID Estudiante";"Asiento";"Gafet";"Nombre";"Apellido";"Telefono";"Email";"Pais";"Traduccion";"Material";"Pago traduccion";"Metodo traduccion";"PP traduccion";"Pago 1";"Metodo pago 1";"PP pago 1";"Pago 2";"Observaciones"';

require_once('../includes/connection.php'); 
$id=$_GET['id'];
$CONSULTA1 = $CONEXION -> query("SELECT * FROM cursos WHERE id = $id");
$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();

$CONSULTA2 = $CONEXION -> query("SELECT * FROM cursoasientos WHERE curso = $id");
while ($row_CONSULTA2 = $CONSULTA2 -> fetch_assoc()) {
	$uid=$row_CONSULTA2['usuario'];

	$CONSULTA3 = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $uid");
	$row_CONSULTA3 = $CONSULTA3 -> fetch_assoc();
	if ($uid!=0) {
		$pago1=($row_CONSULTA2['estatus']==1)?$row_CONSULTA1['precio']:0;
		
		$coursePayment = $CONEXION->query('SELECT * FROM pp_payments WHERE id = "' . $row_CONSULTA2['payment_id'] . '"')->fetch_assoc();
		$translationPayment = $CONEXION->query('SELECT * FROM pp_payments WHERE id = "' . $row_CONSULTA2['translation_payment_id']. '"')->fetch_assoc();

		$coursePaymentEmail = $coursePayment ? $coursePayment['payer_email'] : '';
		$translationPaymentEmail = $translationPayment ? $translationPayment['payer_email'] : '';

		$csv .= '
"'.$uid.'";"'.html_entity_decode($row_CONSULTA2['asiento']).'";"'.html_entity_decode($row_CONSULTA3['gafet']).'";"'.html_entity_decode($row_CONSULTA3['nombre']).'";"'.html_entity_decode($row_CONSULTA3['apellido']).'";"'.$row_CONSULTA3['telefono'].'";"'.$row_CONSULTA3['email'].'";"'.html_entity_decode($row_CONSULTA3['pais']).'";"'.html_entity_decode($row_CONSULTA2['traductor']).'";"'.html_entity_decode($row_CONSULTA2['material']).'";"'.html_entity_decode($row_CONSULTA2['pagot']).'";"'.html_entity_decode($row_CONSULTA2['translation_payment_option']).'";"'.$translationPaymentEmail.'";"'.$row_CONSULTA2['pago1'].'";"'.$row_CONSULTA2['metodo1'].'";"'.$coursePaymentEmail.'";"'.$row_CONSULTA2['pago2'].'";"'.$row_CONSULTA2['metodo2'].'";"'.$row_CONSULTA2['observaciones'].'"';

	}
}
echo str_replace($caracteres_no_validos,$caracteres_si_validos,$csv);