<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<div class="main-content" style="padding: 20px;">
    <h2>User Feedback & Suggestions</h2>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff;">
        <thead>
            <tr style="background: #f8fafc; text-align: left;">
                <th style="padding: 12px; border: 1px solid #e2e8f0;">User</th>
                <th style="padding: 12px; border: 1px solid #e2e8f0;">Message</th>
                <th style="padding: 12px; border: 1px solid #e2e8f0;">Date</th>
                <th style="padding: 12px; border: 1px solid #e2e8f0;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $msg): ?>
            <tr>
                <td style="padding: 12px; border: 1px solid #e2e8f0;"><?= htmlspecialchars($msg['username']) ?></td>
                <td style="padding: 12px; border: 1px solid #e2e8f0;"><?= htmlspecialchars(substr($msg['message'], 0, 50)) ?>...</td>
                <td style="padding: 12px; border: 1px solid #e2e8f0;"><?= $msg['created_at'] ?></td>
                <td style="padding: 12px; border: 1px solid #e2e8f0;">
                    <!-- Eye Icon Trigger -->
                    <button onclick="viewFeedback(<?= htmlspecialchars(json_encode($msg)) ?>)" 
                            style="background:none; border:none; color:#6366f1; cursor:pointer; font-size: 1.2rem;">
                        <i class="fas fa-eye"></i>
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Details Modal -->
<div id="feedbackModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:white; padding:25px; border-radius:12px; width:500px; position:relative;">
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