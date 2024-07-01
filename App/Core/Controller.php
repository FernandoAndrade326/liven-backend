<?php

namespace App\Core;

class Controller
{

    public function model($model){ //metodo para facilitar a instanciação dos models, evitar redundancia de codigo
        require_once "../App/Models/" . $model . ".php";
        return new $model;
    }

    protected function getRequestBody(){ //metodo para retornar o body da requisição em JSON, ja tratado
        $json = file_get_contents("php://input");
        $obj = json_decode($json);

        return $obj;
    }
}
