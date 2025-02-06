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


if (isset($_POST['send_ticket'])) {
    $supportController = new SupportController();

    // Check if attachment file is uploaded
    // Set attachment to null if not uploaded
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {

        // Can change with specific file size
        // Check if file size is larger than 2MB
        if ($_FILES['attachment']['size'] > 2097152) {
            echo "<script>alert('File size too large'); window.history.back();</script>";
            exit;
        }


        // Can change with specific file type
        // Check if file type is not allowed
        $allowed_types = ['image/png', 'image/jpg', 'image/jpeg'];

        if (!in_array($_FILES['attachment']['type'], $allowed_types)) {
            echo "<script>alert('File type not allowed'); window.history.back();</script>";
            exit;
        }

        $attachment = $_FILES['attachment'];
    } else {

        $attachment = null;
    }

    $data = [
        "subject" => $_POST['subject'],
        "description" => $_POST['description'],
        "reported_email" => $_POST['reported_email'],
        "attachment" => $attachment,
        "type" => $_POST['type'],
        "created_by" => $_POST['created_by'],
        "user_id" => $_SESSION['user']['id']
    ];

    $result = $supportController->create($data);

    if ($result['success']) {

        if ($attachment !== null) {

            move_uploaded_file($result['data']['attachment']['tmp_name'], $result['data']['attachment']['target']);
        }

        echo "<script>alert('Support ticket created successfully');</script>";
    } else {

        echo "<script>alert('Failed to create support ticket');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=menu" />

</head>

<body class="m-2 shadow-lg rounded-4 min-vh-100" style="background-color: #f8f9fa;">

    <!-- NEW NAVBAR -->
    <nav class="navbar navbar-expand-lg rounded-top-4" style="background-color: #b7a3e8; color: white;">
        <div class="container-fluid">
            <img src="./images/logo_if.png" alt="Logo" width="40" height="24" class="mx-2 d-inline-block align-text-top">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <span class="mx-2 h6">Support</span>
                    </li>
                </ul>

                <form action="" method="post">

                    <span class="navbar-text" style="color: white;">
                        <ul class="navbar-nav me-auto mx-2 mb-2 mb-lg-0">
                            <li class="nav-item">
                                <button type="submit" name="home" class="nav-link ">
                                    <h6 class="text-white">
                                        Home
                                    </h6>
                                </button>
                            </li>

                            <li class="nav-item">
                                <button type="submit" name="support" class="nav-link active">
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

    <div class="container my-3 pb-3">

        <div class="row justify-content-center mx-3">

            <h1 class="text-center my-5">Hello <?= $_SESSION["user"]["username"] ?>, what can we help ?</h1>

            <div class="col-12 col-lg-6">
                <!-- FORM SECTION -->
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" required placeholder="Subject email">
                    </div>
                    <div class="mb-3">
                        <label for="created_by" class="form-label">Fullname</label>
                        <input type="text" class="form-control" id="created_by" name="created_by" value="<?= $_SESSION['user']['fullname'] ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="reported_email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="reported_email" aria-describedby="emailHelp" name="reported_email" value="<?= $_SESSION['user']['email'] ?>" readonly>
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Description email"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="attachment" class="form-label">Attachment</label>
                        <input class="form-control" type="file" id="attachment" name="attachment">
                        <div id="emailHelp" class="form-text">Format file jpg / png and maximum size 2MB</div>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type Ticket</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="type" value="QUESTION" required>
                            <label class="form-check-label" for="type">
                                Question
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="type" value="SUPPORT" required>
                            <label class="form-check-label" for="type">
                                Support
                            </label>
                        </div>
                    </div>

                    <div class="d-flex flex-row-reverse">
                        <button type="submit" name="send_ticket" class="btn text-white" style="background-color:  #b7a3e8;">Send</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>

</html>