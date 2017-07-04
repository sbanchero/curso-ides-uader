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

if($urlrequest != ""){
  // Parseo de la URL para mostrar los parámetros
  $query_str = parse_url($urlrequest, PHP_URL_QUERY);
  parse_str($query_str, $query_params);
  //print_r(array_search('text/plain', $query_params));
}

// Ejemplo para GetMap
function get_map($url){
  $query_str = parse_url($url, PHP_URL_QUERY);
  parse_str($query_str, $query_params);
  if(strpos(strtolower($url), 'getmap') !== false){ // Verificar si la url es de un request getMap
    if(strpos(strtolower($query_params['FORMAT']),'openlayers') == true){
        return '<div id="result-getmap">GetMap:  <iframe src="' . $url . '" width="800px" height="500px" ></iframe></div>';
    }elseif(strpos(strtolower($query_params['FORMAT']),'geotiff') == true){
        return '<div id="result-getmap">GetMap:  <a href="' . $url . '">Descargar</a></iframe></iframe></div>';
    }else{
        return '<div id="result-getmap">GetMap: <img id="result-getmap" src="' . $url . '" width="'.intval($query_params["WIDTH"]*0.5).'px" height="'.intval($query_params["HEIGHT"]*0.5).'px" /></div>';
    }
  }else{
    return '';
  }
}

// Ejemplo para GetLegendGraphic
function get_legend_graphic($url){
  if(strpos(strtolower($url), 'getlegendgraphic') !== false){ // Verificar si la url es de un request getMap
    return '<div id="result-legend">GetLegendGraphic: <img src="' . $url . '" /></div>';
  }else{
    return '';
  }
}

// Ejemplo para GetCapabilities
function get_capabilities($url){
  if(strpos(strtolower($url), 'getcapabilities') !== false){ // Verificar si la url es de un request getMap
    return '<div id="result-legend">GetCapabilities: <textarea rows="10" cols="100" name="urlrequest" >'.file_get_contents($url).'</textarea></div>';
    
  }else{
    return '';
  }
}

// Ejemplo para GetFeatureInfo
function get_featureinfo($url){
  $query_str = parse_url($url, PHP_URL_QUERY);
  parse_str($query_str, $query_params);
  
  if(strpos(strtolower($url), 'getfeatureinfo') !== false){ // Verificar si la url es de un request getMap
    $str_response = file_get_contents($url);
    if(strpos(strtolower($query_params['INFO_FORMAT']),'plain') == true){
        $str_response = nl2br($str_response);
      }
    return '<div id="result-legend">GetFeatureInfo: '.$str_response.'</div>';
  }else{
    return '';
  }

}

// Ejemplo para DescribeLayer
function get_describelayer($url){
  if(strpos(strtolower($url), 'describelayer') !== false){ // Verificar si la url es de un request getMap
    return '<div id="result-legend">DescribeLayer: <textarea rows="10" cols="100" name="urlrequest" >'.file_get_contents($url).'</textarea></div>';
  }else{
    return '';
  }
}



// GetLegendGraphic
// http://geointa.inta.gov.ar/geoserver/wms?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=20&HEIGHT=20&LAYER=eeapara:IpEMz&service=WMS&legend_options=fontName:Times%20New%20Roman;fontAntiAliasing:true;fontColor:0x000033;fontSize:14;bgColor:0xFFFFEE;dpi:180

// GetFeatureInfo
// http://geointa.inta.gov.ar/geoparana/wms?SERVICE=WMS&VERSION=1.1.1&REQUEST=GetFeatureInfo&FORMAT=image%2Fpng&TRANSPARENT=true&QUERY_LAYERS=suelos%3Acarta_suelos_er&LAYERS=suelos%3Acarta_suelos_er&TILED=true&SRS=EPSG%3A3857&STYLES=cartas_suelos&INFO_FORMAT=application%2Fjson&X=22&Y=141&WIDTH=256&HEIGHT=256&BBOX=-6687322.7306135%2C-3820628.42180625%2C-6682430.760803249%2C-3815736.4519959986
// http://wms.ign.gob.ar/geoserver/ideign/wms?SERVICE=WMS&VERSION=1.1.1&REQUEST=GetFeatureInfo&FORMAT=image%2Fpng&TRANSPARENT=true&QUERY_LAYERS=ideign%3ADEPARTAMENTOS&LAYERS=ideign%3ADEPARTAMENTOS&STYLES&INFO_FORMAT=text%2Fhtml&FEATURE_COUNT=50&X=50&Y=50&SRS=EPSG%3A4326&WIDTH=101&HEIGHT=101&BBOX=-64.56939697265625%2C-36.90719604492188%2C-64.2919921875%2C-36.62979125976563

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link type='text/css' rel='stylesheet' href='style.css'/>
    <title>UADER - Curso8: Web Map Service (WMS)</title>
    <link rel="stylesheet" href="/tp2/highlight/styles/default.css">
    <script src="/tp2/highlight/highlight.pack.js"></script>
    <script src="/tp2/highlight/jquery-3.2.1.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
  </head>
  <body>
    <a href="/"><img src="/tp2/maestria-01p.jpg"/></a>
    <div class="header"><h1>
      <?php
      $bienvenido = "Curso 8: Web Map Service (WMS)";
      echo $bienvenido;
      ?>
    </h1></div>
    <form action="/tp2/wms.php" id="usrform" method="POST">
    <input type="submit">
    </form>
    URL Request
    <textarea rows="4" cols="100" name="urlrequest" form="usrform"><?php echo $urlrequest; ?></textarea>
    <div class="result">URL: <b><?php echo $urlrequest; ?></b></div>
    <div id="result-p">Par&aacute;metros: <ul><?php foreach($query_params as $parametro => $valor){echo '<li><b>'.$parametro.'</b>: '.$valor.'</li>';}; ?></ul></div>
    <?php echo get_map($urlrequest); ?>
    <?php echo get_legend_graphic($urlrequest); ?>
    <?php echo get_capabilities($urlrequest); ?>
    <?php echo get_featureinfo($urlrequest); ?>
    <?php echo get_describelayer($urlrequest); ?>
    
  </body>
</html> 
