<?php

$status;

//defining the database configuration here

$db_host = 'localhost';
$db_name = 'play_dev';
$db_user = "root";
$db_password = "";
$db_tablename = "notifyuser";

if (isset($_POST['email'])) {    //check if Post_email is set
  $email =  $_POST['email'];

  $clean_email = filter_var($email, FILTER_SANITIZE_EMAIL); // cleans the email inputed

  if (filter_var($clean_email, FILTER_VALIDATE_EMAIL)) {  // validates the cleaned email using filter_validate_email
    // create connection to database
    $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

    // testng connection
    if(!$conn) {
      die("Connection failed");
    }

    $query = "INSERT INTO $db_tablename (EMAIL) VALUES ('$email')"; //query to insert to the db

    if(mysqli_query($conn, $query)) {
      $status = "<p style='color: green'>Email has been recieved. Thank you</p>";
    } else {
      if(preg_match("/Duplicate/i", mysqli_error($conn))){
        $status = "<p style='color: red'>Email has already been added to notification list. Thank you</p>";
      } else {
        $status = "<p style='color: red'>Error occurred</p>";
      }      
    }
    $conn->close();
  } else {
    $status = "<p style='color: red'>Invalid Email</p>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body> 
  <h1>Hello</h1>

  <form action="index.php" method="POST">
    <input type="email" name="email" id="email" placeholder="Email username" >
    <button type="submit">Submit</button>
    <?php
      if (isset($_POST['email'])) {
        echo $status;
      }
    ?> 
  </form>
</body>
</html>