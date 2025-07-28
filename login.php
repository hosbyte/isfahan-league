<?php
include 'db.php';
session_start();

//?بررسی سسشن ها
if(isset($_SESSION['user']))
{
  if($_SESSION['role'] = 'admin' )
  {
    header('location : admin.php');
  }
  else
  {
    header('location : index.php');
  }
}
// if(isset($_SESSION['user']))
// {

//   // //?بررسی ادمین بودن کاربر
//   // if($_SESSION['role'] == 'admin' && $_SESSION['user'] == 'admin17')
//   // {
//   //   header('Location: d2z17a.php');
//   //   exit();
//   // }
//   // elseif($_SESSION['role'] == 'admin' && $_SESSION['user'] == 'admin115')
//   // {
//   //   header('Location: d2z15a.php');
//   //   exit();
//   // }
//   // elseif($_SESSION['role'] == 'admin' && $_SESSION['user'] == 'admin14')
//   // {
//   //   header('Location: d2z14a.php');
//   //   exit();
//   // }
//   // elseif($_SESSION['role'] == 'admin' && $_SESSION['user'] == 'admin13')
//   // {
//   //   header('Location: d2z13a.php');
//   //   exit();
//   // }
//   // elseif($_SESSION['role'] == 'admin' && $_SESSION['user'] == 'majid')
//   // {
//   //   header('Location: admin.php');
//   //   exit();
//   // }
//   // else
//   // {
//   //   header('Location: index.php');
//   //   exit();
//   // }
//   exit();
// }

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
    <link href="https://hosbyte.ir/files/bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet">    
    <link rel="stylesheet" href="https://hosbyte.ir/files/icon/icons-1.11.0/font/bootstrap-icons.min.css">
    <link href="style.css" rel="stylesheet">
    <script src="https://hosbyte.ir/files/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://hosbyte.ir/files/jquery-3.7.1.min.js"></script>
    <title>isfahan league</title>
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
        const username = $('#user').val();
        const password = $('#pass').val();

        $.ajax({
          url: 'ajax.php',
          method: 'POST',
          data: {
            user: username,
            pass: password
          },
          success: function(response) 
          {
            response = response.trim();

            if (response === '1') {
              if (username === 'd2admin17') 
              {
                window.location.href = 'd2z17a.php';
              } 
              else if (username === 'd2admin15') 
              {
                window.location.href = 'd2z15a.php';
              } 
              else if (username === 'd2admin14') 
              {
                window.location.href = 'd2z14a.php';
              } 
              else if (username === 'd2admin13') 
              {
                window.location.href = 'd2z13a.php';
              } 
              else if (username === 'majid')
              {
                window.location.href = 'admin.php';
              }
              else 
              {
                alert("کاربر ناشناخته");
              }
            } else {
              alert("نام کاربری یا رمز عبور اشتباه است");
            }
          },
          error: function() {
            alert("خطای برقراری ارتباط با سرور");
          }
        });
      }
    </script>


  </body>
</html>