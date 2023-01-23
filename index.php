<?php
session_start();
$_SESSION['microsoftoauth']['origin'] = 'index.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <a href="./microsoftoauth.php" target="_blank">Sign in with microsoft</a>

</body>

</html>