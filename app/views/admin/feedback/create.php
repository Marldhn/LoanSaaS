<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>


<form method="POST" action="/loansaas/public/index.php?url=feedback/store">
    <div class="form-group">
        <label>Your Message/Suggestion:</label>
        <textarea name="message" class="form-input" rows="5" required></textarea>
    </div>
    <button type="submit" class="btn-submit">Send to Admin</button>
</form>


<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>
