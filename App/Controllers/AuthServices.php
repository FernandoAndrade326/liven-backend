<?php

    use App\Core\Controller;
    
    class AuthServices extends Controller{

        public function insert(){
            $newLogin = $this->getRequestBody();
            
            $AuthServicesModel = $this->model("AuthService");
            $AuthServicesModel->username = $newLogin->username;
            $AuthServicesModel->password = $newLogin->password;

            $AuthServicesModel = $AuthServicesModel->login($AuthServicesModel->username, $AuthServicesModel->password);

            if($AuthServicesModel){
                http_response_code(201);
                echo json_encode(["Sucesso:" => "Login bem-sucedido!"]);
                echo json_encode($AuthServicesModel);
            } else{
                http_response_code(500);
                echo json_encode(["Erro: " =>"Dados inconsistentes. Não foi possível realizar o login!"]);
            }
        }
    }
?>