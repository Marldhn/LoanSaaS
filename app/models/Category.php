<?php
// app/models/Category.php
require_once __DIR__ . '/Loan.php'; 

class Category {
    protected $db;

    public function __construct() {
        // Instantiate Loan to get the database connection
        $loan = new Loan();
        $this->db = $loan->getDb();
    }

    public function create($data) {
        $sql = "INSERT INTO categories (company_id, type, name, description) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['company_id'],
            $data['type'],
            $data['name'],
            $data['description']
        ]);
    }

    public function getAllByCompany($company_id) {
        // Now $this->db is correctly defined from the constructor
        $sql = "SELECT * FROM categories WHERE company_id = ? ORDER BY type, name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$company_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}