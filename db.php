<?php
  $db = mysqli_connect('localhost' , '' , '' , '');

  if (!$db)
  {
    die("Database connection failed: " . mysqli_connect_error());
  }
?>