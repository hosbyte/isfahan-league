<?php
  $db = mysqli_connect('localhost' , '' , '' , '');

  if (!$db)
  {
    die("Database connection failed: " . mysqli_connect_error());
  }

  mysqli_set_charset($db, "utf8mb4");
  
  header('content-Type : text/html; charset=utf-8');
?>