<?php include("../path.php");
session_start();
require(ROOT_PATH . "/app/database/db.php");
if($_SESSION['role']=='ctenar') {
	
	

$errors = array(); 
$id = $_SESSION['id'];


$sql_check = mysqli_query($conn," SELECT * FROM users WHERE id='$id'");
$sql_check_fetch = mysqli_fetch_array($sql_check);
if($sql_check_fetch['zadost_na_zmenu_role'] == '0') {



    if(isset($_POST['poslat-zadost'])) 
    {
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

        <title>Čtenář - Žádost o změnu role</title>
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

                    <h2 class="page-title">Žádost o změnu role</h2>

                    <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?>
                    
                    <?php
                    	if($sql_check_fetch['zadost_na_zmenu_role'] == '0') {
                    ?>
						
                    <form action="zadost_o_zmenu_role.php" name="theForm" id="theForm" method="post" enctype="multipart/form-data">
	                    <div>
	                        <label>Zvolte roli, o kterou žádáte.</label><br><br><br>
	                        <label>Role Autor</label>
							<input type="radio" name="zadost_na_zmenu_role" value="autor"><br>
	                    </div>
                        <div>
                            <button type="submit" name="poslat-zadost" class="btn btn-big">Poslat žádost</button>
                        </div>
                    </form>
                    
                    <?php
                    	}
                    	else
                        {
                            echo "Počkejte na vyřízení předchozí žádosti.";
                        }
                    ?>

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