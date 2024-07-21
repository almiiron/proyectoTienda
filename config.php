<?php
$folderPath = dirname($_SERVER['SCRIPT_NAME']);
$urlPath = $_SERVER['REQUEST_URI'];
$url = substr($urlPath, strlen($folderPath));

define('URL', $url);

// Obtener el número de página si está presente en la URL
$numPage = null;
$urlSegments = explode('/', $url);
if (count($urlSegments) >= 4) { // Si hay al menos 4 segmentos en la URL
    $numPage = intval(end($urlSegments)); // El número de página es el último segmento
}

define('NUM_PAGE', $numPage); // Define la constante NUM_PAGE con el número de página

define('IP_HOST', '192.168.100.10');
// define('IP_HOST', 'localhost');
?>
