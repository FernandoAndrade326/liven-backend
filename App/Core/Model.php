<?php

namespace App\Core;

class Model {

    private static $conexao;

    public static function getConn(){

        if(!isset(self::$conexao)){ //verifica se há uma conexao existente
            self::$conexao = new \PDO("mysql:host=localhost;port=3306;dbname=liven;", "root", "");
        }

        return self::$conexao;
    }

}