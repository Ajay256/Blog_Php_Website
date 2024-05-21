<!-- Database connect and manage -->
<?php
$serverName = "localhost";
$userName = "root";
$dbName ="simple_blog";
$dbPassword = "";

try {
    $connection = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $dbPassword);

    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Connection Failed". $e->getMessage();
    //throw $th;
}


 ?>
