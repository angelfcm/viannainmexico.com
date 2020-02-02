<?
require_once('modulos/'.$seccion.'/acciones.php');

echo $head;
echo $header;

require_once('modulos/varios/mensajes.php');
require_once('modulos/'.$seccion.'/'.$subseccion.'.php'); 

echo $jquery;
?>


<script>

	// Botón formulario
	function checkForm(form)
	{
		form.send.value = "Espere...";
		form.send.disabled = true;
		return true;
	};

	<?=$scripts?>

</script>


<?=$footer?>