<?php
require_once __DIR__ . '/../services/Acto.php';
class Acto {
    private $service;

    public function __construct() {
        $this->service = new ActoService(new Database());
    }

    public function getAll(){
        $acto = $this->service->getAll();   
        return $acto;     
    }
}

?>