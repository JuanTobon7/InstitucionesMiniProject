<?php

require_once __DIR__.'/../services/Estadisticas.php';

class Estadisticas {
    private $service;


    public function __construct() {
        $this->service = new EstadisticaServices(new Database());
        session_start();
    }
    
    public function getInstitutionsByDepartment(){
        $estadistica = $this->service->getInstitutionsByDepartment();
        return $estadistica;
    }

    public function getInstitutionsByDepartmentById($id){
        $estadistica = $this->service->getInstitutionsByDepartmentById($id);
        return $estadistica;
    }
    public function getInstByAcademic($id){
        return $this->service->getInstByAcademic($id);
    }

    public function getInstitutionsByDepartmentAndStatusById($id){
        $estadistica = $this->service->getInstitutionsByDepartmentAndStatusById($id);
        return $estadistica;   
    }

    public function getStatisticsBySectorAndDepartment(){
        $estadistica = $this->service->getStatisticsBySectorAndDepartment();
        return $estadistica;
    }
    public function getStatisticsBySectorAndDepartmentById($id1,$id2){
        $estadistica = $this->service->getStatisticsBySectorAndDepartmentById($id1,$id2);
        
        return $estadistica;
    }

    public function getStatisticsByAcademicCharacter(){
        $estadistica = $this->service->getStatisticsByAcademicCharacter();
        return $estadistica;
    }
    public function getStatisticsByAdministrativeAct(){
        $estadistica = $this->service->getStatisticsByAdministrativeAct();
        return $estadistica;
    }
    public function getStatisticsByAdministrativeActById($id){
        $estadistica = $this->service->getStatisticsByAdministrativeActById($id);
        return $estadistica;
    }
    public function getStatisticsByCreationNorm(){
        $estadistica = $this->service->getStatisticsByCreationNorm();
        return $estadistica;
    }
}
?>