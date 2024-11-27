<?php

require_once __DIR__.'/../services/Instituciones.php';

class Instituciones {
    private $service;

    private function generateTimeBasedId() {
        // Obtener la fecha actual en el formato: AAHHMMSS (año, hora, minuto, segundo)
        $id = (int)date('yHis'); // 'y' es el año en dos dígitos, 'His' es hora, minutos y segundos
    
        // Verificar que el ID esté dentro del rango de un entero de 32 bits
        if ($id > 2147483647) {
            throw new Exception('El ID generado supera el límite de un entero de 32 bits.');
        }
    
        return $id;
    }

    public function __construct() {
        $this->service = new InstitucionesServices(new Database());
    }

    public function getAll(){
        $instituciones = $this->service->getAll();
        return $instituciones;
    }
    
  

}

?>