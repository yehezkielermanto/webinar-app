<?php
require __DIR__ . "/middleware/AuthMiddleware.php";
AuthMiddleware::check();

require __DIR__ . "/controller/SupportController.php";

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



$supportController = new SupportController();

if (isset($_GET['id'])) {
    $support = $supportController->getbyId($_GET['id']);
}

if (isset($_POST['change_status'])) {
    $data = [
        "id" => $_GET['id'],
        "status" => $_POST['status'],
    ];

    $result = $supportController->updateStatus($data);

    if ($result['success']) {

        echo "<script>alert('Support ticket updated successfully');</script>";
    } else {

        echo "<script>alert('Failed to update support ticket');</script>";
    }
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

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=menu" />


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
                        <span class="mx-2 h6">Ticket Detail</span>
                    </li>
                </ul>

                <form action="" method="post">

                    <span class="navbar-text" style="color: white;">
                        <ul class="navbar-nav me-auto mx-2 mb-2 mb-lg-0">
                            <li class="nav-item">
                                <button type="submit" name="home" class="nav-link">
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
                                    <button type="submit" name="ticket" class="nav-link active">
                                        <h6 class="text-white">
                                            Ticket
                                        </h6>
                                    </button>
                                <?php endif; ?>
                            </li>

                            <li class="nav-item">
                                <?php if ($_SESSION['user']['role'] === 'ADMIN') : ?>
                                    <button type="submit" name="event_register" class="nav-link">
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

        <div class="row justify-content-center">

            <h1 class="text-center my-5">Ticket <?= $_GET["id"] ?></h1>

            <div class="col-12 col-lg-6">

                <div class="card mx-auto">
                    <div class="card-body">
                        <!-- SUBJECT -->
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 fw-semibold">Subject: <?= $support["data"]["subject"] ?></span>

                            <span class="">
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
                            </span>
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
                        <!-- FROM -->
                        <p class="card-text">
                            <span class="h6">From: </span><?= $support["data"]["reported_email"] ?>
                        </p>
                    </div>
                </div>

                <!-- CHANGE STATUS -->
                <div class="card mx-auto mt-3">

                    <div class="card-body">

                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Change Status
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <form method="post">

                                            <div class="mb-3">

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="status" id="status" value="Solved" required>
                                                    <label class="form-check-label" for="status">
                                                        Solved
                                                    </label>
                                                </div>

                                            </div>

                                            <div class="d-flex flex-row-reverse">
                                                <button type="submit" name="change_status" class="btn text-white" style="background-color: #b7a3e8;">Change Status</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <!-- FORM REPLY -->
                <div class="card mx-auto mt-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Reply</h5>
                        <form method="post">

                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" required placeholder="Subject email">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Answer</label>
                                <textarea class="form-control" id="reply" name="description" rows="3" required placeholder="Description"></textarea>
                            </div>

                            <div class="d-flex flex-row-reverse">
                                <button type="submit" name="submit" class="btn text-white"style=" background-color: #b7a3e8;">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>


            </div>
        </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>

</html>