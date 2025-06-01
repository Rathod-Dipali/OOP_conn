<?php

class Admin_model
{
    public $connection;
    public function __construct()
    {

        $db = new DatabaseConnection;
        $this->connection = $db->connection;
    }

    public function login_admin($email, $password)
    {
        $query = "SELECT * from `admin` where `email`='$email' and `password`='$password' and `is_deleted`=0 LIMIT 1";
        $result = $this->connection->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_object();
            
            return [
                'status' => true,
                'data' => $row
            ];
        }

        return false;
    }

    public function isAdminExsist($email)
    {

        $check_user = "SELECT email from admin WHERE email='$email' and `is_deleted`=0 LIMIT 1";
        $result = $this->connection->query($check_user);

        if ($result && $result->num_rows > 0) {
            return true;
        }

        return false;
    }

    public function registration($name, $email, $mobile, $image, $password)
    {

        $query = "INSERT INTO admin (name,email,mobile,image,password,is_deleted) values ('$name','$email','$mobile','$image','$password',0)";
        $result = $this->connection->query($query);
        return $result;
    }

    public function isOldPassword($old_password)
    {

        $check_user = "SELECT `password` from admin WHERE `password`='$old_password' and `id`='$_SESSION[admin_user_id]' and `is_deleted`=0 LIMIT 1";        
        $result = $this->connection->query($check_user);            

        if ($result && $result->num_rows > 0) {
            return false;
        }

        return true;
    }

    public function change_password($new_password)
    {        
        $query = "UPDATE admin SET `password`='$new_password' WHERE `id`='$_SESSION[admin_user_id]'";        
        $result = $this->connection->query($query);        
        return $result;
    }

    public function auth_detail()
    {
        $query = "SELECT * from admin where `id`='$_SESSION[admin_user_id]' and `is_deleted`=0";
        $result = $this->connection->query($query);
        if($result && $result->num_rows > 0)
        {
            $data = $result->fetch_assoc();
            return $data;
        }
        return false;
    }

    public function update_profile($id,$name,$email,$mobile,$image)
    {
        $query = "SELECT * from admin where `id` != '$id' and `is_deleted`= 0 and `email`='$email'";
        $result = $this->connection->query($query);        
        
        if($result && $result->num_rows > 0)
        {
            return false;
        }
        $query = "UPDATE admin SET `name`='$name',`email`='$email',`mobile`='$mobile',`image`='$image' WHERE `id`='$_SESSION[admin_user_id]'";        
        $result = $this->connection->query($query);        
        return $result;
    }

    public function delete_admin($delete_id)
    {
        $query = "UPDATE admin SET `is_deleted`=1  WHERE `id`='$delete_id'";        
        $result = $this->connection->query($query);        
        return $result;
    }
    
}

?>
