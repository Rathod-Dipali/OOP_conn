<?php
    
    include_once("../../config/config.php");  
    
    require ('../models/Admin_model.php');
    $register = new Admin_model;

    $result = [];

    if (isset($_POST['login_admin']) && $_POST['login_admin'] === 'login_admin') {        
        
        $email = mysqli_real_escape_string($db->connection, $_POST['login_email']);
        $password = mysqli_real_escape_string($db->connection, $_POST['login_password']);

        if (isset($_POST['remeber_me']) && $_POST['remeber_me'] === 'on') {

            setcookie('admin_email', $email, time() + (86400 * 30), "/");
            setcookie('admin_password', $password, time() + (86400 * 30), "/");

        }
        else{

            setcookie('admin_email', '', -1, '/');
            setcookie('admin_password', '', -1, '/');

        }

        $login_admin = $register->login_admin($email,$password);        
        
        if($login_admin && $login_admin['status'] == 1)
        {

            $_SESSION['admin_user_id'] = $login_admin['data']->id;
            $_SESSION['admin_user_name'] = $login_admin['data']->name;
            $_SESSION['user_image_name'] = $login_admin['data']->image;
            $_SESSION['login_success_message'] = 'Welcome ' . $login_admin['data']->name .', you have successfully logged in.';
            

            $result = [
                'status' => '1',
                'message' => $_SESSION['login_success_message'],
            ];

            echo json_encode($result);
            exit;
        }

        $result = [
            'status' => '0',
            'message' => 'Please enter correct email and password.'
        ];

        echo json_encode($result);
        exit;
        
    }

    if(isset($_POST['admin_logout']) && $_POST['admin_logout'] === 'admin_logout'){

        if (session_destroy()) {

            $_SESSION['logout_message'] = "Admin logout successfully.";

           $result = [
                'status' => '1',
                'message' => $_SESSION['logout_message'],
            ];

            echo json_encode($result);
            exit;

        }      

    }

    if (isset($_POST['insert_admin']) && $_POST['insert_admin'] === 'insert_admin') {        

        $name = mysqli_real_escape_string($db->connection, $_POST['name']);
        $email = mysqli_real_escape_string($db->connection, $_POST['email']);
        $mobile = mysqli_real_escape_string($db->connection, $_POST['mobile']);
        $image = mysqli_real_escape_string($db->connection, $_FILES['image']['name']);
        $password = mysqli_real_escape_string($db->connection, $_POST['password']);

        $path = "../../assets/upload/" . $image;
        $tmp_file = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp_file, $path);

        $is_admin_exsist = $register->isAdminExsist($email);

        if($is_admin_exsist)
        {
            $result = [
                'status' => '0',
                'message' => 'Email is already exsist.'
            ];

            echo json_encode($result);
            exit;
        }

        $registration = $register->registration($name,$email,$mobile,$image,$password);
        if($registration){
            $result = [
                'status' => '1',
                'message' => 'Registration successfully done.'
            ];

            echo json_encode($result);
            exit;
        }

        $result = [
            'status' => '0',
            'message' => 'Something went wrong.'
        ];

        echo json_encode($result);
        exit;
    }

    if (isset($_POST['change_password']) && $_POST['change_password'] === 'change_password') {        
        
        $old_password = mysqli_real_escape_string($db->connection, $_POST['old_password']);
        $new_password = mysqli_real_escape_string($db->connection, $_POST['new_password']);

        $isOldPassword = $register->isOldPassword($old_password);        

        if($isOldPassword)
        {
            $result = [
                'status' => '0',
                'message' => 'Please enter correct old password.'
            ];

            echo json_encode($result);
            exit;
        }

        $change_password = $register->change_password($new_password);
        
        if($change_password){
            $result = [
                'status' => '1',
                'message' => 'Password change successfully done.'
            ];

            echo json_encode($result);
            exit;
        }

        $result = [
            'status' => '0',
            'message' => 'Password not change yet!'
        ];

        echo json_encode($result);
        exit;
    }

    if (isset($_POST['update_admin']) && $_POST['update_admin'] === 'update_admin') {
        
        $id = mysqli_real_escape_string($db->connection, $_POST['id']);
        $name = mysqli_real_escape_string($db->connection, $_POST['name']);
        $email = mysqli_real_escape_string($db->connection, $_POST['email']);
        $mobile = mysqli_real_escape_string($db->connection, $_POST['mobile']);
        $image = mysqli_real_escape_string($db->connection, $_FILES['image']['name']);

        $path = "../../assets/upload/" . $image;
        $tmp_file = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp_file, $path);

        $update_profile = $register->update_profile($id,$name,$email,$mobile,$image);
        
        if($update_profile){
            $result = [
                'status' => '1',
                'message' => 'Profile updated successfully done.'
            ];

            echo json_encode($result);
            exit;
        }

        $result = [
            'status' => '0',
            'message' => 'Email is already exsist.'
        ];

        echo json_encode($result);
        exit;
    }

    if (isset($_POST['admin_delete']) && $_POST['admin_delete'] === 'admin_delete') {        
        
        $delete_id = mysqli_real_escape_string($db->connection, $_POST['id']);

        $delete_admin = $register->delete_admin($delete_id);                

        if($delete_admin)
        {
            $result = [
                'status' => '1',
                'message' => 'Admin deleted successfully done.'
            ];

            echo json_encode($result);
            exit;
        }

        $result = [
            'status' => '0',
            'message' => 'Admin not deleted!.'
        ];

        echo json_encode($result);
        exit;
    }

?>
