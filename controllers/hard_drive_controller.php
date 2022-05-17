<?php
require_once("./../core/mysql-config.php");

class HDController{

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function getUserHDs($username){
        $stmt = $this->conn->prepare("SELECT  * FROM HARD_DRIVE NATURAL JOIN (SELECT H_HARD_DRIVE_REQUEST_NO FROM HARD_DRIVE_REQUEST 
            NATURAL JOIN (SELECT R_REF_NUMBER_YEAR, R_REF_NUMBER_NO FROM REQUEST WHERE U_USERNAME = ?) AS REQUESTS) AS INFO;");
        $stmt->bind_param("s",$username);
        $stmt->execute();
        $result = $stmt->get_result();
    }

    function printCHardDrives(){

        $username = $_SESSION[AuthController::$KEY_USER];
        $stmt = "";
        if ($_SESSION['role'] == "Requester"){
            $stmt = $this->conn->prepare('SELECT * FROM HARD_DRIVE NATURAL JOIN (SELECT H_HARD_DRIVE_REQUEST_NO FROM HARD_DRIVE_REQUEST NATURAL JOIN 
                    (SELECT R_REF_NUMBER_YEAR, R_REF_NUMBER_NO FROM REQUEST WHERE U_USERNAME = ?) AS REQUESTS) AS INFO WHERE HD_CLASSIFICATION = "Classified";');
            $stmt->bind_param("s",$username);
            $stmt->execute();
            //$query = 'SELECT * FROM hard_drive WHERE HD_CLASSIFICATION = "Classified";';
        }
        elseif ($_SESSION['role'] == "Maintainer"){
            $stmt = 'SELECT * FROM hard_drive WHERE HD_CLASSIFICATION = "Classified";';
            $stmt->execute();
        }

        $result = $stmt->get_result();

        while($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td> <input type="checkbox"> </td>';
            echo "<td>". htmlspecialchars($row['HD_ID']) ."</td>";
            echo "<td>" . htmlspecialchars($row['HD_BOOT_STATUS']) . "</td>";
            echo "<td>" . htmlspecialchars($row['H_HARD_DRIVE_REQUEST_NO']) . "</td>";
            echo "<td>" . htmlspecialchars($row['HD_ISSUED_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['HD_RETURN_DATE']) . "</td>";
            echo "</tr>";

        }
    }
}

$hd = new HDController($conn);

