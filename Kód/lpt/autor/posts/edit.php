<?php include("../../path.php");
session_start();
require(ROOT_PATH . "/app/database/db.php");
if($_SESSION['role']=='autor') {
if (($post['user_id'] == $_SESSION['id']) || ($post['user_id'] == $_SESSION['delete_id'])) {
	

$autor_clanku = array(); 
$email_autora_clanku = array(); 
$errors = array(); 



if (isset($_GET['delete_id'])) {
	$delete_id = $_GET['delete_id'];

	$sql = "select * from posts_assets where id='$delete_id'";
	$results = mysqli_query($conn,$sql);
	while ($delete_while_loop = mysqli_fetch_assoc($results)) {
        unlink(ROOT_PATH . '/assets/documents/' . $delete_while_loop['document']);
        unlink(ROOT_PATH . '/assets/images/' . $delete_while_loop['image']);
	}
	
	$sql_delete_2 = "DELETE FROM posts_autors WHERE id='$delete_id'";
	$result_2 = mysqli_query($conn, $sql_delete_2);
	
	$sql_delete_3 = "DELETE FROM posts_assets WHERE id='$delete_id'";
	$result_3 = mysqli_query($conn, $sql_delete_3);
	
	$sql_delete = "DELETE FROM posts WHERE id='$delete_id'";
	$result = mysqli_query($conn, $sql_delete);
	
	if(($result && $result_2 && $result_3) != null)
	{
		mysqli_close($conn);
		$_SESSION['message'] = "Článek úspěšně smazán";
		$_SESSION['type'] = 'success';
		header('location: ' . BASE_URL . '/autor/posts/index.php');
		exit;
	}
	else
	{
		echo mysqli_error();
	}
}

if(isset($_POST['update-post']) == false)
{

	$id = $_GET['id'];

	$qry = mysqli_query($conn,"select * from posts where id='$id'");
	$data = mysqli_fetch_array($qry);
	$id = $data['id'];
	$status = $data['status'];
	
	$qry_3 = mysqli_query($conn,"select * from posts_assets where id='$id' ORDER BY verze DESC LIMIT 0, 1");
	$data_3 = mysqli_fetch_array($qry_3);
	$title = $data_3['title'];
	$verze = $data_3['verze'];

	$qry_2 = mysqli_query($conn,"select * from posts_autors where id='$id' AND verze='$verze'");

	
}

if(isset($_POST['update-post']))
{

	$id = $_REQUEST['id'];
	$verze = $_REQUEST['verze'];
	$status = $_REQUEST['status'];
    $title = $_REQUEST['title'];
    $autor_clanku = $_REQUEST['autor_clanku'];
	$email_autora_clanku = $_REQUEST['email_autora_clanku'];
	$user_id = $_SESSION['id'];
	$verzeplusone = $verze + 1;
	
	if (empty($title)) { array_push($errors, "Vyžadován nadpis"); }
	if (empty($autor_clanku)) { array_push($errors, "Vyžadován autor"); }
	if (empty($email_autora_clanku)) { array_push($errors, "Vyžadován email autora"); }
	if (empty($user_id)) { array_push($errors, "Vyžadováno ID autor"); }
	
	if (!empty($_FILES['image']['name'])) {
		$image_name = time() . '_' . $_FILES['image']['name'];
		$destination = ROOT_PATH . "/assets/images/" . $image_name;

		$result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

		if ($result) {
		   $_POST['image'] = $image_name;
		} else {
			array_push($errors, "Chyba při nahrávání obrázku");
		}
	} else {
	   array_push($errors, "Vyžadován obrázek článku");
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


	if (count($errors) == 0) {
	    
	    $sql_post = mysqli_query($conn,"UPDATE posts SET last_changed_at=now() WHERE id='$id'");
	    
        for($i=0;$i<count($autor_clanku);$i++)
        {
		    $sql_post_2 = mysqli_query($conn,"INSERT INTO posts_autors SET id='$id', autor_clanku='$autor_clanku[$i]', email_autora_clanku='$email_autora_clanku[$i]', verze='$verzeplusone'");
        }
        
		$sql_post_3 = mysqli_query($conn,"INSERT INTO posts_assets SET id='$id', title='$title', image='$image_name', document='$document_name', verze='$verzeplusone'");
		
		if(($sql_post != null) && ($sql_post_2 != null) && ($sql_post_3 != null))
		{
		 
		     if($status == 'poslano autorovi na opravu'){
    	        $sql_update = mysqli_query($conn,"UPDATE posts SET status='opraveno autorem' WHERE id='$id'");
    	    }	   
		    
			mysqli_close($conn);
			$_SESSION['message'] = "Článek byl úspěšně aktualizován";
			$_SESSION['type'] = 'success';
			header('location: ' . BASE_URL . '/autor/posts/index.php');
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

        <title>Autor - Upravit článek</title>
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

                    <h2 class="page-title">Spravovat článek</h2>

                    <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?>

                    <form action="edit.php" name="theForm" id="theForm" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="hidden" name="verze" value="<?php echo $verze ?>">
                        <input type="hidden" name="status" value="<?php echo $status ?>">
                        <div>
                            <label>Nadpis</label>
                            <input type="text" name="title" value="<?php echo $title ?>" class="text-input" required>
                        </div>
	                    <div>
							<table id="autori_table" align=center>
							    
                                <?php

								    
								    for ($rowno = 0; $autor = mysqli_fetch_assoc($qry_2); $rowno++) {
								        
								    $autorclanku = $autor['autor_clanku'];
								    $emailautoraclanku = $autor['email_autora_clanku'];
		
                                		if ($rowno == 0){
                                			              
                                            echo "<tr id='row".$rowno."'>";
                                			              
                                            echo "<td><input type='text' name='autor_clanku[]' value='" . $autorclanku . "' placeholder='Jméno autora' required></td>";
                                			
                                            echo "<td><input type='text' name='email_autora_clanku[]' value='" . $emailautoraclanku . "' placeholder='Email autora' required></td>";
                                            
                                            echo "<td></td></tr>";
                                		
                                		} else {
                                		    
                                            echo "<tr id='row".$rowno."'>";
                                			              
                                            echo "<td><input type='text' name='autor_clanku[]' value='" . $autorclanku . "' placeholder='Jméno autora' required></td>";
                                			
                                            echo "<td><input type='text' name='email_autora_clanku[]' value='" . $emailautoraclanku . "' placeholder='Email autora' required></td>";
                                		
                                			        
                                            echo "<td><input type='button' value='Odstranit' onclick=delete_row('row" . $rowno . "')></td></tr>";
                                		}
			
                                    }
                            		
									
							
							?>		

							</table>
							<input type="button" onclick="add_row();" value="Přidat autora" required>
	                    </div>
                        <div>
                            <label>Dokument:</label>
                            <input type="file" name="document" class="text-input" accept=".doc,.docx" required>
                        </div>
                        <div>
                            <label>Obrázek:</label>
                            <input type="file" name="image" class="text-input" accept=".gif,.jpg,.jpeg,.png" required>
                        </div>
                        <div>
                            <button type="submit" name="update-post" class="btn btn-big">Update Post</button>
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

		<script type="text/javascript">
		function add_row()
		{
			$rowno=$("#autori_table tr").length;
			$rowno=$rowno+1;
			$("#autori_table tr:last").after("<tr id='row"+$rowno+"'><td><input type='text' name='autor_clanku[]' placeholder='Jméno autora'></td><td><input type='text' name='email_autora_clanku[]' placeholder='Email autora'></td><td><input type='button' value='Odstranit' onclick=delete_row('row"+$rowno+"')></td></tr>");
		}
		function delete_row(rowno)
		{
			$('#'+rowno).remove();
		}
		</script>
		
    </body>

</html>

<?php } else { echo 'Nemáte právo editovat cizí posty.'; } ?>
<?php } else { echo 'Nemáte roli ´´Autor´´.'; } ?>
