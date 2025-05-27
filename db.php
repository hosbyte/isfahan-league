<?php
  $db = mysqli_connect('localhost' , 'root' , '' , 'Leaguenama');

  if (!$db)
  {
    die("Database connection failed: " . mysqli_connect_error());
  }
?>