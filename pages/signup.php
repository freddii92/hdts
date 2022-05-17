<?php
require_once("./../controllers/auth_controller.php");
$error = false;
if (array_key_exists(AuthController::$KEY_LOGGED_IN, $_SESSION) && $_SESSION[AuthController::$KEY_LOGGED_IN]) {
    header("Location: menu.php");
} else if (!empty($_POST) && isset($_POST['Submit'])) {
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : " ";
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : " ";
    $email = isset($_POST['email']) ? $_POST['email'] : " ";
    $username = isset($_POST['username']) ? $_POST['username'] : " ";
    $password = isset($_POST['password']) ? $_POST['password'] : " ";
    $super_email = isset($_POST['super_email']) ? $_POST['super_email'] : " ";
    $branch_email = isset($_POST['branch_email']) ? $_POST['branch_email'] : " ";
    $error = $auth->SignUp($firstname,$lastname,$username,$email, $password, $super_email,$branch_email);
}
?>
<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="../components/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://fonts.googleapis.com/icon?family=PT+Mono" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HDTS User Sign Up</title>
</head>



<style>
    .required-field:after {
        content:" *";
        color: red;
    }
</style>


<div class="container" id="main" style="margin-top: 40px">
    <h1>HDTS Sign Up</h1>
    <form action="signup.php"  style="padding: 40px" method="post">
        <div class="form-group">
            <p aria-hidden="true" id="required-description">
                <span class="required-field"></span>Required field
            </p>
            <div class = "required-field">First Name:</div>
            <input type="text" class="form-control" id="firstname" placeholder="Enter First Name" name="firstname">
        </div>
        <div class="form-group">
            <div class = "required-field">Last Name:</div>
            <input type="text" class="form-control" id="lastname" placeholder="Enter Last Name" name="lastname" required>
        </div>
        <div class="form-group">
            <div class = "required-field">Email:</div>
            <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email" required>
        </div>
        <div class="form-group">
            <div class = "required-field">Username:</div>
            <input type="text" class="form-control" id="uname" placeholder="Enter Username" name="username" required>
        </div>
        <div class="form-group">
            <div class = "required-field">Password:</div>
            <input type="password" class="form-control" id="pwd" placeholder="Enter Password"  name="password" required>
        </div>
        <div class="form-group">
            <label for="super_email">Supervisor Email:</label>
            <!--<input type="text" class="form-control" id="super_email" placeholder="Enter Email" name="super_email">-->
        </div>
        <div class="form-group">
            <!--<form action="switch_roles.php" method="post">-->
            <a class="form-group">
                <select name='super_email'>
                    <option selected disabled>---------------</option>
                    <option>Email1@army.mil</option>
                    <option>Email2@army.mil</option>
                    <option>Email3@army.mil</option>
                    <option>Email4@army.mil</option>
                </select>
            </a>
        </div>
        <div class="form-group">
            <label for="chief_email">Branch Chief Email:</label>
            <!--<input type="text" class="form-control" id="chief_email" placeholder="Enter Email" name="chief_email">-->

        </div>
        <div class="form-group">
            <!--<form action="switch_roles.php" method="post">-->
            <a class="form-group">
                <select name='chief_email'>
                    <option selected disabled>---------------</option>
                    <option>Email1@army.mil</option>
                    <option>Email2@army.mil</option>
                    <option>Email3@army.mil</option>
                    <option>Email4@army.mil</option>
                </select>
            </a>

        </div>
        <?php if ($error) { ?>
            <div color="red">
                Error: Duplicate Username
            </div>
        <?php } ?>
        <div class="form-group" style="margin-top: 20px">
            <input class="btn border border-secondary" name='Submit' type="submit" value="Submit">
            <a class="btn border border-secondary" role="button" href="login.php">Cancel</a>
        </div>
    </form>
</div>
</html>
