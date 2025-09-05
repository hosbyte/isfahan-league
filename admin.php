<?php
include 'db.php';
session_start();

// ? admin check
if(!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin' || $_SESSION['username'] !== 'majid')
{
    header('Location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="img/favicon.png">
        <link href="https://hosbyte.ir/files/bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">    
        <link rel="stylesheet" href="https://isfahanleague.ir/files/icons-1.11.0/font/bootstrap-icons.min.css">
        <link href="style.css" rel="stylesheet">
        <script src="https://hosbyte.ir/files/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://hosbyte.ir/files/jquery-3.7.1.min.js"></script>
        <title>isfahan league</title>
    </head>
    <body class="body">
        <!-- // ? navbar -->
        <nav class="navbar navbar-expand-lg" style="background: linear-gradient(135deg, #92fe9d 0% , #00c9ff 100%);">
            <div class="container-fluid">
                <a class="navbar-brand" style="color:rgb(255, 255, 255);" href="#">اصفهان لیگ </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="teamedit.php">مدیریت تیم ها</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">ثبت نتایج</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">خروج</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- // ? card show -->
        <div class="row" style="text-align: center;">
            <!-- // ? bartar  19 -->
            <div class="cart-back1 col-sm-6 mb-3 mb-sm-0" style="padding-top: 20px;">
                <div class="cart-back card">
                    <div class="cart-back cart card-body">
                        <h5 class="card-title">زیر 19 سال</h5>
                        <p class="card-text">لیگ برتر</p>
                        <a href="bartar19a.php" class="btn btn-primary">مشاهده جدول <i class="bi bi-eye"></i></a>
                    </div>
                </div>
            </div>
            <!-- // ? bartar  18 -->
            <div class="cart-back1 col-sm-6 mb-3 mb-sm-0" style="padding-top: 20px;">
                <div class="cart-back card">
                    <div class="cart-back cart card-body">
                        <h5 class="card-title">زیر 18 سال</h5>
                        <p class="card-text">لیگ برتر</p>
                        <a href="bartar18a.php" class="btn btn-primary">مشاهده جدول <i class="bi bi-eye"></i></a>
                    </div>
                </div>
            </div>
            <!-- // ? bartar  17 -->
            <div class="cart-back1 col-sm-6 mb-3 mb-sm-0" style="padding-top: 20px;">
                <div class="cart-back card">
                    <div class="cart-back cart card-body">
                        <h5 class="card-title">زیر 17 سال</h5>
                        <p class="card-text">لیگ برتر</p>
                        <a href="bartar17a.php" class="btn btn-primary">مشاهده جدول <i class="bi bi-eye"></i></a>
                    </div>
                </div>
            </div>
            <!-- // ? bartar  15 -->
            <div class="cart-back1 col-sm-6 mb-3 mb-sm-0" style="padding-top: 20px;">
                <div class="cart-back card">
                    <div class="cart-back cart card-body">
                        <h5 class="card-title">زیر 15 سال</h5>
                        <p class="card-text">لیگ برتر</p>
                        <a href="bartar15a.php" class="btn btn-primary">مشاهده جدول <i class="bi bi-eye"></i></a>
                    </div>
                </div>
            </div>
            <!-- // ? bartar 14 -->
            <div class="cart-back1 col-sm-6 mb-3 mb-sm-0" style="padding-top: 20px;">
                <div class="cart-back card">
                    <div class="cart-back cart card-body">
                        <h5 class="card-title">زیر 14 سال</h5>
                        <p class="card-text">لیگ برتر</p>
                        <a href="bartar14a.php" class="btn btn-primary">مشاهده جدول <i class="bi bi-eye"></i></a>
                    </div>
                </div>
            </div>
            <!-- // ? bartar  13 -->
            <div class="cart-back1 col-sm-6 mb-3 mb-sm-0" style="padding-top: 20px;">
                <div class="cart-back card">
                    <div class="cart-back cart card-body">
                        <h5 class="card-title">زیر 13 سال</h5>
                        <p class="card-text">لیگ برتر</p>
                        <a href="bartar13a.php" class="btn btn-primary">مشاهده جدول <i class="bi bi-eye"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- // ? empty div -->
        <div style="height: 100px;"></div>

        <!-- // ?footer -->
        <footer class="footer">
            <p class="text-footer">Create By <a class="footer-link" href="https://hosbyte.ir">Hosbyte</a> Programmer</p>
        </footer>

        <!-- // ? style for table -->
        <style>
            @media (max-width: 768px) {
                .table-responsive-md td:nth-child(4),
                .table-responsive-md td:nth-child(5),
                .table-responsive-md td:nth-child(6) {
                    display: none;
                }
                .table-responsive-md th:nth-child(4),
                .table-responsive-md th:nth-child(5),
                .table-responsive-md th:nth-child(6) {
                    display: none;
                }
            }
        </style>
    </body>
</html>