<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Ip_Rbl extends Entity {

    private $id_ip;
    private $id_rbl;
    

    function getId_ip() {
        return $this->id_ip;
    }

    function getId_rbl() {
        return $this->id_rbl;
    }

    function setId_ip($id_ip) {
        $this->id_ip = $id_ip;
    }

    function setId_rbl($id_rbl) {
        $this->id_rbl = $id_rbl;
    }




}
