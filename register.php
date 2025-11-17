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
$team1_id = null;
$team2_id = null;
$gt1 =null;
$gt2 =null;
$gd = null;
$db_gf1 = null;
$db_gf2 = null;
$db_ga1 = null;
$db_ga2 = null;
$db_gd1 = null;
$db_gd2 = null;
$db_win1 = null;
$db_win2 = null;
$db_drow1 = null;
$db_drow2 = null;
$db_lost1 = null;
$db_lost2 = null;
$db_mp1 = null;
$db_mp2 = null;
$db_point1 = null;
$db_point2 = null;
$save_query1 =null;
$save_query2 =null;
$save_sql1 = null;
$save_sql2 = null;
// * create database read variable
$show_query = null;
$show_sql = null;
$row = null;

// ? read database for show teams name
if(isset($_POST['table']) && !empty($_POST['table'])) {
    $_SESSION['table'] = $_POST['table'];
    $table = $_POST['table'];
    
    // اعتبارسنجی نام جدول
    $allowed_tables = ['bartar13', 'bartar14', 'bartar15', 'bartar17', 'bartar18', 'bartar19', 
     'bartar21','daste1b' ,'daste1z19' ,'daste1z18' ,'daste1z17' ,'daste1z15' ,'daste1z14' ,'daste1z13' ,'osve'];
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
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['team1_id']) &&  isset($_POST['team2_id']) && isset($_POST['gt1']) && isset($_POST['gt2']))
{      
    $table = $_SESSION['table'] ?? null;
    $team1_id = intval($_POST['team1_id']);
    $team2_id = intval($_POST['team2_id']);
    $gt1 = intval($_POST['gt1']);
    $gt2 = intval($_POST['gt2']);

    // ! team 1 winner
    if($gt1 > $gt2)
    {
        $read1_query = ("SELECT * FROM `$table` WHERE `id` = '$team1_id'");
        $read1_sql = mysqli_query($db , $read1_query);
        while($read = mysqli_fetch_assoc($read1_sql))
        {
            $db_point1 = $read['point'];
            $db_mp1 = $read['mp'];
            $db_win1 = $read['win'];
            $db_drow1 = $read['drow'];
            $db_lost1 = $read['lost'];
            $db_gf1 = $read['f'];
            $db_ga1 = $read['a'];
            $db_gd1 = $read['gd'];
        }
        $db_gf1 = $db_gf1 + $gt1;
        $db_ga1 = $db_ga1 + $gt2;
        $db_gd1 = $db_gf1 - $db_ga1;

        $db_win1++;
        $db_point1 = $db_point1 + 3;

        $db_mp1++;
        $save_query1 = ("UPDATE `$table` SET `point` = '$db_point1' , `mp` = '$db_mp1' , `win` = '$db_win1' , `drow` = '$db_drow1' 
            ,`lost` = '$db_lost1' ,`f` = '$db_gf1' , `a` = '$db_ga1' , `gd` = '$db_gd1' WHERE `id` = '$team1_id'");
        $save_sql1 = mysqli_query($db , $save_query1);

        // ! team 2

        $read2_query = ("SELECT * FROM `$table` WHERE `id` = '$team2_id'");
        $read2_sql = mysqli_query($db , $read2_query);
        while($read = mysqli_fetch_assoc($read2_sql))
        {
            $db_point2 = $read['point'];
            $db_mp2 = $read['mp'];
            $db_win2 = $read['win'];
            $db_drow2 = $read['drow'];
            $db_lost2 = $read['lost'];
            $db_gf2 = $read['f'];
            $db_ga2 = $read['a'];
            $db_gd2 = $read['gd'];
        }
        $db_gf2 = $db_gf2 + $gt2;
        $db_ga2 = $db_ga2 + $gt1;
        $db_gd2 = $db_gf2 - $db_ga2;

        $db_lost2++; 

        $db_mp2++;
        $save_query2 = ("UPDATE `$table` SET `point` = '$db_point2' , `mp` = '$db_mp2' , `win` = '$db_win2' , `drow` = '$db_drow2' 
            ,`lost` = '$db_lost2' ,`f` = '$db_gf2' , `a` = '$db_ga2' , `gd` = '$db_gd2' WHERE `id` = '$team2_id'");
        $save_sql2 = mysqli_query($db , $save_query2);
    }

    // ! team 2 winner
    elseif($gt1 < $gt2)
    {
        $read1_query = ("SELECT * FROM `$table` WHERE `id` = '$team2_id'");
        $read1_sql = mysqli_query($db , $read1_query);
        while($read = mysqli_fetch_assoc($read1_sql))
        {
            $db_point1 = $read['point'];
            $db_mp1 = $read['mp'];
            $db_win1 = $read['win'];
            $db_drow1 = $read['drow'];
            $db_lost1 = $read['lost'];
            $db_gf1 = $read['f'];
            $db_ga1 = $read['a'];
            $db_gd1 = $read['gd'];
        }
        $db_gf1 = $db_gf1 + $gt2;
        $db_ga1 = $db_ga1 + $gt1;
        $db_gd1 = $db_gf1 - $db_ga1;

        $db_win1++;
        $db_point1 = $db_point1 + 3;

        $db_mp1++;
        $save_query1 = ("UPDATE `$table` SET `point` = '$db_point1' , `mp` = '$db_mp1' , `win` = '$db_win1' , `drow` = '$db_drow1' 
            ,`lost` = '$db_lost1' ,`f` = '$db_gf1' , `a` = '$db_ga1' , `gd` = '$db_gd1' WHERE `id` = '$team2_id'");
        $save_sql1 = mysqli_query($db , $save_query1);

        // ! team 2

        $read2_query = ("SELECT * FROM `$table` WHERE `id` = '$team1_id'");
        $read2_sql = mysqli_query($db , $read2_query);
        while($read = mysqli_fetch_assoc($read2_sql))
        {
            $db_point2 = $read['point'];
            $db_mp2 = $read['mp'];
            $db_win2 = $read['win'];
            $db_drow2 = $read['drow'];
            $db_lost2 = $read['lost'];
            $db_gf2 = $read['f'];
            $db_ga2 = $read['a'];
            $db_gd2 = $read['gd'];
        }
        $db_gf2 = $db_gf2 + $gt1;
        $db_ga2 = $db_ga2 + $gt2;
        $db_gd2 = $db_gf2 - $db_ga2;

        $db_lost2++; 

        $db_mp2++;
        $save_query2 = ("UPDATE `$table` SET `point` = '$db_point2' , `mp` = '$db_mp2' , `win` = '$db_win2' , `drow` = '$db_drow2' 
            ,`lost` = '$db_lost2' ,`f` = '$db_gf2' , `a` = '$db_ga2' , `gd` = '$db_gd2' WHERE `id` = '$team1_id'");
        $save_sql2 = mysqli_query($db , $save_query2);
    }

    // ! draw
    elseif($gt1 == $gt2)
    {
        $read1_query = ("SELECT * FROM `$table` WHERE `id` = '$team2_id'");
        $read1_sql = mysqli_query($db , $read1_query);
        while($read = mysqli_fetch_assoc($read1_sql))
        {
            $db_point1 = $read['point'];
            $db_mp1 = $read['mp'];
            $db_win1 = $read['win'];
            $db_drow1 = $read['drow'];
            $db_lost1 = $read['lost'];
            $db_gf1 = $read['f'];
            $db_ga1 = $read['a'];
            $db_gd1 = $read['gd'];
        }
        $db_gf1 = $db_gf1 + $gt2;
        $db_ga1 = $db_ga1 + $gt1;
        $db_gd1 = $db_gf1 - $db_ga1;

        $db_drow1++;
        $db_point1++;

        $db_mp1++;
        $save_query1 = ("UPDATE `$table` SET `point` = '$db_point1' , `mp` = '$db_mp1' , `win` = '$db_win1' , `drow` = '$db_drow1' 
            ,`lost` = '$db_lost1' ,`f` = '$db_gf1' , `a` = '$db_ga1' , `gd` = '$db_gd1' WHERE `id` = '$team2_id'");
        $save_sql1 = mysqli_query($db , $save_query1);

        // ! team 2

        $read2_query = ("SELECT * FROM `$table` WHERE `id` = '$team1_id'");
        $read2_sql = mysqli_query($db , $read2_query);
        while($read = mysqli_fetch_assoc($read2_sql))
        {
            $db_point2 = $read['point'];
            $db_mp2 = $read['mp'];
            $db_win2 = $read['win'];
            $db_drow2 = $read['drow'];
            $db_lost2 = $read['lost'];
            $db_gf2 = $read['f'];
            $db_ga2 = $read['a'];
            $db_gd2 = $read['gd'];
        }
        $db_gf2 = $db_gf2 + $gt1;
        $db_ga2 = $db_ga2 + $gt2;
        $db_gd2 = $db_gf2 - $db_ga2;

        $db_drow2++;
        $db_point2++; 

        $db_mp2++;
        $save_query2 = ("UPDATE `$table` SET `point` = '$db_point2' , `mp` = '$db_mp2' , `win` = '$db_win2' , `drow` = '$db_drow2' 
            ,`lost` = '$db_lost2' ,`f` = '$db_gf2' , `a` = '$db_ga2' , `gd` = '$db_gd2' WHERE `id` = '$team1_id'");
        $save_sql2 = mysqli_query($db , $save_query2);
    }
    echo"1";
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
                                <a class="nav-link" href="teamedit.php">مدیریت تیم‌ها</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="resultedit.php">اصلاح نتایج</a>
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
                                <option value="bartar21" >زیر 21 سال لیگ برتر</option>
                                <option value="bartar19" >زیر 19 سال لیگ برتر</option>
                                <option value="bartar18" >زیر 18 سال لیگ برتر</option>
                                <option value="bartar17" >زیر 17 سال لیگ برتر</option>
                                <option value="bartar15" >زیر 15 سال لیگ برتر</option>
                                <option value="bartar14" >زیر 14 سال لیگ برتر</option>
                                <option value="bartar13" >زیر 13 سال لیگ برتر</option>
                                <option value="daste1b" >لیگ دسته یک بزرگسال</option>
                                <option value="daste1z19" >لیگ دسته یک زیر 19 سال</option>
                                <option value="daste1z18" >لیگ دسته یک زیر 18 سال</option>
                                <option value="daste1z17" >لیگ دسته یک زیر 17 سال</option>
                                <option value="daste1z15" >لیگ دسته یک زیر 15 سال</option>
                                <option value="daste1z14" >لیگ دسته یک زیر 14 سال</option>
                                <option value="daste1z13" >لیگ دسته یک زیر 13 سال</option>
                                <option value="osve" >لیگ اسوه</option>
                                <!-- <option value="d2z17" >test</option> -->
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
                                <center>
                                    <label for="dropdown" class="form-label fw-bold">نام تیم مورد نظر را انتخاب کنید</label>
                                </center>
                                <div class="row align-items-center g-3">
                                    <div class="col-md-6">
                                        <select id="dropdown1" class="team-reg form-select form-select-lg">
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
                                    </div>
                                    <div class="col-md-6">
                                        <select id="dropdown2" class="team-reg form-select form-select-lg">
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
                                    </div>
                                </div>
                                <br>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="gt1" class="form-label fw-bold">گل زده تیم اول</label>
                                        <input id="gt1" name="gf" type="number" class="form-control form-control-lg">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="gt2" class="form-label fw-bold">گل زده تیم دوم</label>
                                        <input id="gt2" name="ga" type="number" class="form-control form-control-lg">
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