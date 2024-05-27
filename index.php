<?php
session_start();
require_once(__DIR__. '/config.php');
require_once(__DIR__. '/router.php');

require_once('./models/classConexion.php');
$conexion = new Conexion();
$conexion->obtenerConexion();

$numPage = NUM_PAGE; // Obtener el número de página de config.php

$router = new Router($conexion, $numPage); // Pasar $conexion y $numPage al constructor de Router
$router->run();
?>
