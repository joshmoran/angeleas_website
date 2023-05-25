<?php

class CustomerAccount {
    public $id;
    public int $order;

    public function __construct( $id, $order ){
        $this->$id = $id;
        $this->$order = $order;
    }
    public function getId() {
        return $this->id;
    }
    public function basketAdd(){

    }

    public function basketDel(){
        
    }
}

//$customer = new CustomerAccount(1, 2);


?>