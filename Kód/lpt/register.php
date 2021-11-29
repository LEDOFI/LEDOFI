<?php include('path.php'); ?>
<?php include('server.php'); ?>
<?php if (!isset($_SESSION['id'])) { ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=BioRhyme&family=Lora&display=swap" rel="stylesheet">

  <!-- Custom Styling -->
  <link rel="stylesheet" href="assets/css/style.css">

  <title>Registrace</title>
</head>

<body>
  
  
<?php include(ROOT_PATH . "/app/includes/header.php"); ?>

  <div class="auth-content">

    <form action="register.php" name="theForm" method="post">
      <h2 class="form-title">Registrace</h2>

      <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?>

      <div>
        <label>Uživatelské jméno</label>
        <input type="text" name="username" value="<?php echo $username; ?>" class="text-input" >
      </div>
      <div>
        <label>Email</label>
        <input type="email" name="email" value="<?php echo $email; ?>" class="text-input">
      </div>
      <div>
        <label>Heslo</label>
        <input type="password" name="password_1" class="text-input">
      </div>
	  <div>
        <label>Heslo znovu</label>
        <input type="password" name="password_2" class="text-input">
      </div>
      <div>
        <button type="submit" name="register-btn" class="btn btn-big">Registrovat</button>
      </div>
      <p>Nebo se <a href="<?php echo BASE_URL . '/login.php' ?>">Přihlásit</a></p>
    </form>

  </div>


  <!-- JQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Custom Script -->
  <script src="assets/js/scripts.js"></script>

</body>

</html>

<?php } else { header('location: ' . BASE_URL . '/index.php'); exit; } ?>