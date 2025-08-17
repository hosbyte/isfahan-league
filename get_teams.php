<!-- // todo register gpt -->
 <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $table) {
    $team1 = $_POST['team1'];
    $team2 = $_POST['team2'];
    $goal1 = intval($_POST['goal1']);
    $goal2 = intval($_POST['goal2']);

    if ($team1 === $team2) {
        echo "<p style='color:red'>تیم‌ها نباید یکسان باشند.</p>";
    } else {
        // محاسبه نتیجه
        if ($goal1 > $goal2) {
            $win1 = 1; $draw = 0; $win2 = 0;
        } elseif ($goal1 == $goal2) {
            $win1 = 0; $draw = 1; $win2 = 0;
        } else {
            $win1 = 0; $draw = 0; $win2 = 1;
        }

        // آپدیت تیم اول
        mysqli_query($db, "UPDATE `$table` SET 
            played = played + 1,
            win = win + $win1,
            draw = draw + $draw,
            lose = lose + $win2,
            goals_for = goals_for + $goal1,
            goals_against = goals_against + $goal2,
            points = points + " . ($win1 ? 3 : ($draw ? 1 : 0)) . "
            WHERE team = '$team1'");

        // آپدیت تیم دوم
        mysqli_query($db, "UPDATE `$table` SET 
            played = played + 1,
            win = win + $win2,
            draw = draw + $draw,
            lose = lose + $win1,
            goals_for = goals_for + $goal2,
            goals_against = goals_against + $goal1,
            points = points + " . ($win2 ? 3 : ($draw ? 1 : 0)) . "
            WHERE team = '$team2'");

        echo "<p style='color:green'>نتیجه با موفقیت ثبت شد.</p>";
    }
}
?>
<!-- // ! html register -->
 <!-- onchange="this.form.submit()" -->
<?php
                if ($table) {
                    // گرفتن لیست تیم‌ها
                    $query = "SELECT team FROM `$table` ORDER BY team ASC";
                    $result = mysqli_query($db, $query);
                    $teams = [];
                    while ($row = mysqli_fetch_assoc($result)) {
                        $teams[] = $row['team'];
                }
            ?>
            <form method="POST" action="register.php?table=<?= htmlspecialchars($table) ?>">
                <label>تیم میزبان:</label>
                <select name="team1" required>
                    <option value="">-- انتخاب تیم --</option>
                    <?php foreach ($teams as $team): ?>
                        <option value="<?= htmlspecialchars($team) ?>"><?= htmlspecialchars($team) ?></option>
                    <?php endforeach; ?>
                </select>

                <label>گل‌های میزبان:</label>
                <input type="number" name="goal1" min="0" required>

                <br>

                <label>تیم مهمان:</label>
                <select name="team2" required>
                    <option value="">-- انتخاب تیم --</option>
                    <?php foreach ($teams as $team): ?>
                        <option value="<?= htmlspecialchars($team) ?>"><?= htmlspecialchars($team) ?></option>
                    <?php endforeach; ?>
                </select>

                <label>گل‌های مهمان:</label>
                <input type="number" name="goal2" min="0" required>

                <br><br>
                <button type="submit">ثبت نتیجه</button>
            </form>
            <?php
                }
            ?>
<script>
$(document).ready(function() {
  $('#myForm').on('submit', function(e) {
    e.preventDefault(); // جلوگیری از ارسال پیش‌فرض فرم

    // دریافت داده‌های فرم
    var formData = $(this).serialize();

    // ارسال با AJAX
    $.ajax({
      url: 'your-server-endpoint.php', // آدرس مقصد
      type: 'POST',
      data: formData,
      success: function(response) {
        console.log('پاسخ سرور:', response);
      },
      error: function(xhr, status, error) {
        console.error('خطا:', error);
      }
    });
  });
});





function tsend(){
                const table = $('#table').val();

                if(!table){
                    alert("لطفاً تمام فیلدها را پر کنید.");
                    return;
                }

                $.ajax({
                    url : 'register.php',
                    method : 'get',
                    data :{
                        table : $('#table').val()
                    },
                    success : function(show_t){
                        show_t.trim() ==='1'
                        ?window.location.href = 'register.php'
                        : alert ("جدول انتخاب نشد");
                    },
                    error : function(){
                        alert ("اتصال انجام نشد");
                    }
                });
            }
</script>

/////////////////////////////////////////////////////////////////////////////////////////////

<?php
include 'db.php';
session_start();

// بررسی لاگین بودن کاربر
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// پردازش انتخاب جدول
if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['table'])) {
    $allowed_tables = ['d2z17', 'd2z15', 'd2z14', 'd2z13'];
    $table = $_GET['table'];
    
    // اعتبارسنجی جدول
    if(!in_array($table, $allowed_tables)) {
        echo json_encode(['status' => 'error', 'message' => 'جدول نامعتبر']);
        exit();
    }
    
    // بررسی دسترسی کاربر majid
    if($_SESSION['username'] === 'majid') {
        $_SESSION['selected_table'] = $table;
        
        // دریافت تیم‌های جدول انتخابی
        $query = "SELECT id, name FROM `$table` ORDER BY name";
        $result = mysqli_query($db, $query);
        
        $teams = [];
        while($row = mysqli_fetch_assoc($result)) {
            $teams[] = $row;
        }
        
        echo json_encode(['status' => 'success', 'teams' => $teams]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'دسترسی غیرمجاز']);
    }
    exit();
}

// پردازش ثبت نتیجه
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['team_id']) && isset($_POST['gf']) && isset($_POST['ga'])) {
    $team_id = intval($_POST['team_id']);
    $gf = intval($_POST['gf']);
    $ga = intval($_POST['ga']);
    
    // تعیین جدول بر اساس کاربر
    $user_tables = [
        'd2admin17' => 'd2z17',
        'd2admin15' => 'd2z15', 
        'd2admin14' => 'd2z14',
        'd2admin13' => 'd2z13'
    ];
    
    if(!isset($user_tables[$_SESSION['username']])) {
        echo json_encode(['status' => 'error', 'message' => 'دسترسی غیرمجاز']);
        exit();
    }
    
    $table = $user_tables[$_SESSION['username']];
    
    // دریافت اطلاعات فعلی تیم
    $query = "SELECT * FROM `$table` WHERE id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $team_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if(mysqli_num_rows($result) === 0) {
        echo json_encode(['status' => 'error', 'message' => 'تیم یافت نشد']);
        exit();
    }
    
    $team = mysqli_fetch_assoc($result);
    
    // محاسبه مقادیر جدید
    $new_gf = $team['f'] + $gf;
    $new_ga = $team['a'] + $ga;
    $new_gd = $new_gf - $new_ga;
    $new_mp = $team['mp'] + 1;
    $new_point = $team['point'];
    $new_win = $team['win'];
    $new_drow = $team['drow'];
    $new_lost = $team['lost'];
    
    if($gf > $ga) {
        $new_win++;
        $new_point += 3;
    } elseif($gf == $ga) {
        $new_drow++;
        $new_point += 1;
    } else {
        $new_lost++;
    }
    
    // به‌روزرسانی اطلاعات تیم
    $update_query = "UPDATE `$table` SET 
        point = ?, mp = ?, win = ?, drow = ?, lost = ?, 
        f = ?, a = ?, gd = ? 
        WHERE id = ?";
    
    $stmt = mysqli_prepare($db, $update_query);
    mysqli_stmt_bind_param(
        $stmt,
        "iiiiiiiii",
        $new_point, $new_mp, $new_win, $new_drow, $new_lost,
        $new_gf, $new_ga, $new_gd, $team_id
    );
    
    if(mysqli_stmt_execute($stmt)) {
        echo json_encode(['status' => 'success', 'message' => 'نتیجه با موفقیت ثبت شد']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'خطا در ثبت نتیجه']);
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ثبت نتایج لیگ اصفهان</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #00c9ff 0%, #92fe9d 100%);
        }
        .form-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>
    <!-- نوار ناوبری -->
    <nav class="navbar navbar-expand-lg navbar-dark gradient-bg">
        <div class="container">
            <a class="navbar-brand" href="#">ثبت نتایج لیگ</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <?php
                    $pages = [
                        'd2admin17' => 'd2z17a.php',
                        'd2admin15' => 'd2z15a.php',
                        'd2admin14' => 'd2z14a.php',
                        'd2admin13' => 'd2z13a.php'
                    ];
                    
                    if(isset($pages[$_SESSION['username']])) {
                        echo '<li class="nav-item">
                            <a class="nav-link" href="'.$pages[$_SESSION['username']].'">خانه</a>
                        </li>';
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

    <!-- فرم انتخاب جدول -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <form id="selectTableForm" class="p-4 rounded-3 shadow form-container">
                    <h4 class="text-center mb-4">انتخاب جدول</h4>
                    <div class="mb-3">
                        <label class="form-label">جدول مورد نظر:</label>
                        <select id="tableSelect" class="form-select form-select-lg">
                            <option value="">-- انتخاب کنید --</option>
                            <option value="d2z17">زیر 17 سال</option>
                            <option value="d2z15">زیر 15 سال</option>
                            <option value="d2z14">زیر 14 سال</option>
                            <option value="d2z13">زیر 13 سال</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        نمایش تیم‌ها
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- فرم ثبت نتیجه (در ابتدا مخفی است) -->
    <div class="container py-3" id="resultFormContainer" style="display: none;">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <form id="registerResultForm" class="p-4 rounded-3 shadow form-container">
                    <h4 class="text-center mb-4">ثبت نتیجه</h4>
                    <div class="mb-3">
                        <label class="form-label">تیم:</label>
                        <select id="teamSelect" name="team_id" class="form-select form-select-lg" required>
                            <option value="">ابتدا جدول را انتخاب کنید</option>
                        </select>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">گل زده:</label>
                            <input type="number" id="gf" name="gf" class="form-control form-control-lg" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">گل خورده:</label>
                            <input type="number" id="ga" name="ga" class="form-control form-control-lg" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100">
                        <i class="bi bi-check-circle"></i> ثبت نتیجه
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- اسکریپت‌ها -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        // انتخاب جدول
        $('#selectTableForm').on('submit', function(e) {
            e.preventDefault();
            const table = $('#tableSelect').val();
            
            if(!table) {
                alert('لطفاً یک جدول انتخاب کنید');
                return;
            }
            
            $.ajax({
                url: 'register.php',
                method: 'GET',
                data: { table: table },
                dataType: 'json',
                success: function(response) {
                    if(response.status === 'success') {
                        // پر کردن dropdown تیم‌ها
                        $('#teamSelect').empty();
                        $('#teamSelect').append('<option value="">تیم را انتخاب کنید</option>');
                        
                        $.each(response.teams, function(index, team) {
                            $('#teamSelect').append(
                                `<option value="${team.id}">${team.name}</option>`
                            );
                        });
                        
                        // نمایش فرم ثبت نتیجه
                        $('#resultFormContainer').fadeIn();
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('خطا در ارتباط با سرور');
                }
            });
        });
        
        // ثبت نتیجه
        $('#registerResultForm').on('submit', function(e) {
            e.preventDefault();
            
            if(!$('#teamSelect').val()) {
                alert('لطفاً یک تیم انتخاب کنید');
                return;
            }
            
            $.ajax({
                url: 'register.php',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    alert(response.message);
                    if(response.status === 'success') {
                        $('#registerResultForm')[0].reset();
                    }
                },
                error: function() {
                    alert('خطا در ارتباط با سرور');
                }
            });
        });
    });
    </script>
</body>
</html>


///////////////////////////////////////////////////////////////////////////////////////////////////////
// ? register
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['team_id']) && isset($_POST['gf']) && isset($_POST['ga']))
{   
    
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
    
    
    echo"1";
    exit();
}



// else if($_SESSION['username'] === 'd2admin15')
    // {
    //     $read_query = ("SELECT * FROM `d2z15` WHERE `id` = '$team_id'");
    //     $read_sql = mysqli_query($db , $read_query);
    //     while($read = mysqli_fetch_assoc($read_sql))
    //     {
    //         $db_point = $read['point'];
    //         $db_mp = $read['mp'];
    //         $db_win = $read['win'];
    //         $db_drow = $read['drow'];
    //         $db_lost = $read['lost'];
    //         $db_gf = $read['f'];
    //         $db_ga = $read['a'];
    //         $db_gd = $read['gd'];
    //     }

    //     $db_gf = $db_gf + $gf;
    //     $db_ga = $db_ga + $ga;
    //     $db_gd = $db_gf - $db_ga;

    //     if($gf > $ga)
    //     {
    //         $db_win++;
    //         $db_point = $db_point + 3;
    //     }
    //     else if($gf == $ga)
    //     {
    //         $db_drow++;
    //         $db_point++;
    //     }
    //     else
    //     {
    //         $db_lost++;
    //     }

    //     $db_mp++;
    //     $save_query = ("UPDATE `d2z15` SET `point` = '$db_point' , `mp` = '$db_mp' , `win` = '$db_win' , `drow` = '$db_drow' 
    //     ,`lost` = '$db_lost' ,`f` = '$db_gf' , `a` = '$db_ga' , `gd` = '$db_gd' WHERE `id` = '$team_id'");
    //     $save_sql = mysqli_query($db , $save_query);
    // }
    // else if($_SESSION['username'] === 'd2admin14')
    // {
    //     $read_query = ("SELECT * FROM `d2z14` WHERE `id` = '$team_id'");
    //     $read_sql = mysqli_query($db , $read_query);
    //     while($read = mysqli_fetch_assoc($read_sql))
    //     {
    //         $db_point = $read['point'];
    //         $db_mp = $read['mp'];
    //         $db_win = $read['win'];
    //         $db_drow = $read['drow'];
    //         $db_lost = $read['lost'];
    //         $db_gf = $read['f'];
    //         $db_ga = $read['a'];
    //         $db_gd = $read['gd'];
    //     }

    //     $db_gf = $db_gf + $gf;
    //     $db_ga = $db_ga + $ga;
    //     $db_gd = $db_gf - $db_ga;

    //     if($gf > $ga)
    //     {
    //         $db_win++;
    //         $db_point = $db_point + 3;
    //     }
    //     else if($gf == $ga)
    //     {
    //         $db_drow++;
    //         $db_point++;
    //     }
    //     else
    //     {
    //         $db_lost++;
    //     }

    //     $db_mp++;
    //     $save_query = ("UPDATE `d2z14` SET `point` = '$db_point' , `mp` = '$db_mp' , `win` = '$db_win' , `drow` = '$db_drow' 
    //     ,`lost` = '$db_lost' ,`f` = '$db_gf' , `a` = '$db_ga' , `gd` = '$db_gd' WHERE `id` = '$team_id'");
    //     $save_sql = mysqli_query($db , $save_query);
    // }
    // else if($_SESSION['username'] === 'd2admin13')
    // {
    //     $read_query = ("SELECT * FROM `d2z13` WHERE `id` = '$team_id'");
    //     $read_sql = mysqli_query($db , $read_query);
    //     while($read = mysqli_fetch_assoc($read_sql))
    //     {
    //         $db_point = $read['point'];
    //         $db_mp = $read['mp'];
    //         $db_win = $read['win'];
    //         $db_drow = $read['drow'];
    //         $db_lost = $read['lost'];
    //         $db_gf = $read['f'];
    //         $db_ga = $read['a'];
    //         $db_gd = $read['gd'];
    //     }

    //     $db_gf = $db_gf + $gf;
    //     $db_ga = $db_ga + $ga;
    //     $db_gd = $db_gf - $db_ga;

    //     if($gf > $ga)
    //     {
    //         $db_win++;
    //         $db_point = $db_point + 3;
    //     }
    //     else if($gf == $ga)
    //     {
    //         $db_drow++;
    //         $db_point++;
    //     }
    //     else
    //     {
    //         $db_lost++;
    //     }

    //     $db_mp++;
    //     $save_query = ("UPDATE `d2z13` SET `point` = '$db_point' , `mp` = '$db_mp' , `win` = '$db_win' , `drow` = '$db_drow' 
    //     ,`lost` = '$db_lost' ,`f` = '$db_gf' , `a` = '$db_ga' , `gd` = '$db_gd' WHERE `id` = '$team_id'");
    //     $save_sql = mysqli_query($db , $save_query);
    // }

