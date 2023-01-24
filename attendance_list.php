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


        $sql = "SELECT * FROM course_list WHERE status = 1";
        $stmt = $conn->connect()->prepare($sql);
        $stmt->execute();

            $course_lists = $stmt->fetchAll();

        $sql1 = "SELECT * FROM year_level";
        $stmt1 = $conn->connect()->prepare($sql1);
        $stmt1->execute();
    
             $year_levels = $stmt1->fetchAll();

             if (isset($_GET['course_id']) && !empty($_GET['course_id'])&& is_numeric($_GET['course_id']) && $_GET['course_id'] > 0){
                 $course_id = filter_var($_GET['course_id'] , FILTER_SANITIZE_NUMBER_INT);
             }
             if (isset($_GET['yl_id']) && !empty($_GET['yl_id'])&& $_GET['yl_id'] > 0 && is_numeric($_GET['yl_id'])){
                $yl_id = filter_var($_GET['yl_id'] , FILTER_SANITIZE_NUMBER_INT);
            }


        $sql2 = "SELECT s.* , a.* , CONCAT(s.fname , ', ' , s.mname , ' ' , s.lname) AS name  FROM attendance_list a INNER JOIN students s ON a.student_id = s.student_id". (isset($course_id) ? " AND course_id = {$course_id} " : "" ) . (isset($yl_id) ? " AND yl_id = {$yl_id} " : "") . " ORDER BY `attendance_id` ASC";
        $stmt2 = $conn->connect()->prepare($sql2);
        $stmt2->execute();

            $dd = 0;
                if ($stmt2->rowCount() >= 1 ){
                   $datas = $stmt2->fetchAll();
                   $dd =1 ;
                }

            
        ?>




<div class="container py-3" id="page-container">
    <div class="card rounded-0 mb-3">
        <div class="card-header rounded-0">
            <div class="card-title"><b>Filter Attendance Record</b></div>
        </div>
        <div class="card-body rounded-0">
            <div class="container-fluid">
                <form action="" id="filter-form">
                    <div class="row align-items-end">
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="course_id" class="control-label">Course</label>
                                <select name="course_id" id="course_id" class="form-select form-select-sm rounded-0">
                                    <option selected>All</option>
                                    <?php 
                                    foreach ($course_lists as $course_list){
                                    ?>
                                    <option value="<?=$course_list['course_id'] ?>" <?php if (isset($_GET['course_id']) && $_GET['course_id'] == $course_list['course_id'] ) echo "selected"; ?> ><?=$course_list['course_code'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="yl_id" class="control-label">Year Level</label>
                                <select name="yl_id" id="yl_id" class="form-select form-select-sm rounded-0">
                                    <option selected>All</option>
                                    <?php
                                        foreach($year_levels as $year_level){
                                    ?>
                                    <option value="<?=$year_level['yl_id'] ?>" <?php if (isset($_GET['yl_id']) && $_GET['yl_id'] == $year_level['yl_id'] ) echo "selected"; ?> ><?=$year_level['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <button class="btn btn-primary btn-sm rounded-0"><i class="fa fa-filter"></i> Filter
                                Records</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">Attendance Records</h3>
            <div class="card-tools align-middle">
                <button class="btn btn-success btn-sm py-1 rounded-0" type="button" id="print"><i
                        class="fa fa-print"></i> Print</button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover" id="att-list">
                <colgroup>
                    <col width="5%">
                    <col width="45%">
                    <col width="25%">
                    <col width="25%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="p-0 text-center">#</th>
                        <th class="p-0 text-center">Student</th>
                        <th class="p-0 text-center">Attendance Type</th>
                        <th class="p-0 text-center">Attendance DateTime</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($dd){ 
                        
                        $i = 1;
                        foreach($datas as $data){
                        ?>
                    
                    <tr>
                    <td class="align-middle py-0 px-1 text-center"><?=$i++; ?></td>
                        <td class="align-middle py-0 px-1">
                            <p class="m-0">
                                <small><b>Student Code:</b> <?=$data['student_code'] ?></small><br>
                                <small><b>Name:</b> <?=$data['name'] ?> </small>
                            </p>
                        </td>
                        <?php if ($data['type'] == 1){ ?>
                            <td class="align-middle py-0 px-1 text-center">
                            <span class="badge bg-primary">Time In</span>
                             </td>
                       
                        <?php }else{ ?>
                            <td class="align-middle py-0 px-1 text-center">
                            <span class="badge bg-danger">Time Out</span>
                              </td>
                            <?php } ?>


                        <td class="align-middle py-0 px-1 text-end"><?=$data['date_updated'] ?></td>
                    </tr>
                    <?php } }else{ ?>
                    <tr>
                        <th class="text-center" colspan="4">No attendance record found.</th>
                    </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
    <script>
    $(function() {
        $('#print').click(function() {
            var _h = $("head").clone()
            var _table = $('#att-list').clone()
            var _el = $("<div>")
            _el.append("<h2 class='text-center'>Attendance List</h2>")
            _el.append("<h3 class='text-center'>All Course</h3>")
            _el.append("<h3 class='text-center'>All Year Level</h3>")
            _el.append("<hr/>")
            _el.append(_table)
            var nw = window.open("", "_blank", "width=1200,height=900")
            nw.document.querySelector('head').innerHTML = _h[0].outerHTML
            nw.document.querySelector('body').innerHTML += _el.html()
            nw.document.querySelector('body').setAttribute('onload',
                `window.print(); setTimeout(()=>{ window.close() },500);`)
            nw.document.close()

        })
        $('#filter-form').submit(function(e) {
            e.preventDefault()
            location.href = './?page=attendance_list&' + $(this).serialize()
        })
    })
    </script>
</div>