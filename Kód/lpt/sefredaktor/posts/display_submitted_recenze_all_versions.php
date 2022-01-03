<?php include("../../path.php");
session_start();
require(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . '/app/controllers/class.filetotext.php');
if($_SESSION['role']=='sefredaktor') {
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

        <title>Redaktor - Zobrazit články</title>
    </head>

    <body>
        
    <?php include(ROOT_PATH . "/app/includes/dashboardHeader.php"); ?>

        <!-- Admin Page Wrapper -->
        <div class="admin-wrapper">

        <?php include(ROOT_PATH . "/app/includes/dashboardSidebar.php"); ?>


            <!-- Admin Content -->
            <div class="admin-content">
                <div class="button-group">
                    <a href="index.php" class="btn btn-big">Spravovat články</a>
                </div>

                <div class="content">

                    <h2 class="page-title">Zobrazit recenze</h2>
                    
    <?php

    if (isset($_GET['id'])) {

  	$id = $_GET['id']; // get id through query string

	$results = mysqli_query($conn," SELECT * FROM posts, posts_assets, posts_vybrani_recenzenti, posts_recenze
									WHERE posts.id=posts_assets.id AND posts.id=posts_vybrani_recenzenti.id AND posts.id=posts_recenze.id AND posts_assets.verze=posts_vybrani_recenzenti.verze AND posts_assets.verze=posts_recenze.verze AND posts_vybrani_recenzenti.recenzent_id=posts_recenze.recenzent_id AND posts.id='$id'
								    ORDER BY posts_assets.verze DESC"); // select query

	while ($post = mysqli_fetch_assoc($results)) {
			?>

      <div class="main-content-wrapper">
        <div class="main-content single">
          <h1 class="post-title"><?php echo $post['title']; ?></h1>

          <div class="post-content">
			 
			<?php
			
			echo '<p style="text-align:center">Verze článku ' . $post['verze'] . '</p>';
		
			$postVERZE = $post['verze'];
	        $results_2 = mysqli_query($conn," SELECT * FROM posts_autors WHERE posts_autors.id='$id' AND posts_autors.verze='$postVERZE'
                                    ORDER BY posts_autors.verze"); // select query
			
            while ($autor = mysqli_fetch_assoc($results_2)) {
			
        			echo '<p style="text-align:center">Autor článku ' . $autor['autor_clanku'] . '</p>';
			
			        echo '<p style="text-align:center">Email autora článku ' . $autor['email_autora_clanku'] . '</p>';
			
			}
			
			$docObj = new Filetotext(ROOT_PATH . "/assets/documents/" . $post['document']);
			//$docObj = new Doc2Txt("test.doc");

			$txt = $docObj->convertToText();
			echo $txt;
			
			echo "<br><br><br>";
			
			$recenzent_id = $post['recenzent_id'];
			
			$results_3 = mysqli_query($conn," SELECT * FROM users, posts_vybrani_recenzenti WHERE users.id='$recenzent_id' AND posts_vybrani_recenzenti.verze='$postVERZE' AND posts_vybrani_recenzenti.id='$id' GROUP BY posts_vybrani_recenzenti.id"); // select query
				while ($recenzent = mysqli_fetch_assoc($results_3)) {
	
				echo "<br><br><div align='right'>Jméno recenzenta: " . $recenzent['username'] . "</div><br>";
			}	
			
			$results_4 = mysqli_query($conn," SELECT * FROM posts_recenze WHERE posts_recenze.verze='$postVERZE' AND posts_recenze.id='$id' AND posts_recenze.recenzent_id='$recenzent_id'"); // select query
			while ($recenzent = mysqli_fetch_assoc($results_4)) {
			
				echo "<div align='right'>Datum recenze: " . $post['created_at'] . "</div><br>";
			}	
						
			echo "<div align='right'>Hodnocení aktuálnost, zajímavost a přínosnost: " . $post['aktualnost'] . " z 5 bodů.</div><br>";
			echo "<div align='right'>Hodnocení originalita: " . $post['originalita'] . " z 5 bodů.</div><br>";
			echo "<div align='right'>Hodnocení odborná úroveň: " . $post['odborna_uroven'] . " z 5 bodů.</div><br>";
			echo "<div align='right'>Hodnocení jazyková a stylistická úroveň: " . $post['jazykova_uroven'] . " z 5 bodů.</div><br>";
			echo "<div align='right'>Otevřená odpověď: " . $post['message_recenzent_to_autor'] . "</div><br><br><br>";
			echo "<div align='right'>Finální hodnocení: " . $post['hodnoceni'] . "</div><br><br><br>";
			
			?>
			
          </div>

        </div>
      </div>
      
<?php } } ?>
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

<?php } else { echo 'Nemáte roli ´´sefredaktor´´.'; } ?>