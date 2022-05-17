<?php
if(isset($_POST['requester name'])){
    $data = $_POST['requester name'];
}
?>

<?php
include_once("./../controllers/auth_controller.php");

//user must be logged in
if (!(array_key_exists(AuthController::$KEY_LOGGED_IN, $_SESSION) && $_SESSION[AuthController::$KEY_LOGGED_IN])) {
    header("Location: login.php");
}
?>

<?php
/*
* Reference for tables: https://getbootstrap.com/docs/4.5/content/tables/
*/
require_once('../core/mysqli-config.php');
?>

<!DOCTYPE html>
<html>


<head>
    <link rel="stylesheet" href="../components/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://fonts.googleapis.com/icon?family=PT+Mono" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HDTS Process Request</title>
</head>

<?php include_once("../components/navbar.php") ?>


<body id="main">
    <span style="font-size:32px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>

<div>


    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- read and gather data from the DB below, not complete-->
    <?php $sql = "SELECT * FROM process_request ";
    if ($result = $conn->query($sql)) {
    ?><body>
    <?php
    while ($row = $result->fetch_row()) {?>
    <tr>


        <div class="jumbotron" style="background-color:#FFFFFF;">
            <form>
                <div class="row">
                    <table style="width:50%" table class="center">
                        <tr id="ROW0" style="height:25px">
                            <td style="text-align:center"><strong><p style="color:black;font-size:16px">Request Form</Re></p><strong></td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table style="width:50%">
                        <tr id="ROWcontInfo" style="height:25px">
                            <td style="text-align:left"><strong><p style="color:black;font-size:16px">Contact information</p><strong></td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table style="width:50%">
                        <tr id="ROW1" style="height:25px">
                            <td> Requester Email: <div> <?php printf("%s", $row[0]); ?> </td>

                            <td>Requester Username: <div> <?php printf("%s", $row[1]); ?></td>

                            <td>Return By: <div> <?php printf("%s", $row[2]); ?> </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table style="width:50%">
                        <tr id="ROW2" style="height:25px">
                            <td style="text-align:left"><strong><p style="color:black;font-size:16px">Request Information</p><strong></td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table style="width:50%">
                        <tr id="ROW3" style="height:25px">
                            <td style="font-size:75%">Request Due by Date: <div> <?php
                                    //idk yet how to add to the date in other format, this will not update to the current date
                                    $date = date_create('2022-03-04');
                                    date_add($date, date_interval_create_from_date_string('30 days'));
                                    echo date_format($date, 'Y-m-d');
                                    ?> </td>
                            <td style="font-size:75%">Team lead: <div> <?php printf("%s", $row[1]); ?> </td>
                        </tr>
                    </table>
                </div>

                <div class="row">
                    <table style="width:50%">
                        <tr id="ROW5" style="height:25px">
                            <td style="text-align:left"><strong><p style="color:black;font-size:16px">Event Information</p><strong></td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table style="width:50%">
                        <tr id="ROW6" style="height:25px">
                            <td style="font-size:75%">Event Name: <div> <?php printf("%s", $row[3]); ?> </td>
                            <td style="font-size:75%">Event ID: <div> <?php printf("%s", $row[4]); ?> </td>
                        </tr>
                    </table>

                </div>
                <div class="row">
                    <table style="width:50%">
                        <tr id="ROW7" style="height:25px">

                            <td style="font-size:75%"><label for="event status">Event Status: <?php printf("%s", $row[5]); ?></td>

                            <td style="font-size:75%"><label for="Event Names">Event Type: <?php printf("%s", $row[6]); ?> </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table style="width:50%">
                        <tr id="ROW8" style="height:25px">
                            <td style="font-size:75%">Event Start Date: <?php printf("%s", $row[7]); ?> </td>
                            <td style="font-size:75%">Event End Date: <?php printf("%s", $row[8]); ?> </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table style="width:50%">
                        <tr id="ROW9" style="height:25px">
                            <td style="font-size:75%">Event Location: <?php printf("%s", $row[9]); ?> </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table style="width:50%">
                        <tr id="ROW8" style="height:25px">
                            <td style="font-size:75%">Event Description: <div> <?php printf("%s", $row[10]); ?> </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table style="width:50%">
                        <tr id="ROW10" style="height:25px">
                            <td style="font-size:75%">Comment Section: <div> <?php printf("%s", $row[11]); ?> </td>


                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table style="width:50%">
                        <tr id="ROW11" style="height:25px">
                            <td style="font-size:75%">End of Reporing Cycle Date: <?php printf("%s", $row[12]); ?> </td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table style="width:50%">
                        <tr id="ROW12" style="height:25px">
                            <td style="font-size:75%">Number of Hard Drives: <?php printf("%s", $row[13]); ?> </td>
                        </tr>
                    </table>
                </div>
        </div>
</div>
</div>
</div>


</tr>
<?php
}
?>
</body>
<?php
}
?>




</body>
</html>

<div class="btn-group">
    <button>Approve</button>
    <button>Edit Request</button>
    <button>Select Hard drives</button>
    <button>Deny</button>
</div>
