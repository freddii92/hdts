<?php
include_once("./../controllers/auth_controller.php");
$error = false;
if (!(array_key_exists(AuthController::$KEY_LOGGED_IN, $_SESSION) && $_SESSION[AuthController::$KEY_LOGGED_IN])) {
    header("Location: login.php");
}

/* else if (isset($_POST['update'])) {
    $userInfo = getInfo($_GET['user'];)

    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : $userInfo[1];
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : $userInfo[2];
    $email = isset($_POST['email']) ? $_POST['email'] : $userInfo[3];
    $username = isset($_POST['username']) ? $_POST['username'] : $userInfo[0];
    $password = isset($_POST['password']) ? $_POST['password'] : " ";
    $super_email = isset($_POST['super_email']) ? $_POST['super_email'] : " ";
    $branch_email = isset($_POST['branch_email']) ? $_POST['branch_email'] : " ";
    $status = isset($_POST['status']) ? $_POST['status'] : " ";
    $error = $auth->updateProfile($firstname, $lastname, $username, $email, $password, $super_email, $branch_email, $status);
} */

?>

<!DOCTYPE html>
<!-- style -->
<head xmlns="http://www.w3.org/1999/html">
    <link rel="stylesheet" href="../components/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://fonts.googleapis.com/icon?family=PT+Mono" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Profile</title>

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
<?php
require_once('./../core/mysqli-config.php');

// try{
//     $pdo = new PDO($attr, $user, $pass, $opts);
// }
// catch (PDOException $e) {
//     throw new PDOException($e->getMessage(), (int)$e->getCode());
// }
$username= $_GET['user'];

function printUsers(){

    $conn = $GLOBALS['conn'];
    $user = $_SESSION[AuthController::$KEY_USER];
    //$stmt = $this->conn->prepare("SELECT * FROM USER_PROFILE WHERE U_USERNAME = ? AND U_PASSWORD = ?");
    $query = 'SELECT * FROM user_profile WHERE U_USERNAME = '."'$user'";
    /*if ($_SESSION['role'] == "Requester")
    {

        $query = 'SELECT * FROM user_profile WHERE U_USERNAME = bavalos6';
        //SELECT * FROM [table name] WHERE [field name] = "whatever";
    }*/
    $userInfo = array();
    $result = $conn->query($query);

    while($row = $result->fetch_row()) {
        echo "<tr>";
        //printf("%s (%s)\n", $row[0], $row[1]);
        foreach ($row as $value){
            array_push($userInfo,$value);
            echo "<td>".$value."</td>";
        }

        echo "</tr>";
    }
}

function getInfo($user){

    $conn = $GLOBALS['conn'];

    //$stmt = $this->conn->prepare("SELECT * FROM USER_PROFILE WHERE U_USERNAME = ? AND U_PASSWORD = ?");
    $query = 'SELECT * FROM user_profile WHERE U_USERNAME = '."'$user'";
    /*if ($_SESSION['role'] == "Requester")
    {

        $query = 'SELECT * FROM user_profile WHERE U_USERNAME = bavalos6';
        //SELECT * FROM [table name] WHERE [field name] = "whatever";
    }*/
    $userInfo = array();
    $result = $conn->query($query);

    while($row = $result->fetch_row()) {
        foreach ($row as $value){
            array_push($userInfo,$value);
        }
    }
    return $userInfo;
}

/*function updateUser($username){
    $conn = $GLOBALS['conn'];
    $currentUser = $username;
    $sql = "SELECT * from user_profile WHERE U_USERNAME = $currentUser";
    $gotresults = $conn->query($sql);
    if($gotresults){
        while($row = )
    }

}
*/
?>


<body id="main">
<span style="font-size:32px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
<div class="main" style="padding-top:40px; padding-left:30px;">
    <h1>Update Profile</h1>
    <!-- read and gather data from the DB below, not complete-->
    <!--<table class="requestList" style="width: 50%" >
        <thead>
        <tr>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody>
        <?php printUsers(); ?>
        </tbody>
        <table>
</div>

</body>
</html>
-->

    <?php include_once("../components/navbar.php") ?>
    <div class="container">
	<form method="post" action="update_user.php">
        <div class="row gutters">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="account-settings">
                            <div class="user-profile">
                                <div class="user-avatar">
                                    <img src="devcomBlack3.jpg" alt="Maxwell Admin ">
                                </div>
                                <h8 class="Name "><?php echo getinfo($username)[0]  ?></h8>
                                <h8 class="user-email"><?php echo getinfo($username)[3]; ?></h8>
                                <!-- <h8 class="role">Role: <?php echo $_SESSION[AuthController::$KEY_ROLE]; ?></h8> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 text-primary">Personal Details</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="fullName">Full Name:</label>
                                    <input type="text" class="form-control" id="fullname" value="<?php echo getinfo($username)[1] . " " . getinfo($username)[2]; ?>" placeholder="Change full name">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="eMail">Email:</label>
                                    <input type="email" class="form-control" id="email" value=<?php echo getinfo($username)[3]?>>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="phone">Old Password: </label>
                                    <input type="text" class="form-control" id="oldpassword" placeholder="Old password">
                                    <label for="phone">New Password: </label>
                                    <input type="text" class="form-control" id="newpassword" placeholder="New password">
                                    <label for="phone">Confirm New Password: </label>
                                    <input type="text" class="form-control" id="confirmnewpassword" placeholder="Confirm new password">
                                </div>

                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="website">Role: <?php
                                        $info = array();
                                        $userinfo = getInfo($username);
                                        $info[0] = "Requester ";
                                        $info[1] = "Maintainer ";
                                        $info[2] = "Auditor ";
                                        $info[3] = "Administrator ";

                                        for($i = 0; $i<4;$i++){
                                            if($userinfo[$i+5]==1){
                                                echo $info[$i];
                                            }
                                        }

                                        ?></label>
                                    <div class="form-group">
                                        <div class = "required-field">Change Role:</div>
                                        <select name = 'role[]' multiple size="4">
                                            <option value="Requester">Requester</option>
                                            <option value="Maintainer">Maintainer</option>
                                            <option value="Auditor">Auditor</option>
                                            <option value="Administrator">Administrator</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gutters">
                            <!--<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mt-3 mb-2 text-primary">Address</h6>
                            </div>-->
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="Street">Supervisor Email:
                                    </label>
                                    <input type="name" class="form-control" id="Street" value=<?php
                                    echo getInfo($username)[9];
                                    ?>>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="ciTy">Branch Supervisor Email:</label>
                                    <input type="name" class="form-control" id="ciTy" value=<?php
                                    echo getInfo($username)[10];
                                    ?>>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="sTate">Status: <?php
                                    echo getInfo($username)[11];
                                    ?></label>
                                </div>
                                    <label for="sTate">Change Status</label>
                                    <select name="status" id="status-label">
                                        <default value="choose">Type</default>
                                        <option value="inactive">Pending</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Disabled</option>
                                        <option value="inactive">Archived</option>

                                    </select>

                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="zIp">Last modified date: <?php
                                        echo getInfo($username)[12];
                                        ?></label>
                                    <input type="text" class="form-control" id="zIp" readonly placeholder="<?php
                                    echo date('Y-m-d h:i:s');
                                    ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-right">
                                    <button type="button" id="submit" name="Submit" class="btn btn-secondary" onclick="location.href = 'test_userV.php'">Back</button>
                                    <button type="button" id="submit" name="Submit" class="btn btn-secondary" onclick="location.href = 'test_userV.php'">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</form>
    </div>

</body>