<?php


$date1=DateTime::createFromFormat('Y-m-d H:i:s', '2023-01-23 20:30:41')->format('Y-m-d');

    echo $date1 . '<BR>';
    echo date('Y-m-d');