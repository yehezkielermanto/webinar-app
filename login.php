<?php
session_start();

require_once __DIR__ . "/controller/UserController.php";

if (isset($_SESSION['user'])) {
    header('Location: homepage.php');
}


if (isset($_POST['login'])) {

    $userController = new UserController();

    $data = [
        'username' => $_POST['username'],
        'password' => $_POST['password']
    ];

    $result = $userController->login($data);

    if ($result === "Username or password is wrong") {

        echo "<script>alert('Username or password is wrong');</script>";

    } else if ($result) {
        
        $_SESSION['user'] = $result;

        header('Location: homepage.php');
        
    } else if (!$result) {
        echo "<script>alert('Error logging in');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>

    <div class="container w-50 mt-3 mb-3">

        <div class="row">
            <div class="col-12">
                <a href="register.php">Register</a>
            </div>

            <div class="col-12">
                <h1 class="text-center">Login</h1>
            </div>
        </div>

        <form method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" aria-describedby="emailHelp" name="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <button type="submit" name="login" class="btn btn-primary">Login</button>
        </form>

    </div>

</body>

</html>