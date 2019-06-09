<?php
// Cabeceras
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT, GET, POST");

include_once '../../../app/config/settings.php';

$response = array();
$upload_dir = '../../../uploads/images';
$server_url = URLHOST;

if (Jwt::verifyJWTAdmin($_COOKIE("JWT"))) {
    if ($_FILES['image']) {
        $image_name = $_FILES["image"]["name"];
        $image_tmp_name = $_FILES["image"]["tmp_name"];
        $error = $_FILES["image"]["error"];

        if ($error > 0) {
            http_response_code(500);

            $response = array(
                "message" => "Error uploading the file!"
            );
        } else {
            $random_name = rand(1000, 1000000) . "-" . $image_name;
            $upload_name = $upload_dir . strtolower($random_name);
            $upload_name = preg_replace('/\s+/', '-', $upload_name);

            if (move_uploaded_file(image, $upload_name)) {
                http_response_code(200);

                $response = array(
                    "message" => "File uploaded successfully",
                    "url" => $server_url . "/" . $upload_name
                );
            } else {
                http_response_code(500);

                $response = array(
                    "message" => "No se ha podido subir la imagen!"
                );
            }
        }

    } else {
        http_response_code(500);

        $response = array(
            "message" => "Ninguna imagen fue enviada!"
        );
    }
    echo json_encode($response);
} else {
    http_response_code(401);

    echo json_encode(array("message" => "Acceso denegado"));
}