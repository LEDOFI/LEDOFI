<?php include("../../path.php"); ?>
<?php session_start();
require(ROOT_PATH . "/app/database/db.php");?>
<?php
if(isset($_SESSION['role'])) {
?>
<?php

// initializing variables
$id = "";
$username = "";
$email = "";
$password = "";
$passwordConf = "";
$role = "";
$errors = array(); 

if(isset($_POST['update-user']) == false) // when not clicked on Update button
{
	$id = $_SESSION['id'];
	$username = $_SESSION['username'];
	
	$qry = mysqli_query($conn,"select * from users where id='$id'"); // select query
    $data = mysqli_fetch_array($qry); // fetch data
	
	$email = $data['email'];
}

if(isset($_POST['update-user']))
{
	

	$id = $_SESSION['id'];
    $username = $_REQUEST['username'];
    $email = $_REQUEST['email'];
	$password = $_REQUEST['password'];
	$passwordConf = $_REQUEST['passwordConf'];
	
	if (empty($username)) { array_push($errors, "Vyžadováno uživatelské jméno"); }
	if (empty($email)) { array_push($errors, "Vyžadován email"); }
	if (empty($password)) { array_push($errors, "Vyžadováno heslo"); }
	if ($password != $passwordConf) { array_push($errors, "Hesla se neshodují"); }


	$user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' EXCEPT SELECT * FROM users WHERE (username='$username' OR email='$email') AND id='$id'";
	$result = mysqli_query($conn, $user_check_query);
	$user = mysqli_fetch_assoc($result);

	if ($user) { // if user exists
		if ($user['username'] === $username) {
			array_push($errors, "Uživatelské jméno již existuje");
		}

		if ($user['email'] === $email) {
			array_push($errors, "Email již existuje");
		}
	}

	// Finally, register user if there are no errors in the form	
	if (count($errors) == 0) {
	
		$password = md5($password);//encrypt the password before saving in the database
		
		$edit = mysqli_query($conn,"update users set username='$username', email='$email', password='$password' where id='$id'");
		
		if($edit != null)
		{
			mysqli_close($conn); // Close connection
			$_SESSION['username'] = $username;
			$_SESSION['message'] = 'Uživatel upraven';
			$_SESSION['type'] = 'success';
			header('location: ' . BASE_URL . '/autor/dashboard.php');  // redirects to all records page
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

        <title>Změna uživatelských údajů</title>
    </head>

    <body>
        
    <?php include(ROOT_PATH . "/app/includes/dashboardHeader.php"); ?>

        <!-- Admin Page Wrapper -->
        <div class="admin-wrapper">

        <?php include(ROOT_PATH . "/app/includes/dashboardSidebar.php"); ?>


            <!-- Admin Content -->
            <div class="admin-content">
                <div class="button-group">
                </div>


                <div class="content">

                    <h2 class="page-title">Upravit uživatele</h2>

                    <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?>

                    <form action="edit.php" name="theForm" id="theForm" method="post">
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
                            <button type="submit" name="update-user" class="btn btn-big">Upravit uživatele</button>
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