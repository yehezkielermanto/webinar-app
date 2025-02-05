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

                <span class="h6 mx-2">Register Webinar</span>

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
                        <button type="submit" name="event_register" class="nav-link">
                            <h5>
                                Register Webinar
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