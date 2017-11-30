<?php
  session_start();
  if(!isset($_SESSION['admin'])){
    header('Location: index.php');
  }

  if(isset($_GET['id'])){
    $uid = $_GET['id'];

    // include database connection
    include 'dbConnection.php';

    // Delete user by id
    $stmt = $connection->prepare("DELETE FROM Users WHERE user_id = ?");
    $stmt->bind_param( "i", $uid);
    $stmt->execute();

    header('Location: account.php');

  }else{
    header('Location: index.php');
  }
?>
