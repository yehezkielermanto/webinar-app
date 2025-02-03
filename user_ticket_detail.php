<?php
require __DIR__ . "/middleware/AuthMiddleware.php";
AuthMiddleware::check();

require __DIR__ . "/controller/SupportController.php";

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

if (isset($_POST['event_cordinator'])) {
    header('Location: koordinator/event_list.php');
}


$supportController = new SupportController();

if (isset($_GET['id'])) {
    $support = $supportController->getbyId($_GET['id']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Ticket Detail</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=menu" />

</head>

<body>

    <!-- NAVBAR | CAN IMPROVE WITH COMPONENT -->
    <nav class="navbar bg-body-tertiary sticky-sm-top">
        <div class="container-fluid">
            <div class="">

                <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                    <span class="material-symbols-outlined">
                        menu
                    </span>
                </button>

                <img src="./images/logo_if.png" alt="Logo" width="40" height="24" class="d-inline-block align-text-top">

                <span class="h6 mx-2">Ticket Detail</span>

            </div>
        </div>
    </nav>

    <div class="container my-3">

        <div class="row justify-content-center">

            <h1 class="text-center my-5">Ticket <?= $_GET["id"] ?></h1>

            <div class="col-12 col-lg-6">

                <div class="card mx-auto">
                    <div class="card-body">
                        <!-- SUBJECT -->
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="h5 fw-semibold">Subject: <?= $support["data"]["subject"] ?></p>

                            <p class="text-muted">
                                <?php
                                $date = new DateTime();
                                $dateTicket = new DateTime($support["data"]["created_at"], new DateTimeZone('Asia/Jakarta'));

                                $interval = $date->diff($dateTicket);

                                $formatClock = $interval->d > 1 ? $dateTicket->format('D, d M Y, h:i A') : $dateTicket->format('h:i A');

                                switch ($interval) {
                                    case $interval->m > 1:
                                        echo $formatClock;
                                        break;
                                    case $interval->d > 1 && $interval->d < 7:
                                        echo $formatClock . " " . $interval->format('(%d days ago)');
                                        break;
                                    case $interval->d == 1:
                                        echo $formatClock . " " . $interval->format('(%d day ago)');
                                        break;
                                    case $interval->h > 1:
                                        echo $formatClock . " " . $interval->format('(%h hours ago)');
                                        break;
                                    case $interval->h == 1:
                                        echo $formatClock . " " . $interval->format('(%h hour ago)');
                                        break;
                                    default:
                                        echo $formatClock . " " . $interval->format('(%d days %H hours ago)');
                                        break;
                                }
                                ?>
                            </p>
                        </div>
                        <!-- TYPE -->
                        <p class="card-text">
                            <?php if ($support["data"]["type"] === "SUPPORT") : ?>
                                <span class="badge bg-secondary">Support</span>
                            <?php else : ?>
                                <span class="badge bg-secondary">Question</span>
                            <?php endif; ?>
                        </p>
                        <!-- DESCRIPTION -->
                        <p class="card-text"><?= $support["data"]["description"] ?></p>
                    </div>
                </div>

                <div class="card mx-auto mt-3">
                    <div class="card-body">

                        <h6 class="card-title">
                            Answer
                        </h6>

                        <div class="mb-3">
                            <?php if ($support["data"]["status"] == "PENDING") : ?>
                                <span class="badge bg-warning text-light">Pending</span>
                            <?php endif; ?>

                            <?php if ($support["data"]["status"] == "SOLVED") : ?>
                                <span class="badge bg-success text-light">Solved</span>
                            <?php endif; ?>
                        </div>

                        <?php if ($support["data"]["answer"] !== null) : ?>

                            <p class="card-text"><?= $support["data"]["answer"] ?></p>

                        <?php else : ?>

                            <p class="card-text">No answer yet</p>

                        <?php endif; ?>
                    </div>
                </div>

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
                    <?php if ($_SESSION['user']['role'] === 'ADMIN') : ?>
                        <button type="submit" name="event_cordinator" class="nav-link">
                            <h5>
                                Event Cordinator
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