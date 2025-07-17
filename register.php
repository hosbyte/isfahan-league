<?php
include 'db.php';
session_start();

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

// ? read database for show teams name
$show_query = null;
$show_sql = null;
if($_SESSION['username'] === 'd2admin17')
{
    $show_query = ("SELECT * FROM `d2z17`");
    $show_sql = mysqli_query($db , $show_query);
}
else if($_SESSION['username'] === 'd2admin15')
{
    $show_query = ("SELECT * FROM `d2z15`");
    $show_sql = mysqli_query($db , $show_query);
}
else if($_SESSION['username'] === 'd2admin14')
{
    $show_query = ("SELECT * FROM `d2z14`");
    $show_sql = mysqli_query($db , $show_query);
}
else if($_SESSION['username'] === 'd2admin13')
{
    $show_query = ("SELECT * FROM `d2z13`");
    $show_sql = mysqli_query($db , $show_query);
}



// ? register
if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['team_id']) && isset($_GET['gf']) && isset($_GET['ga']))
{   
    
    $team_id = intval($_GET['team_id']);
    $gf = intval($_GET['gf']);
    $ga = intval($_GET['ga']);

    if($_SESSION['username'] === 'd2admin17')
    {
        $read_query = ("SELECT * FROM `d2z17` WHERE `id` = '$team_id'");
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
        $save_query = ("UPDATE `d2z17` SET `point` = '$db_point' , `mp` = '$db_mp' , `win` = '$db_win' , `drow` = '$db_drow' 
        ,`lost` = '$db_lost' ,`f` = '$db_gf' , `a` = '$db_ga' , `gd` = '$db_gd' WHERE `id` = '$team_id'");
        $save_sql = mysqli_query($db , $save_query);
    }
    else if($_SESSION['username'] === 'd2admin15')
    {
        $read_query = ("SELECT * FROM `d2z15` WHERE `id` = '$team_id'");
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
        $save_query = ("UPDATE `d2z15` SET `point` = '$db_point' , `mp` = '$db_mp' , `win` = '$db_win' , `drow` = '$db_drow' 
        ,`lost` = '$db_lost' ,`f` = '$db_gf' , `a` = '$db_ga' , `gd` = '$db_gd' WHERE `id` = '$team_id'");
        $save_sql = mysqli_query($db , $save_query);
    }
    else if($_SESSION['username'] === 'd2admin14')
    {
        $read_query = ("SELECT * FROM `d2z14` WHERE `id` = '$team_id'");
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
        $save_query = ("UPDATE `d2z14` SET `point` = '$db_point' , `mp` = '$db_mp' , `win` = '$db_win' , `drow` = '$db_drow' 
        ,`lost` = '$db_lost' ,`f` = '$db_gf' , `a` = '$db_ga' , `gd` = '$db_gd' WHERE `id` = '$team_id'");
        $save_sql = mysqli_query($db , $save_query);
    }
    else if($_SESSION['username'] === 'd2admin13')
    {
        $read_query = ("SELECT * FROM `d2z13` WHERE `id` = '$team_id'");
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
        $save_query = ("UPDATE `d2z13` SET `point` = '$db_point' , `mp` = '$db_mp' , `win` = '$db_win' , `drow` = '$db_drow' 
        ,`lost` = '$db_lost' ,`f` = '$db_gf' , `a` = '$db_ga' , `gd` = '$db_gd' WHERE `id` = '$team_id'");
        $save_sql = mysqli_query($db , $save_query);
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
        <link rel="stylesheet" href="https://hosbyte.ir/files/icon/icons-1.11.0/font/bootstrap-icons.min.css">
        <link href="style.css" rel="stylesheet">
        <script src="https://hosbyte.ir/files/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://hosbyte.ir/files/jquery-3.7.1.min.js"></script>
        <title>League Nama</title>
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
                            <?php
                                if($_SESSION['username'] === 'd2admin17')
                                {
                                    echo "
                                        <li class=\"nav-item\">
                                            <a class=\"nav-link active\" aria-current=\"page\" href=\"d2z17a.php\">خانه</a>
                                         </li>
                                    ";
                                } 
                                else if($_SESSION['username'] === 'd2admin15')
                                {
                                    echo "
                                        <li class=\"nav-item\">
                                            <a class=\"nav-link active\" aria-current=\"page\" href=\"d2z15a.php\">خانه</a>
                                         </li>
                                    ";
                                }
                                else if($_SESSION['username'] === 'd2admin13')
                                {
                                    echo "
                                        <li class=\"nav-item\">
                                            <a class=\"nav-link active\" aria-current=\"page\" href=\"d2z13a.php\">خانه</a>
                                         </li>
                                    ";
                                }
                                else if($_SESSION['username'] === 'd2admin14')
                                {
                                    echo "
                                        <li class=\"nav-item\">
                                            <a class=\"nav-link active\" aria-current=\"page\" href=\"d2z14a.php\">خانه</a>
                                         </li>
                                    ";
                                }
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="teamedit.php">افزودن تیم</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">خروج</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            
            <!-- // ? register form  -->
            <div class="container-fluid py-5 img">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6" >
                        <form action="register.php" method="get" onsubmit="rsend(); return false;"
                        class="bg-info bg-opacity-10 p-3 p-md-5 rounded-3 shadow"
                        style="background: linear-gradient(135deg, #00c9ff 0%, #92fe9d 100%);">
                            <div class="mb-4">
                                <label for="dropdown" class="form-label fw-bold">نام تیم مورد نظر را انتخاب کنید</label>
                                <select id="dropdown" class="form-select form-select-lg">
                                    <option value="">انتخاب کنید</option>
                                    <?php
                                    while($row = mysqli_fetch_assoc($show_sql))
                                    {
                                        $id = $row['id'];
                                        $name = $row['name'];
                                        echo "
                                        <option value=\"$id\">$name</option>
                                        ";
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

            <!-- // ? footer -->
            <footer class="footer">
                <p class="text-footer">Create By <a class="footer-link" href="https://hosbyte.ir"> Hosbyte </a> Programmer</p>
            </footer> 

        </div>

        <!-- // ? jquery -->
        <script>
                function rsend()
                {
                    const team_id = $('#dropdown').val();
                    const gf = $('#gf').val();
                    const ga = $('#ga').val();

                    if (!team_id || !gf || !ga) {
                        alert("لطفاً تمام فیلدها را پر کنید.");
                        return;
                    }
                    $.ajax({
                        url : 'register.php',
                        method : 'GET',
                        data :{
                            team_id : $('#dropdown').val(),
                            gf : $('#gf').val(),
                            ga : $('#ga').val()
                        },
                        success : function(reg)
                        {
                            reg.trim() === '1'
                            ?window.location.href='register.php'
                            : alert ("ثبت انجام نشد");
                        },
                        error : function()
                        {
                            alert ("اتصال انجام نشد");
                        }
                    });
                }
        </script>
    </body>
</html>