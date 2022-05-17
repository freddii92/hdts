
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../components/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://fonts.googleapis.com/icon?family=PT+Mono" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HDTS</title>
</head>

<?php include_once("../components/navbar.php") ?>

<body id = "main">
    <span style="font-size:32px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
    <div class="main">

        <div class="container" style="background-color:#FFFFFF; padding-left: 25%">
            <form method="POST" action="menu.php">
                <div style="text-align: center" class="row">
                    <!--<label ><strong><p style="color:black;font-size:28px"><p class="center">Request Sent!<br><br><br><br><br></p><strong></label>-->
                    <p style="font-size:28px" class="center3"><strong>Request Sent!<br><br><br><br><br><br></strong></p>
                </div>
                <div class="row">
                    <img style="align-content: center" src="checkmark1.png" class="center" alt="checkmark">
                </div>
            </form>
        </div>
    </div>
</body>



