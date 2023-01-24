<?php

    if (!isset($_SESSION)){
        session_start();
    }

    if(!class_exists("db_conn")){
        require_once("classes/db_conn.class.php");
    }    include "classes/traits.php";

        class Actions extends db_conn {
            use validate_input;

            function login(){

                if (isset($_POST['username']) && isset($_POST['password'])){
                    
                    $username = $this->validate_input($_POST['username']);
                    $password = $_POST['password'];

                        $sql = "SELECT * FROM admin WHERE username = ?";
                        $stmt = $this->connect()->prepare($sql);
                        $stmt->execute([$username]);

                        if ($stmt->rowCount() != 1){
                            $resp['status'] = "error";
                            $resp['msg'] = "username or password is wrong";
                        }else{
                            $data = $stmt->fetch();
                            if(password_verify($password , $data['password'])){
                                $_SESSION['admin_id'] = $data['admin_id'];
                                $_SESSION['username'] = $data['username'];
                                $_SESSION['name'] = $data['name'];

                                $resp['status'] = "success";
                                $resp['msg'] = "successfully logined";
  
                             }else{
                                    $resp['status'] = "error";
                                    $resp['msg'] = "username or password is wrong";
                                }
                        }
                        
                    }else{
                         $resp['status'] = "error";
                         $resp['msg'] = "an error accouried";
                    }
                    return json_encode($resp);
                    }

                function logout(){
                    session_unset();
                    session_destroy();

                   header("location: login.php");
                       exit;
                }

                function update_credentials(){
                     $old_password='';
                    
                    extract($_POST);

                    $sql = "SELECT * FROM admin WHERE admin_id= ?";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->execute([$id]);

                    if ($stmt->rowCount() == 1){
                        $data = $stmt->fetch();

                            if (strcasecmp($data['username'] , "username") != 0){
                                $sql_test = "SELECT * FROM admin WHERE username = ? AND admin_id != ?";
                                $stmt_test = $this->connect()->prepare($sql_test);
                                $stmt_test->execute([$username , $_SESSION['admin_id']]);

                                if ($stmt_test->rowCount() >= 1){
                                    $resp['status'] = "error";
                                     $resp['msg'] = "username is taken";
                                }else{
                                    if (password_verify($old_password , $data['password'])){
                                        $password_hash = password_hash($password , PASSWORD_DEFAULT);
                                        $sql2 = "UPDATE admin SET password = ?, name= ?, username = ? WHERE admin_id = ?";
                                        $stmt2 = $this->connect()->prepare($sql2);
                                        $stmt2->execute([$password_hash , $fullname , $username, $id]);
            
                                        $_SESSION['username'] = $username;
                                        $_SESSION['name'] = $fullname;

                                        $resp['status'] = "success";
                                        $resp['msg'] = "successfully updated";
            
                                    }else{
                                        $resp['status'] = "error";
                                        $resp['msg'] = "old password is wrong";
                                    }
                                }
                            }
                       
                    }else{
                        $resp['status'] = "error";
                        $resp['msg'] = "an error accouried1";
                    }

                    return json_encode($resp);
                }
                

                public function save_sy(){
                    
                    extract($_POST);
                    if (isset($_POST['school_year']) && isset($_POST['status']) && isset($_POST['id']) 
                       && !empty($_POST['school_year'])  && !empty($_POST['id']) ){

                        $sql2 = "UPDATE `school_year` SET `status` = 0 ";
                        $stmt2 = $this->connect()->prepare($sql2);
                        $stmt2->execute();

                    $sql = "UPDATE school_year SET status = ? , school_year = ? WHERE sy_id =?";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->execute([$status , $school_year , $id]);

                    $resp['status'] = "success";
                    $resp['msg'] = "successfully updated";
                    }elseif (!isset($_POST['id'])){
                         extract($_POST);
                            if ($status == 1 ){
                                $sql2 = "UPDATE `school_year` SET `status` = 0 ";
                                $stmt2 = $this->connect()->prepare($sql2);
                                $stmt2->execute();
                            }
            
                            $sql = "INSERT INTO school_year (status, school_year) VALUES (? , ?)";
                                $stmt= $this->connect()->prepare($sql);
                                $stmt ->execute([$status , $school_year]);
            
                                    $resp['status'] = "success";
                                    $resp['msg'] = "successfully added";                        
                        
                    }else{
                        $resp['status'] = "error";
                        $resp['msg'] = "an error accouried1";
                    }
                    return json_encode($resp);
                }


                public function update_stat_sy(){
                    extract($_POST);
                    if (isset($_POST['id']) && isset($_POST['status']) && !empty($_POST['id']) ){
                   //     if($status == 0){$status = 1;}else{$status= 0;}
                   $sql2 = "UPDATE `school_year` SET `status` = 0 ";
                   $stmt2 = $this->connect()->prepare($sql2);
                   $stmt2->execute();
                   
                   $sql = "UPDATE school_year SET status = ?  WHERE sy_id =?";
                   $stmt = $this->connect()->prepare($sql);
                   $stmt->execute([$status , $id]);
                   
                    $resp['status'] = "success";
                    $resp['msg'] = "successfully updated";
                    }else{       
                        $resp['status'] = "error";
                        $resp['msg'] = "an error accouried12";
                    }
                    return json_encode($resp);
                }

               public function delete_school_year (){
                    extract($_POST);

                    if (isset($_POST['id'])){
                    $sql = "DELETE FROM school_year WHERE sy_id =? ";
                        $stmt = $this->connect()->prepare($sql);
                        $stmt->execute([$id]);

                        $resp['status'] = "success";
                        $resp['msg'] = "successfully deleted";
                    }else{
                        $resp['status'] = "error";
                        $resp['msg'] = "an error accouried";
                    }
                        return json_encode($resp);
                }

                public function save_yl(){
                    extract($_POST);
                    if (isset($_POST['year_level']) && isset($_POST['id']) 
                       && !empty($_POST['year_level'])  && !empty($_POST['id']) ){

                    $sql = "UPDATE year_level SET name = ? WHERE yl_id =?";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->execute([$year_level , $id]);

                    $resp['status'] = "success";
                    $resp['msg'] = "successfully updated";
                    }elseif (!isset($_POST['id'])){
                         extract($_POST);
            
                            $sql = "INSERT INTO year_level (name) VALUES (?)";
                                $stmt= $this->connect()->prepare($sql);
                                $stmt ->execute([$year_level]);
            
                                    $resp['status'] = "success";
                                    $resp['msg'] = "successfully added";                        
                        
                    }else{
                        $resp['status'] = "error";
                        $resp['msg'] = "an error accouried1";
                    }
                    return json_encode($resp);
                }

                public function delete_yl(){
                    extract($_POST);
                    if (isset($_POST['id'])){
                        $sql = "DELETE FROM year_level WHERE yl_id =? ";
                            $stmt = $this->connect()->prepare($sql);
                            $stmt->execute([$id]);
    
                            $resp['status'] = "success";
                            $resp['msg'] = "successfully deleted";
                        }else{
                            $resp['status'] = "error";
                            $resp['msg'] = "an error accouried";
                        }
                            return json_encode($resp);
                }

                public function update_stat_course(){
                    extract($_POST);
                    if (isset($_POST['id']) && isset($_POST['status']) && !empty($_POST['id']) ){
                   //    if($status == 0){$status = 1;}else{$status= 0;}
                   $sql = "UPDATE course_list SET status = ? WHERE course_id = ?";
                   $stmt = $this->connect()->prepare($sql);
                   $stmt->execute([$status , $id]);
                   
                    $resp['status'] = "success";
                    $resp['msg'] = "successfully updated";
                    }else{       
                        $resp['status'] = "error";
                        $resp['msg'] = "an error accouried12";
                    }
                    return json_encode($resp);
                }

                public function save_course (){
                    extract($_POST);
                    if (isset($_POST['name']) && isset($_POST['status']) && isset($_POST['id']) 
                       && !empty($_POST['name'])  && !empty($_POST['id']) ){

                    $sql = "UPDATE course_list SET status = ? , course_code = ? WHERE course_id =?";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->execute([$status , $name , $id]);

                    $resp['status'] = "success";
                    $resp['msg'] = "successfully updated";
                    }elseif (!isset($_POST['id'])){
                         extract($_POST);
            
                            $sql = "INSERT INTO course_list (status, course_code) VALUES (? , ?)";
                                $stmt= $this->connect()->prepare($sql);
                                $stmt ->execute([$status , $name]);
            
                                    $resp['status'] = "success";
                                    $resp['msg'] = "successfully added";                        
                        
                    }else{
                        $resp['status'] = "error";
                        $resp['msg'] = "an error accouried1";
                    }
                    return json_encode($resp);
                }

            public function delete_course(){
                extract($_POST);
                    if (isset($_POST['id'])){
                        $sql = "DELETE FROM course_list WHERE course_id =? ";
                            $stmt = $this->connect()->prepare($sql);
                            $stmt->execute([$id]);
    
                            $resp['status'] = "success";
                            $resp['msg'] = "successfully deleted";
                        }else{
                            $resp['status'] = "error";
                            $resp['msg'] = "an error accouried";
                        }
                            return json_encode($resp);
            }
               

            public function save_student(){
                extract($_POST);
                $gender = ($_POST['gender'] ==  1)? "male" : "female";
                $status = ($_POST['status'] >=  1)? 1 : 0 ;

                if (!empty($_POST['id']) && isset($_POST['id']) && isset($_POST['sy_id']) ){
                    $sql1 = "SELECT * FROM students WHERE student_code = ? AND student_id != ?";
                    $stmt1 = $this->connect()->prepare($sql1);
                    $stmt1->execute([$student_code , $id]);

                        if ($stmt1->rowCount() >= 1){
                            $resp['status'] = "error";
                             $resp['msg'] = "student code is taken!";
                             return json_encode($resp);
                             exit;
                            }
                $sql = "UPDATE students SET student_code = ? , fname = ? , mname =? , lname = ? , email = ? , contact = ? , gender = ? , yl_id = ? , status = ? , course_id = ?  WHERE student_id =?";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([ $student_code , $fname , $mname , $lname , $email, $contact,$gender , $yl_id , $status , $course_id , $id]);

                $resp['status'] = "success";
                $resp['msg'] = "successfully updated";
                }elseif (!isset($_POST['id']) && isset($_SESSION['sy_id'])){

                    $sql1 = "SELECT * FROM students WHERE student_code = ?";
                    $stmt1 = $this->connect()->prepare($sql1);
                    $stmt1->execute([$student_code]);

                        if ($stmt1->rowCount() >= 1){
                            $resp['status'] = "error";
                             $resp['msg'] = "student code is taken!";
                             return json_encode($resp);
                             exit;
                            }
        
                     $sql = "INSERT INTO students (student_code , fname , mname , lname , email , contact , gender , yl_id , status , course_id , sy_id ) VALUES (?,?,?,?,?,?,?,?,?,? , ?)";    
                     $stmt = $this->connect()->prepare($sql);
                     $stmt->execute([ $student_code , $fname , $mname , $lname , $email, $contact,$gender , $yl_id , $status , $course_id , $_SESSION['sy_id']]);
     
        
                                $resp['status'] = "success";
                                $resp['msg'] = "successfully added";                        
                    
                }else{
                    $resp['status'] = "error";
                    $resp['msg'] = "an error accouried1";
                }
                return json_encode($resp);
            }


            public function delete_student(){
                extract($_POST);
                    if (isset($_POST['id'])){
                        $sql = "DELETE FROM students WHERE student_id =? ";
                            $stmt = $this->connect()->prepare($sql);
                            $stmt->execute([$id]);
    
                            $resp['status'] = "success";
                            $resp['msg'] = "successfully deleted";
                        }else{
                            $resp['status'] = "error";
                            $resp['msg'] = "an error accouried";
                        }
                            return json_encode($resp);
            }


            public function save_attendance(){
                extract($_POST);
                if(isset($student_code) && isset($att_type) && isset($date_created) ){
                    $att_type = ($att_type == 1 ) ? 1 : 2;

                    $sql = "SELECT * FROM students WHERE student_code = ? AND status = 1";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->execute([$student_code]);

                    if($stmt->rowCount() == 1){
                        $data_student = $stmt->fetch();

                        $sql2 = "SELECT * FROM attendance_list WHERE student_id = ? AND STR_TO_DATE(date_created , '%Y-%m-%d')= CURDATE() AND type = ?";
                        $stmt2 = $this->connect()->prepare($sql2);
                        $stmt2->execute([$data_student['student_id'] , $att_type]);

                        
                        if($stmt2->rowCount() == 0){

                            $date_created = date('M d ,Y h:i A');
                            $sql3 = "INSERT INTO attendance_list(student_id , type , date_updated) VALUES (? , ? , ?)";
                            $stmt3 = $this->connect()->prepare($sql3);
                            $stmt3->execute([$data_student['student_id'] , $att_type , $date_created  ]);
                            
                            $resp['status'] = "success";
                            $resp['msg'] = "successfully added";
                            
                            }else{
                                $resp['status'] = "failed";
                                $resp['msg'] = "You already have Time In record today.";
                            }
                    }else{
                        $resp['status'] = "failed";
                        $resp['msg'] = "Uknown student Code.";
                    }
                }else{
                    $resp['status'] = "failed";
                    $resp['msg'] = "an error accouried";      
                }
                return json_encode($resp);
        }


        public function save_user(){
            extract($_POST);
            $gender = ($_POST['type'] ==  1)? 1 : 2;

            if (!empty($_POST['id']) && isset($_POST['id']) && is_numeric($_POST['id']) && isset($_POST['fullname']) && isset($_POST['username']) && isset($_POST['type']) ){
                $sql1 = "SELECT * FROM user_list WHERE username = ? AND user_id != ?";
                $stmt1 = $this->connect()->prepare($sql1);
                $stmt1->execute([$username , $id]);

                    if ($stmt1->rowCount() >= 1){
                        $resp['status'] = "error";
                         $resp['msg'] = "username is taken!";
                         return json_encode($resp);
                         exit;
                        }
            $sql = "UPDATE user_list SET username =? , fullname = ? , type =? WHERE user_id =?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([ $username , $fullname , $type , $id]);

            $resp['status'] = "success";
            $resp['msg'] = "successfully updated";
            }elseif (!isset($_POST['id']) && isset($_POST['fullname']) && isset($_POST['username']) && isset($_POST['type']) && isset($_POST['password'])){

                $sql1 = "SELECT * FROM user_list WHERE username = ?";
                $stmt1 = $this->connect()->prepare($sql1);
                $stmt1->execute([$username]);

                    if ($stmt1->rowCount() >= 1){
                        $resp['status'] = "error";
                         $resp['msg'] = "username is taken!";
                         return json_encode($resp);
                         exit;
                        }
    
                        $password_hash = password_hash($password, PASSWORD_DEFAULT);
                 $sql = "INSERT INTO user_list (username , fullname , type , password) VALUES (?,?,? , ?)";    
                 $stmt = $this->connect()->prepare($sql);
                 $stmt->execute([ $username , $fullname , $type , $password_hash]);
 
    
                            $resp['status'] = "success";
                            $resp['msg'] = "successfully added";                        
                
            }else{
                $resp['status'] = "error";
                $resp['msg'] = "an error accouried1";
            }
            return json_encode($resp);
        }


        public function delete_user(){
            extract($_POST);
            if (isset($_POST['id'])){
                $sql = "DELETE FROM user_list WHERE user_id =? ";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->execute([$id]);

                    $resp['status'] = "success";
                    $resp['msg'] = "successfully deleted";
                }else{
                    $resp['status'] = "error";
                    $resp['msg'] = "an error accouried";
                }
                    return json_encode($resp);
        }


    }

        $action = new Actions();

    $a = $_GET['a'];

    switch($a){
        case "login" :
           echo $action->login();
            break;
        case "logout":
            $action->logout();
            break;
        case "update_credentials" :
           echo $action->update_credentials();
            exit;
        case "save_sy":
            echo $action->save_sy();
            break;
        case "update_stat_sy":
            echo $action->update_stat_sy();
            break;
        case "delete_school_year":
            echo $action->delete_school_year();
            break;
        case "save_yl":
            echo $action->save_yl();
            exit;
        case "delete_yl":
            echo $action->delete_yl();
            break;
        case "update_stat_course":
            echo $action->update_stat_course();
            break;
        case "save_course":
            echo $action->save_course();
            break;
        case "delete_course":
            echo $action->delete_course();
            break;
        case "save_student":
            echo $action->save_student();
            break;
        case "delete_student":
            echo $action->delete_student();
            break;
        case "save_attendance":
            echo $action->save_attendance();
            break;
        case "save_user":
            echo $action->save_user();
            break;
        case "delete_user":
            echo $action->delete_user();
            break;


    }