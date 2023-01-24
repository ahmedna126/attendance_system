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

        $sql = "SELECT * FROM year_level WHERE yl_id = ?";
        $stmt = $conn->connect()->prepare($sql);
        $stmt->execute([$id]);

        if($stmt->rowCount() != 1){
            header("location: index.php?page=maintenance");
            exit;
        }

            $data = $stmt->fetch();
    
?>

<div class="container-fluid">
    <form action="" id="yl-form">
        <input type="hidden" name="id" value="<?=$data['yl_id']?>">
        <div class="form-group">
            <label for="year_level" class="control-label">Name</label>
            <input type="text" autofocus name="year_level" id="year_level" required class="form-control form-control-sm rounded-0" value="<?=$data['name'] ?>">
        </div>
    </form>
</div>
<?php
    }else{
    
?>
<div class="container-fluid">
    <form action="" id="yl-form">
        <div class="form-group">
            <label for="year_level" class="control-label">Name</label>
            <input type="text" autofocus name="year_level" id="year_level" required class="form-control form-control-sm rounded-0" value="">
        </div>
    </form>
</div>
<?php } ?>
<script>
    $(function(){
        $('#yl-form').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
                _el.addClass('pop_msg')
            $('#uni_modal button').attr('disabled',true)
            $('#uni_modal button[type="submit"]').text('submitting form...')
            $.ajax({
                url:'Actions.php?a=save_yl',
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
