<?php
include_once("./../controllers/auth_controller.php");

$error = false;


if (!(array_key_exists(AuthController::$KEY_LOGGED_IN, $_SESSION) && $_SESSION[AuthController::$KEY_LOGGED_IN])) {
    header("Location: login.php");
}
else if (!empty($_POST) && isset($_POST['role'])) {
    $role = isset($_POST['role']) ? $_POST['role'] : " ";
    $_SESSION['role'] = $role;
}
header("Location: menu.php");
?>
