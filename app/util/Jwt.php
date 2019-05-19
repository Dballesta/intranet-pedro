<?php
include_once __DIR__.'/../model/Usuarios.php';
include_once __DIR__.'/../config/settings.php';

//https://rbrt.wllr.info/2018/01/29/how-create-json-web-token-php.html
class Jwt
{
    public static function generateJWT(Usuarios $usuario)
    {

        // Create token header as a JSON string
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        // Create token payload as a JSON string
        //https://es.wikipedia.org/wiki/JSON_Web_Token
        $payload = json_encode([
            'dni' => $usuario->dni,
            'nombre' => $usuario->nombre,
            'apellidos' => $usuario->apellidos,
            'privilegios' => $usuario->privilegios,
            'iat' => time(),
            'exp' => strtotime('+1 day')
        ]);

        // Encode Header to Base64Url String
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

        // Encode Payload to Base64Url String
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        // Create Signature Hash
        echo JWTPASSWORD;
        $signature = hash_hmac(ALGORITHM, $base64UrlHeader . "." . $base64UrlPayload, JWTPASSWORD, true);

        // Encode Signature to Base64Url String
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        // Create JWT
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        return $jwt;

    }

    public static function verifyJWT($recievedJwt)
    {

        // Split a string by '.'
        $jwt_values = explode('.', $recievedJwt);

        // extracting the signature from the original JWT
        $recieved_signature = $jwt_values[2];

        // concatenating the first two arguments of the $jwt_values array, representing the header and the payload
        $recievedHeaderAndPayload = $jwt_values[0] . '.' . $jwt_values[1];

        // creating the Base 64 encoded new signature generated by applying the HMAC method to the concatenated header and payload values
        $resultedsignature = base64_encode(hash_hmac(ALGORITHM, $recievedHeaderAndPayload, JWTPASSWORD, true));

        // checking if the created signature is equal to the received signature
        if ($resultedsignature == $recieved_signature)
        {
            // If everything worked fine, if the signature is ok and the payload was not modified you should get a success message
            return true;
        }
        return false;
    }

}