<?php
// Cabeceras
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");

include_once '../../../app/config/Database.php';
include_once '../../../app/model/Cursos.php';

if (Jwt::verifyJWTAdmin($_COOKIE("JWT"))) {

// Instanciación de la BBDD
    $database = new Database();
    $db = $database->getConnection();

// Instanciacion de los cursos
    $curso = new Cursos($db);

// Obtención del id por get
    $curso->nombre = isset($_POST['nombre']) ? $$_POST['nombre'] : die();

    if ($curso->exists()) {
        return;
    }
// Obtención del curso
    $curso->findOne();

// Creación del array
    $cursos = array(
        'id' => $curso->id,
        'nombre' => $curso->nombre,
    );

// Generación del Json
    print_r(json_encode($cursos));

} else {
    //https://developer.mozilla.org/es/docs/Web/HTTP/Status/401
    http_response_code(401);

    //Mensaje de error de login
    echo json_encode(array("message" => "Acceso denegado"));
}