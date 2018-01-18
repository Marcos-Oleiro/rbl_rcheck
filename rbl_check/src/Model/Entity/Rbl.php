<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Rbl extends Entity {

    private $id;
    private $address;
    private $link;



    public function getId() {
        return $this->id;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getLink() {
        return $this->link;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setLink($link) {
        $this->link = $link;
    }

}
