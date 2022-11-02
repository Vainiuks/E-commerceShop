<?php
require_once 'classes/cart.class.php';
$cartObj = new Cart();
$cartItemCount = $cartObj->getCartCount();
// session_start();
$userType = "";

if (isset($_SESSION['userType'])) {
  $userType = $_SESSION['userType'];
} else {
  $userType = "";
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Candy shop</title>
  <link rel="stylesheet" href="includes/styles.css">
</head>

<body>


  <section style="background: #55d6aa;; color: #fff;" class="HeaderSection">
    <nav class="stroke">
      <a href="index.php">
        <img src="includes/images/logo.png" alt="logo" class="logo">
      </a>

      <ul class="nav-list">
        <li><a href="index.php">Home</a></li>
        <li><a href="aboutus.php">About us</a></li>
        <li><a href="fusioncharts.php">Statistics</a></li>

        <form action="index.php" method="POST">
          <input class="headerInput" type="text" name="search_input" placeholder="Search..">
          <button style="border: none; cursor: pointer; background-color: #55d6aa;" type="submit" name="search_button_submit"><img src="includes/images/searchButton.png" height="20" width="30" /></button>
        </form>

      </ul>
      <div class="rightNav">
        <ul class="nav-list-right">
          <?php if ($userType == "") { ?>
            <a href="cart.php"><img src="includes/images/cart.png" style="width:30px; height:25px; margin-left:-20px; margin-top:10px;">
            <sup class="supClass"><?php echo (string)$cartItemCount ?></sup>
            </a>
            <li><a href="signup.php">Sign up</a></li>
            <li><a href="login.php">Login</a></li>
          <?php } elseif ($userType == "User") { ?>
            <a href="cart.php"><img src="includes/images/cart.png" style="width:30px; height:25px; margin-left:-20px; margin-top:10px;"><sup class="supClass"><?php echo (string)$cartItemCount ?></sup></a>
            <ul class="dropdownUL">
              <li class="dropdown">
                <a href="#" class="dropbtn"><?php echo $_SESSION["username"]; ?></a>
                <div class="dropdown-content">
                  <a href="settings.php">Settings</a>
                  <a href="includes/logout.inc.php">Logout</a>
                </div>
              </li>
            </ul>
          <?php } elseif ($userType == "Admin") { ?>
            <a href="cart.php"><img src="includes/images/cart.png" style="width:30px; height:25px; margin-left:-20px; margin-top:10px;"><sup class="supClass"><?php echo (string)$cartItemCount ?></sup></a>
            <ul class="dropdownUL">
              <li class="dropdown">
                <a href="#" class="dropbtn"><?php echo $_SESSION["username"]; ?></a>
                <div class="dropdown-content">
                  <a href="adminpanel.php">Admin panel</a>
                  <a href="settings.php">Settings</a>
                  <hr>
                  <a href="includes/logout.inc.php">Logout</a>
                </div>
              </li>
            </ul>
          <?php } else { ?>
            <li><a href="signup.php">Sign up</a></li>
            <li><a href="login.php">Login</a></li>
            <?php } ?>
        </ul>
      </div>
    </nav>
  </section>

</body>

</html>