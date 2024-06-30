<?php

    use App\Core\Model;

    class Address{

        public $id;
        public $user_id;
        public $street;
        public $number;
        public $complement;
        public $neighborhood;
        public $city;
        public $state;
        public $zip_code;
        public $country;

        public function getAll($user_id) {
            try {
                $sql = "SELECT * FROM address WHERE user_id = ?";
        
                $stmt = Model::getConn()->prepare($sql);
                $stmt->bindValue(1, $user_id);
                $stmt->execute();
        
                if ($stmt->rowCount() > 0) {
                    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        
                    return $result;
                } else {
                    return [];
                }
            } catch (PDOException $e) {
                // Tratamento de exceção do PDO
                error_log("Erro ao obter endereços por ID de usuário: " . $e->getMessage());
                throw new Exception("Erro ao obter endereços. Tente novamente mais tarde.");
            } catch (Exception $e) {
                // Tratamento de outras exceções
                error_log("Erro geral ao obter endereços por ID de usuário: " . $e->getMessage());
                throw new Exception("Erro inesperado ao obter endereços. Tente novamente mais tarde.");
            }
        }
        

        public function insert() {
            try {
                $sql = "INSERT INTO address (user_id, street, number, complement, neighborhood, city, state, zip_code, country) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
                $stmt = Model::getConn()->prepare($sql);
                $stmt->bindValue(1, $this->user_id);
                $stmt->bindValue(2, $this->street);
                $stmt->bindValue(3, $this->number);
                $stmt->bindValue(4, $this->complement);
                $stmt->bindValue(5, $this->neighborhood);
                $stmt->bindValue(6, $this->city);
                $stmt->bindValue(7, $this->state);
                $stmt->bindValue(8, $this->zip_code);
                $stmt->bindValue(9, $this->country);
        
                if ($stmt->execute()) {
                    return $this;
                } else {
                    print_r($stmt->errorInfo());
                    return null;
                }
            } catch (PDOException $e) {
                // Tratamento de exceção do PDO
                error_log("Erro ao inserir endereço: " . $e->getMessage());
                throw new Exception("Erro ao inserir endereço. Tente novamente mais tarde.");
            } catch (Exception $e) {
                // Tratamento de outras exceções
                error_log("Erro geral ao inserir endereço: " . $e->getMessage());
                throw new Exception("Erro inesperado ao inserir endereço. Tente novamente mais tarde.");
            }
        }
        

        public function getById($id) {
            try {
                $this->id = $id;
                $sql = "SELECT * FROM address WHERE id = ?";
        
                $stmt = Model::getConn()->prepare($sql);
                $stmt->bindValue(1, $this->id);
        
                $stmt->execute();
        
                if ($stmt->rowCount() > 0) {
                    $result = $stmt->fetch(PDO::FETCH_OBJ);
        
                    if (!$result) {
                        return null;
                    }
        
                    $this->id = $result->id;
                    $this->user_id = $result->user_id;
                    $this->street = $result->street;
                    $this->number = $result->number;
                    $this->complement = $result->complement;
                    $this->neighborhood = $result->neighborhood;
                    $this->city = $result->city;
                    $this->state = $result->state;
                    $this->zip_code = $result->zip_code;
                    $this->country = $result->country;
        
                    return $this;
                } else {
                    return null;
                }
            } catch (PDOException $e) {
                // Tratamento de exceção do PDO
                error_log("Erro ao obter endereço por ID: " . $e->getMessage());
                throw new Exception("Erro ao obter endereço. Tente novamente mais tarde.");
            } catch (Exception $e) {
                // Tratamento de outras exceções
                error_log("Erro geral ao obter endereço por ID: " . $e->getMessage());
                throw new Exception("Erro inesperado ao obter endereço. Tente novamente mais tarde.");
            }
        }

        public function getByUserId($userId)
        {
            try {
                $sql = "SELECT id AS address_id, street AS address_street, number AS address_number, complement AS address_complement, neighborhood AS address_neighborhood, city AS address_city, state AS address_state, zip_code AS address_zip_code, country AS address_country
                        FROM address
                        WHERE user_id = ?";
                
                $stmt = Model::getConn()->prepare($sql);
                $stmt->bindValue(1, $userId);
                $stmt->execute();
    
                if ($stmt->rowCount() > 0) {
                    return $stmt->fetchAll(PDO::FETCH_OBJ);
                } else {
                    return [];
                }
            } catch (PDOException $e) {
                error_log("Erro ao obter endereços por ID de usuário: " . $e->getMessage());
                throw new Exception("Erro ao obter endereços. Tente novamente mais tarde.");
            } catch (Exception $e) {
                error_log("Erro geral ao obter endereços por ID de usuário: " . $e->getMessage());
                throw new Exception("Erro inesperado ao obter endereços. Tente novamente mais tarde.");
            }
        }
        

        public function update($id) {
            try {
                $this->id = $id;
        
                $sql = "UPDATE address 
                        SET user_id = ?, street = ?, number = ?, complement = ?, neighborhood = ?, city = ?, state = ?, zip_code = ?, country = ? 
                        WHERE id = ?";
        
                $stmt = Model::getConn()->prepare($sql);
                $stmt->bindValue(1, $this->user_id);
                $stmt->bindValue(2, $this->street);
                $stmt->bindValue(3, $this->number);
                $stmt->bindValue(4, $this->complement);
                $stmt->bindValue(5, $this->neighborhood);
                $stmt->bindValue(6, $this->city);
                $stmt->bindValue(7, $this->state);
                $stmt->bindValue(8, $this->zip_code);
                $stmt->bindValue(9, $this->country);
                $stmt->bindValue(10, $this->id);
        
                if ($stmt->execute()) {
                    return $this;
                } else {
                    print_r($stmt->errorInfo());
                    return null;
                }
            } catch (PDOException $e) {
                // Tratamento de exceção do PDO
                error_log("Erro ao atualizar endereço: " . $e->getMessage());
                throw new Exception("Erro ao atualizar endereço. Tente novamente mais tarde.");
            } catch (Exception $e) {
                // Tratamento de outras exceções
                error_log("Erro geral ao atualizar endereço: " . $e->getMessage());
                throw new Exception("Erro inesperado ao atualizar endereço. Tente novamente mais tarde.");
            }
        }
        

        public function delete($id) {
            try {
                $this->id = $id;
        
                $sql = "DELETE FROM address WHERE id = ?";
        
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
                error_log("Erro ao deletar endereço: " . $e->getMessage());
                throw new Exception("Erro ao deletar endereço. Tente novamente mais tarde.");
            } catch (Exception $e) {
                // Tratamento de outras exceções
                error_log("Erro geral ao deletar endereço: " . $e->getMessage());
                throw new Exception("Erro inesperado ao deletar endereço. Tente novamente mais tarde.");
            }
        }
        
    }
?>