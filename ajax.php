<?php
include 'db.php';
session_start();

// ? login
if (isset($_POST['user']) && isset($_POST['pass']))
{
  // مقدار دهی متغیر ها
  $user = mysqli_real_escape_string($db , $_POST['user']);
  $pass = mysqli_real_escape_string($db , $_POST['pass']);

  // بررسی درستی اطلاعات ورود
  $resul = mysqli_query($db , "SELECT * FROM user WHERE  'user' = $user AND 'pass' = $pass");

  // ذخیره اطلاعات در سسشن ها
  if (mysqli_num_rows($result) == 1)
  {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['username'] = $row['username'];
    $_SESSION['user'] = $row['user'];
  }
}
?>