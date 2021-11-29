<?php 
include("path.php");
session_start();
require(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . '/app/controllers/doc2txt.class.php');

if (isset($_GET['id'])) {

  	$id = $_GET['id']; 

	$post_query = mysqli_query($conn,"SELECT * FROM posts, posts_assets, posts_autors
							INNER JOIN (SELECT id, MAX(verze) AS MaxVerze FROM posts_autors GROUP BY id) groupedPostsAutors ON posts_autors.id = groupedPostsAutors.id AND posts_autors.verze = groupedPostsAutors.MaxVerze 
						WHERE posts.id=posts_autors.id AND posts.id=posts_assets.id AND posts_autors.verze=posts_assets.verze AND posts.published='1' AND posts.id='$id'"); // select query

	$post = mysqli_fetch_array($post_query); // fetch data
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=BioRhyme&family=Lora&display=swap" rel="stylesheet">

  <!-- Custom Styling -->
  <link rel="stylesheet" href="assets/css/style.css">

  <title><?php echo $post['title']; ?> | Los Polos Technikos</title>
</head>

<body>

  <?php include(ROOT_PATH . "/app/includes/header.php"); ?>

  <!-- Page Wrapper -->
  <div class="page-wrapper">

    <!-- Content -->
    <div class="content clearfix">

      <!-- Main Content Wrapper -->
      <div class="main-content-wrapper">
        <div class="main-content single">
          <h1 class="post-title"><?php echo $post['title']; ?></h1>

          <div class="post-content">
           
           	<?php
 
			$postID = $post['id'];
            $results_2 = mysqli_query($conn," SELECT * FROM posts, posts_assets, posts_autors
							INNER JOIN (SELECT id, MAX(verze) AS MaxVerze FROM posts_autors GROUP BY id) groupedPostsAutors ON posts_autors.id = groupedPostsAutors.id AND posts_autors.verze = groupedPostsAutors.MaxVerze 
						WHERE posts.id=posts_autors.id AND posts.id=posts_assets.id AND posts_autors.verze=posts_assets.verze AND posts.published='1' AND posts.id='$id' AND posts.id='$id'"); // select query
			
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
      <!-- // Main Content -->

      <!-- Sidebar -->
      <div class="sidebar single">

        <div class="section popular">
          <h2 class="section-title">Oblíbené</h2>

          <?php
			$sql = "SELECT * FROM posts, posts_assets, posts_autors
						INNER JOIN (SELECT id, MAX(verze) AS MaxVerze FROM posts_autors GROUP BY id) groupedPostsAutors ON posts_autors.id = groupedPostsAutors.id AND posts_autors.verze = groupedPostsAutors.MaxVerze 
					WHERE posts.id=posts_autors.id AND posts.id=posts_assets.id AND posts_autors.verze=posts_assets.verze AND posts.published='1'
					GROUP BY posts.id";
			$results = mysqli_query($conn,$sql);
			while ($p = mysqli_fetch_assoc($results)) {
		  ?>
            <div class="post clearfix">
              <img src="<?php echo BASE_URL . '/assets/images/' . $p['image']; ?>" alt="">
              <a href="" class="title">
                <h4><?php echo $p['title'] ?></h4>
              </a>
            </div>
          <?php } ?>
          

        </div>

      </div>
      <!-- // Sidebar -->

    </div>
    <!-- // Content -->

  </div>
  <!-- // Page Wrapper -->

  <?php include(ROOT_PATH . "/app/includes/footer.php"); ?>


  <!-- JQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Slick Carousel -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

  <!-- Custom Script -->
  <script src="assets/js/scripts.js"></script>

</body>

</html>