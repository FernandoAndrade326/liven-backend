<?php

namespace App\Core;

class Router{

    private $controller;

    private $method;

    private $controllerMethod;

    private $params = [];

    function __construct(){
        
        $url = $this->parseURL();

        if(file_exists("../App/Controllers/" . ucfirst($url[3]) . ".php")){ //verifica se o controller existe - converte o c da url para upperCase

            $this->controller = $url[3];
            unset($url[3]);


        }elseif(empty($url[3])){ //se url vazia, mostra uma mensagem para situar o usuário

            echo "Olá, API do Teste Backend Liven - Por favor, digite um método na URL";

            exit;

        }else{
            http_response_code(404); // caso 404 retorna mensagem de erro avisando que o rec nao existe
            echo json_encode(["erro" => "Recurso não encontrado"]);

            exit;
        }

        //caso exista e validação ocorra, instanciamos o objeto do controlador

        require_once "../App/Controllers/" . ucfirst($this->controller) . ".php";

        $this->controller = new $this->controller;

        $this->method = $_SERVER["REQUEST_METHOD"];

        //agora com base no metodo selecionado, fazemos as tratativas de acionamento

        switch($this->method){
            case "GET":

                if(isset($url[4])){ //caso tiver parametro enviamos para o metodo find (que fará tratativas de acordo)
                    $this->controllerMethod = "find";
                    $this->params = [$url[4]];
                }else{ //senao fazemos a listagem completa, que tem nomenclatura index
                    $this->controllerMethod = "index";
                }
                
                break;

            case "POST": //caso for post, redireciona para o metodo store, responsavel por adicionar ao banco
                $this->controllerMethod = "insert";
                break;

            case "PUT":
                $this->controllerMethod = "update";
                if(isset($url[4]) && is_numeric($url[4])){ //verifica se tem parametro na URL
                    $this->params = [$url[4]]; //se tiver, params, recebe o conteudo na posicao de parametro da url
                }else{
                    http_response_code(400); //senao, tratativa informando que é necessario ID
                    echo json_encode(["erro" => "Por favor, informe um id para ser atualizado"]);
                    exit;
                }
                break;

            case "DELETE":
                $this->controllerMethod = "delete";
                if(isset($url[4]) && is_numeric($url[4])){ //verifica se há parametros na url 
                    $this->params = [$url[4]];
                }else{
                    http_response_code(400); //caso nao houver, status 400 e informa que é necessario um id
                    echo json_encode(["erro" => "Por favor, informe um id para ser excluído"]);
                    exit;
                }
                break;

            default: // se for diferente dos 4 metodos, informa que nao existe essa funcionalidade
                echo "Método não suportado";
                exit;
                break;
        }

        call_user_func_array([$this->controller, $this->controllerMethod], $this->params);
        //passamos aqui qual é o controller, qual metodo setado no case sw e parametros caso houver
    }

    //alterar parse para pegar query params

    private function parseURL(){
        return explode("/", $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
        //explode na url pela "barra", para separar os itens
    }

}