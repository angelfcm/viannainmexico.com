<?=$head?>
<?=$header?>

<?php 
require_once('modulos/varios/mensajes.php');
require_once('modulos/'.$seccion.'/'.$subseccion.'.php'); 
?>

<?=$jquery?>

<script>
	$(document).ready(function() {
		$(".cfg").click(function(){
			cfgid=$(this).attr("data-cfgid");
			titulo=$(this).attr("data-titulo");
			txt=$(this).attr("data-txt");
			url=$(this).attr("data-url");
			$("#cfgid").val(cfgid);
			$("#titulo").val(titulo);
			$("#txt").val(txt);
			$("#url").val(url);
			console.log(cfgid+"-"+titulo);
		});
	});
	
	function eliminaPic () { 
		var statusConfirm = confirm("Realmente desea eliminar esta foto?"); 
		if (statusConfirm == true) 
		{ 
			window.location = ("index.php?seccion=<?=$seccion?>&languaje=<?=$languaje?>&borrar=1&id="+id);
		} 
	};

	$(function(){
		$('#sort').sortable({
			update: function( event, ui ) {
				var PostData = $( "#sort" ).sortable( "toArray");
				$.post('modulos/<?=$seccion?>/acciones.php', {list: PostData}, function(guardar){
				}, 'json')
			}
		});
	});

	function checkForm(form){
		form.enviar.value = "Espere...";
		form.enviar.disabled = true;
		setTimeout(function(){ 
			form.enviar.value = "Reintentar";
			form.enviar.disabled = false;
		}, 3000);
		return true;
	}

	$(document).ready(function() {
		var imagenesArray = [];
		$("#fileuploader").uploadFile({
			url:"../library/upload-file/php/upload.php",
			fileName:"myfile",
			maxFileCount:1,
			showDelete: 'false',
			allowedTypes: "jpeg,jpg",
			maxFileSize: 6291456,
			showFileCounter: true,
			showPreview:true,
			returnType:'json',
			onSuccess:function(files,data,xhr){ 
				imagenesArray.push(data);
				var id=$('#cfgid').val();
				window.location = ('index.php?seccion=<?=$seccion?>&languaje=<?=$languaje?>&imagen='+data);
			}
		});
	});
</script>

<script>
	$("#animacion").change(function() {
		var animacion = $(this).val();
		$.ajax({
			method: "POST",
			url: "modulos/<?=$seccion?>/acciones.php",
			data: { 
				animacion: animacion
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg);
		});
	});

	$("#anchocarousel").change(function() {
		var anchocarousel = $(this).val();
		$.ajax({
			method: "POST",
			url: "modulos/<?=$seccion?>/acciones.php",
			data: { 
				anchocarousel: anchocarousel
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg);
		});
	});
</script>


<?=$footer?>
