<?php
    require_once __DIR__.'/../database/index.php';
    class EntidadesEducativasService {
        private $db;

        public function __construct(Database $db) {
            $this->db = $db->getConnection();
        }

        public function getAll(){
            $query = 'SELECT i.nomb_inst,i.cod_inst ,sec.nomb_sector, car.nomb_academ, mun.nomb_munic,dep.nomb_depto, es.nomb_estado, inst.programas_vigente, inst.acreditada FROM instituciones i 
                        JOIN sectores sec ON i.cod_sector=sec.cod_sector
                        JOIN caracter_academico car ON i.cod_academ=car.cod_academ
                        JOIN inst_por_municipio inst ON i.cod_inst=inst.cod_inst
                        JOIN municipios mun ON inst.cod_munic=mun.cod_munic
                        JOIN estados es ON inst.cod_estado=es.cod_estado
                        JOIN departamentos dep ON mun.cod_depto=dep.cod_depto
                        ORDER BY i.nomb_inst ASC;
                        ';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function create($id,$name, $sector, $caracterAcademico){
            try{

                $query = 'INSERT INTO instituciones (cod_inst,nomb_inst,cod_sector,cod_academ) VALUES (:cod_inst,:nomb_inst,:cod_sector,:cod_academ);';
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':cod_inst', $id);
                $stmt->bindParam(':nomb_inst', $name);
                $stmt->bindParam(':cod_sector', $sector);
                $stmt->bindParam(':cod_academ', $caracterAcademico);
                $stmt->execute();
                return ['success' => true];
            }catch (PDOException $e) {
                // Capturamos el error SQLSTATE y verificamos si es el caso esperado
                if ($e->getCode() === 'P0001') { // Código SQLSTATE de "raise exception"
                    // Extraer mensaje personalizado del trigger
                    return ['error' => $e->getMessage()];
                } else {
                    // Manejar otros errores
                    return ['error' => 'Ocurrió un error al intentar guardar la institución.'];
                }
            }
        }

        public function update($id, $name, $sector, $caracterAcademico){
            $query = 'UPDATE instituciones SET nomb_inst = :nomb_inst, cod_sector = :cod_sector, cod_academ = :cod_academ WHERE cod_inst = :cod_inst;';
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':cod_inst', $id);
            $stmt->bindParam(':nomb_inst', $name);
            $stmt->bindParam(':cod_sector', $sector);
            $stmt->bindParam(':cod_academ', $caracterAcademico);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function delete($id){
            $query = 'DELETE FROM instituciones WHERE cod_inst = :cod_inst;';
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':cod_inst', $id);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        
        
        public function getInstByDeptStatus($codEstado,$codDept){
            $query = "
                SELECT instP.nomb_inst,mun.nomb_munic,depto.nomb_depto,inst.direccion
                FROM instituciones instP
                JOIN cobertura c ON c.cod_inst = instP.cod_inst
                JOIN municipios mun ON mun.cod_munic = c.cod_munic
                JOIN departamentos depto ON depto.cod_depto = mun.cod_depto
                JOIN inst_por_municipio inst  ON inst.cod_inst = instP.cod_inst
                WHERE cod_estado = :cod_estado AND depto.cod_depto = :cod_depto;
            ";
            $stms = $this->db->prepare($query);
            $stms->bindParam('cod_estado',$codEstado);
            $stms->bindParam('cod_depto',$codDept);
            $stms->execute();
            return $stms->fetchAll();
        }
        
        public function getByAcademicCHaracterById($caracterAcademico){
            $query = "
                SELECT instP.nomb_inst,mun.nomb_munic,dept.nomb_depto,inst.direccion,cad.nomb_academ
                FROM instituciones instP
                JOIN cobertura c ON c.cod_inst = instP.cod_inst
                JOIN municipios mun ON mun.cod_munic = c.cod_munic
                JOIN departamentos dept ON dept.cod_depto = mun.cod_depto
                JOIN inst_por_municipio inst  ON inst.cod_inst = instP.cod_inst
                JOIN caracter_academico cad ON cad.cod_academ = instP.cod_academ
                 WHERE cad.cod_academ = :caracter_academico;
            ";
            $stms = $this->db->prepare($query);
            $stms->bindParam('caracter_academico',$caracterAcademico);
            $stms->execute();
            return $stms->fetchAll();
        }        
        public function getByAcademicCHaracter(){
            $query = "
                SELECT instP.nomb_inst,mun.nomb_munic,dept.nomb_depto,inst.direccion,cad.nomb_academ
                FROM instituciones instP
                JOIN cobertura c ON c.cod_inst = instP.cod_inst
                JOIN municipios mun ON mun.cod_munic = c.cod_munic
                JOIN departamentos dept ON dept.cod_depto = mun.cod_depto
                JOIN inst_por_municipio inst  ON inst.cod_inst = instP.cod_inst
                JOIN caracter_academico cad ON cad.cod_academ = instP.cod_academ;
            ";
            $stms = $this->db->prepare($query);
            $stms->execute();
            return $stms->fetchAll();
        }

        public function instBySector($codSector){
            $query = "
                     SELECT instP.nomb_inst,mun.nomb_munic,dept.nomb_depto,inst.direccion
                FROM instituciones instP
                JOIN cobertura c ON c.cod_inst = instP.cod_inst
                JOIN municipios mun ON mun.cod_munic = c.cod_munic
                JOIN departamentos dept ON dept.cod_depto = mun.cod_depto
                JOIN inst_por_municipio inst  ON inst.cod_inst = instP.cod_inst
                 WHERE instP.cod_sector = :cod_sector;
            ";
            $stms = $this->db->prepare($query);
            $stms->bindParam('cod_sector',$codSector);
            $stms->execute();
            return $stms->fetchAll();
        }

        public function instBySectorDept($codSector,$codDept){
            $query = "
                     SELECT instP.nomb_inst,mun.nomb_munic,dept.nomb_depto,inst.direccion
                FROM instituciones instP
                JOIN cobertura c ON c.cod_inst = instP.cod_inst
                JOIN municipios mun ON mun.cod_munic = c.cod_munic
                JOIN departamentos dept ON dept.cod_depto = mun.cod_depto
                JOIN inst_por_municipio inst  ON inst.cod_inst = instP.cod_inst
                 WHERE instP.cod_sector = :cod_sector AND dept.cod_depto = :cod_dept;
            ";
            $stms = $this->db->prepare($query);
            $stms->bindParam('cod_sector',$codSector);
            $stms->bindParam('cod_dept',$codDept);
            $stms->execute();
            return $stms->fetchAll();
        }


        public function actoAdmin(){
            $query = "SELECT * FROM acto_admon;";
            $stms = $this->db->prepare($query);
            $stms->execute();
            return $stms->fetchAll();
        }

    }
?>