<?php
// Cabeceras
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");

include_once '../../../app/config/Database.php';
include_once '../../../app/model/Cursos.php';

// Instanciación de la BBDD
$database = new Database();
$db = $database->getConnection();

// Instanciacion de los cursos
$curso = new Cursos($db);

// Obtención del id por get
$curso->nombre = isset($_GET['nombre']) ? $_GET['nombre'] : die();

// Obtención del curso
$curso->findOne();

// Creación del array
$cursos = array(
    'id' => $curso->id,
    'nombre' => $curso->nombre,
);

// Generación del Json
print_r(json_encode($cursos));