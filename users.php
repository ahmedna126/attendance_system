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

    $sql = "SELECT * FROM user_list WHERE status = 1";
    $stmt = $conn->connect()->prepare($sql);
    $stmt->execute();

    ?>



<div class="container py-3" id="page-container">

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Users List</h3>
        <div class="card-tools align-middle">
            <button class="btn btn-dark btn-sm py-1 rounded-0" type="button" id="create_new">Add New</button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover table-striped table-bordered">
            <colgroup>
                <col width="5%">
                <col width="25%">
                <col width="25%">
                <col width="25%">
                <col width="20%">
            </colgroup>
            <thead>
                <tr>
                    <th class="text-center p-0">#</th>
                    <th class="text-center p-0">Name</th>
                    <th class="text-center p-0">Username</th>
                    <th class="text-center p-0">Type</th>
                    <th class="text-center p-0">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $datas = $stmt->fetchAll();
                $i = 1;
                foreach($datas as $data){
                ?>
                                <tr>
                    <td class="text-center p-0"><?=$i++ ?></td>
                    <td class="py-0 px-1"><?=$data['fullname'] ?></td>
                    <td class="py-0 px-1"><?=$data['username']?></td>
                    <?php $dd = ($data['type'] == 1)? "Administrator" : "Staff"; ?>
                    <td class="py-0 px-1"><?=$dd ?></td>
                    <th class="text-center py-0 px-1">
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle btn-sm rounded-0 py-0" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <li><a class="dropdown-item edit_data" data-id = '<?=$data['user_id'] ?>' href="javascript:void(0)">Edit</a></li>
                            <li><a class="dropdown-item delete_data" data-id = '<?=$data['user_id'] ?>' data-name = '<?=$data['fullname'] ?>' href="javascript:void(0)">Delete</a></li>
                            </ul>
                        </div>
                    </th>
                </tr>
                <?php } ?>
                                            </tbody>
        </table>
    </div>
</div>
<script>
    $(function(){
        $('#create_new').click(function(){
            uni_modal('Add New User',"manage_user.php")
        })
        $('.edit_data').click(function(){
            uni_modal('Edit User Details',"manage_user.php?id="+$(this).attr('data-id'))
        })
        $('.delete_data').click(function(){
            _conf("Are you sure to delete <b>"+$(this).attr('data-name')+"</b> from list?",'delete_data',[$(this).attr('data-id')])
        })
    })
    function delete_data($id){
        $('#confirm_modal button').attr('disabled',true)
        $.ajax({
            url:'Actions.php?a=delete_user',
            method:'POST',
            data:{id:$id},
            dataType:'JSON',
            error:err=>{
                console.log(err)
                alert("An error occurred.")
                $('#confirm_modal button').attr('disabled',false)
            },
            success:function(resp){
                if(resp.status == 'success'){
                    location.reload()
                }else{
                    alert("An error occurred.")
                    $('#confirm_modal button').attr('disabled',false)
                }
            }
        })
    }
</script>       
 </div>