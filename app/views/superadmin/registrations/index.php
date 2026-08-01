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
    font-size:.875rem;
    margin:0;
}

.filter-card{
    margin-bottom:20px;
}

.search-wrapper{
    position:relative;
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
    padding:12px 16px 12px 40px;
    border:1px solid #e2e8f0;
    border-radius:8px;
    background:#fff;
    outline:none;

}

.search-input:focus{

    border-color:#6366f1;

}

.registration-list{

    background:transparent;

}

.registration-row{

    display:grid;

    grid-template-columns:
    1.6fr
    1.2fr
    120px
    140px
    120px
    70px;

    gap:18px;

    align-items:center;

    background:#fff;

    border:1px solid #e2e8f0;

    border-radius:12px;

    padding:16px 20px;

    margin-bottom:12px;

    transition:.2s;

}

.registration-row:hover{

    background:#f8fafc;

}

.registration-row.header{

    background:#fff;

    border:none;

    font-size:.75rem;

    font-weight:700;

    color:#64748b;

    text-transform:uppercase;

    letter-spacing:.05em;

    margin-bottom:4px;

}

.status{

    display:inline-block;

    padding:5px 12px;

    border-radius:20px;

    font-size:.8rem;

    font-weight:600;

}

.pending{

    background:#fef3c7;

    color:#b45309;

}

.approved{

    background:#dcfce7;

    color:#166534;

}

.rejected{

    background:#fee2e2;

    color:#b91c1c;

}

.action-group{

    display:flex;

    justify-content:flex-end;

}

.icon-btn{

    width:34px;

    height:34px;

    border:none;

    border-radius:8px;

    background:#f1f5f9;

    color:#64748b;

    cursor:pointer;

    transition:.2s;

}

.icon-btn:hover{

    background:#e0e7ff;

    color:#4f46e5;

}

.modal-overlay{

    display:none;

    position:fixed;

    top:0;

    left:0;

    width:100%;

    height:100%;

    background:rgba(15,23,42,.55);

    backdrop-filter:blur(2px);

    justify-content:center;

    align-items:center;

    z-index:9999;

}

.modal-content{

    background:#fff;

    width:90%;

    max-width:500px;

    padding:24px;

    border-radius:12px;

    position:relative;

}

.info{

    margin-bottom:14px;

}

.info strong{

    display:block;

    color:#475569;

    font-size:.8rem;

    margin-bottom:4px;

}

.btn{

    border:none;

    padding:10px 18px;

    border-radius:8px;

    cursor:pointer;

    font-weight:600;

}

.btn-secondary{

    background:#f1f5f9;

    color:#475569;

}

.btn-success{

    background:#16a34a;

    color:#fff;

}

.btn-danger{

    background:#dc2626;

    color:#fff;

}

@media(max-width:768px){

.registration-row.header{

display:none;

}

.registration-row{

display:flex;

flex-direction:column;

align-items:flex-start;

gap:12px;

}

.registration-row>div{

width:100%;

display:flex;

justify-content:space-between;

}

.registration-row>div::before{

content:attr(data-label);

font-size:.75rem;

font-weight:700;

text-transform:uppercase;

color:#64748b;

}

}

</style>

<div class="page-container">

<div class="page-header">

<div>

<h1 class="page-title">
Registration Requests
</h1>

<p class="page-subtitle">
Approve or reject newly registered companies.
</p>

</div>

</div>

<div class="filter-card">

<div class="search-wrapper">

<i class="fas fa-search search-icon"></i>

<input
type="text"
id="searchInput"
class="search-input"
placeholder="Search company or username..."
onkeyup="filterRequests()">

</div>

</div>

<div class="registration-list">

<div class="registration-row header">

<div>Company</div>

<div>Username</div>

<div>Plan</div>

<div>Date</div>

<div>Status</div>

<div>Action</div>

</div>

<?php if(empty($registrations)): ?>

<div style="padding:40px;text-align:center;background:#fff;border:1px solid #e2e8f0;border-radius:12px;color:#94a3b8;">

No pending registrations.

</div>

<?php else: ?>

<?php foreach($registrations as $r): ?>

<div
class="registration-row registration-item"

data-search="<?= strtolower(htmlspecialchars($r['company_name'].' '.$r['username'])) ?>">

<div data-label="Company">

<strong><?= htmlspecialchars($r['company_name']) ?></strong>

</div>

<div data-label="Username">

<?= htmlspecialchars($r['username']) ?>

</div>

<div data-label="Plan">

<?= htmlspecialchars(ucfirst($r['plan_tier'])) ?>

</div>

<div data-label="Date">

<?= date("M d, Y",strtotime($r['created_at'])) ?>

</div>

<div data-label="Status">

<span class="status <?= $r['status'] ?>">

<?= ucfirst($r['status']) ?>

</span>

</div>

<div data-label="Action" class="action-group">

<button
class="icon-btn"
onclick='viewRegistration(<?= json_encode($r) ?>)'>

<i class="fas fa-eye"></i>

</button>

</div>

</div>

<?php endforeach; ?>

<?php endif; ?>

</div>

</div>

<div id="viewModal" class="modal-overlay">

<div class="modal-content">

<h3 style="margin-top:0;">
Registration Details
</h3>

<div class="info">

<strong>Company</strong>

<div id="m_company"></div>

</div>

<div class="info">

<strong>Username</strong>

<div id="m_username"></div>

</div>

<div class="info">

<strong>Subscription</strong>

<div id="m_plan"></div>

</div>

<div class="info">

<strong>Registered On</strong>

<div id="m_date"></div>

</div>

<div class="info">

<strong>Status</strong>

<div id="m_status"></div>

</div>

<div style="display:flex;justify-content:flex-end;gap:10px;margin-top:25px;">

<button
class="btn btn-secondary"
onclick="closeModal()">

Close

</button>

<form
id="approveForm"
method="POST"
action="">

<button
class="btn btn-success">

Approve

</button>

</form>

<form
id="rejectForm"
method="POST"
action="">

<button
class="btn btn-danger">

Reject

</button>

</form>

</div>

</div>

</div>

<script>

function filterRequests(){

let s=document.getElementById("searchInput").value.toLowerCase();

document.querySelectorAll(".registration-item").forEach(function(row){

row.style.display=row.dataset.search.includes(s)?"grid":"none";

});

}

function viewRegistration(data){

document.getElementById("m_company").innerText=data.company_name;

document.getElementById("m_username").innerText=data.username;

document.getElementById("m_plan").innerText=data.plan_tier;

document.getElementById("m_date").innerText=data.created_at;

document.getElementById("m_status").innerHTML="<span class='status "+data.status+"'>"+data.status+"</span>";

document.getElementById("approveForm").action="/loansaas/public/index.php?url=superadmin/approve/"+data.id;

document.getElementById("rejectForm").action="/loansaas/public/index.php?url=superadmin/reject/"+data.id;

document.getElementById("viewModal").style.display="flex";

}

function closeModal(){

document.getElementById("viewModal").style.display="none";

}

window.onclick=function(e){

if(e.target.classList.contains("modal-overlay")){

closeModal();

}

}

</script>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>