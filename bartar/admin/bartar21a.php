<?php
include '../../db.php';
session_start();

// ? admin check
if(!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin' || $_SESSION['username'] !== 'majid')
{
    header('Location: ../../login.php');
    exit();
}

// ? database conection
$query = ("SELECT * FROM `bartar21` ORDER BY point DESC , gd DESC, name ASC");
$sql =mysqli_query($db , $query);

?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="../../img/favicon.png">
        <link href="https://hosbyte.ir/files/bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">    
        <link rel="stylesheet" href="https://isfahanleague.ir/files/icons-1.11.0/font/bootstrap-icons.min.css">
        <link href="../../style.css" rel="stylesheet">
        <!-- اضافه کردن فونت فارسی -->
        <style>
            body {
                font-family: Vazirmatn, sans-serif;
            }
        </style>
        <script src="https://hosbyte.ir/files/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://hosbyte.ir/files/jquery-3.7.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <script src="../../jquery.js"></script>
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
                            <a class="nav-link active" aria-current="page" href="../../admin.php">خانه</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../teamedit.php">مدیریت تیم‌ها</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../register.php">ثبت نتایج</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../resultedit.php">اصلاح نتایج</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../logout.php">خروج</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- // ? for photo -->
        <div id="leagueTable">
            <!-- // ? box for show table name -->
            <div class="box-name">
                <h4>لیگ برتر زیر ٢١ سال</h4>
            </div>

            <!-- // ? table -->
            <div class="img" style="margin-top: 50px; text-align: center;" class="container-fluid py-4 table-responsive-sm">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-10 col-xl-8">
                        <div class="table-responsive rounded-3 shadow-sm" style="margin-bottom: 80px;">
                            <table class="gradient-table-wrapper gradient-table table-size" style="color : black; font-size: 24px; font-weight: bold;">
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
                                                        <td style=\"font-size: 18px;\">$name</td>
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
        </div>

        <!-- // ? button for download -->
        <button id="downloadTable" class="btn btn-success" 
            style="display: block; margin: 20px auto; padding: 10px 20px; 
            background: linear-gradient(to right, rgba(0, 0, 0, 1), rgba(1, 63, 44, 1));">
            <i class="bi bi-download"></i> دانلود جدول به صورت عکس
        </button>
        
        <div style="height: 200px;"></div>

        <!-- // ? footer -->
        <footer class="footer">
            <p class="text-footer">Create By <a class="footer-link" href="https://hosbyte.ir">Hosbyte</a> Programmer</p>
        </footer>

        <!-- // ? script for photo download -->
        <script>
            $(document).ready(function(){
                $("#downloadTable").click(function(){
                    // ایجاد یک کپی از جدول برای پردازش بهتر
                    var tableElement = document.getElementById("leagueTable");
                    
                    // پیکربندی html2canvas برای پردازش بهتر متن فارسی
                    var options = {
                        scale: 2, // افزایش کیفیت
                        logging: false,
                        useCORS: true,
                        allowTaint: true,
                        backgroundColor: null,
                        onclone: function(clonedDoc) {
                            // اطمینان از اعمال استایل‌ها روی المنت کپی شده
                            var clonedTable = clonedDoc.getElementById("leagueTable");
                            if (clonedTable) {
                                clonedTable.style.fontFamily = "Vazirmatn, sans-serif";
                                clonedTable.style.direction = "rtl";
                            }
                        }
                    };
                    
                    html2canvas(tableElement, options).then(function(canvas) {
                        var link = document.createElement("a");
                        link.download = "league_table.png";
                        link.href = canvas.toDataURL("image/png");
                        link.click();
                    }).catch(function(error) {
                        console.error("Error generating image:", error);
                        alert("خطا در ایجاد تصویر. لطفاً دوباره تلاش کنید.");
                    });
                });
            });
        </script>

        <!-- // ? style for table -->
        <style>
            /* اضافه کردن استایل برای اطمینان از نمایش صحیح فونت */
            body, table, th, td {
                font-family: Vazirmatn, sans-serif !important;
            }
            
            /* استایل‌های قبلی شما */
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

            .box-name {
                position: relative;
                margin: 40px auto;
                padding: 15px 25px;
                max-width: 600px;
                width: 90%;
                background: linear-gradient(to right, rgba(0, 0, 0, 1), rgba(1, 63, 44, 1));
                color: white;
                text-align: center;
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
                font-family: Vazirmatn, sans-serif;
            }

            .box-name h4 {
                margin: 0;
                font-size: 1.4rem;
                font-weight: bold;
            }

            @media (max-width: 480px) {
                .box-name {
                    padding: 12px 18px;
                    font-size: 1rem;
                }
                .box-name h4 {
                    font-size: 1.2rem;
                }
            }

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
                font-family: Vazirmatn, sans-serif;
            }
            
            .gradient-table thead tr {
                background: linear-gradient(to right, rgba(0, 0, 0, 1), rgba(1, 63, 44, 1));
                color: white;
            }
            
            .gradient-table tbody tr {
                background: linear-gradient(to right, rgba(0, 0, 0, 1), rgba(1, 63, 44, 1));
                color: white;
                transition: all 0.3s ease;
                padding: 13px 10px;
                line-height: 3;
            }
            
            .gradient-table tbody tr:nth-child(even) {
                color: white;
                background: linear-gradient(to right, rgba(0, 0, 0, 1), rgba(1, 63, 44, 1));
            }
            
            .gradient-table th, 
            .gradient-table td {
                padding: 12px 15px;
                text-align: center;
                border: 1px solid rgba(255, 255, 255, 0.1);
                font-family: Vazirmatn, sans-serif;
            }
            
            .gradient-table th {
                font-weight: 600;
            }
        </style>
    </body>
</html>