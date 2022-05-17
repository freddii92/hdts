<?php
    require_once 'testConfig.php';
    try{
        $pdo = new PDO($attr, $user, $pass, $opts);
    }
    catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }

    

    $refNum= $_GET['refNumber'];
    $ref_arr = explode ("-", $refNum); 

    $refYear = $ref_arr[0];
    $refNum = $ref_arr[1];

    $sql = "UPDATE request_event SET r_status='APPROVE' WHERE r_ref_number_no =$refNum AND r_ref_number_year = $refYear";
    $stmt = $pdo->prepare($sql);

    // execute the query
    $stmt->execute();
    header("Location: view_requests.php");
?>

