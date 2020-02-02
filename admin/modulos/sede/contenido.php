<?php 
$CONSULTA = $CONEXION -> query("SELECT * FROM traduccion WHERE variable = 'menuCiudad'");
$row_CONSULTA = $CONSULTA -> fetch_assoc();

echo '

<div class="uk-width-1-1uk-text-left">
	<ul class="uk-breadcrumb">
		<li><a href="index.php?seccion='.$seccion.'" class="color-red">Ciudad sede</a></li>
	</ul>
</div>

<div class="uk-width-1-1 margen-top-20 uk-text-left">
	<div uk-grid class="uk-grid-small uk-child-width-expand">
		<div class="uk-width-1-1">
			Título del menú
		</div>
		<div>
			<label>Español</label>
			<input type="text" class="uk-input uk-form-width-medium" id="catnamees" value="'.$row_CONSULTA['es'].'">
		</div>
		<div>
			<label>Inglés</label>
			<input type="text" class="uk-input uk-form-width-medium" id="catnameen" value="'.$row_CONSULTA['en'].'">
		</div>
		<div>
			<label>Japonés</label>
			<input type="text" class="uk-input uk-form-width-medium" id="catnameja" value="'.$row_CONSULTA['ja'].'">
		</div>
		<div>
			<label>Ruso</label>
			<input type="text" class="uk-input uk-form-width-medium" id="catnameru" value="'.$row_CONSULTA['ru'].'">
		</div>
		<div>
			<label>Portugés</label>
			<input type="text" class="uk-input uk-form-width-medium" id="catnamept" value="'.$row_CONSULTA['pt'].'">
		</div>
		<div>
			<label>Húngaro</label>
			<input type="text" class="uk-input uk-form-width-medium" id="catnameit" value="'.$row_CONSULTA['it'].'">
		</div>
		<div>
			<br>
			<button id="catnamesave" class="uk-button uk-button-white">Guardar</button>
		</div>
	</div>
</div>';
$CONSULTA = $CONEXION -> query("SELECT * FROM traduccion WHERE variable = 'tituloCiudad'");
$row_CONSULTA = $CONSULTA -> fetch_assoc();
echo'
<div class="uk-width-1-1 margen-top-20 uk-text-left">
	<div uk-grid class="uk-grid-small uk-child-width-expand">
		<div>
			<label>Español</label>
			<input type="text" class="uk-input uk-form-width-medium" id="titnamees" value="'.$row_CONSULTA['es'].'">
		</div>
		<div>
			<label>Inglés</label>
			<input type="text" class="uk-input uk-form-width-medium" id="titnameen" value="'.$row_CONSULTA['en'].'">
		</div>
		<div>
			<label>Japonés</label>
			<input type="text" class="uk-input uk-form-width-medium" id="titnameja" value="'.$row_CONSULTA['ja'].'">
		</div>
		<div>
			<label>Ruso</label>
			<input type="text" class="uk-input uk-form-width-medium" id="titnameru" value="'.$row_CONSULTA['ru'].'">
		</div>
		<div>
			<label>Portugés</label>
			<input type="text" class="uk-input uk-form-width-medium" id="titnamept" value="'.$row_CONSULTA['pt'].'">
		</div>
		<div>
			<label>Húngaro</label>
			<input type="text" class="uk-input uk-form-width-medium" id="titnameit" value="'.$row_CONSULTA['it'].'">
		</div>
		<div>
			<br>
			<button id="titnamesave" class="uk-button uk-button-white">Guardar</button>
		</div>
	</div>
</div>

<div class="uk-width-1-1 margen-v-20">
	<table class="uk-table uk-table-striped uk-table-hover">
		<thead>
			<tr class="uk-text-muted">
				<td width="50%">Título en español</td>
				<td width="25%">Foto</td>
				<td width="25%" class="uk-text-center">Acciones</td>
			</tr>
		</thead>
		<tbody id="sortable">';

		$gallery = $CONEXION -> query("SELECT * FROM gallery ORDER BY orden");
		while ($row_gallery = $gallery -> fetch_assoc()) {

			$prodID=$row_gallery['id'];

			$inicioButton=($row_gallery['inicio']==1)?'success':'white';

			$picROW='<img src="../img/design/blank.png" class="uk-border-rounded" width="100px">';
			$gallerypic = $CONEXION -> query("SELECT * FROM gallerypic WHERE item = $prodID ORDER BY orden");
			$row_gallerypic = $gallerypic -> fetch_assoc();
			$pic='../img/contenido/gallery/'.$row_gallerypic['id'].'-nat300.jpg';
			if(file_exists($pic)){
				$picROW='<img src="'.$pic.'" class="uk-border-rounded" width="100px">';
			}

			$link='index.php?seccion='.$seccion.'&subseccion=detalle&id='.$row_gallery['id'];

			echo '
			<tr id="'.$row_gallery['id'].'">
				<td>
					<a href="'.$link.'">'.$row_gallery['tituloes'].'</a>
				</td>
				<td>
					<a href="'.$link.'">'.$picROW.'</a>
				</td>
				<td class="uk-text-center">
					<a href="'.$link.'" class="uk-icon-button uk-button-primary"  uk-icon="icon:pencil"></i></a>
					<a href="javascript:eliminaProd(id='.$row_gallery['id'].')" class="uk-icon-button uk-button-danger" uk-icon="icon:trash"></i></a> 
				</td>
			</tr>';
		$picROW='';
		}
echo'
		</tbody>
	</table>
</div>

<div>
	<div id="buttons">
		<a href="index.php?seccion='.$seccion.'&subseccion=nuevo" id="add-button" class="uk-icon-button uk-button-primary uk-box-shadow-large" uk-icon="icon: plus;ratio:1.4"></a>
	</div>
</div>';

$scripts='
<script>
	$("#catnamesave").click(function(){
		var es=$("#catnamees").val();
		var en=$("#catnameen").val();
		var ja=$("#catnameja").val();
		var ru=$("#catnameru").val();
		var pt=$("#catnamept").val();
		var it=$("#catnameit").val();
		$.ajax({
			method: "POST",
			url: "modulos/'.$seccion.'/acciones.php",
			data: { 
				catnamesave: 1,
				es: es,
				en: en,
				ja: ja,
				ru: ru,
				pt: pt,
				it: it
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg);
			//console.log( msg + " - " + id + " - " + inicio);
		});
	})
</script>

<script>
	$("#titnamesave").click(function(){
		var es=$("#titnamees").val();
		var en=$("#titnameen").val();
		var ja=$("#titnameja").val();
		var ru=$("#titnameru").val();
		var pt=$("#titnamept").val();
		var it=$("#titnameit").val();
		$.ajax({
			method: "POST",
			url: "modulos/'.$seccion.'/acciones.php",
			data: { 
				titnamesave: 1,
				es: es,
				en: en,
				ja: ja,
				ru: ru,
				pt: pt,
				it: it
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg);
			//console.log( msg + " - " + id + " - " + inicio);
		});
	})
</script>

<script>
	$(".inicio").click(function(){
		var id = $(this).attr("data-id");
		var inicio = $(this).attr("data-inicio");

		if(inicio==0) {
			inicio=1;
			$(this).removeClass("uk-button-white");
			$(this).addClass("uk-button-success");
		}else{
			inicio=0;
			$(this).removeClass("uk-button-success");
			$(this).addClass("uk-button-white");
		}
		$(this).attr("data-inicio",inicio);

		$.ajax({
			method: "POST",
			url: "modulos/'.$seccion.'/acciones.php",
			data: { 
				id: id,
				seccion: "'.$seccion.'",
				eninicio: 1,
				estado: inicio
			}
		})
		.done(function( msg ) {
			UIkit.notification.closeAll();
			UIkit.notification(msg);
			//console.log( msg + " - " + id + " - " + inicio);
		});

	})
</script>
';
?>