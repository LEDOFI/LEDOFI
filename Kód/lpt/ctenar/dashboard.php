<?php include("../path.php");
session_start();
require(ROOT_PATH . "/app/database/db.php");
if($_SESSION['role']=='ctenar') {
	
$errors = array(); 

if(isset($_POST['poslat-zadost']))
{
	$id = $_SESSION['id'];
	$zadost_na_zmenu_role = $_REQUEST['zadost_na_zmenu_role'];
	
	if (empty($id)) { array_push($errors, "id is required"); }
	if (empty($zadost_na_zmenu_role)) { array_push($errors, "zadost na zmenu role is required"); }

	if (count($errors) == 0) {

		$sql_update = mysqli_query($conn,"UPDATE users SET zadost_na_zmenu_role='$zadost_na_zmenu_role' WHERE id='$id'");
		
		if($sql_update != null)
		{
    		mysqli_close($conn); // Close connection
    		$_SESSION['message'] = "Žádost byla úspěšně odeslána";
    		$_SESSION['type'] = 'success';
    		header('location: ' . BASE_URL . '/ctenar/dashboard.php'); 
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
        <link rel="stylesheet" href="../assets/css/style.css">

        <!-- Admin Styling -->
        <link rel="stylesheet" href="../assets/css/admin.css">

        <title>Čtenář - Nástěnka</title>
    </head>

    <body>
        
    <?php include(ROOT_PATH . "/app/includes/dashboardHeader.php"); ?>

        <!-- Admin Page Wrapper -->
        <div class="admin-wrapper">

        <?php include(ROOT_PATH . "/app/includes/dashboardSidebar.php"); ?>


            <!-- Admin Content -->
            <div class="admin-content">

                <div class="content">

                    <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>

                    <h2 class="page-title">Nástěnka</h2>


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
        <script src="../assets/js/scripts.js"></script>

    </body>

</html>

<?php } else { echo 'Nemáte roli ´´ctenar´´.'; } ?>