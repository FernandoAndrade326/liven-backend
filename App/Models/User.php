<?php

    use App\Core\Model;
    require_once("Address.php");
    class User{

        public $id;
        public $username;
        public $password;
        public $email;
        public $created_at;
        public $updated_at;
        public $is_active;

        public function getAll() {
            try {
                $sql = "SELECT u.*, a.*
                FROM user u
                LEFT JOIN address a ON u.id = a.user_id
                ORDER BY u.id DESC;";
        
                $stmt = Model::getConn()->prepare($sql);
                $stmt->execute();
        
                if ($stmt->rowCount() > 0) {
                    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        
                    return $result;
                } else {
                    return [];
                }
            } catch (PDOException $e) {
                // Tratamento de exceção do PDO
                error_log("Erro ao obter todos os usuários: " . $e->getMessage());
                throw new Exception("Erro ao obter usuários. Tente novamente mais tarde.");
            } catch (Exception $e) {
                // Tratamento de outras exceções
                error_log("Erro geral ao obter todos os usuários: " . $e->getMessage());
                throw new Exception("Erro inesperado ao obter usuários. Tente novamente mais tarde.");
            }
        }
        

        public function getById($id)
    {
        try {
            $this->id = $id;
            $sql = "SELECT id AS user_id, username AS user_name, password as user_password, email AS user_email, created_at AS user_created_at, updated_at AS user_updated_at, is_active AS user_is_active
                    FROM user
                    WHERE id = ?";
            
            $stmt = Model::getConn()->prepare($sql);
            $stmt->bindValue(1, $this->id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_OBJ);

                // Instanciar o modelo Address e obter os endereços do usuário
                $addressModel = new Address();
                $addresses = $addressModel->getByUserId($id);
                //$addresses = json_encode($addresses);
                // Adicionar os endereços ao resultado do usuário
                $user->addresses = $addresses;

                return $user;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Erro ao obter usuário por ID: " . $e->getMessage());
            throw new Exception("Erro ao obter usuário. Tente novamente mais tarde.");
        } catch (Exception $e) {
            error_log("Erro geral ao obter usuário por ID: " . $e->getMessage());
            throw new Exception("Erro inesperado ao obter usuário. Tente novamente mais tarde.");
        }
    }
        

        public function insert() {
            try {
                $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);
        
                $sql = "INSERT INTO user (username, password, email) VALUES (?, ?, ?)";
        
                $stmt = Model::getConn()->prepare($sql);
                $stmt->bindValue(1, $this->username);
                $stmt->bindValue(2, $hashedPassword);
                $stmt->bindValue(3, $this->email);
        
                if ($stmt->execute()) {
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
        

        public function update($id) {
            try {
                $this->id = $id;
                $updatedAt = new DateTime(); 
                $updatedAt = $updatedAt->format('Y-m-d H:i:s');
        
                $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);
        
                $sql = "UPDATE user SET username = ?, password = ?, email = ?, updated_at = ? WHERE id = ?";
        
                $stmt = Model::getConn()->prepare($sql);
                $stmt->bindValue(1, $this->username);
                $stmt->bindValue(2, $hashedPassword);
                $stmt->bindValue(3, $this->email);
                $stmt->bindValue(4, $updatedAt);
                $stmt->bindValue(5, $this->id);
        
                if ($stmt->execute()) {
                    return $this;
                } else {
                    // Erro inesperado, pode não lançar exceção mas ainda assim falhar
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
        

        public function delete($id) {
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
?>