<?php


    class db_conn {

       public function connect (){
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db = "attendance";

        try{
            $conn = new PDO("mysql:host={$host};dbname={$db}" , $user , $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $e){
            echo "connection failed " . $e ->getMessage();
        }
            return $conn;
        }

    }

    $conn = new db_conn();
