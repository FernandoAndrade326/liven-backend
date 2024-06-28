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

                    
                    define('SECRET_KEY', 'Teste_Liven_Secret_Sample_OK');
                    //Não é uma boa prática e deve ser aleatória,
                    //mas por limitações de ambiente, e proposito didatico, coloquei aqui
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