<?php
include_once("./../controllers/auth_controller.php");

$welcomeComponent = "";
if (array_key_exists(AuthController::$KEY_LOGGED_IN, $_SESSION) && $_SESSION[AuthController::$KEY_LOGGED_IN]) {
    $welcomeComponent = "";

} else {
    $welcomeComponent = "<div></div>";
}



echo "
  <nav class='navbar navbar-expand-sm bg-dark border-bottom border-warning'>
      <a class='navbar-brand' style='color: #ffc107;' href='/Classes/cs4311/CS4311Team6/pages/'>Hard Drive Tracker System</a>" .

    $welcomeComponent
    . "
    </div>
  </nav>
";
