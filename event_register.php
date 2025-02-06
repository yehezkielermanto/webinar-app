<?php

require_once __DIR__ . "/middleware/AuthMiddleware.php";
AuthMiddleware::check();

require_once __DIR__ . "/controller/EventController.php";

if ($_SESSION['user']['role'] !== 'ADMIN') {
    header('Location: /webinar-app/beranda.php');
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
}

if (isset($_POST['support'])) {
    header('Location: support.php');
}

if (isset($_POST['home'])) {
    header('Location: /webinar-app/beranda.php');
}

if (isset($_POST['my_ticket'])) {
    header('Location: myticket.php');
}

if (isset($_POST['ticket'])) {
    header('Location: ticket.php');
}

if (isset($_POST['event_register'])) {
    header('Location: event_register.php');
}

/**
 * Get all events
 */
$eventController = new EventController();
$events = $eventController->get();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Webinar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=menu" />

    <style>
        .card-hover:hover {
            box-shadow: 0 0 10px rgba(183, 163, 232, 0.8);
            transition: 0.3s;
            transition-timing-function: ease-in-out;
        }
    </style>

</head>

<body>


    <!-- NEW NAVBAR -->
    <nav class="navbar navbar-expand-lg " style="background-color: #b7a3e8; color: white;">
        <div class="container-fluid">
            <img src="./images/logo_if.png" alt="Logo" width="40" height="24" class="mx-2 d-inline-block align-text-top">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <span class="mx-2 h6">Event Register</span>
                    </li>
                </ul>

                <form action="" method="post">

                    <span class="navbar-text" style="color: white;">
                        <ul class="navbar-nav me-auto mx-2 mb-2 mb-lg-0">
                            <li class="nav-item">
                                <button type="submit" name="home" class="nav-link active">
                                    <h6 class="text-white">
                                        Home
                                    </h6>
                                </button>
                            </li>

                            <li class="nav-item">
                                <button type="submit" name="support" class="nav-link">
                                    <h6 class="text-white">
                                        Support
                                    </h6>
                                </button>
                            </li>

                            <li class="nav-item">
                                <button type="submit" name="my_ticket" class="nav-link">
                                    <h6 class="text-white">
                                        My Ticket
                                    </h6>
                                </button>
                            </li>

                            <li class="nav-item">
                                <?php if ($_SESSION['user']['role'] === 'ADMIN') : ?>
                                    <button type="submit" name="ticket" class="nav-link">
                                        <h6 class="text-white">
                                            Ticket
                                        </h6>
                                    </button>
                                <?php endif; ?>
                            </li>

                            <li class="nav-item">
                                <?php if ($_SESSION['user']['role'] === 'ADMIN') : ?>
                                    <button type="submit" name="event_register" class="nav-link active">
                                        <h6 class="text-white">
                                            Event Register
                                        </h6>
                                    </button>
                                <?php endif; ?>
                            </li>

                        </ul>
                    </span>

                </form>

            </div>
        </div>
    </nav>


    <div class="container my-3">
        <!-- CARD SECTION -->
        <div class="row justify-content-center">

            <h1 class="text-center my-5">Register Webinar</h1>

            <div class="col-12 col-lg-6">

                <?php if ($events['success']) : ?>

                    <?php if (count($events['data']) > 0) : ?>

                        <?php foreach ($events['data'] as $event) : ?>

                            <?php if (!$event['published']) : ?>

                                <div class="card card-hover m-2">
                                    <div class="card-body">
                                        <p class="fw-bolder fs-4"><?= $event["title"] ?></p>
                                        <h6 class="card-subtitle mb-2 text-body-secondary"><?= $event["description"] ?></h6>

                                        <a href="event_register_detail.php?id=<?= $event["id"] ?>" class="text-decoration-none">Read more</a>

                                    </div>
                                </div>

                            <?php else : ?>

                                <div class="alert alert-info w-100" role="alert">
                                    All webinar has been published
                                </div>


                            <?php endif; ?>

                        <?php endforeach; ?>

                    <?php else : ?>

                        <div class="alert alert-info w-100" role="alert">
                            No ticket found
                        </div>

                    <?php endif; ?>

                <?php endif; ?>

            </div>

        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>