<?php
session_start();
if(isset($_SESSION['username'])){
  header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
<head></head>

  <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
      if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"]) && isset($_POST["dna"]) && isset($_POST["address"]) && isset($_POST["city"]) && isset($_POST["province"]) && isset($_POST["postal"])
      && isset($_POST["country"]) && isset($_POST["docid"])){
        //handle the user inputted data
        $username= $_POST["username"];
        $pass = md5($_POST["password"]);
        $email = $_POST["email"];
        $dna = $_POST["dna"];
        $address = $_POST["address"];
        $city = $_POST["city"];
        $province = $_POST["province"];
        $postal = $_POST["postal"];
        $country = $_POST["country"];
        $docid = $_POST["docid"];

        // include database connection
        include 'dbConnection.php';

        $stmt = $connection->prepare("SELECT * FROM Users WHERE user_name = ?");
        $stmt->bind_param( "s", $username);
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;

        $stmt2 = $connection->prepare("SELECT * FROM Users WHERE user_email = ?");
        $stmt2->bind_param( "s", $email);
        $stmt2->execute();
        $stmt2->store_result();
        $emailRows = $stmt2->num_rows;

        if($rows > 0 || $emailRows > 0){
          $_SESSION['errMsg'] = "<p style='color:red' align='center'> Username/email already in use! </p>";
          header('Location: register.php');
        }else{
        // query
        $sql = $connection->prepare("INSERT INTO Users (user_name, password, user_email, dna, address, city, province, postal, country, doc_id) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $sql->bind_param("sssssssssi", $username, $pass, $email, $dna, $address, $city, $province, $postal, $country, $docid);
        $sql->execute();

        header('Location: account.php');
        }
        }
        else{
          header('Location: account.php');
        }
        mysqli_close($connection);
      }
      else{
        //username or password was not set, redirect back to the login password_get_info
        header('Location: register.php');
      }
  ?>
</body>
</html>
