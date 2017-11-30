<?
session_start();
if(!isset($_SESSION['username'])){
  header('Location: index.php');
}

if ($_SERVER["REQUEST_METHOD"] == "GET"){
  if(isset($_GET["id"]) && isset($_GET["comment"]) && isset($_GET["rating"])){

    $username = $_SESSION["username"];
    $userid = "";

    include 'dbConnection.php';

    // Get current user id
    $sql = $connection->prepare("SELECT user_id FROM Users WHERE user_name = ?");
    $sql->bind_param("s", $username);
    $sql->execute();
    $sql->store_result();
    $sql->bind_result($col1);

    while($sql->fetch()){
      $userid = $col1;
    }

    $cid = $_GET["id"];
    $comment = $_GET["comment"];
    $rating= $_GET["rating"];

    $sql = $connection->prepare("INSERT INTO Review (review_rating, review_desc, user_id, cure_id)VALUES (?,?,?,?)");
    $sql->bind_param("isii",$rating,$comment,$userid,$cid);
    $sql->execute();

    header('Location: cureDesc.php?id='.$cid.'.php');

  }else{
    header('Location: shop.php');
  }
}else{
  header('Location: shop.php');
}

?>
