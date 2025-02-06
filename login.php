<?php
session_start();

require_once __DIR__ . "/controller/UserController.php";

if (isset($_SESSION['user'])) {
    header('Location: beranda.php');
}


if (isset($_POST['login'])) {

    $userController = new UserController();

    $data = [
        'username' => $_POST['username'],
        'password' => $_POST['password']
    ];

    echo password_hash($data['password'], PASSWORD_DEFAULT);

    $result = $userController->login($data);

    if ($result['success']) {

        $_SESSION['user'] = $result['data'];

        // we need this because the old component need this
        // session to function.
        $_SESSION['user_id'] = $_SESSION['user']['id'];
        $_SESSION['fullname'] = $_SESSION['user']['fullname'];
        $_SESSION['email'] = $_SESSION['user']['email'];
        $_SESSION['nama_lengkap'] = $_SESSION['user']['fullname'];
        $_SESSION['email'] = $_SESSION['user']['email'];
        $_SESSION['phone'] = $_SESSION['user']['phone'];
        $_SESSION['gender'] = $_SESSION['user']['gender'];
        $_SESSION['address'] = $_SESSION['user']['address'];
        $_SESSION['institution'] = $_SESSION['user']['institution'];
        $_SESSION['pfp'] = $_SESSION['user']['pfp_path'];
        $_SESSION['is_admin'] = $_SESSION['user']['role'] == 'ADMIN' ? true : false;
        header('Location: beranda.php');
    } else {

        echo "<script>alert('" . $result['message'] . "');</script>";
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

    <div class="container mt-3 mb-3">

        <div class="col-12 col-md-6 mx-auto mt-5 text-center">
            <img src="./images/logo_if.png" alt="Logo" width="90" height="49" class="d-inline-block align-text-top">
        </div>

        <div class="col-12 col-md-6 mx-auto mt-5 mb-4">
            <h4 class="text-center fw-normal">Sign In to Webinar UKDC</h4>
        </div>

        <div class="row justify-content-center mx-auto" style="max-width: 48rem;">
            <div class="col-12 col-lg-6">

                <div class="card mb-3">
                    <div class="card-body">

                        <form method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control-sm form-control" id="username" aria-describedby="emailHelp" name="username">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control-sm form-control" id="password" name="password">
                            </div>

                            <div class="d-grid">
                                <button type="submit" name="login" class="btn btn-sm text-white" style="background-color:  #b7a3e8;" >Login</button>
                            </div>
                        </form>

                    </div>
                </div>

                <div class="card text-center">
                    <div class="card-body d-flex justify-content-center align-items-center">

                        New to Webinar UKDC? <a href="register.php" class="text-decoration-none px-1">Create an account</a>

                    </div>
                </div>

            </div>
        </div>

    </div>

</body>

</html>
