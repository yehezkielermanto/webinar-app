<?php
require_once __DIR__ . "/controller/SupportController.php";

session_start();

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

if (isset($_POST['send_ticket'])) {
    $supportController = new SupportController();

    $data = [
        "subject" => $_POST['subject'],
        "description" => $_POST['description'],
        "reported_email" => $_POST['reported_email'],
        "type" => $_POST['type'],
        "created_by" => $_POST['created_by'],
        "user_id" => $_SESSION['user']['id']
    ];

    $result = $supportController->create($data);

    if ($result['success']) {
        
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
                </form>
            </div>

            <div class="col-12">
                <h1 class="text-center">Support</h1>
            </div>

            <div class="row">
                <div class="col-12 ">
                    <!-- FORM SECTION -->
                    <form method="post">
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="created_by" class="form-label">Fullname</label>
                            <input type="text" class="form-control" id="created_by" name="created_by" required>
                        </div>
                        <div class="mb-3">
                            <label for="reported_email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="reported_email" aria-describedby="emailHelp" name="reported_email" required>
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
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

                        <button type="submit" name="send_ticket" class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

</body>

</html>