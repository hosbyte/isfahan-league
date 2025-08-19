<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'db.php';
session_start();

// ? check admin
if(!isset($_SESSION['role']) && $_SESSION['role'] !== 'admin')
{
    header('Location: login.php');
    exit();
}

// * create table variable 
$table = null;
// * create teams register variable
$team_id = null;
$gf =null;
$ga =null;
$gd = null;
$db_gf = null;
$db_ga = null;
$db_gd = null;
$db_win = null;
$db_drow = null;
$db_lost = null;
$db_mp = null;
$db_point = null;
$save_query =null;
// * create database read variable
$show_query = null;
$show_sql = null;
$row = null;

// ? read database for show teams name
if(isset($_POST['table']) && !empty($_POST['table'])) {
    $_SESSION['table'] = $_POST['table'];
    $table = $_POST['table'];
    
    // اعتبارسنجی نام جدول
    $allowed_tables = ['d2z17', 'd2z15', 'd2z14', 'd2z13', 'bartar13', 'bartar15'];
    if(!in_array($table, $allowed_tables)) {
        die("0"); // جدول نامعتبر
    }
    
    $show_query = "SELECT id, name FROM `$table`";
    $show_sql = mysqli_query($db, $show_query);
    
    if(!$show_sql) {
        die("0"); // خطا در اجرای کوئری
    }
    
    // ذخیره تمام رکوردها در session
    $_SESSION['teams_data'] = [];
    while($row = mysqli_fetch_assoc($show_sql)) {
        $_SESSION['teams_data'][] = $row;
    }
    echo "1";
    exit();
    return;
}

// ? register
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['team_id']) && isset($_POST['gf']) && isset($_POST['ga']))
{   
    
    $table = $_SESSION['table'] ?? null;
    //var_dump($table);
    $team_id = intval($_POST['team_id']);
    $gf = intval($_POST['gf']);
    $ga = intval($_POST['ga']);

    if($_SESSION['role'] === 'admin')
    {
        $read_query = ("SELECT * FROM `$table` WHERE `id` = '$team_id'");
        $read_sql = mysqli_query($db , $read_query);
        while($read = mysqli_fetch_assoc($read_sql))
        {
            $db_point = $read['point'];
            $db_mp = $read['mp'];
            $db_win = $read['win'];
            $db_drow = $read['drow'];
            $db_lost = $read['lost'];
            $db_gf = $read['f'];
            $db_ga = $read['a'];
            $db_gd = $read['gd'];
        }

        $db_gf = $db_gf + $gf;
        $db_ga = $db_ga + $ga;
        $db_gd = $db_gf - $db_ga;

        if($gf > $ga)
        {
            $db_win++;
            $db_point = $db_point + 3;
        }
        else if($gf == $ga)
        {
            $db_drow++;
            $db_point++;
        }
        else
        {
            $db_lost++;
        }

        $db_mp++;
        $save_query = ("UPDATE `$table` SET `point` = '$db_point' , `mp` = '$db_mp' , `win` = '$db_win' , `drow` = '$db_drow' 
        ,`lost` = '$db_lost' ,`f` = '$db_gf' , `a` = '$db_ga' , `gd` = '$db_gd' WHERE `id` = '$team_id'");
        $save_sql = mysqli_query($db , $save_query);
    }
    echo "1";
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
        <link rel="stylesheet" href="https://hosbyte.ir/files/icon/icons-1.11.0/font/bootstrap-icons.min.css">
        <link href="style.css" rel="stylesheet">
        <script src="https://hosbyte.ir/files/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://hosbyte.ir/files/jquery-3.7.1.min.js"></script>
        <script  src="jquery.js"></script>
        <title>isfahan league</title>
    </head>
    <body>  
        <div class="body" >
            <!-- // ? navbar -->
            <nav class="navbar navbar-expand-lg" style="background: linear-gradient(135deg, #92fe9d 0% , #00c9ff 100%);">
                <div class="container-fluid">
                    <a class="navbar-brand" style="color:rgb(255, 255, 255);"  href="#">ثبت نتایج</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="admin.php">خانه</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="teamedit.php">مدیریت تیم ها</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">خروج</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- //? select database -->
            <div class="container-fluid py-5 img">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6" >
                        <form  method="POST" id="leaguetable"
                         class="bg-info bg-opacity-10 p-3 p-md-5 rounded-3 shadow"
                         style="background: linear-gradient(135deg, #00c9ff 0%, #92fe9d 100%);">
                            <label class="form-label fw-bold">انتخاب جدول:</label>
                            <select id="table" class="form-select form-select-lg">
                                <option value="">-- انتخاب کنید --</option>
                                <option value="bartar15" >زیر 15 سال لیگ برتر</option>
                                <option value="bartar13" >زیر 13 سال لیگ برتر</option>
                                <option value="d2z17" >زیر 17 دسته دو</option>
                                <option value="d2z15" >زیر 15 دسته 2</option>
                                <option value="d2z14" >زیر 14 دسته دو</option>
                                <option value="d2z13" >زیر 13 دسته دو</option>
                            </select>
                            <br>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success btn-lg px-5 py-2">انتخاب جدول</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- // ? register form    -->  
            <div class="container-fluid py-5 img">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6" >
                        <form method="POST" id="register"
                         class="bg-info bg-opacity-10 p-3 p-md-5 rounded-3 shadow"
                         style="background: linear-gradient(135deg, #00c9ff 0%, #92fe9d 100%);">
                            <div class="mb-4">
                                <label for="dropdown" class="form-label fw-bold">نام تیم مورد نظر را انتخاب کنید</label>
                                <select id="dropdown" class="form-select form-select-lg">
                                    <option value="">انتخاب کنید</option>
                                    <?php
                                        if(!empty($_SESSION['teams_data'])) {
                                            foreach($_SESSION['teams_data'] as $team) {
                                                echo '<option value="'.htmlspecialchars($team['id']).'">'
                                                    .htmlspecialchars($team['name']).
                                                    '</option>';
                                            }
                                        }
                                    ?>
                                </select>
                                <br>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="gf" class="form-label fw-bold">گل زده</label>
                                        <input id="gf" name="gf" type="number" class="form-control form-control-lg">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="ga" class="form-label fw-bold">گل خورده</label>
                                        <input id="ga" name="ga" type="number" class="form-control form-control-lg">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success btn-lg px-5 py-2">
                                    <i class="bi bi-check-circle-fill"></i> ثبت نتیجه
                                </button>
                            </div>  
                        </form>
                    </div>
                </div>
            </div> 
            <!-- // ? empty div  -->
            <div style="height: 50px;"></div>

            <!-- // ? footer -->
            <footer class="footer">
                <p class="text-footer">Create By <a class="footer-link" href="https://hosbyte.ir"> Hosbyte </a> Programmer</p>
            </footer> 
        </div>  
    </body>
</html>