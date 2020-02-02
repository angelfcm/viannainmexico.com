<?php 

require_once('modulos/'.$seccion.'/acciones.php');

echo $head;
echo $header;

require_once('modulos/varios/mensajes.php');
require_once('modulos/'.$seccion.'/'.$subseccion.'.php'); 

?>
<?=$jquery?>


<script>
	// Eliminar producto
	function eliminaProd () { 
		var statusConfirm = confirm("Realmente desea eliminar esto?"); 
		if (statusConfirm == true) { 
			window.location = ("index.php?seccion=<?=$seccion?>&borrarPod&id="+id);
		} 
	};

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
				$.post("modulos/<?=$seccion?>/acciones.php", {list1: PostData}, function(guardar){
				}, "json")
			}
		});
	})

	// Ordenar fotos
	$(function(){
		$("#sortable2").sortable({
			update: function( event, ui ) {
				var PostData = $( "#sortable2" ).sortable( "toArray");
				$.post("modulos/<?=$seccion?>/acciones.php", {list2: PostData}, function(guardar){
				}, "json")
			}
		});
	})

	$(document).ready(function() {
		var imagenesArray = [];
		$("#fileuploader").uploadFile({
			url:"../library/upload-file/php/upload.php",
			fileName:"myfile",
			maxFileCount:6,
			showDelete: 'true',
			allowedTypes: "jpeg,jpg,png,gif",
			maxFileSize: 6291456,
			showFileCounter: true,
			showPreview:true,
			returnType:'json',
			onSuccess:function(files,data,xhr){ 
				imagenesArray.push(data);
				window.location = ('index.php?seccion=<?=$seccion?>&subseccion=<?=$subseccion?>&id=<?=$id?>&imagen='+data);
			},
			deleteCallback: function(data,pd)
			{
				$("#img_"+imagenesArray.indexOf(data)).remove();
				imagenesArray.splice(imagenesArray.indexOf(data), 1)
				for(var i=0;i<data.length;i++)
				{
					$.post("removeImg.php",{op:"delete",pathImage:data[i]},
					function(resp, textStatus, jqXHR){});
				}		
				pd.statusbar.hide(); //You choice to hide/not.
			}
		});
	});
</script>

<?=$scripts?>

<?=$footer?>
