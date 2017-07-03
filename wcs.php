<?php
/********************************************************************************
 * Curso 8: Infraestructura de datos espaciales y mapas interactivos en línea
 * Año: 2017
 * Autor: Banchero, Santiago 
 * Versión: 0.1
 * 
 ********************************************************************************/

// define variables and set to empty values
$urlrequest = "";
if (isset($_POST["urlrequest"])) {
  $urlrequest = $_POST["urlrequest"];
}

// Ejemplo para Capabilities
function get_capabilities($url){
  if(strpos(strtolower($url), 'getcapabilities') !== false){ // Verificar si la url es de un request GetCapabilities
  
    $dom = new DOMDocument;
    $dom->preserveWhiteSpace = FALSE;
    $dom->loadXML(file_get_contents($url));
    $dom->formatOutput = TRUE;
    
    return 'GetCapabilities:<pre><code class="XML">'.htmlspecialchars($dom->saveXml()).'</code></pre>';
  }else{
    return '';
  }
}

// Ejemplo para DescribeCoverage
function get_describecoverage($url){
  if(strpos(strtolower($url), 'describecoverage') !== false){ // Verificar si la url es de un request DescribeCoverage
    $dom = new DOMDocument;
    $dom->preserveWhiteSpace = FALSE;
    $dom->loadXML(file_get_contents($url));
    $dom->formatOutput = TRUE;
    
    return 'GetCapabilities:<pre><code class="XML">'.htmlspecialchars($dom->saveXml()).'</code></pre>';
  }else{
    return '';
  }
}

// Ejemplo para GetCoverage
function get_coverage($url){
  if(strpos(strtolower($url), 'getcoverage') !== false){ // Verificar si la url es de un request GetCoverage
    return '<div id="result-legend">GetCoverage: <textarea rows="10" cols="100" name="urlrequest" >'.file_get_contents($url).'</textarea></div>';
  }else{
    return '';
  }
}

// Parseo de la URL para mostrar los parámetros
$query_str = parse_url($urlrequest, PHP_URL_QUERY);
parse_str($query_str, $query_params);

?>

<!DOCTYPE html>
<html>
  <head>
    <link type='text/css' rel='stylesheet' href='style.css'/>
    <title>UADER - Curso 8: Web Coverage Service (WCS)</title>
    <link rel="stylesheet" href="/highlight/styles/default.css">
    <script src="/highlight/highlight.pack.js"></script>
    <script src="/highlight/jquery-3.2.1.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
  </head>
  <body>
    <a href="/"><img src="maestria-01p.jpg"/></a>
    <div class="header"><h1>
      <?php
      $bienvenido = "Web Coverage Service (WCS)";
      echo $bienvenido;
      ?>
    </h1></div>
    <form action="/wcs.php" id="usrform" method="POST">
    <input type="submit">
    </form>
    URL Request
    <textarea rows="4" cols="50" name="urlrequest" form="usrform"><?php echo $urlrequest; ?></textarea>
    <div class="result">URL: <b><?php echo $urlrequest; ?></b></div>
    <div id="result-p">Par&aacute;metros: <ul><?php foreach($query_params as $parametro => $valor){echo '<li><b>'.$parametro.'</b>: '.$valor.'</li>';}; ?></ul></div>
    <?php echo get_coverage($urlrequest); ?>
    <?php echo get_capabilities($urlrequest); ?>
    <?php echo get_describecoverage($urlrequest); ?>
  </body>
</html> 
