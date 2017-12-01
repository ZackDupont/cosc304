<?php
  session_start();
  if(!isset($_SESSION['admin'])){
    header('Location: index.php');
  }

  if(isset($_GET['id'])){
    $cid = $_GET['id'];

    // include database connection
    include 'dbConnection.php';

    // Delete user by id
    $stmt = $connection->prepare("DELETE FROM Cure WHERE cure_id = ?");
    $stmt->bind_param( "i", $cid);
    $stmt->execute();

    header('Location: account.php');

  }else{
    header('Location: account.php');
  }
?>
