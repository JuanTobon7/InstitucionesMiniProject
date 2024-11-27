<?php
    require_once __DIR__.'/../database/index.php';
    class DirectivosServices {
        private $db;

        public function __construct(Database $db) {
            $this->db = $db->getConnection();
        }

        public function getAll(){
            $query = 'SELECT i.cod_inst,i.nomb_inst, d.nomb_directivo,c.nomb_cargo FROM instituciones i
                        JOIN inst_por_municipio inst ON i.cod_inst=inst.cod_inst
                        JOIN rectoria r ON inst.cod_inst=r.cod_inst
                        JOIN directivos d ON r.cod_directivo=d.cod_directivo
                        JOIN cargos c ON r.cod_cargo=C.cod_cargo
                        GROUP BY (i.cod_inst,d.nomb_directivo,c.nomb_cargo) ORDER BY i.cod_inst ASC;
';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        }

    }
?>