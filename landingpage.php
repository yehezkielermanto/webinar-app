<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Login Portal</h1>
            </div>
        </div>
        
        <form action="" method="get">
            <div class="row gap-2">
                <div class="col-12 text-center">
                    <button class="btn btn-primary" name="login">Masuk</button>
                </div>

                <div class="col-12 text-center">
                    <button class="btn btn-secondary" name="register">Daftar</button>
                </div>
            </div>
        </form>
    </div>
    
    
</body>

</html>

<?php

session_start();

if (isset($_GET['login'])) {
    header('Location: login.php');
}

if (isset($_GET['register'])) {
    header('Location: register.php');
}

?>