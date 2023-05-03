<?php 
namespace store\model;
require "src/model/customer.php";

class basket extends customer {
    private $basket_id;


    public function add() {

    }

    public function del() {

    }

    public function getID() {
        return $this->basket_id;
    }

    public function setName( $new ) {
        // Code for changing Name
    }
}

?>