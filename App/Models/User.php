<?php

    use App\Core\Model;

    require_once("Address.php");
    class User
    {
        //seta as variaveis do user
        public $id;
        public $username;
        public $password;
        public $email;
        public $created_at;
        public $updated_at;
        public $is_active;

    public function getAll(){ //retorna todos os dados do usuario
        try { //inicia o trycatch para poder lidar melhor com exceptions e sql injections
            $sql = "SELECT u.*, a.*
                FROM user u
                LEFT JOIN address a ON u.id = a.user_id
                ORDER BY u.id DESC"; //query do usuario

            $stmt = Model::getConn()->prepare($sql); //statement recebe conexao e prepara a query
            $stmt->execute(); //executa a query

            if ($stmt->rowCount() > 0) { //caso retornar dados
                $result = $stmt->fetchAll(PDO::FETCH_OBJ); //fetchall para recuperar todos os dados

                return $result; //retorna os dados
            } else {
                return []; //caso nao tiver nenhum registro, retorna vazio
            }
        } catch (PDOException $e) {
            // Tratamento de exceção do PDO, capturando o erro da execução
            error_log("Erro ao obter todos os usuários: " . $e->getMessage());
            throw new Exception("Erro ao obter usuários. Tente novamente mais tarde.");
        } catch (Exception $e) {
            // Tratamento de outras exceções ao nivel anterior
            error_log("Erro geral ao obter todos os usuários: " . $e->getMessage());
            throw new Exception("Erro inesperado ao obter usuários. Tente novamente mais tarde.");
        }
    }


    public function getById($id) //get de usuarios pelo parametro ID, ja com os endereços do mesmo
    {
        try {
            $this->id = $id;
            $sql = "SELECT id AS user_id, username AS user_name, password as user_password, email AS user_email, created_at AS user_created_at, updated_at AS user_updated_at, is_active AS user_is_active
                    FROM user
                    WHERE id = ?"; //selectt comparando o id do parametro com o do usuario

            $stmt = Model::getConn()->prepare($sql);
            $stmt->bindValue(1, $this->id); //vincula o valor do parametro na query
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_OBJ); //recupera o resultado pos execução

                // Instanciar o model Address e obter os endereços do usuário
                $addressModel = new Address();
                $addresses = $addressModel->getByUserId($id);
                // Adicionar os endereços ao resultado do usuário
                $user->addresses = $addresses; //adiciona os retornos de address ao nosso usuario

                return $user;
            } else {
                return null;
            }
        } catch (PDOException $e) { //tratamento de exceptions 
            error_log("Erro ao obter usuário por ID: " . $e->getMessage());
            throw new Exception("Erro ao obter usuário. Tente novamente mais tarde.");
        } catch (Exception $e) {
            error_log("Erro geral ao obter usuário por ID: " . $e->getMessage());
            throw new Exception("Erro inesperado ao obter usuário. Tente novamente mais tarde.");
        }
    }


    public function insert() //insere um usuario
    {
        try {
            $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT); //encriptação de senha pela lib bcrypt

            $sql = "INSERT INTO user (username, password, email) VALUES (?, ?, ?)"; //sql basica de inserção

            $stmt = Model::getConn()->prepare($sql);
            $stmt->bindValue(1, $this->username); //invucla os dados que vieram no body, capturados no controller
            $stmt->bindValue(2, $hashedPassword);
            $stmt->bindValue(3, $this->email);

            if ($stmt->execute()) {//se execução for sucesso, retorna o resultado
                return $this;
            } else {
                // Erro inesperado, pode não lançar exceção mas ainda assim falhar
                print_r($stmt->errorInfo());
                return null;
            }
        } catch (PDOException $e) {
            // Tratamento de exceção de PDO
            error_log("Erro ao inserir usuário: " . $e->getMessage());
            echo json_encode(["erro" => "Erro ao inserir o usuário. Tente novamente mais tarde."]);
            return null;
        } catch (Exception $e) {
            // Tratamento de outras exceções
            error_log("Erro geral: " . $e->getMessage());
            echo json_encode(["erro" => "Ocorreu um erro inesperado. Tente novamente mais tarde."]);
            return null;
        }
    }


    public function update($id) //atualiza o usuario, com base no id do parametro
    {
        try {
            $this->id = $id;
            $updatedAt = new DateTime(); //recebo a data do servidor
            $updatedAt = $updatedAt->format('Y-m-d H:i:s'); //formato para o tipo utilizado

            $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT); //recebe a nova senha e faz a encryptação
            //uma melhoria de codigo seria a comparação das alterações

            $sql = "UPDATE user SET username = ?, password = ?, email = ?, updated_at = ? WHERE id = ?";
            //update simples
            $stmt = Model::getConn()->prepare($sql);
            $stmt->bindValue(1, $this->username);//vinculo das variaveis em ordem
            $stmt->bindValue(2, $hashedPassword);
            $stmt->bindValue(3, $this->email);
            $stmt->bindValue(4, $updatedAt);
            $stmt->bindValue(5, $this->id);

            if ($stmt->execute()) {
                return $this;
            } else {
                // exibe na tela o erro inesperado, pode não lançar exceção mas ainda assim falhar
                print_r($stmt->errorInfo());
                return null;
            }
        } catch (PDOException $e) {
            // Tratamento de exceção do PDO
            error_log("Erro ao atualizar usuário: " . $e->getMessage());
            throw new Exception("Erro ao atualizar usuário. Tente novamente mais tarde.");
        } catch (Exception $e) {
            // Tratamento de outras exceções
            error_log("Erro geral ao atualizar usuário: " . $e->getMessage());
            throw new Exception("Erro inesperado ao atualizar usuário. Tente novamente mais tarde.");
        }
    }


    public function delete($id) //deleta o usuario, com base no parametro
    {
        try {
            $this->id = $id;

            $sql = "DELETE FROM user WHERE id = ?";

            $stmt = Model::getConn()->prepare($sql);
            $stmt->bindValue(1, $this->id);

            if ($stmt->execute()) {
                return $this;
            } else {
                // Erro inesperado, pode não lançar exceção mas ainda assim falhar
                print_r($stmt->errorInfo());
                return null;
            }
        } catch (PDOException $e) {
            // Tratamento de exceção do PDO
            error_log("Erro ao deletar usuário: " . $e->getMessage());
            throw new Exception("Erro ao deletar usuário. Tente novamente mais tarde.");
        } catch (Exception $e) {
            // Tratamento de outras exceções
            error_log("Erro geral ao deletar usuário: " . $e->getMessage());
            throw new Exception("Erro inesperado ao deletar usuário. Tente novamente mais tarde.");
        }
    }
}
