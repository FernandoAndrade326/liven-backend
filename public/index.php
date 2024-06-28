<?php

    require_once("../vendor/autoload.php"); //autoload para carregar classes

    date_default_timezone_set("America/Sao_Paulo");

    header("Content-type: application/json"); //seta o tipo de conteudo da pagina para interpretar JSON
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header("Access-Control-Allow-Headers: Content-Type");

    new App\Core\Router(); //chama o construtor do router, reponsavel pelas rotas

?>