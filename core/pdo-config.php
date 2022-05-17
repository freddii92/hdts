<?php




$user = "jrlopez14";  # If 1 above (for your group project), enter the username of the interface or reports lead.
# If 2 above (for this individual exercise), enter your username.

$password = "*YC2022!";  # If 1 above (for your group project), enter the password of the interface or reports lead. Make sure it is not used anywhere else as it will be shared among team members.
# If 2 above (for this individual exercise), enter your individual password.

$host = "cssrvlab01.utep.edu";
$port = 3306;
$data = "s22_yc_team6";
$user = 'jrlopez14'; // Change as necessary
$pass = '*YC2022!'; // Change as necessary
$chrs = 'utf8mb4';
$attr = "mysql:host=$host;port=$port,dbname=$data;charset=$chrs";
$opts =
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];


try {
    $pdo = new PDO($attr, $user, $pass, $opts);

} catch (PDOException $e) {
    // throw new PDOException($e->getMessage(), (int)$e->getCode());

    $dbhost = $_SERVER['RDS_HOSTNAME'];
    $dbport = $_SERVER['RDS_PORT'];
    $dbname = $_SERVER['RDS_DB_NAME'];
    $charset = 'utf8mb4';

    $dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};charset={$charset}";
    $username = $_SERVER['RDS_USERNAME'];
    $password = $_SERVER['RDS_PASSWORD'];

    $pdo = new PDO($dsn, $username, $password, $opts);
}
