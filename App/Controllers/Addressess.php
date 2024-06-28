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

    public function index(){
        $addressModel = $this->model("Address");

        $address = $addressModel->getAll();

        if(!$address){
            http_response_code(204);
            exit;
        }

        echo json_encode($address, JSON_UNESCAPED_UNICODE);
    }

    public function find($id){
        $addressModel = $this->model("Address");

        if(isset($id)){
            $address = $addressModel->getById($id);
            echo json_encode($address, JSON_UNESCAPED_UNICODE);
        } 
    }

    public function insert(){
        $newAddress = $this->getRequestBody();

        $addressModel = $this->model("Address");
        $addressModel->user_id = $newAddress->user_id;
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

        // Decodifica o token JWT para obter o user_id do usuário autenticado
        $headers = getallheaders();
        $authHeader = $headers['Authorization'];
        list($jwt) = sscanf($authHeader, 'Bearer %s');
        $decoded = JWT::decode($jwt, new Key(SECRET_KEY, 'HS256'));

        if ($address->user_id !== $decoded->data->id) {
            http_response_code(403);
            echo json_encode(["Erro: " => "Você não tem permissão para alterar este endereço!"]);
            exit;
        }

        $updatedAddress = $this->getRequestBody();
        $addressModel->user_id = $updatedAddress->user_id;
        $addressModel->street = $updatedAddress->street;
        $addressModel->number = $updatedAddress->number;
        $addressModel->complement = $updatedAddress->complement;
        $addressModel->neighborhood = $updatedAddress->neighborhood;
        $addressModel->city = $updatedAddress->city;
        $addressModel->state = $updatedAddress->state;
        $addressModel->zip_code = $updatedAddress->zip_code;
        $addressModel->country = $updatedAddress->country;

        $addressModel->update($id);
        echo json_encode($addressModel, JSON_UNESCAPED_UNICODE);
    }

    public function delete($id){
        $addressModel = $this->model("Address");
        $address = $addressModel->getById($id);

        if (!$address) {
            http_response_code(404);
            echo json_encode(["Erro: " => "Endereço inexistente!"]);
            exit;
        }

        // Decodifica o token JWT para obter o user_id do usuário autenticado
        $headers = getallheaders();
        $authHeader = $headers['Authorization'];
        list($jwt) = sscanf($authHeader, 'Bearer %s');
        $decoded = JWT::decode($jwt, new Key(SECRET_KEY, 'HS256'));

        if ($address->user_id !== $decoded->data->id) {
            http_response_code(403);
            echo json_encode(["Erro: " => "Você não tem permissão para excluir este endereço!"]);
            exit;
        }

        $addressModel->delete($id);
        echo json_encode($addressModel, JSON_UNESCAPED_UNICODE);
    }
}
?>
