<?php include("../../path.php");
session_start();
require(ROOT_PATH . "/app/database/db.php");
if($_SESSION['role']=='autor') {

// initializing variables
$p_id = "";
$user_id = "";
$autor_clanku = "";
$title = "";
$document_name = "";
$image_name = "";
$published = "";
$errors = array(); 

if(isset($_POST['add-post'])) // when click on Update button
{
	
	// Taking values from the form data(input)
    $title = $_REQUEST['title'];
    $autor_clanku = $_REQUEST['autor_clanku'];
	$published = isset($_REQUEST['published']) ? 1 : 0;
	$user_id = $_SESSION['id'];
	
	if (empty($title)) { array_push($errors, "Title is required"); }
	if (empty($autor_clanku)) { array_push($errors, "Autor clanku is required"); }
	if (empty($user_id)) { array_push($errors, "User id is required"); }
	
	if (!empty($_FILES['image']['name'])) {
		$image_name = time() . '_' . $_FILES['image']['name'];
		$destination = ROOT_PATH . "/assets/images/" . $image_name;

		$result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

		if ($result) {
		   $_POST['image'] = $image_name;
		} else {
			array_push($errors, "Failed to upload image");
		}
	} else {
	   array_push($errors, "Post image required");
	}
	if (!empty($_FILES['document']['name'])) {
		$document_name = time() . '_' . $_FILES['document']['name'];
		$destination = ROOT_PATH . "/assets/documents/" . $document_name;

		$result = move_uploaded_file($_FILES['document']['tmp_name'], $destination);

		if ($result) {
		   $_POST['document'] = $document_name;
		} else {
			array_push($errors, "Failed to upload document");
		}
	} else {
	   array_push($errors, "Post document required");
	}

	// Finally, add post if there are no errors in the form	
	if (count($errors) == 0) {
		
		$sql_post = mysqli_query($conn,"INSERT INTO posts SET title='$title', user_id='$user_id', autor_clanku='$autor_clanku', published='$published', image='$image_name', document='$document_name'");
		
		if($sql_post != null)
		{
			mysqli_close($conn); // Close connection
			$_SESSION['message'] = "Post created successfully";
			$_SESSION['type'] = 'success';
			header('location: ' . BASE_URL . '/autor/posts/index.php');  // redirects to all records page
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

        <title>Autor Section - Add Post</title>
    </head>

    <body>
        
    <?php include(ROOT_PATH . "/app/includes/autorHeader.php"); ?>

        <!-- Admin Page Wrapper -->
        <div class="admin-wrapper">

        <?php include(ROOT_PATH . "/app/includes/autorSidebar.php"); ?>


            <!-- Admin Content -->
            <div class="admin-content">
                <div class="button-group">
                    <a href="create.php" class="btn btn-big">Add Post</a>
                    <a href="index.php" class="btn btn-big">Manage Posts</a>
                </div>


                <div class="content">

                    <h2 class="page-title">Add Post</h2>

                    <?php include(ROOT_PATH . '/app/helpers/formErrors.php'); ?>

                    <form action="create.php" name="theForm" method="post" enctype="multipart/form-data">
                        <div>
                            <label>Title</label>
                            <input type="text" name="title" value="<?php echo $title ?>" class="text-input">
                        </div>
						<div>
                            <label>Autoři:</label>
                            <input type="text" name="autor_clanku" value="<?php echo $autor_clanku ?>" class="text-input">
                        </div>
                        <div>
                            <label>Document:</label>
                            <input type="file" name="document" class="text-input">
                        </div>
                        <div>
                            <label>Image</label>
                            <input type="file" name="image" class="text-input">
                        </div>
						<div>
                            <?php if (empty($published)): ?>
								<input type="checkbox" name="published" hidden>
                            <?php else: ?>
								<input type="checkbox" name="published" checked hidden>
                            <?php endif; ?>
                           

                        </div>
                        <div>
                            <button type="submit" name="add-post" class="btn btn-big">Add Post</button>
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

<?php } else { echo 'Nemáte roli ´´Autor´´.'; } ?>