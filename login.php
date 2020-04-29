<?php
require 'classes/DBConnector.php';
require 'classes/User.php';

$dbConnector=new DBConnector;
$user=new User;

$post=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

if(isset($post['login'])){
    $username=$post['username'];
    $password=$post['password'];

    $user->setUsername($username);
    $user->setPassword($password);



    $dbConnector->query('SELECT * FROM user where username=:uname');
    $dbConnector->bind(':uname',$username);

    $row=$dbConnector->single();
//    print_r($row);
    $hash=$row['password'];

    if(password_verify($password,$hash)){
        $user->login();
        $user->createUserSession();
//       echo 'Successful Login :)';
    }else{
//        echo 'Incorrect login details! :(';
        header('Location:login.php');
    }

}





?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
<h1>Login</h1>
<form method="post"action="<?php $_SERVER['PHP_SELF'];?>" name="login" id="login">

    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="password" required><br><br>
    <input type="submit" name="login" value="LOGIN"><br><br>

</form>

</body>
</html>
