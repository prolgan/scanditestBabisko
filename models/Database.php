<?php
    Class DBase{
        private $db_ip = "";
        private $login = "";
        private $psw = '';
        private $db_name="";

        public $connection;

        function conncect(){
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $this->connection = mysqli_connect($this->db_ip,$this->login,$this->psw,$this->db_name) or die(mysqli_error($this->connection));
        }

        function __construct(){
            $this->conncect();
        }
    }

    
?>