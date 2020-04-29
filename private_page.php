<?php
session_start();
if(!isset($_SESSION['username'])){
    header('Location:login.php');
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Private Page</title>
</head>
<body>
<h1>Hello <?php echo $_SESSION['username'];?></h1>
<h2>This is a private</h2>
<p>We want to protect it.</p>

<p><a href="logout.php">Logout</a> </p>

</body>
</html>
