<?php 
include("path.php");
session_start();
require(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . '/app/controllers/doc2txt.class.php');

$posts = array();
$postsTitle = 'Nedávné příspěvky';

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

  <title>Los Polos Technikos</title>
</head>

<body>

  <?php include(ROOT_PATH . "/app/includes/header.php"); ?>
  <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>



  <!-- Page Wrapper -->
  <div class="page-wrapper">

    <!-- Post Slider -->
    <div class="post-slider">
      <h1 class="slider-title">Oblíbené články</h1>
      <i class="fas fa-chevron-left prev"></i>
      <i class="fas fa-chevron-right next"></i>

      <div class="post-wrapper">

		<?php
		
			if (isset($_POST['search-term'])) {
				$postsTitle = "Zadali jste '" . $_POST['search-term'] . "'";
				$posts = $_POST['search-term'];
				$match = '%' . $posts . '%';
				$sql = "SELECT * FROM posts, posts_assets, posts_autors
							INNER JOIN (SELECT id, MAX(verze) AS MaxVerze FROM posts_autors GROUP BY id) groupedPostsAutors ON posts_autors.id = groupedPostsAutors.id AND posts_autors.verze = groupedPostsAutors.MaxVerze 
						WHERE posts.id=posts_autors.id AND posts.id=posts_assets.id AND posts_autors.verze=posts_assets.verze AND posts.published='1' AND posts_assets.title LIKE '$match' GROUP BY posts.id ORDER BY posts.last_changed_at DESC";
			} else {
				$sql = "SELECT * FROM posts, posts_assets, posts_autors
							INNER JOIN (SELECT id, MAX(verze) AS MaxVerze FROM posts_autors GROUP BY id) groupedPostsAutors ON posts_autors.id = groupedPostsAutors.id AND posts_autors.verze = groupedPostsAutors.MaxVerze 
						WHERE posts.id=posts_autors.id AND posts.id=posts_assets.id AND posts_autors.verze=posts_assets.verze AND posts.published='1' GROUP BY posts.id ORDER BY posts.last_changed_at DESC";
				
			}
				$results = mysqli_query($conn,$sql);
				while ($post = mysqli_fetch_assoc($results)) {
		?>
          <div class="post">
            <img src="<?php echo BASE_URL . '/assets/images/' . $post['image']; ?>" alt="" class="slider-image">
            <div class="post-info">
              <h4><a href="single.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h4>
              <i class="far fa-user"> <?php echo $post['autor_clanku']; ?></i>
              &nbsp;
              <i class="far fa-calendar"> <?php echo date('F j, Y', strtotime($post['created_at'])); ?></i>
            </div>
          </div>
		<?php } ?>


      </div>

    </div>
    <!-- // Post Slider -->

    <!-- Content -->
    <div class="content clearfix">

      <!-- Main Content -->
      <div class="main-content">
        <h1 class="recent-post-title"><?php echo $postsTitle ?></h1>

		<?php
				$results = mysqli_query($conn,$sql);
				while ($post = mysqli_fetch_assoc($results)) {
		?>
          <div class="post clearfix">
            <img src="<?php echo BASE_URL . '/assets/images/' . $post['image']; ?>" alt="" class="post-image">
            <div class="post-preview">
              <h2><a href="single.php?id=<?php echo $post['id']; ?>"><?php echo substr($post['title'], 0, 50); ?></a></h2>
              <i class="far fa-user">
                  <?php
                  
                                                         
                    $postID = $post['id'];
                    $results_2 = mysqli_query($conn,"SELECT * FROM posts, posts_assets, posts_autors
							INNER JOIN (SELECT id, MAX(verze) AS MaxVerze FROM posts_autors GROUP BY id) groupedPostsAutors ON posts_autors.id = groupedPostsAutors.id AND posts_autors.verze = groupedPostsAutors.MaxVerze 
						WHERE posts.id=posts_autors.id AND posts.id=posts_assets.id AND posts_autors.verze=posts_assets.verze AND posts.published='1' AND posts.id=$postID"); // select query
            			
                    while ($autor = mysqli_fetch_assoc($results_2)) { echo substr($autor['autor_clanku'], 0, 50) . " "; }
              ?>
              </i>
              <i class="far fa-calendar"> <?php echo date('F j, Y', strtotime($post['created_at'])); ?></i>
              <p class="preview-text">
			  	<?php
				$docObj = new Doc2Txt(ROOT_PATH . "/assets/documents/" . $post['document']);

				$txt = $docObj->convertToText();
				if (strlen($txt) > 250) {
				    echo substr($txt, 0, 250) . '...';
				}
				else {
				    echo $txt;
				}    
				?>
              </p>
              <a href="single.php?id=<?php echo $post['id']; ?>" class="btn read-more">Více</a>
            </div>
          </div>    
		<?php } ?>
        


      </div>
      <!-- // Main Content -->

      <div class="sidebar">

        <div class="section search">
          <h2 class="section-title">Vyhledávání</h2>
          <form action="index.php" method="post">
            <input type="text" name="search-term" class="text-input" placeholder="Vyhledat...">
          </form>
        </div>

      </div>

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
