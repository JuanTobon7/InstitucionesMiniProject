<?php
    require_once __DIR__.'/../database/index.php';
    class EstadisticaServices {
        private $db;

        public function __construct(Database $db) {
            $this->db = $db->getConnection();
        }

        public function getInstitutionsByDepartment(){
            $query = "SELECT  d.nomb_depto,est.nomb_estado,COUNT(inst.*) AS total_instituciones FROM inst_por_municipio inst
                JOIN estados est ON est.cod_estado = inst.cod_estado
                JOIN municipios m ON inst.cod_munic = m.cod_munic
                JOIN departamentos d ON d.cod_depto = m.cod_depto
                GROUP  BY d.nomb_depto,est.nomb_estado ORDER BY d.nomb_depto ASC; 
            ";
            $stms = $this->db->prepare($query);
            $stms->execute();
            return $stms->fetchAll();
        }

        public function getInstByAcademic($id){
            $query = "SELECT i.nomb_inst,i.cod_inst ,sec.nomb_sector, car.nomb_academ, mun.nomb_munic,dep.nomb_depto, es.nomb_estado, inst.programas_vigente, inst.acreditada FROM instituciones i 
                        JOIN sectores sec ON i.cod_sector=sec.cod_sector
                        JOIN caracter_academico car ON i.cod_academ=car.cod_academ
                        JOIN inst_por_municipio inst ON i.cod_inst=inst.cod_inst
                        JOIN municipios mun ON inst.cod_munic=mun.cod_munic
                        JOIN estados es ON inst.cod_estado=es.cod_estado
                        JOIN departamentos dep ON mun.cod_depto=dep.cod_depto
                        WHERE car.cod_academ = :cod_academ
                        ORDER BY i.nomb_inst ASC;
            ";
            $stms = $this->db->prepare($query);
            $stms->bindParam('cod_academ',$id);
            $stms->execute();
            return $stms->fetchAll();
        }
        public function getInstitutionsByDepartmentById($id){
            $query = "SELECT i.nomb_inst,i.cod_inst ,sec.nomb_sector, car.nomb_academ, mun.nomb_munic,dep.nomb_depto, es.nomb_estado, inst.programas_vigente, inst.acreditada FROM instituciones i 
                        JOIN sectores sec ON i.cod_sector=sec.cod_sector
                        JOIN caracter_academico car ON i.cod_academ=car.cod_academ
                        JOIN inst_por_municipio inst ON i.cod_inst=inst.cod_inst
                        JOIN municipios mun ON inst.cod_munic=mun.cod_munic
                        JOIN estados es ON inst.cod_estado=es.cod_estado
                        JOIN departamentos dep ON mun.cod_depto=dep.cod_depto
                        WHERE dep.cod_depto = :cod_depto
                        ORDER BY i.nomb_inst ASC;
            ";
            $stms = $this->db->prepare($query);
            $stms->bindParam('cod_depto',$id);
            $stms->execute();
            return $stms->fetchAll();
        }

        public function getStatisticsByAcademicCharacter(){
            $query = "SELECT  d.nomb_depto,est.nomb_estado,COUNT(inst.*) AS total_instituciones FROM inst_por_municipio inst
                JOIN estados est ON est.cod_estado = inst.cod_estado
                JOIN municipios m ON inst.cod_munic = m.cod_munic
                JOIN departamentos d ON d.cod_depto = m.cod_depto
                WHERE d.cod_depto = :cod_depto
                GROUP  BY d.nomb_depto,est.nomb_estado ORDER BY d.nomb_depto ASC; 
                ";
            $stms = $this->db->prepare($query);
            $stms->bindParam('cod_depto',$id);
            $stms->execute();
            return $stms->fetchAll();
        }
        public function getInstitutionsByDepartmentAndStatusById($id){

            $query = "SELECT  d.nomb_depto,est.nomb_estado,COUNT(inst.*) AS total_instituciones FROM inst_por_municipio inst
                JOIN estados est ON est.cod_estado = inst.cod_estado
                JOIN municipios m ON inst.cod_munic = m.cod_munic
                JOIN departamentos d ON d.cod_depto = m.cod_depto
                WHERE d.cod_depto = :cod_depto
                GROUP  BY d.nomb_depto,est.nomb_estado ORDER BY d.nomb_depto ASC; 
            ";
            $stms = $this->db->prepare($query);
            $stms->bindParam('cod_depto',$id);
            $stms->execute();
            return $stms->fetchAll();
        }


        public function getStatisticsBySectorAndDepartment(){
            $query = "SELECT  dept.nomb_depto,sect.nomb_sector,COUNT(inst_pm.*) as total_inst 
                FROM instituciones inst
                JOIN sectores sect ON sect.cod_sector = inst.cod_sector
                JOIN  inst_por_municipio inst_pm ON inst_pm.cod_inst = inst.cod_inst
                JOIN municipios m ON m.cod_munic = inst_pm.cod_munic
                JOIN departamentos dept ON dept.cod_depto = m.cod_depto
                GROUP BY dept.nomb_depto,sect.nomb_sector
                ORDER BY dept.nomb_depto ASC;
                ";
            $stms = $this->db->prepare($query);
            $stms->execute();
            return $stms->fetchAll();
        }

        public function getStatisticsBySectorAndDepartmentById($id1,$id2){
            $query = "SELECT i.nomb_inst,i.cod_inst ,sec.nomb_sector, car.nomb_academ, mun.nomb_munic,dep.nomb_depto, es.nomb_estado, inst.programas_vigente, inst.acreditada FROM instituciones i 
                        JOIN sectores sec ON i.cod_sector=sec.cod_sector
                        JOIN caracter_academico car ON i.cod_academ=car.cod_academ
                        JOIN inst_por_municipio inst ON i.cod_inst=inst.cod_inst
                        JOIN municipios mun ON inst.cod_munic=mun.cod_munic
                        JOIN estados es ON inst.cod_estado=es.cod_estado
                        JOIN departamentos dep ON mun.cod_depto=dep.cod_depto
                        WHERE dep.cod_depto = :cod_depto AND sec.cod_sector= :cod_sector
                        ORDER BY i.nomb_inst ASC;
            ";
            $stms = $this->db->prepare($query);
            $stms->bindParam('cod_depto',$id1);
            $stms->bindParam('cod_sector',$id2);
            $stms->execute();
            return $stms->fetchAll();
        }

        public function getStatisticsByAdministrativeAct(){
            $query = "SELECT act.nomb_admon, COUNT(inst.*) AS total_inst FROM inst_por_municipio inst
                JOIN acto_admon act ON act.cod_admon = inst.cod_admon
                GROUP BY act.nomb_admon 
                HAVING act.nomb_admon = 'Gobierno Nacional' OR act.nomb_admon = 'Congreso de la Republica' OR act.nomb_admon = 'Congreso de Colombia' 
                OR act.nomb_admon = 'Ministerio de Educación Nacional'
                ORDER BY act.nomb_admon DESC;
                ";
            $stms = $this->db->prepare($query);
            $stms->execute();
            return $stms->fetchAll();
        }

        public function getStatisticsByAdministrativeActById($id){
            $query = "SELECT i.nomb_inst,i.cod_inst ,sec.nomb_sector, ac.nomb_admon, mun.nomb_munic,dep.nomb_depto, es.nomb_estado, inst.programas_vigente, inst.acreditada FROM instituciones i 
                        JOIN sectores sec ON i.cod_sector=sec.cod_sector
                        JOIN caracter_academico car ON i.cod_academ=car.cod_academ
                        JOIN inst_por_municipio inst ON i.cod_inst=inst.cod_inst
                        JOIN municipios mun ON inst.cod_munic=mun.cod_munic
                        JOIN estados es ON inst.cod_estado=es.cod_estado
                        JOIN departamentos dep ON mun.cod_depto=dep.cod_depto
                        JOIN acto_admon ac ON ac.cod_admon=inst.cod_admon
                        WHERE inst.cod_admon = :cod_admon
                        ORDER BY i.nomb_inst ASC;
            ";
            $stms = $this->db->prepare($query);
            $stms->bindParam('cod_admon',$id);
            $stms->execute();
            return $stms->fetchAll();
        }

        public function getStatisticsByCreationNorm(){
            $query = "SELECT nc.nomb_norma, COUNT(inst.*) AS total_inst FROM inst_por_municipio inst
                JOIN norma_creacion nc ON  inst.cod_norma = nc.cod_norma
                GROUP BY nc.nomb_norma;
                ";
            $stms = $this->db->prepare($query);
            $stms->execute();
            return $stms->fetchAll();
        }
        

    }
?>