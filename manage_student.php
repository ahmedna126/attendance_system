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

    $sql2 = "SELECT * FROM course_list";
    $stmt2 = $conn->connect()->prepare($sql2);
    $stmt2 -> execute();
        $course_list = $stmt2->fetchAll();

    $sql3 = "SELECT * FROM year_level";
    $stmt3 = $conn->connect()->prepare($sql3);
    $stmt3 -> execute();
        $year_level = $stmt3->fetchAll();


    ?>



<?php if (isset($_GET['id'])){ 
    $id = filter_var($_GET['id'] , FILTER_SANITIZE_NUMBER_INT);
    $sql = "SELECT s.*,c.course_code as course, yl.name as year_level FROM `students` s INNER JOIN `course_list` c on s.course_id = c.course_id inner join `year_level` yl on s.yl_id = yl.yl_id where s.student_id = ?  order by `name` asc";
    $stmt = $conn->connect()->prepare($sql);
    $stmt->execute([$id]);

    $data = $stmt->fetch();
    
    
    ?>
    
<div class="container-fluid">
    <form action="" id="student-form">
        <input type="hidden" name="id" value="<?=$id ?>">
        <input type="hidden" name="sy_id" value="<?=$data['sy_id'] ?>">
        <div class="col-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="student_code" class="control-label">Student Code</label>
                        <input type="text" name="student_code" autofocus id="student_code" required class="form-control form-control-sm rounded-0" value="<?=$data['student_code'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="firstname" class="control-label">First Name</label>
                        <input type="text" name="fname" id="fname" required class="form-control form-control-sm rounded-0" value="<?=$data['fname'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="middlename" class="control-label">Middle Name</label>
                        <input type="text" name="mname" id="mname" required class="form-control form-control-sm rounded-0" placeholder="(optional)" value="<?=$data['mname'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="control-label">Last Name</label>
                        <input type="text" name="lname" id="lname" required class="form-control form-control-sm rounded-0" value="<?=$data['lname'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="gender" class="control-label">Gender</label>
                        <select name="gender" id="gender" class="form-select form-select-sm rounded-0">
                            <option value="1" <?php if(strcasecmp($data['gender'] , "male") == 0 ) echo "selected"; ?> >Male</option>
                            <option value="2" <?php if(strcasecmp($data['gender'] , "female") == 0 ) echo "selected"; ?>>Female</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" name="email" id="email" required class="form-control form-control-sm rounded-0" value="<?=$data['email'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="contact" class="control-label">Contact</label>
                        <input type="text" name="contact" id="contact" required class="form-control form-control-sm rounded-0" value="<?=$data['contact'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="course_id" class="control-label">Course</label>
                        <select name="course_id" id="course_id" class="form-select form-select-sm rounded-0">
                            <option  disabled>Please Seelect Department</option>
                            <?php foreach($course_list as $course_list){ ?>
                                     <option value="<?=$course_list['course_id'] ?>" <?php if ($course_list['course_id'] == $data['course_id']) echo "selected";?> ><?=$course_list['course_code'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="yl_id" class="control-label">Year Level</label>
                        <select name="yl_id" id="yl_id" class="form-select form-select-sm rounded-0">
                            <option  disabled>Please Seelect Department</option>
                            <?php foreach($year_level as $year_level){ ?>
                                  <option value="<?=$year_level['yl_id'] ?>" <?php if ($year_level['yl_id'] == $data['yl_id']) echo "selected";?> ><?=$year_level['name']; ?></option>
                             <?php } ?>
                                                    </select>
                    </div>
                    <div class="form-group">
                        <label for="status" class="control-label">Status</label>
                        <select name="status" id="status" class="form-select form-select-sm rounded-0">
                            <option value="1" <?php if ($data['status'] == 1) echo "selected"; ?>>Active</option>
                            <option value="0" <?php if ($data['status'] == 0) echo "selected"; ?> >Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?php }else{ ?>

    <div class="container-fluid">
    <form action="" id="student-form">
        <div class="col-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="student_code" class="control-label">Student Code</label>
                        <input type="text" name="student_code" autofocus id="student_code" required class="form-control form-control-sm rounded-0" value="">
                    </div>
                    <div class="form-group">
                        <label for="firstname" class="control-label">First Name</label>
                        <input type="text" name="fname" id="fname" required class="form-control form-control-sm rounded-0" value="">
                    </div>
                    <div class="form-group">
                        <label for="middlename" class="control-label">Middle Name</label>
                        <input type="text" name="mname" id="mname" required class="form-control form-control-sm rounded-0" placeholder="(optional)" value="">
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="control-label">Last Name</label>
                        <input type="text" name="lname" id="lname" required class="form-control form-control-sm rounded-0" value="">
                    </div>
                    <div class="form-group">
                        <label for="gender" class="control-label">Gender</label>
                        <select name="gender" id="gender" class="form-select form-select-sm rounded-0">
                            <option value="1" >Male</option>
                            <option value="2" >Female</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" name="email" id="email" required class="form-control form-control-sm rounded-0" value="">
                    </div>
                    <div class="form-group">
                        <label for="contact" class="control-label">Contact</label>
                        <input type="text" name="contact" id="contact" required class="form-control form-control-sm rounded-0" value="">
                    </div>
                    <div class="form-group">
                        <label for="course_id" class="control-label">Course</label>
                        <select name="course_id" id="course_id" class="form-select form-select-sm rounded-0">
                            <option  disabled>Please Seelect Department</option>
                            <?php foreach($course_list as $course_list){ ?>
                                     <option value="<?=$course_list['course_id'] ?>"><?=$course_list['course_code'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="yl_id" class="control-label">Year Level</label>
                        <select name="yl_id" id="yl_id" class="form-select form-select-sm rounded-0">
                            <option  disabled>Please Seelect Department</option>
                            <?php foreach($year_level as $year_level){ ?>
                                  <option value="<?=$year_level['yl_id'] ?>"  ><?=$year_level['name']; ?></option>
                             <?php } ?>
                                                    </select>
                    </div>
                    <div class="form-group">
                        <label for="status" class="control-label">Status</label>
                        <select name="status" id="status" class="form-select form-select-sm rounded-0">
                            <option value="1" >Active</option>
                            <option value="0" >Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

   <?php } ?>

<script>
    $(function(){
        $('#student-form').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
                _el.addClass('pop_msg')
            $('#uni_modal button').attr('disabled',true)
            $('#uni_modal button[type="submit"]').text('submitting form...')
            $.ajax({
                url:'Actions.php?a=save_student',
                method:'POST',
                data:$(this).serialize(),
                dataType:'JSON',
                error:err=>{
                    console.log(err)
                    _el.addClass('alert alert-danger')
                    _el.text("An error occurred.")
                    _this.prepend(_el)
                    _el.show('slow')
                     $('#uni_modal button').attr('disabled',false)
                     $('#uni_modal button[type="submit"]').text('Save')
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        _el.addClass('alert alert-success')
                        $('#uni_modal').on('hide.bs.modal',function(){
                            location.reload()
                        })
                        if("1" != 1)
                        _this.get(0).reset();
                    }else{
                        _el.addClass('alert alert-danger')
                    }
                    _el.text(resp.msg)

                    _el.hide()
                    _this.prepend(_el)
                    _el.show('slow')
                     $('#uni_modal button').attr('disabled',false)
                     $('#uni_modal button[type="submit"]').text('Save')
                }
            })
        })
    })
</script>