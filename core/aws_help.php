<?php
$test = new mysqli($_SERVER['RDS_HOSTNAME'], $_SERVER['RDS_USERNAME'], $_SERVER['RDS_PASSWORD'], $_SERVER['RDS_DB_NAME'], $_SERVER['RDS_PORT']);

if ($test->connect_error) {
    echo "fail";
} else {
    echo "pass";

    $query = "SELECT * FROM USER_PROFILE;";
    $result = $test->query($query);
    var_dump($result);
}