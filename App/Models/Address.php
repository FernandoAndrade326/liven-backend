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

        public function getAll(){
            $sql = "SELECT * FROM address ORDER BY id DESC";

            $stmt = Model::getConn()->prepare($sql);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $result = $stmt->fetchAll(PDO::FETCH_OBJ);

                return $result;
            } else{
                return null;
            }
            
        }

        public function insert(){
            $sql = "INSERT INTO address 
            (user_id,
                street,
                number,
                complement,
                neighborhood,
                city,
                state,
                zip_code,
                country)
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

                if ($stmt->execute()){
                    //$this->id =Model::getConn()->getLastAddress();
                    return $this;
                } else{
                    print_r($stmt->errorInfo());
                    return null;
                }
        }

        public function getById($id){
            $sql = "SELECT * FROM address WHERE id = ?";
            $stmt = Model::getConn()->prepare($sql);
            $stmt->bindValue(1, $id);

            if ($stmt->execute()){
                $address = $stmt->fetch(PDO::FETCH_OBJ);

                if(!$address){
                    return null;
                }

                $this->id = $address->id;
                $this->user_id = $address->user_id;
                $this->street = $address->street;
                $this->number = $address->number;
                $this->complement = $address->complement;
                $this->neighborhood = $address->neighborhood;
                $this->city = $address->city;
                $this->state = $address->state;
                $this->zip_code = $address->zip_code;
                $this->country = $address->country;

                return $this;
            } else{
                return null;
            }

        }

        public function update($id){
            $this->id = $id;
            
            $sql = "UPDATE address SET street = ?, number = ?, complement = ?, neighborhood = ?, city = ?, state = ?, zip_code = ?, country =? WHERE id = ?";

            $stmt = Model::getConn()->prepare($sql);
            $stmt->bindValue(1, $this->street);
            $stmt->bindValue(2, $this->number);
            $stmt->bindValue(3, $this->complement);
            $stmt->bindValue(4, $this->neighborhood);
            $stmt->bindValue(5, $this->city);
            $stmt->bindValue(6, $this->state);
            $stmt->bindValue(7, $this->zip_code);
            $stmt->bindValue(8, $this->country);
            $stmt->bindValue(9, $this->id);

            if($stmt->execute()){
                print_r("Usuário: ".$this->id." - Atualizado com sucesso!");
                return $this;
            } else{
                print_r($stmt->errorInfo());
                return null;
            }
        }

        public function delete($id){
            $this->id = $id;

            $sql = "DELETE FROM address WHERE id = ? ";

            $stmt = Model::getConn()->prepare($sql);
            $stmt->bindValue(1, $this->id);

            if($stmt->execute()){
                print_r("Endereço: ".$this->id." - Excluído com sucesso!");
                return $this;
            } else{
                print_r($stmt->errorInfo());
                return null;
            }
        }
    }
?>