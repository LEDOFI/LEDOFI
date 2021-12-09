<?php include("../../path.php");
session_start();
require(ROOT_PATH . "/app/database/db.php");
if($_SESSION['role']=='autor') {

// initializing variables
$errors = array();
$autors = array();

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

        <title>Autor - Recenze (seskupené)</title>
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

                    <h2 class="page-title">Správa článků</h2>

                    <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>

                    <table>
                        <thead>
                            <th>SČ</th>
                            <th>Nadpis</th>
                            <th>Poslední verze</th>
                            <th>Autoři článku</th>
                            <th colspan="1">Akce</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
							<?php
								$key = 1;
								$sessionid = $_SESSION['id'];
								$sql = "SELECT * FROM posts, posts_assets, posts_vybrani_recenzenti, posts_recenze
									WHERE posts.id=posts_assets.id AND posts.id=posts_vybrani_recenzenti.id AND posts.id=posts_recenze.id AND posts_assets.verze=posts_vybrani_recenzenti.verze AND posts_assets.verze=posts_recenze.verze AND posts_vybrani_recenzenti.recenzent_id=posts_recenze.recenzent_id AND posts.user_id='$sessionid' AND posts_vybrani_recenzenti.zpristupneno_autorovi='1'
									    GROUP BY posts.id
								        ORDER BY posts_recenze.created_at DESC, posts.last_changed_at DESC, posts.id DESC, posts_assets.verze DESC";
								$results = mysqli_query($conn,$sql);
								while ($post = mysqli_fetch_assoc($results)) {
							?>
                                <tr>
                                    <td><?php echo $key++; ?></td>
                                    <td><?php echo $post['title'] ?></td>
                                    <td><?php echo $post['verze'] ?></td>
                                    <td>
                                        <?php
                                			$postID = $post['id'];
                                	        $results_2 = mysqli_query($conn,"SELECT * FROM posts, posts_assets, posts_autors 
								            INNER JOIN (SELECT id, MAX(verze) AS MaxVerze FROM posts_autors GROUP BY id) groupedPostsAutors ON posts_autors.id = groupedPostsAutors.id AND posts_autors.verze = groupedPostsAutors.MaxVerze 
								        WHERE posts.id=posts_autors.id AND posts.id=posts_assets.id AND posts_autors.verze=posts_assets.verze AND posts.id=$postID"); // select query
                                			
                                            while ($autor = mysqli_fetch_assoc($results_2)) {
                                			
                                        			echo $autor['autor_clanku'] . " ";
                                			}
                                		?>	
                                    </td>
                                    <td><a href="display_submitted_recenze_all_versions.php?id=<?php echo $post['id']; ?>" class="display">zobrazit</a></td>
                                    <td><?php	if($post['published'] == '1') { 	echo "publikovano";	} else { 	echo $post['status'];	} ?></td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>

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

<?php } else { echo 'Nemáte roli ´´Autor´´.'; } ?>
