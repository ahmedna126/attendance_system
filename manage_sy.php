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
        if (isset($_GET['id'])){
           
        

        $id = filter_var($_GET['id'] , FILTER_SANITIZE_NUMBER_INT);

        $sql = "SELECT * FROM school_year WHERE sy_id = ?";
        $stmt = $conn->connect()->prepare($sql);
        $stmt->execute([$id]);

        if($stmt->rowCount() != 1){
            header("location: index.php?page=maintenance");
            exit;
        }

            $data = $stmt->fetch();
    
?>

<div class="container-fluid">
    <form action="" id="sy-form">
        <input type="hidden" name="id" value="<?=$data['sy_id'] ?>">
        <div class="form-group">
            <label for="school_year" class="control-label">School Year</label>
            <input type="text" name="school_year" autofocus id="school_year" required class="form-control form-control-sm rounded-0" value="<?=$data['school_year'] ?>">
        </div>
        <div class="form-group">
            <label for="status" class="control-label">Status</label>
            <select name="status" id="status" class="form-select form-select-sm rounded-0">
                <option value="1" <?php if($data['status'] == 1) echo"selected"; ?>  >Active</option>
                <option value="0" <?php if($data['status'] == 0) echo"selected"; ?> >Inactive</option>
            </select>
        </div>
    </form>
</div>
<?php
    }else{
    
?>
<div class="container-fluid">
    <form action="" id="sy-form">
        <div class="form-group">
            <label for="school_year" class="control-label">School Year</label>
            <input type="text" name="school_year" autofocus id="school_year" required class="form-control form-control-sm rounded-0" value="">
        </div>
        <div class="form-group">
            <label for="status" class="control-label">Status</label>
            <select name="status" id="status" class="form-select form-select-sm rounded-0">
                <option value="1" >Active</option>
                <option value="0" >Inactive</option>
            </select>
        </div>
    </form>
</div>
<?php } ?>
<script>
    $(function(){
        $('#sy-form').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
                _el.addClass('pop_msg')
            $('#uni_modal button').attr('disabled',true)
            $('#uni_modal button[type="submit"]').text('submitting form...')
            $.ajax({
                url:'Actions.php?a=save_sy',
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