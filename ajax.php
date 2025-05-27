<?php
include 'db.php';
session_start();


// ? login
if (isset($_POST['user']) && isset($_POST['pass']))
{
  // مقدار دهی متغیر ها
  $username = mysqli_real_escape_string($db , $_POST['user']);
  $pass = mysqli_real_escape_string($db , $_POST['pass']);

  // بررسی درستی اطلاعات ورود

  $query = ( "SELECT * FROM user WHERE  username = '$username' AND pass = '$pass'");
  $result = mysqli_query($db , $query);

   if (!$result)
  {
    die("Query failed: " . mysqli_error($db)); // نمایش خطا برای دیباگ
  }

  // ذخیره اطلاعات در سسشن ها
  if (mysqli_num_rows($result) == 1)
  {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['username'] = $row['username'];
    $_SESSION['name'] = $row['name'];

    echo("1"); // بررسی موفق
  }
  else
  {
    echo(0); // بررسی ناموفق
  }
}
?>