<?php
require 'classes/DBConnector.php';
$dbConnector=new DBConnector;

$post=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

//Inserting into the DB
if(isset($post['submit'])){
    $fName=$post['first_name'];
    $lName=$post['last_name'];
    $cityName=$post['city_name'];

    $dbConnector->query('INSERT INTO user(first_name,last_name,user_city) VALUES(:fname,:lname,:cname)');
    $dbConnector->bind(':fname',$fName);
    $dbConnector->bind(':lname',$lName);
    $dbConnector->bind(':cname',$cityName);

    if($dbConnector->execute()){
        echo '<p>Save operation was successful!</p>';
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
    <title>Lab1</title>
    </head>
<body>
<div class="container ">
    <h2>Enter Details</h2>
    <form method="post" action="<?php $_SERVER['PHP_SELF'];?>">
    <input type="text" name="first_name" placeholder="First Name"/><br><br>

    <input type="text" name="last_name" placeholder="Last Name"/><br><br>

        <input type="text" name="city_name" placeholder="City Name" /><br><br>

        <input type="submit" name="submit" value="Save"/>
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






