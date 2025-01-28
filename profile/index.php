<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location:/session.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Profile</title>
        <link href="style.css" rel="stylesheet">
        <script src="script.js"></script>
    </head>
    <body>
        <div class="floating-menu">
            <div class="hamburg-menu" id="hmenu" hidden>
                <div class="hamburg-inner m-f">
                    <div class="hamburg-btn"><i class="accent-cf mr-5 nf nf-md-home"></i> <a href="/beranda.php">Home</a></div>
                    <hr>
                    <div class="hamburg-btn"><i class="accent-cf mr-5 nf nf-md-lightning_bolt"></i> <a href="/event.php">Webinar</a></div>
                    <hr>
                    <div class="hamburg-btn"><i class="accent-cf mr-5 nf nf-md-certificate"></i> <a href="/sertifikat.php">Certificate</a></div>
                    <hr>
                    <div class="hamburg-btn"><i class="accent-cf mr-5 nf nf-md-key"></i> <a href="/ganti-password.php">Ganti Password</a></div>
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
            <div class="sidebar-left">
                <div class="left-back">
                    <div class="left-upper">
                        <div class="img-container">
                            <img class="responsive-image" src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fpreview.redd.it%2Fy7o9g85gp2q51.jpg%3Fwidth%3D960%26crop%3Dsmart%26auto%3Dwebp%26s%3D831fd62b4deffa1908a3807c5920b5f80e88e35c&f=1&nofb=1&ipt=c50e28045007b7979226d1202f05e370c467da1710a2c530d88c1e2e7d2512c0&ipo=images"/>
                        </div>
                    </div>
                    <div class="left-bottom">
                        <div class="pad-left">
                            <br>
                            <h3 class="xl-f" id="name">
                                <?php 
                                echo $_SESSION['nama_lengkap'];
                                //if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == "admin") {
                                //    echo " (Admin)";
                                //}
                                ?>
                            </h3>
                            <br>
                            <table class="s-f user-table">
                                <tr>
                                    <td><i class="nf nf-md-email"></i></td>
                                    <td id="email">
                                        <?php echo $_SESSION['email']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="nf nf-fa-phone"></i></td>
                                    <td id="phone">
                                        <?php echo $_SESSION['phone']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="nf nf-fa-home"></i></td>
                                    <td id="address">
                                        <?php echo $_SESSION['address']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="nf nf-fa-briefcase"></i></td>
                                    <td id="instansi">
                                        <?php echo $_SESSION['institution']; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="center-me">
                            <div style="display:none;" class="s-f" id="save-edit"><i class="nf nf-fa-save"></i> Save</div>
                            <div class="s-f" id="editbtn"><i class="nf nf-fa-edit"></i> Rubah Profile</div>
                            <div class="s-f" id="logoutbtn"><i class="nf nf-fa-sign_out"></i> Logout</div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="sidebar-right">
                <div class="right-back">
                    <p class="accent-cf bold-f xl-f drops-f">RIWAYAT</p>
                    <div class="search-bar">
                        <input class="text-inp" type="text" placeholder="Cari Webinar...">
                        <div class="advanced-s" id="toggle-advs">
                            <i class="nf nf-md-text_box_search_outline"></i>
                        </div>
                        <div class="s-button" id="sbut">
                            <i class="nf nf-fa-search"></i>
                        </div>
                    </div>
                    <div id="as-dialog" style="display: none;">
                        <div class="inner-dialog">
                            <p class="m-f bold-f">Advanced Search</p>
                            <label class="bold-f" for="from">Sebelum:</label>
                            <input type="date" placeholder="before">
                            <label class="bold-f" for="from">Sesudah:</label>
                            <input type="date" placeholder="after">
                            <label class="bold-f" for="from">Sortir:</label>
                            <radio-group>
                                <input type="radio" name="sort" value="asc" checked>abc
                                <input type="radio" name="sort" value="desc">zyx
                            </radio-group>
                            <label class="bold-f" for="from">Sortir dengan:</label>
                            <radio-group>
                                <input type="radio" name="sortby" value="name" checked>nama
                                <input type="radio" name="sortby" value="date">tanggal
                            </radio-group>
                        </div>
                    </div>
                    <div class="card-container" id="c-container">
                        <!--<div class="card">-->
                        <!--    <div class="card-upper">-->
                        <!--        <div class="wimg-container">-->
                        <!--            <img class="responsive-image2" src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fmikrocentrum.nl%2Fassets%2FUploads%2FALG_Webinars-min-v2.jpg&f=1&nofb=1&ipt=1067cd4cae67259b4c613752d1b1cecf932f0e5d111a6c527eec068a3eb9d1e3&ipo=images"/>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--    <div class="card-bottom">-->
                        <!--        <p class="m-f bold-f mb-5 mb-0">Webinar A</p>-->
                        <!--        <p class="s-f mb-0">1/1/1111</p>-->
                        <!--        <p class="s-f mb-0">Manusia</p>-->
                        <!--        <div class="card-status">-->
                        <!--            <p class="xs-f">Panitia</p>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                    <div class="more-card-btn">
                        <div class="white-grad inner-footer">
                            <p id="prev-but" class="accent-cf m-f page-number"><i class="nf nf-md-arrow_left_circle"></i></p>
                            <p id="current-page" class="accent-cf m-f page-number">1/n</p>
                            <p id="next-but" class="accent-cf m-f page-number"><i class="nf nf-md-arrow_right_circle"></i></p>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </body>
</html>
