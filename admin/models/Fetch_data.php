<?php

    class Fetch_data
    {
        public $connection;
        public function __construct()
        {

            $db = new DatabaseConnection;
            $this->connection = $db->connection;
        }

        public function auth_detail($id)
        {
            $query = "SELECT * from admin where `id`='$id' and `is_deleted`=0";
            $result = $this->connection->query($query);
            if($result && $result->num_rows > 0)
            {
                $data = $result->fetch_assoc();
                return $data;
            }
            return false;
        }

        public function all_admin_data(){
            $query = "SELECT * from admin WHERE `is_deleted`=0";
            $result = $this->connection->query($query);
            if($result && $result->num_rows > 0)
            {
                $data = [];
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }

                return $data;
            }
            return false;
        }
    }

    $fetch_data = new Fetch_data;

?>
