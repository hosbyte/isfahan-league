<?php
include('../../db.php');
session_start();

// ? database conecttion
$query = ("SELECT * FROM `daste1z17` ORDER BY point DESC , gd DESC, name ASC ");
$sql = mysqli_query($db , $query);


?>

<!DOCTYPE html>
<html lang="en" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="../../img/favicon.png">
        <link href="https://hosbyte.ir/files/bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">    
        <link rel="stylesheet" href="https://isfahanleague.ir/files/icons-1.11.0/font/bootstrap-icons.min.css">
        <link href="../../style.css" rel="stylesheet">
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
                            <a class="nav-link" href="index.php">خانه</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">ورود</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- // ? box for show league name -->
        <div class="box-name">
            <h4>لیگ دسته یک زیر ١٧ سال</h4>
        </div>

        <!-- // ? table -->
        <div class="img" style="margin-top: 70px; text-align: center;" class="container-fluid py-4 table-responsive-sm">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 col-xl-8">
                    <div class="table-responsive rounded-3 shadow-sm" style="margin-bottom: 80px;">
                        <table class="gradient-table-wrapper gradient-table" style="color : black;">
                            <thead style="text-align: center;">
                                <tr>
                                    <th scope="col">رتبه</th>
                                    <th scope="col">نام تیم</th>
                                    <th scope="col">امتیاز</th>
                                    <th scope="col">بازی</th>
                                    <th scope="col">برد</th>
                                    <th scope="col">مساوی</th>
                                    <th scope="col">باخت</th>
                                    <th scope="col">گل زده</th>
                                    <th scope="col">گل خورده</th>
                                    <th scope="col">تفاضل گل</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center;">
                                    <?php
                                        $num = 0;
                                        while ($show = mysqli_fetch_assoc($sql))
                                        {
                                            $num++;
                                            $name = $show['name'];
                                            $point = $show['point'];
                                            $mp = $show['mp'];
                                            $win = $show['win'];
                                            $drow =$show['drow'];
                                            $lost = $show['lost'];
                                            $gf = $show['f'];
                                            $ga = $show['a'];
                                            $gd = $show['gd'];
                                            echo "
                                                <tr>
                                                    <th scope=\"row\">$num</th>
                                                    <td>$name</td>
                                                    <td>$point</td>
                                                    <td>$mp</td>
                                                    <td>$win</td>
                                                    <td>$drow</td>
                                                    <td>$lost</td>
                                                    <td>$gf</td>
                                                    <td>$ga</td>
                                                    <td>$gd</td>
                                                </tr>
                                            ";
                                        }
                                    ?>
                            </tbody>
                        </table>   
                    </div>
                </div>
            </div>
        </div>

        <!-- // empty div -->
        <div style="height: 20px;"></div>

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

            /*  box for show league name  */
            .box-name {
            position: relative;
            margin: 40px auto;
            padding: 15px 25px;
            max-width: 600px;
            width: 90%;
            background-color: rgba(0, 0, 255, 0.7);
            /* background: linear-gradient(to right, rgba(0, 0, 0, 1), rgba(6, 181, 235, 1)); */
            color: white;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            font-family: 'Vazir', sans-serif; /* اگر فونت فارسی داری */
            }

            .box-name h4 {
            margin: 0;
            font-size: 1.4rem;
            font-weight: bold;
            }

            /* ریسپانسیو برای موبایل */
            @media (max-width: 480px) {
            .box-name {
                padding: 12px 18px;
                font-size: 1rem;
            }

            .box-name h4 {
                font-size: 1.2rem;
            }
            }

            /*  table */
            .gradient-table-wrapper {
            background: linear-gradient(to bottom, #00c8ff86, #92fe9d71);
            border-radius: 10px;
            padding: 1px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }
            
            .gradient-table {
                width: 100%;
                background-color: transparent;
                border-collapse: collapse;
                color: #333;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            
            .gradient-table thead tr {
                background-color: rgba(0, 0, 255, 0.7);
                /* background: linear-gradient(to right, rgba(0, 0, 0, 1), rgba(6, 181, 235, 1)); */
                color: white;
                text-shadow: 1px 1px 2px rgba(255, 255, 255, 1);
            }
            
            .gradient-table tbody tr {
                background-color: rgba(0, 0, 255, 0.7);
                /* background: linear-gradient(to right, rgba(0, 0, 0, 1), rgba(6, 181, 235, 1)); */
                color: white;
                transition: all 0.3s ease;
            }
            
            .gradient-table tbody tr:nth-child(even) {
                color: white;
                background-color: rgba(0, 0, 255, 0.7);
                /* background: linear-gradient(to right, rgba(0, 0, 0, 1), rgba(6, 181, 235, 1)); */
            }
            
            
            .gradient-table th, 
            .gradient-table td {
                padding: 12px 15px;
                text-align: center;
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
            
            .gradient-table th {
                font-weight: 600;
                letter-spacing: 0.5px;
            }
        </style>
    </body>
</html>
