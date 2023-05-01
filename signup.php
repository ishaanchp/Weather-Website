<?php
$insert = false;
if(isset($_POST['new_username'])){

    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "Users";

    $con = mysqli_connect($server, $username, $password,$database);
    if(!$con){
        die("connection to this database failed due to" . mysqli_connect_error());
    }
    // echo "Success Connecting to the db";
    $new_username = $_POST['new_username'];
    $new_password = $_POST['new_password'];
    $sql =  "INSERT INTO Users (`Username`, `Password`) VALUES ('$new_username', '$new_password');";
    // echo $sql;

    if($con->query($sql) == true){
        // echo "Successfully inserted";
        $insert = true;
    }
    else{
        echo "Error: $sql <br> $con->error";
    }

    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function checkthings(){
            let x = document.forms['Signuppage']['new_username'].value.length;
            if (x<5 || x>10){
                alert("Username should be between 5 and 10");
                return false;
            }
        }
    </script>
</head>
<body>
    <div class="login-container hidden">
        <h1>Sign Up</h1>
        <form name="Signuppage" method="post">
          <input type="text" id="new_username" name="new_username" placeholder="Enter your username" required>
          <input type="password" id="new_password" name="new_password" placeholder= "Enter your password" required>
          <button type="submit" onclick="checkthings()">Sign Up</button>
          <?php
          if($insert == true){
            echo "<p> Thanks for signing up, you can login in now.</p>";
          }
          ?>
        </form>
        <p>Already have an account? <a href="login.php" id="login-link">Log in here</a></p>
      </div>
     
</body>
</html>