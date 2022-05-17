<?php


function insertToLogs($u_username, $l_type, $l_action) {

    require_once("./../core/mysqli-config.php");

    $conn = $GLOBALS['conn'];

    date_default_timezone_set("America/Denver");

    $date_time = date("Y/m/d h:i:s");

    $queryEvent  = "INSERT INTO Log VALUES ('0', '$u_username', '$l_action', '$date_time');";

    if ($conn->query($queryEvent) === TRUE) {
        echo "<br> New record created successfully";
    } else {
        echo "<br> The record was not created, the query: <br>" . $queryEvent . "  <br> Generated the error <br>" . $conn->error;
    }
}

?>
?>