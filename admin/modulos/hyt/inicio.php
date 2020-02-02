<?php 

require_once('modulos/'.$seccion.'/acciones.php');

echo $head;
echo $header;

require_once('modulos/varios/mensajes.php');
require_once('modulos/'.$seccion.'/'.$subseccion.'.php'); 

?>
<?=$jquery?>


<script>
	// Botón formulario
	function checkForm(form)
	{
		form.send.value = "Espere...";
		form.send.disabled = true;
		return true;
	};
	// Ordenar productos
	$(function(){
		$("#sortable").sortable({
			update: function( event, ui ) {
				var PostData = $( "#sortable" ).sortable( "toArray");
				console.log(PostData);
				$.post("modulos/<?=$seccion?>/acciones.php", {list1: PostData}, function(guardar){
				}, "json")
			}
		});
	})
</script>

<?=$scripts?>

<?=$footer?>
