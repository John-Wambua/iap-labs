<?php
include 'Interfaces/Authenticator.php';
include_once 'DBConnector.php';

class User implements Authenticator{

    private $first_name;
    private $last_name;
    private $city_name;

    private $username;
    private $password;

//    function __construct ($first_name,$last_name,$city_name,$username,$password)
//    {
//        $this->first_name=$first_name;
//        $this->last_name=$last_name;
//        $this->city_name=$city_name;
//        $this->username=$username;
//        $this->password=$password;
//    }
    public function setFname($fName){
        $this->first_name=$fName;
    }

    public function getFname(){
        return $this->first_name;
    }

    public function setLname($lName){
        $this->last_name=$lName;
    }

    public function getLname(){
        return $this->last_name;
    }

    public function setCityName($cName){
        $this->city_name=$cName;
    }

    public function getCityName(){
        return $this->city_name;
    }

    public function setUsername($username){
        $this->username=$username;
    }
    public function getUsername(){
        return $this->username;
    }


    public function setPassword($password){
        $this->password=$password;
    }
    public function getPassword(){
        return $this->password;
    }

    public function validateForm(){
        if($this->getFname()==''||$this->getLname()==''||$this->getCityName()==''||$this->getUsername()==''||$this->getPassword()==''){
            return false;
        }
        return true;
    }
    public function createFormErrorSessions(){
        session_start();
        $_SESSION['form_errors']='All fields are required!';
    }

    public function hashPassword(){
        $this->password=password_hash($this->getPassword(),PASSWORD_DEFAULT);
        return $this->password;
    }
    public function isPasswordCorrect(){
        return null;
    }
    public function login(){
       header('Location:private_page.php');
    }

    public function createUserSession(){
        session_start();
        $_SESSION['username']=$this->getUsername();
    }
    public function logout(){
       session_start();
       unset($_SESSION['username']);
       session_destroy();
       header('Location:lab1.php');
    }
//    public function isUserExist(){
//        $dbConnector=new DBConnector;
//        if($dbConnector->single()>0){
//            return true;
//        }
//        return false;
//    }
    public function createUserExistsSession(){
        session_start();
        $_SESSION['user_exists']='The username is already taken!';
    }

}
