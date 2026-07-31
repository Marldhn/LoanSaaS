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


/* Search */

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
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:8px;
    outline:none;
    font-size:.875rem;
}

.search-input:focus{
    border-color:#6366f1;
}


/* List */

.admin-list{
    background:transparent;
}


.admin-row{

    display:grid;
    grid-template-columns:1.5fr 1.5fr 120px;
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

    background:#fff;

    border:none;

    padding:12px 20px;

    margin-bottom:4px;

    font-size:.75rem;

    font-weight:700;

    text-transform:uppercase;

    color:#64748b;

    letter-spacing:.05em;

}


.company-badge{

    display:inline-block;

    background:#eef2ff;

    color:#4f46e5;

    padding:5px 12px;

    border-radius:20px;

    font-size:.8rem;

    font-weight:600;

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

    background:#fee2e2;

    color:#dc2626;

}



/* Modal */

.modal-overlay{

    position:fixed;

    top:0;

    left:0;

    width:100%;

    height:100%;

    background:rgba(15,23,42,.55);

    backdrop-filter:blur(2px);

    display:none;

    justify-content:center;

    align-items:center;

    z-index:9999;

}



.modal-content{

    width:90%;

    max-width:420px;

    background:#fff;

    padding:24px;

    border-radius:12px;

    box-shadow:0 20px 25px rgba(0,0,0,.1);

}



.form-input{

    width:100%;

    padding:10px 14px;

    border:1px solid #cbd5e1;

    border-radius:8px;

    font-size:14px;

    box-sizing:border-box;

    outline:none;

}


.form-input:focus{

    border-color:#6366f1;

}



.btn-secondary{

    background:#f1f5f9;

    color:#475569;

    border:none;

    padding:10px 18px;

    border-radius:8px;

    font-weight:600;

    cursor:pointer;

}



.btn-danger{

    background:#dc2626;

    color:white;

    border:none;

    padding:10px 18px;

    border-radius:8px;

    font-weight:600;

    cursor:pointer;

}



@media(max-width:768px){

    .admin-row.header{
        display:none;
    }


    .admin-row{

        display:flex;

        flex-direction:column;

        align-items:flex-start;

        gap:12px;

    }


    .admin-row > div{

        width:100%;

        display:flex;

        justify-content:space-between;

    }


    .admin-row > div::before{

        content:attr(data-label);

        font-size:.75rem;

        font-weight:700;

        color:#64748b;

        text-transform:uppercase;

    }


    .action-group{

        justify-content:flex-start;

    }

}

</style>



<div class="page-container">


    <div class="page-header">

        <div>

            <h1 class="page-title">
                All Company Administrators
            </h1>

            <p class="page-subtitle">
                Manage administrators from all registered companies.
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
                placeholder="Search administrator or company..."
                onkeyup="filterAdmins()">

        </div>

    </div>




    <div class="admin-list">


        <div class="admin-row header">

            <div>Username</div>

            <div>Company</div>

            <div style="text-align:right;">
                Action
            </div>

        </div>



        <?php if(empty($admins)): ?>


            <div style="padding:40px;text-align:center;background:#fff;border:1px solid #e2e8f0;border-radius:12px;color:#94a3b8;">

                No administrators found.

            </div>



        <?php else: ?>


            <?php foreach($admins as $admin): ?>


            <div class="admin-row admin-item"
                 data-search="<?= strtolower(htmlspecialchars($admin['username'].' '.$admin['company_name'])) ?>">



                <div data-label="Username">

                    <strong>
                        <?= htmlspecialchars($admin['username']) ?>
                    </strong>

                </div>




                <div data-label="Company">

                    <span class="company-badge">

                        <?= htmlspecialchars($admin['company_name']) ?>

                    </span>

                </div>




                <div data-label="Action" class="action-group">


                    <button 
                        class="icon-btn"
                        title="Reset Password"
                        onclick="openModal(<?= $admin['id'] ?>)">

                        <i class="fas fa-key"></i>

                    </button>


                </div>


            </div>



            <?php endforeach; ?>


        <?php endif; ?>


    </div>



</div>




<!-- RESET MODAL -->

<div id="modalContainer" class="modal-overlay">


    <div class="modal-content">


        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">


            <h3 style="margin:0;color:#0f172a;">
                Reset Admin Password
            </h3>


            <span onclick="closeModal()"
                  style="cursor:pointer;font-size:24px;color:#64748b;">
                &times;
            </span>


        </div>



        <form id="changeForm" method="POST">


            <div style="margin-bottom:16px;">


                <label style="font-size:13px;font-weight:600;color:#475569;">
                    New Password
                </label>


                <input 
                    type="text"
                    name="new_password"
                    class="form-input"
                    placeholder="Enter new password"
                    required>


            </div>



            <div style="display:flex;justify-content:flex-end;gap:10px;">


                <button 
                    type="button"
                    class="btn-secondary"
                    onclick="closeModal()">

                    Cancel

                </button>


                <button 
                    type="submit"
                    class="btn-danger">

                    Reset Password

                </button>


            </div>


        </form>


    </div>


</div>




<script>


function filterAdmins(){

    let search =
    document.getElementById('searchInput').value.toLowerCase();


    document.querySelectorAll('.admin-item').forEach(row=>{


        let data=row.dataset.search;


        if(data.includes(search)){

            row.style.display="grid";

        }else{

            row.style.display="none";

        }


    });


}



function openModal(userId){


    document.getElementById('modalContainer').style.display='flex';


    document.getElementById('changeForm').action =
    '/loansaas/public/index.php?url=superadmin/resetPassword&id=' + userId;


}



function closeModal(){

    document.getElementById('modalContainer').style.display='none';

}



window.onclick=function(e){

    if(e.target.classList.contains('modal-overlay')){

        closeModal();

    }

}



document.addEventListener('keydown',function(e){

    if(e.key==="Escape"){

        closeModal();

    }

});


</script>


<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>