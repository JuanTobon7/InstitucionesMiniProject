<?php
require_once __DIR__ . '/../services/Academico.php';

class Academico{
    private $service;

    public function __construct() {
        $this->service = new AcademicoServices(new Database());
    }    

    // Método para obtener todos los sectores (GET)
    public function getAll() {
        $academico = $this->service->getAll();
        return $academico;
    }
   
}