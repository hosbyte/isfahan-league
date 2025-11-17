<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'db.php';
session_start();

// ? admin check
if(!isset($_SESSION['role']) && $_SESSION['role'] !== 'admin')
{
  header('Location: login.php');
  exit();
}

// ? select table
$table = null;
$sql_query = null;
$sql_result = null;
$row = null;
if(isset($_POST['table']) && !empty($_POST['table']))
{
  $_SESSION['result_table'] = $_POST['table'];
  $table = $_POST['table'];

  // اعتبارسنجی 
  $allowed_tables = ['bartar13', 'bartar14', 'bartar15', 'bartar17', 'bartar18', 'bartar19', 'bartar21', 'daste1b', 'daste1z17', 'daste1z15', 'daste1z14', 'daste1z13' ,'osve'];
  if(!in_array($table, $allowed_tables)) 
  {
    die("0"); // جدول نامعتبر
  }

  $sql_query = ("SELECT * FROM `$table`");
  $sql_result = mysqli_query($db , $sql_query);
  if(!$sql_result)
  {
    die(0);
  }

  // ? save all data
  $_SESSION["save_data"] = [];
  while($row = mysqli_fetch_assoc($sql_result))
  {
    $_SESSION["save_data"][] = $row;
  }
  echo"1";
  exit();
  //return;
}

// ? show name team for edit or delete
$table_query = null;
$table_sql = null; 
// ! query
if(isset($_SESSION['result_table']))
{
    $table = $_SESSION["result_table"];
    $table_query = ("SELECT `id` , `name` FROM `$table` ORDER BY `point` DESC , `id` DESC");
    $table_sql =mysqli_query($db , $table_query);
}

// ? show teams name for edit in modal
$name_show = null;
$point_show = null;
$mp_show = null;
$win_show = null;
$draw_show = null;
$lost_show = null;
$gf_show = null;
$ga_show = null;
$gd_show = null;
$show_id = null;
if(isset($_GET['edit']))
{
  $table = $_SESSION['result_table'];
  $show_id = intval($_GET['edit']);
  $show_query = ("SELECT * FROM `$table` WHERE `id` = '$show_id'");
  $show_sql = mysqli_query($db , $show_query);
  while($read = mysqli_fetch_assoc($show_sql))
  {
    $name_show = $read['name'];
    $point_show = $read['point'];
    $mp_show = $read['mp'];
    $win_show = $read['win'];
    $draw_show = $read['drow'];
    $lost_show = $read['lost'];
    $gf_show = $read['f'];
    $ga_show = $read['a'];
    $gd_show = $read['gd'];
  }
}

// ? update teams result
if(isset($_POST['update']))
{
  $table = $_SESSION['result_table'];
  $show_id = $_POST['team_id'];
  $team_point = $_POST['team_point'];
  $team_mp = $_POST['team_mp'];
  $team_win = $_POST['team_win'];
  $team_draw = $_POST['team_draw'];
  $team_lost = $_POST['team_lost'];
  $team_gf = $_POST['team_gf'];
  $team_ga = $_POST['team_ga'];
  $team_gd = $_POST['team_gd'];

  // ! update query
  $update_query = ("UPDATE `$table` SET `point` = '$team_point' , `mp` = '$team_mp' , `win` = '$team_win'
    , `drow` = '$team_draw' , `lost` = '$team_lost' , `f` = '$team_gf' , `a` = '$team_ga' , `gd` = '$team_gd' WHERE `id` = '$show_id'");
  $update_sql = mysqli_query($db , $update_query);

}

?>
<!DOCTYPE html>
<html lang="en">
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
    <!-- // ? edit modal -->
    <div class="modal fade <?php echo isset($_GET['edit']); ?>" id="resultmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">اصلاح نتایج</h1>
          </div>
          <form action="resultedit.php" method="post">
            <div class="modal-body" style="text-align: center;"> 
              <input type="hidden" name="team_id" value="<?php echo $_GET['edit']; ?>"> 
              <!-- // ? team name -->
              <label style="color: black; margin-top: 10px;" >
                <h6><?php echo $name_show?></h6>
              </label> 
              <br>
              <!-- // ? point -->
              <label style="color: black; margin-top: 10px;" for="point">
                <h6>امتیاز</h6>
              </label>
              <br>
              <input type="text" value="<?php echo $point_show?>" name="team_point" id="point" style="border-radius: 20px;">
              <br>
              <!-- // ? mach play -->
              <label style="color: black; margin-top: 10px;" for="mp">
                <h6>تعداد بازی</h6>
              </label>
              <br>
              <input type="text" value="<?php echo $mp_show?>" name="team_mp" id="mp" style="border-radius: 20px;">
              <br>
              <!-- // ? win -->
              <label style="color: black; margin-top: 10px;" for="win">
                <h6>تعداد برد</h6>
              </label>
              <br>
              <input type="text" value="<?php echo $win_show?>" name="team_win" id="win" style="border-radius: 20px;">
              <br>
              <!-- // ? draw -->
              <label style="color: black; margin-top: 10px;" for="draw">
                <h6>تعداد تساوی</h6>
              </label>
              <br>
              <input type="text" value="<?php echo $draw_show?>" name="team_draw" id="draw" style="border-radius: 20px;">
              <br>
              <!-- // ? lost -->
              <label style="color: black; margin-top: 10px;" for="lost">
                <h6>تعداد باخت</h6>
              </label>
              <br>
              <input type="text" value="<?php echo $lost_show?>" name="team_lost" id="lost" style="border-radius: 20px;">
              <br>
              <!-- // ? gf -->
              <label style="color: black; margin-top: 10px;" for="gf">
                <h6>گل زده</h6>
              </label>
              <br>
              <input type="text" value="<?php echo $gf_show?>" name="team_gf" id="gf" style="border-radius: 20px;">
              <br>
              <!-- // ? ga -->
              <label style="color: black; margin-top: 10px;" for="ga">
                <h6>گل خورده</h6>
              </label>
              <br>
              <input type="text" value="<?php echo $ga_show?>" name="team_ga" id="ga" style="border-radius: 20px;">
              <br>
              <!-- // ? gd -->
              <label style="color: black; margin-top: 10px;" for="gd">
                <h6>تفاضل گل</h6>
              </label>
              <br>
              <input type="text" value="<?php echo $gd_show?>" name="team_gd" id="gd" style="border-radius: 20px;">
              <br>
            </div>
            <div class="modal-footer">
              <a href="resultedit.php" type="button" class="btn btn-info" data-bs-dismiss="modal">بستن</a>
              <button type="submit" name="update" class="btn btn-success">ذخیره</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- // ? navbar -->
    <nav class="navbar navbar-expand-lg" style="background: linear-gradient(135deg, #92fe9d 0% , #00c9ff 100%);">
      <div class="container-fluid">
        <a class="navbar-brand" style="color:rgb(255, 255, 255);" href="#">اصلاح نتایج</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="admin.php">خانه</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="register.php">ثبت نتایج</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="teamedit.php">مدیریت تیم‌ها</a>
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
          <form  method="POST" id="resultedit"
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
              <option value="daste1z17" >لیگ دسته یک زیر 17 سال</option>
              <option value="daste1z15" >لیگ دسته یک زیر 15 سال</option>
              <option value="daste1z14" >لیگ دسته یک زیر 14 سال</option>
              <option value="daste1z13" >لیگ دسته یک زیر 13 سال</option>
              <option value="osve" >لیگ اسوه</option>
            </select>
            <br>
            <div class="text-center mt-4">
              <button type="submit" class="btn btn-success btn-lg px-5 py-2">انتخاب جدول</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- // ? table for edit name  -->
    <div class="img" style="margin-top: 50px; padding-bottom: 50px ;text-align: center;" class="container-fluid py-4 table-responsive-sm">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
          <div class="table-responsive rounded-3 shadow-sm" style="margin-bottom: 80px;">
          <table class="table table-primary table-striped">
              <thead style="text-align: center;">
                <tr>
                  <th scope="col">ردیف</th>
                  <th scope="col">نام تیم</th>
                  <th scope="col">عملیات</th>  
                </tr>
              </thead>
              <tbody style="text-align: center;">
                <?php
                  $num = 0;
                  if(isset($_SESSION['result_table']))
                  {
                    while($show = mysqli_fetch_assoc($table_sql))
                    {
                      $num++;
                      $id = $show['id'];
                      $name = $show['name'];
                      echo "
                        <tr>
                          <th scope=\"row\">$num</th>
                          <td>$name</td>
                          <td> 
                            <a href=\"?edit=$id\" type=\"button\" class=\"btn btn-info\"> <i class=\"bi bi-pencil-square\"></i>اصلاح نتایج</a> 
                          </td>
                        </tr>
                      ";
                    }
                  }
                ?>
              </tbody>
            </table>
          </div> 
        </div>
      </div>                      
    </div>

    <!-- // ? footer -->
    <footer class="footer ">
      <p class="text-footer">Create By <a class="footer-link" href="https://hosbyte.ir">Hosbyte</a> Programmer</p>
    </footer>

    <!-- // ? style -->
    <style>
      input{
        padding-right: 10px;
      }
    </style>
  </body>
</html>