<?php
include_once('./../controllers/auth_controller.php');

$auth->clearSession();
header("Location: login.php");
