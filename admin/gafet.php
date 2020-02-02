<?php
    header("Content-type:application/pdf");
    //header("Content-type:text/plain");
    
    ob_start();
    include(dirname(__FILE__).'/pdf-source.php');
    $content = ob_get_clean();

    /*echo $content;
    exit;*/

    if($dominio=='localhost'){
        require_once(dirname(__FILE__).'/../library/composer/vendor/autoload.php');
    }else{
        require_once(dirname(__FILE__).'/../library/composer/vendor/autoload.php');
    }
    use Dompdf\Dompdf;

/*
    $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0), false);
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('ficha.pdf');*/

    $dompdf = new Dompdf();
    $dompdf->setPaper('letter', 'portrait');
    $dompdf->set_option('enable_css_float', true);
    $dompdf->set_option('enable_html5_parser', true);
    $dompdf->set_option('enable_remote', true);        
    $dompdf->loadHtml($content);
    $dompdf->render();
    $filename = 'gafets_' . $nombre_curso_f .'_' . date("d_m_Y-g_i_a") . '.pdf';
    $pdf = $dompdf->output();
    echo $pdf;
