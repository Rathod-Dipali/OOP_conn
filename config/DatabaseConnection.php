<?php

    class DatabaseConnection
    {
        public $connection;

        public function __construct()
        {
            $this->connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE,'3377');

            if($this->connection->connect_error){
                die("<h3>Database Not Connected<h3>");
            }

            return $this->connection;
        }
    }

?>
