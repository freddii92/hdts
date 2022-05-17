<?php

include_once("./../controllers/auth_controller.php");

$welcomeComponent = "";
if (array_key_exists(AuthController::$KEY_LOGGED_IN, $_SESSION) && $_SESSION[AuthController::$KEY_LOGGED_IN]) {
    $welcomeComponent = "
    
    "
    ;

} else {
    $welcomeComponent = "<div></div>";
}
?>

<div>

</div>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://fonts.googleapis.com/icon?family=PT+Mono" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<div id="mySidenav" class="sidenav">
    <img src="devcomBlack3.jpg" href="login.php" alt="Devcom"  style="margin-left:20px;width:150px;height:100px;">
    <h><b>HDTS</b></h>
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="menu.php">&nbspMenu</a>
    <?php
    if ($_SESSION['role'] == "Requester")
    {
        echo '<a href="create_request.php">&nbspCreate Request</a>';
        echo '<a href="view_requests.php">&nbspView Requests</a>';
        echo '<a href="view_inventory.php">&nbspView Inventory</a>';
        echo '<a href="view_profile_2.php">&nbspView Profile</a>';
        echo '<a href="generate_reports.php"></i>&nbspGenerate Report</a>';

    }
    ?>



    <?php
    if ($_SESSION['role'] == "Maintainer" || $_SESSION['role'] == "Auditor" )
    {
        echo '<a href="view_requests.php">&nbspView Requests</a>';
        echo '<a href="view_inventory.php">&nbspView Inventory</a>';
        echo '<a href="view_profile_2.php">&nbspView Profile</a>';
        echo '<a href="view_logs.php"></i>&nbspView Logs</a>';
        echo '<a href="generate_reports.php"></i>&nbspGenerate Report</a>';

    }
    ?>



    <?php
    if ($_SESSION['role'] == "Administrator")
    {
        echo '<a href="create_user.php">&nbspCreate User</a>';
        echo '<a href="view_profile_2.php">&nbspView Profile</a>';
        echo '<a href="test_userV.php">&nbspView Users</a>';
        echo '<a href="view_logs.php"></i>&nbspView Logs</a>';
        echo '<a href="generate_reports.php"></i>&nbspGenerate Report</a>';
    }
    ?>


    <form action="../pages/switch_roles.php" method="post">
        <a class="form-group">
            <select name='role' style="background-color: #000000; color: #ffffff; border: none; padding-left: 4px" onchange='this.form.submit()'>
                <option selected disabled>Switch Role</option>
                <?php
                $valid_roles = $auth->getRoles($_SESSION['user']);
                if ($valid_roles[0] == 1){
                    echo '<option>Requester</option>';
                }
                if ($valid_roles[1] == 1){
                    echo '<option>Maintainer</option>';
                }
                if ($valid_roles[2] == 1){
                    echo '<option>Auditor</option>';
                }
                if ($valid_roles[3] == 1){
                    echo '<option>Administrator</option>';
                }
                ?>
            </select>
        </a>
    </form>

    <a href='logout.php'>&nbspLog Out</a>

</div>


<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "200px";
        document.getElementById("main").style.marginLeft = "200px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.getElementById("main").style.marginLeft= "0";
    }
</script>

</body>
</html>
