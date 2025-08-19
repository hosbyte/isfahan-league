<?php
include 'db.php';
session_start();

// ? check admin
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
    $_SESSION['tableselect'] = $_POST['table'];
    $table = $_POST['table'];

    // اعتبارسنجی نام جدول
    $allowed_tables = ['d2z17', 'd2z15', 'd2z14', 'd2z13'];
    if(!in_array($table, $allowed_tables)) 
    {
        die("0"); // جدول نامعتبر
    }

    $sql_query = ("SELECT id, name FROM `$table`");
    $sql_result = mysqli_query($db , $sql_query);

    if(!$sql_result)
    {
        die("0");
    }

    // ? save all data
    $_SESSION["save_data"] = [];
    while($row = mysqli_fetch_assoc($sql_result))
    {
        $_SESSION["save_data"][] = $row;
    }
    echo "1";
    exit();
    return;
}

// ? add team
$name = null;
$query = null;
$sql = null;
if(isset($_POST['name']))
{
    if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin')
    {
        $table = $_SESSION["tableselect"];
        $name = $_POST['name'];
        $query = ("INSERT INTO `$table`(`name`, `point`, `mp`, `win`, `drow`, `lost`, `f`, `a`, `gd`) VALUES ('$name','0','0','0','0','0','0','0','0')");
        $sql = mysqli_query($db , $query);
    }

    //page refresh
    header('Location: teamedit.php');
}

// ? show name team for edit or delete
$table_query = null;
$table_sql = null; 
 
// ? query
$table = $_SESSION["tableselect"];
$table_query = ("SELECT `id` , `name` FROM `$table` ORDER BY `point` DESC , `id` DESC");
$table_sql =mysqli_query($db , $table_query);

// ? delete one team
$id = null;
$delete_query = null;
$delete_sql = null;
if(isset($_GET['del']))
{
    if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin')
    {
        $table = $_SESSION["tableselect"];
        $id = $_GET['del'];
        $delete_query = ("DELETE FROM `$table` WHERE id = $id");
        $delete_sql =mysqli_query($db , $delete_query);
    }

    // page refresh
    header('Location: teamedit.php');
    exit();
}

// ? show teams name for edit in modal
$name_show = null;
$show_id = null;
if(isset($_GET['edit']))
{
    if($_SESSION['role'] === 'admin')
    {
        $table = $_SESSION["tableselect"];
        $show_id = intval($_GET['edit']);
        $show_query = ("SELECT `name` FROM `$table` WHERE `id` = '$show_id'");
        $show_sql = mysqli_query($db , $show_query);
        while($read = mysqli_fetch_assoc($show_sql))
        {
            $name_show = $read['name'];
        }
    }
}
// ? update teams name
if (isset($_POST['update']))
{
    $table = $_SESSION["tableselect"];
    $show_id = $_POST['team_id'];
    $team_name = $_POST['team_name'];

    // ! query
    if($_SESSION['role'] === 'admin')
    {
        $update_query = ("UPDATE `$table` SET `name` = '$team_name' WHERE `id` = '$show_id'");
        $update_sql = mysqli_query($db , $update_query);
    }
    // page refresh for update
    header('Location: teamedit.php');
    exit();
}

// ? delete all team
$delete_all = null;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_all'])) 
{
    if($_SESSION['role'] === 'admin')
    {
        $table = $_SESSION["tableselect"];
        $delete_all = "TRUNCATE TABLE $table";
        if (mysqli_query($db, $delete_all)) 
        {
            echo "تمام تیم‌ها حذف شدند.";
        } 
        else 
        {
            http_response_code(500);
            echo "خطا در حذف: " . mysqli_error($db);
        }
    }
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
    <body class="body">
        <!-- // ? add modal -->
        <div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">افزودن تیم</h1>
                    </div>
                    <form action="teamedit.php" method="post">
                        <div class="modal-body" style="text-align: center;">    
                            <label style="color: black; margin-top: 10px;" for="nameteam">
                            <h6>نام تیم</h6>
                            </label>
                            <br>
                            <input type="text" name="name" id="nameteam" style="border-radius: 20px;">
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">بستن</button>
                            <button type="submit"  class="btn btn-success">ذخیره</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- // ? edit modal -->
        <div class="modal fade <?php echo isset($_GET['edit']); ?>" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">تغییر نام تیم</h1>
                    </div>
                    <form action="teamedit.php" method="post">
                        <div class="modal-body" style="text-align: center;"> 
                            <input type="hidden" name="team_id" value="<?php echo $_GET['edit']; ?>">  
                            <label style="color: black; margin-top: 10px;" for="nameteam">
                            <h6>نام تیم</h6>
                            </label>
                            <br>
                            <input type="text" value="<?php echo $name_show?>" name="team_name" id="nameteam" style="border-radius: 20px;">
                            <br>
                        </div>
                        <div class="modal-footer">
                            <a href="teamedit.php" type="button" class="btn btn-info" data-bs-dismiss="modal">بستن</a>
                            <button type="submit" name="update" class="btn btn-success">ذخیره</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- // ? navbar -->
        <nav class="navbar navbar-expand-lg" style="background: linear-gradient(135deg, #92fe9d 0% , #00c9ff 100%);">
            <div class="container-fluid">
                <a class="navbar-brand" style="color:rgb(255, 255, 255);" href="#">افزودن تیم</a>
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
                            <a class="nav-link" href="logout.php">خروج</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- // ? select database -->
        <div class="container-fluid py-5 img">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6" >
                    <form  method="POST" id="teamtable"
                     class="bg-info bg-opacity-10 p-3 p-md-5 rounded-3 shadow"
                     style="background: linear-gradient(135deg, #00c9ff 0%, #92fe9d 100%);">
                        <label class="form-label fw-bold">انتخاب جدول:</label>
                        <select id="table" class="form-select form-select-lg">
                                <option value="">-- انتخاب کنید --</option>
                                <option value="d2z17" >زیر 17</option>
                                <option value="d2z15" >زیر 15</option>
                                <option value="d2z14" >زیر 14</option>
                                <option value="d2z13" >زیر 13</option>
                        </select>
                        <br>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success btn-lg px-5 py-2">انتخاب جدول</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- // ? add or delete button -->
        <div class="row col-12 mb-3" style="text-align: center; margin: 20px;">
            <!-- // * add button -->
            <div class="col">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addmodal">
                <i class="bi bi-plus-circle-fill"></i> اضافه کردن تیم
                </button>
            </div>
            <!-- // * delete all team -->
            <div class="col">
                <button id="delete_all" type="submit" class="btn btn-danger">
                <i class="bi bi-trash-fill"></i> حذف تمام تیم ها
                </button>
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
                                                <a href=\"?edit=$id\" type=\"button\" class=\"btn btn-warning\"> <i class=\"bi bi-pencil-square\"></i> تغییر نام</a> 
                                                <a href=\"?del=$id\" type=\"button\" class=\"btn btn-danger\"> <i class=\"bi bi-trash-fill\"></i> حذف تیم</a> </td>
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

        <!-- // ? footer -->
        <footer class="footer ">
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