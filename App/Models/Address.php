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
    }
?>