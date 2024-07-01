<?php

namespace App\Core;

    class Router{

    private $controller;

    private $method;

    private $controllerMethod;

    private $params = [];

    function __construct()
    {
        $url = $this->parseURL();
        $path = $url["path"];
        $query = $url["query"];

        //valores que correspondem as nossas urls em questão
        $controllerIndex = 2; //aqui acessa "teste_backend"
        $methodIndex = 3; //aqui o metodo, se no caso de exemplo é users ou address
        $paramIndex = 4; //parametro

        if (isset($path[$controllerIndex]) && file_exists("../App/Controllers/" . ucfirst($path[$controllerIndex]) . ".php")) {
            // Verifica se o controller existe - converte a incial da url para upperCase para bater com o caminho dos arquivos controllers
            $this->controller = ucfirst($path[$controllerIndex]);
        } elseif (empty($path[$controllerIndex])) {
            // Se url vazia, mostra uma mensagem para situar o usuário
            echo "Olá, API do Teste Backend Liven - Por favor, digite um método na URL";
            exit;
        } else {
            http_response_code(404); // Caso der errado, retorna 404 e mensagem de erro avisando que o recurso não existe
            echo json_encode(["erro" => "Recurso não encontrado"]);
            exit;
        }

        // Caso exista e validação ocorra, instanciamos o objeto do controlador
        require_once "../App/Controllers/" . $this->controller . ".php";
        $this->controller = new $this->controller; //instancia o objeto do controller

        $this->method = $_SERVER["REQUEST_METHOD"]; //captura o metodo da requisicao (GET,POST etc)

        // Agora com base no método selecionado, fazemos as tratativas de acionamento
        switch ($this->method) {
            case "GET":
                if (isset($path[$methodIndex])) { // Caso tiver parâmetro, enviamos para o método find (que fará tratativas de acordo)
                    $this->controllerMethod = "find";
                    $this->params = [$path[$methodIndex], $query];
                } else { // Senão fazemos a listagem completa, que tem nomenclatura index
                    $this->controllerMethod = "index";
                    $this->params = [$query]; // Passa a query string como parâmetros
                }
                break;

            case "POST": // Caso for POST, redireciona para o método insert, responsável por adicionar ao banco
                $this->controllerMethod = "insert";
                $this->params = [$query]; // Passa a query string como parâmetros, caso necessário
                break;

            case "PUT":
                $this->controllerMethod = "update";
                if (isset($path[$methodIndex]) && is_numeric($path[$methodIndex])) { // Verifica se tem parâmetro na URL
                    $this->params = [$path[$methodIndex], $query]; // Passa ID e query string como parâmetros
                } else {
                    http_response_code(400); // Senão, tratativa informando que é necessário ID
                    echo json_encode(["erro" => "Por favor, informe um id para ser atualizado"]);
                    exit;
                }
                break;

            case "DELETE":
                $this->controllerMethod = "delete";
                if (isset($path[$methodIndex]) && is_numeric($path[$methodIndex])) { // Verifica se há parâmetros NUMERICOS na URL 
                    $this->params = [$path[$methodIndex], $query]; // Passa ID e query string como parâmetros
                } else {
                    http_response_code(400); // Caso não houver, status 400 e informa que é necessário um id
                    echo json_encode(["erro" => "Por favor, informe um id para ser excluído"]);
                    exit;
                }
                break;

            default: // Se for diferente dos 4 métodos, informa que não existe essa funcionalidade
                echo "Método não suportado";
                exit;
                break;
        }

        call_user_func_array([$this->controller, $this->controllerMethod], $this->params);
        // Passamos aqui qual é o controller, qual método setado no case switch e parâmetros caso houver
        //ou seja, chamamos o metodo correspondente no controller em questão, juntamente com os parametros
    }

    private function parseURL() //devolve o necessario das urls, caminho e parametros
    {
        $url = parse_url($_SERVER["REQUEST_URI"]); //recupera a url
        $path = explode("/", trim($url["path"], "/")); //fragmenta a url com base nas barras
        $query = []; //cria um array para armazenar as query string

        if (isset($url["query"])) {
            parse_str($url["query"], $query); //query recebe o valor da query na url, caso houver apos o "?"
        }

        return ["path" => $path, "query" => $query]; //aqui retorna o caminho da url e a querystring
    }
}
