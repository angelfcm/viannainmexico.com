<?php
$catalogo = $CONEXION -> query("SELECT * FROM gallery WHERE id = $id");
$row_catalogo = $catalogo -> fetch_assoc();

$linkReload='index.php?seccion='.$seccion.'&subseccion=detalle&id='.$id;

echo '
<div class="uk-width-1-1 margen-top-20">
	<ul class="uk-breadcrumb">
		<li><a href="index.php?seccion='.$seccion.'">Ciudad sede</a></li>
		<li><a href="index.php?seccion='.$seccion.'&subseccion=detalle&id='.$id.'" class="color-red">'.$row_catalogo['tituloes'].'</a></li>
	</ul>
</div>

<form action="index.php" class="uk-width-1-1" method="post" name="editar" onsubmit="return checkForm(this);">
	<input type="hidden" name="editar" value="1">
	<input type="hidden" name="seccion" value="'.$seccion.'">
	<input type="hidden" name="subseccion" value="detalle">
	<input type="hidden" name="id" value="'.$id.'">
	<div uk-grid>

		<div class="uk-width-1-2@m uk-width-1-1 uk-container-center">
			<h4><br>Español</h4>
			<div>
				<label for="tituloes">Título</label>
				<input type="text" class="uk-input" name="tituloes" value="'.$row_catalogo['tituloes'].'" required autofocus>
			</div>
			<div>
				<label for="txtes">Descripción</label>
				<textarea class="editor" name="txtes">'.$row_catalogo['txtes'].'</textarea>
			</div>
		</div>
		<div class="uk-width-1-2@m uk-width-1-1 uk-container-center">
			<h4><br>Inglés</h4>
			<div>
				<label for="tituloen">Título</label>
				<input type="text" class="uk-input" name="tituloen" value="'.$row_catalogo['tituloen'].'" required>
			</div>
			<div>
				<label for="txten">Descripción</label>
				<textarea class="editor" name="txten">'.$row_catalogo['txten'].'</textarea>
			</div>
		</div>
		<div class="uk-width-1-2@m uk-width-1-1 uk-container-center">
			<h4><br>Japonés</h4>
			<div>
				<label for="tituloja">Título</label>
				<input type="text" class="uk-input" name="tituloja" value="'.$row_catalogo['tituloja'].'" required>
			</div>
			<div>
				<label for="txtja">Descripción</label>
				<textarea class="editor" name="txtja">'.$row_catalogo['txtja'].'</textarea>
			</div>
		</div>
		<div class="uk-width-1-2@m uk-width-1-1 uk-container-center">
			<h4><br>Ruso</h4>
			<div>
				<label for="tituloru">Título</label>
				<input type="text" class="uk-input" name="tituloru" value="'.$row_catalogo['tituloru'].'" required>
			</div>
			<div>
				<label for="txtru">Descripción</label>
				<textarea class="editor" name="txtru">'.$row_catalogo['txtru'].'</textarea>
			</div>
		</div>
		<div class="uk-width-1-2@m uk-width-1-1 uk-container-center">
			<h4><br>Portugués</h4>
			<div>
				<label for="titulopt">Título</label>
				<input type="text" class="uk-input" name="titulopt" value="'.$row_catalogo['titulopt'].'" required>
			</div>
			<div>
				<label for="txtpt">Descripción</label>
				<textarea class="editor" name="txtpt">'.$row_catalogo['txtpt'].'</textarea>
			</div>
		</div>
		<div class="uk-width-1-2@m uk-width-1-1 uk-container-center">
			<h4><br>Húngaro</h4>
			<div>
				<label for="tituloit">Título</label>
				<input type="text" class="uk-input" name="tituloit" value="'.$row_catalogo['tituloit'].'" required>
			</div>
			<div>
				<label for="txtit">Descripción</label>
				<textarea class="editor" name="txtit">'.$row_catalogo['txtit'].'</textarea>
			</div>
		</div>
		<div class="uk-width-1-1 uk-text-center margen-top-20">
			<a href="index.php?seccion='.$seccion.'" class="uk-button uk-button-large uk-button-white" tabindex="10">Cancelar</a>
			<a href="javascript:eliminaProd(id='.$row_catalogo['id'].')" class="uk-button uk-button-large uk-button-danger" tabindex="1">Eliminar</a>
			<input type="submit" name="send" value="Guardar" class="uk-button uk-button-large uk-button-primary">
		</div>

	</div>
</form>


<div class="uk-width-1-1 margen-v-20">
	<hr class="uk-divider-icon">
</div>

<div class="uk-width-1-2@m margen-top-50">
	<span class="uk-text-muted">
		Dimensiones recomendadas: 500 px de ancho<br>
		Para ordenar fotos arrastre y suelte.<br>
	</span>
	<div id="fileuploader">
		Cargar
	</div>
	<br><span id="msg" class="color-red">&nbsp;</span>
</div>

<div class="uk-width-1-1">
	<div id="sortable2" uk-grid class="uk-grid-match uk-grid-small">
		'; 


$num=1;
$picTXT='';
$productosPIC = $CONEXION -> query("SELECT * FROM gallerypic WHERE item = $id ORDER BY orden,id");
while ($row_productosPIC = $productosPIC -> fetch_assoc()) {

	$pic='../img/contenido/gallery/'.$row_productosPIC['id'].'-nat300.jpg';
	$picCopy='../img/contenido/gallery/'.$row_productosPIC['id'].'-nat1000.jpg';
	if(file_exists($pic)){
		echo '
		<div id="'.$row_productosPIC['id'].'" class="sortable uk-width-1-4@l uk-width-1-3@m uk-width-1-2">
			<div class="uk-card uk-card-default uk-card-body uk-text-center">
				<a 
					href="#config"
					uk-toggle
					class="cfg uk-icon-button uk-button-primary" 
					data-cfgid="'.$row_productosPIC['id'].'" 
					data-titulo="'.$row_productosPIC['titulo'].'"
					data-txt="'.$row_productosPIC['txt'].'"
					data-url="'.$row_productosPIC['url'].'"
					uk-icon="icon:cog">
				</a>
				&nbsp;
				<a href="javascript:eliminaPic(picID='.$row_productosPIC['id'].')" class="uk-icon-button uk-button-danger" uk-icon="icon:trash;"></a>
				<br><br>
				<img src="'.$pic.'" class="uk-border-rounded margen-bottom-20">
			</div>
		</div>';
	}else{
		echo '
		<div class="uk-width-1-5 uk-text-center" id="'.$row_productosPIC['id'].'">
			<p class="uk-scrollable-box"><i uk-icon="icon:chain-broken uk-icon-large"></i><br><br>
				Imagen rota<br><br>
				<a href="javascript:eliminaPic(picID='.$row_productosPIC['id'].')" class="uk-button uk-button-small uk-button-danger" tabindex="1">&times;</a>
			</p>
		</div>';
	}
}

echo '
	</div>
</div>



<div id="config" class="modal" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<a href="" class="uk-modal-close uk-close"></a>
		<div class="uk-modal-header">
			Configurar imagen
		</div>
		<form action="index.php" method="post" class="uk-width-1-1" name="datos" onsubmit="return checkForm(this);">
			<input type="hidden" name="editarpic" value="1">
			<input type="hidden" name="seccion" value="'.$seccion.'">
			<input type="hidden" name="subseccion" value="'.$subseccion.'">
			<input type="hidden" name="id" value="'.$id.'">
			<input type="hidden" name="picid" id="cfgid" value="">
			<div uk-grid>
				<div class="uk-width-1-2 uk-margin-top">
					<label for="titulo">Titulo de la imagen</label>
					<input type="text" id="titulo" name="titulo" class="uk-input">
				</div>
				<div class="uk-width-1-2 uk-margin-top">
					<label for="url">Link</label>
					<input type="text" id="url" name="url" class="uk-input">
				</div>
				<div class="uk-width-1-1 uk-margin-top uk-text-center">
					<a href="" class="uk-button uk-button-white uk-modal-close uk-button-large" tabindex="10">Cancelar</a>
					<button class="uk-button uk-button-primary uk-button-large">Guardar</button>
				</div>
			</div>
		</form>
	</div>
</div>

';


$scripts='

<script>
	// Eliminar foto
	function eliminaPic () { 
		console.log(picID);
		var statusConfirm = confirm("Realmente desea eliminar esta foto?"); 
		if (statusConfirm == true) { 
			window.location = ("index.php?seccion='.$seccion.'&borrarPic&id='.$id.'&picID="+picID);
		} 
	};
</script>

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
		})
	})
</script>
';

