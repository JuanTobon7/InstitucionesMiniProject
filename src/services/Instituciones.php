<?php
    require_once __DIR__.'/../database/index.php';
    class InstitucionesServices {
        private $db;

        public function __construct(Database $db) {
            $this->db = $db->getConnection();
        }

        public function getAll(){
            $query = 'SELECT * FROM instituciones;';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        }

    }
?>