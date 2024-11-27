<?php
class ActoService {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db->getConnection();
    }

    public function getAll(){
        $query = 'SELECT * FROM acto_admon;';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }    
    
}
?>