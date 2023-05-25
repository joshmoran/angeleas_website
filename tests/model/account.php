<?php
namespace store\model;
require "src/model/customer.php";

class account extends customer {
    public $id;
    private $name;

    public function getName() {
        return $this->name;
    }

    public function setName( $new ) {
        // Code for changing Name
    }

}

?>