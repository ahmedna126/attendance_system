<?php
    if(!isset($_SESSION)){
        session_start();
    }

    if (!isset($_SESSION['admin_id']) && !isset($_SESSION['username'])){
        header("location: Actions.php?a=logout");
        exit;
    }

        
        $p = (isset($_GET['page']))? $_GET['page'] : "home" ;
?>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-gradient" id="topNavBar">
            <div class="container">
                <a class="navbar-brand" href="#">
                Intrams - SAMS
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link <?php if($p == "home") echo "active";?>" aria-current="page" href="./">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($p == "students") echo "active";?>" aria-current="page" href="./?page=students">Students</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($p == "attendance_list") echo "active";?>" href="./?page=attendance_list">Attendance Records</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./attendance.php" target="_blank">Attendance</a>
                        </li>
                                                <li class="nav-item">
                            <a class="nav-link <?php if($p == "users") echo "active";?>" aria-current="page" href="./?page=users">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($p == "maintenance") echo "active";?>" href="./?page=maintenance">Maintenance</a>
                        </li>
                                                
                    </ul>
                </div>
                <div>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle bg-transparent  text-light border-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Hello <?=ucwords($_SESSION['username']) ?>                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="./?page=manage_account">Manage Account</a></li>
                        <li><a class="dropdown-item" href="Actions.php?a=logout">Logout</a></li>
                    </ul>
                </div>
                </div>
            </div>
        </nav>
       