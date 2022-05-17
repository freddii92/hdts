<?php
require_once('./../core/mysqli-config.php');
require_once 'testConfig.php';
include_once("./../controllers/auth_controller.php");


if (!(array_key_exists(AuthController::$KEY_LOGGED_IN, $_SESSION) && $_SESSION[AuthController::$KEY_LOGGED_IN])) {
    header("Location: login.php");
}


try{
    $pdo = new PDO($attr, $user, $pass, $opts);
}
catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}


function printRequests($pdo){
    
    $conn = $GLOBALS['conn'];
    
    $query = "";
    if ($_SESSION['role'] == "Requester")
    {
        $query = 'SELECT * FROM REQUEST WHERE U_USERNAME = "' . $_SESSION[AuthController::$KEY_USER] . '";';

    }elseif ($_SESSION['role'] == "Maintainer") {
        $query = 'SELECT * FROM REQUEST NATURAL JOIN (SELECT U_USERNAME,U_EMAIL FROM USER_PROFILE) AS INFO;';
        ///$query = "SELECT * FROM REQUEST";        
    }
    //$query = "SELECT * FROM REQUEST";
    $result = $pdo->query($query);

    while($row = $result->fetch()) {
        $refNumber = $row['R_REF_NUMBER_NO'];
        $refYear = $row['R_REF_NUMBER_YEAR'];
        $query = "SELECT * FROM request_event NATURAL JOIN (SELECT U_USERNAME,U_EMAIL FROM USER_PROFILE) AS INFO WHERE R_REF_NUMBER_NO = $refNumber AND  R_REF_NUMBER_YEAR = $refYear";
        $result2 = $pdo->query($query);

        while($row2 = $result2->fetch()){
            $refYN = $refYear ."-". $refNumber;
            echo '<tr'. ' onclick="showHideRow(' . "'" . "requestOpen". 
            "', '". htmlspecialchars($refYN). 
            "', '". htmlspecialchars($row2['U_USERNAME']) .
            "', '". htmlspecialchars($row2['U_EMAIL']) .
            "', '". htmlspecialchars($row2['R_STATUS']).  
            "', '". htmlspecialchars($row2['E_DESCRIPTION']).
            "', '". htmlspecialchars($row2['R_CREATION_DATE']).
            "', '". htmlspecialchars($row2['R_LAST_MODIFIED_DATE']).
            "', '". htmlspecialchars($row2['R_NEED_BY_DATE']).
            "', '". htmlspecialchars($row2['E_EVENT_NAME']).  
            "', '". htmlspecialchars($row2['E_LOCATION']). 
            "', '". htmlspecialchars($row2['E_TYPE']).
            "', '". htmlspecialchars($row2['E_START_DATE']).
            "', '". htmlspecialchars($row2['E_END_DATE']). 
            "'". ');">';

            $refNumber = sprintf('%04d',$refNumber);

            echo "<td>". $refYear ."-". $refNumber ."</td>";
            echo "<td>" . htmlspecialchars($row['R_STATUS']) . "</td>";
            echo "<td>" . htmlspecialchars($row['R_CREATION_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['R_LAST_MODIFIED_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['R_NEED_BY_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['R_COMMENTS']) . "</td>";
            echo "<td>" . htmlspecialchars($row['U_USERNAME']) . "</td>";
            echo "</tr>";
        }

    }


}
function requestSearch($search_value,$pdo){
    
    require_once('./../core/mysqli-config.php');

    $conn = $GLOBALS['conn'];
    
    $query = "";
    // if ($_SESSION['role'] == "Requester")
    // {
    //     $query = "CREATE OR REPLACE VIEW Request_Search AS SELECT * FROM REQUEST WHERE CONCAT_WS('-',R_REF_NUMBER_YEAR,R_REF_NUMBER_NO) ='".$search_value."';";
    // }else{
        
    $query = "CREATE OR REPLACE VIEW Request_Search AS SELECT * FROM REQUEST WHERE CONCAT_WS('-',R_REF_NUMBER_YEAR,R_REF_NUMBER_NO) ='".$search_value."';";
    // }

    $result = $conn->query($query);

    // if ($_SESSION['role'] == "Requester")
    // {
    $query = 'SELECT * FROM Request_Search;';
    // }

    $result = $pdo->query($query);

    while($row = $result->fetch()) {
        $refNumber = $row['R_REF_NUMBER_NO'];
        $refYear = $row['R_REF_NUMBER_YEAR'];
        $query = "SELECT * FROM request_event WHERE R_REF_NUMBER_NO = $refNumber AND  R_REF_NUMBER_YEAR = $refYear";
        $result2 = $pdo->query($query);
        while($row2 = $result2->fetch()){
            echo '<tr'. ' onclick="showHideRow(' . "'" . "requestOpen". 
            "', '". htmlspecialchars($row['R_REF_NUMBER_YEAR']). 
            "', '". htmlspecialchars($row['R_REF_NUMBER_NO']). 
            "', '". htmlspecialchars($row2['U_USERNAME']) .
            "', '". htmlspecialchars($row2['R_STATUS']).  
            "', '". htmlspecialchars($row2['R_REF_NUMBER_NO']). 
            "', '". htmlspecialchars($row2['E_DESCRIPTION']).
            "', '". htmlspecialchars($row2['R_CREATION_DATE']).
            "', '". htmlspecialchars($row2['R_LAST_MODIFIED_DATE']).
            "', '". htmlspecialchars($row2['R_NEED_BY_DATE']).
            "', '". htmlspecialchars($row2['E_EVENT_NAME']).  
            "', '". htmlspecialchars($row2['E_LOCATION']). 
            "', '". htmlspecialchars($row2['E_TYPE']).
            "', '". htmlspecialchars($row2['E_START_DATE']).
            "', '". htmlspecialchars($row2['E_END_DATE']). 
            "'". ');">';

            //echo '<td> <input type="checkbox"> </td>';
            $refNumber = sprintf('%04d',$refNumber);

            echo "<td>". $refYear ."-". $refNumber ."</td>";
            echo "<td>" . htmlspecialchars($row['R_STATUS']) . "</td>";
            echo "<td>" . htmlspecialchars($row['R_CREATION_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['R_LAST_MODIFIED_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['R_NEED_BY_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['R_COMMENTS']) . "</td>";
            echo "<td>" . htmlspecialchars($row['U_USERNAME']) . "</td>";
            echo "</tr>";
        }

    }
}

function resetView($pdo){

    require_once('./../core/mysqli-config.php');

    $conn = $GLOBALS['conn'];
    
    $query = "";
    if ($_SESSION['role'] == "Requester")
    {
        $query = 'CREATE OR REPLACE VIEW Request_Search AS SELECT * FROM REQUEST WHERE U_USERNAME="'. $_SESSION[AuthController::$KEY_USER] .'" ;';
    }else{
        $query = 'CREATE OR REPLACE VIEW Request_Search AS SELECT * FROM REQUEST;';
    }

    $result = $conn->query($query);

    if ($_SESSION['role'] == "Requester")
    {
        $query = 'SELECT * FROM Request_Search WHERE U_USERNAME="'. $_SESSION[AuthController::$KEY_USER] .'" ;';
    }else{
        $query = 'SELECT * FROM Request_Search';
    }

    $result = $pdo->query($query);

    while($row = $result->fetch()) {
        $refNumber = $row['R_REF_NUMBER_NO'];
        $refYear = $row['R_REF_NUMBER_YEAR'];
        $query = "SELECT * FROM request_event WHERE R_REF_NUMBER_NO = $refNumber AND  R_REF_NUMBER_YEAR = $refYear";
        $result2 = $pdo->query($query);
        while($row2 = $result2->fetch()){
            echo '<tr'. ' onclick="showHideRow(' . "'" . "requestOpen". 
            "', '". htmlspecialchars($row['R_REF_NUMBER_YEAR']). 
            "', '". htmlspecialchars($row['R_REF_NUMBER_NO']). 
            "', '". htmlspecialchars($row2['U_USERNAME']) .
            "', '". htmlspecialchars($row2['R_STATUS']).  
            "', '". htmlspecialchars($row2['R_REF_NUMBER_NO']). 
            "', '". htmlspecialchars($row2['E_DESCRIPTION']).
            "', '". htmlspecialchars($row2['R_CREATION_DATE']).
            "', '". htmlspecialchars($row2['R_LAST_MODIFIED_DATE']).
            "', '". htmlspecialchars($row2['R_NEED_BY_DATE']).
            "', '". htmlspecialchars($row2['E_EVENT_NAME']).  
            "', '". htmlspecialchars($row2['E_LOCATION']). 
            "', '". htmlspecialchars($row2['E_TYPE']).
            "', '". htmlspecialchars($row2['E_START_DATE']).
            "', '". htmlspecialchars($row2['E_END_DATE']). 
            "'". ');">';

            //echo '<td> <input type="checkbox"> </td>';
            $refNumber = sprintf('%04d',$refNumber);

            echo "<td>". $refYear ."-". $refNumber ."</td>";
            echo "<td>" . htmlspecialchars($row['R_STATUS']) . "</td>";
            echo "<td>" . htmlspecialchars($row['R_CREATION_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['R_LAST_MODIFIED_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['R_NEED_BY_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['R_COMMENTS']) . "</td>";
            echo "<td>" . htmlspecialchars($row['U_USERNAME']) . "</td>";
            echo "</tr>";
        }

    }
}

function filter($filter_option,$pdo) {

    $conn = $GLOBALS['conn'];
    
    $query = "";

    if ($_SESSION['role'] == "Requester" or $_SESSION['role'] == "Maintainer" or $_SESSION['role'] == "Administrator" or $_SESSION['role'] == "Auditor")
    {

        if ($filter_option == "newest_to_oldest") {
            $query = 'SELECT * FROM Request_Search ORDER BY R_CREATION_DATE DESC;';
        }else if($filter_option == "PENDING"){
            $query = 'SELECT * FROM Request_Search WHERE R_STATUS = "PENDING";';
        } else if($filter_option == "APPROVE"){
            $query = 'SELECT * FROM Request_Search WHERE R_STATUS = "APPROVE";';
        } else if($filter_option == "DENIED"){
            $query = 'SELECT * FROM Request_Search WHERE R_STATUS = "DENIED";';
        }
         else{
            $query = 'SELECT * FROM Request_Search ORDER BY R_CREATION_DATE ASC;';
        }
    }

    $result = $pdo->query($query);

    while($row = $result->fetch()) {
        $refNumber = $row['R_REF_NUMBER_NO'];
        $refYear = $row['R_REF_NUMBER_YEAR'];
        $query = "SELECT * FROM request_event WHERE R_REF_NUMBER_NO = $refNumber AND  R_REF_NUMBER_YEAR = $refYear";
        $result2 = $pdo->query($query);
        while($row2 = $result2->fetch()){
            echo '<tr'. ' onclick="showHideRow(' . "'" . "requestOpen". 
            "', '". htmlspecialchars($row['R_REF_NUMBER_YEAR']). 
            "', '". htmlspecialchars($row['R_REF_NUMBER_NO']). 
            "', '". htmlspecialchars($row2['U_USERNAME']) .
            "', '". htmlspecialchars($row2['R_STATUS']).  
            "', '". htmlspecialchars($row2['R_REF_NUMBER_NO']). 
            "', '". htmlspecialchars($row2['E_DESCRIPTION']).
            "', '". htmlspecialchars($row2['R_CREATION_DATE']).
            "', '". htmlspecialchars($row2['R_LAST_MODIFIED_DATE']).
            "', '". htmlspecialchars($row2['R_NEED_BY_DATE']).
            "', '". htmlspecialchars($row2['E_EVENT_NAME']).  
            "', '". htmlspecialchars($row2['E_LOCATION']). 
            "', '". htmlspecialchars($row2['E_TYPE']).
            "', '". htmlspecialchars($row2['E_START_DATE']).
            "', '". htmlspecialchars($row2['E_END_DATE']). 
            "'". ');">';

            
            //echo '<td> <input type="checkbox"> </td>';
            $refNumber = sprintf('%04d',$refNumber);

            echo "<td>". $refYear ."-". $refNumber ."</td>";
            echo "<td>" . htmlspecialchars($row['R_STATUS']) . "</td>";
            echo "<td>" . htmlspecialchars($row['R_CREATION_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['R_LAST_MODIFIED_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['R_NEED_BY_DATE']) . "</td>";
            echo "<td>" . htmlspecialchars($row['R_COMMENTS']) . "</td>";
            echo "<td>" . htmlspecialchars($row['U_USERNAME']) . "</td>";
            echo "</tr>";
        }

    }
}
?>



<?php include_once("../components/navbar.php") ?>

<!DOCTYPE html>
<!-- style -->
<html>
<head>
    <link rel="stylesheet" href="../components/styles.css">
    <link rel="stylesheet" href="../components/styleRequests.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=PT+Mono" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Requests</title>
    
    <script type="text/javascript">
  
        function showHideRow(request, refNumber, username, email, requestStatus , eDescription, createdDate 
        ,lastModDate, needByDate,eEventName, eLocation, eType, eStartDate, eEndDate) {

            const div = document.getElementById('requestOpen');
            $("#" + request).css('display', "inline");
            $("#" + request).css('width', "50%");
            $("#" + request).css('position', "sticky");
            var ref =2

            div.innerHTML = '<table style="width:95%"><tr id="ROWcontInfo" style="height:10px"><td style="text-align: center;" colspan="2"><strong><p style="color:black;font-size:25px">Request Form</Re></p></td></tr><tr style="height:25px"><td colspan="2"><p>Contact Information</p> <br> <p>Requester Email: ' + email +'</p>'

            + '<p>  Requester Username: ' + username + '</p>'
            
            + '</td> </tr> <tr style="width:95%"> <td style="width:40%" colspan="2"> <strong> <p style="color:black;font-size:16px">Request Status:  </strong>' + requestStatus 
            
            + '</td> </tr> <tr style="width:95%"> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Reference Number: </strong> <p>' + refNumber 
            
            + '</td> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Creation Date: </strong> <p>' + createdDate 
            
            + '</td> </tr> <tr style="width:95%"> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Last Modified Date: </strong> <p>' + lastModDate 
            
            + '</td> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Needed by date: </strong> <p>' + needByDate 

            + '</td> </tr> <tr style="width:95%"> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Event Name : </strong> <p>' + eEventName 

            + '</td> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Location : </strong> <p>' + eLocation

            + '</td> </tr> <tr style="width:95%"> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Description : </strong> <p>' + eDescription 
            
            + '</td> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Event Type: </strong> <p>' + eType

            + '</td> </tr> <tr style="width:95%"> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Event Start Date : </strong> <p>' + eStartDate 

            + '</td> <td style="width:40%"> <strong> <p style="color:black;font-size:16px">Event End Date : </strong> <p>' + eEndDate

            + '</td> </tr> </table>';
            
            
            div.insertAdjacentHTML('beforeEnd','<br><button type="button" onclick="closeDiv();">Close</button>');
            $("#listRequests").css('width', "50%");

            //div.insertAdjacentHTML('beforeEnd','<br><select class="from-control" id="review" name="Select" value="Select"> <option>PENDING</option> <option>APPROVE</option><option>DENIED</option></select>');
            //$("#listRequests").css('width', "50%");

            var approveButton = '<br><a href="approveRequest.php?refNumber=' + refNumber + '&status=approve">APPROVE</a>';
            div.insertAdjacentHTML('beforeEnd',approveButton);
            $("#listRequests").css('width', "50%");

            var denyButton = '<br><a href="approveRequest.php?refNumber=' + refNumber + '&status=deny">DENY</a>';
            div.insertAdjacentHTML('beforeEnd',denyButton);
            $("#listRequests").css('width', "50%");
            
            
        }

        function closeDiv(){
            $("#requestOpen").css('width', "0%");
            $("#listRequests").css('width', "100%");
            $("#requestOpen").css('display', "none");
        }

      </script>

</head>



<body id="main">
<span style="font-size:32px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
<div class="main" style="padding-top:40px; padding-left:30px;">
<h1>REQUESTS</h1>

    <!-- read and gather data from the DB below, not complete-->
    <!---->
    <form method="post" id="search">
    <input type="text" id="search" name="search" class="search" placeholder="Search">
                <div style="display: inline;">
                    <button class="form-group">
                    <input class="btn btn-primary; fa fa-search" name='Submit' type="submit" value="Search" style="font-size: 15px;">
                    </button>
                    <select class="filter" name="filter" id="filter">
                        <option value="oldest_to_newest">Timestamp Old - New</option>
                        <option value="newest_to_oldest">Timestamp New - Old</option>
                        <option value="PENDING">status - PENDING</option>
                        <option value="APPROVE">status - APPROVE</option>
                        <option value="DENIED">status - DENIED</option>
                    </select>
                    <button class="form-group">
                    <input class="btn btn-success; fa fa-search" name='filter' type="button" value="Filter" style="font-size: 15px;">
                    </button>
                    <button class="btn btn-success" style="background-color:red; border-color:red"name="reset">Reset</button>
                </div>
            </form>
    <!----->

    


    <div id="requestOpen">
        
    </div>
    <div id="listRequests">
        <table style="width:100%" >
            <thead >
            <tr>
                <th>Request No.</th>
                <th>Status</th>
                <th>Creation Date</th>
                <th>Last Modified Date</th>
                <th>Need By</th>
                <th>Comments</th>
                <th>Username</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($_POST)) {
                if (isset($_POST['Submit'])) {
                    $search_value = isset($_POST['search']) ? $_POST['search'] : NULL;
                
                    requestSearch($search_value,$pdo);
                    die();
                }
                if (isset($_POST['reset'])) {
                    resetView($pdo);
                    die();
                }
                if (isset($_POST['filter'])) {

                    $filter_option = isset($_POST['filter']) ? $_POST['filter'] : NULL;
                    
                    filter($filter_option, $pdo);
                    
                    die();
                }
                printRequests($pdo);
            } else {
                printRequests($pdo);
            }

            ?>
            </tbody>
            <table>
    </div>


</body>
</html>

