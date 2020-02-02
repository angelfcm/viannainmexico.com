<?php 
require_once('modulos/'.$seccion.'/acciones.php');

echo $head;
echo $header;

require_once('modulos/varios/mensajes.php');
require_once('modulos/'.$seccion.'/'.$subseccion.'.php'); 

echo $jquery
?>

<script>
	// Eliminar carpeta
	$(function() {
		$(".eliminauser").click(function() {
			var statusConfirm = confirm("Realmente desea eliminar este usuario?");
			var id=$(this).data('id');
			if (statusConfirm == true) { 
				window.location = ("index.php?seccion=<?=$seccion?>&borrarUser&id="+id);
			} 
		});
	});

	function checkForm(form)
	{
		form.enviar.value = "Espere...";
		form.enviar.disabled = true;
		setTimeout(function(){ 
			form.enviar.value = "Reintentar";
			form.enviar.disabled = false;
		}, 3000);
		return true;
	}
</script>
<?=$scripts?>
<?=$footer?>
