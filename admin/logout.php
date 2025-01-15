<?php
// session start
session_start();

// hilangkan session yang sudah diset
unset($_SESSION['id_user']);
unset($_SESSION['user']);
unset($_SESSION['pass']);

session_destroy();

header('location:login.php');
