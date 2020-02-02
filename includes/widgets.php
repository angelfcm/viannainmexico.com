<?

// FECHA
  function fechaDisplay($fechaSQL){
    $fechaSegundos=strtotime($fechaSQL);
    $fechaY=date('Y',$fechaSegundos);
    $fechaM=date('m',$fechaSegundos);
    $fechaD=date('d',$fechaSegundos);
    $fechaDay=strtolower(date('D',$fechaSegundos));

    switch ($fechaM) {
      case 1:
      $mes='enero';
      break;
      
      case 2:
      $mes='febrero';
      break;
      
      case 3:
      $mes='marzo';
      break;
      
      case 4:
      $mes='abril';
      break;
      
      case 5:
      $mes='mayo';
      break;
      
      case 6:
      $mes='junio';
      break;
      
      case 7:
      $mes='julio';
      break;
      
      case 8:
      $mes='agosto';
      break;
      
      case 9:
      $mes='septiembre';
      break;
      
      case 10:
      $mes='octubre';
      break;
      
      case 11:
      $mes='noviembre';
      break;
      
      default:
      $mes='diciembre';
      break;
    }

    switch ($fechaDay) {
      case 'mon':
      $fechaDia='Lunes';
      break;
      case 'tue':
      $fechaDia='Martes';
      break;
      case 'wed':
      $fechaDia='Miércoles';
      break;
      case 'thu':
      $fechaDia='Jueves';
      break;
      case 'fri':
      $fechaDia='Viernes';
      break;
      case 'sat':
      $fechaDia='Sábado';
      break;
      default:
      $fechaDia='Domingo';
      break;
    }

    //return $fechaDia.' '.$fechaD.' de '.$mes.' de '.$fechaY;
    return $fechaD.' de '.$mes.' de '.$fechaY;
  }


// Anuncio
  function anuncio($id){
	global $CONEXION;
	global $caracteres_si_validos;
	global $caracteres_no_validos;
	global $linkToShare;
	global $linkToShare;
  global $rutaEstaPagina;
  global $ruta;

	// Número de anucnios
	$CONSULTA = $CONEXION -> query("SELECT * FROM clasificados WHERE id = $id");
	$row_CONSULTA = $CONSULTA -> fetch_assoc();

    $thisID=$row_CONSULTA['id'];
    $link=$thisID.'_'.(urlencode(str_replace($caracteres_no_validos, $caracteres_si_validos, html_entity_decode($row_CONSULTA['titulo'])))).'_.html';
    $linkEdit=$thisID.'_anuncio-c.html';
    $linkPics=$thisID.'_anuncio-d.html';

    $fechaSQL=$row_CONSULTA['fecha'];
    $fechaDisplay=fechaDisplay($fechaSQL);
    $subseccion=$row_CONSULTA['subseccion'];
    $title=html_entity_decode($row_CONSULTA['titulo']);
    $description=html_entity_decode($row_CONSULTA['descripcion']);
    $txt=($row_CONSULTA['descripcion']=='')?'':'<div class="uk-text-sm uk-text-truncate margen-v-10">'.strip_tags($row_CONSULTA['descripcion']).'</div>';


    // Fotos
    $num=0;
    $pic1='';
    $rutaFotos='img/contenido/clasificados/';

    for ($i=1; $i<=6 ; $i++) {
      if($row_CONSULTA['foto'.$i]!='' AND file_exists($rutaFotos.$row_CONSULTA['foto'.$i])){
        $fotosArray[]=$row_CONSULTA['foto'.$i];
      }
    }

    $pic1=(isset($fotosArray))?$rutaFotos.$fotosArray[0]:'';
      

    $CONSULTA2 = $CONEXION -> query("SELECT * FROM clasificadoscat WHERE id = $subseccion");
    $row_CONSULTA2 = $CONSULTA2 -> fetch_assoc();
    $parent=$row_CONSULTA2['parent'];

    $CONSULTA3 = $CONEXION -> query("SELECT * FROM clasificadoscat WHERE id = $parent");
    $row_CONSULTA3 = $CONSULTA3 -> fetch_assoc();

    $CONSULTA4 = $CONEXION -> query("SELECT * FROM comentarios WHERE prod = $thisID AND parent = 0 AND estatus=1");
    $numComent = $CONSULTA4->num_rows;
    $numComentHtml=($numComent>0)?'<span class="uk-badge">'.$numComent.'</span>':'';

    $buttons=($rutaEstaPagina==$ruta.'Mi-Cuenta')?'
            <!-- Botones privados -->
            <div class="uk-width-1-1 uk-text-center">
                <a href="'.$linkEdit.'" class="uk-button uk-button-personal">
                  Editar datos
                </a><a href="'.$linkPics.'" class="uk-button uk-button-claro">
                  imágenes
                </a><a href="'.$link.'" class="uk-button uk-button-default">
                  Comentarios '.$numComentHtml.'
                </a><button data-id="'.$thisID.'" class="borrar uk-button uk-button-danger">
                  Eliminar
                </button>
            </div>
            ':'
            <!-- Botones públicos -->
            <div class="uk-width-1-1 uk-text-center">
                <a href="0_'.$row_CONSULTA['subseccion'].'_'.urlencode($row_CONSULTA2['txt1']).'-b.html" class="uk-button uk-button-claro">
                  '.$row_CONSULTA2['txt1'].'
                </a><a href="'.$link.'" class="uk-button uk-button-default">
                  Detalles
                </a><a href="#info" uk-toggle class="uk-button uk-button-default">
                  Inscribirme al curso
                </a><button class="uk-button uk-button-default" type="button">
                 Compartir
                </button>
                <div uk-dropdown>
                  <ul class="uk-nav uk-dropdown-nav">
                    <li><a href="https://twitter.com/intent/tweet?text='.$linkToShare.'&ref=plugin&src=share_button&button_hashtag=Ecoguia&screen_name=Ecoguia" target="_blank"><span uk-icon="icon:twitter"></span> &nbsp; Twitter</a></li>
                    <li><a href="https://www.facebook.com/sharer/sharer.php?u='.$linkToShare.'" target="_blank"><span uk-icon="icon:facebook"></span> &nbsp; Facebook</a></li>
                  </ul>
                </div>
            </div>
    ';

    echo '
          <div uk-grid id="item'.$thisID.'" data-id="'.$thisID.'">
            <div class="uk-width-1-5@l uk-width-1-4@m uk-width-1-2@s uk-text-center">
              <a href="'.$link.'">
                <img src="'.$pic1.'" class="max-height-300px uk-border-rounded">
              </a>
            </div>
            <div class="uk-width-4-5@l uk-width-3-4@m uk-width-1-2@s">
              <span class="uk-card-title">'.$row_CONSULTA['titulo'].'</span>
              <p><i uk-icon="icon:clock"></i> '.$fechaDisplay.'</p>
              '.$txt.'
            </div>
            
            '.$buttons.'

          </div>
          <div class="uk-divider-icon">
          </div>';
	
	mysqli_free_result($CONSULTA);
	mysqli_free_result($CONSULTA2);
  mysqli_free_result($CONSULTA3);
	mysqli_free_result($CONSULTA4);
  } 


// Guardar cambios a anuncio
  if (isset($_POST['editaanuncio'])) {
    $id=$_POST['id'];
    if(isset($_POST['seccion']) and $_POST['seccion']!='') { $seccion = $_POST['seccion']; }else{ $fallo=1; $legendFail.='<br>Proporcione seccion'; }
    if(isset($_POST['subseccion']) and $_POST['subseccion']!='') { $subseccion = $_POST['subseccion']; }else{ $fallo=1; $legendFail.='<br>Proporcione subseccion'; }
    if(isset($_POST['fecha']) and $_POST['fecha']!='') { $fecha = $_POST['fecha']; }else{ $fallo=1; $legendFail.='<br>Proporcione fecha'; }
    if(isset($_POST['titulo']) and $_POST['titulo']!='') { $titulo = htmlentities($_POST['titulo'], ENT_QUOTES); }else{ $fallo=1; $legendFail.='<br>Proporcione t&iacute;tulo'; }
    if(isset($_POST['descripcion']) and $_POST['descripcion']!='') { $descripcion = $_POST['descripcion']; }else{ $fallo=1; $legendFail.='<br>Proporcione descripcion'; }

    // Mapa
    if(isset($_POST['mapahidden'])){ 
      $mapa = explode(',', substr($_POST['mapahidden'], 1, -1));
      $maplat=trim($mapa[0]);
      $maplng=trim($mapa[1]);
    }

    if($fallo===0){
      if (
          $actualizar = $CONEXION->query("UPDATE clasificados SET seccion = $seccion WHERE id = $id")
      AND $actualizar = $CONEXION->query("UPDATE clasificados SET subseccion = $subseccion WHERE id = $id")
      AND $actualizar = $CONEXION->query("UPDATE clasificados SET fecha = '$fecha' WHERE id = $id")
      AND $actualizar = $CONEXION->query("UPDATE clasificados SET titulo = '$titulo' WHERE id = $id")
      AND $actualizar = $CONEXION->query("UPDATE clasificados SET descripcion = '$descripcion' WHERE id = $id")
      AND $actualizar = $CONEXION->query("UPDATE clasificados SET maplat  = '$maplat'  WHERE id = $id")
      AND $actualizar = $CONEXION->query("UPDATE clasificados SET maplng  = '$maplng'  WHERE id = $id")
      ){
        $mensajeClase='success';
        $mensaje='<br>Cambios guardados';
      }else{
        $mensajeClase='danger';
        $mensaje='<br>No se pudo modificar la base de datos';
      }
    }
  }

