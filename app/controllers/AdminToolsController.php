<?php
require_once __DIR__ . '/../models/Loan.php'; 

class AdmintoolsController {
    
    // This matches the "exportLogs" part of your URL: admin_tools/exportLogs
    public function exportLogs() {
        if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
            die("Unauthorized Access.");
        }

        $db = (new Loan())->getDb();
        $logs = $db->query("SELECT * FROM activity_logs ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

        if (empty($logs)) {
            die("No logs available.");
        }

        // Output clean HTML for printing/PDF
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Activity Log Report</title>
            <style>
                body { font-family: sans-serif; padding: 40px; }
                h1 { color: #6366f1; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th { background: #f8fafc; text-align: left; padding: 12px; border-bottom: 2px solid #e2e8f0; }
                td { padding: 12px; border-bottom: 1px solid #f1f5f9; }
                tr:nth-child(even) { background: #fafafa; }
            </style>
        </head>
        <body>
            <h1>Activity Log Report</h1>
            <p>Generated on: " . date('Y-m-d H:i') . "</p>
            <table>
                <tr><th>ID</th><th>Action</th><th>Table</th><th>Details</th><th>Timestamp</th></tr>";
        
        foreach ($logs as $log) {
    // Use ?? '' to provide a blank space if the column doesn't exist
    $id = $log['id'] ?? 'N/A';
    $action = $log['action'] ?? 'N/A';
    $table = $log['table_name'] ?? ($log['table'] ?? 'N/A'); // Try 'table_name' or 'table'
    $details = $log['details'] ?? ($log['description'] ?? ''); // Try 'details' or 'description'
    $timestamp = $log['timestamp'] ?? ($log['created_at'] ?? ''); // Try 'timestamp' or 'created_at'

    echo "<tr>
        <td>" . htmlspecialchars($id) . "</td>
        <td>" . htmlspecialchars($action) . "</td>
        <td>" . htmlspecialchars($table) . "</td>
        <td>" . htmlspecialchars($details) . "</td>
        <td>" . htmlspecialchars($timestamp) . "</td>
    </tr>";
}
        
        echo "</table>
            <script>window.onload = function() { window.print(); };</script>
        </body>
        </html>";
    }
}