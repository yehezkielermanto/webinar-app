<?php
require_once __DIR__ . "/middleware/AuthMiddleware.php";
AuthMiddleware::check();

require_once __DIR__ . "/controller/SupportController.php";

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
}

if (isset($_POST['support'])) {
    header('Location: support.php');
}

if (isset($_POST['home'])) {
    header('Location: homepage.php');
}

if (isset($_POST['my_ticket'])) {
    header('Location: myticket.php');
}

if (isset($_POST['ticket'])) {
    header('Location: ticket.php');
}

$userId = $_SESSION['user']['id'];

$supportController = new SupportController();
$supports = $supportController->list($userId);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Ticket</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>

    <div class="container w-50 my-3">

        <div class="row">
            <div class="col-12">
                <!-- CAN CREATE COMPONENT FOR NAVIGATION -->
                <form method="post">
                    <button type="submit" name="logout" class="btn btn-link">
                        Logout
                    </button>
                    <button type="submit" name="home" class="btn btn-link">
                        Home
                    </button>
                    <button type="submit" name="support" class="btn btn-link">
                        Support
                    </button>
                    <button type="submit" name="my_ticket" class="btn btn-link">
                        My Ticket
                    </button>

                    <?php if ($_SESSION['user']['role'] === 'ADMIN') : ?>
                        <button type="submit" name="ticket" class="btn btn-link">
                            Ticket
                        </button>
                    <?php endif; ?>
                </form>
            </div>

            <div class="col-12 mb-3">
                <h1 class="text-center">My Ticket</h1>
            </div>

            <!-- CARD SECTION -->
            <div class="row">
                <div class="col-12 d-flex flex-wrap justify-content-between">

                    <!-- CHECK RESPONSE SUCCESSFULLY -->
                    <?php if ($supports["success"]) : ?>

                        <!-- CHECK DATA TICKET -->
                        <?php if (count($supports["data"]) > 0) : ?>

                            <!-- ITERATE TICKET -->
                            <?php foreach ($supports["data"] as $support) : ?>
                                <div class="card m-2" style="width: 20rem;">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= "Ticket#" . $support["id"] ?></h5>
                                        <h6 class="card-subtitle mb-2 text-body-secondary"><?= $support["subject"] ?></h6>

                                        <?php if ($support["status"] == "PENDING") : ?>
                                            <span class="badge bg-warning text-light">Pending</span>
                                        <?php endif; ?>

                                        <?php if ($support["status"] == "SOLVED") : ?>
                                            <span class="badge bg-success text-light">Solved</span>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            <?php endforeach; ?>

                        <?php else : ?>

                            <div class="alert alert-info w-100" role="alert">
                                No ticket found
                            </div>

                        <?php endif; ?>

                    <?php else : ?>

                        <div class="alert alert-danger w-100" role="alert">
                            <?= $supports["message"] ?>
                        </div>

                    <?php endif; ?>

                </div>
            </div>
        </div>

    </div>

</body>

</html>