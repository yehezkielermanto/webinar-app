<?php

session_start();

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>

    <div class="container w-50 my-3">
        <div class="row">
            <div class="col-12">
                <form method="post">
                    <button type="submit" name="logout" class="btn btn-link">
                        Logout
                    </button>
                    <button type="submit" name="support" class="btn btn-link">
                        Support
                    </button>
                </form>
            </div>

            <div class="col-12">
                <h1 class="text-center">Homepage</h1>
            </div>
        </div>
    </div>

</body>

</html>