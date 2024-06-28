<?php

namespace App\Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class AuthMiddleware {

    public static function authenticate() {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            list($jwt) = sscanf($authHeader, 'Bearer %s');

            if ($jwt) {
                try {
                    $decoded = JWT::decode($jwt, new Key(SECRET_KEY, 'HS256'));
                    return $decoded; // Retorna os dados decodificados se o token for válido
                } catch (Exception $e) {
                    http_response_code(401);
                    echo json_encode(["Erro: " => "Acesso não autorizado. Token inválido!"]);
                    exit;
                }
            }
        }

        http_response_code(401);
        echo json_encode(["Erro: " => "Acesso não autorizado. Nenhum token fornecido!"]);
        exit;
    }
}
