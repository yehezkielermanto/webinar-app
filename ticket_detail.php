<?php
require __DIR__ . "/middleware/AuthMiddleware.php";
AuthMiddleware::check();

require __DIR__ . "/controller/SupportController.php";

if ($_SESSION['user']['role'] !== 'ADMIN') {
    header('Location: homepage.php');
}

if (isset($_POST['ticket'])) {
    header('Location: ticket.php');
}

$supportController = new SupportController();

if (isset($_GET['id'])) {
    $support = $supportController->getbyId($_GET['id']);
}

if (isset($_POST['submit'])) {
    $data = [
        "id" => $_GET['id'],
        "subject" => $_POST['subject'],
        "description" => $_POST['description'],
        "reported_email" => $support["data"]["reported_email"],
        "status" => "SOLVED",
    ];

    
    $result = $supportController->update($data);

    if ($result['success']) {

        echo "<script>alert('Support ticket updated successfully');</script>";

    } else {
        
        echo "<script>alert('Failed to update support ticket');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Ticket</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>

    <div class="container w-50 my-3">

        <div class="row">

            <div class="col-12">
                <!-- CAN CREATE COMPONENT FOR NAVIGATION -->
                <form method="post">
                    <button type="submit" name="ticket" class="btn btn-link">
                        Back
                    </button>
                </form>
            </div>

            <div class="col-12 mb-3">
                <h1 class="text-center">Ticket <?= $_GET["id"] ?></h1>
            </div>

            <div class="col-12">

                <div class="card mx-auto">
                    <div class="card-body">
                        <!-- SUBJECT -->
                        <h5 class="card-title"><?= $support["data"]["subject"] ?></h5>
                        <!-- TYPE -->
                        <p class="card-text"><?= $support["data"]["type"] ?></p>
                        <!-- DESCRIPTION -->
                        <p class="card-text"><?= $support["data"]["description"] ?></p>
                        <!-- FROM -->
                        <p class="card-text"><?= $support["data"]["reported_email"] ?></p>
                    </div>
                </div>

            </div>

            <div class="col-12">

                <div class="card mx-auto mt-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Reply</h5>
                        <form method="post">

                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Answer</label>
                                <textarea class="form-control" id="reply" name="description" rows="3"></textarea>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>

</body>

</html>