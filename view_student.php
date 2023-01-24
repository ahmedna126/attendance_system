<?php
    if(!isset($_SESSION)){
        session_start();
    }

    if (!isset($_SESSION['admin_id']) && !isset($_SESSION['username'])){
        header("location: Actions.php?a=logout");
        exit;
    }

    if(!class_exists("db_conn")){
        require_once("classes/db_conn.class.php");
    }

        if (!isset($_GET['id']) || empty($_GET['id']) ){
            header("location: index.php?page=students");
            exit;
        }else{
            $id = $_GET['id'];
        }

    $sql = "SELECT s.*,CONCAT(s.lname , ', ' , s.fname , ' ' , s.mname) as `name`,c.course_code as course, yl.name as year_level FROM `students` s INNER JOIN `course_list` c on s.course_id = c.course_id inner join `year_level` yl on s.yl_id = yl.yl_id where s.student_id = ?  order by `name` asc";
            $stmt = $conn->connect()->prepare($sql);
            $stmt->execute([$id]);

            $data = $stmt->fetch();
    ?>

<style>
    #uni_modal .modal-footer{
        display:none !important
    }
</style>
<div class="cotainer-flui">
    <div class="col-12">
        <div class="row">
            <div class="col-md-6">
                <div class="w-100 d-flex">
                    <label for="" class="col-auto"><b>Name:</b></label>
                    <span class="border-bottom border-dark px-2 col-auto flex-grow-1"><?=$data['name']?></span>
                </div>
                <div class="w-100 d-flex">
                    <label for="" class="col-auto"><b>Gender:</b></label>
                    <?php 
                if (strcasecmp($data['gender'] , "female") == 0){

                    ?>
                    <span class="border-bottom border-dark px-2 col-auto flex-grow-1">
                        Female                                                    
                        <span class="fa fa-venus mx-1 text-danger opacity-50" title="Female"></span></span>
                <?php }else{ ?>
                    <span class="border-bottom border-dark px-2 col-auto flex-grow-1">
                        Male                                           
                        <svg class="svg-inline--fa fa-mars fa-w-12 mx-1 text-primary opacity-50" title="Male"
                            aria-labelledby="svg-inline--fa-title-nrSmnEDqgr1u" data-prefix="fa" data-icon="mars"
                            role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                            <title id="svg-inline--fa-title-nrSmnEDqgr1u">Male</title>
                            <path fill="currentColor"
                                d="M372 64h-79c-10.7 0-16 12.9-8.5 20.5l16.9 16.9-80.7 80.7c-22.2-14-48.5-22.1-76.7-22.1C64.5 160 0 224.5 0 304s64.5 144 144 144 144-64.5 144-144c0-28.2-8.1-54.5-22.1-76.7l80.7-80.7 16.9 16.9c7.6 7.6 20.5 2.2 20.5-8.5V76c0-6.6-5.4-12-12-12zM144 384c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z">
                            </path>
                        </svg>         
                <?php } ?>
                </div>
                <div class="w-100 d-flex">
                    <label for="" class="col-auto"><b>Email:</b></label>
                    <span class="border-bottom border-dark px-2 col-auto flex-grow-1"><?=$data['email'] ?></span>
                </div>
                <div class="w-100 d-flex">
                    <label for="" class="col-auto"><b>Contact:</b></label>
                    <span class="border-bottom border-dark px-2 col-auto flex-grow-1"><?=$data['contact'] ?></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="w-100 d-flex">
                    <label for="" class="col-auto"><b>Student Code:</b></label>
                    <span class="border-bottom border-dark px-2 col-auto flex-grow-1"><?=$data['student_code'] ?></span>
                </div>
                <div class="w-100 d-flex">
                    <label for="" class="col-auto"><b>Course:</b></label>
                    <span class="border-bottom border-dark px-2 col-auto flex-grow-1"><?=$data['course'] ?></span>
                </div>
                <div class="w-100 d-flex">
                    <label for="" class="col-auto"><b>Year Level:</b></label>
                    <span class="border-bottom border-dark px-2 col-auto flex-grow-1"><?=$data['year_level'] ?></span>
                </div>
            </div>
        </div>
        <div class="col-12">
        <div class="row justify-content-end mt-3">
            <button class="btn btn-sm rounded-0 btn-dark col-auto me-3" type="button" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>