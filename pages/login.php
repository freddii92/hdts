<?php
include_once("./../controllers/auth_controller.php");

$error = false;

if (array_key_exists(AuthController::$KEY_LOGGED_IN, $_SESSION) && $_SESSION[AuthController::$KEY_LOGGED_IN]) {
    header("Location: menu.php");
} else if (!empty($_POST) && isset($_POST['Submit'])) {
    $username = isset($_POST['username']) ? $_POST['username'] : " ";
    $password = isset($_POST['password']) ? $_POST['password'] : " ";
    $role= isset($_POST['role']) ? $_POST['role'] : " ";

    $error = $auth->SignIn($username, $password, $role);
}
?>


<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="../components/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://fonts.googleapis.com/icon?family=PT+Mono" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HDTS User Login</title>
</head>


<div class="container" id="main" style="margin-top: 40px">
    <h1>HDTS Login</h1>
    <form action="login.php" style="padding: 40px" method="post">
        <div class="form-group">
            <label for="uname">Username:</label>
            <input type="text" class="form-control" id="uname" placeholder="Enter Username" name="username" required>
        </div>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pwd" placeholder="Enter Password"  name="password" required>
        </div>
        <div class="form-group">
            <label for="sel1">Select Role:</label>
            <select class="form-control" id="sel1" name="role">
                <option>Requester</option>
                <option>Maintainer</option>
                <option>Auditor</option>
                <option>Administrator</option>
            </select>
        </div>

        <?php if ($error) {
            echo $error;
        }?>


        <div class="form-group" style="margin-top: 20px">
            <input class="btn border border border-secondary" name='Submit' type="submit" value="Submit">
        </div>
        <a href="signup.php" style="margin: 20px 0px; color:black">Don't have an account? Create one now!</a>
    </form>
</div>

</html>
