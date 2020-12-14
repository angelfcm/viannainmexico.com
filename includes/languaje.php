<?php

  $languaje = isset($_GET['languaje']) ? $_GET['languaje'] : 'es';

  $SITELANGUAJE = $CONEXION -> query("SELECT $languaje,variable FROM traduccion");
  while($rowSITELANGUAJE = $SITELANGUAJE -> fetch_assoc()){
    //$$rowSITELANGUAJE['variable']=$rowSITELANGUAJE[$languaje]; // PHP <=5
    ${$rowSITELANGUAJE['variable']}=$rowSITELANGUAJE[$languaje]; // PHP >5
  }
  mysqli_free_result($SITELANGUAJE);

  $courseTypeLangs = [
    COURSE_TYPE_FACE_TO_FACE => $courseFaceToFace,
    COURSE_TYPE_ONLINE => $courseOnline,
  ];
