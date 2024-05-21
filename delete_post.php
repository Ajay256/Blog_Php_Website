<?php
include("config/config.php");

session_start();

if (!isset($_SESSION["user_id"])) {
    header('Location:login.php');
    exit();
}



if (isset($_GET['id'])) {
    
    $id = $_GET['id'];

    $sql = "DELETE FROM posts WHERE id = ? AND user_id = ?";
    $stmt= $connection->prepare($sql);
    $stmt->execute([$id, $_SESSION["user_id"]]);

    header('Location: index.php');
}

?>