<?php
require_once('../includes/connection.php');

const GAFETS_POR_PAGINA = 10;
const GAFETS_POR_FILA = 2;

$id=$_GET['id'];

$CONSULTA1 = $CONEXION -> query("SELECT * FROM cursos WHERE id = $id");
$row_CONSULTA1 = $CONSULTA1 -> fetch_assoc();
$nombre_curso = strtolower($row_CONSULTA1['tituloes']);
$id_curso = strtolower($row_CONSULTA1['id']);
// Resume los nombres de los cursos dependiendo el id
$nombre_curso_f = $row_CONSULTA1['titulo_gafet'];
/*switch($id_curso)
{
    case 23:
        $nombre_curso_f = "Básico Instructor";
    break;
    case 16:
        $nombre_curso_f = "Avanzado Instructor";
    break;
    case 17:
        $nombre_curso_f = "Indagación Instructor";
    break;
    case 25:
        $nombre_curso_f = "Manifestación Instructor";
    break;
    case 26:
        $nombre_curso_f = "Creciendo 1 Practicante";
    break;
    case 27:
        $nombre_curso_f = "Creciento 1 Instructor";
    break;
    case 21:
        $nombre_curso_f = "Dios y tú Practicante";
    break;
    case 21:
        $nombre_curso_f = "Dios y tú Instructor";
    break;
}
*/
$CONSULTA2 = $CONEXION -> query("SELECT * FROM cursoasientos WHERE curso = $id AND usuario IS NOT NULL");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title><?php echo 'gafets_' . $nombre_curso_f .'_' . date("d_m_Y-g_i_a") . '.pdf' ?></title>
        <meta charset="UTF-8">
    </head>
    <body>
<?php
$i = 0;
while ($row_CONSULTA2 = $CONSULTA2 -> fetch_assoc()) {
    $uid=$row_CONSULTA2['usuario'];

    $CONSULTA3 = $CONEXION -> query("SELECT * FROM usuarios WHERE id = $uid");
    $row_CONSULTA3 = $CONSULTA3 -> fetch_assoc();
    $nombre_gafet = strtolower(html_entity_decode($row_CONSULTA3['gafet']));
    $apellido = strtolower(html_entity_decode($row_CONSULTA3['apellido']));
    $asiento = $row_CONSULTA2['asiento'];
    $apellidos = explode(" ", $apellido);
    $nombres_gafet = explode(" ", $nombre_gafet);
    $traductor = html_entity_decode($row_CONSULTA2['traductor']);
    $material = html_entity_decode($row_CONSULTA2['material']);

    // Quita los elementos basura y convierte las entidades html en carácteres normales (esto último solo pasa con el nombre del gafet).
    $nombres_gafet_aux = array();
    for($j = 0; $j < count($nombres_gafet); $j++)
    {
        if (!empty(trim($nombres_gafet[$j])))
            $nombres_gafet_aux[] = html_entity_decode(trim($nombres_gafet[$j]));
    }
    $nombres_gafet = $nombres_gafet_aux;

    // Quitamos el apellido del nombre del gafet en caso de tenerlo.
    $nombres_gafet_nuevo = $nombres_gafet;
    for($j = 0; $j < count($nombres_gafet); $j++)
    {
        foreach ($apellidos as $_apellido)
        {
            if ($nombres_gafet[$j] == $_apellido)
            {
                $index_nuevo = array_search($_apellido, $nombres_gafet_nuevo);
                if ($index_nuevo !== false)
                    unset($nombres_gafet_nuevo[$index_nuevo]);
            }
        }
    }
    // Quita los elementos que quedaron nulos ya que unset no hace bien su trabajo, remueve el elemento pero no elimina el espacio de la memoria del array.
    $nombres_gafet_nuevo_aux = array();
    foreach($nombres_gafet_nuevo as $nombre)
    {
        if (!empty($nombre))
            $nombres_gafet_nuevo_aux[] = $nombre;
    }
    $nombres_gafet_nuevo = $nombres_gafet_nuevo_aux;

    // Obtiene el nombre semi formateado para el gafet.
    $nombre_gafet_f = strtoupper(implode(' ', $nombres_gafet_nuevo));
   
    // Si uno de los nombres supera los 10 carácteres, todo el nombre se dejará en tamaño chico.
    $maxlen = 0;
    for($j = 0; $j < count($nombres_gafet_nuevo); $j++)
    {
        $nombre = $nombres_gafet_nuevo[$j];
        $len = mb_strlen($nombre); // mb_length lee en formato de codificación la cuál desconozco ya que si los carácteres tienen acento cuentan por dos, ej. strlen("iván") = 5... 
        if ($len > $maxlen)
            $maxlen = $len;
    }
    
    // Si hay un nombre, el tamaño de la letra se deja grande, si hay dos nombres, el tamaño en mediano y si hay 3 en chico.
    if ($maxlen > 10)
        $nombre_gafet_f = "<span class='nombre-gafet-chico'>" . $nombre_gafet_f . "</span>";
    else if (count($nombres_gafet_nuevo) <= 1)
        $nombre_gafet_f = "<span class='nombre-gafet-grande'>" . $nombre_gafet_f . "</span>";
    else if (count($nombres_gafet_nuevo) <= 2)
        $nombre_gafet_f = "<span class='nombre-gafet-mediano'>" . $nombre_gafet_f . "</span>";
    else
        $nombre_gafet_f = "<span class='nombre-gafet-chico'>" . $nombre_gafet_f . "</span>";
?>
    <?php if($i % GAFETS_POR_PAGINA == 0): ?>
        <?php if($i > 0): ?>
            </tr>
        </table>
        <hr />
        <?php endif; ?>
        <table class="plantilla">
    <?php endif; ?>

    <?php if($i % GAFETS_POR_FILA == 0): ?>
        <?php if($i > 0 && $i % GAFETS_POR_PAGINA != 0): ?>
            </tr>
        <?php endif; ?>
            <tr>
    <?php endif; ?>

                <td class="gafet-container" style="<?php echo $i % 2 == 0 ? '' : 'padding-left: 4.2mm;' ?>">
                   <!-- <div class="gafet" style="background-color: <?php $x = $i % 3; echo $x == 0 ? '#ddd' : ($x == 1 ? '#bbb' : '#999') ?>">
                       --><div class="gafet"> <div class="nombre-gafet">
                            <?php echo $nombre_gafet_f ?> 
                            <br />
                            <span class="apellido">
                                <?php echo ucwords($apellido) ?>
                            </span>
                        </div>
                        <div class="detalles">
                            <div class="idiomas">
                                Audio: <?php echo $traductor ? $traductor : 'No' ?>
                                <br />
                                Manual: <?php echo $material ? $material : 'Indefinido' ?>
                            </div>
                            <div class="asiento"><?php echo $asiento ? $asiento : 'N/A' ?> - <?php echo $nombre_curso_f ?></div>
                        </div>
                        <!--<div class="gafet-pie">-->
                            <!--<div class="gafet-pie-texto">www.viannainmexico.com</div><img src="logo-gafet.jpg" class="gafet-pie-logo"></img>
                            -->
                            <div class="gafet-pie-franja"><img src="gafet-pie-franja.jpg" /></div>
                        <!--</div>-->
                    </div>
                </td>
    <?php
        $i++;
    }
    ?>
    <?php if($i % GAFETS_POR_FILA != 0): ?>
        <td></td>
    <?php endif; ?>
            </tr>
        </table>


    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
        }
        @page {
            margin: 0;
        }
        html {
            margin-top: 13.5mm;/*14mm;*/
            margin-left: 3.2mm:/*3.4mm; este quedo casi perfecto *//*3.9mm;*/ /* 2.9mm;*/
        }
        body {
            font-family: Helvetica;
        }
        hr {
            page-break-after: always;
            border: 0;
            margin: 0;
            padding: 0;
        }
        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
        }
        .plantilla {
            width: 207.4mm; /* 106.1mm de ancho por etiqueta + 4.2mm (4mm este quedo casi perfecto) del margen entre las etiquetas */
            max-width: 207.4mm;
            height: 254mm; /* 50.8mm por las 5 etiquetas verticales */
            max-height: 254mm;
            /*margin: auto;*/
            vertical-align: top;
        }
        .gafet-container {
            vertical-align: top; /* para que no quede espacio superior si la plantilla no tiene todas las etiquetas */
        }
        .gafet {
            text-align: center;
            width: 101.6mm;
            max-width: 101.6mm;
            height: 50.8mm;
            max-height: 50.8mm;
        }
        .nombre-gafet {   
            word-wrap: break-word;
            text-transform: uppercase;
            height: 24.3mm; /* 29.8mm sin idiomas */
            padding-top: 8mm;
        }
        .nombre-gafet-grande {
            font-size: 40pt;
            line-height: 38pt;
            font-weight: bold;
        }
        .nombre-gafet-mediano {
            font-size: 34pt;
            line-height: 32pt;
            font-weight: bold;
        }
        .nombre-gafet-chico {
            font-size: 28pt;
            line-height: 26pt;
            font-weight: bold;
        }
        .apellido {
            font-size: 20pt;
            line-height: 16pt;
        }
        .detalles {
            font-size: 12pt;
            /*background: white;*/
            color: black;
            height: 10.5mm; /* 5mm sin idiomas */
        }
        .idiomas {
            text-align: left;
            font-size: 9pt;
            line-height: 1;
            height: 5.75mm;
        }
        .asiento {
            text-align: center;
            height: 4.75mm;
        }
        .gafet-pie { /* ESTILO DESCARTADO */
            font-size: 10.5pt;
            height: 18.5mm; /* 13mm sin idiomas */
            text-align: left;
            background: #7b1fa2;
            color: white;
        }/*
        .gafet-pie-logo {
            height: 8mm;
            display: block;
            float: right;
            margin-top: -0.2mm;
            margin-right: 0mm;
        }
        .gafet-pie-texto {
            margin-left: 3mm;
            display: inline;
            line-height: 7mm;
        }*/
        .gafet-pie-franja {
            height: 8mm;
            /*background-image: url('gafet-pie-franja.jpg');*/
        }
        .gafet-pie-franja img {
            height: 100%;
            width: 100%;
        }
    </style>

    </body>
</html>