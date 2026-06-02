<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>

    .feedback-container {
    display: flex;
    justify-content: center;
    padding: 40px 20px;
    background-color: #f9fafb;
}

.feedback-card {
    background: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px;
}

.feedback-card h2 { margin-top: 0; color: #1f2937; }
.feedback-card p { color: #6b7280; margin-bottom: 20px; }

.form-group { margin-bottom: 20px; }

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #374151;
}

.form-input {
    width: 100%;
    padding: 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.2s, box-shadow 0.2s;
    box-sizing: border-box; /* Ensures padding doesn't affect width */
}

.form-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}

.btn-submit {
    width: 100%;
    padding: 12px;
    background-color: #3b82f6;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.2s;
}

.btn-submit:hover {
    background-color: #2563eb;
}
</style>

<div class="feedback-container">
    <div class="feedback-card">
        <h2>We Value Your Feedback</h2>
        <p>Have a suggestion or found an issue? Let us know below.</p>
        
        <form method="POST" action="/loansaas/public/index.php?url=feedback/store">
            <div class="form-group">
                <label for="message">Your Message</label>
                <textarea 
                    name="message" 
                    id="message" 
                    class="form-input" 
                    rows="6" 
                    placeholder="Tell us what you think..." 
                    required></textarea>
            </div>
            
            <button type="submit" class="btn-submit">
                Submit Feedback
            </button>
        </form>
    </div>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>