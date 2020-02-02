
<div class="uk-width-1-1 margen-top-20 uk-text-left">
	<ul class="uk-breadcrumb">
		<?php 
		echo '
		<li><a href="index.php?seccion='.$seccion.'" class="color-red">Cursos</a></li>
		';
		?>
	</ul>
</div>

<div class="uk-width-medium-1-1 margen-v-50">
	<table class="uk-table uk-table-striped uk-table-hover">
		<thead>
			<tr class="uk-text-muted">
				<td>Título</td>
				<td class="uk-text-center">Primer pago</td>
				<td class="uk-text-right">Acciones &nbsp;&nbsp;&nbsp;&nbsp;</td>
			</tr>
		</thead>
		<tbody id="sortable">
		<?php
		$productos = $CONEXION -> query("SELECT * FROM $seccion ORDER BY orden");
		while ($row_productos = $productos -> fetch_assoc()) {
			$prodID=$row_productos['id'];

			$destacadoButton=($row_productos['destacado']==1)?'success':'default';
			$link='index.php?seccion='.$seccion.'&subseccion=detalle&id='.$row_productos['id'];

			echo '
			<tr id="'.$row_productos['id'].'">
				<td>
					<a href="'.$link.'">'.nl2br($row_productos['tituloes']).'</a>
				</td>
				<td class="uk-text-center">
					<a href="'.$link.'">$'.number_format($row_productos['precio']).'</a>
				</td>
				<td class="uk-text-right">
					<span class="destacado uk-icon-button uk-button-'.$destacadoButton.'" data-destacado="'.$row_productos['destacado'].'" id="'.$row_productos['id'].'" data-id="'.$row_productos['id'].'" uk-icon="icon:star"></span>
					<a href="'.$link.'" class="uk-icon-button uk-button-primary" uk-icon="icon:pencil"></a>
					<a href="auditorio1.php?id='.$prodID.'" target="_blank" class="uk-icon-button uk-button-primary" uk-icon="icon:download" download="auditorio.csv"></a>
					<span data-id="'.$row_productos['id'].'" class="eliminaprod uk-icon-button uk-button-danger" tabindex="1" uk-icon="icon:trash"></span>
				</td>
			</tr>';
		}
		?>

		</tbody>
	</table>
	<p id="mensaje"></p>
</div>

<?php
$CONSULTA = $CONEXION -> query("SELECT * FROM configuracion WHERE id = 1");
$row_CONSULTA = $CONSULTA -> fetch_assoc();
?>
<div class="uk-width-1-1">
	<hr class="uk-divider-icon">
</div>
<div class="uk-width-1-1 uk-text-center">
	<h3>Imágenes del encabezado</h3>
	<input type="hidden" id="languaje">
</div>
<div class="uk-width-1-1 uk-text-center">
	<a href="#pic" uk-toggle class="pic margen-top-20 uk-button uk-button-white" data-languaje="es" uk-tooltip title="<img src='../img/contenido/cursoscat/<?=$row_CONSULTA['pices']?>'>">Español</a>
	<a href="#pic" uk-toggle class="pic margen-top-20 uk-button uk-button-white" data-languaje="en" uk-tooltip title="<img src='../img/contenido/cursoscat/<?=$row_CONSULTA['picen']?>'>">Inglés</a>
	<a href="#pic" uk-toggle class="pic margen-top-20 uk-button uk-button-white" data-languaje="ja" uk-tooltip title="<img src='../img/contenido/cursoscat/<?=$row_CONSULTA['picja']?>'>">Japonés</a>
	<a href="#pic" uk-toggle class="pic margen-top-20 uk-button uk-button-white" data-languaje="ru" uk-tooltip title="<img src='../img/contenido/cursoscat/<?=$row_CONSULTA['picru']?>'>">Ruso</a>
	<a href="#pic" uk-toggle class="pic margen-top-20 uk-button uk-button-white" data-languaje="pt" uk-tooltip title="<img src='../img/contenido/cursoscat/<?=$row_CONSULTA['picpt']?>'>">Portugues</a>
	<a href="#pic" uk-toggle class="pic margen-top-20 uk-button uk-button-white" data-languaje="it" uk-tooltip title="<img src='../img/contenido/cursoscat/<?=$row_CONSULTA['picit']?>'>">Húngaro</a>
</div>
<img src="../img/contenido/cursoscat/<?=$row_CONSULTA['pices']?>" class="uk-hidden">
<img src="../img/contenido/cursoscat/<?=$row_CONSULTA['picen']?>" class="uk-hidden">
<img src="../img/contenido/cursoscat/<?=$row_CONSULTA['picja']?>" class="uk-hidden">
<img src="../img/contenido/cursoscat/<?=$row_CONSULTA['picru']?>" class="uk-hidden">
<img src="../img/contenido/cursoscat/<?=$row_CONSULTA['picpt']?>" class="uk-hidden">
<img src="../img/contenido/cursoscat/<?=$row_CONSULTA['picit']?>" class="uk-hidden">

<div uk-modal id="pic">
	<div class="uk-modal-dialog">
		<div class="uk-modal-header">
			<h3>Imágenes de encabezado</h3>
		</div>
		<div class="uk-modal-body">
			<div id="fileuploadercat">
				Cargar
			</div>
		</div>
		<div class="uk-modal-footer uk-text-center">
			<a class="uk-button uk-button-white uk-button-large uk-modal-close">Cerrar</a>
		</div>
	</div>
</div>


<?php
	$picTXT='';
	$CONSULTAPIC = $CONEXION -> query("SELECT * FROM $seccionpic ORDER BY orden,id");
	$numProds=$CONSULTAPIC->num_rows;
	while ($row_CONSULTAPIC = $CONSULTAPIC -> fetch_assoc()) {

		$pic='../img/contenido/'.$seccion.'/'.$row_CONSULTAPIC['id'].'-xs.jpg';
		$picLg='../img/contenido/'.$seccion.'/'.$row_CONSULTAPIC['id'].'-lg.jpg';
		if(file_exists($pic)){

			$picTXT.='
					<div class="uk-width-1-4@l uk-width-1-2@m uk-width-1-1@s uk-margin-bottom" id="'.$row_CONSULTAPIC['id'].'">
						<div class="uk-card uk-card-default uk-card-body uk-text-center">
							<a href="'.$picLg.'" class="uk-icon-button uk-button-default" target="_blank" uk-icon="icon:image"></a>&nbsp;
							<a href="javascript:eliminaPic(picID='.$row_CONSULTAPIC['id'].')" class="uk-icon-button uk-button-danger" tabindex="1" uk-icon="icon:trash"></a>
							<br>
							<img src="'.$pic.'" class="img-responsive uk-border-rounded margen-top-20"><br>
							'.$row_CONSULTAPIC['titulo'].'<br>
							'.$row_CONSULTAPIC['title'].'
						</div>
					</div>';
		}else{
			$picTXT.='
					<div class="uk-width-1-4@l uk-width-1-2@m uk-width-1-1@s uk-margin-bottom" id="'.$row_CONSULTAPIC['id'].'">
						<div class="uk-card uk-card-default uk-card-body uk-text-center">
							<a href="javascript:eliminaPic(picID='.$row_CONSULTAPIC['id'].')" class="uk-icon-button uk-button-danger" tabindex="1" uk-icon="icon:trash"></a>
							<br>
							Imagen rota<br>
							<i uk-icon="icon:ban;ratio:2;"></i>
						</div>
					</div>';
		}
	}

	echo '
	<div class="uk-width-1-1 margen-v-50">
		<hr class="uk-divider-icon">
	</div>
	<div class="uk-width-1-1">
		<h3 class="uk-text-center">Mapas de asientos</h3>
	</div>

	<div class="uk-width-1-1">
		<div id="fileuploader">
			Cargar
		</div>
	</div>
	<div class="uk-width-1-1 uk-text-center">
		<div uk-grid class="uk-grid-small uk-grid-match" id="sortable2">
			'.$picTXT.'
		</div>
	</div>
';
?>


<div>
	<div id="buttons">
		<a href="index.php?seccion=<?=$seccion?>&subseccion=nuevo&cat=<?=$cat?>" id="add-button" class="uk-icon-button uk-button-primary uk-box-shadow-large" uk-icon="icon: plus;ratio:1.4"></a>
	</div>
</div>


<?php
$scripts='

	// Eliminar producto
	$(".eliminaprod").click(function() {
		var id = $(this).attr("data-id");
		var statusConfirm = confirm("Realmente desea eliminar este Producto?"); 
		if (statusConfirm == true) { 
			window.location = ("index.php?seccion='.$seccion.'&subseccion=contenido&borrarPod&cat='.$cat.'&id="+id);
		} 
	});

	// Definir lenguaje de la foto
	$(".pic").click(function() {
		$("#languaje").val($(this).attr("data-languaje"));
	});

	$(document).ready(function() {
		var imagenesArray = [];
		$("#fileuploadercat").uploadFile({
			url:"../library/upload-file/php/upload.php",
			fileName:"myfile",
			maxFileCount:1,
			allowedTypes: "jpeg,jpg",
			maxFileSize: 6291456,
			showFileCounter: true,
			showPreview:true,
			returnType:"json",
			onSuccess:function(files,data,xhr){ 
				var languaje=$("#languaje").val();
				window.location = ("index.php?seccion='.$seccion.'&position=categoria&languaje="+languaje+"&imagen="+data);
			}
		});
	});


	$(".destacado").click(function(){
		var id = $(this).attr("data-id");
		var destacado = $(this).attr("data-destacado");

		if(destacado==0) {
			destacado=1;
			$(".uk-button-success").attr("data-destacado",0);
			$(this).addClass("uk-button-success");
		}else{
			destacado=0;
			$(this).removeClass("uk-button-success");
		}
		$(this).attr("data-destacado",destacado);

		$.ajax({
			method: "POST",
			url: "modulos/'.$seccion.'/acciones.php",
			data: { 
				id: id,
				seccion: "'.$seccion.'",
				endestacado: 1,
				estado: destacado
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg);
			//console.log( msg + " - " + id + " - " + destacado);
		});

	})

	$(document).ready(function() {
		var imagenesArray = [];
		$("#fileuploader").uploadFile({
			url:"../library/upload-file/php/upload.php",
			fileName:"myfile",
			maxFileCount:1,
			allowedTypes: "jpeg,jpg",
			maxFileSize: 6291456,
			showFileCounter: true,
			showPreview:true,
			returnType:\'json\',
			onSuccess:function(files,data,xhr){ 
				window.location = (\'index.php?seccion='.$seccion.'&position=gallery&imagen=\'+data);
			}
		});
	});

	';



?>