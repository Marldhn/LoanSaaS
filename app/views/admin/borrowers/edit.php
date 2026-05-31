<?php
// Look up two levels: admin/ -> views/ -> layouts/
require_once dirname(__DIR__, 2) . '/layouts/header.php'; 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Borrower</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #218838;
        }

        .preview {
            margin-top: 10px;
        }

        .preview img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Edit Borrower</h2>

    <form id="edit-borrower-form" method="POST" enctype="multipart/form-data" 
      action="/loansaas/public/index.php?url=borrower/update/<?= $borrower['id'] ?>">

    <div class="form-row">
        <label>First Name</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($borrower['first_name'] ?? '') ?>" required>
    </div>

    <div class="form-row">
        <label>Last Name</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($borrower['last_name'] ?? '') ?>" required>
    </div>

    <div class="form-row">
        <label>Contact</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($borrower['phone'] ?? '') ?>" required>
    </div>

    <div class="form-row">
        <label>Address</label>
        <input type="text" name="address" value="<?= htmlspecialchars($borrower['address'] ?? '') ?>" required>
    </div>

    <div class="form-row">
        <label>Birthdate</label>
        <input type="date" name="birthdate" value="<?= htmlspecialchars($borrower['birthdate'] ?? '') ?>">
    </div>

    <div class="form-row">
        <label>Occupation</label>
        <input type="text" name="occupation" value="<?= htmlspecialchars($borrower['occupation'] ?? '') ?>">
    </div>

        <label>ID Picture</label>
        <input type="file" name="id_picture">

        <?php if (!empty($borrower['id_picture'])): ?>
            <div class="preview">
                <p>Current ID:</p>
                <img src="/LoanManagement/public/uploads/ids/<?= $borrower['id_picture'] ?>">
            </div>
        <?php endif; ?>

        <label>Borrower Picture</label>
        <input type="file" name="borrower_picture">

        <?php if (!empty($borrower['borrower_picture'])): ?>
            <div class="preview">
                <p>Current Photo:</p>
                <img src="/LoanManagement/public/uploads/borrowers/<?= $borrower['borrower_picture'] ?>">
            </div>
        <?php endif; ?>



        <div class="card" style="margin-top: 20px; background: #f8fafc;">
    <h3>Edit Collateral</h3>
    <div class="grid-container">
        <input type="hidden" name="collateral_id" value="<?= $collateral['id'] ?? '' ?>">
        
        <div class="form-group">
            <label>Item Name</label>
            <input type="text" name="collateral_name" value="<?= htmlspecialchars($collateral['item_name'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Estimated Value</label>
            <input type="number" name="collateral_value" value="<?= htmlspecialchars($collateral['estimated_value'] ?? '') ?>">
        </div>
    </div>
</div>
        <button type="submit">Update Borrower</button>

    </form>

</div>

</body>
</html>


<?php 
require_once dirname(__DIR__, 2) . '/layouts/footer.php'; 
?>