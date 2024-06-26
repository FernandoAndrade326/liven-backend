<?php

namespace App\Core;

class Router{

    private $controller;

    private $method;

    private $controllerMethod;

    private $params = [];

    function __construct(){
        
        $url = $this->parseURL();

        if(file_exists("../App/Controllers/" . ucfirst($url[1]) . ".php")){ //verifica se o controller existe - converte o c da url para upperCase

            $this->controller = $url[1];
            unset($url[1]);

        }elseif(empty($url[1])){ //se url vazia, mostra uma mensagem para situar o usuário

            echo "Olá, API do Teste Backend Liven - Por favor, digite um método na URL";

            exit;

        }else{
            http_response_code(404); // caso 404 retorna mensagem de erro avisando que o rec nao existe
            echo json_encode(["erro" => "Recurso não encontrado"]);
        }

        require_once "../App/Controllers/" . ucfirst($this->controller) . ".php";

        $this->controller = new $this->controller;

        $this->method = $_SERVER["REQUEST_METHOD"];

        switch($this->method){
            case "GET":

                if(isset($url[2])){
                    $this->controllerMethod = "find";
                    $this->params = [$url[2]];
                }else{
                    $this->controllerMethod = "index";
                }
                
                break;

            case "POST":
                $this->controllerMethod = "store";
                break;

            case "PUT":
                $this->controllerMethod = "update";
                if(isset($url[2]) && is_numeric($url[2])){
                    $this->params = [$url[2]];
                }else{
                    http_response_code(400);
                    echo json_encode(["erro" => "Por favor, informe um id para ser atualizado"]);
                    exit;
                }
                break;

            case "DELETE":
                $this->controllerMethod = "delete";
                if(isset($url[2]) && is_numeric($url[2])){
                    $this->params = [$url[2]];
                }else{
                    http_response_code(400);
                    echo json_encode(["erro" => "Por favor, informe um id para ser excluído"]);
                    exit;
                }
                break;

            default: 
                echo "Método não suportado";
                exit;
                break;
        }

        call_user_func_array([$this->controller, $this->controllerMethod], $this->params);
        
    }

    private function parseURL(){
        return explode("/", $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
    }

}