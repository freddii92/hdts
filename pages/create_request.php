<?php

require_once("./../controllers/auth_controller.php");
require_once('./../controllers/request_controller.php');

if (!(array_key_exists(AuthController::$KEY_LOGGED_IN, $_SESSION) && $_SESSION[AuthController::$KEY_LOGGED_IN])) {
    header("Location: login.php");
} else if (!empty($_POST) && isset($_POST['Submit'])) {

    $u_user = $_SESSION['user'];
    $r_comments = "";

    $e_event_name = isset($_POST['event_name']) ? $_POST['event_name'] : "Test";
    $e_event_description = isset($_POST['event_description']) ? $_POST['event_description'] : "Hello";
    $e_event_location = isset($_POST['event_location']) ? $_POST['event_location'] : "El Paso, Texas";
    $e_event_type = isset($_POST['event_type']) ? $_POST['event_type'] : "CVI";
    $e_event_length = isset($_POST['event_length']) ? $_POST['event_length'] : 7;
    $e_event_start_date = isset($_POST['event_start_date']) ? $_POST['event_start_date'] : "2022-03-05";
    $e_event_end_date = isset($_POST['event_end_date']) ? $_POST['event_end_date'] : "2022-03-12";

    $h_classication = isset($_POST['classification']) ? $_POST['classification'] : "unclassified";
    $h_amount = isset($_POST['hard_drive_amount']) ? $_POST['hard_drive_amount'] : 1;
    $h_port = isset($_POST['hard_drive_port']) ? $_POST['hard_drive_port'] : "SATA";
    $h_size = isset($_POST['hard_drive_size']) ? $_POST['hard_drive_size'] : "500GB";
    $h_hard_drive_type = isset($_POST['hard_drive_type']) ? $_POST['hard_drive_type'] : "SSD";
    $h_comment = isset($_POST['h_comment']) ? $_POST['h_comment'] : "";

    $need_by = isset($_POST['need_by']) ? $_POST['need_by'] : "0000-00-00";


    $year = date("Y");
    $current_time = date("Y-m-d h:i:s");

    $r_ref_number_no = $req->NextRefNum;

    echo $r_ref_number_no;
    $request_success = $req->insertToRequest($year,$r_ref_number_no,"PENDING", $current_time, $current_time, $need_by , $r_comments, $u_user);
    $event_success = $req->insertToEvent($e_event_name,$e_event_description,$e_event_location,$e_event_type,$e_event_length,$e_event_start_date,$e_event_end_date,$year,$r_ref_number_no);
    $hard_drive_request_success = $req->insertToHardDriveRequest($h_classication,$h_amount,$h_port,$h_size, $h_hard_drive_type, $h_comment, $year,$r_ref_number_no);

    if ($request_success && $event_success && $hard_drive_request_success) {
        header("Location: Confirmation.php");
    }
}
//?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../components/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .row {
            padding-left:15%;
            padding-top: 10px;
        }
        .required-field::after {
            content: "*";
            color: red;

        }
        table {
            margin: 18px 0;
            width: 100%;
        }
        table th,
        table td {
            text-align: left;
            padding: 6px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".add").click(function() {
                var classification = $("#classification").val();
                var no_of_hd = $("#number_of_hard_drives").val();
                var port = $("#connection_port").val();
                var type = $("#hard_drive_type").val();
                var size = $("#hard_drive_size").val();
                var comment = $("#h_comment").val();
                var ligne = "<tr><td><input type='checkbox' name='select'></td><td>" + classification + "</td><td>" + no_of_hd + "</td><td>" + port + "</td><td>"
                    + type + "</td><td>" + size + "</td><td>" + comment + "</td></tr>";
                $("table.test").append(ligne);
            });
            $(".delete").click(function() {
                $("table.test").find('input[name="select"]').each(function() {
                    if ($(this).is(":checked")) {
                        $(this).parents("table.test tr").remove();
                    }
                });
            });
        });
    </script>
</head>

<?php include_once("../components/navbar.php") ?>
<body id="main">



    <form method="post" action="create_request.php">
        <div class="main" >
            <span style="font-size:32px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
            <div class="container border border-secondary" style="background-color:#FFFFFF;">
                    <div class="row">
                        <table style="width:85%">
                            <tr id="ROW0" style="height:25px">
                                <td style="text-align:center"><strong><p style="color:black;font-size:32px">Request Form</Re></p><strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <table style="width:85%">
                            <tr id="ROWcontInfo" style="height:25px">
                                <td style="text-align:left"><strong><p style="color:black;font-size:16px">Contact Information</p><strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <table style="width:85%">
                            <tr id="ROW1" style="height:25px">
                                <td>Requester Email: <?php echo $_SESSION[AuthController::$KEY_EMAIL]; ?></td>

                                <td>Requester Username: <?php echo $_SESSION[AuthController::$KEY_USER]; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <table style="width:85%">
                            <tr id="ROW2" style="height:25px">
                                <td style="text-align:left"><strong><p style="color:black;font-size:16px">Request Information</p><strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <table style="width:83%">
                            <tr id="ROW3" style="height:25px" class="required-field">
                                <td style="font-size:75%">Request Need by Date: <input type="date" class="form-control" size="17" id="request_need_date" name="request_need_date" placeholder="YYYY-MM-DD" required></td>
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <table style="width:83%">
                            <tr id="ROW3" style="height:25px" class="required-field">
                                <td style="font-size:75%">Request Due by Date: <input type="date" class="form-control" size="17" id="request_due_date" name="request_due_date" placeholder="YYYY-MM-DD" required></td>
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <table style="width:85%">
                            <tr id="ROW4" style="height:25px">
                                <td style="font-size:75%">I am the Team lead for this Event <input type="checkbox" id="team_lead" name="team_lead" value="I am the Team Lead for this Event"></td>
                                <td style="font-size:75%"><span style="white-space: pre-line"> </span>If you are filling this request on behalf of your <span style="white-space: pre-line"><strong>Team Lead</strong>, please select the appropriate team <span style="white-space: pre-line"> </span>lead from the following list.</td>
                            </tr>
                        </table>
                    </div>

                    <div class="row">
                        <table style="width:85%">
                            <tr id="ROW5" style="height:25px">
                                <td style="text-align:left"><strong><p style="color:black;font-size:16px">Event Information</p><strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <table style="width:84%">
                            <tr id="ROW6" style="height:25px" class="required-field">
                                <td style="font-size:75%">Event Name: <input type="text" class="form-control" size="10" id="event_name" name = "event_name" placeholder="Enter Name" required></td>
                            </tr>
                        </table>

                    </div>
                    <div class="row">
                        <table style="width:85%">
                            <tr id="ROW7" style="height:25px">

                                <td style="font-size:75%" class="required-field"><label for="event status">Event Status:</label>
                                    <select name="event_status" id="status_names">
                                        <option value="pending">Forecasted</option>
                                        <option value="modify">Modified</option>
        <!--                                <option value="cancelled">Cancelled</option>-->
                                        <option value="confirmed">Confirmed</option>
                                    </select>
                                </td>

                                <td style="font-size:75%" class="required-field"><label for="Event Names" >Event Type:</label>
                                    <select name="event_type" id="event-type-names">
                                        <default value="choose" class="required-field">Type</default>
                                        <option value="CVI">CVI</option>
                                        <option value="VoF">VoF</option>
                                        <option value="PMR">PMR</option>
                                        <option value="CPVA">CPVA</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <table style="width:83%">
                            <tr id="ROW8" style="height:25px" class="required-field">
                                <td style="font-size:75%">Event Start Date: <input type="date"  class="form-control" size="10" id="event_start"  name = "event_start" placeholder="YYYY-MM-DD" required></td>
                            </tr>
                        </table>
                    </div>
                <div class="row">
                    <table style="width:83%">
                        <tr id="ROW8" style="height:25px" class="required-field">
                            <td style="font-size:75%">Event End Date: <input type="date" class="form-control" size="10" id="event_end" name = "event_end" placeholder="YYYY-MM-DD" required></td>
                        </tr>
                    </table>
                </div>
                    <div class="row">
                        <table style="width:78.5%">
                            <tr id="ROW9" style="height:25px">
                                <td style="font-size:75%">Event Location: <input type="text" class="form-control" size="17" id="event_location" name = "event_location" placeholder="Enter Event Location" required></td>
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <table style="width:85%">
                            <tr id="ROW8" style="height:25px">
                                <td style="font-size:75%">Event Description: <span style="white-space: pre-line">
                                        <input type="text" class="form-control" size="30" style="height:100px;width:500px" id="event_description" name = "event_description" placeholder="Event Information" required></span></td>


                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <table style="width:85%">
                            <tr id="ROW10" style="height:25px">
                                <td style="font-size:75%">Comment Section: <span style="white-space: pre-line">
                                        <input type="text" class="form-control" size="30" style="height:100px;width:500px" id="event_information" name="event_information" placeholder="Event Information" required></span></td>


                            </tr>
                        </table>
                    </div>
                    <!--<div class="row">
                        <table style="width:85%">
                            <tr id="ROW11" style="height:25px">
                                <td style="font-size:75%">End of Reporing Cycle Date: <input type="text" class="form-control" size="17" id="event start" placeholder="Enter End of Reporting Cycle" required></td>
                            </tr>
                        </table>
                    </div>-->
                    <div class="row">
                        <table style="width:85%">
                            <tr id="ROW12" style="height:25px">
                                <td style="text-align:left"><strong><p style="color:black;font-size:16px">Hard Drives Requested Information</p><strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <table style="width:85%">
                            <tr id="ROW13" style="height:25px">
                                <td style="font-size:75%"><span style="white-space: pre-line"> </span>Under normal Cicumstances you are only allowed to request up to <strong>30 hard drives</strong> per event.<span style="white-space: pre-line">
                                            If you require more than <strong>30 hard drives</strong>, please contact your <strong>Supervisor or one of the HDTS maintainers.</strong></span><span style="white-space: pre-line"> </span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="row">
                        <table style="width:95%">
                            <tr id="ROW14" style="height:25px">
                                <td style="text-align:left"><strong><p style="color:black;font-size:12px">Classification <label class="required-field"></label></p><strong></td>
                                <td style="text-align:left"><strong><p style="color:black;font-size:12px">Number of Hard Drives <label class="required-field"></label></p><strong></td>
                                <td style="text-align:left"><strong><p style="color:black;font-size:12px">Connection Port <label class="required-field"></label></p><strong></td>

                                <td style="text-align:left"><strong><p style="color:black;font-size:12px">Hard Drive Type <label class="required-field"></label></p><strong></td>
                                <td style="text-align:left"><strong><p style="color:black;font-size:12px">Hard Drive Size <label class="required-field"></label></p><strong></td>
                                <td style="text-align:left"><strong><p style="color:black;font-size:12px">Comment <label class="required-field"></label></p><strong></td>


                            </tr>
                            <tr id="ROW6" style="height:25px;">
                                <td style="font-size:75%">
                                    <label for="classification" > </label>
                                    <select name="classification" id="classification" >
                                        <option value="Classified">Classified</option>
                                        <option value="Unclassified" >Unclassified</option>

                                    </select>

                                </td>
                                <td style="text-align:left; height:25px; width:150px" ><input type="text" class="form-control" class="required-field" size="12" name="hard_drive_amount" id="number_of_hard_drives" placeholder="Enter Number of Hard Drives" required></td>


                                <td style="font-size:75%; height:25px;"><label for="connection port"></label>
                                    <select name="hard_drive_port" id="connection_port">
                                        <option value="SATA">SATA</option>
                                        <option value="HDMI">HDMI</option>
                                        <option value="USB">USB</option>
                                    </select>

                                </td>

                                <!--<td style="font-size:75%; height:25px;"><input type="text" class="form-control" size="12" name="hard_drive_type" id="hard_drive_type" placeholder="Enter Hard Drives Type" required></td>-->
                                <td style="font-size:75%; height:25px;"><label for="hard drive type"></label>
                                    <select name="hard_drive_type" id="hard_drive_type">
                                        <option value="HDD">HDD</option>
                                        <option value="SSD">SSD</option>
                                    </select>

                                </td>

                                <!--<td style="font-size:75%; height:25px;"><input type="text" class="form-control" size="12" name="hard_drive_size" id="hard_drive_size" placeholder="Enter Hard Drives Size" required> <label class="required-field"></label></td>-->

                                <td style="font-size:75%; height:25px;"><label for="hard drive size"></label>
                                    <select name="hard_drive_size" id="hard_drive_size">
                                        <option value="128GB">128GB</option>
                                        <option value="256GB">256GB</option>
                                        <option value="500GB">500GB</option>
                                        <option value="1TB">1TB</option>
                                    </select>

                                </td>
                                <td style="text-align:left; height:25px; width:150px;"><input type="text" class="form-control" size="12" name="h_comment" id="h_comment" placeholder="Enter Comment" required></td>
                                <td style="text-align:left; height:25px; width:150px;"><input type="button" class="add" value="Add row"></td>

                            </tr>

                        </table>
                        <p> Hard Drives that have been added: </p> <br />
                        <table class="test">
                            <tr id="ROW14" style="height:25px">
                                <td style="text-align:left"><strong><p style="color:black;font-size:12px">Select </p><strong></td>
                                <td style="text-align:left"><strong><p style="color:black;font-size:12px">Classification </p><strong></td>
                                <td style="text-align:left"><strong><p style="color:black;font-size:12px">Number of Hard Drives </label></p><strong></td>
                                <td style="text-align:left"><strong><p style="color:black;font-size:12px">Connection Port</p><strong></td>
                                <td style="text-align:left"><strong><p style="color:black;font-size:12px">Hard Drive Type </p><strong></td>
                                <td style="text-align:left"><strong><p style="color:black;font-size:12px">Hard Drive Size </p><strong></td>
                                <td style="text-align:left"><strong><p style="color:black;font-size:12px">Comment </label></p><strong></td>

                            </tr>
                            <tr>
                                <td><input type="checkbox" name="select"></td>
                            </tr>
                        </table>
                        <button type="button" class="delete">Delete row</button>
                    </div>

            </div>

            <div style="padding-left:18%;padding-top: 25px;" id="main">
                <button type="Submit" name="Submit" class="btn btn-secondary">Submit</button>
            </div>

        </div>
    </form>


</body>
</html>
