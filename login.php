<?php
include 'db.php';
session_start();

//?بررسی سسشن ها

if(isset($_SESSION['username']))
{
  //?بررسی ادمین بودن کاربر

  if($_SESSION['role'] = 'admin')
  {
    header('location : admin.php');
  }
  else
  {
    header('location : index.php');
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="rtl">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <link rel="icon" type="image/png" href="favicon.png"> -->
    <link href="style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>League Nama</title>
  </head>
  <body> 
    <!-- // ? navbar -->
    <!-- <nav class="navbar navbar-expand-lg bg-success">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">خانه</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="add.php">افزودن تیم</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">ورود</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">خروج</a>
            </li>
          </ul>
        </div>
      </div>
    </nav> -->

    <!-- // ? form -->
    <div class="login">
      <h2 style="color: aquamarine;">ورود</h2>
      <form method="POST" onsubmit="send(); return false;">
        <p style="margin-bottom: 10px; color: aquamarine;">نام کاربری</p>
        <input id="user" name="user" type="text" class="user" style="margin-bottom: 10px; border-radius: 20px;">
        <p style="margin-bottom: 10px; color: aquamarine;">رمز عبور</p>
        <input id="pass" name="pass" type="text" style="margin-bottom: 20px; border-radius: 20px;" class="pass">
        <br>
        <button class="but" type="submit"> ورود </button>
        <br>
      </form>
    </div>
        
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