<?php
session_start();


$username = "";
$email    = "";
$errors = array(); 

$db = mysqli_connect('localhost', 'id17928260_ledofi', 'Superheslo.123', 'id17928260_ledofi_db');

// REGISTER USER
if (isset($_POST['register-btn'])) {

  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);


  if (empty($username)) { array_push($errors, "Vyžadováno jméno"); }
  if (empty($email)) { array_push($errors, "Vyžadován email"); }
  if (empty($password_1)) { array_push($errors, "Vyžadováno heslo"); }
  if ($password_1 != $password_2) {
	array_push($errors, "Hesla se neshodují");
  }


  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Uživatelské jméno již existuje");
    }

    if ($user['email'] === $email) {
      array_push($errors, "Email již existuje");
    }
  }


  if (count($errors) == 0) {
  	$password = md5($password_1);

  	$query = "INSERT INTO users (username, email, password) 
  			  VALUES('$username', '$email', '$password')";
  	$xyc = mysqli_query($db, $query);
	
	  if (!empty($username) && !empty($password)) {
		$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
		$result = mysqli_query($db, $query);
		$user = mysqli_fetch_assoc($result);
		$count = mysqli_num_rows($result); 
		if ($count == 1) {
			$_SESSION['id'] = $user['id'];
			$_SESSION['username'] = $user['username'];
			$_SESSION['role'] = $user['role'];
			$_SESSION['success'] = "Nyní jste přihlášen/a";
			header('location: index.php');
		}else {
			array_push($errors, "Špatně zadané uživatelské jméno/heslo");
		}
	  }
  }
}

// LOGIN USER
if (isset($_POST['login-btn'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Vyžadováno jméno");
  }
  if (empty($password)) {
  	array_push($errors, "Vyžadováno heslo");
  }

  if (!empty($username) && !empty($password)) {
  	$password = md5($password);
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
	$result = mysqli_query($db, $query);
	$user = mysqli_fetch_assoc($result);
	$count = mysqli_num_rows($result); 
  	if ($count == 1) {
		$_SESSION['id'] = $user['id'];
		$_SESSION['username'] = $user['username'];
		$_SESSION['role'] = $user['role'];
		$_SESSION['success'] = "Nyní jste přihlášen/a";
		header('location: index.php');
  	}else {
  		array_push($errors, "Špatně zadané uživatelské jméno/heslo");
  	}
  }
}

?>