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
        $school_year = "SELECT * FROM school_year WHERE status = 1";
            $stmt_school = $conn->connect()->prepare($school_year);
            $stmt_school->execute();
            $sy_id = $stmt_school->fetch();
            $sy_id = $sy_id['sy_id'];

            include "classes/Paginator.class.php";

            $limit = 10;


            $sql2 = "SELECT * FROM students";
            $stmt2 = $conn->connect()->prepare($sql2);
            $stmt2->execute();
            $totalRecords = $stmt2->rowCount();

            $totalPages = ceil($totalRecords / $limit);
            
            if(!isset($_GET['pn']) ||$_GET['pn'] > $totalPages || $_GET['pn'] <= 0 ){
                $pn =1;
            }else{
                $pn = $_GET['pn'];
            }
            $queryString = "?";

        $sql = "SELECT s.*,CONCAT(s.lname , ', ' , s.fname , ' ' , s.mname) as `name`,c.course_code as course, yl.name as year_level FROM `students` s INNER JOIN `course_list` c on s.course_id = c.course_id inner join `year_level` yl on s.yl_id = yl.yl_id where s.sy_id = $sy_id  order by `name` asc";
            
            $Paginator = new Paginator($conn->connect() , $sql);
            $results = $Paginator->getData($limit , $pn);
            $datas = $results->data;



?>
<link rel="stylesheet" href="css/aa.css">
<script>
function pageValidation() {
    var valid = true;
    var pageNo = $('#page-no').val();
    var totalPage = $('#total-page').val();
    if (pageNo == "" || pageNo < 1 || !pageNo.match(/\d+/) || pageNo > parseInt(totalPage)) {
        $("#page-no").css("border-color", "#ee0000").show();
        valid = false;
    }
    return valid;
}
</script>
<div class="container py-3" id="page-container">

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">Student List</h3>
            <div class="card-tools align-middle">
                <button class="btn btn-dark btn-sm py-1 rounded-0" type="button" id="create_new">Add New</button>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-hover table-striped table-bordered">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="20%">
                    <col width="20%">
                    <col width="20%">
                    <col width="10%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="text-center p-0">#</th>
                        <th class="text-center p-0">Student Code</th>
                        <th class="text-center p-0">Name</th>
                        <th class="text-center p-0">Course/Year Level</th>
                        <th class="text-center p-0">Info</th>
                        <th class="text-center p-0">Status</th>
                        <th class="text-center p-0">Action</th>
                    </tr>
                </thead>
                <tbody>



                    <?php
                    $i = 1;
                    foreach($datas as $data){

                        $oo = ($i % 2 == 0) ? "even" : "odd";

                    ?>

                    <tr class="<?=$oo?>">
                        <td class="text-center p-0 align-middle sorting_1"><?=$i; ?></td>
                        <td class="py-0 px-1 align-middle"><?=$data['student_code'] ?></td>
                        <td class="py-0 px-1 align-middle">
                            <?php echo $data['fname'] . ' ' . $data['mname'] . ' ' . $data['lname']; ?>

                            <?php if(strcasecmp($data['gender'] , "female") == 0){  ?>

                            <svg class="svg-inline--fa fa-venus fa-w-9 mx-1 text-danger opacity-50" title="Female"
                                aria-labelledby="svg-inline--fa-title-wUHSUH7mn1f3" data-prefix="fa" data-icon="venus"
                                role="img" width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 288 512" data-fa-i2svg="">
                                <title id="svg-inline--fa-title-wUHSUH7mn1f3" >Female</title>
                                <path fill="currentColor"
                                    d="M288 176c0-79.5-64.5-144-144-144S0 96.5 0 176c0 68.5 47.9 125.9 112 140.4V368H76c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h36v36c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12v-36h36c6.6 0 12-5.4 12-12v-40c0-6.6-5.4-12-12-12h-36v-51.6c64.1-14.5 112-71.9 112-140.4zm-224 0c0-44.1 35.9-80 80-80s80 35.9 80 80-35.9 80-80 80-80-35.9-80-80z">
                                </path>
                            </svg>
                            <!-- <span class="fa fa-venus mx-1 text-danger opacity-50" title="Female"></span> Font Awesome fontawesome.com -->
                            <?php }else{ ?>
                            <svg width="20px" class="svg-inline--fa fa-mars fa-w-12 mx-1 text-primary opacity-50" title="Male"
                                aria-labelledby="svg-inline--fa-title-nrSmnEDqgr1u" data-prefix="fa" data-icon="mars"
                                role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                <title id="svg-inline--fa-title-nrSmnEDqgr1u" width="30px">Male</title>
                                <path fill="currentColor"
                                    d="M372 64h-79c-10.7 0-16 12.9-8.5 20.5l16.9 16.9-80.7 80.7c-22.2-14-48.5-22.1-76.7-22.1C64.5 160 0 224.5 0 304s64.5 144 144 144 144-64.5 144-144c0-28.2-8.1-54.5-22.1-76.7l80.7-80.7 16.9 16.9c7.6 7.6 20.5 2.2 20.5-8.5V76c0-6.6-5.4-12-12-12zM144 384c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z">
                                </path>
                            </svg>

                            <?php } ?>
                        </td>
                        <td class="py-0 px-1 align-middle"><?php echo $data['course'] . ' - ' . $data['year_level']; ?>
                        </td>
                        <td class="py-0 px-1 align-middle">
                            <small>Email: <?=$data['email'] ?></small><br>
                            <small>Contact: <?=$data['contact'] ?></small>
                        </td>
                        <td class="py-0 px-1 text-center align-middle">
                            <?php
                            if ($data['status'] == 1){
                        ?>
                            <span class="badge bg-success rounded-pill">Active</span>
                            <?php }else{ ?>
                            <span class="badge bg-danger rounded-pill">Inactive</span>
                            <?php } ?>
                        </td>
                        <th class="text-center py-0 px-1 align-middle">
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button"
                                    class="btn btn-primary dropdown-toggle btn-sm rounded-0 py-0"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <li><a class="dropdown-item view_data" data-id="<?=$data['student_id'] ?>"
                                            href="javascript:void(0)">View</a>
                                    </li>
                                    <li><a class="dropdown-item edit_data" data-id="<?=$data['student_id'] ?>"
                                            href="javascript:void(0)">Edit</a>
                                    </li>
                                    <li><a class="dropdown-item delete_data" data-id="<?=$data['student_id'] ?>"
                                            data-name="<?=$data['student_code'] ?> - <?=$data['name'] ?>"
                                            href="javascript:void(0)">Delete</a></li>
                                </ul>
                            </div>
                        </th>
                    </tr>
                    <?php $i++; }?>

                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="pagination">
    <?php
if ($pn > 1) {
    ?>
    <a class="previous-page" id="prev-page" href="<?php echo "index.php?page=students&";?>pn=<?php echo (($pn-1));?>"
        title="Previous Page"><span>&#10094; Previous</span></a>
    <?php }?>
    <?php
if (($pn - 1) > 1) {
    ?>
    <a href='index.php?page=students&pn=1'>
        <div class='page-a-link'>1</div>
    </a>
    <div class='page-before-after'>...</div>
    <?php
}

for ($i = ($pn - 1); $i <= ($pn + 1); $i ++) {
    if ($i < 1)
        continue;
    if ($i > $totalPages)
        break;
    if ($i == $pn) {
        $class = "active";
    } else {
        $class = "page-a-link";
    }
    ?>
    <a href='index.php?page=students&pn=<?php echo $i; ?>'>
        <div class='<?php echo $class; ?>'><?php echo $i; ?></div>
    </a>
    <?php
}

if (($totalPages - ($pn + 1)) >= 1) {
    ?>
    <div class='page-before-after'>...</div>
    <?php
}
if (($totalPages - ($pn + 1)) > 0) {
    if ($pn == $totalPages) {
        $class = "active";
    } else {
        $class = "page-a-link";
    }
    ?>
    <a href='index.php?page=students&pn=<?php echo $totalPages; ?>'>
        <div class='<?php echo $class; ?>'><?php echo $totalPages; ?></div>
    </a>
    <?php
}
?>
    <?php
    if (($pn > 1) && ($pn < $totalPages)) {
        ?>
    <a class="next" id="next-page" href="<?php echo "index.php?page=students&";?>pn=<?php echo (($pn+1));?>"
        title="Next Page"><span>Next &#10095;</span></a>
    <?php
    }
    ?>




</div>
</div>
<script>
$(function() {
    $('#create_new').click(function() {
        uni_modal('Add New Student', "manage_student.php", 'mid-large')
    })
    $('.edit_data').click(function() {
        uni_modal('Edit Student Details', "manage_student.php?id=" + $(this).attr('data-id'),
            'mid-large')
    })
    $('.view_data').click(function() {
        uni_modal('Student Details', "view_student.php?id=" + $(this).attr('data-id'), 'mid-large')
    })
    $('.delete_data').click(function() {
        _conf("Are you sure to delete <b>" + $(this).attr('data-name') + "</b> from list?",
            'delete_data', [$(this).attr('data-id')])
    })
    $('table td,table th').addClass('align-middle')
    $('table').dataTable({
        columnDefs: [{
            orderable: false,
            targets: 6
        }]
    })
})

function delete_data($id) {
    $('#confirm_modal button').attr('disabled', true)
    $.ajax({
        url: 'Actions.php?a=delete_student',
        method: 'POST',
        data: {
            id: $id
        },
        dataType: 'JSON',
        error: err => {
            console.log(err)
            alert("An error occurred.")
            $('#confirm_modal button').attr('disabled', false)
        },
        success: function(resp) {
            if (resp.status == 'success') {
                location.reload()
            } else {
                alert("An error occurred.")
                $('#confirm_modal button').attr('disabled', false)
            }
        }
    })
}
</script>
