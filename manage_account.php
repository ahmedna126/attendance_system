<?php
    if(!isset($_SESSION)){
        session_start();
    }

    if (!isset($_SESSION['admin_id']) && !isset($_SESSION['username'])){
        header("location: Actions.php?a=logout");
        exit;
    }
?>
<div class="container py-3" id="page-container">
    <h3>Manage Account</h3>
    <hr>
    <div class="col-md-6">
        <form action="" id="user-form">
            <input type="hidden" name="id" value="<?=$_SESSION['admin_id'] ?>">
            <div class="form-group">
                <label for="fullname" class="control-label">Full Name</label>
                <input type="text" name="fullname" id="fullname" required=""
                    class="form-control form-control-sm rounded-0" value="<?=$_SESSION['name'] ?>">
            </div>
            <div class="form-group">
                <label for="username" class="control-label">Username</label>
                <input type="text" name="username" id="username" required=""
                    class="form-control form-control-sm rounded-0" value="<?=$_SESSION['username'] ?>">
            </div>
            <div class="form-group">
                <label for="password" class="control-label">New Password</label>
                <input type="password" name="password" id="password" class="form-control form-control-sm rounded-0"
                    value="">
            </div>
            <div class="form-group">
                <label for="old_password" class="control-label">Old Password</label>
                <input type="password" name="old_password" id="old_password"
                    class="form-control form-control-sm rounded-0" value="">
            </div>
            <div class="form-group">
                <small>Leave the password field blank if you don't want update your password.</small>
            </div>
            <div class="form-group d-flex w-100 justify-content-end">
                <button class="btn btn-sm btn-primary rounded-0 my-1">Update</button>
            </div>
        </form>
    </div>

    <script>
    $(function() {
        $('#user-form').submit(function(e) {
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
            _el.addClass('pop_msg')
            $('#uni_modal button').attr('disabled', true)
            $('#uni_modal button[type="submit"]').text('submitting form...')
            $.ajax({
                url: 'Actions.php?a=update_credentials',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'JSON',
                error: err => {
                    console.log(err)
                    _el.addClass('alert alert-danger')
                    _el.text("An error occurred.")
                    _this.prepend(_el)
                    _el.show('slow')
                    $('#uni_modal button').attr('disabled', false)
                    $('#uni_modal button[type="submit"]').text('Save')
                },
                success: function(resp) {
                    if (resp.status == 'success') {
                        location.reload()
                    } else {
                        _el.addClass('alert alert-danger')
                    }
                    _el.text(resp.msg)

                    _el.hide()
                    _this.prepend(_el)
                    _el.show('slow')
                    $('#uni_modal button').attr('disabled', false)
                    $('#uni_modal button[type="submit"]').text('Save')
                }
            })
        })
    })
    </script>
</div>