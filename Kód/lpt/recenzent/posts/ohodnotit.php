<?php include("../../path.php");
session_start();
require(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . '/app/controllers/doc2txt.class.php');
if($_SESSION['role']=='recenzent') {
	

$errors = array(); 

if(isset($_POST['poslat-recenzi']) == false)
{

	$id = $_GET['id'];
	
	$post_query = mysqli_query($conn,"SELECT * FROM posts, posts_assets, posts_autors
							INNER JOIN (SELECT id, MAX(verze) AS MaxVerze FROM posts_autors GROUP BY id) groupedPostsAutors ON posts_autors.id = groupedPostsAutors.id AND posts_autors.verze = groupedPostsAutors.MaxVerze 
						WHERE posts.id=posts_autors.id AND posts.id=posts_assets.id AND posts_autors.verze=posts_assets.verze AND posts.status='poslano recenzentovi' AND posts.id='$id'"); // select query

	$post = mysqli_fetch_array($post_query); // fetch data
	
	$title = $post['title'];
	$verze = $post['verze'];
	$document = $post['document'];
}

if(isset($_POST['poslat-recenzi']))
{
	$id = $_REQUEST['id'];
	$verze = $_REQUEST['verze'];
	$aktualnost = $_REQUEST['aktualnost'];
	$originalita = $_REQUEST['originalita'];
	$odborna_uroven = $_REQUEST['odborna_uroven'];
	$jazykova_uroven = $_REQUEST['jazykova_uroven'];
	$message_recenzent_to_autor = $_REQUEST['message_recenzent_to_autor'];
	$hodnoceni = $_REQUEST['hodnoceni'];
	$recenzent_id = $_SESSION['id'];
	
	if (empty($aktualnost)) { array_push($errors, "aktualnost is required"); }
	if (empty($originalita)) { array_push($errors, "originalita is required"); }
	if (empty($odborna_uroven)) { array_push($errors, "odborna_uroven is required"); }
	if (empty($jazykova_uroven)) { array_push($errors, "jazykova_uroven is required"); }
	if (empty($message_recenzent_to_autor)) { array_push($errors, "message_recenzent_to_autor is required"); }
	if (empty($hodnoceni)) { array_push($errors, "hodnoceni is required"); }
	
      // OCHRANA PROTI DOUBLE INSERT
      $ochrana_proti_double_insert = mysqli_query($conn, "SELECT * FROM posts_recenze WHERE id='$id' AND recenzent_id='$recenzent_id' AND verze='$verze'");
      
      if ($ochrana_proti_double_insert->num_rows) {
  		mysqli_close($conn); // Close connection
		$_SESSION['message'] = "Článek byl úspěšně odeslán recenzentovi.";
		$_SESSION['type'] = 'success';
		header('location: ' . BASE_URL . '/recenzent/posts/index.php');
		exit;
      }	


	if (count($errors) == 0) {

		$sql_insert = mysqli_query($conn,"INSERT INTO posts_recenze SET id='$id', recenzent_id='$recenzent_id', aktualnost='$aktualnost', originalita='$originalita', odborna_uroven='$odborna_uroven', jazykova_uroven='$jazykova_uroven', message_recenzent_to_autor='$message_recenzent_to_autor', hodnoceni='$hodnoceni', verze='$verze'");
		
		if($sql_insert != null)
		{
		    $sql_update = mysqli_query($conn,"UPDATE posts_vybrani_recenzenti SET submitted='1' WHERE id='$id' AND verze='$verze' AND recenzent_id='$recenzent_id'");
		    
			$array = array();
			$sql_check = mysqli_query($conn,"SELECT submitted FROM posts_vybrani_recenzenti WHERE id='$id' AND verze='$verze'");
            while ($submitted = mysqli_fetch_assoc($sql_check)) {
			        array_push($array, $submitted);
			}
			$array_submitted = array_column($array, 'submitted');

			if (in_array('0', $array_submitted)){
			    
				mysqli_close($conn); // Close connection
				$_SESSION['message'] = "Recenze úspěšně odeslána";
				$_SESSION['type'] = 'success';
				header('location: ' . BASE_URL . '/recenzent/posts/index.php');  // redirects to all records page
				exit;
			}
			else
			{
				$sql_update_2 = mysqli_query($conn,"UPDATE posts SET status='recenze vypracovany', last_changed_at=now() WHERE id='$id'");
				
				if($sql_update_2 != null)
				{
					mysqli_close($conn); // Close connection
					$_SESSION['message'] = "Recenze úspěšně poslána";
					$_SESSION['type'] = 'success';
					header('location: ' . BASE_URL . '/recenzent/posts/index.php');  // redirects to all records page
					exit;
				}
				else
				{
					echo mysqli_error();
				}
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

        <title>Recenzent - Ohodnotit článek</title>
    </head>

    <body>
        
    <?php include(ROOT_PATH . "/app/includes/dashboardHeader.php"); ?>

        <!-- Admin Page Wrapper -->
        <div class="admin-wrapper">

        <?php include(ROOT_PATH . "/app/includes/dashboardSidebar.php"); ?>


            <!-- Admin Content -->
            <div class="admin-content">

                <div class="content">

                    <h2 class="page-title">Ohodnotit článek</h2>
                    <h3 class="page-title">Název článku: <?php echo $title ?></h3>

                    <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?>
					
						<div>
							<?php
				 
							$results_2 = mysqli_query($conn," SELECT * FROM posts, posts_assets, posts_autors
											INNER JOIN (SELECT id, MAX(verze) AS MaxVerze FROM posts_autors GROUP BY id) groupedPostsAutors ON posts_autors.id = groupedPostsAutors.id AND posts_autors.verze = groupedPostsAutors.MaxVerze 
										WHERE posts.id=posts_autors.id AND posts.id=posts_assets.id AND posts_autors.verze=posts_assets.verze AND posts.id='$id'"); // select query
							
							while ($autor = mysqli_fetch_assoc($results_2)) {
							
									echo '<p style="text-align:center">Autor článku ' . $autor['autor_clanku'] . '</p>';
							
									echo '<p style="text-align:center">Email autora článku ' . $autor['email_autora_clanku'] . '</p>';
							
							}
							 
							$docObj = new Doc2Txt(ROOT_PATH . "/assets/documents/" . $document);

							$txt = $docObj->convertToText();
							echo $txt;
							?>
                        </div>
						
                    <form action="ohodnotit.php" name="theForm" id="theForm" method="post" enctype="multipart/form-data">
                        <div>
						    <input type="hidden" name="id" value="<?php echo $id ?>">
							<input type="hidden" name="verze" value="<?php echo $verze ?>">
							<label>Datum:</label>
							<input type="date" value="<?php echo date('Y-m-d'); ?>" readonly>
                        </div>
                        <div>
							<label>Hodnocení článku</label>
							<table>
							  <tr>
								<th></th>
								<th>výborný</th>
								<th>chvalitebný</th>
								<th>dobrý</th>
								<th>dostatečný</th>    
								<th>nedostatečný</th>
							  </tr>
							  <tr>
								<td>aktuálnost, zajímavost a přínosnost</td>
								<td><input type="radio" name="aktualnost" value="5" required></td>
								<td><input type="radio" name="aktualnost" value="4"></td>
								<td><input type="radio" name="aktualnost" value="3"></td>
								<td><input type="radio" name="aktualnost" value="2"></td>
								<td><input type="radio" name="aktualnost" value="1"></td>
							  </tr>
							  <tr>
								<td>originalita</td>
								<td><input type="radio" name="originalita" value="5" required></td>
								<td><input type="radio" name="originalita" value="4"></td>
								<td><input type="radio" name="originalita" value="3"></td>
								<td><input type="radio" name="originalita" value="2"></td>
								<td><input type="radio" name="originalita" value="1"></td>
							  </tr>
								<tr>
								<td>odborná úroveň</td>
								<td><input type="radio" name="odborna_uroven" value="5" required></td>
								<td><input type="radio" name="odborna_uroven" value="4"></td>
								<td><input type="radio" name="odborna_uroven" value="3"></td>
								<td><input type="radio" name="odborna_uroven" value="2"></td>
								<td><input type="radio" name="odborna_uroven" value="1"></td>
							  </tr>
								<tr>
								<td>jazyková a stylistická úroveň</td>
								<td><input type="radio" name="jazykova_uroven" value="5" required></td>
								<td><input type="radio" name="jazykova_uroven" value="4"></td>
								<td><input type="radio" name="jazykova_uroven" value="3"></td>
								<td><input type="radio" name="jazykova_uroven" value="2"></td>
								<td><input type="radio" name="jazykova_uroven" value="1"></td>
							  </tr>
							</table>
                        </div>
                        <div>
                            <label>Textové pole na otevřenou odpověď.</label>
                            <textarea rows="4" cols="50" name="message_recenzent_to_autor" placeholder="Zadejte vaši odpověď..." class="text-input" required></textarea>
                        </div>
	                    <div>
	                        <label>Příjmout článek</label>
	                        <input type="radio" name="hodnoceni" value="Článek byl přijat" required><br>
	                        <label>Příjmout článek s výhradami</label>
							<input type="radio" name="hodnoceni" value="Článek byl přijat s výhradami"><br>
							<label>Zamítnout článek</label>
							<input type="radio" name="hodnoceni" value="Článek byl zamítnut"><br>
	                    </div>
                        <div>
                            <button type="submit" name="poslat-recenzi" class="btn btn-big">Odeslat recenzi</button>
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

<?php } else { echo 'Nemáte roli ´´recenzent´´.'; } ?>