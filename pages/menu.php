<?php
include_once("./../controllers/auth_controller.php");


if (!(array_key_exists(AuthController::$KEY_LOGGED_IN, $_SESSION) && $_SESSION[AuthController::$KEY_LOGGED_IN])) {
    header("Location: login.php");
}


?>


<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="../components/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://fonts.googleapis.com/icon?family=PT+Mono" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HDTS Menu</title>
</head>

<?php include_once("../components/navbar.php") ?>

<body id="main">
<span style="font-size:32px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>

<?php include_once("../components/switch_roles.php") ?>

<body id="main">
<span style="font-size:32px;cursor:pointer" Switch Roles</span>

<?php
if ($_SESSION['role'] == "Requester")
{
    echo '<div style="font-size:32px; padding-top:50px; padding-left:10%">
         <a href="create_request.php" style="color:black;"><u>Create Request</u></a>
         </div>';
    echo '<div style="font-size:32px; padding-top:50px; padding-left:10%">
            <a href="view_requests.php" style="color:black;"><u>View Requests</u></a>
    	    </div>';
    echo "<div style='font-size:32px; padding-top:50px; padding-left:10%'>
            <a href='view_inventory.php' style='color:black;'><u>View Inventory</u></a>
            </div>";
    echo "<div style='font-size:32px; padding-top:50px; padding-left:10%'>
            <a href='view_profile_2.php' style='color:black;'><u>View Profile</u></a>
            </div>";
    echo "<div style='font-size:32px; padding-top:50px; padding-left:10%'>
            <a href='generate_reports_modifications.php' style='color:black;'><u>Generate Report</u></a>
    	    </div>";
}
?>

<?php
if ($_SESSION['role'] == "Maintainer")
{
    echo '<div style="font-size:32px; padding-top:50px; padding-left:10%">
            <a href="view_requests.php" style="color:black;"><u>View Requests</u></a>
    	    </div>';
    echo "<div style='font-size:32px; padding-top:50px; padding-left:10%'>
            <a href='view_inventory.php' style='color:black;'><u>View Inventory</u></a>
            </div>";
    echo "<div style='font-size:32px; padding-top:50px; padding-left:10%'>
            <a href='view_profile_2.php' style='color:black;'><u>View Profile</u></a>
            </div>";
    echo "<div style='font-size:32px; padding-top:50px; padding-left:10%'>
            <a href='view_logs.php' style='color:black;'><u>View Logs</u></a>
    	    </div>";
    echo "<div style='font-size:32px; padding-top:50px; padding-left:10%'>
            <a href='generate_reports_modifications.php' style='color:black;'><u>Generate Report</u></a>
    	    </div>";
}
?>

<?php
if ($_SESSION['role'] == "Auditor")
{
    echo '<div style="font-size:32px; padding-top:50px; padding-left:10%">
            <a href="view_requests.php" style="color:black;"><u>View Requests</u></a>
    	    </div>';
    echo "<div style='font-size:32px; padding-top:50px; padding-left:10%'>
            <a href='view_inventory.php' style='color:black;'><u>View Inventory</u></a>
            </div>";
    echo "<div style='font-size:32px; padding-top:50px; padding-left:10%'>
            <a href='view_profile_2.php' style='color:black;'><u>View Profile</u></a>
            </div>";
    echo "<div style='font-size:32px; padding-top:50px; padding-left:10%'>
            <a href='view_logs.php' style='color:black;'><u>View Logs</u></a>
    	    </div>";
    echo "<div style='font-size:32px; padding-top:50px; padding-left:10%'>
            <a href='generate_reports_modifications.php' style='color:black;'><u>Generate Report</u></a>
    	    </div>";
}
?>





<?php
if ($_SESSION['role'] == "Administrator")
{
    echo '<div style="font-size:32px; padding-top:50px; padding-left:10%">
         <a href="create_user.php" style="color:black;"><u>Create User</u></a>
         </div>';

    echo "<div style='font-size:32px; padding-top:50px; padding-left:10%'>
        <a href='view_profile_admin.php' style='color:black;'><u>View Profile</u></a>
    	</div>";

    echo '<div style="font-size:32px; padding-top:50px; padding-left:10%">
        <a href="test_userV.php" style="color:black;"><u>View Users</u></a>
	</div>';

    echo "<div style='font-size:32px; padding-top:50px; padding-left:10%'>
            <a href='view_logs.php' style='color:black;'><u>View Logs</u></a>
    	    </div>";

    echo "<div style='font-size:32px; padding-top:50px; padding-left:10%'>
            <a href='generate_reports_modifications.php' style='color:black;'><u>Generate Report</u></a>
    	    </div>";

}
?>





</body>
</body>

