<?php

require_once __DIR__ . "/controller/UserController.php";

session_start();

// Check if the user is already logged in
if (isset($_POST['registration'])) {

    $userController = new UserController();

    // Data to be sent to the controller
    $data = [
        'fullname' => $_POST['fullname'],
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'gender' => $_POST['gender'],
        'phone' => $_POST['phone'],
        'institution' => $_POST['institution'],
        'address' => $_POST['address']
    ];

    // Call the register function from the controller
    $result = $userController->register($data);

    // Check the result
    if ($result['success']) {
        echo "<script>alert('User created successfully');</script>";
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
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <div class="container w-50 mt-3 mb-3">

        <div class="row">
            <div class="col-12">
                <a href="login.php">Login</a>
            </div>

            <div class="col-12">
                <h1 class="text-center">Register</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12 ">
                <!-- FORM SECTION -->
                <form method="post">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Fullname</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" required>
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="gender" value="MALE" required>
                            <label class="form-check-label" for="gender">
                                Male
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="gender" value="FEMALE" required>
                            <label class="form-check-label" for="gender">
                                Female
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="institution" class="form-label">Institution</label>
                        <input type="text" class="form-control" id="institution" name="institution" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>

                    <button type="submit" name="registration" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>

    </div>

</body>

</html>