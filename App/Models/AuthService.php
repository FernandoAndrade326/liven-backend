<?php

    use Firebase\JWT\JWT;
    use App\Core\Model;

    class AuthService{
        public function login($username, $password){

            $sql = "SELECT * FROM user WHERE username = ?";
            $stmt = Model::getConn()->prepare($sql);
            $stmt->bindValue(1, $username);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user){
                // Verifica se a senha fornecida corresponde à senha criptografada armazenada
                if(password_verify($password, $user['password'])){
                    // Dados do token
                    $tokenData = [
                        'user_id' => $user['id'],
                        'username' => $user['username'],
                        // Você pode adicionar mais dados relevantes ao token, se necessário
                    ];

                    $algorithm = 'HS256';

                    // Gera o token JWT
                    $jwt = JWT::encode($tokenData, SECRET_KEY, $algorithm); 
                    // Retorna o token JWT
                    return $jwt;
                } else {
                    return false; // Senha incorreta
                }
            } else {
                return null; // Usuário não encontrado
            }
        }

        

    }
?>