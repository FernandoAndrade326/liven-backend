<?php

    use Firebase\JWT\JWT;
    use App\Core\Model;
use Firebase\JWT\Key;

    class AuthService{

        public function login($username, $password){
            $sql = "SELECT * FROM user WHERE username = ?";

            $stmt = Model::getConn()->prepare($sql);
            $stmt->bindValue(1, $username);
            $stmt->execute();

            if($stmt->rowCount()>0){
                $result = $stmt->fetch(PDO::FETCH_OBJ);
                
                if(password_verify($password, $result->password)){
                $tokenData = [
                    'user_id' => $result->id,
                    'username' => $result->username,
                    // Você pode adicionar mais dados relevantes ao token, se necessário
                ];

                $algorithm = 'HS256';

                $jwt = JWT::encode($tokenData, SECRET_KEY, $algorithm);
                
                    // Retorna o token JWT
                    return $jwt;
                } else {
                    return false; // Senha incorreta
                }
            } else{
                return [];
            }
        }

        public static function getTokenData() {
            $headers = apache_request_headers();
            if (isset($headers['Authorization'])) {
                $matches = [];
                preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches);
                if (isset($matches[1])) {
                    $jwt = $matches[1];
                    try {
                        $decoded = JWT::decode($jwt, new Key(SECRET_KEY, 'HS256'));
                        return [
                            'user_id' => $decoded->user_id,
                            'username' => $decoded->username
                        ];
                    } catch (Exception $e) {
                        http_response_code(401);
                        echo json_encode(["Mensagem" => "Acesso negado!", "error" => $e->getMessage()]);
                        exit;
                    }
                }
            }
            http_response_code(401);
            echo json_encode(["Mensagem" => "Acesso negado!"]);
            exit;
        }
    }
?>