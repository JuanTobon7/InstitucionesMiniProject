<?php
class Database {
    private $host = "localhost";
    private $dbname = "instituciones";
    private $user = "juan";
    private $password = "Juan316";
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("pgsql:host={$this->host};dbname={$this->dbname}", $this->user, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    // Método para obtener la conexión PDO
    public function getConnection() {
        return $this->pdo;
    }

    // Método para ejecutar una consulta SELECT y devolver los resultados
    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Método para ejecutar una consulta INSERT, UPDATE o DELETE
    public function execute($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
}
