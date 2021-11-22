<!DOCTYPE html>
<html lang="cs">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=BioRhyme&family=Lora&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="assets/css/style.css">

  <title>Registrace</title>
</head>

<body>
<?php include("app/includes/header.php"); ?>

  <div class="auth-content">

    <form action="register.php" method="post">
      <h2 class="form-title">Registrace</h2>

      <!-- <div class="msg error">
        <li>Username required</li>
      </div> -->

      <div>
        <label>Uživatelské jméno</label>
        <input type="text" name="username" class="text-input">
      </div>
      <div>
        <label>Email</label>
        <input type="email" name="email" class="text-input">
      </div>
      <div>
        <label>Heslo</label>
        <input type="password" name="password" class="text-input">
      </div>
      <div>
        <label>Potvrzení hesla</label>
        <input type="password" name="passwordConf" class="text-input">
      </div>
      <div>
        <button type="submit" name="register-btn" class="btn btn-big">Registrovat</button>
      </div>
      <p>Máte již účet? <a href="login.php">Přihlaste se</a></p>
    </form>

  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script src="assets/js/scripts.js"></script>

</body>

</html>