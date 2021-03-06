<?php include("../../path.php"); ?>
<?php session_start();
require(ROOT_PATH . "/app/database/db.php");?>
<?php
if($_SESSION['role']=='admin') {
?>
<?php


$username = "";
$email = "";
$password = "";
$passwordConf = "";
$role = "";
$errors = array(); 

if(isset($_POST['create-admin']))
{
	

    $username = $_REQUEST['username'];
    $email = $_REQUEST['email'];
	$password = $_REQUEST['password'];
	$passwordConf = $_REQUEST['passwordConf'];
	$role = $_REQUEST['role'];
	
	if (empty($username)) { array_push($errors, "Je vyžadováno uživ. jméno"); }
	if (empty($email)) { array_push($errors, "Je vyžadován email"); }
	if (empty($password)) { array_push($errors, "Je vyžadováno heslo"); }
	if ($password != $passwordConf) { array_push($errors, "Hesla se neshodují"); }
	if (empty($role)) { array_push($errors, "Je vyžadováno zadaní role"); }


	$user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
	$result = mysqli_query($conn, $user_check_query);
	$user = mysqli_fetch_assoc($result);

	if ($user) { 
		if ($user['username'] === $username) {
			array_push($errors, "uživatelské jméno již existuje");
		}

		if ($user['email'] === $email) {
			array_push($errors, "Email již existuje");
		}
	}

	
	if (count($errors) == 0) {
	
		$password = md5($password);
		
		$insert = mysqli_query($conn,"INSERT INTO users SET username='$username', email='$email', password='$password', role='$role'");
		
		if($insert != null)
		{
			mysqli_close($conn); 
			$_SESSION['message'] = 'Admin uživatel byl vytvořen';
            $_SESSION['type'] = 'success';
			header('location: ' . BASE_URL . '/admin/users/index.php'); 
			exit;
		}
		else
		{
			echo mysqli_error();
		}   
	}		
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- Font Awesome -->
        <link rel="stylesheet"
            href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
            integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
            crossorigin="anonymous">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=BioRhyme&family=Lora&display=swap" rel="stylesheet">

        <!-- Custom Styling -->
        <link rel="stylesheet" href="../../assets/css/style.css">

        <!-- Admin Styling -->
        <link rel="stylesheet" href="../../assets/css/admin.css">

        <title>Admin - Přidat uživatele</title>
    </head>

    <body>
        
    <?php include(ROOT_PATH . "/app/includes/dashboardHeader.php"); ?>

        <!-- Admin Page Wrapper -->
        <div class="admin-wrapper">

        <?php include(ROOT_PATH . "/app/includes/dashboardSidebar.php"); ?>


            <!-- Admin Content -->
            <div class="admin-content">
                <div class="button-group">
                    <a href="create.php" class="btn btn-big">Přidat uživatele</a>
                    <a href="index.php" class="btn btn-big">Spravovat uživatele</a>
                </div>


                <div class="content">

                    <h2 class="page-title">Přidat uživatele</h2>

                    <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?>

                    <form action="create.php" name="theForm" id="theForm" method="post">
                        <div>
                            <label>Uživatelské jméno</label>
                            <input type="text" name="username" value="<?php echo $username; ?>" class="text-input">
                        </div>
                        <div>
                            <label>Email</label>
                            <input type="email" name="email" value="<?php echo $email; ?>" class="text-input">
                        </div>
                        <div>
                            <label>Heslo</label>
                            <input type="password" name="password" value="<?php echo $password; ?>" class="text-input">
                        </div>
                        <div>
                            <label>Heslo znovu</label>
                            <input type="password" name="passwordConf" value="<?php echo $passwordConf; ?>" class="text-input">
                        </div>
                        <div>
							  <p>Role:</p>
							  <input type="radio" name="role" value="admin">
							  <label>admin</label><br>
							  <input type="radio" name="role" value="autor">
							  <label>autor</label><br>  
							  <input type="radio" name="role" value="redaktor">
							  <label>redaktor</label><br>
							  <input type="radio" name="role" value="recenzent">
							  <label>recenzent</label><br>
							  <input type="radio" name="role" value="ctenar" checked>
							  <label>čtenář</label><br>
							  <input type="radio" name="role" value="sefredaktor">
							  <label>šéfredaktor</label><br><br>
                        </div>

                        <div>
                            <button type="submit" name="create-admin" class="btn btn-big">Přidat uživatele</button>
                        </div>
                    </form>

                </div>

            </div>
            <!-- // Admin Content -->

        </div>
        <!-- // Page Wrapper -->



        <!-- JQuery -->
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Ckeditor -->
        <script
            src="https://cdn.ckeditor.com/ckeditor5/12.2.0/classic/ckeditor.js"></script>
        <!-- Custom Script -->
        <script src="../../assets/js/scripts.js"></script>
		
    </body>

</html>

<?php } ?>