<?php

    session_start();

    define('DB_HOST','localhost');
    define('DB_USER','root');
    define('DB_PASSWORD','');
    define('DB_DATABASE','oop_con');
    define('SITE_URL','http://localhost/OOP_Conn/');

    include_once('DatabaseConnection.php');
    $db = new DatabaseConnection;

    function base_url($file_name)
    {
        echo SITE_URL.$file_name;
    }

    function redirect($message,$page)
    {

        $redirectTo = SITE_URL.$page;
        $_SESSION['error_message'] = "$message";
        header("Location: $redirectTo");
        exit(0);
        
    }

?>
