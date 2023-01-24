<?php

        trait validate_input{
            function validate_input ($data){
                $data = trim($data);
                $data = strip_tags($data);
                $data = htmlspecialchars($data);
                $data = stripslashes($data);
                
                return $data;
            }
        }