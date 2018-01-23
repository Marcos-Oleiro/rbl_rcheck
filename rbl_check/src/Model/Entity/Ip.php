<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Ip extends Entity {

    private $id;
    private $ipv4;
    private $ip_reverse;
    private $active;
    private $listed;
    private $service;
    protected $_accessible = [
        '*' => true
    ];

    public function getId() {
        return $this->id;
    }

    public function getIpv4() {
        return $this->ipv4;
    }

    public function getIp_reverse() {
        return $this->ip_reverse;
    }

    public function getActive() {
        return $this->active;
    }

    public function getListed() {
        return $this->listed;
    }

    public function getUsage() {
        return $this->usage;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIpv4($ipv4) {
        $this->ipv4 = $ipv4;
    }

    function setIp_reverse($ip_reverse) {
        $this->ip_reverse = $ip_reverse;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    public function setListed($listed) {
        $this->listed = $listed;
    }

    public function setUsage($usage) {
        $this->usage = $usage;
    }


}

?>