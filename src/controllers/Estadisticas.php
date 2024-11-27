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
        $result = null;
        if($id != null){
            $result = $this->service->getInstByAcademicById($id);
        }else{
            $result = $this->service->getInstByAcademic();
        }
        return $result;
    }

    public function getInstitutionsByDepartmentAndStatusById($id){
        $estadistica = $this->service->getInstitutionsByDepartmentAndStatusById($id);
        return $estadistica;   
    }

    public function getStatisticsBySectorAndDepartment($id1){
        $estadistica = null;
        if($id1 != null){
            $estadistica = $this->service->getStatisticsBySectorAndDepartmentBySector($id1);
        }else{
            $estadistica = $this->service->getStatisticsBySectorAndDepartment();
        }
        return $estadistica;
    }
    public function getStatisticsBySectorAndDepartmentById($id1,$id2){
        $estadistica = null;
        if($id1 == null && $id2 == null){
            $estadistica = $this->service->getStatisticsBySectorAndDepartment();
        }else if($id1 != null && $id2 == null){

            $estadistica = $this->service->getStatisticsBySectorAndDepartmentByDept($id1);
        }
        else{
            $estadistica = $this->service->getStatisticsBySectorAndDepartmentById($id1,$id2);
        }
        
        return $estadistica;
    }

    public function getStatisticsByAcademicCharacter($id){
        $estadistica = $this->service->getStatisticsByAcademicCharacter($id);
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