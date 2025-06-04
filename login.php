<?php
include 'db.php';
session_start();

//?بررسی سسشن ها
if(isset($_SESSION['user']))
{
  //?بررسی ادمین بودن کاربر
  if($_SESSION['role'] == 'admin')
  {
    header('Location: admin.php');
    exit();
  }
  else
  {
    header('Location: index.php');
    exit();
  }
  exit();
}

// اگر کاربر لاگین نکرده باشد، مقدار سشن را پاک می‌کنیم
$_SESSION['fullname'] = '';
$_SESSION['tel'] = '';

?>

<!DOCTYPE html>
<html lang="en" dir="rtl">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" type="image/png" href="img/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>League Nama</title>
  </head>
  <body class="body"> 
    <!-- // ? navbar -->
    <nav class="navbar navbar-expand-lg" style="background: linear-gradient(135deg, #92fe9d 0% , #00c9ff 100%);">
        <div class="container-fluid">
            <p class="navbar-brand" style="color:rgb(255, 255, 255);" >ورود</p>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">خانه</a>
                  </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- // ? form -->
    <div class="img container-fluid py-5" style="min-height: 100vh;">
      <div class="row justify-content-center align-items-center h-100">
        <div class="col-11 col-sm-8 col-md-6 col-lg-4">
          <div class="login p-4 p-md-5 rounded-4 shadow-lg" style="background: linear-gradient(135deg,rgb(4, 187, 238) 0%,rgb(0, 0, 0) 100%);">
            <h2 class="text-center mb-4" style="color:rgb(247, 247, 247); font-weight: 700;">ورود</h2>
            <form method="POST" onsubmit="send(); return false;">
              <div class="mb-3">
                <label for="user" class="form-label fw-bold" style="color:rgb(47, 245, 225);">نام کاربری</label>
                <input id="user" name="user" type="text" class="form-control form-control-lg py-2" style="border-radius: 20px;">
              </div>
              <div class="mb-4">
                <label for="pass" class="form-label fw-bold" style="color:rgb(47, 245, 225);">رمز عبور</label>
                <input id="pass" name="pass" type="password" class="form-control form-control-lg py-2" style="border-radius: 20px;">
              </div>
              <div class="d-grid">
                <button class="btn btn-lg text-black fw-bold py-2" type="submit" style="border-radius: 20px; background: #00ced1;"> 
                  ورود <i class="bi bi-box-arrow-in-right me-2"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- // ?footer -->
    <footer class="footer">
        <p class="text-footer">Create By <a class="footer-link" href="https://hosbyte.ir">Hosbyte</a> Programmer</p>
    </footer>

    <!-- // ? jquery -->
    <script>
      function send()
      {
        $.ajax({
          url : 'ajax.php',
          method : 'POST',
          data :{
            user : $('#user').val(),
            pass : $('#pass').val()
          },
          success : function(response)
          {
            response.trim() === '1'
            ?window.location.href = 'admin.php'
            : alert ("نام کاربری یا رمز عبور اشتباه است");
          },
          error : function()
          {
            alert ("خطای برقرار ارتباط با سرور");
          }
        }); 
      }
    </script>
  </body>
</html>