<?php
include 'db.php';
session_start();

// ? admin check
// if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin')
// {
//     header('Location: admin.php');
//     exit();
// }

// ? database conecttion
$query = ("SELECT * FROM `d2z13` ORDER BY point DESC , gd DESC ");
$sql = mysqli_query($db , $query);


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
            <a class="navbar-brand" style="color:rgb(255, 255, 255);" href="#">اصفهان لیگ </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">ورود</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- // ? table -->
    <!-- <div class="img" style="margin-top: 50px; text-align: center;" class="container-fluid py-4 table-responsive-sm">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="table-responsive rounded-3 shadow-sm " style="margin-bottom: 80px;">
                    <div class="gradient-table-wrapper">
                        <table class="gradient-table">
                            <thead>
                                <tr>
                                    <th>رتبه</th>
                                    <th>نام تیم</th>
                                    <th>امتیاز</th>
                                    <th>بازی</th>
                                    <th>برد</th>
                                    <th>مساوی</th>
                                    <th>باخت</th>
                                    <th>گل زده</th>
                                    <th>گل خورده</th>
                                    <th>تفاضل گل</th>
                                </tr>
                            </thead>
                            <tbody style="color : white;">
                                <php
                                $num = 0;
                                while ($show = mysqli_fetch_assoc($sql)) {
                                    $num++;
                                    echo '
                                    <tr>
                                        <td>'.$num.'</td>
                                        <td>'.$show['name'].'</td>
                                        <td>'.$show['point'].'</td>
                                        <td>'.$show['mp'].'</td>
                                        <td>'.$show['win'].'</td>
                                        <td>'.$show['drow'].'</td>
                                        <td>'.$show['lost'].'</td>
                                        <td>'.$show['f'].'</td>
                                        <td>'.$show['a'].'</td>
                                        <td>'.$show['gd'].'</td>
                                    </tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>  -->
    <div class="container-fluid py-4" style="margin-top: 50px;">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="table-responsive" style="margin-bottom: 80px;">
        <div class="gradient-table-wrapper">
          <table class="gradient-table">
            <thead>
              <tr>
                <th class="position-sticky top-0">رتبه</th>
                <th class="position-sticky top-0">نام تیم</th>
                <th class="position-sticky top-0 d-none d-sm-table-cell">امتیاز</th>
                <th class="position-sticky top-0 d-none d-md-table-cell">بازی</th>
                <th class="position-sticky top-0 d-none d-lg-table-cell">برد</th>
                <th class="position-sticky top-0 d-none d-lg-table-cell">مساوی</th>
                <th class="position-sticky top-0 d-none d-md-table-cell">باخت</th>
                <th class="position-sticky top-0 d-none d-sm-table-cell">گل زده</th>
                <th class="position-sticky top-0 d-none d-sm-table-cell">گل خورده</th>
                <th class="position-sticky top-0 d-none d-xl-table-cell">تفاضل گل</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $num = 0;
              while ($show = mysqli_fetch_assoc($sql)) {
                $num++;
                echo '
                <tr>
                  <td>'.$num.'</td>
                  <td><strong>'.$show['name'].'</strong></td>
                  <td class="d-none d-sm-table-cell">'.$show['point'].'</td>
                  <td class="d-none d-md-table-cell">'.$show['mp'].'</td>
                  <td class="d-none d-lg-table-cell">'.$show['win'].'</td>
                  <td class="d-none d-lg-table-cell">'.$show['drow'].'</td>
                  <td class="d-none d-md-table-cell">'.$show['lost'].'</td>
                  <td class="d-none d-sm-table-cell">'.$show['f'].'</td>
                  <td class="d-none d-sm-table-cell">'.$show['a'].'</td>
                  <td class="d-none d-xl-table-cell">'.$show['gd'].'</td>
                </tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


    <!-- // ?footer -->
    <footer class="footer">
        <p class="text-footer">Create By <a class="footer-link" href="https://hosbyte.ir">Hosbyte</a> Programmer</p>
    </footer>

    <!-- // ? style for table -->
     <!-- <style>
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
    
        .gradient-table-wrapper {
        background: linear-gradient(to bottom, #00c8ff86, #92fe9d71);
        border-radius: 10px;
        padding: 1px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .gradient-table {
            width: 100%;
            background-color: transparent;
            border-collapse: collapse;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .gradient-table thead tr {
            /* background: linear-gradient(to right, rgba(146, 254, 157, 1), rgba(0, 200, 255, 1)); */
            /* background: linear-gradient(to right, rgba(0, 0, 0, 1), rgba(255, 0, 0, 1)); */
            background: linear-gradient(to right, rgba(255, 0, 0, 1), rgba(0, 0, 0, 1));
            color: white;
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 1);
        }
        
        .gradient-table tbody tr {
            /* background-color: rgba(255, 255, 255, 0.15); */
            /* background: linear-gradient(to right, rgba(255, 0, 0, 1), rgba(0, 0, 0, 1)); */
            background: linear-gradient(to right, rgba(255, 0, 0, 1), rgba(0, 0, 0, 1));
            transition: all 0.3s ease;
        }
        
        .gradient-table tbody tr:nth-child(even) {
            /* background: linear-gradient(to right, rgba(0, 0, 0, 1), rgba(255, 0, 0, 1)); */
            background: linear-gradient(to right, rgba(255, 0, 0, 1), rgba(0, 0, 0, 1));
        }
        
        .gradient-table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.4);
        }
        
        .gradient-table th, 
        .gradient-table td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .gradient-table th {
            font-weight: 600;
            letter-spacing: 0.5px;
        }
    </style>  -->
    <style>
  .gradient-table-wrapper {
    background: linear-gradient(to bottom, #00c8ff86, #92fe9d71);
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }
  
  .gradient-table {
    width: 100%;
    min-width: 650px;
    background-color: rgba(255, 255, 255, 0.9);
    color: #2c3e50;
    font-family: 'Yekan', 'Segoe UI', sans-serif;
    border-collapse: collapse;
  }
  
  .gradient-table thead tr {
    background: linear-gradient(to right, rgba(255, 0, 0, 1), rgba(0, 0, 0, 1)) !important;
    color: white;
    text-shadow: 1px 1px 2px rgba(255, 255, 255, 1);
  }
  
  .gradient-table tbody tr {
    background: linear-gradient(to right, rgba(255, 0, 0, 1), rgba(0, 0, 0, 1));
    transition: all 0.3s ease;
  }
  
  .gradient-table tbody tr:nth-child(even) {
    background: linear-gradient(to right, rgba(255, 0, 0, 0.9), rgba(0, 0, 0, 0.9));
  }
  
  .gradient-table tbody tr:hover {
    background: linear-gradient(to right, rgba(255, 0, 0, 0.8), rgba(0, 0, 0, 0.8));
  }
  
  .gradient-table th, 
  .gradient-table td {
    padding: 12px 10px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.1);
    white-space: nowrap;
  }
  
  .gradient-table td {
    color: white;
    font-weight: 500;
  }

  /* Responsive fixes */
  .table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }
  
  @media (max-width: 768px) {
    .gradient-table th, 
    .gradient-table td {
      padding: 8px 6px;
      font-size: 0.85rem;
    }
  }
  
  @media (max-width: 576px) {
    .gradient-table th, 
    .gradient-table td {
      padding: 6px 4px;
      font-size: 0.8rem;
    }
  }
</style>

</body>
</html>
