<?php

use App\Core\Controller;

    class Addressess extends Controller{

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
            $addressModel-> user_id = $newAddress->user_id;
            $addressModel-> street = $newAddress->street;
            $addressModel-> number = $newAddress->number;
            $addressModel-> complement = $newAddress->complement;
            $addressModel-> neighborhood = $newAddress->neighborhood;
            $addressModel-> city = $newAddress->city;
            $addressModel-> state = $newAddress->state;
            $addressModel-> zip_code = $newAddress->zip_code;
            $addressModel-> country = $newAddress->country;

            $addressModel = $addressModel->insert();

            if($addressModel){
                http_response_code(201); //criado com sucesso
                echo json_encode($addressModel);
            }else{
                http_response_code(500);
                echo json_encode(["erro" => "Não foi possível inserir o endereço!"]);
            }

        }

        public function delete($id){
            $addressModel = $this->model("Address");
            $addressModel = $addressModel->getById($id);

            if(!$addressModel){
                http_response_code(404);
                echo json_encode(["Erro: "=> "Endereço inexistente!"]);
                exit;
            }

            $addressModel->delete($id);

            echo json_encode($addressModel, JSON_UNESCAPED_UNICODE);

        }
    }
?>