<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
}

?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Profile</title>
        <link href="css/profile.css" rel="stylesheet">
        <link href="css/beranda.css" rel="stylesheet">
        <script src="js/beranda.js"></script>
    </head>
    <body>
        <div class="floating-menu">
            <div class="hamburg-menu" id="hmenu" hidden>
                <div class="hamburg-inner m-f">
                    <div class="hamburg-btn"><i class="accent-cf mr-5 nf nf-md-home"></i> <a href="/webinar-app/beranda.php">Home</a></div>
                    <hr>
                    <div class="hamburg-btn"><i class="accent-cf mr-5 nf nf-md-lightning_bolt"></i> <a href="/webinar-app/event.php">Webinar</a></div>
                    <hr>
                    <div class="hamburg-btn"><i class="accent-cf mr-5 nf nf-md-certificate"></i> <a href="/webinar-app/sertifikat.php">Certificate</a></div>
                    <hr>
                    <div class="hamburg-btn"><i class="accent-cf mr-5 nf nf-md-key"></i> <a href="/webinar-app/ganti-password.php">Ganti Password</a></div>
                    <hr>
                    <div class="hamburg-btn"><i class="accent-cf mr-5 nf nf-md-account"></i> <a href="">Profile</a></div>
                </div>
            </div>
            <div class="floating-hamburg" id="toggle-menu">
                <p class="accent-cf bold-f">
                <i class="nf nf-md-menu"></i>
                </p>
            </div>
        </div>
        <div class="container">
            <div class="inner-container">
                <div class="inner-header">
                    <div class="inner-left">
                        <img class="if-logo" src="./images/logo_IF_square.png">
                        <p class="xl-f accent-cf bold-f page-title">DC-Webinar</p>
                    </div>
                    <button class="notif-button accent-cf"><i class="nf nf-md-bell"></i></button>
                </div>
                <div class="inner-content">
                    <p class="m-f accent-cf bold-f drops-f">Webinar yang akan datang</p>
                    <div class="coming-container">
                        <!-- start here -->
                        <div class="webinar">
                            <div class="card-upper">
                                <div class="wimg-container">
                                    <img class="responsive-image2" src="https://assets-a1.kompasiana.com/statics/files/2014/02/1393344209146395570.jpg?t=o&v=770"/>
                                </div>
                            </div>
                            <div class="card-bottom">
                                <p class="m-f bold-f mb-5 mb-0">ini title</p>
                                <p class="s-f mb-0">tanggal</p>
                                <p class="s-f mb-0">speaker</p>
                            </div>
                        </div>
                        <div class="webinar">
                            <div class="card-upper">
                                <div class="wimg-container">
                                    <img class="responsive-image2" src="https://assets-a1.kompasiana.com/statics/files/2014/02/1393344209146395570.jpg?t=o&v=770"/>
                                </div>
                            </div>
                            <div class="card-bottom">
                                <p class="m-f bold-f mb-5 mb-0">ini title</p>
                                <p class="s-f mb-0">tanggal</p>
                                <p class="s-f mb-0">speaker</p>
                            </div>
                        </div>
                        <div class="webinar">
                            <div class="card-upper">
                                <div class="wimg-container">
                                    <img class="responsive-image2" src="https://assets-a1.kompasiana.com/statics/files/2014/02/1393344209146395570.jpg?t=o&v=770"/>
                                </div>
                            </div>
                            <div class="card-bottom">
                                <p class="m-f bold-f mb-5 mb-0">ini title</p>
                                <p class="s-f mb-0">tanggal</p>
                                <p class="s-f mb-0">speaker</p>
                            </div>
                        </div>
                        <div class="webinar">
                            <div class="card-upper">
                                <div class="wimg-container">
                                    <img class="responsive-image2" src="https://assets-a1.kompasiana.com/statics/files/2014/02/1393344209146395570.jpg?t=o&v=770"/>
                                </div>
                            </div>
                            <div class="card-bottom">
                                <p class="m-f bold-f mb-5 mb-0">ini title</p>
                                <p class="s-f mb-0">tanggal</p>
                                <p class="s-f mb-0">speaker</p>
                            </div>
                        </div>
                        <div class="webinar">
                            <div class="card-upper">
                                <div class="wimg-container">
                                    <img class="responsive-image2" src="https://assets-a1.kompasiana.com/statics/files/2014/02/1393344209146395570.jpg?t=o&v=770"/>
                                </div>
                            </div>
                            <div class="card-bottom">
                                <p class="m-f bold-f mb-5 mb-0">ini title</p>
                                <p class="s-f mb-0">tanggal</p>
                                <p class="s-f mb-0">speaker</p>
                            </div>
                        </div>
                        <div class="webinar">
                            <div class="card-upper">
                                <div class="wimg-container">
                                    <img class="responsive-image2" src="https://assets-a1.kompasiana.com/statics/files/2014/02/1393344209146395570.jpg?t=o&v=770"/>
                                </div>
                            </div>
                            <div class="card-bottom">
                                <p class="m-f bold-f mb-5 mb-0">ini title</p>
                                <p class="s-f mb-0">tanggal</p>
                                <p class="s-f mb-0">speaker</p>
                            </div>
                        </div>
                        <div class="webinar">
                            <div class="card-upper">
                                <div class="wimg-container">
                                    <img class="responsive-image2" src="https://assets-a1.kompasiana.com/statics/files/2014/02/1393344209146395570.jpg?t=o&v=770"/>
                                </div>
                            </div>
                            <div class="card-bottom">
                                <p class="m-f bold-f mb-5 mb-0">ini title</p>
                                <p class="s-f mb-0">tanggal</p>
                                <p class="s-f mb-0">speaker</p>
                            </div>
                        </div>
                        <div class="webinar">
                            <div class="card-upper">
                                <div class="wimg-container">
                                    <img class="responsive-image2" src="https://assets-a1.kompasiana.com/statics/files/2014/02/1393344209146395570.jpg?t=o&v=770"/>
                                </div>
                            </div>
                            <div class="card-bottom">
                                <p class="m-f bold-f mb-5 mb-0">ini title</p>
                                <p class="s-f mb-0">tanggal</p>
                                <p class="s-f mb-0">speaker</p>
                            </div>
                        </div>
                        <!-- end here -->
                    </div>
                </div>
            </div>
            <div class="footer white-cf">
                <p class="m-f bold-f">Hubungi Kami</p>
                <div class="footer-entry">
                    <p class="s-f foot"><i class="nf nf-fa-building"></i> JL. IR.H. Soekarno no.201, Surabaya &nbsp|</p>
                    <p class="s-f foot"><i class="nf nf-fa-phone"></i> (031) 5914157, 5946482 &nbsp|</p>
                    <p class="s-f foot"><i class="nf nf-md-email"></i> info@ukdc.ac.id(informasi), pmb@ukdc.ac.id(pmb)</p>
                </div>
            </div>
        </div>
    </body>
</html>

