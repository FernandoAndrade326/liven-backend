<?php

use App\Core\Controller;
use App\Middleware\AuthMiddleware;

class Addressess extends Controller{

    public function __construct() {
        AuthMiddleware::authenticate(); //todos os metodos de address requerem autenticacao
    }

    public function index($query) {
        $authModel = $this->model("AuthService"); //instancia objeto do authservice
        $tokenData = $authModel->getTokenData(); //chama metodo para recuperar dados do token
    
        //validamos se tokendata tem o user_id que precisamos
        if (!$tokenData || !isset($tokenData['user_id'])) {
            http_response_code(401); //senao mensagem de erro
            echo json_encode(["message" => "Não autorizado: Token inválido. Por favor, faça login novamente!"]);
            exit;
        }
    
        $user_id = $tokenData['user_id']; //caso passar, capturamos o id na nossa variavel
    
        $addressModel = $this->model("Address"); //instanceamos o modelo de address

        $address = $addressModel->getAll($user_id, $query); // aqui obtemos o endereço do usuario logado
    
        //verificamos se há retorno nos endereços
        if (!$address) {
            http_response_code(204); //senao, 204 e mensagem de nao encontrado
            echo json_encode(["message" => "Nenhum endereço encontrado para este usuário."]);
            exit;
        }
    
        http_response_code(200); //caso passar, codigo 200 e exibe os dados
        echo json_encode([
            "message" => "Endereços recuperados com sucesso.",
            "data" => $address
        ], JSON_UNESCAPED_UNICODE);
    }
    
    
    

    public function find($id) {
        $authModel = $this->model("AuthService"); //instancia o objeto para utilizar authservice
        $tokenData = $authModel->getTokenData(); //usamos getTokenData para pegar id e username
    
        if (!$tokenData || !isset($tokenData['user_id'])) { //caso haja valores
            http_response_code(401);
            echo json_encode(["message" => "Não autorizado: Token inválido. Por favor, faça login novamente!"]);
            exit;
        }
    
        $addressModel = $this->model("Address"); //instancia objeto para usar metodos do address

        if (isset($id)) { //caso haja o parametro id
            $address = $addressModel->getById($id); //select dos address por id
            if ($address->user_id == $tokenData['user_id']) {//compara id do select com id do token
                echo json_encode($address, JSON_UNESCAPED_UNICODE); //retorna o json dos address
            } else {
                http_response_code(403); //caso nao pertenca ao usuario
                echo json_encode(["message:" => "Você não tem permissão para visualizar este endereço!"]);
                exit;
            }
        } else {
            http_response_code(400); //caso o parametro n seja valido
            echo json_encode(["message:" => "Por favor, informe um ID válido."]);
            exit;
        }
    }
    

    public function insert() { //insere um edenreço com base no id do usuario pelo token
        try {
            $newAddress = $this->getRequestBody(); //pega oos valores do body da requisicao
    
            $authModel = $this->model("AuthService"); //objeto do authservice
            $tokenData = $authModel->getTokenData(); //recebemos valores do token
    
            $addressModel = $this->model("Address"); //model do address para vincularmos valores
            $addressModel->user_id = $tokenData['user_id']; //user_id proveniente do token
            $addressModel->street = $newAddress->street; //valores do reqbody
            $addressModel->number = $newAddress->number;
            $addressModel->complement = $newAddress->complement;
            $addressModel->neighborhood = $newAddress->neighborhood;
            $addressModel->city = $newAddress->city;
            $addressModel->state = $newAddress->state;
            $addressModel->zip_code = $newAddress->zip_code;
            $addressModel->country = $newAddress->country;
    
            $addressModel = $addressModel->insert(); //chama o metodo insert address
    
            if ($addressModel) {
                http_response_code(201); // caso verdadeiro criado com sucesso
                echo json_encode(["message"=>"Endereço inserido com sucesso!", "data"=>$addressModel]);
            } else {
                http_response_code(500);
                echo json_encode(["erro" => "Não foi possível inserir o endereço!"]);
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 1452) {
                http_response_code(400); // erro de requisição do cliente
                echo json_encode(["erro" => "Usuário não cadastrado."]);
            } else {
                http_response_code(500); // erro interno do servidor
                echo json_encode(["erro" => "Erro ao inserir o endereço: " . $e->getMessage()]);
            }
        }
    }
    

    public function update($id){ //update dos endereços
        $addressModel = $this->model("Address"); //instancia objeto com base no model address
        $address = $addressModel->getById($id); //faz o getid por parametro

        if (!$address) { //caso false 
            http_response_code(404); //significa que nao ha esse endereço
            echo json_encode(["Erro: " => "Endereço inexistente!"]);
            exit;
        }

        $authModel = $this->model("AuthService"); //objeto para autenticacao

        if($tokenData = $authModel->getTokenData()){ //se tokendata conseguir receber valor do metodo

        if(isset($tokenData['user_id'])){ //se user_id existir
                if ($address->user_id !== $tokenData['user_id']) { //se os user id nao forem iguais
                    http_response_code(403); //sem permissao para update no endereço
                    echo json_encode(["Erro: " => "Você não tem permissão para alterar este endereço!"]);
                    exit;
                }

                $updatedAddress = $this->getRequestBody();//recebe os dados do body na requisicao
                $addressModel->street = $updatedAddress->street;
                $addressModel->number = $updatedAddress->number;
                $addressModel->complement = $updatedAddress->complement;
                $addressModel->neighborhood = $updatedAddress->neighborhood;
                $addressModel->city = $updatedAddress->city;
                $addressModel->state = $updatedAddress->state;
                $addressModel->zip_code = $updatedAddress->zip_code;
                $addressModel->country = $updatedAddress->country;

                $addressModel->update($id);//roda o metodo update enviando o id do parametro

                if($addressModel){ 
                http_response_code(201); //caso verdade, retorna 201 e mensagem
                echo json_encode(["message"=>"Atualizado com sucesso!", "data"=>$addressModel]);
                }
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

    public function delete($id){//delete por parametro id
        $addressModel = $this->model("Address"); //objetto do address
        $address = $addressModel->getById($id);//roda o getById com id do parametro

        if (!$address) { //caso nao encontrar
            http_response_code(404);
            echo json_encode(["Erro: " => "Endereço inexistente!"]);
            exit;
        }

        $authModel = $this->model("AuthService");//objeto de autenticacao

        if($tokenData = $authModel->getTokenData()){//recebe os dados do token

        if(isset($tokenData['user_id'])){//se houver um user_id
                if ($address->user_id !== $tokenData['user_id']) {//se ids nao forem iguais
                    http_response_code(403);
                    echo json_encode(["Erro: " => "Você não tem permissão para excluir este endereço!"]);
                    exit;
                }

                $addressModel->delete($id);//caso forem iguais, roda o metodo e exibe a mensagem

                if($addressModel){//se existir resultado
                    echo json_encode(["message"=>"Endereço deletado com sucesso!", "data"=>$addressModel]);
                }
                
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
