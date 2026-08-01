<?php require_once dirname(__DIR__, 2) . '/layouts/header.php'; ?>

<style>

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:24px;
}

.page-title{
    font-size:1.5rem;
    font-weight:700;
    color:#0f172a;
    margin:0 0 4px;
}

.page-subtitle{
    color:#64748b;
    font-size:.9rem;
    margin:0;
}

.filter-card{
    display:flex;
    gap:16px;
    margin-bottom:20px;
}

.search-wrapper{
    position:relative;
    flex:1;
}

.search-icon{
    position:absolute;
    left:14px;
    top:50%;
    transform:translateY(-50%);
    color:#94a3b8;
}

.search-input{
    width:100%;
    padding:12px 16px 12px 42px;
    border:1px solid #e2e8f0;
    border-radius:10px;
    outline:none;
    font-size:.9rem;
    background:#fff;
}

.search-input:focus{
    border-color:#6366f1;
}

.admin-list{
    background:transparent;
}

.admin-row{
    display:grid;
    grid-template-columns:2fr 1fr 180px;
    gap:20px;
    align-items:center;

    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:12px;

    padding:16px 20px;
    margin-bottom:12px;

    transition:.2s;
}

.admin-row:hover{
    background:#f8fafc;
}

.admin-row.header{
    background:transparent;
    border:none;
    font-size:.75rem;
    text-transform:uppercase;
    color:#64748b;
    font-weight:700;
    padding:8px 20px;
    margin-bottom:6px;
}

.admin-name{
    font-weight:700;
    color:#0f172a;
}

.role-badge{

    display:inline-block;

    background:#eef2ff;

    color:#4f46e5;

    padding:6px 14px;

    border-radius:50px;

    font-size:12px;

    font-weight:700;

    text-transform:capitalize;

}

.action-group{

display:flex;

justify-content:flex-end;

}

.reset-btn{

background:#eef2ff;

color:#4f46e5;

border:none;

padding:10px 16px;

border-radius:8px;

cursor:pointer;

font-weight:600;

transition:.2s;

}

.reset-btn:hover{

background:#6366f1;

color:#fff;

}

@media(max-width:768px){

.admin-row.header{

display:none;

}

.admin-row{

display:flex;

flex-direction:column;

align-items:flex-start;

gap:14px;

}

.action-group{

width:100%;

justify-content:flex-start;

}

}

.modal-overlay{

display:none;

position:fixed;

top:0;

left:0;

width:100%;

height:100%;

background:rgba(15,23,42,.55);

justify-content:center;

align-items:center;

z-index:9999;

}

.modal-content{

background:#fff;

width:95%;

max-width:450px;

border-radius:14px;

padding:25px;

}

.form-input{

width:100%;

padding:12px;

border:1px solid #d1d5db;

border-radius:8px;

margin-top:12px;

margin-bottom:20px;

box-sizing:border-box;

outline:none;

}

.form-input:focus{

border-color:#6366f1;

}

.btn-secondary{

background:#f1f5f9;

border:none;

padding:10px 18px;

border-radius:8px;

cursor:pointer;

font-weight:600;

}

.btn-primary{

background:#6366f1;

border:none;

padding:10px 18px;

border-radius:8px;

cursor:pointer;

font-weight:600;

color:#fff;

}

.btn-primary:hover{

background:#4f46e5;

}

</style>

<div class="page-header">

<div>

<h1 class="page-title">
Administrator Management
</h1>

<p class="page-subtitle">
Manage company administrators and reset their passwords.
</p>

</div>

</div>

<div class="filter-card">

<div class="search-wrapper">

<i class="fas fa-search search-icon"></i>

<input
type="text"
class="search-input"
id="searchAdmin"
placeholder="Search administrator..."
onkeyup="filterAdmins()">

</div>

</div>

<div class="admin-list">

<div class="admin-row header">

<div>Administrator</div>

<div>Role</div>

<div style="text-align:right;">Action</div>

</div>

<?php foreach($users as $u): ?>

<div
class="admin-row admin-item"
data-name="<?= strtolower(htmlspecialchars($u['username'])) ?>">

<div class="admin-name">

<?= htmlspecialchars($u['username']) ?>

</div>

<div>

<span class="role-badge">

<?= ucfirst(htmlspecialchars($u['role'])) ?>

</span>

</div>

<div class="action-group">

<button
class="reset-btn"
onclick="openResetModal(<?= $u['id'] ?>)">

<i class="fas fa-key"></i>

Reset Password

</button>

</div>

</div>

<?php endforeach; ?>

</div>

id="nextpart"
<!-- Reset Password Modal -->

<div id="resetModal" class="modal-overlay">

    <div class="modal-content">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">

            <h3 style="margin:0; color:#0f172a;">
                Reset Administrator Password
            </h3>

            <span 
                onclick="closeResetModal()"
                style="cursor:pointer; font-size:24px; color:#64748b;">
                &times;
            </span>

        </div>


        <p style="color:#64748b; font-size:.9rem;">
            You are about to reset this administrator's password.
        </p>


        <form id="resetForm" method="POST" action="">


            <label style="font-size:13px; font-weight:600; color:#475569;">
                New Password
            </label>


            <input 
                type="password"
                name="new_password"
                class="form-input"
                placeholder="Enter new password"
                required>


            <div style="
                display:flex;
                justify-content:flex-end;
                gap:10px;
            ">

                <button 
                    type="button"
                    class="btn-secondary"
                    onclick="closeResetModal()">

                    Cancel

                </button>


                <button 
                    type="submit"
                    class="btn-primary">

                    <i class="fas fa-key"></i>
                    Reset Password

                </button>


            </div>


        </form>


    </div>

</div>


<script>


// =============================
// Search Administrator
// =============================

function filterAdmins(){

    let search =
    document.getElementById('searchAdmin')
    .value
    .toLowerCase();


    let admins =
    document.querySelectorAll('.admin-item');


    admins.forEach(function(admin){

        let name =
        admin.getAttribute('data-name');


        if(name.includes(search)){

            admin.style.display="grid";

        }else{

            admin.style.display="none";

        }

    });

}



// =============================
// Open Reset Modal
// =============================

function openResetModal(userId){

    document
    .getElementById('resetModal')
    .style.display='flex';


    document
    .getElementById('resetForm')
    .action =
    '/loansaas/public/index.php?url=user/resetPassword/' + userId;

}



// =============================
// Close Modal
// =============================

function closeResetModal(){

    document
    .getElementById('resetModal')
    .style.display='none';

}



// Close when clicking outside

window.onclick=function(event){

    let modal =
    document.getElementById('resetModal');


    if(event.target === modal){

        modal.style.display="none";

    }

}



// Close with ESC key

document.addEventListener(
'keydown',
function(event){

    if(event.key==="Escape"){

        closeResetModal();

    }

});

</script>


<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>