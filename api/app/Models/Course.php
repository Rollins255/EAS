<?php
class Department {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllDepartments() {
        $stmt = $this->db->query("SELECT * FROM departments");
        return $stmt->fetchAll();
    }

    // Add other department-related methods
}
?>