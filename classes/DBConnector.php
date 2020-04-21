<?php
    class DBConnector{
        private $host='localhost';
        private $user='root';
        private $pass='';
        private $dbname='btc3205';

        private $dbh;
        private $error;
        private $stmt;

        public function __construct()
        {
            //SET DSN
            $dsn="mysql:host=$this->host;dbname=$this->dbname";

            //Set options
            $options=array(PDO::ATTR_PERSISTENT=>true, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);

            //Create new PDO
            try{
                $this->dbh=new PDO($dsn,$this->user,$this->pass,$options);
            }catch (PDOException $e){
                $this->error=$e->getMessage();
            }
        }
        //FETCHING DATA FROM THE DATABASE

        //query fn
        public function query($query){
            $this->stmt=$this->dbh->prepare($query);
        }

        //bind fn to bind our data
        //--Sets conditions for the selected data e.g where id=1

        public function bind($param,$value,$type=null){
            if (is_null($type)){
                switch (true){
                    case is_int($value):
                        $type=PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type=PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type=PDO::PARAM_NULL;
                        break;
                    default:
                        $type=PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param,$value,$type);
        }
        public function execute(){
            return $this->stmt->execute();
        }
        //To check if data was inserted to the DB
        public function lastInsertId(){
            $this->dbh->lastInsertId();
        }

        //Fetch data from the DB in form of an assotiative array
        public function resultset(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }