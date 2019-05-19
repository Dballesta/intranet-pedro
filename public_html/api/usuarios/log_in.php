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


// Instanciación de la BBDD
$database = new Database();
$db = $database->getConnection();


// Instanciacion de los cursos
$usuario = new Usuarios($db);

foreach ($_POST as $key => $value) {
    echo "Key: $key; Value: $value\n";
}
$usuario->dni = isset($_POST['dni']) ? $_POST['dni'] : die();

$usuario->password = base64_encode(isset($_POST['password']) ? $_POST['password'] : die());

echo $usuario->password;

$stmt = $usuario->login();
echo $stmt->rowCount();
if($stmt->rowCount() > 0){
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $usuario->nombre = $row['nombre'];
    $usuario->apellidos = $row['apellidos'];
    $usuario->privilegios = $row['privilegios'];

    $jwt = Jwt::generateJWT($usuario);
    setcookie("JWT", $jwt, time()+31536000);
    http_response_code(200);
    echo json_encode(array("message" => "Acceso permitido"));

}else{
    //https://developer.mozilla.org/es/docs/Web/HTTP/Status/401
    http_response_code(401);

    //Mensaje de error de login
    echo json_encode(array("message" => "Acceso denegado"));
}