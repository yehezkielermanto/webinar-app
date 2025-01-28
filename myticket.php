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

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=menu" />


</head>

<body>

    <!-- NAVBAR | CAN IMPROVE WITH COMPONENT -->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <div class="">

                <button class="btn btn-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                    <span class="material-symbols-outlined">
                        menu
                    </span>
                </button>

                <img src="./images/logo_if.png" alt="Logo" width="40" height="24" class="d-inline-block align-text-top">


                <span class="mx-2 h6">My Ticket</span>

            </div>
        </div>
    </nav>

    <div class="col-12">
        <h1 class="text-center my-5">My Ticket</h1>
    </div>

    <div class="container w-50 my-3">

        <!-- CARD SECTION -->
        <div class="row mx-3">
            <div class="col-12 d-flex flex-wrap justify-content-between">

                <!-- CHECK RESPONSE SUCCESSFULLY -->
                <?php if ($supports["success"]) : ?>

                    <!-- CHECK DATA TICKET -->
                    <?php if (count($supports["data"]) > 0) : ?>

                        <!-- ITERATE TICKET -->
                        <?php foreach ($supports["data"] as $support) : ?>
                            <div class="card m-2 w-100">
                                <div class="card-body">
                                    <h5 class="card-title"><?= "Ticket#" . $support["id"] ?></h5>
                                    <h6 class="card-subtitle mb-2 text-body-secondary"><?= $support["subject"] ?></h6>

                                    <a href="user_ticket_detail.php?id=<?= $support["id"] ?>" class="card-link">See Detail</a>

                                    <div class="col mt-2">

                                        <?php if ($support["status"] == "PENDING") : ?>
                                            <span class="badge bg-warning text-light">Pending</span>
                                        <?php endif; ?>

                                        <?php if ($support["status"] == "SOLVED") : ?>
                                            <span class="badge bg-success text-light">Solved</span>
                                        <?php endif; ?>

                                    </div>

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

    <!-- NAVIGATION | CAN IMPROVE WITH COMPONENT -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h4 class="offcanvas-title" id="offcanvasExampleLabel">Webinar UKDC</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body ms-3">
            <form method="post">
                <div class="mb-3">
                    <button type="submit" name="home" class="nav-link">
                        <h5>
                            Home
                        </h5>
                    </button>
                </div>

                <div class="mb-3">
                    <button type="submit" name="support" class="nav-link">
                        <h5>
                            Support
                        </h5>
                    </button>
                </div>

                <div class="mb-3">
                    <button type="submit" name="my_ticket" class="nav-link">
                        <h5>
                            My Ticket
                        </h5>
                    </button>
                </div>

                <div class="mb-3">
                    <?php if ($_SESSION['user']['role'] === 'ADMIN') : ?>
                        <button type="submit" name="ticket" class="nav-link">
                            <h5>
                                Ticket
                            </h5>
                        </button>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <button type="submit" name="logout" class="nav-link">
                        <h5>
                            Logout
                        </h5>
                    </button>
                </div>


            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>

</html>