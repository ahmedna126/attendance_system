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
            $sql = "SELECT * FROM school_year order by status DESC";
            $stmt=$conn->connect()->prepare($sql);
            $stmt->execute();
            $school_years = $stmt->fetchAll();

            $sql2 = "SELECT * FROM year_level";
            $stmt2=$conn->connect()->prepare($sql2);
            $stmt2->execute();
            $year_levels = $stmt2->fetchAll();

            $sql3 = "SELECT * FROM course_list";
            $stmt3=$conn->connect()->prepare($sql3);
            $stmt3->execute();
            $courses = $stmt3->fetchAll();


?>

<div class="container py-3" id="page-container">

    <div class="card h-100 d-flex flex-column">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">Maintenance</h3>
            <div class="card-tools align-middle">
                <!-- <button class="btn btn-dark btn-sm py-1 rounded-0" type="button" id="create_new">Add New</button> -->
            </div>
        </div>
        <div class="card-body flex-grow-1">
            <div class="container-fluid">
                <div class="col-12 h-100">
                    <div class="row h-100">
                        <div class="col-md-6 h-100 d-flex flex-column">
                            <div class="w-100 d-flex border-bottom border-dark py-1 mb-1">
                                <div class="fs-5 col-auto flex-grow-1"><b>School Year</b></div>
                                <div class="col-auto flex-grow-0 d-flex justify-content-end">
                                    <a href="javascript:void(0)" id="new_sy"
                                        class="btn btn-dark btn-sm bg-gradient rounded-2" title="Add School Year"><svg
                                            class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true" focusable="false"
                                            data-prefix="fa" data-icon="plus" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                            <path fill="currentColor"
                                                d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z">
                                            </path>
                                        </svg><!-- <span class="fa fa-plus"></span> Font Awesome fontawesome.com --></a>
                                </div>
                            </div>
                            <div class="h-100 overflow-auto border rounded-1 border-dark">
                                <ul class="list-group">
                                    <?php
                                    foreach($school_years as $school_year){
                                    ?>
                                    <li class="list-group-item d-flex">
                                        <div class="col-auto flex-grow-1">
                                            <?=$school_year['school_year'] ?> </div>
                                        <div class="col-auto">
                                            <?php if($school_year['status'] == 1){ ?>
                                            <a href="javascript:void(0)"
                                                class="update_stat_sy badge bg-success bg-gradiend rounded-pill text-decoration-none me-1"
                                                title="Update Status" data-tostat="0" data-id="<?=$school_year['sy_id'] ?>"
                                                data-name="<?=$school_year['school_year'] ?>"><small>Active</small></a>
                                                <?php }else{ ?>
                                                    <a href="javascript:void(0)"
                                                class="update_stat_sy badge bg-secondary bg-gradiend rounded-pill text-decoration-none me-1"
                                                title="Update Status" data-tostat="1" data-id="<?=$school_year['sy_id'] ?>"
                                                data-name="<?=$school_year['school_year'] ?>"><small>Inactive</small></a>
                                                <?php } ?>
                                        </div>
                                        <div class="col-auto d-flex justify-content-end">
                                            <a href="javascript:void(0)"
                                                class="edit_school_year btn btn-sm btn-primary bg-gradient py-0 px-1 me-1"
                                                title="Edit School Year Details" data-id="<?=$school_year['sy_id'] ?>" data-name="2022-2023"><svg
                                                    class="svg-inline--fa fa-edit fa-w-18" aria-hidden="true"
                                                    focusable="false" data-prefix="fa" data-icon="edit" role="img"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                    data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z">
                                                    </path>
                                                </svg>
                                                <!-- <span class="fa fa-edit"></span> Font Awesome fontawesome.com --></a>

                                            <a href="javascript:void(0)"
                                                class="delete_school_year btn btn-sm btn-danger bg-gradient py-0 px-1"
                                                title="Delete School Year" data-id="<?=$school_year['sy_id'] ?>" data-name="<?=$school_year['school_year'] ?>"><svg
                                                    class="svg-inline--fa fa-trash fa-w-14" aria-hidden="true"
                                                    focusable="false" data-prefix="fa" data-icon="trash" role="img"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                    data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z">
                                                    </path>
                                                </svg>
                                                <!-- <span class="fa fa-trash"></span> Font Awesome fontawesome.com --></a>
                                        </div>
                                    </li>
                                    <?php } ?>
                                    
                                </ul>
                            </div>
                        </div>


                        <div class="col-md-6 h-100 d-flex flex-column">
                            <div class="w-100 d-flex border-bottom border-dark py-1 mb-1">
                                <div class="fs-5 col-auto flex-grow-1"><b>Year Level</b></div>
                                <div class="col-auto flex-grow-0 d-flex justify-content-end">
                                    <a href="javascript:void(0)" id="new_year_lvl"
                                        class="btn btn-dark btn-sm bg-gradient rounded-2" title="Add Year Level"><svg
                                            class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true" focusable="false"
                                            data-prefix="fa" data-icon="plus" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                            <path fill="currentColor"
                                                d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z">
                                            </path>
                                        </svg><!-- <span class="fa fa-plus"></span> Font Awesome fontawesome.com --></a>
                                </div>
                            </div>
                            <div class="h-100 overflow-auto border rounded-1 border-dark">
                                <ul class="list-group">

                                <?php 
                                
                                foreach($year_levels as $year_level){
                                ?>
                                    <li class="list-group-item d-flex">
                                        <div class="col-auto flex-grow-1">
                                            <?=$year_level['name'] ?> </div>
                                        <div class="col-auto d-flex justify-content-end">
                                            <a href="javascript:void(0)"
                                                class="edit_year_lvl btn btn-sm btn-primary bg-gradient py-0 px-1 me-1"
                                                title="Edit School Year Details" data-id="<?=$year_level['yl_id'] ?>" data-name="<?=$year_level['name'] ?>"><svg
                                                    class="svg-inline--fa fa-edit fa-w-18" aria-hidden="true"
                                                    focusable="false" data-prefix="fa" data-icon="edit" role="img"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                    data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z">
                                                    </path>
                                                </svg>
                                                <!-- <span class="fa fa-edit"></span> Font Awesome fontawesome.com --></a>

                                            <a href="javascript:void(0)"
                                                class="delete_year_lvl btn btn-sm btn-danger bg-gradient py-0 px-1"
                                                title="Delete School Year" data-id="<?=$year_level['yl_id'] ?>" data-name="<?=$year_level['name'] ?>"><svg
                                                    class="svg-inline--fa fa-trash fa-w-14" aria-hidden="true"
                                                    focusable="false" data-prefix="fa" data-icon="trash" role="img"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                    data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z">
                                                    </path>
                                                </svg>
                                                <!-- <span class="fa fa-trash"></span> Font Awesome fontawesome.com --></a>
                                        </div>
                                    </li>
                                    <?php } ?>

                                    
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6 h-100 d-flex flex-column">
                            <div class="w-100 d-flex border-bottom border-dark py-1 mb-1">
                                <div class="fs-5 col-auto flex-grow-1"><b>Course List</b></div>
                                <div class="col-auto flex-grow-0 d-flex justify-content-end">
                                    <a href="javascript:void(0)" id="new_course"
                                        class="btn btn-dark btn-sm bg-gradient rounded-2" title="Add course"><svg
                                            class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true" focusable="false"
                                            data-prefix="fa" data-icon="plus" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                            <path fill="currentColor"
                                                d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z">
                                            </path>
                                        </svg><!-- <span class="fa fa-plus"></span> Font Awesome fontawesome.com --></a>
                                </div>
                            </div>
                            <div class="h-100 overflow-auto border rounded-1 border-dark">
                                <ul class="list-group">
                                    <?php 

                                    foreach($courses as $course){
                                        ?>
                                    <li class="list-group-item d-flex">
                                        <div class="col-auto flex-grow-1">
                                            <?=$course['course_code'] ?> </div>
                                        <div class="col-auto">
                                        <?php if($course['status'] == 1){ ?>
                                            <a href="javascript:void(0)"
                                                class="update_stat_course badge bg-success bg-gradiend rounded-pill text-decoration-none me-1"
                                                title="Update Status" data-tostat="0" data-id="<?=$course['course_id'] ?>"
                                                data-name="<?=$course['course_code'] ?>"><small>Active</small></a>
                                                <?php }else{ ?>
                                                    <a href="javascript:void(0)"
                                                class="update_stat_course badge bg-secondary bg-gradiend rounded-pill text-decoration-none me-1"
                                                title="Update Status" data-tostat="1" data-id="<?=$course['course_id'] ?>"
                                                data-name="<?=$course['course_code'] ?>"><small>Inactive</small></a>
                                                <?php } ?>
                                        </div>
                                        <div class="col-auto d-flex justify-content-end">
                                            <a href="javascript:void(0)"
                                                class="edit_course btn btn-sm btn-primary bg-gradient py-0 px-1 me-1"
                                                title="Edit Course Details" data-id="<?=$course['course_id'] ?>" data-name="<?=$course['course_code'] ?>"><svg
                                                    class="svg-inline--fa fa-edit fa-w-18" aria-hidden="true"
                                                    focusable="false" data-prefix="fa" data-icon="edit" role="img"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                    data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z">
                                                    </path>
                                                </svg>
                                                <!-- <span class="fa fa-edit"></span> Font Awesome fontawesome.com --></a>

                                            <a href="javascript:void(0)"
                                                class="delete_course btn btn-sm btn-danger bg-gradient py-0 px-1"
                                                title="Delete Course" data-id="<?=$course['course_id'] ?>" data-name="<?=$course['course_code'] ?>"><svg
                                                    class="svg-inline--fa fa-trash fa-w-14" aria-hidden="true"
                                                    focusable="false" data-prefix="fa" data-icon="trash" role="img"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                    data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z">
                                                    </path>
                                                </svg>
                                                <!-- <span class="fa fa-trash"></span> Font Awesome fontawesome.com --></a>
                                        </div>
                                    </li>
                                    <?php } ?>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(function() {
        // School Year
        $('#new_sy').click(function() {
            uni_modal('Add New School Year', "manage_sy.php")
        })
        $('.edit_school_year').click(function() {
            uni_modal('Edit School Year Details', "manage_sy.php?id=" + $(this).attr('data-id'))
        })
        $('.update_stat_sy').click(function() {
            var changeTo = $(this).attr('data-toStat') == 1 ? "Active" : "Inactive";
            _conf("Are you sure to change status of <b>" + $(this).attr('data-name') + "</b> to " +
                changeTo + "?", 'update_stat_sy', [$(this).attr('data-id'), $(this).attr(
                    'data-toStat')])
        })
        $('.delete_school_year').click(function() {
            _conf("Are you sure to delete <b>" + $(this).attr('data-name') +
                "</b> from School Year List?", 'delete_school_year', [$(this).attr('data-id')])
        })
        // year_lvl
        $('#new_year_lvl').click(function() {
            uni_modal('Add New Year Level', "manage_year_lvl.php")
        })
        $('.edit_year_lvl').click(function() {
            uni_modal('Edit Year Level Details', "manage_year_lvl.php?id=" + $(this).attr('data-id'))
        })
        $('.delete_year_lvl').click(function() {
            _conf("Are you sure to delete <b>" + $(this).attr('data-name') + "</b> from year_lvl List?",
                'delete_year_lvl', [$(this).attr('data-id')])
        })


        // Course
        $('#new_course').click(function() {
            uni_modal('Add New Course', "manage_course.php")
        })
        $('.edit_course').click(function() {
            uni_modal('Edit Course Details', "manage_course.php?id=" + $(this).attr('data-id'))
        })
        $('.update_stat_course').click(function() {
            var changeTo = $(this).attr('data-toStat') == 1 ? "Active" : "Inactive";
            _conf("Are you sure to change status of <b>" + $(this).attr('data-name') + "</b> to " +
                changeTo + "?", 'update_stat_course', [$(this).attr('data-id'), $(this).attr(
                    'data-toStat')])
        })
        $('.delete_course').click(function() {
            _conf("Are you sure to delete <b>" + $(this).attr('data-name') + "</b> from Course List?",
                'delete_course', [$(this).attr('data-id')])
        })

        $('table').dataTable({
            columnDefs: [{
                orderable: false,
                targets: 6
            }]
        })
    })

    function update_stat_sy($id, $status) {
        $('#confirm_modal button').attr('disabled', true)
        $.ajax({
            url: 'Actions.php?a=update_stat_sy',
            method: 'POST',
            data: {
                id: $id,
                status: $status
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

    function update_stat_course($id, $status) {
        $('#confirm_modal button').attr('disabled', true)
        $.ajax({
            url: 'Actions.php?a=update_stat_course',
            method: 'POST',
            data: {
                id: $id,
                status: $status
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

    function delete_school_year($id) {
        $('#confirm_modal button').attr('disabled', true)
        $.ajax({
            url: 'Actions.php?a=delete_school_year',
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

    function delete_year_lvl($id) {
        $('#confirm_modal button').attr('disabled', true)
        $.ajax({
            url: 'Actions.php?a=delete_yl',
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

    function delete_course($id) {
        $('#confirm_modal button').attr('disabled', true)
        $.ajax({
            url: 'Actions.php?a=delete_course',
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
</div>