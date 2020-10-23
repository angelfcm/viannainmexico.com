<?php
  $languaje =$_GET['languaje'];

  $SITELANGUAJE = $CONEXION -> query("SELECT $languaje,variable FROM traduccion");
  while($rowSITELANGUAJE = $SITELANGUAJE -> fetch_assoc()){
    //$$rowSITELANGUAJE['variable']=$rowSITELANGUAJE[$languaje]; // PHP <=5
    ${$rowSITELANGUAJE['variable']}=$rowSITELANGUAJE[$languaje]; // PHP >5
  }
  mysqli_free_result($SITELANGUAJE);
