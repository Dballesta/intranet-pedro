<?php
include_once __DIR__ . '/../model/Usuarios.php';
include_once __DIR__ . '/../config/settings.php';

//https://rbrt.wllr.info/2018/01/29/how-create-json-web-token-php.html
class Jwt
{
    public static function generateJWT(Usuarios $usuario)
    {

        // Creación de la cabecera del token como una cadena JSON
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        // Creación del token de carga como una cadena Json
        //https://es.wikipedia.org/wiki/JSON_Web_Token
        $payload = json_encode([
            'dni' => $usuario->dni,
            'nombre' => $usuario->nombre,
            'apellidos' => $usuario->apellidos,
            'privilegios' => $usuario->privilegios,
            'iat' => time(),
            'exp' => strtotime('+365 day')
        ]);

        // Codificación de la cabecera a base64
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

        // Codificación de la carga a base64
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        // Creación de la Firma Hasheadah.
        $signature = hash_hmac(ALGORITHM, $base64UrlHeader . "." . $base64UrlPayload, JWTPASSWORD, true);

        // Codificación a base 64 de la firma
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        // Creación del JSON WEB TOKEN
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        return $jwt;

    }

    public static function verifyJWT($recievedJwt)
    {

        // Separación del token a a partir de los puntos
        $jwtValues = explode('.', $recievedJwt);

        // Extracción de la firma del JWT spliteado previamente
        $recievedSignature = $jwtValues[2];

        // Concatenación de la cabecera y la carga
        $recievedHeaderAndPayload = $jwtValues[0] . '.' . $jwtValues[1];

        // Creación de una nueva firma con la cabecera y carga concatenadas previamente para comprobar posteriormente si son iguales a las recibidas
        $resultedSignature = base64_encode(hash_hmac(ALGORITHM, $recievedHeaderAndPayload, JWTPASSWORD, true));

        // Comprobar si la firma creada en el método y la recibida son iguales. Si son iguales se devolverá true, si no false
        if ($resultedSignature == $recievedSignature) {
            return true;
        }
        return false;
    }

    public static function verifyJWTAdmin($recievedJwt)
    {
        if (self::verifyJWT($recievedJwt)) {
            // Separación del token a a partir de los puntos
            $jwt_values = explode('.', $recievedJwt);

            // Extracción de la firma del JWT spliteado previamente
            $decodedPayload = json_decode(base64_decode($jwt_values[1]), true);

            if ($decodedPayload['privilegios'] > 0) {
                return true;
            }
            return false;
        }
        return false;
    }


}