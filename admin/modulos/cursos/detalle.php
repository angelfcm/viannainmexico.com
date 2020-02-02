<?
$CONSULTA = $CONEXION -> query("SELECT * FROM $seccion WHERE id = $id");
$row_CONSULTA = $CONSULTA -> fetch_assoc();

$linkShareEs='http%3A%2F%2Fexper.mx%2F'.$id.'_'.str_replace('+', '%2B', urlencode(html_entity_decode($row_CONSULTA['tituloes']))).'_.html';
$linkOnline='http://exper.mx/'.$id.'_'.urlencode(html_entity_decode($row_CONSULTA['tituloes'])).'_.html';


// DIAGRAMA
$diagrama='';
$pic='../img/contenido/'.$seccion.'main/'.$row_CONSULTA['imagen'];
if($row_CONSULTA['imagen']!='' AND file_exists($pic)){
	$diagrama.='
	<div class="uk-panel uk-text-center">
		<a href="'.$pic.'" target="_blank">
			<img src="'.$pic.'" class="img-responsive uk-border-rounded margen-top-20">
		</a>
	</div>';
}else{
	$diagrama.='
	<div class="uk-panel uk-text-center">
		<p class="uk-scrollable-box"><i uk-icon="icon:image;ratio:5;"></i><br><br>
			Falta foto para compartir en redes sociales<br><br>
		</p>
	</div>';
}

$asientos=(($row_CONSULTA['asientoscol']*$row_CONSULTA['asientosrow'])==0)?'
	<a href="#asientos" uk-toggle class="uk-button uk-button-secondary uk-button-large" tabindex="10">Auditorio</a>
	':'
	<a href="index.php?seccion='.$seccion.'&subseccion=auditorio&id='.$id.'" class="uk-button uk-button-secondary uk-button-large" tabindex="10">Auditorio</a>';

/* OBSOLETO
	$picTXT='';
	$CONSULTAPIC = $CONEXION -> query("SELECT * FROM $seccionpic WHERE producto = $id ORDER BY orden,id");
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

	$obsoleto='

	<div class="uk-width-1-1 margen-v-50">
		<hr class="uk-divider-icon">
	</div>
	<div class="uk-width-1-1">
		<h1 class="uk-text-center">Fotografías</h1>
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
*/


echo '
<div class="uk-width-1-1 margen-v-20">
	<ul class="uk-breadcrumb">
		<li><a href="index.php?seccion='.$seccion.'">Cursos</a></li>
		<li><a href="index.php?seccion='.$seccion.'&subseccion=detalle&id='.$id.'" class="color-red">'.$row_CONSULTA['tituloes'].'</a></li>
	</ul>
</div>';


$languaje=(isset($_REQUEST['languaje']))?$_REQUEST['languaje']:'es';
$languajeButton=array(
	'es'=>'uk-button-white',
	'en'=>'uk-button-white',
	'ja'=>'uk-button-white',
	'ru'=>'uk-button-white',
	'pt'=>'uk-button-white',
	'it'=>'uk-button-white'
	);
$languajeButton[$languaje]='uk-button-secondary';

echo '
<!-- Selección de idioma -->
<div class="uk-width-1-1 uk-text-center">
    <a href="index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&id='.$id.'&languaje=es" class="margen-top-20 uk-button '.$languajeButton['es'].'">Español</a>
    <a href="index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&id='.$id.'&languaje=en" class="margen-top-20 uk-button '.$languajeButton['en'].'">Inglés</a>
    <a href="index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&id='.$id.'&languaje=ja" class="margen-top-20 uk-button '.$languajeButton['ja'].'">Japonés</a>
    <a href="index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&id='.$id.'&languaje=ru" class="margen-top-20 uk-button '.$languajeButton['ru'].'">Ruso</a>
    <a href="index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&id='.$id.'&languaje=pt" class="margen-top-20 uk-button '.$languajeButton['pt'].'">Portugues</a>
    <a href="index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&id='.$id.'&languaje=it" class="margen-top-20 uk-button '.$languajeButton['it'].'">Húngaro</a>
</div>

<div class="uk-width-1-1 margen-top-20">
	<form action="index.php" method="post" enctype="multipart/form-data" name="datos" onsubmit="return checkForm(this);">
		<input type="hidden" name="editar" value="1">
		<input type="hidden" name="seccion" value="'.$seccion.'">
		<input type="hidden" name="subseccion" value="detalle">
		<input type="hidden" name="languaje" value="'.$languaje.'">
		<input type="hidden" name="id" value="'.$id.'">
		<div uk-grid>
			<div class="uk-width-1-2@m uk-margin-top">
				<label for="titulo">Título</label>
				<textarea class="uk-textarea uk-margin-bottom" name="titulo">'.$row_CONSULTA['titulo'.$languaje].'</textarea>
				<label for="titulo">Título Gafet</label>
				<textarea class="uk-textarea uk-margin-bottom" name="titulo_gafet">'.$row_CONSULTA['titulo_gafet'].'</textarea>
				<label for="fecha">Fechas</label>
				<input type="text" class="uk-input uk-margin-bottom" name="fecha" value="'.$row_CONSULTA['fecha'.$languaje].'" >
				<label for="horario">Horario</label>
				<input type="text" class="uk-input uk-margin-bottom" name="horario" value="'.$row_CONSULTA['horario'.$languaje].'" >
				<label for="lugar">Lugar</label>
				<input type="text" class="uk-input uk-margin-bottom" name="lugar" value="'.$row_CONSULTA['lugar'.$languaje].'" >
			</div>
			<div class="uk-width-1-2@m uk-margin-top">
				<label for="prerequisito">Prerrequisito</label>
				<input type="text" class="uk-input uk-margin-bottom" name="prerequisito" value="'.$row_CONSULTA['prerequisito'.$languaje].'" >
				<label for="pagostexto">Descripción de pagos</label>
				<textarea class="uk-textarea uk-margin-bottom" name="pagostexto">'.$row_CONSULTA['pagostexto'.$languaje].'</textarea>
			</div>
			<div class="uk-width-1-2">
				<div class="uk-margin-top uk-text-center">
					<label for="precio">Primer pago MXN</label>
					<input type="number" class="uk-input uk-margin-bottom" name="precio" value="'.$row_CONSULTA['precio'].'" >
				</div>
			</div>
			<div class="uk-width-1-2">
				<div class="uk-margin-top uk-text-center">
					<label for="preciousd">Primer pago USD</label>
					<input type="number" class="uk-input uk-margin-bottom" name="preciousd" value="'.$row_CONSULTA['preciousd'].'" >
				</div>
			</div>

			<div class="uk-width-1-2" style="visibility: hidden"> <!-- no requerido por ahora -->
				<div class="uk-margin-top uk-text-center">
					<label for="precio_traduccion">Precio Traducción MXN</label>
					<input type="number" class="uk-input uk-margin-bottom" name="precio_traduccion" value="'.$row_CONSULTA['precio_traduccion'].'" >
				</div>
			</div>
			<div class="uk-width-1-2">
				<div class="uk-margin-top uk-text-center">
					<label for="precio_traduccion_usd">Precio Traducción USD</label>
					<input type="number" class="uk-input uk-margin-bottom" name="precio_traduccion_usd" value="'.$row_CONSULTA['precio_traduccion_usd'].'" >
				</div>
			</div>

			<div class="uk-width-1-1">
				<div class="uk-margin-top uk-text-center">
					<a href="index.php?seccion='.$seccion.'&subseccion=contenido" class="uk-button uk-button-white uk-button-large" tabindex="10">Cancelar</a>					
					'.$asientos.'
					<button name="send" class="uk-button uk-button-primary uk-button-large">Guardar</button>
				</div>
			</div>
		</div>
	</form>
</div>



<div class="uk-width-1-1 margen-v-50">
	<hr class="uk-divider-icon">
</div>
<div class="uk-width-1-1">
	<h1 class="uk-text-center">Imagen para compartir en redes sociales</h1>
</div>
<div class="uk-width-2-3@m margen-top-50">
	<div class="margen-bottom-50 uk-text-muted">
		Dimensiones recomendadas:<br><br>
		1000 px de ancho<br>
		600 px de alto
	</div>
	<div id="fileuploadermain">
		Cargar
	</div>
</div>
<div class="uk-width-1-3@m uk-text-center margen-v-20">
	'.$diagrama.'
</div>


<div>
	<div id="buttons">
		<a href="#" data-id="'.$row_CONSULTA['id'].'" class="eliminaprod uk-icon-button uk-button-danger uk-box-shadow-large" uk-icon="icon:trash;ratio:1.4"></a href="#"> 
		<a href="index.php?seccion='.$seccion.'&subseccion=nuevo&cat='.$cat.'" id="add-button" class="uk-icon-button uk-button-primary uk-box-shadow-large" uk-icon="icon:plus;ratio:1.4"></a>
	</div>
</div>


<div id="asientos" uk-modal class="modal">
	<div class="uk-modal-dialog uk-modal-body">
		<a href="" class="uk-modal-close uk-close"></a>
		<form action="index.php" method="post" onsubmit="return checkForm(this);">
			<input type="hidden" name="auditorionew" value="1">
			<input type="hidden" name="seccion" value="'.$seccion.'">
			<input type="hidden" name="subseccion" value="auditorio">
			<input type="hidden" name="id" value="'.$id.'">
			<div class="uk-child-width-1-2" uk-grid>
				<div>
					<label for="filas">Filas</label>
					<input type="number" class="uk-input" name="filas">
				</div>
				<div>
					<label for="columnas">Columnas</label>
					<input type="number" class="uk-input" name="columnas">
				</div>
			</div>
			<br><br>
			<div class="uk-text-center">
				<a href="" class="uk-button uk-button-default uk-modal-close uk-button-large" tabindex="10">Cancelar</a>
				<input type="submit" name="send" value="Guardar" class="uk-button uk-button-primary uk-button-large">
			</div>
		</form>
	</div>
</div>
';



$scripts='

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
				window.location = (\'index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&id='.$id.'&position=gallery&imagen=\'+data);
			}
		});
	});

	$(document).ready(function() {
		var imagenesArray = [];
		$("#fileuploadermain").uploadFile({
			url:"../library/upload-file/php/upload.php",
			fileName:"myfile",
			maxFileCount:1,
			allowedTypes: "jpeg,jpg",
			maxFileSize: 6291456,
			showFileCounter: true,
			showPreview:true,
			returnType:\'json\',
			onSuccess:function(files,data,xhr){ 
				window.location = (\'index.php?seccion='.$seccion.'&subseccion='.$subseccion.'&id='.$id.'&position=main&imagen=\'+data);
			}
		});
	});


	// Eliminar producto
	$(".eliminaprod").click(function() {
		var id = $(this).attr(\'data-id\');
		//console.log(id);
		var statusConfirm = confirm("Realmente desea eliminar este curso?"); 
		if (statusConfirm == true) { 
			window.location = ("index.php?seccion='.$seccion.'&subseccion=contenido&borrarPod&cat='.$cat.'&id="+id);
		} 
	});
	';
