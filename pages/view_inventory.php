<?php
include_once("./../controllers/auth_controller.php");
include_once("../components/navbar.php");
require_once('./../core/mysqli-config.php');
require_once('./../core/pdo-config.php');

try{
    $pdo = new PDO($attr, $user, $pass, $opts);
}
catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
if (!(array_key_exists(AuthController::$KEY_LOGGED_IN, $_SESSION) && $_SESSION[AuthController::$KEY_LOGGED_IN])) {
    header("Location: login.php");
}

else if (isset($_POST['Add'])) {

    $current_time = date("Y-m-d");

    $hd_serial_no = isset($_POST['hd_s_no']) ? $_POST['hd_s_no'] : "0"  ;
    $hd_boot_status = isset($_POST['hd_boot_s']) ? $_POST['hd_boot_s'] : "0"  ;
    $hd_boot_exp_date = isset($_POST['boot_exp']) ? $_POST['boot_exp'] : $current_time;
    $hd_status = isset($_POST['hd_status']) ? $_POST['hd_status'] : "Available" ;
    $hd_connetion_port_type = isset($_POST['port_type']) ? $_POST['port_type'] : "0" ;
    $hd_manufacturer = isset($_POST['hd_manu']) ? $_POST['hd_manu'] : "Unknown";
    $hd_image_id = isset($_POST['hd_image']) ? $_POST['hd_image'] : "0"  ;

    $hd_type = isset($_POST['hd_type']) ? $_POST['hd_type'] : "0"  ;
    $hd_size = isset($_POST['hd_size']) ? $_POST['hd_size'] : "0"  ;
    $hd_classification = isset($_POST['hd_classification']) ? $_POST['hd_classification'] : "0" ;
    $hd_model_number = isset($_POST['hd_m_no']) ? $_POST['hd_m_no'] : "0";

    addHardDrive($pdo,$hd_serial_no, $hd_image_id,$hd_boot_status,$hd_boot_exp_date,$hd_status,$hd_type,$hd_connetion_port_type, $hd_size,$hd_classification,$hd_model_number,$hd_manufacturer);

}

function userRole(){
    $role = $_SESSION['role'];
    $user = $_SESSION[AuthController::$KEY_USER];

    echo '<div style="float: right; background-color: black; color: white; padding: 2px 5px; display: block; margin-bottom: 1em;">' . htmlspecialchars($user). "</div><br>";
    echo '<div style="float: right; background-color: black; color: white; padding: 2px 5px; display: block; margin-bottom: 0em;">' . htmlspecialchars($role). "</div>";

}

function addHardDrive($pdo,$hd_serial_no, $hd_image_id,$hd_boot_status,$hd_boot_exp_date,$hd_status,$hd_type,$hd_connetion_port_type, $hd_size,$hd_classification,$hd_model_number,$hd_manufacturer){
    $current_date = date("Y-m-d");
    $null_date = "0000-00-00";

    $query = "INSERT INTO HARD_DRIVE VALUES ('0', 
            '". $hd_serial_no . "', 
            '". $hd_image_id . "', 
            '". $hd_boot_status . "', 
            '". $hd_boot_exp_date . "', 
            '". $hd_status . "', 
            '', 
            '1', 
            '". $null_date . "', 
            '". $null_date . "', 
            '". $null_date . "', 
            '". $null_date . "', 
            '". $current_date . "', 
            '', 
            '". $hd_type . "', 
            '". $hd_connetion_port_type . "', 
            '". $hd_size . "', 
            '". $hd_classification . "', 
            '', 
            '". $hd_manufacturer . "', 
            '". $hd_model_number . "');";

    $result = $pdo->query($query);

}


function printCHardDrives($pdo){

    //View only for Requester
    $sUSER = $_SESSION[AuthController::$KEY_USER];

    $query = "";
    if ($_SESSION['role'] == "Requester"){
        $query = "CREATE OR REPLACE VIEW CLASSIFIED_HARD_DRIVE_SEARCH AS SELECT * FROM HARD_DRIVE WHERE HD_CLASSIFICATION = 'Classified' AND U_USERNAME= '" . $_SESSION[AuthController::$KEY_USER] . "';";
        //$query->execute([$sUSER]);
        $result = $pdo->query($query);

        $query = "SELECT * FROM CLASSIFIED_HARD_DRIVE_SEARCH WHERE HD_CLASSIFICATION = 'Classified' AND U_USERNAME= '" . $_SESSION[AuthController::$KEY_USER] . "';";

        $result = $pdo->query($query);

        while($row = $result->fetch()) {

            echo '<tr'. ' onclick="showHideRow(' . "'" . "requestOpenClassified".
                "', '". htmlspecialchars($row['HD_ID']).
                "', '". htmlspecialchars($row['HD_SERIAL_NO']).
                "', '". htmlspecialchars($row['HD_IMAGE_ID']).
                "', '". htmlspecialchars($row['HD_BOOT_STATUS']).
                "', '". htmlspecialchars($row['HD_BOOT_EXP_DATE']).

                "', '". htmlspecialchars($row['HD_STATUS']).
                "', '". htmlspecialchars($row['U_USERNAME']).
                "', '". htmlspecialchars($row['H_HARD_DRIVE_REQUEST_NO']).
                "', '". htmlspecialchars($row['HD_ISSUED_DATE']).
                "', '". htmlspecialchars($row['HD_RETURN_DATE']).

                "', '". htmlspecialchars($row['HD_LAST_MODIFIED_DATE']).
                "', '". htmlspecialchars($row['HD_ADDED_DATE']).
                "', '". htmlspecialchars($row['HD_STATUS_JUSTIFICATION']).
                "', '". htmlspecialchars($row['HD_TYPE']).

                "', '". htmlspecialchars($row['HD_CONNECTION_PORT_TYPE']).
                "', '". htmlspecialchars($row['HD_SIZE']).
                "', '". htmlspecialchars($row['HD_CLASSIFICATION']).
                "', '". htmlspecialchars($row['HD_CLASSIFICATION_JUSTIFICATION']).
                "', '". htmlspecialchars($row['HD_MANUFACTURER']).
                "', '". htmlspecialchars($row['HD_MODEL_NUMBER']).

                "'". ');">';
            echo '<td> <input type="checkbox"> </td>';
            echo "<td>". htmlspecialchars($row['HD_SERIAL_NO']) ."</td>";
            echo "<td>". htmlspecialchars($row['HD_STATUS']) ."</td>";
            echo "<td>" . htmlspecialchars($row['HD_BOOT_STATUS']) . "</td>";
            echo "<td>" . htmlspecialchars($row['H_HARD_DRIVE_REQUEST_NO']) . "</td>";
            echo "<td>" . htmlspecialchars($row['HD_ISSUED_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['HD_RETURN_DATE']) . "</td>";
            echo "</tr>";

        }
    }
    //view for Maintainer
    elseif ($_SESSION['role'] == "Maintainer"){
        $query = 'SELECT * FROM HARD_DRIVE WHERE HD_CLASSIFICATION = "Classified";';

        $result = $pdo->query($query);

        while($row = $result->fetch()) {

            echo '<tr'. ' onclick="showHideRow(' . "'" . "requestOpenClassified".
                "', '". htmlspecialchars($row['HD_ID']).
                "', '". htmlspecialchars($row['HD_SERIAL_NO']).
                "', '". htmlspecialchars($row['HD_IMAGE_ID']).
                "', '". htmlspecialchars($row['HD_BOOT_STATUS']).
                "', '". htmlspecialchars($row['HD_BOOT_EXP_DATE']).

                "', '". htmlspecialchars($row['HD_STATUS']).
                "', '". htmlspecialchars($row['U_USERNAME']).
                "', '". htmlspecialchars($row['H_HARD_DRIVE_REQUEST_NO']).
                "', '". htmlspecialchars($row['HD_ISSUED_DATE']).
                "', '". htmlspecialchars($row['HD_RETURN_DATE']).

                "', '". htmlspecialchars($row['HD_LAST_MODIFIED_DATE']).
                "', '". htmlspecialchars($row['HD_ADDED_DATE']).
                "', '". htmlspecialchars($row['HD_STATUS_JUSTIFICATION']).
                "', '". htmlspecialchars($row['HD_TYPE']).

                "', '". htmlspecialchars($row['HD_CONNECTION_PORT_TYPE']).
                "', '". htmlspecialchars($row['HD_SIZE']).
                "', '". htmlspecialchars($row['HD_CLASSIFICATION']).
                "', '". htmlspecialchars($row['HD_CLASSIFICATION_JUSTIFICATION']).
                "', '". htmlspecialchars($row['HD_MANUFACTURER']).
                "', '". htmlspecialchars($row['HD_MODEL_NUMBER']).

                "'". ');">';
            echo '<td> <input type="checkbox"> </td>';
            echo "<td>". htmlspecialchars($row['HD_SERIAL_NO']) ."</td>";
            echo "<td>". htmlspecialchars($row['HD_STATUS']) ."</td>";
            echo "<td>" . htmlspecialchars($row['HD_BOOT_STATUS']) . "</td>";
            echo "<td>" . htmlspecialchars($row['H_HARD_DRIVE_REQUEST_NO']) . "</td>";
            echo "<td>" . htmlspecialchars($row['HD_ISSUED_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['HD_RETURN_DATE']) . "</td>";
            echo "</tr>";

        }
    }

}


function printUHardDrives($pdo){

    $sUSER = $_SESSION[AuthController::$KEY_USER];
    $query = "";
    if ($_SESSION['role'] == "Requester"){
        $query = "CREATE OR REPLACE VIEW UNCLASSIFIED_HARD_DRIVE_SEARCH AS SELECT * FROM HARD_DRIVE WHERE HD_CLASSIFICATION = 'Unclassified' AND U_USERNAME= '" . $_SESSION[AuthController::$KEY_USER] . "';";

        $result = $pdo->query($query);

        $query = "SELECT * FROM UNCLASSIFIED_HARD_DRIVE_SEARCH WHERE HD_CLASSIFICATION = 'Unclassified' AND U_USERNAME= '" . $_SESSION[AuthController::$KEY_USER] . "';";

        $result = $pdo->query($query);

        while($row = $result->fetch()) {

            echo '<tr'. ' onclick="showHideRow(' . "'" . "requestOpenClassified".
                "', '". htmlspecialchars($row['HD_ID']).
                "', '". htmlspecialchars($row['HD_SERIAL_NO']).
                "', '". htmlspecialchars($row['HD_IMAGE_ID']).
                "', '". htmlspecialchars($row['HD_BOOT_STATUS']).
                "', '". htmlspecialchars($row['HD_BOOT_EXP_DATE']).

                "', '". htmlspecialchars($row['HD_STATUS']).
                "', '". htmlspecialchars($row['U_USERNAME']).
                "', '". htmlspecialchars($row['H_HARD_DRIVE_REQUEST_NO']).
                "', '". htmlspecialchars($row['HD_ISSUED_DATE']).
                "', '". htmlspecialchars($row['HD_RETURN_DATE']).

                "', '". htmlspecialchars($row['HD_LAST_MODIFIED_DATE']).
                "', '". htmlspecialchars($row['HD_ADDED_DATE']).
                "', '". htmlspecialchars($row['HD_STATUS_JUSTIFICATION']).
                "', '". htmlspecialchars($row['HD_TYPE']).

                "', '". htmlspecialchars($row['HD_CONNECTION_PORT_TYPE']).
                "', '". htmlspecialchars($row['HD_SIZE']).
                "', '". htmlspecialchars($row['HD_CLASSIFICATION']).
                "', '". htmlspecialchars($row['HD_CLASSIFICATION_JUSTIFICATION']).
                "', '". htmlspecialchars($row['HD_MANUFACTURER']).
                "', '". htmlspecialchars($row['HD_MODEL_NUMBER']).

                "'". ');">';
            echo '<td> <input type="checkbox"> </td>';
            echo "<td>". htmlspecialchars($row['HD_SERIAL_NO']) ."</td>";
            echo "<td>". htmlspecialchars($row['HD_STATUS']) ."</td>";
            echo "<td>" . htmlspecialchars($row['HD_BOOT_STATUS']) . "</td>";
            echo "<td>" . htmlspecialchars($row['H_HARD_DRIVE_REQUEST_NO']) . "</td>";
            echo "<td>" . htmlspecialchars($row['HD_ISSUED_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['HD_RETURN_DATE']) . "</td>";
            echo "</tr>";

        }
    }
    elseif ($_SESSION['role'] == "Maintainer" || $_SESSION['role'] == "Auditor"){
        $query = 'SELECT * FROM HARD_DRIVE WHERE HD_CLASSIFICATION = "Unclassified";';

        $result = $pdo->query($query);

        while($row = $result->fetch()) {
            $id = $row['HD_ID'];
            echo '<tr'. ' onclick="showHideRow(' . "'" . "requestOpenClassified".
                "', '". htmlspecialchars($row['HD_ID']).
                "', '". htmlspecialchars($row['HD_SERIAL_NO']).
                "', '". htmlspecialchars($row['HD_IMAGE_ID']).
                "', '". htmlspecialchars($row['HD_BOOT_STATUS']).
                "', '". htmlspecialchars($row['HD_BOOT_EXP_DATE']).

                "', '". htmlspecialchars($row['HD_STATUS']).
                "', '". htmlspecialchars($row['U_USERNAME']).
                "', '". htmlspecialchars($row['H_HARD_DRIVE_REQUEST_NO']).
                "', '". htmlspecialchars($row['HD_ISSUED_DATE']).
                "', '". htmlspecialchars($row['HD_RETURN_DATE']).

                "', '". htmlspecialchars($row['HD_LAST_MODIFIED_DATE']).
                "', '". htmlspecialchars($row['HD_ADDED_DATE']).
                "', '". htmlspecialchars($row['HD_STATUS_JUSTIFICATION']).
                "', '". htmlspecialchars($row['HD_TYPE']).

                "', '". htmlspecialchars($row['HD_CONNECTION_PORT_TYPE']).
                "', '". htmlspecialchars($row['HD_SIZE']).
                "', '". htmlspecialchars($row['HD_CLASSIFICATION']).
                "', '". htmlspecialchars($row['HD_CLASSIFICATION_JUSTIFICATION']).
                "', '". htmlspecialchars($row['HD_MANUFACTURER']).
                "', '". htmlspecialchars($row['HD_MODEL_NUMBER']).
                "'". ');">';

            echo '<td> <input type="checkbox"> </td>';
            $id = sprintf('%04d',$id);
            echo "<td>". htmlspecialchars($row['HD_SERIAL_NO']) ."</td>";
            echo "<td>". htmlspecialchars($row['HD_STATUS']) ."</td>";
            echo "<td>" . htmlspecialchars($row['HD_BOOT_STATUS']) . "</td>";
            echo "<td>" . htmlspecialchars($row['H_HARD_DRIVE_REQUEST_NO']) . "</td>";
            echo "<td>" . htmlspecialchars($row['HD_ISSUED_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['HD_RETURN_DATE']) . "</td>";
            echo "</tr>";

        }
    }
}

function search($pdo, $search_value, $search_option, $class){

    $query = "";

    if ($_SESSION['role'] == "Requester") {
        if ($search_option == "keyword_search") {
            $query = "CREATE OR REPLACE VIEW ". $class . "_HARD_DRIVE_SEARCH AS SELECT * FROM HARD_DRIVE WHERE HD_ID LIKE '%" . $search_value . "%' 
                OR HD_SERIAL_NO LIKE '%" . $search_value . "%' 
                OR HD_STATUS LIKE '%" . $search_value . "%' 
                OR HD_BOOT_STATUS LIKE '%" . $search_value . "%' 
                OR H_HARD_DRIVE_REQUEST_NO LIKE '%" . $search_value . "%' 
                OR HD_ISSUED_DATE LIKE '%" . $search_value . "%' 
                OR HD_RETURNED_DATE LIKE '%" . $search_value . "%' 
                AND HD_CLASSIFICATION = '". $class . "' AND U_USERNAME= '" . $_SESSION[AuthController::$KEY_USER] . "';";
        } else {
            $query = "CREATE OR REPLACE VIEW ". $class . "_HARD_DRIVE_SEARCH AS SELECT * FROM HARD_DRIVE WHERE " . $search_option . "='" . $search_value . "' AND HD_CLASSIFICATION = '". $class . "' AND U_USERNAME= '" . $_SESSION[AuthController::$KEY_USER] . "';";
        }
    }
    else if ($_SESSION['role'] == "Maintainer" || $_SESSION['role'] == "Auditor") {
        if ($search_option == "keyword_search") {
            $query = "CREATE OR REPLACE VIEW ". $class . "_HARD_DRIVE_SEARCH AS SELECT * FROM HARD_DRIVE WHERE HD_ID LIKE '%" . $search_value . "%' 
                OR HD_SERIAL_NO LIKE '%" . $search_value . "%' 
                OR HD_STATUS LIKE '%" . $search_value . "%' 
                OR HD_BOOT_STATUS LIKE '%" . $search_value . "%' 
                OR H_HARD_DRIVE_REQUEST_NO LIKE '%" . $search_value . "%' 
                OR HD_ISSUED_DATE LIKE '%" . $search_value . "%' 
                OR HD_RETURNED_DATE LIKE '%" . $search_value . "%' 
                AND HD_CLASSIFICATION = '". $class . "';";
        } else {
            $query = "CREATE OR REPLACE VIEW ". $class . "_HARD_DRIVE_SEARCH AS SELECT * FROM HARD_DRIVE WHERE " . $search_option . "='" . $search_value . "' AND HD_CLASSIFICATION = '". $class . "';";
        }
    }

    $result = $pdo->query($query);

    if ($_SESSION['role'] == "Requester") {
        $query = "SELECT * FROM ". $class . "_HARD_DRIVE_SEARCH WHERE HD_CLASSIFICATION = '". $class . "' AND U_USERNAME= '" . $_SESSION[AuthController::$KEY_USER] . "';";

        $result = $pdo->query($query);

        while($row = $result->fetch()) {
            $id = $row['HD_ID'];
            echo '<tr'. ' onclick="showHideRow(' . "'" . "requestOpenClassified".
                "', '". htmlspecialchars($row['HD_ID']).
                "', '". htmlspecialchars($row['HD_SERIAL_NO']).
                "', '". htmlspecialchars($row['HD_IMAGE_ID']).
                "', '". htmlspecialchars($row['HD_BOOT_STATUS']).
                "', '". htmlspecialchars($row['HD_BOOT_EXP_DATE']).

                "', '". htmlspecialchars($row['HD_STATUS']).
                "', '". htmlspecialchars($row['U_USERNAME']).
                "', '". htmlspecialchars($row['H_HARD_DRIVE_REQUEST_NO']).
                "', '". htmlspecialchars($row['HD_ISSUED_DATE']).
                "', '". htmlspecialchars($row['HD_RETURN_DATE']).

                "', '". htmlspecialchars($row['HD_LAST_MODIFIED_DATE']).
                "', '". htmlspecialchars($row['HD_ADDED_DATE']).
                "', '". htmlspecialchars($row['HD_STATUS_JUSTIFICATION']).
                "', '". htmlspecialchars($row['HD_TYPE']).

                "', '". htmlspecialchars($row['HD_CONNECTION_PORT_TYPE']).
                "', '". htmlspecialchars($row['HD_SIZE']).
                "', '". htmlspecialchars($row['HD_CLASSIFICATION']).
                "', '". htmlspecialchars($row['HD_CLASSIFICATION_JUSTIFICATION']).
                "', '". htmlspecialchars($row['HD_MANUFACTURER']).
                "', '". htmlspecialchars($row['HD_MODEL_NUMBER']).

                "'". ');">';
            echo '<td> <input type="checkbox"> </td>';
            echo "<td>". htmlspecialchars($row['HD_SERIAL_NO']) ."</td>";
            echo "<td>". htmlspecialchars($row['HD_STATUS']) ."</td>";
            echo "<td>" . htmlspecialchars($row['HD_BOOT_STATUS']) . "</td>";
            echo "<td>" . htmlspecialchars($row['H_HARD_DRIVE_REQUEST_NO']) . "</td>";
            echo "<td>" . htmlspecialchars($row['HD_ISSUED_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['HD_RETURN_DATE']) . "</td>";
            echo "</tr>";

        }
    }
    else if ($_SESSION['role'] == "Maintainer" || $_SESSION['role'] == "Auditor") {
        $query = "SELECT * FROM ". $class . "_HARD_DRIVE_SEARCH WHERE HD_CLASSIFICATION = '". $class . "';";

        $result = $pdo->query($query);

        while($row = $result->fetch()) {
            $id = $row['HD_ID'];
            echo '<tr'. ' onclick="showHideRow(' . "'" . "requestOpenClassified".
                "', '". htmlspecialchars($row['HD_ID']).
                "', '". htmlspecialchars($row['HD_SERIAL_NO']).
                "', '". htmlspecialchars($row['HD_IMAGE_ID']).
                "', '". htmlspecialchars($row['HD_BOOT_STATUS']).
                "', '". htmlspecialchars($row['HD_BOOT_EXP_DATE']).

                "', '". htmlspecialchars($row['HD_STATUS']).
                "', '". htmlspecialchars($row['U_USERNAME']).
                "', '". htmlspecialchars($row['H_HARD_DRIVE_REQUEST_NO']).
                "', '". htmlspecialchars($row['HD_ISSUED_DATE']).
                "', '". htmlspecialchars($row['HD_RETURN_DATE']).

                "', '". htmlspecialchars($row['HD_LAST_MODIFIED_DATE']).
                "', '". htmlspecialchars($row['HD_ADDED_DATE']).
                "', '". htmlspecialchars($row['HD_STATUS_JUSTIFICATION']).
                "', '". htmlspecialchars($row['HD_TYPE']).

                "', '". htmlspecialchars($row['HD_CONNECTION_PORT_TYPE']).
                "', '". htmlspecialchars($row['HD_SIZE']).
                "', '". htmlspecialchars($row['HD_CLASSIFICATION']).
                "', '". htmlspecialchars($row['HD_CLASSIFICATION_JUSTIFICATION']).
                "', '". htmlspecialchars($row['HD_MANUFACTURER']).
                "', '". htmlspecialchars($row['HD_MODEL_NUMBER']).

                "'". ');">';
            echo '<td> <input type="checkbox"> </td>';
            echo "<td>". htmlspecialchars($row['HD_SERIAL_NO']) ."</td>";
            echo "<td>". htmlspecialchars($row['HD_STATUS']) ."</td>";
            echo "<td>" . htmlspecialchars($row['HD_BOOT_STATUS']) . "</td>";
            echo "<td>" . htmlspecialchars($row['H_HARD_DRIVE_REQUEST_NO']) . "</td>";
            echo "<td>" . htmlspecialchars($row['HD_ISSUED_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['HD_RETURN_DATE']) . "</td>";
            echo "</tr>";

        }
    }
}

function resetView($pdo, $class){

    $query = "";

    if ($_SESSION['role'] == "Requester") {
        $query = "CREATE OR REPLACE VIEW ". $class . "_HARD_DRIVE_SEARCH AS SELECT * FROM HARD_DRIVE WHERE HD_CLASSIFICATION = '". $class . "' AND U_USERNAME= '" . $_SESSION[AuthController::$KEY_USER] . "';";
    }
    else if ($_SESSION['role'] == "Auditor" || $_SESSION['role'] == "Maintainer" || $_SESSION['role'] == "Administrator") {
        $query = "CREATE OR REPLACE VIEW ". $class . "_HARD_DRIVE_SEARCH AS SELECT * FROM HARD_DRIVE WHERE HD_CLASSIFICATION = '". $class . "';";
    }

    $result = $pdo->query($query);

    if ($_SESSION['role'] == "Requester") {
        $query = "SELECT * FROM ". $class . "_HARD_DRIVE_SEARCH WHERE HD_CLASSIFICATION = '". $class . "' AND U_USERNAME= '" . $_SESSION[AuthController::$KEY_USER] . "';";

        $result = $pdo->query($query);

        while($row = $result->fetch()) {
            echo '<tr>';
            echo '<td> <input type="checkbox"> </td>';
            echo "<td>" . htmlspecialchars($row['HD_ID']) ."</td>";
            echo "<td>" . htmlspecialchars($row['HD_BOOT_STATUS']) . "</td>";
            echo "<td>" . htmlspecialchars($row['H_HARD_DRIVE_REQUEST_NO']) . "</td>";
            echo "<td>" . htmlspecialchars($row['HD_ISSUED_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['HD_RETURN_DATE']) . "</td>";
            echo "</tr>";

        }
    }
    else if ($_SESSION['role'] == "Auditor" || $_SESSION['role'] == "Maintainer" || $_SESSION['role'] == "Administrator") {
        $query = "SELECT * FROM ". $class . "_HARD_DRIVE_SEARCH WHERE HD_CLASSIFICATION = '". $class . "';";

        $result = $pdo->query($query);

        while($row = $result->fetch()) {
            $id = $row['HD_ID'];
            echo '<tr'. ' onclick="showHideRow(' . "'" . "requestOpenClassified".
                "', '". htmlspecialchars($row['HD_ID']).
                "', '". htmlspecialchars($row['HD_SERIAL_NO']).
                "', '". htmlspecialchars($row['HD_IMAGE_ID']).
                "', '". htmlspecialchars($row['HD_BOOT_STATUS']).
                "', '". htmlspecialchars($row['HD_BOOT_EXP_DATE']).

                "', '". htmlspecialchars($row['HD_STATUS']).
                "', '". htmlspecialchars($row['U_USERNAME']).
                "', '". htmlspecialchars($row['H_HARD_DRIVE_REQUEST_NO']).
                "', '". htmlspecialchars($row['HD_ISSUED_DATE']).
                "', '". htmlspecialchars($row['HD_RETURN_DATE']).

                "', '". htmlspecialchars($row['HD_LAST_MODIFIED_DATE']).
                "', '". htmlspecialchars($row['HD_ADDED_DATE']).
                "', '". htmlspecialchars($row['HD_STATUS_JUSTIFICATION']).
                "', '". htmlspecialchars($row['HD_TYPE']).

                "', '". htmlspecialchars($row['HD_CONNECTION_PORT_TYPE']).
                "', '". htmlspecialchars($row['HD_SIZE']).
                "', '". htmlspecialchars($row['HD_CLASSIFICATION']).
                "', '". htmlspecialchars($row['HD_CLASSIFICATION_JUSTIFICATION']).
                "', '". htmlspecialchars($row['HD_MANUFACTURER']).
                "', '". htmlspecialchars($row['HD_MODEL_NUMBER']).

                "'". ');">';
            echo '<td> <input type="checkbox"> </td>';
            echo "<td>". htmlspecialchars($row['HD_SERIAL_NO']) ."</td>";
            echo "<td>". htmlspecialchars($row['HD_STATUS']) ."</td>";
            echo "<td>" . htmlspecialchars($row['HD_BOOT_STATUS']) . "</td>";
            echo "<td>" . htmlspecialchars($row['H_HARD_DRIVE_REQUEST_NO']) . "</td>";
            echo "<td>" . htmlspecialchars($row['HD_ISSUED_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['HD_RETURN_DATE']) . "</td>";
            echo "</tr>";

        }
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../components/styleHardDrives.css">
    <link rel="stylesheet" href="../components/styles.css">
    <!-- <link rel="stylesheet" href="styleRequests.css"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=PT+Mono" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory</title>
    <style>
    .search {
        width: 73%;
        border-collapse: collapse;
        display:inline-block;
    }
    </style>
    <script type="text/javascript">

        function showHideRow( rOC, hdID, hdSerialNum, hdImageID, hdBootStatus, hdBootExpDate, hdStatus, uUsername, hHDRequestNo, hdIssuedDate, hdReturnedDate,
                              hdLastModDate, hdAddedDate, hdStatusJusti, hdType, hdConnPortType, hdSize, hdClass, hdClassJusti, hdManu, hdModelNum ) {

            const div = document.getElementById('requestOpenClassified');
            $("#" + rOC).css('display', "inline");
            $("#" + rOC).css('width', "50%");
            $("#" + rOC).css('position', "sticky");


            div.innerHTML = '<table style="width:100%;"><tr id="ROWcontInfo" style="height:10px"><td style="text-align: center;" colspan="2"><strong><p style="color:black;font-size:25px">Hard Drive</Re></p></td></tr><trstyle="height:25px"><td colspan="2">Hard Drive ID:         '+ hdID

                + '</td> </tr> <tr style="width:75%"> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Hard Drive Number: </strong> <p>' + hdSerialNum

                + '</td> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Hard Drive Image ID: </strong> <p>' + hdImageID

                + '</td> </tr> <tr style="width:75%"> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Hard Drive Boot Status: </strong> <p>' + hdBootStatus

                + '</td> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Hard Drive Boot Expected Date: </strong> <p>' + hdBootExpDate

                + '</td> </tr> <tr style="width:75%"> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Hard Drive Status: </strong> <p>' + hdStatus

                + '</td> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Username: </strong> <p>' + uUsername

                + '</td> </tr> <tr style="width:75%"> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Hard Drive Request Number: </strong> <p>' + hHDRequestNo

                + '</td> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Hard Drive Issued Date: </strong> <p>' + hdIssuedDate

                + '</td> </tr> <tr style="width:75%"> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Returned Date: </strong> <p>' + hdReturnedDate

                + '</td> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Date of Last Modification: </strong> <p>' + hdLastModDate

                + '</td> </tr> <tr style="width:75%"> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Date of Hard Drive Added </strong> <p>' + hdAddedDate

                + '</td> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Status Justification: </strong> <p>' + hdStatusJusti

                + '</td> </tr> <tr style="width:75%"> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Hard Drive Type: </strong> <p>' + hdType

                + '</td> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Connection Type: </strong> <p>' + hdConnPortType

                + '</td> </tr> <tr style="width:75%"> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Memory Size: </strong> <p>' + hdSize

                + '</td> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Classification: </strong> <p>' + hdClass

                + '</td> </tr> <tr style="width:75%"> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Justification for Classification: </strong> <p>' + hdClassJusti

                + '</td> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Manufacturer: </strong> <p>' + hdManu

                + '</td> </tr> <tr style="width:75%"> <td colspan="2"> <strong> <p style="color:black;font-size:16px">Model Number: </strong> <p>' + hdModelNum

                + '</td> </tr> </table>';


            div.insertAdjacentHTML('beforeEnd','<br><button type="button" onclick="closeDiv();" style="float: right;">Close</button>');
            var editButton = "<button id='updateButton'><a href='updateHardDrive.php?hd=" + hdID +"'>Update</a></button>";
            div.insertAdjacentHTML('beforeEnd', editButton);
            $("#listRequests").css('width', "50%");
        }

        function closeDiv(){
            $("#requestOpenClassified").css('width', "0%");
            $("#listRequests").css('width', "100%");
            $("#requestOpenClassified").css('display', "none");
        }

        function openForm(){
            $('.addHDForm').css('display', "inline");
        }

        function closeForm(){
            $('.addHDForm').css('display', "none");
        }

    </script>
</head>
<body id="main">
<span style="font-size:32px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
<?php userRole(); ?>
<div class="title">
    <h1>INVENTORY</h1>
</div>

<?php
if ($_SESSION['role'] == "Maintainer"){
    print "
            <div class=buttons>
                <button class='buttonAddHD' onclick='openForm();'>Add Hard Drive</button>
            </div>
            ";
}
?>
<div class="addHDForm">
    <form method="post" action="view_inventory.php" class="formDisplay">
        <table>
            <tr>
                <td>HD Serial No.: <input type="text" name="hd_s_no" required></td>
                <td>HD Boot Status: <select name="hd_boot_s" id="status_names" required>
                        <option value="Pass">Pass</option>
                        <option value="Fail">Fail</option>
                    </select> </td>
                <td>HD Status: <select name="hd_status" id="status_names" required>
                        <option value="Available">Available</option>
                        <option value="End of Life">End of Life</option>
                        <option value="Master Clone">Master Clone</option>
                    </select></td>
                <td>HD Port Type:
                    <select name="port_type" id="port_type" required>
                        <option value="SATA">SATA</option>
                        <option value="HDMI">HDMI</option>
                        <option value="USB">USB</option>
                    </select>
                </td>
                <td>HD Manufacturer:
                    <select name="hd_manu" id="hd_manu">
                        <option value="Samsung">Samsung</option>
                        <option value="Seagate">Seagate</option>
                        <option value="Toshiba">Toshiba</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>HD Image ID: <input type="text" name="hd_image" placeholder="1234" required></td>
                <td>HD Boot Exp Date: <input type="date" size="17" name="boot_exp" placeholder="YYYY-MM-DD">
                <td>HD Type:
                    <select name="hd_type" id="status_names" required>
                        <option value="HDD">HDD</option>
                        <option value="SDD">SDD</option>
                    </select></td>
                <td>HD Size:
                    <select name="hd_size" id="hd_size" required>
                        <option value="128 GB">128 GB</option>
                        <option value="256 GB">256 GB</option>
                        <option value="500 GB">500 GB</option>
                        <option value="1 TB">1 TB</option>
                    </select>
                </td>
                <td>HD Classification:
                    <select name="hd_classification" id="status_names" required>
                        <option value="Unclassified">Unclassified</option>
                        <option value="Classified">Classified</option>
                    </select>
                </td>
                <td>HD Model No.: <input type="text" name="hd_m_no"></td>
            </tr>
        </table>
        <input class="buttonsForm" type="submit" value="Add" name="Add" style="margin: 5px;">
        <button class="buttonsForm" onclick="closeForm();" style="float: right;">Cancel</button>
    </form>
</div>


<div id="requestOpenClassified"></div>

<div id="listRequests">

    <div class="tablesInventory">
        <h2>UNCLASSIFIED HARD DRIVES</h2>
        <form method="post" id="unclassified_search">
            <input type="text" style="border: 3px solid #555" id="unclassified_search" name="unclassified_search" class="search" placeholder="Search">
            <div style="display: inline;">
                <select class="search_option" name="unclassified_search_option" id="unclassified_search_option">
                        <option value="keyword_search">Keyword</option>
                        <option value="hd_serial_no">Serial No.</option>
                        <option value="hd_status">HD Status</option>
                        <option value="hd_boot_status">Boot Status</option>
                        <option value="h_hard_drive_request_no">HD Request No.</option>
                </select>
                <button class="form-group">
                    <input class="btn btn-primary; fa fa-search" name='unclassified_Submit' type="submit" value="Search" style="font-size: 15px;">
                </button>
                <button class="btn btn-success" style="background-color:red; border-color:red"name="unclassified_reset">Reset</button>
            </div>
        </form>
        <table style="width: 100%; padding: 10px;">
            <thead>
            <tr>
                <th>Select</th>
                <th>SERIAL NO.</th>
		        <th>HD STATUS</th>
                <th>BOOT STATUS</th>
                <th>HD REQUEST NO.</th>
                <th>ISSUED DATE</th>
                <th>RETURN DATE</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($_POST)) {
                if (isset($_POST['unclassified_search']) && $_POST['unclassified_search'] != "") {

                    $search_value = isset($_POST['unclassified_search']) ? $_POST['unclassified_search'] : NULL;
                    $search_option = isset($_POST['unclassified_search_option']) ? $_POST['unclassified_search_option'] : NULL;

                    search($pdo, $search_value, $search_option, "UNCLASSIFIED");
                }
                else if (isset($_POST['unclassified_reset'])) {
                    resetView($pdo, "UNCLASSIFIED");
                } else {
                    printUHardDrives($pdo);
                }
            } else {
                printUHardDrives($pdo);
            }
            ?>
            </tbody>

            <table>
                <h2 style="padding-top:30px">CLASSIFIED HARD DRIVES</h2>
                <form method="post" id="search">
                    <input type="text" id="search" style="border: 3px solid #555" name="search" class="search" placeholder="Search">
                    <div style="display: inline;">
                        <select class="search_option" name="search_option" id="search_option">
                            <option value="keyword_search">Keyword</option>
                            <option value="hd_serial_no">Serial No.</option>
                            <option value="hd_status">HD Status</option>
                            <option value="hd_boot_status">Boot Status</option>
                            <option value="h_hard_drive_request_no">HD Request No.</option>
                        </select>
                        <button class="form-group">
                            <input class="btn btn-primary; fa fa-search" name='Submit' type="submit" value="Search" style="font-size: 15px;">
                        </button>
                        <button class="btn btn-success" style="background-color:red; border-color:red"name="reset">Reset</button>
                    </div>
                </form>
                <table style="width:100%;">
                    <thead>
                    <tr>
                        <th>Select</th>
                        <th>SERIAL NO.</th>
			            <th>HD STATUS</th>
                        <th>BOOT STATUS</th>
                        <th>HD REQUEST NO.</th>
                        <th>ISSUED DATE</th>
                        <th>RETURN DATE</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (!empty($_POST)) {
                        if (isset($_POST['search']) && $_POST['search'] != "") {

                            $search_value = isset($_POST['search']) ? $_POST['search'] : NULL;
                            $search_option = isset($_POST['search_option']) ? $_POST['search_option'] : NULL;

                            search($pdo, $search_value, $search_option, "CLASSIFIED");
                        }
                        else if (isset($_POST['reset'])) {
                            resetView($pdo, "CLASSIFIED");
                        } else {
                            printCHardDrives($pdo);
                        }
                    } else {
                        printCHardDrives($pdo);
                    }
                    ?>
                    </tbody>
                    <table>
    </div>
</div>

</body>
