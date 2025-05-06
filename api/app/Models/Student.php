<?php
class Employee {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllEmployees() {
        $stmt = $this->db->query("SELECT * FROM employees");
        return $stmt->fetchAll();
    }

    public function getEmployeeById($id) {
        $stmt = $this->db->prepare("SELECT * FROM employees WHERE employee_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function addEmployee($data) {
        $stmt = $this->db->prepare("INSERT INTO employees (first_name, last_name, email, phone, department_id, position, hire_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['phone'],
            $data['department_id'],
            $data['position'],
            $data['hire_date']
        ]);
    }

    // Add other employee-related methods as needed
}
?>