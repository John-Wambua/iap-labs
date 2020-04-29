<?php
require 'classes/DBConnector.php';
require 'classes/User.php';
$dbConnector=new DBConnector;

$post=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

//Inserting into the DB
if(isset($post['submit'])){
    $fName=$post['first_name'];
    $lName=$post['last_name'];
    $cityName=$post['city_name'];
    $username=$post['username'];
    $password=$post['password'];

    $user=new User;
    $user->setFname($fName);
    $user->setLname($lName);
    $user->setCityName($cityName);
    $user->setUsername($username);
    $user->setPassword($password);
//    ($fName,$lName,$cityName,$username,$password);
//    die( $user->getUsername());

    if(!$user->validateForm()){
        $user->createFormErrorSessions();
        header('Refresh:0');
        die();
    }

    $pass=$user->hashPassword();

    $dbConnector->query('SELECT * FROM user where username=:uname');
    $dbConnector->bind(':uname',$username);

    if($dbConnector->single()>0){
        $user->createUserExistsSession();
        header('Refresh:0');
        die();
    }

    $dbConnector->query('INSERT INTO user(first_name,last_name,user_city,username,password) VALUES(:fname,:lname,:cname,:uname,:pass)');

    $dbConnector->bind(':fname',$fName);
    $dbConnector->bind(':lname',$lName);
    $dbConnector->bind(':cname',$cityName);
    $dbConnector->bind(':uname',$username);
    $dbConnector->bind(':pass',$pass);

    if($dbConnector->execute()){
        ?>
        <script>
            alert('Registered Successfully!')
        </script>
        <?php
        header('Location:login.php');

    }
}

?>
<!--------------------HTML----------------------------->

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IAP LABS</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/validate.js"></script>
    </head>
<body>
<div class="container ">
    <h2>Enter Details</h2>
    <form name="user_details" method="post" action="<?php $_SERVER['PHP_SELF'];?>" onsubmit="return validateForm()">
        <div id="form-errors">
            <?php
                session_start();
                if(isset($_SESSION['form_errors'])){
                    echo ' '.$_SESSION['form_errors'];
                    unset($_SESSION['form_errors']);
            }
                if(isset($_SESSION['user_exists'])){
                echo ' '.$_SESSION['user_exists'];
                unset($_SESSION['user_exists']);
            }

            ?>
        </div>
    <input type="text" name="first_name" placeholder="First Name"/><br><br>

    <input type="text" name="last_name" placeholder="Last Name"/><br><br>

        <input type="text" name="city_name" placeholder="City Name" /><br><br>

        <input type="text" name="username" placeholder="Username" /><br><br>

        <input type="password" name="password" placeholder="Password" /><br><br>

        <input type="submit" name="submit" value="Save"/><br><br>
        <a href="login.php">Login</a>

    </form>
</div>

</body>
</html>
<!------------------------------------------------HTML------------------------------------>

<?php

//DELETE FROM DB
if (isset($_POST['delete'])) {
    $id = $_POST['delete_id'];

    $dbConnector->query('DELETE FROM user WHERE id=:id');
    $dbConnector->bind(':id', $id);

    if ($dbConnector->execute()) {
        echo 'Deleted Successfully!';
    } else {
        echo 'Error deleting item';
    }
}


//RETRIEVE DATA FROM THE DB AND DISPLAY
    $dbConnector->query('SELECT * FROM user ORDER BY id DESC');
    $rows=$dbConnector->resultset();



    ?>
<!--DISPLAY USERS FROM DB-->
<h1>Users</h1>
<?php foreach ($rows as $row){?>
<div>
    <p>Name: <?php echo $row['first_name'].' '; echo $row['last_name'];?></p>
    <p>City Name: <?php echo $row['user_city'];?></p>

    <!--    DELETING FROM THE DB-->
    <form method="post" action="<?php $_SERVER['PHP_SELF'];?>">
        <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>"/>
        <input type="submit" name="delete" value="Delete"/>
    </form>

    <hr/>
    <?php };?>
</div>






