<?php
    if(!isset($_SESSION)){
        session_start();
    }

    if (!isset($_SESSION['admin_id']) && !isset($_SESSION['username'])){
        header("location: Actions.php?a=logout");
        exit;
    }

        $page = (!isset($_GET['page']))? "home" : $_GET['page'];



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Student Attendance Management System - Intramurals</title>
    <link rel="stylesheet" href="Font-Awesome-master/css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="Font-Awesome-master/js/all.min.js"></script>
    <script src="js/script.js"></script>
    
    <style>
    html,
    body {
        height: 100%;
        width: 100%;
    }

    main {
        height: 100%;
        display: flex;
        flex-flow: column;
    }

    #page-container {
        flex: 1 1 auto;
        overflow: auto;
    }

    #topNavBar {
        flex: 0 1 auto;
    }

    .truncate-1 {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
    }

    .truncate-3 {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .modal-dialog.large {
        width: 80% !important;
        max-width: unset;
    }

    .modal-dialog.mid-large {
        width: 50% !important;
        max-width: unset;
    }

    @media (max-width:720px) {

        .modal-dialog.large {
            width: 100% !important;
            max-width: unset;
        }

        .modal-dialog.mid-large {
            width: 100% !important;
            max-width: unset;
        }

    }

    #topNavBar {
        background-color: #6E85B7 !important;
        background: #6E85B7 !important;
    }
    </style>
</head>

<body>
    <main>

        <?php include "nav.php"; ?>
        <div class="container">
            <div class="py-1 w-100 d-flex justify-content-end">
                <small class="text-muted">Active School Year: </small>
        <?php
         if(!class_exists("db_conn")){
            require_once("classes/db_conn.class.php");
        }

        $sql_1 = "SELECT * FROM school_year WHERE status = 1";
        $stmt_1 = $conn->connect()->prepare($sql_1);
        $stmt_1->execute();

            $school_year = $stmt_1->fetch();
            if($stmt_1->rowCount() == 1){
                $_SESSION['sy_id'] = $school_year['sy_id'];
        ?>
             <span class="badge bg-success mx-2 rounded-pill"><?=$school_year['school_year']; ?></span>
            
        <?php } ?>
        </div>
        </div>
            <?php 
                $pa = $page . '.php';
                if (file_exists($pa)){
                    include $pa ;
                }else{
                    include "home.php";
                }
            
                ?> 
    </main>
    <div class="modal fade" id="uni_modal" role='dialog' data-bs-backdrop="static" data-bs-keyboard="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer py-1">
                    <button type="button" class="btn btn-sm rounded-0 btn-primary" id='submit'
                        onclick="$('#uni_modal form').submit()">Save</button>
                    <button type="button" class="btn btn-sm rounded-0 btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirm_modal" role='dialog'>
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header py-2">
                    <h5 class="modal-title">Confirmation</h5>
                </div>
                <div class="modal-body">
                    <div id="delete_content"></div>
                </div>
                <div class="modal-footer py-1">
                    <button type="button" class="btn btn-primary btn-sm rounded-0" id='confirm'
                        onclick="">Continue</button>
                    <button type="button" class="btn btn-secondary btn-sm rounded-0"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>