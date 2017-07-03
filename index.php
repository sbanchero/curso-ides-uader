<?php
/********************************************************************************
 * Curso 8: Infraestructura de datos espaciales y mapas interactivos en línea
 * Año: 2017
 * Autor: Banchero, Santiago 
 * Versión: 0.1
 * 
 ********************************************************************************/
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link type='text/css' rel='stylesheet' href='style.css'/>
    <title>UADER - Web Map Service (WMS)</title>
  </head>
  <body>
    <a href="/"><img src="https://maestriageomaticadotorg.files.wordpress.com/2014/04/maestria-01p.jpg"/></a>
    <div class="header"><h1>
      <?php
      $bienvenido = "Servicios de interoperabilidad";
      echo $bienvenido;
      ?>
    </h1></div>
    <ul>
        <li>Web Map Service (<a href="wms.php">WMS</a>)</li>
        <li>Web Feature Service (<a href="wfs.php">WFS</a>)</li>
        <li>Web Coverage Service (<a href="wcs.php">WCS</a>)</li>
        <li>Request para el TP 2(<a href="tp2_requests.html" target="_blank">ir</a>)</li>
    </ul>
    
  </body>
</html> 
