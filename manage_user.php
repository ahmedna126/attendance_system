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

    

    ?>

<?php 
    if (isset($_GET['id']) && is_numeric($_GET['id'])){
        $id = filter_var($_GET['id'] , FILTER_SANITIZE_NUMBER_INT);
        $sql = "SELECT * FROM user_list WHERE status = 1 AND user_id = ?";
        $stmt = $conn->connect()->prepare($sql);
        $stmt->execute([$id]);

        if ($stmt->rowCount() != 1){
            header("location: index.php?page=users");
            exit;
        }
        $data = $stmt->fetch();
?>
<div class="container-fluid">
    <form action="" id="user-form">
        <input type="hidden" name="id" value="<?=$id ?>">
        <div class="form-group">
            <label for="fullname" class="control-label">Full Name</label>
            <input type="text" name="fullname" id="fullname" required class="form-control form-control-sm rounded-0" value="<?=$data['fullname'] ?>">
        </div>
        <div class="form-group">
            <label for="username" class="control-label">Username</label>
            <input type="text" name="username" id="username" required class="form-control form-control-sm rounded-0" value="<?=$data['username'] ?>">
        </div>
        <div class="form-group">
            <label for="type" class="control-label">Type</label>
            <select name="type" id="type" class="form-control form-control" required>
                <option value="1" <?php if($data['type'] == 1) echo "selected"; ?> >Administrator</option>
                <option value="2" <?php if($data['type'] == 2) echo "selected"; ?>>Staff</option>
            </select>
        </div>
    </form>
</div>
<?php }else{ ?>
    <div class="container-fluid">
    <form action="" id="user-form">
        <div class="form-group">
            <label for="fullname" class="control-label">Full Name</label>
            <input type="text" name="fullname" id="fullname" required class="form-control form-control-sm rounded-0" value="">
        </div>
        <div class="form-group">
            <label for="username" class="control-label">Username</label>
            <input type="text" name="username" id="username" required class="form-control form-control-sm rounded-0" value="">
        </div>
        <div class="form-group">
            <label for="password" class="control-label">password</label>
            <input type="text" name="password" id="password" required class="form-control form-control-sm rounded-0" value="">
        </div>
        <div class="form-group">
            <label for="type" class="control-label">Type</label>
            <select name="type" id="type" class="form-control form-control" required>
                <option value="1" >Administrator</option>
                <option value="2" >Staff</option>
            </select>
        </div>
    </form>
</div>


    <?php } ?>











<script>
    $(function(){
        $('#user-form').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
                _el.addClass('pop_msg')
            $('#uni_modal button').attr('disabled',true)
            $('#uni_modal button[type="submit"]').text('submitting form...')
            $.ajax({
                url:'Actions.php?a=save_user',
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