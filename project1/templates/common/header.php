<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Getting Shit Done App</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">

  <link href='//fonts.googleapis.com/css?family=Raleway:400,300,600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="/assets/css/main.css">

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
</head>

<body>

    <div class="navbar-top" >
      <a href="#home">Home</a>
      <a href="#news">News</a>
      <a href="#contact">Contact</a>
      <a href="#about">About</a>
      <div class="nav-right">
          <?php if (isset($_SESSION['username']) && $_SESSION['username'] != '') { ?>
              <a href="user.php"><?=$_SESSION['username']?></a>
              <a href="action_logout.php">Logout</a>
          <?php } else { ?>
              <a href="login.php">Login</a>
              <a href="register.php">Register</a>
          <?php } ?>
      </div>

    </div>