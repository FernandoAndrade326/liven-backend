<?php

namespace App\Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class AuthMiddleware
{

    public static function authenticate()
    {
        $headers = getallheaders(); //recupera todos os headers da req
        if (isset($headers['Authorization'])) { //verifica se há, no array retornado valor na chave auth
            $authHeader = $headers['Authorization']; //coloca o valor na variavel
            list($jwt) = sscanf($authHeader, 'Bearer %s'); //a funcao sscanf le o valor de %s, apos o bearer e coloca o valor do array ma varivavel jwt pela funcao list

            if ($jwt) {//caso houver jwt
                try {
                    $decoded = JWT::decode($jwt, new Key(SECRET_KEY, 'HS256'));//decodifica o token, com base na secret key e criptografia utilizada
                    return $decoded; // Retorna os dados decodificados se o token for válido
                } catch (Exception $e) {
                    http_response_code(401); //caso o token nao for compativel com o id da solicitacao
                    echo json_encode(["Erro: " => "Acesso não autorizado. Token inválido!"]);
                    exit;
                }
            }
        }

        http_response_code(401); //caso nao houver token na req.
        echo json_encode(["Erro: " => "Acesso não autorizado. Nenhum token fornecido!"]);
        exit;
    }
}
