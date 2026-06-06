<?php 
// Go up 3 levels to reach the root app folder: app/views/superadmin/feedback/index.php -> app/
require_once dirname(__DIR__, 2) . '/layouts/header.php'; 
?>

<style>
    /* Scoped CSS for this page only */
    .feedback-container { padding: 20px; }
    .feedback-table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; }
    .feedback-table th, .feedback-table td { padding: 12px; border: 1px solid #e2e8f0; }
    .feedback-table thead { background: #f8fafc; text-align: left; }
    
    /* Modal Styles */
    .modal-overlay { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center; }
    .modal-content { background:white; padding:25px; border-radius:12px; width:500px; position:relative; }
</style>

<div class="feedback-container">
    <h2>User Feedback & Suggestions</h2>
    
    <table class="feedback-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Message</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $msg): ?>
            <tr>
                <td><?= htmlspecialchars($msg['username']) ?></td>
                <td><?= htmlspecialchars(substr($msg['message'], 0, 50)) ?>...</td>
                <td><?= $msg['created_at'] ?></td>
                <td>
                    <button onclick='viewFeedback(<?= json_encode($msg) ?>)' 
                            style="background:none; border:none; color:#6366f1; cursor:pointer; font-size: 1.2rem;">
                        <i class="fas fa-eye"></i>
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="feedbackModal" class="modal-overlay">
    <div class="modal-content">
        <button onclick="document.getElementById('feedbackModal').style.display='none'" style="position:absolute; top:15px; right:15px; border:none; background:none; cursor:pointer; font-size:20px;">&times;</button>
        <h3>Feedback Details</h3>
        <p><strong>User:</strong> <span id="modalUser"></span></p>
        <p><strong>Message:</strong></p>
        <p id="modalMessage" style="background:#f8fafc; padding:10px; border-radius:6px;"></p>
        <div id="modalImageContainer" style="display:none; margin-top:15px;">
            <p><strong>Screenshot:</strong></p>
            <img id="modalImage" src="" style="width:100%; border-radius:8px; border:1px solid #e2e8f0;">
        </div>
    </div>
</div>

<script>
function viewFeedback(msg) {
    document.getElementById('modalUser').innerText = msg.username;
    document.getElementById('modalMessage').innerText = msg.message;
    const imgContainer = document.getElementById('modalImageContainer');
    if (msg.image_path) {
        document.getElementById('modalImage').src = '/loansaas/public/' + msg.image_path;
        imgContainer.style.display = 'block';
    } else {
        imgContainer.style.display = 'none';
    }
    document.getElementById('feedbackModal').style.display = 'flex';
}
</script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>