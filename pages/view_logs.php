<?php
include_once("./../controllers/auth_controller.php");
require_once('./../core/mysqli-config.php');


if (!(array_key_exists(AuthController::$KEY_LOGGED_IN, $_SESSION) && $_SESSION[AuthController::$KEY_LOGGED_IN])) {
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<!-- style -->
<head>
    <link rel="stylesheet" href="../components/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://fonts.googleapis.com/icon?family=PT+Mono" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logs</title>

    <style>
        .requestList {

            border-collapse: collapse;
            width: 50%;
            border:ridge 3px grey; border-collapse: collapse;
            background-color:white; color:black; width:50%;
        }
        th{
            background-color: #818181;
            color: white;
        }
        th, td {
            padding: 8px;
            text-align: left;
            /* border-bottom: 1px solid #ddd; */
        }
        .requestList tr:hover {
            background-color: #062e94;
            color: white;
        }
        * {
            box-sizing: border-box;
        }

        .row {
            margin-left:-5px;
            margin-right:-5px;
        }

        .search {
            width: 73%;
            border-collapse: collapse;
            display:inline-block;
        }

        .column {
            float: left;
            width: 50%;
            padding: 5px;
        }


        /* Clearfix (clear floats) */
        .row::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<?php
require_once('./../core/mysqli-config.php');

function printLogs(){

    $conn = $GLOBALS['conn'];
    
    $query = "";
    if ($_SESSION['role'] == "Maintainer" || $_SESSION['role'] == "Auditor" || $_SESSION['role'] == "Administrator")
    {
        $query = 'SELECT * FROM LOG;';
    }

    $result = $conn->query($query);

    while($row = $result->fetch_row()) {
        echo "<tr>";
        foreach ($row as $value){
            echo "<td>".$value."</td>";
        }
        echo "</tr>";
    }
}

function logSearch($search_value){

    require_once('./../core/mysqli-config.php');

    $conn = $GLOBALS['conn'];
    
    $query = "";
    if ($_SESSION['role'] == "Auditor" || $_SESSION['role'] == "Maintainer" || $_SESSION['role'] == "Administrator")
    {
        $query = "CREATE OR REPLACE VIEW LOG_SEARCH AS SELECT * FROM LOG WHERE L_ID LIKE '%".$search_value."%' OR U_USERNAME LIKE '%".$search_value."%' OR L_ACTION LIKE '%".$search_value."%' OR L_TIMESTAMP LIKE '%".$search_value."%';";
    }

    $result = $conn->query($query);

    if ($_SESSION['role'] == "Auditor" || $_SESSION['role'] == "Maintainer" || $_SESSION['role'] == "Administrator")
    {
        $query = 'SELECT * FROM LOG_SEARCH;';
    }

    $result = $conn->query($query);

    while($row = $result->fetch_row()) {
        echo "<tr>";
        foreach ($row as $value){
            echo "<td>".$value."</td>";
        }
        echo "</tr>";
    }
}

function resetView(){

    require_once('./../core/mysqli-config.php');

    $conn = $GLOBALS['conn'];
    
    $query = "";
    if ($_SESSION['role'] == "Auditor" || $_SESSION['role'] == "Maintainer" || $_SESSION['role'] == "Administrator")
    {
        $query = "CREATE OR REPLACE VIEW LOG_SEARCH AS SELECT * FROM LOG;";
    }

    $result = $conn->query($query);

    if ($_SESSION['role'] == "Auditor" || $_SESSION['role'] == "Maintainer" || $_SESSION['role'] == "Administrator")
    {
        $query = 'SELECT * FROM LOG_SEARCH;';
    }

    $result = $conn->query($query);

    while($row = $result->fetch_row()) {
        echo "<tr>";
        foreach ($row as $value){
            echo "<td>".$value."</td>";
        }
        echo "</tr>";
    }
}

?>

<?php include_once("../components/navbar.php") ?>
<body id="main">
<span style="font-size:32px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
<div class="main" style="padding-top:40px; padding-left:30px;">
<h1>LOGS</h1>
<!-- read and gather data from the DB below, not complete-->
        <form method="post" id="search">
            <input type="text" id="search" name="search" class="search" placeholder="Search">
            <div style="display: inline;">
                <button class="form-group">
                <input class="btn btn-primary; fa fa-search" name='Submit' type="submit" value="Search" style="font-size: 15px;">
                </button>
                <button class="btn btn-success" style="background-color:red; border-color:red"name="reset">Reset</button>
            </div>
        </form>
    
        <table class="requestList" style="width: 87%" >
            <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Action</th>
                <th>Timestamp</th>
            </tr>
            </thead>
            <tbody>
            <?php

            if (!empty($_POST)) {
                if (isset($_POST['Submit'])) {
                    $search_value = isset($_POST['search']) ? $_POST['search'] : NULL;
                
                    logSearch($search_value);
                    die();
                }
                if (isset($_POST['reset'])) {
                    resetView();
                    die();
                }
                printLogs();
            } else {
                printLogs();
            }
            ?>
            </tbody>
            <table>
    </div>


</body>
</html>


