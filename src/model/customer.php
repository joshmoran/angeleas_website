<?php
namespace store\model;

class customer {
    public $id;
    private $name;
    public $active;

    public function __construct() {
        $this->active = true;
    }

    public function setName($new) {
        $this->name = $new;
    }

    public function getName() {
        return $this->name;
    }
    
}

?>
