<?php
session_start();

class AuthMiddleware
{
    public static function check()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: login.php');
            exit();
        }
    }
}
?>