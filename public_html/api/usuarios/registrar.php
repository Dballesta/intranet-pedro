<?php
// Cabeceras
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../../app/config/Database.php';
include_once '../../../app/config/settings.php';
include_once '../../../app/model/Usuarios.php';
include_once '../../../app/util/Jwt.php';


$database = new Database();
$db = $database->getConnection();

$usuario = new Usuarios($db);

$usuario->dni = $_POST['dni'];
$usuario->nombre = $_POST['nombre'];
$usuario->apellidos = $_POST['apellidos'];
$usuario->password = base64_encode($_POST['password']);
$usuario->privilegios = $_POST['privilegios'];

if($usuario->signup()){
    http_response_code(201);
    $usuario_arr=array(
        "message" => "Registrado Correctamente",
        "dni" => $usuario->dni,
        "nombre" => $usuario->nombre
    );
}
else{
    http_response_code(409);
    $usuario_arr=array(
        "message" => "El usuario ya existe!"
    );
}
print_r(json_encode($$usuario_arr));