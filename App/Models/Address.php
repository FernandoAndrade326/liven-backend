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
    }
?>