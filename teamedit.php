<?php
include 'db.php';
session_start();

// ? add team
if(isset($_POST['name']))
{
    $name = $_POST['name'];
    $query = ("INSERT INTO `teams`(`name`, `point`, `mp`, `win`, `drow`, `lost`, `f`, `a`, `gd`) VALUES ('$name','0','0','0','0','0','0','0','0')");
    $sql = mysqli_query($db , $query);

    //page refresh
    header('Location: teamedit.php');
}

// ? show name team for edit or delete
$table_query = ("SELECT `id` , `name` FROM `teams` ORDER BY `point` DESC , `id` DESC");
$table_sql =mysqli_query($db , $table_query);

// ? delete one team
if(isset($_GET['del']))
{
    $id = $_GET['del'];
    $delete_query = ("DELETE FROM `teams` WHERE id = $id");
    $delete_sql =mysqli_query($db , $delete_query);

    // page refresh
    header('Location: teamedit.php');
    exit();
}

// ? edit teams name
$name_show = null;
$show_id = null;
if(isset($_GET['edit']))
{
    $show_id = intval($_GET['edit']);
    $show_query = ("SELECT `name` FROM `teams` WHERE `id` = '$show_id'");
    $show_sql = mysqli_query($db , $show_query);
    while($read = mysqli_fetch_assoc($show_sql))
    {
        $name_show = $read['name'];
    }
}
// * update team
if (isset($_POST['update']))
{
    $show_id = $_POST['team_id'];
    $team_name = $_POST['team_name'];

    // query
    $update_query = ("UPDATE `teams` SET `name` = '$team_name' WHERE `id` = '$show_id'");
    $update_sql = mysqli_query($db , $update_query);

    // page refresh for update
    header('Location: teamedit.php');
    exit();
}

// ? delete all team
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_all'])) 
{
    $sql = "TRUNCATE TABLE teams";
    if (mysqli_query($db, $sql)) 
    {
        echo "تمام تیم‌ها حذف شدند.";
    } 
    else 
    {
        http_response_code(500);
        echo "خطا در حذف: " . mysqli_error($db);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>League Nama</title>
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
                            <a class="nav-link active" aria-current="page" href="admin.php">خانه</a>
                        </li
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

        <!-- // ? jquery -->
        <script>
            <!-- // ? modal show jquery -->
            $(document).ready(function() {
                const urlParams = new URLSearchParams(window.location.search);
                if(urlParams.has('edit')) {
                    const myModal = new bootstrap.Modal(document.getElementById('editmodal'));
                    myModal.show();
                }
            });

            // ? delete all jquery
            $(document).ready(function() {
                $("#delete_all").click(function() {
                    if (confirm("آیا مطمئن هستید که می‌خواهید تمام تیم‌ها حذف شوند؟")) {
                        $.ajax({
                            url: 'teamedit.php',
                            type: 'POST',
                            data: { delete_all: true },
                            success: function(response) {
                                alert(response);
                                location.reload(); // برای بروز شدن جدول بعد از حذف
                            },
                            error: function(xhr, status, error) {
                                alert("خطا در حذف: " + error);
                            }
                        });
                    }
                });
            });
        </script>
    </body>
</html>