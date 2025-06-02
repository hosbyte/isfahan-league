<?php
include 'db.php';
session_start();

// ? admin check
if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin')
{
    header('Location: admin.php');
    exit();
}


// ? database conecttion
$query = ("SELECT * FROM `teams` ORDER BY point DESC , gd DESC ");
$sql = mysqli_query($db , $query);


?>

<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>League Nama</title>
</head>
<body>
    <!-- // ? navbar -->
    <!-- //FIXME:  -->
    <nav class="navbar navbar-expand-lg" style=" background-color: #135e85">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">league nama</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">خانه</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">ورود</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- // ? table -->
    <div style="margin-top: 50px; text-align: center;">
        <table class="table table-primary table-striped">
            <thead>
                <tr>
                    <th scope="col">ردیف</th>
                    <th scope="col">نام تیم</th>
                    <th scope="col">امتیاز</th>
                    <th scope="col">بازی انجام شده</th>
                    <th scope="col">برد</th>
                    <th scope="col">مساوی</th>
                    <th scope="col">باخت</th>
                    <th scope="col">گل زده</th>
                    <th scope="col">گل خورده</th>
                    <th scope="col">تفاضل گل</th>
                </tr>
            </thead>
            <tbody>
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
    
    <div style="height: 150px;">

    </div>
    <footer class="footer">
        <p class="text-footer">Macked By <a class="footer-link" href="https://hosbyte.ir">Hosbyte</a> Programmer</p>
    </footer>
</body>
</html>