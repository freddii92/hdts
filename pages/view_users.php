<?php
include_once("./../controllers/auth_controller.php");
require_once('./../core/mysqli-config.php');


if (!(array_key_exists(AuthController::$KEY_LOGGED_IN, $_SESSION) && $_SESSION[AuthController::$KEY_LOGGED_IN])) {
    header("Location: login.php");
}

?>

<?php
function printUsers(){


    $conn = $GLOBALS['conn'];
    
    $query = "";
    if ($_SESSION['role'] == "Administrator")
    {
        $query = 'SELECT * FROM USER_PROFILE;';        
    }

    $result = $conn->query($query);

    while($row = $result->fetch_row()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row[0]) . "</td>";
        echo "<td>" . htmlspecialchars($row[1]) . "</td>";
        echo "<td>" . htmlspecialchars($row[2]) . "</td>";
        echo "<td>" . htmlspecialchars($row[3]) . "</td>";
        echo "<td>" . htmlspecialchars($row[4]) . "</td>";

        if ($row[5] == 0){
            echo "<td>" ."No" . "</td>";    
        }else{
            echo "<td>" ."Yes" . "</td>";
        }
        if ($row[6] == 0){
            echo "<td>" ."No" . "</td>";    
        }else{
            echo "<td>" ."Yes" . "</td>";
        }
        if ($row[7] == 0){
            echo "<td>" ."No" . "</td>";    
        }else{
            echo "<td>" ."Yes" . "</td>";
        }
        if ($row[8] == 0){
            echo "<td>" ."No" . "</td>";    
        }else{
            echo "<td>" ."Yes" . "</td>";
        }

        echo "<td>" . htmlspecialchars($row[9]) . "</td>";
        echo "<td>" . htmlspecialchars($row[10]) . "</td>";
        echo "<td>" . htmlspecialchars($row[11]) . "</td>";
        echo "<td>" . htmlspecialchars($row[12]) . "</td>";
        echo "</tr>";

    }


}
function userSearch($search_value){

    require_once('./../core/mysqli-config.php');

    $conn = $GLOBALS['conn'];
    
    $query = "";
    if ($_SESSION['role'] == "Administrator")
    {
        $query = "CREATE OR REPLACE VIEW USER_PROFILE_SEARCH AS SELECT * FROM USER_PROFILE WHERE U_USERNAME='".$search_value."';"; 
    }

    $result = $conn->query($query);

    if ($_SESSION['role'] == "Administrator")
    {
        $query = 'SELECT * FROM USER_PROFILE_SEARCH;';
    }

    $result = $conn->query($query);

    while($row = $result->fetch_row()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row[0]) . "</td>";
        echo "<td>" . htmlspecialchars($row[1]) . "</td>";
        echo "<td>" . htmlspecialchars($row[2]) . "</td>";
        echo "<td>" . htmlspecialchars($row[3]) . "</td>";
        echo "<td>" . htmlspecialchars($row[4]) . "</td>";
        if ($row[5] == 0){
            echo "<td>" ."No" . "</td>";    
        }else{
            echo "<td>" ."Yes" . "</td>";
        }
        if ($row[6] == 0){
            echo "<td>" ."No" . "</td>";    
        }else{
            echo "<td>" ."Yes" . "</td>";
        }
        if ($row[7] == 0){
            echo "<td>" ."No" . "</td>";    
        }else{
            echo "<td>" ."Yes" . "</td>";
        }
        if ($row[8] == 0){
            echo "<td>" ."No" . "</td>";    
        }else{
            echo "<td>" ."Yes" . "</td>";
        }
        echo "<td>" . htmlspecialchars($row[9]) . "</td>";
        echo "<td>" . htmlspecialchars($row[10]) . "</td>";
        echo "<td>" . htmlspecialchars($row[11]) . "</td>";
        echo "<td>" . htmlspecialchars($row[12]) . "</td>";
        echo "</tr>";

    }
}

function resetView(){

    require_once('./../core/mysqli-config.php');

    $conn = $GLOBALS['conn'];
    
    $query = "";
    if ($_SESSION['role'] == "Administrator")
    {
        $query = 'CREATE OR REPLACE VIEW USER_PROFILE_SEARCH AS SELECT * FROM USER_PROFILE';
    }

    $result = $conn->query($query);

    if ($_SESSION['role'] == "Administrator")
    {
        $query = 'SELECT * FROM USER_PROFILE_SEARCH;';
    }

    $result = $conn->query($query);

    while($row = $result->fetch_row()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row[0]) . "</td>";
        echo "<td>" . htmlspecialchars($row[1]) . "</td>";
        echo "<td>" . htmlspecialchars($row[2]) . "</td>";
        echo "<td>" . htmlspecialchars($row[3]) . "</td>";
        echo "<td>" . htmlspecialchars($row[4]) . "</td>";
        if ($row[5] == 0){
            echo "<td>" ."No" . "</td>";    
        }else{
            echo "<td>" ."Yes" . "</td>";
        }
        if ($row[6] == 0){
            echo "<td>" ."No" . "</td>";    
        }else{
            echo "<td>" ."Yes" . "</td>";
        }
        if ($row[7] == 0){
            echo "<td>" ."No" . "</td>";    
        }else{
            echo "<td>" ."Yes" . "</td>";
        }
        if ($row[8] == 0){
            echo "<td>" ."No" . "</td>";    
        }else{
            echo "<td>" ."Yes" . "</td>";
        }
        echo "<td>" . htmlspecialchars($row[9]) . "</td>";
        echo "<td>" . htmlspecialchars($row[10]) . "</td>";
        echo "<td>" . htmlspecialchars($row[11]) . "</td>";
        echo "<td>" . htmlspecialchars($row[12]) . "</td>";
        echo "</tr>";

    }
}

function filter($filter_option) {

    $conn = $GLOBALS['conn'];
    
    $query = "";

    if ($_SESSION['role'] == "Administrator")
    {

        if($filter_option == "Closed"){
            $query = 'SELECT * FROM USER_PROFILE_SEARCH WHERE U_STATUS = "Closed";';
        }else if($filter_option == "Requester"){
            $query = 'SELECT * FROM USER_PROFILE_SEARCH WHERE U_REQUESTER = 1;';
        }else if($filter_option == "Maintainer"){
            $query = 'SELECT * FROM USER_PROFILE_SEARCH WHERE U_MAINTAINER = 1;';
        }else if($filter_option == "Auditor"){
            $query = 'SELECT * FROM USER_PROFILE_SEARCH WHERE U_AUDITOR = 1;';
        }else if($filter_option == "Administrator"){
            $query = 'SELECT * FROM USER_PROFILE_SEARCH WHERE U_ADMIN = 1;';
        }else{
            $query = 'SELECT * FROM USER_PROFILE_SEARCH WHERE U_STATUS = "Active";';
        }
    }

    $result = $conn->query($query);

    while($row = $result->fetch_row()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row[0]) . "</td>";
        echo "<td>" . htmlspecialchars($row[1]) . "</td>";
        echo "<td>" . htmlspecialchars($row[2]) . "</td>";
        echo "<td>" . htmlspecialchars($row[3]) . "</td>";
        echo "<td>" . htmlspecialchars($row[4]) . "</td>";
        if ($row[5] == 0){
            echo "<td>" ."No" . "</td>";    
        }else{
            echo "<td>" ."Yes" . "</td>";
        }
        if ($row[6] == 0){
            echo "<td>" ."No" . "</td>";    
        }else{
            echo "<td>" ."Yes" . "</td>";
        }
        if ($row[7] == 0){
            echo "<td>" ."No" . "</td>";    
        }else{
            echo "<td>" ."Yes" . "</td>";
        }
        if ($row[8] == 0){
            echo "<td>" ."No" . "</td>";    
        }else{
            echo "<td>" ."Yes" . "</td>";
        }
        echo "<td>" . htmlspecialchars($row[9]) . "</td>";
        echo "<td>" . htmlspecialchars($row[10]) . "</td>";
        echo "<td>" . htmlspecialchars($row[11]) . "</td>";
        echo "<td>" . htmlspecialchars($row[12]) . "</td>";
        echo "</tr>";

    }
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
    <title>View Users</title>

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
            width: 50%;
            border-collapse: collapse;
            display:inline-block;
        }

        .filter {
            width: 15%;
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
?>


<?php include_once("../components/navbar.php") ?>
<body id="main">
<span style="font-size:32px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
<div class="main" style="padding-top:40px; padding-left:30px;">
<h1>User Profiles</h1>
<!-- read and gather data from the DB below, not complete-->
<!---->
<form method="post" id="search">
<input type="text" id="search" name="search" class="search" placeholder="Search">
            <div style="display: inline;">
                <button class="form-group">
                <input class="btn btn-primary; fa fa-search" name='Submit' type="submit" value="Search" style="font-size: 15px;">
                </button>
                <select class="filter" name="filter" id="filter">
                    <option value="Active">status - Active</option>
                    <option value="Closed">status - Closed</option>
                    <option value="Requester">role - Requester</option>
                    <option value="Maintainer">role - Maintainer</option>
                    <option value="Auditor">role - Auditor</option>
                    <option value="Administrator">role - Administrator</option>
                </select>
                <button class="form-group">
                <input class="btn btn-success; fa fa-search" name='filter_button' type="button" value="Filter" style="font-size: 15px;">
                </button>
                <button class="btn btn-success" style="background-color:red; border-color:red"name="reset">Reset</button>
            </div>
        </form>
<!----->
    
        <table class="requestList" style="width: 50%" >
            <thead>
            <tr>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>User Email</th>
                <th>Password</th>
                <th>Requester Privileges</th>
                <th>Maintainer Privileges</th>
                <th>Auditor Privileges</th>
                <th>Administrator Privileges</th>
                <th>Supervisor Email</th>
                <th>Branch Email</th>
                <th>Status</th>
                <th>Last Modified Date</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($_POST)) {
                if (isset($_POST['Submit'])) {
                    $search_value = isset($_POST['search']) ? $_POST['search'] : NULL;
                
                    userSearch($search_value);
                    die();
                }
                if (isset($_POST['reset'])) {
                    resetView();
                    die();
                }
                if (isset($_POST['filter'])) {

                    $filter_option = isset($_POST['filter']) ? $_POST['filter'] : NULL;
                    
                    filter($filter_option);
                    
                    die();
                }
                printUsers();
            } else {
                printUsers();
            }

            ?>
            </tbody>
            <table>
    </div>


</body>
</html>