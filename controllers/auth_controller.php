<?php
require_once("./../core/mysqli-config.php");

class AuthController
{
    public static $KEY_USER = 'user';
    public static $KEY_EMAIL = 'email';
    public static $KEY_ROLE = 'role';
    public static $KEY_LOGGED_IN = 'logged_in';

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    static function clearSession()
    {
        $_SESSION[self::$KEY_USER] = null;
        $_SESSION[self::$KEY_ROLE] = null;
        $_SESSION[self::$KEY_EMAIL] = null;
        $_SESSION[self::$KEY_LOGGED_IN] = null;
    }

    function setSession($username,$email, $role)
    {
        $_SESSION[self::$KEY_USER] = $username;
        $_SESSION[self::$KEY_ROLE] = $role;
        $_SESSION[self::$KEY_EMAIL] = $email;
        $_SESSION[self::$KEY_LOGGED_IN] = true;
    }

    function getRoles($username){
        $stmt = $this->conn->prepare("SELECT * FROM USER_PROFILE WHERE BINARY U_USERNAME = ?");
        $stmt->bind_param("s",$username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            return array($user['U_REQUESTER'], $user['U_MAINTAINER'],$user['U_AUDITOR'],$user['U_ADMIN']);
        }
        else{
            return array(0,0,0,0);
        }


    }


    function Sign($FirstName, $LastName, $Username, $Email, $Password, $SupervisorEmail = "", $BranchChiefEmail = "", $status = "Active", $requesterVal, $maintainerval, $auditorVal, $adminVal)
    {

        $requester = $requesterVal;
        $maintainer = $maintainerval;
        $auditor = $auditorVal;
        $admin = $adminVal;
    }


    function SignIn($username, $password,$role)
    {
        $stmt = $this->conn->prepare("SELECT * FROM USER_PROFILE WHERE BINARY U_USERNAME = ? AND binary U_PASSWORD = ?");
        $stmt->bind_param("ss",$username,$password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($user['U_STATUS'] == 'Active'){
                if ($role == 'Requester') {
                    if ($user['U_REQUESTER'] == 1){
                        $this->setSession($username, $user['U_EMAIL'],'Requester');
                        header("Location: menu.php");
                        return false;
                    }
                }
                elseif ($role == 'Maintainer') {
                    if ($user['U_MAINTAINER'] == 1) {
                        $this->setSession($username, $user['U_EMAIL'], 'Maintainer');
                        header("Location: menu.php");
                        return false;
                    }
                }
                elseif ($role == 'Auditor') {
                    if ($user['U_AUDITOR'] == 1) {
                        $this->setSession($username, $user['U_EMAIL'], 'Auditor');
                        header("Location: menu.php");
                        return false;
                    }
                }
                elseif ($role == 'Administrator') {
                    if ($user['U_ADMIN'] == 1) {
                        $this->setSession($username, $user['U_EMAIL'], 'Administrator');
                        header("Location: menu.php");
                        return false;
                    }
                }
            }
            else if ($user['U_STATUS'] == 'Pending' || $user['U_STATUS'] == 'Disabled' || $user['U_STATUS'] == 'Archived'){
                return 'Inactive Account';
            }
        }
        return 'Invalid Username or Password';
    }

    function SignUp($FirstName,$LastName,$Username,$Email,$Password,$SupervisorEmail="",$BranchChiefEmail="",$status="Pending")
    {

        $requester = 1;
        $maintainer = 0;
        $auditor = 0;
        $admin = 0;

        $stmt = $this->conn->prepare("INSERT INTO USER_PROFILE (U_USERNAME,U_FIRST_NAME,U_LAST_NAME,U_EMAIL,U_PASSWORD,U_REQUESTER,U_MAINTAINER,U_AUDITOR,U_ADMIN,U_SUPER_EMAIL,U_BRANCH_EMAIL,U_STATUS) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");

        $stmt->bind_param("sssssiiiisss", $Username, $FirstName,$LastName, $Email, $Password, $requester, $maintainer, $auditor, $admin, $SupervisorEmail, $BranchChiefEmail, $status);

        $stmt->execute();

        $stmt = $this->conn->prepare("SELECT * FROM USER_PROFILE WHERE BINARY U_USERNAME = ?");
        $stmt->bind_param("s",$Username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result == true) {

            header("Location: login.php");
            return false;
        }
        return true;
    }

    function updateProfile($FirstName,$LastName,$Username,$Email,$Password,$SupervisorEmail="",$BranchChiefEmail="",$status="Active")
    {

        $requester = 1;
        $maintainer = 1;
        $auditor = 1;
        $admin = 1;






        $stmt = $this->conn->prepare("INSERT INTO USER_PROFILE (U_USERNAME,U_FIRST_NAME,U_LAST_NAME,U_EMAIL,U_PASSWORD,U_REQUESTER,U_MAINTAINER,U_AUDITOR,U_ADMIN,U_SUPER_EMAIL,U_BRANCH_EMAIL,U_STATUS) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");

        $stmt->bind_param("sssssiiiisss", $Username, $FirstName,$LastName, $Email, $Password, $requester, $maintainer, $auditor, $admin, $SupervisorEmail, $BranchChiefEmail, $status);

        $stmt->execute();

        $stmt = $this->conn->prepare("SELECT * FROM USER_PROFILE WHERE BINARY U_USERNAME = ?");
        $stmt->bind_param("s",$Username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result == true) {

            header("Location: login.php");
            return false;
        }
        return true;
    }

    function createProfile($FirstName,$LastName,$Username,$Email,$Password,$requester,$maintainer,$auditor,$administrator,$SupervisorEmail="",$BranchChiefEmail="",$status="Active")
    {

        $stmt = $this->conn->prepare("INSERT INTO USER_PROFILE (U_USERNAME,U_FIRST_NAME,U_LAST_NAME,U_EMAIL,U_PASSWORD,U_REQUESTER,U_MAINTAINER,U_AUDITOR,U_ADMIN,U_SUPER_EMAIL,U_BRANCH_EMAIL,U_STATUS) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");

        $stmt->bind_param("sssssiiiisss", $Username, $FirstName,$LastName, $Email, $Password, $requester, $maintainer, $auditor, $administrator, $SupervisorEmail, $BranchChiefEmail, $status);

        $stmt->execute();

        $stmt = $this->conn->prepare("SELECT * FROM USER_PROFILE WHERE BINARY U_USERNAME = ?");
        $stmt->bind_param("s",$Username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result == true) {

            header("Location: login.php");
            return false;
        }
        return true;
    }

    function getUsername()
    {
        return self::$KEY_USER;
    }

    function getEmail()
    {
        return self::$KEY_EMAIL;
    }

}

$auth = new AuthController($conn);