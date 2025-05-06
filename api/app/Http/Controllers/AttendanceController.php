<?php
require_once '../models/Employee.php';
require_once '../models/Department.php';

class AttendanceController {
    private $employee;
    private $department;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->employee = new Employee($db);
        $this->department = new Department($db);
    }

    public function markAttendance() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $employeeId = $_POST['employee_id'];
            $status = $_POST['status'];
            $date = date('Y-m-d');
            $time = date('H:i:s');

            // Check if attendance already marked
            $stmt = $this->db->prepare("SELECT * FROM attendance WHERE employee_id = ? AND date = ?");
            $stmt->execute([$employeeId, $date]);
            
            if ($stmt->rowCount() > 0) {
                // Update existing record
                $stmt = $this->db->prepare("UPDATE attendance SET time_out = ?, status = ? WHERE employee_id = ? AND date = ?");
                $stmt->execute([$time, $status, $employeeId, $date]);
            } else {
                // Create new record
                $stmt = $this->db->prepare("INSERT INTO attendance (employee_id, date, time_in, status) VALUES (?, ?, ?, ?)");
                $stmt->execute([$employeeId, $date, $time, $status]);
            }
            
            header("Location: ../views/attendance/success.php");
            exit();
        }
    }

    public function getAttendanceReport() {
        $stmt = $this->db->query("
            SELECT e.first_name, e.last_name, e.position, d.department_name, 
                   a.date, a.time_in, a.time_out, a.status
            FROM attendance a
            JOIN employees e ON a.employee_id = e.employee_id
            JOIN departments d ON e.department_id = d.department_id
            ORDER BY a.date DESC
        ");
        return $stmt->fetchAll();
    }
}
?>