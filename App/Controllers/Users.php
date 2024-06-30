<?php
    
    use App\Core\Controller;

    class Users extends Controller{

        public function index(){
            $authModel = $this->model("AuthService");

            $tokenData = $authModel->getTokenData();

            // Verificar se o tokenData contém os valores esperados
            if (!$tokenData || !isset($tokenData['user_id'])) {
                http_response_code(401);
                echo json_encode(["message" => "Não autorizado: Token inválido. Por favor, faça login novamente!"]);
                exit;
            }

            $user_id = $tokenData['user_id'];

            // Instanciar o modelo de usuário
            $usersModel = $this->model("User");

            // Obter dados do usuário logado
            $user = $usersModel->getById($user_id);

            // Verificar se os dados do usuário foram encontrados
            if (!$user) {
                http_response_code(404);
                echo json_encode(["message" => "Usuário não encontrado!"]);
                exit;
            }

            // Retornar dados do usuário e mensagem de sucesso
            http_response_code(200);
            echo json_encode([
                "message" => "Informações do seu cadastro.",
                "data" => $user
            ], JSON_UNESCAPED_UNICODE);
        }

        public function find($id){
            $authModel = $this->model("AuthService");

            $tokenData = $authModel->getTokenData();

            // Verificar se o tokenData contém os valores esperados
            if (!$tokenData || !isset($tokenData['user_id'])) {
                http_response_code(401);
                echo json_encode(["message" => "Não autorizado: Token inválido. Por favor, faça login novamente!"]);
                exit;
            }

            $user_id = $tokenData['user_id'];

            // Verificar se o ID passado é igual ao user_id do token
            if ($id != $user_id) {
                http_response_code(403);
                echo json_encode(["message" => "Você não tem permissão para acessar outros cadastros."]);
                exit;
            }

            // Instanciar o modelo de usuário
            $usersModel = $this->model("User");

            // Obter dados do usuário logado
            $user = $usersModel->getById($user_id);

            // Verificar se os dados do usuário foram encontrados
            if (!$user) {
                http_response_code(404);
                echo json_encode(["message" => "Usuário não encontrado!"]);
                exit;
            }

            // Retornar dados do usuário e mensagem de sucesso
            http_response_code(200);
            echo json_encode([
                "message" => "Informações do seu cadastro.",
                "data" => $user
            ], JSON_UNESCAPED_UNICODE);
        }

        public function insert(){
            $newUser = $this->getRequestBody();

            $usersModel = $this->Model("User");
            $usersModel->username = $newUser->username;
            $usersModel->password = $newUser->password;
            $usersModel->email = $newUser->email;

            $usersModel = $usersModel->insert();

            if($usersModel){
                http_response_code(201);
                echo json_encode(["Cadastro realizado com sucesso!", $usersModel]);
            } else{
                http_response_code(500);
                echo json_encode(["Erro: " =>"Não foi possível inserir o usuário!"]);
            }

        }

        public function update($id) {
            // Obter os dados do token
            $authModel = $this->model("AuthService");
        
            $tokenData = $authModel->getTokenData();
        
            // Verificar se o tokenData contém os valores esperados
            if (!$tokenData || !isset($tokenData['user_id'])) {
                http_response_code(401);
                echo json_encode(["message" => "Token inválido. Por favor, faça login novamente!"]);
                exit;
            }
        
            $user_id = $tokenData['user_id'];
        
            // Verificar se o ID passado é igual ao user_id do token
            if ($id != $user_id) {
                http_response_code(403);
                echo json_encode(["message" => "Você não tem permissão para alterar dados de outro usuário."]);
                exit;
            }
        
            // Instanciar o modelo de usuário
            $usersModel = $this->model("User");
        
            // Verificar se o usuário existe
            $user = $usersModel->getById($id);
            if (!$user) {
                http_response_code(404);
                echo json_encode(["message" => "Usuário não encontrado!"]);
                exit;
            }
        
            // Obter os dados atualizados do corpo da requisição
            $updatedUser = $this->getRequestBody();
            // Atualizar os dados do usuário
            $user->username = $updatedUser->username;
            $user->password = $updatedUser->password;
            $user->email = $updatedUser->email;
        
            // Salvar as alterações no banco de dados
            $result = $usersModel->update($id, $user);
        
            if ($result) {
                // Retornar uma resposta de sucesso
                http_response_code(200);
                echo json_encode([
                    "message" => "Dados do usuário atualizados com sucesso.",
                    "data" => $user
                ], JSON_UNESCAPED_UNICODE);
            } else {
                // Caso a atualização falhe
                http_response_code(500);
                echo json_encode(["message" => "Erro ao atualizar os dados do usuário."]);
            }
        }
        

        public function delete($id) {
            // Obter os dados do token
            $authModel = $this->model("AuthService");
        
            $tokenData = $authModel->getTokenData();
        
            // Verificar se o tokenData contém os valores esperados
            if (!$tokenData || !isset($tokenData['user_id'])) {
                http_response_code(401);
                echo json_encode(["message" => "Não autorizado: Token inválido."]);
                exit;
            }
        
            // Verificar se o ID passado é igual ao user_id do token
            if ($id != $tokenData['user_id']) {
                http_response_code(403);
                echo json_encode(["message" => "Você não tem permissão para deletar outro usuário!"]);
                exit;
            }
        
            // Instanciar o modelo de usuário
            $usersModel = $this->model("User");
        
            // Verificar se o usuário existe
            $user = $usersModel->getById($id);
            if (!$user) {
                http_response_code(404);
                echo json_encode(["message" => "Usuário não encontrado!"]);
                exit;
            }
        
            // Deletar o usuário
            $result = $usersModel->delete($id);
        
            if ($result) {
                // Retornar uma resposta de sucesso
                http_response_code(200);
                echo json_encode(["message" => "Usuário deletado com sucesso."], JSON_UNESCAPED_UNICODE);
            } else {
                // Caso a exclusão falhe
                http_response_code(500);
                echo json_encode(["message" => "Erro ao deletar o usuário."]);
            }
        }
        
        
    }
?>