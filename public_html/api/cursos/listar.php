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

// Obtención del curso
$stmt = $curso->findAll();
$num = $stmt->rowCount();

if ($num > 0) {
    $cursos_arr = array();
    $cursos_arr["cursos"] = array();
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $cursos_item = array(
            "id" => $row['id'],
            "nombre" => $row['nombre']
        );
    }

    echo json_encode($cursos_arr["cursos"]);
} else {
    echo json_encode(array());
}