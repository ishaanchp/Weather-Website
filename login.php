<?php
$login = false;
$showError = false;
if(isset($_POST['userid'])){

    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "Users";

    $con = mysqli_connect($server, $username, $password,$database);
    if(!$con){
        die("connection to this database failed due to" . mysqli_connect_error());
    }
    // echo "Success Connecting to the db";
    $userid = $_POST['userid'];
    $passcode = $_POST['passcode'];
    $sql =  "SELECT * FROM Users where Username='$userid' AND Password='$passcode'";
    $result= mysqli_query($con,$sql);
    $row= mysqli_fetch_assoc($result);
    $num = mysqli_num_rows($result);
    if($num==1){
      $login = true;
    }
    else{
        $showError="Invalid Credentials";
    }

    $con->close();
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="login-container">
      <h1>Login</h1>
      <form method="post">
        <input type="text" id="userid" name="userid" required placeholder="Enter your name"><br>
        <input type="password" id="passcode" name="passcode" required placeholder="Enter your password">
        <button type="submit" class="btn">Login</button>
        <?php
          if($login == true){
            // echo $row['Username'];
            header("Location: website.php");
          }
          if($showError){
            echo "<p> Invalid Credentials";
          }
          ?>
      </form>
      <p>Don't have an account? <a href="signup.php" id="signup-link">Sign up here</a></p>
    </div>
    <script src="script.js"></script>
  </body>
</html>
