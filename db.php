<?php
  $db = mysqli_connect('localhost' , 'root' , '' , 'LeagueNama');
  if (!$db)
  {
    die("Database connection failed: " . mysqli_connect_error());
  }
?>