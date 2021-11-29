<?php include("../../path.php");
session_start();
require(ROOT_PATH . "/app/database/db.php");
if($_SESSION['role']=='redaktor') {
	
// initializing variables
$errors = array(); 

if(isset($_POST['poslat-recenzentovi']) == false) // when not clicked on Update button
{

	$id = $_GET['id']; // get id through query string
	
	$qry_3 = mysqli_query($conn,"select * from posts_assets where id='$id' ORDER BY verze DESC LIMIT 0, 1"); // select query
	$data_3 = mysqli_fetch_array($qry_3); // fetch data
	$title = $data_3['title'];
	$verze = $data_3['verze'];
}

if(isset($_POST['poslat-recenzentovi'])) // when click on Update button
{
	
	
	$id = $_REQUEST['id'];
	$verze = $_REQUEST['verze'];
    $zvoleni_recenzenti = $_REQUEST['zvoleni_recenzenti'];

	if (empty($id)) { array_push($errors, "Chyba: Nenalezeno identifikační číslo článku."); }
	if (empty($verze)) { array_push($errors, "Chyba: Nenalezena verze článku."); }
	if (empty($zvoleni_recenzenti)) { array_push($errors, "Musíte zvolit recenzenty"); }
	
      // OCHRANA PROTI DOUBLE INSERT
      for($i=0;$i<count($zvoleni_recenzenti);$i++)
		{
        $ochrana_proti_double_insert = mysqli_query($conn, "SELECT * FROM posts_vybrani_recenzenti WHERE id='$id' AND recenzent_id='$zvoleni_recenzenti[$i]' AND verze='$verze'");
		}
      
      if ($ochrana_proti_double_insert->num_rows) {
  		mysqli_close($conn); // Close connection
		$_SESSION['message'] = "Článek byl úspěšně odeslán recenzentovi.";
		$_SESSION['type'] = 'success';
		header('location: ' . BASE_URL . '/redaktor/posts/index.php');  // redirects to all records page
		exit;
      }	



	if (count($errors) == 0) {
		
		for($i=0;$i<count($zvoleni_recenzenti);$i++)
		{
			$sql_post_2 = mysqli_query($conn,"INSERT INTO posts_vybrani_recenzenti SET id='$id', recenzent_id='$zvoleni_recenzenti[$i]', verze='$verze'");
		}
		
		if($sql_post_2 != null)
		{
			$sql_update = mysqli_query($conn,"UPDATE posts SET status='poslano recenzentovi', last_changed_at=now() WHERE id='$id'");
			
			if($sql_update != null)
			{
				mysqli_close($conn); // Close connection
				$_SESSION['message'] = "Článek byl úspěšně odeslán recenzentovi.";
				$_SESSION['type'] = 'success';
				header('location: ' . BASE_URL . '/redaktor/posts/index.php');  // redirects to all records page
				exit;
			}
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

        <title>Redaktor - Poslat recenzentovi</title>
    </head>

    <body>
        
    <?php include(ROOT_PATH . "/app/includes/dashboardHeader.php"); ?>

        <!-- Admin Page Wrapper -->
        <div class="admin-wrapper">

        <?php include(ROOT_PATH . "/app/includes/dashboardSidebar.php"); ?>


            <!-- Admin Content -->
            <div class="admin-content">

                <div class="content">

                    <h2 class="page-title">Poslat článek recenzentovi</h2>
                    <h3 class="page-title">Název článku: <?php echo $title ?></h3>

                    <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?>

                    <form action="poslat_recenzentovi.php" name="theForm" id="theForm" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="hidden" name="verze" value="<?php echo $verze ?>">
                        <div>
                            <label>Zvolte recenzenta:</label>
								<div style="height:360px;width:240px;border:1px solid #ccc; overflow:auto;">
									<?php
										$sql_recenzenti = mysqli_query($conn,"SELECT * FROM users WHERE users.role='recenzent'");
										for ($i = 0; $recenzenti = mysqli_fetch_assoc($sql_recenzenti); $i++) {
											
										$recenzenti_username = $recenzenti['username'];
										$recenzenti_id = $recenzenti['id'];
										
											echo "<input type='checkbox' name='zvoleni_recenzenti[]' value='" . $recenzenti_id . "'>" . $recenzenti_username . "</option><br>";
										}
									?>
								</div>
                        </div>
	                    <div>
                        <div>
                            <button type="submit" name="poslat-recenzentovi" class="btn btn-big">Poslat článek recenzentovi</button>
                        </div>
                    </form>

                </div>

            </div>
            <!-- // Admin Content -->

        </div>
        <!-- // Page Wrapper -->



        <!-- JQuery -->		
		<script src="../../assets/js/jquery.js"></script>
        <!-- Ckeditor -->
        <script
            src="https://cdn.ckeditor.com/ckeditor5/12.2.0/classic/ckeditor.js"></script>
        <!-- Custom Script -->
        <script src="../../assets/js/scripts.js"></script>
		
    </body>

</html>

<?php } else { echo 'Nemáte roli ´´Redaktor´´.'; } ?>