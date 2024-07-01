<?php

use Firebase\JWT\JWT;
use App\Core\Model;
use Firebase\JWT\Key;

class AuthService
{

    public function login($username, $password)
    {
        $sql = "SELECT * FROM user WHERE username = ?"; //select simples do usuario com parm id

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_OBJ); //recupera o resultado

            if (password_verify($password, $result->password)) { //verifica se senhas conferem
                $tokenData = [ //caso sim, gera o array TokenData
                    'user_id' => $result->id,
                    'username' => $result->username,
                    //por enquanto, o nosso token armazena apenas id e nome de usuario
                ];

                $algorithm = 'HS256'; //seta o algoritmo utilizado

                $jwt = JWT::encode($tokenData, SECRET_KEY, $algorithm); //gera o jwt, com as informações que queremos, a nossa secret_key e o algoritimo setado

                // Retorna o token JWT pronto
                return $jwt;
            } else {
                return false; // caso senha incorreta
            }
        } else {
            return [];
        }
    }

    public static function getTokenData()//metodo para recuperar dados do usario pelo token
    {
        $headers = apache_request_headers(); //pega todos os cabeçalhos e armazena
        if (isset($headers['Authorization'])) {//se a chave authrozation existir
            $matches = [];
            preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches); //compara se o que ha em auth, segue o padrao que deveria, e armazena em matches o array do token 
            if (isset($matches[1])) { //mathces na posicao 1 é o token apos o Bearer
                $jwt = $matches[1]; //caso houver, jwt recebe o conteudo 
                try {
                    $decoded = JWT::decode($jwt, new Key(SECRET_KEY, 'HS256'));
                    //decodifica o token do header, utilizando os mesmos padroes para criação
                    return [
                        'user_id' => $decoded->user_id,
                        'username' => $decoded->username //retorna os dados lá do tokenData
                    ];
                } catch (Exception $e) { //trata o erro caso nao houver cabreçalho
                    http_response_code(401);
                    echo json_encode(["message" => "Acesso negado!", "error" => $e->getMessage()]);
                    exit;
                }
            }
        }
        http_response_code(401);
        echo json_encode(["message" => "Acesso negado!"]);
        exit;
    }
}
