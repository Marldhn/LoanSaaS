<?php
require_once __DIR__ . '/../core/Model.php';

class Loan extends Model {

    public function getById($id) {
        $sql = "SELECT loans.*, b.first_name, b.last_name, b.phone, b.address 
                FROM loans 
                LEFT JOIN borrowers b ON loans.borrower_id = b.id 
                WHERE loans.id = :id";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllByCompany($company_id) {
        $stmt = $this->conn->prepare("SELECT * FROM loans WHERE company_id = ? ORDER BY id DESC");
        $stmt->execute([$company_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getApprovedLoansByCompany($company_id) {
        $sql = "SELECT l.*, b.first_name, b.last_name 
                FROM loans l
                LEFT JOIN borrowers b ON l.borrower_id = b.id
                WHERE l.company_id = ? AND (l.status = 'approved' OR l.status = 'Active')";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$company_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch upcoming payments within a given timeframe (default: 14 days)
     */
    public function getUpcomingPayments($company_id, $days = 14) {
        $today = date('Y-m-d');
        $futureDate = date('Y-m-d', strtotime("+$days days"));

        $sql = "SELECT l.*, b.first_name, b.last_name,
                       DATEDIFF(l.due_date, :today) AS days_left
                FROM loans l
                LEFT JOIN borrowers b ON l.borrower_id = b.id
                WHERE l.company_id = :company_id 
                  AND (l.status = 'Active' OR l.status = 'approved')
                  AND l.due_date BETWEEN :today AND :futureDate
                ORDER BY l.due_date ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'company_id' => $company_id,
            'today'      => $today,
            'futureDate' => $futureDate
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch overdue payments (due date is prior to today)
     */
    public function getOverduePayments($company_id) {
        $today = date('Y-m-d');

        $sql = "SELECT l.*, b.first_name, b.last_name,
                       DATEDIFF(:today, l.due_date) AS days_overdue
                FROM loans l
                LEFT JOIN borrowers b ON l.borrower_id = b.id
                WHERE l.company_id = :company_id 
                  AND (l.status = 'Active' OR l.status = 'Overdue')
                  AND l.due_date < :today
                ORDER BY l.due_date ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'company_id' => $company_id,
            'today'      => $today
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPaginatedLoans($company_id, $limit, $offset, $filters = []) {
        $where = ["company_id = ?"];
        $params = [$company_id];

        if (!empty($filters['search'])) {
            $where[] = "(b.first_name LIKE ? OR b.last_name LIKE ?)";
            $params[] = "%{$filters['search']}%";
            $params[] = "%{$filters['search']}%";
        }
        if (!empty($filters['status'])) {
            $where[] = "loans.status = ?";
            $params[] = $filters['status'];
        }
        if (!empty($filters['date_from'])) {
            $where[] = "loans.created_at >= ?";
            $params[] = $filters['date_from'];
        }

        $sql = "SELECT loans.*, b.first_name, b.last_name, loans.status as display_status 
                FROM loans 
                LEFT JOIN borrowers b ON loans.borrower_id = b.id 
                WHERE " . implode(" AND ", $where) . " 
                ORDER BY loans.id DESC LIMIT $limit OFFSET $offset";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalLoans($company_id, $filters = []) {
        $where = ["company_id = ?"];
        $params = [$company_id];

        if (!empty($filters['search'])) {
            $where[] = "(b.first_name LIKE ? OR b.last_name LIKE ?)";
            $params[] = "%{$filters['search']}%";
            $params[] = "%{$filters['search']}%";
        }
        if (!empty($filters['status'])) {
            $where[] = "loans.status = ?";
            $params[] = $filters['status'];
        }

        $sql = "SELECT COUNT(*) FROM loans LEFT JOIN borrowers b ON loans.borrower_id = b.id WHERE " . implode(" AND ", $where);
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }
}