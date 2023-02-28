<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forum</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <?php
  session_start();

  // Display errors
  error_reporting(E_ALL);
  ini_set('display_errors', '1');


  // Database Connection
  require_once "./Model/dbConnection.php";
  $db = Connection::getDb();




  // Header
  include("Static/header.html");

  // Test
  //include("Static/home.html");

  // Main
  if (isset($_GET['ctrl'])) {
    $ctrl = ucfirst($_GET['ctrl']);

    $ctrlClass = $ctrl . 'Controller';

    require_once "./Controller/" . $ctrl . "Controller.php";
    $controller = new $ctrlClass($db);
  }

  // Footer
  include("Static/footer.html");
  ?>

</body>

</html>