<?php

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Addressess extends Controller{

    public function __construct() {
        // Adiciona autenticação às rotas protegidas
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            AuthMiddleware::authenticate();
        }
    }

    public function index() {
        // Obter os dados do token
        $authModel = $this->model("AuthService");
    
        $tokenData = $authModel->getTokenData();
    
        // Verificar se o tokenData contém os valores esperados
        if (!$tokenData || !isset($tokenData['user_id'])) {
            http_response_code(401);
            echo json_encode(["message" => "Não autorizado: Token inválido. Por favor, faça login novamente!"]);
            exit;
        }
    
        $user_id = $tokenData['user_id'];
    
        // Instanciar o modelo de endereço
        $addressModel = $this->model("Address");
    
        // Obter endereços do usuário logado
        $address = $addressModel->getAll($user_id);
    
        // Verificar se há endereços
        if (!$address) {
            http_response_code(204);
            echo json_encode(["message" => "Nenhum endereço encontrado para este usuário."]);
            exit;
        }
    
        // Retornar endereços e message de sucesso
        http_response_code(200);
        echo json_encode([
            "message" => "Endereços recuperados com sucesso.",
            "data" => $address
        ], JSON_UNESCAPED_UNICODE);
    }
    
    
    

    public function find($id) {
        // Obter os dados do token
        $authModel = $this->model("AuthService");
    
        $tokenData = $authModel->getTokenData();
    
        // Verificar se o tokenData contém os valores esperados
        if (!$tokenData || !isset($tokenData['user_id'])) {
            http_response_code(401);
            echo json_encode(["message" => "Não autorizado: Token inválido. Por favor, faça login novamente!"]);
            exit;
        }
    
        // Instanciar o modelo de endereço
        $addressModel = $this->model("Address");
    
        // Verificar se o ID está definido
        if (isset($id)) {
            // Obter o endereço pelo ID
            $address = $addressModel->getById($id);
            // Verificar se o endereço pertence ao usuário autenticado
            if ($address->user_id == $tokenData['user_id']) {
                // Retornar o endereço em formato JSON
                echo json_encode($address, JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(403);
                echo json_encode(["message:" => "Você não tem permissão para visualizar este endereço!"]);
                exit;
            }
        } else {
            http_response_code(400);
            echo json_encode(["message:" => "Por favor, informe um ID válido."]);
            exit;
        }
    }
    

    public function insert(){
        $newAddress = $this->getRequestBody();

        $authModel = $this->model("AuthService");
        $tokenData = $authModel->getTokenData();

        $addressModel = $this->model("Address");
        $addressModel->user_id = $tokenData['user_id'];
        $addressModel->street = $newAddress->street;
        $addressModel->number = $newAddress->number;
        $addressModel->complement = $newAddress->complement;
        $addressModel->neighborhood = $newAddress->neighborhood;
        $addressModel->city = $newAddress->city;
        $addressModel->state = $newAddress->state;
        $addressModel->zip_code = $newAddress->zip_code;
        $addressModel->country = $newAddress->country;

        $addressModel = $addressModel->insert();

        if($addressModel){
            http_response_code(201); //criado com sucesso
            echo json_encode($addressModel);
        }else{
            http_response_code(500);
            echo json_encode(["erro" => "Não foi possível inserir o endereço!"]);
        }
    }

    public function update($id){
        $addressModel = $this->model("Address");
        $address = $addressModel->getById($id);

        if (!$address) {
            http_response_code(404);
            echo json_encode(["Erro: " => "Endereço inexistente!"]);
            exit;
        }

        $authModel = $this->model("AuthService");

        if($tokenData = $authModel->getTokenData()){

        if(isset($tokenData['user_id'])){
                if ($address->user_id !== $tokenData['user_id']) {
                    http_response_code(403);
                    echo json_encode(["Erro: " => "Você não tem permissão para alterar este endereço!"]);
                    exit;
                }

                $updatedAddress = $this->getRequestBody();
                $addressModel->street = $updatedAddress->street;
                $addressModel->number = $updatedAddress->number;
                $addressModel->complement = $updatedAddress->complement;
                $addressModel->neighborhood = $updatedAddress->neighborhood;
                $addressModel->city = $updatedAddress->city;
                $addressModel->state = $updatedAddress->state;
                $addressModel->zip_code = $updatedAddress->zip_code;
                $addressModel->country = $updatedAddress->country;

                $addressModel->update($id);
                echo json_encode(["Usuário: ".$id." - Atualizado com sucesso!"]);
                echo json_encode($addressModel, JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(401);
                echo json_encode(["Erro: " => "Acesso não autorizado. Nenhum token fornecido!"]);
                exit;
            }
        }
            else {
            http_response_code(401);
            echo json_encode(["Erro: " => "Acesso não autorizado. Nenhum token fornecido!"]);
            exit;
        }
    }

    public function delete($id){
        $addressModel = $this->model("Address");
        $address = $addressModel->getById($id);

        if (!$address) {
            http_response_code(404);
            echo json_encode(["Erro: " => "Endereço inexistente!"]);
            exit;
        }

        $authModel = $this->model("AuthService");

        if($tokenData = $authModel->getTokenData()){

        if(isset($tokenData['user_id'])){
                if ($address->user_id !== $tokenData['user_id']) {
                    http_response_code(403);
                    echo json_encode(["Erro: " => "Você não tem permissão para excluir este endereço!"]);
                    exit;
                }

                $addressModel->delete($id);
                echo json_encode(["Sucesso: " => "Endereço ".$id." deletado com sucesso!"]);
                echo json_encode($addressModel, JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(401);
                echo json_encode(["Erro: " => "Acesso não autorizado. Nenhum token fornecido!"]);
                exit;
            }
        } else {
            http_response_code(401);
            echo json_encode(["Erro: " => "Acesso não autorizado. Nenhum token fornecido!"]);
            exit;
        }
    }
}
?>
