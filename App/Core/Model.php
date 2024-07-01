<?php

namespace App\Core;

class Model
{

    private static $conexao; //cria nossa variavel de conexao

    public static function getConn() //funcao para conectar no banco
    {

        if (!isset(self::$conexao)) { //verifica se há uma conexao existente
            //caso nao houver conexao, instancia uma nova na variavvel conexao, senao mantem a existente
            self::$conexao = new \PDO("mysql:host=localhost;port=3306;dbname=liven;", "root", "");
        }
        //apos rodar o PDO pra conectar com o db, retorna conexao
        return self::$conexao;
    }
}
