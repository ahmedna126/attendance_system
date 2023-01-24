
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance | Student Intramurals Attendance Management System</title>
    <link rel="stylesheet" href="Font-Awesome-master/css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="DataTables/datatables.min.css">
    <script src="DataTables/datatables.min.js"></script>
    <script src="Font-Awesome-master/js/all.min.js"></script>
    <script src="js/script.js"></script>
    <style>
        html,body{
            height:100%;
            width:100%;
        }
        main{
            height:100%;
            display:flex;
            flex-flow:column;
            background-color:#6E85B7;
            background:#6E85B7;
        }
        #page-container{
            flex: 1 1 auto; 
            overflow:auto;
        }
        #topNavBar{
            flex: 0 1 auto; 
        }
        .truncate-1 {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }
        .truncate-3 {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }
        .modal-dialog.large {
            width: 80% !important;
            max-width: unset;
        }
        .modal-dialog.mid-large {
            width: 50% !important;
            max-width: unset;
        }
        @media (max-width:720px){
            
            .modal-dialog.large {
                width: 100% !important;
                max-width: unset;
            }
            .modal-dialog.mid-large {
                width: 100% !important;
                max-width: unset;
            }  
        
        }
    </style>
</head>
<body>
    <main class="text-light">
    <div class="container py-3 d-flex flex-column " id="page-container">
        <div class="w-100 h-25 d-flex  align-items-center">
            <h2 class="text-center w-100 fs-1"><b>Intramurals - Student Attendance Management System</b></h2>
        </div>
        <div class="w-100 row flex-grow-1">
            <div class="col-md-6 d-flex flex-column align-items-center h-100 mx-auto">
                <div class="w-100 h-25 d-flex align-items-center">
                    <div class="w-100">
                        <h2 class="text-center"><b><span id="time_display">11:12 PM</span></b></h2>
                        <h5 class="text-center"><b><span id="date_display">Jan 23,2023 </span></b></h5>
                        <input type="hidden" id="date_time" value="">
                    </div>
                </div>
                <div class="w-100 h-75 d-flex align-items-center">
                    <div class="w-100">
                        <div class="card text-dark h-auto">
                            <div class="card-body">
                                <center><small>Please Enter your student Code</small></center>
                                <div class="form-group">
                                    <center><small id="msg"></small></center>
                                    <input type="text" autofocus class="form-control form-control-sm rounded-0" id="student_code">
                                </div>
                                <div class="form-group d-flex justify-content-between mt-3 mb-1">
                                    <button class="att_btn btn btn-primary rounded-pill py-0 col-lg-4 col-md-6 col-sm-12" type="button" data-id="1">In</button>
                                    <button class="att_btn btn btn-danger rounded-pill py-0 col-lg-4 col-md-6 col-sm-12" type="button" data-id="2">Out</button>
                                </div>
                            </div>
                        </div>
                    <center><a href="./index.php" class="mt-4 text-light"><b>Go to Admin Side</b></a></center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
    <div class="modal fade" id="uni_modal" role='dialog' data-bs-backdrop="static" data-bs-keyboard="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer py-1">
            <button type="button" class="btn btn-sm rounded-0 btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
            <button type="button" class="btn btn-sm rounded-0 btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
        </div>
    </div>
    <div class="modal fade" id="confirm_modal" role='dialog'>
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header py-2">
            <h5 class="modal-title">Confirmation</h5>
        </div>
        <div class="modal-body">
            <div id="delete_content"></div>
        </div>
        <div class="modal-footer py-1">
            <button type="button" class="btn btn-primary btn-sm rounded-0" id='confirm' onclick="">Continue</button>
            <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
        </div>
    </div>
</body>
</html>
<script>
    function date_time(){
        var currentdate = new Date(); 
        var datetime = "Last Sync: " + currentdate.getDate() + "/"
                + (currentdate.getMonth()+1)  + "/" 
                + currentdate.getFullYear() + " @ "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds();
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var _m = months[currentdate.getMonth()]
        var _Y = currentdate.getFullYear()
        var _d = String(currentdate.getDate()).padStart(2, 0)
        $('#date_display').text(_m + ' ' +_d+', '+_Y)
        var _h = currentdate.getHours() > 12 ? String(currentdate.getHours() - 12).padStart(2, '0') : String(currentdate.getHours()).padStart(2, '0');
        var _H = String(currentdate.getHours()).padStart(2, '0');
        var _mm = String(currentdate.getMinutes()).padStart(2, '0')
        var _a = currentdate.getHours() > 12 ? "PM" : "AM";
        var _s = String(currentdate.getSeconds()).padStart(2, '0');
        $('#time_display').text(_h + ':' +_mm+':'+_s+' '+_a);
        $('#date_time').val(_Y+'-'+String(currentdate.getMonth()+1).padStart(2, '0')+'-'+_d+' '+_H+':'+_mm+':'+_s)
    }
    $(function(){
        setInterval(() => {
            date_time()
        }, 100);
        $('.att_btn').click(function(){
            $('#msg').removeClass('text-danger text-success').text('')
            var sCode = $('#student_code').val()
            $("#student_code").removeClass('border-danger')
            if(sCode == ''){
                $("#student_code").addClass('border-danger').focus()
                return false;
            }
            var dateTime = $('#date_time').val()
            var att_type = $(this).attr('data-id')
            $('.att_btn').attr('disabled',true)
            $.ajax({
                url:'Actions.php?a=save_attendance',
                method:'POST',
                data:{student_code:sCode,att_type:att_type,date_created:dateTime},
                dataType:'json',
                error:err=>{
                    console.log(err)
                $('.att_btn').attr('disabled',false)
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        location.reload()
                    }else if(resp.status =='failed' && resp.msg){
                        var msg_h= $('#msg')
                        msg_h.addClass('text-danger')
                        msg_h.text(resp.msg)
                    }
                    $('.att_btn').attr('disabled',false)
                }
            })
        })
    })
</script>