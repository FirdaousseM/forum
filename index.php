<?php
  session_start();

  // Display errors
  error_reporting(E_ALL);
  ini_set('display_errors', '1');


  // Database Connection
  require_once "./Model/dbConnection.php";
  $db = Connection::getDb();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forum</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100" rel="stylesheet" />
</head>

<body>
  <div class="container">

    <!-- HEADER -->
    <?php include("Static/header.php"); ?>


    <!-- MAIN -->
    <main>
      <?php

      // Main
      if (isset($_GET['ctrl'])) {
        $ctrl = ucfirst($_GET['ctrl']);

        $ctrlClass = $ctrl . 'Controller';

        require_once "./Controller/" . $ctrl . "Controller.php";
        $controller = new $ctrlClass($db);
      }
      else{
        header("Location: index.php?ctrl=topic&action=seeAll");
      }
      ?>
    </main>

    <!-- FOOTER -->
    
    <?php include("Static/footer.php"); ?>
  </div>
</body>

</html>