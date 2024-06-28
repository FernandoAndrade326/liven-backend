<?php

    use Firebase\JWT\JWT;
    use App\Core\Model;

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
                    var_dump($tokenData);
                    // Retorna o token JWT
                    return $jwt;
                } else {
                    return false; // Senha incorreta
                }
            } else{
                return [];
            }
        }
    }
?>