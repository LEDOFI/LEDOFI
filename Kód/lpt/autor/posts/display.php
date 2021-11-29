<?php include("../../path.php");
session_start();
require(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . '/app/controllers/doc2txt.class.php');
if($_SESSION['role']=='autor') {
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

        <title>Autor - Zobrazit článek</title>
    </head>

    <body>
        
    <?php include(ROOT_PATH . "/app/includes/dashboardHeader.php"); ?>

        <!-- Admin Page Wrapper -->
        <div class="admin-wrapper">

        <?php include(ROOT_PATH . "/app/includes/dashboardSidebar.php"); ?>


            <!-- Admin Content -->
            <div class="admin-content">
                <div class="button-group">
                    <a href="create.php" class="btn btn-big">Přidat článek</a>
                    <a href="index.php" class="btn btn-big">Spravovat články</a>
                </div>

                <div class="content">

                    <h2 class="page-title">Zobrazit článek</h2>
                    
    <?php

    if (isset($_GET['id'])) {

  	$id = $_GET['id'];

	$results = mysqli_query($conn," SELECT * FROM posts, posts_assets, posts_autors 
                                    WHERE posts.id=posts_autors.id AND posts.id=posts_assets.id AND posts_autors.verze=posts_assets.verze AND posts.id='$id'
                                    GROUP BY posts_assets.verze ORDER BY posts_assets.verze DESC");

	while ($post = mysqli_fetch_assoc($results)) {
			?>

      <div class="main-content-wrapper">
        <div class="main-content single">
          <h1 class="post-title"><?php echo $post['title']; ?></h1>

          <div class="post-content">
			 
			<?php
			
			echo '<p style="text-align:center">Verze článku ' . $post['verze'] . '</p>';
		
			$postVERZE = $post['verze'];
	        $results_2 = mysqli_query($conn," SELECT * FROM posts, posts_assets, posts_autors 
                                    WHERE posts.id=posts_autors.id AND posts.id=posts_assets.id AND posts_autors.verze=posts_assets.verze AND posts_assets.verze=$postVERZE AND posts.id='$id'
                                    ORDER BY posts_assets.verze DESC");
			
            while ($autor = mysqli_fetch_assoc($results_2)) {
			
        			echo '<p style="text-align:center">Autor článku ' . $autor['autor_clanku'] . '</p>';
			
			        echo '<p style="text-align:center">Email autora článku ' . $autor['email_autora_clanku'] . '</p>';
			
			}
			
			$docObj = new Doc2Txt(ROOT_PATH . "/assets/documents/" . $post['document']);
			//$docObj = new Doc2Txt("test.doc");

			$txt = $docObj->convertToText();
			echo $txt;
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

<?php } else { echo 'Nemáte roli ´´Autor´´.'; } ?>