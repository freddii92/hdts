<?php
include_once("./../controllers/auth_controller.php");

$error = false;


if (!(array_key_exists(AuthController::$KEY_LOGGED_IN, $_SESSION) && $_SESSION[AuthController::$KEY_LOGGED_IN])) {
    header("Location: login.php");
}
else if (!empty($_POST) && isset($_POST['Submit'])) {
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : " ";
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : " ";
    $email = isset($_POST['email']) ? $_POST['email'] : " ";
    $username = isset($_POST['username']) ? $_POST['username'] : " ";
    $password = isset($_POST['password']) ? $_POST['password'] : " ";
    $super_email = isset($_POST['super_email']) ? $_POST['super_email'] : " ";
    $branch_email = isset($_POST['branch_email']) ? $_POST['branch_email'] : " ";
    $requester = isset($_POST['requester']) ? $_POST['requester'] : "0";
    $maintainer = isset($_POST['maintainer']) ? $_POST['maintainer'] : "0";
    $auditor = isset($_POST['auditor']) ? $_POST['auditor'] : "0";
    $administrator = isset($_POST['administrator']) ? $_POST['administrator'] : "0";
    //$status = isset($_POST['status']) ? $_POST['status'] : " ";
    $requester = intval($requester);
    $maintainer = intval($maintainer);
    $auditor = intval($auditor);
    $administrator = intval($administrator);
    $error = $auth->createProfile($firstname,$lastname,$username,$email,$password,$requester,$maintainer,$auditor,$administrator,$super_email,$branch_email);
}
?>

<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="../components/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://fonts.googleapis.com/icon?family=PT+Mono" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create User</title>

    <style>
        .requestList {

            border-collapse: collapse;
            width: 50%;
        }
        th{
            background-color: #818181;
            color: white;
        }
        th, td {
            padding: 8px;
            text-align: left;
            /* border-bottom: 1px solid #ddd; */
        }
        tr:hover {
            background-color: #062e94;
            color: white;
        }
        * {
            box-sizing: border-box;
        }

        .row {
            margin-left:-5px;
            margin-right:-5px;
        }

        .column {
            float: left;
            width: 50%;
            padding: 5px;
        }
        table          {border:ridge 3px grey; border-collapse: collapse;  }
        table td       {border:inset 1px black;}
        table tr#ROW0  {background-color:white; color:black; width:50%;}
        table tr#ROWcontInfo  {background-color:lightgray; color:black; width:100%;}


        /* Clearfix (clear floats) */
        .row::after {
            content: "";
            clear: both;
            display: table;
        }
        img {
            width: 100%;
            height: auto;
        }
    </style>
</head>



<?php include_once("../components/navbar.php") ?>


<body id="main">
<span style="font-size:32px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>




<style>
    .required-field:after {
        content:" *";
        color: red;
    }
</style>


<div class="container" id="main" style="margin-top: 40px">
    <h1>Create User</h1>
    <form action="create_user.php"  style="padding: 40px" method="post">
        <p aria-hidden="true" id="required-description">
            <span class="required-field"></span>Required field
        </p>
        <div class="form-group">
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
            <div class = "required-field">Confirm Password:</div>
            <input type="password" class="form-control" id="pwd" placeholder="Confirm Password"  name="passwordConf" required>
        </div>
        <div class="form-group">
            <label>Supervisor Email:</label>
            <!--<input type="text" class="form-control" id="super_email" placeholder="Enter Email" name="super_email">-->
        </div>
        <div class="form-group">
            <!--<form action="switch_roles.php" method="post">-->
                <a class="form-group">
                    <select name='super_email'>
                        <option selected disabled>---------------</option>
                        <option value="email1@army.mil">Email1@army.mil</option>
                        <option value="email2@army.mil">Email2@army.mil</option>
                        <option value="email3@army.mil">Email3@army.mil</option>
                        <option value="email4@army.mil">Email4@army.mil</option>
                    </select>
                </a>
        </div>
        <div class="form-group">
            <label>Branch Chief Email:</label>
            <!--<input type="text" class="form-control" id="chief_email" placeholder="Enter Email" name="chief_email">-->

        </div>
        <div class="form-group">
            <!--<form action="switch_roles.php" method="post">-->
                <a class="form-group">
                    <select name='branch_email'>
                        <option selected disabled>---------------</option>
                        <option value="email1@army.mil">Email1@army.mil</option>
                        <option value="email2@army.mil">Email2@army.mil</option>
                        <option value="email3@army.mil">Email3@army.mil</option>
                        <option value="email4@army.mil">Email4@army.mil</option>
                    </select>
                </a>

        </div>
                <?php if ($error) { ?>
                    <div color="red">
                        Error: Duplicate Username
                    </div>
                <?php } ?>
        <div class="form-group">
            <div class = "required-field">Select Role:</div>
            <input type="checkbox" id="requester" name="requester" value="1">
            <label for="requester"> Requester</label><br>
            <input type="checkbox" id="maintainer" name="maintainer" value="1">
            <label for="maintainer"> Maintainer</label><br>
            <input type="checkbox" id="auditor" name="auditor" value="1">
            <label for="auditor"> Auditor</label><br>
            <input type="checkbox" id="administrator" name="administrator" value="1">
            <label for="administrator"> Administrator</label><br>
        </div>
        <div class="form-group" style="margin-top: 20px">
            <input class="btn border border-secondary" name='Submit' type="submit" value="Submit">
            <a class="btn border border-secondary" role="button" href="menu.php">Cancel</a>
        </div>



    </form>
</div>
</body>

