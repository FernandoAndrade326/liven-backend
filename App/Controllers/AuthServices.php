<?php

    use App\Core\Controller;
    
    class AuthServices extends Controller{

        public function insert(){
            $newLogin = $this->getRequestBody(); //pega o body da requisicao
            
            $AuthServicesModel = $this->model("AuthService"); //instancia o objeto de authservice
            $AuthServicesModel->username = $newLogin->username; //seta as variaveis com valores do body
            $AuthServicesModel->password = $newLogin->password;

            $AuthServicesModel = $AuthServicesModel->login($AuthServicesModel->username, $AuthServicesModel->password);
            //chama o metodo de login com as variaveis do body passadas
            if($AuthServicesModel){ //se true, roda 201 e mensagem com token JWT
                http_response_code(201);
                echo json_encode(["message:" => "Login bem-sucedido!"]);
                echo json_encode($AuthServicesModel);
            } else{
                http_response_code(500);//caso de bad request, aviso de nao possivel
                echo json_encode(["Erro: " =>"Dados inconsistentes. Não foi possível realizar o login!"]);
            }
        }
    }
?>