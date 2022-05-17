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



    $year = date("Y");
    $current_time = date("Y-m-d h:i:s");

    $r_ref_number_no = $req->NextRefNum;

    echo $r_ref_number_no;
    $request_success = $req->insertToRequest($year,$r_ref_number_no,"PENDING", $current_time, $current_time, $current_time , $r_comments, $u_user);
    $event_success = $req->insertToEvent($e_event_name,$e_event_description,$e_event_location,$e_event_type,$e_event_length,$e_event_start_date,$e_event_end_date,$year,$r_ref_number_no);

    $h_classication = isset($_POST['classification']) ? $_POST['classification'] : "unclassified";
    $h_amount = isset($_POST['hard_drive_amount']) ? $_POST['hard_drive_amount'] : 1;
    $h_port = isset($_POST['hard_drive_port']) ? $_POST['hard_drive_port'] : "SATA";
    $h_size = isset($_POST['hard_drive_size']) ? $_POST['hard_drive_size'] : "500GB";
    $h_hard_drive_type = isset($_POST['hard_drive_type']) ? $_POST['hard_drive_type'] : "SSD";
    $h_comment = isset($_POST['h_comment']) ? $_POST['h_comment'] : "";
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
        #toggleThis {
            border 1px solid black;
        }
        #content {
            display:none;
        }
    </style>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
    </script>
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
    <script src="script.js"></script>
</head>

<?php include_once("../components/navbar.php") ?>

<body id="main">



<form method="post" action="create_request.php">
    <span style="font-size:32px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
    <div class="container border border-secondary" style="background-color:#FFFFFF;">

        <div class="row">
            <table style="width:85%">
                <tr id="ROW0" style="height:25px">
                    <td style="text-align:center"><strong><p style="color:black;font-size:32px">Generate Reports</Re></p><strong></td>
                </tr>
            </table>
        </div>

        <div class="row">
            <table style="width:85%">
                <tr id="ROW2" style="height:25px">
                    <td style="text-align:left"><strong><p style="color:black;font-size:16px">Scheduled Report</p><strong></td>
                </tr>
            </table>
        </div>
        <div class="row">
            <table style="width:29%">
                <tr id="ROW3" style="height:25px">
                    <td style="font-size:75%">Report Title: <input type="text" class="form-control" size="17" id="report_title" name="report_title" placeholder="Enter Report Title" required></td>

                </tr>
            </table>
        </div>

        <div class="row">
            <table style="width:85%">
                <tr id="ROW6" style="height:25px">
                    <td style="font-size:75%">Frequency: <input type="text" class="form-control" size="10" id="frequency" name = "frequency" placeholder="Enter Frequency" required></td>
                </tr>
            </table>

        </div>

        <div class="row">
            <table style="width:85%">
                <tr id="ROW6" style="height:25px">
                    <td style="font-size:75%">Recepients Email: <input type="text" class="form-control" size="10" id="recepients_email" name = "recepients_email" placeholder="Enter Recipients Email" required></td>
                </tr>
            </table>

        </div>
        <div class="row">
            <table style="width:85%">
                <tr id="ROW7" style="height:25px">

                    <td style="font-size:75%"><label for="Report Format">Report Format:</label>
                        <select name="report_format" id="format">
                            <default value="choose">Format</default>
                            <option value="CVI">.csv</option>
                            <option value="VoF">JSON</option>
                            <option value="PMR">.xlsx</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <hr style="border-top:1px solid black">
        <div class="row">
            <table style="width:85%">
                <tr id="ROW2" style="height:25px">
                    <td style="text-align:left"><strong><p style="color:black;font-size:16px">Hard Drive Report Building</p><strong></td>
                </tr>
            </table>
        </div>
        <div class="row">
            <table style="width:85%">
                <tr id="ROW6" style="height:25px">
                    <td style="font-size:75%">Month recurring interval: <input type="text" class="form-control" size="10" id="month_recurring_interval" name = "month_recurring_interval" placeholder="Choose Month" required></td>
                </tr>
            </table>

        </div>
        <div class="row">
            <table style="width:85%">
                <tr id="ROW6" style="height:25px">
                    <td style="font-size:75%">Day of week recurring interval: <input type="text" class="form-control" size="10" id="day_of_week" name = "day_of_week" placeholder="Day of week" required></td>
                </tr>
            </table>

        </div>
        <div class="row">
            <table style="width:85%">
                <tr id="ROW6" style="height:25px">
                    <td style="font-size:75%">Year recurring interval: <input type="text" class="form-control" size="10" id="year_recurring_interval" name = "year_recurring_interval" placeholder="Choose Year"></td>
                </tr>
            </table>

        </div>
        <div class="row">
            <table style="width:85%">
                <tr id="ROW2" style="height:25px">
                    <td style="text-align:left"><strong><p style="color:black;font-size:16px">Hard Drive Content</p><strong></td>
                </tr>
            </table>
        </div>

        <div class="row">
            <table style="width:85%">
                <tr id="ROW6" style="height:25px">
                    <td style="font-size:75%">Creation Date: <input type="date" class="form-control" size="10" id="creation_date" name = "creation_date" placeholder="Creation Date" required></td>
                </tr>
            </table>
        </div>
        <div class="row">
            <table style="width:85%">
                <tr id="ROW6" style="height:25px">
                    <td style="font-size:75%">Issue Date: <input type="date" class="form-control" size="10" id="issue_date" name = "issue_date" placeholder="Issue Date" required></td>
                </tr>
            </table>
        </div>

        <div class="row">
            <table style="width:85%">
                <tr id="ROW6" style="height:25px">
                    <td style="font-size:75%">Modified Date: <input type="date" class="form-control" size="10" id="modified_date" name = "modified_date" placeholder="Modified Date" required></td>
                </tr>
            </table>
        </div>

        <div class="row">
            <table style="width:85%">
                <tr id="ROW6" style="height:25px">
                    <td style="font-size:75%">Expected Hard Drive Return: <input type="date" class="form-control" size="10" id="expected_return_date" name = "expected_return_date" placeholder="Expected Return" required></td>
                </tr>
            </table>
        </div>

        <div class="row">
            <table style="width:85%">
                <tr id="ROW6" style="height:25px">
                    <td style="font-size:75%">Boot Test Expiration Date: <input type="date" class="form-control" size="10" id="boot_expiration" name = "boot_expiration" placeholder="Boot Expiration Date" required></td>
                </tr>
            </table>
        </div>

        <div class="row">
            <table style="width:85%">
                <tr id="ROW6" style="height:25px">
                    <td style="font-size:75%">Image Version No: <input type="text" class="form-control" size="10" id="image_version" name = "image_version" placeholder="Image Version No." required></td>
                </tr>
            </table>
        </div>
        <div class="row">
            <table style="width:85%">
                <tr id="ROW7" style="height:25px">

                    <td style="font-size:75%" class="required-field"><label for="event status">Boot Test Status:</label>
                        <select name="boot_status" id="boot_names">
                            <option value="pending">Tested</option>
                            <option value="modify">Not Tested</option>
                            <option value="modify">Pending</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row">
            <table style="width:85%">
                <tr id="ROW7" style="height:25px">

                    <td style="font-size:75%" class="required-field"><label for="manufacturer status">Manufacturer:</label>
                        <select name="manufacturer" id="manufacturer">
                            <option value="pending">Manufacturer A</option>
                            <option value="modify">Manufacturer B</option>
                            <option value="modify">Manufacturer C</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>

        <div class="row">
            <table style="width:85%">
                <tr id="ROW7" style="height:25px">

                    <td style="font-size:75%" class="required-field"><label for="model_no">Model No.:</label>
                        <select name="model_no" id="model_no">
                            <option value="pending">Model A</option>
                            <option value="modify">Model B</option>
                            <option value="modify">Model C</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row">
            <table style="width:85%">
                <tr id="ROW7" style="height:25px">

                    <td style="font-size:75%" class="required-field"><label for="event status">Boot Test Status:</label>
                        <select name="event_status" id="status_names">
                            <option value="pending">Tested</option>
                            <option value="modify">Not Tested</option>
                            <option value="modify">Pending</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row">
            <table id="table.test" name="table.test" style="width:95%">
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
        </div>
        <hr style="border-top:1px solid black">

        <div class="row">
            <table style="width:85%">
                <tr id="ROW2" style="height:25px">
                    <td style="text-align:left"><strong><p style="color:black;font-size:16px">Request Reference Content</p><strong></td>
                </tr>
            </table>
        </div>
        <div class="row">
            <table style="width:85%">
                <tr id="ROW6" style="height:25px">
                    <td style="font-size:75%">Request Reference: <input type="text" class="form-control" size="10" id="creation_date" name = "creation_date" placeholder="Enter request reference" required></td>
                </tr>
            </table>
        </div>
        <div class="row">
            <table style="width:85%">
                <tr id="ROW6" style="height:25px">
                    <td style="font-size:75%">Creation Date: <input type="text" class="form-control" size="10" id="creation_date" name = "creation_date" placeholder="Creation Date" required></td>
                </tr>
            </table>
        </div>
        <div class="row">
            <table style="width:85%">
                <tr id="ROW7" style="height:25px">

                    <td style="font-size:75%" class="required-field"><label for="request status">Request Status:</label>
                        <select name="request_status" id="status_names">
                            <option value="pending">Created</option>
                            <option value="modify">Forecasted</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="Approved">Approved</option>
                            <option value="Declined">Declined</option>
                            <option value="Delivered">Delivered</option>
                            <option value="Fulfilled">Fulfilled</option>
                            <option value="partial_returned">Partial-Returned</option>
                            <option value="closed">Closed</option>
                            <option value="canceled">Canceled</option>
                            <option value="modify">Archived</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>


        <div style="padding-left:18%;padding-top: 25px;" id="main">
            <button type="Submit" name="Submit" class="btn btn-secondary"><a target="_blank" href='menu.php"'>Submit</button>
        </div>

    </div>

</form>


</body>
</html>
