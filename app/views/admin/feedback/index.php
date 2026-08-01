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


/* Feedback Rows */

.feedback-list{
    background:transparent;
}


.feedback-row{

    display:grid;

    grid-template-columns:1.2fr 2fr 1fr 80px;

    gap:20px;

    align-items:center;

    background:#fff;

    border:1px solid #e2e8f0;

    border-radius:12px;

    padding:16px 20px;

    margin-bottom:12px;

    transition:.2s;

}


.feedback-row:hover{

    background:#f8fafc;

}


.feedback-row.header{

    background:#fff;

    border:none;

    padding:12px 20px;

    margin-bottom:4px;

    font-size:.75rem;

    font-weight:700;

    color:#64748b;

    text-transform:uppercase;

    letter-spacing:.05em;

}



.message-text{

    color:#64748b;

    font-size:.875rem;

}



.date-text{

    color:#64748b;

    font-size:.85rem;

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

    background:#fff;

    width:90%;

    max-width:500px;

    padding:24px;

    border-radius:12px;

    position:relative;

    box-shadow:0 20px 25px rgba(0,0,0,.1);

}



.feedback-message{

    background:#f8fafc;

    padding:12px;

    border-radius:8px;

    color:#475569;

    line-height:1.5;

}



.close-btn{

    position:absolute;

    right:18px;

    top:15px;

    border:none;

    background:none;

    font-size:24px;

    cursor:pointer;

    color:#64748b;

}



@media(max-width:768px){


    .feedback-row.header{

        display:none;

    }


    .feedback-row{

        display:flex;

        flex-direction:column;

        align-items:flex-start;

        gap:12px;

    }


    .feedback-row > div{

        width:100%;

        display:flex;

        justify-content:space-between;

    }


    .feedback-row > div::before{

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
                User Feedback & Suggestions
            </h1>

            <p class="page-subtitle">
                Review user feedback, suggestions, and reported issues.
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
                placeholder="Search user or feedback message..."
                onkeyup="filterFeedback()">

        </div>

    </div>




    <div class="feedback-list">


        <div class="feedback-row header">

            <div>User</div>

            <div>Message</div>

            <div>Date</div>

            <div style="text-align:right;">
                Action
            </div>

        </div>



        <?php if(empty($messages)): ?>


            <div style="padding:40px;text-align:center;background:#fff;border:1px solid #e2e8f0;border-radius:12px;color:#94a3b8;">

                No feedback found.

            </div>



        <?php else: ?>


            <?php foreach($messages as $msg): ?>


            <div class="feedback-row feedback-item"
                 data-search="<?= strtolower(htmlspecialchars($msg['username'].' '.$msg['message'])) ?>">



                <div data-label="User">

                    <strong>
                        <?= htmlspecialchars($msg['username']) ?>
                    </strong>

                </div>



                <div data-label="Message" class="message-text">

                    <?= htmlspecialchars(substr($msg['message'],0,70)) ?>
                    <?= strlen($msg['message']) > 70 ? '...' : '' ?>

                </div>




                <div data-label="Date" class="date-text">

                    <?= htmlspecialchars($msg['created_at']) ?>

                </div>




                <div data-label="Action" class="action-group">


                    <button 
                        class="icon-btn"
                        title="View Feedback"
                        onclick='viewFeedback(<?= json_encode($msg) ?>)'>

                        <i class="fas fa-eye"></i>

                    </button>


                </div>


            </div>



            <?php endforeach; ?>


        <?php endif; ?>


    </div>


</div>





<!-- Feedback Modal -->

<div id="feedbackModal" class="modal-overlay">


    <div class="modal-content">


        <button 
            class="close-btn"
            onclick="closeFeedbackModal()">

            &times;

        </button>



        <h3 style="margin-top:0;color:#0f172a;">
            Feedback Details
        </h3>



        <p>
            <strong>User:</strong>
            <span id="modalUser"></span>
        </p>



        <p>
            <strong>Message:</strong>
        </p>



        <div id="modalMessage" class="feedback-message"></div>




        <div id="modalImageContainer" style="display:none;margin-top:20px;">


            <p>
                <strong>Screenshot:</strong>
            </p>


            <img 
                id="modalImage"
                src=""
                style="width:100%;border-radius:8px;border:1px solid #e2e8f0;">


        </div>


    </div>


</div>





<script>


function filterFeedback(){


    let search =
    document.getElementById('searchInput').value.toLowerCase();



    document.querySelectorAll('.feedback-item').forEach(row=>{


        let data=row.dataset.search;


        if(data.includes(search)){

            row.style.display="grid";

        }else{

            row.style.display="none";

        }


    });


}



function viewFeedback(msg){


    document.getElementById('modalUser').innerText =
    msg.username;


    document.getElementById('modalMessage').innerText =
    msg.message;



    const imageContainer =
    document.getElementById('modalImageContainer');



    if(msg.image_path){


        document.getElementById('modalImage').src =
        '/loansaas/public/' + msg.image_path;


        imageContainer.style.display='block';


    }else{


        imageContainer.style.display='none';


    }



    document.getElementById('feedbackModal').style.display='flex';


}



function closeFeedbackModal(){

    document.getElementById('feedbackModal').style.display='none';

}



window.onclick=function(e){

    if(e.target.classList.contains('modal-overlay')){

        closeFeedbackModal();

    }

}



document.addEventListener('keydown',function(e){

    if(e.key==="Escape"){

        closeFeedbackModal();

    }

});


</script>



<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>