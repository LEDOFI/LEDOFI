<?php include("../../path.php");
session_start();
require(ROOT_PATH . "/app/database/db.php");
if($_SESSION['role']=='autor') {


$p_id = "";
$user_id = "";
$autor_clanku = "";
$email_autora_clanku = "";
$title = "";
$document_name = "";
$image_name = "";
$errors = array(); 

if(isset($_POST['add-post'])) 
{
	

    $title = $_REQUEST['title'];
    $autor_clanku = $_REQUEST['autor_clanku'];
	$email_autora_clanku = $_REQUEST['email_autora_clanku'];
	$user_id = $_SESSION['id'];
	
	if (empty($title)) { array_push($errors, "Vyžadován nadpis"); }
	if (empty($autor_clanku)) { array_push($errors, "Vyžadován autor"); }
	if (empty($email_autora_clanku)) { array_push($errors, "Vyžadován email autora"); }
	if (empty($user_id)) { array_push($errors, "Vyžadováno ID autora"); }
	
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
	   array_push($errors, "Vyžadován obrázek");
	}
	if (!empty($_FILES['document']['name'])) {
		$document_name = time() . '_' . $_FILES['document']['name'];
		$destination = ROOT_PATH . "/assets/documents/" . $document_name;

		$result = move_uploaded_file($_FILES['document']['tmp_name'], $destination);

		if ($result) {
		   $_POST['document'] = $document_name;
		} else {
			array_push($errors, "Chyba při nahrávání dokumentu");
		}
	} else {
	   array_push($errors, "Vyžadován dokument k článku");
	}


	if (count($errors) == 0) {
		
		$sql_post = mysqli_query($conn,"INSERT INTO posts SET user_id='$user_id'");
		
        for($i=0;$i<count($autor_clanku);$i++)
        {
    			$sql_post_2 = mysqli_query($conn,"INSERT INTO posts_autors SET id=LAST_INSERT_ID(), autor_clanku='$autor_clanku[$i]', email_autora_clanku='$email_autora_clanku[$i]', verze='1'");
        }
        
		$sql_post_3 = mysqli_query($conn,"INSERT INTO posts_assets SET id=LAST_INSERT_ID(), title='$title', image='$image_name', document='$document_name', verze='1'");
		
		if(($sql_post && $sql_post_2 && $sql_post_3) != null)
		{
			mysqli_close($conn);
			$_SESSION['message'] = "Článek byl úspěšně přidán";
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

        <title>Autor - Přidat článek</title>
		
    </head>

    <body onload="addItem();">
        
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

                    <h2 class="page-title">Přidat článek</h2>

                    <?php include(ROOT_PATH . '/app/helpers/formErrors.php'); ?>

                    <form action="create.php" name="theForm" id="theForm" method="post" enctype="multipart/form-data">
                        <div>
                            <label>Nadpis</label>
                            <input type="text" name="title" value="<?php echo $title ?>" class="text-input" required>
                        </div>
	                    <div>
							<table id="autori_table" align=center>
								<tr id="row1">
									<td><input type='text' name='autor_clanku[]' placeholder='Jméno autora' required></td>
									<td><input type='text' name='email_autora_clanku[]' placeholder='Email autora' required></td>
								</tr>
							</table>
							<input type="button" onclick="add_row();" value="Přidat autora">
	                    </div>
                        <div>
                            <label>Dokument:</label>
                            <input type="file" name="document" class="text-input" accept=".doc,.docx" required>
                        </div>
                        <div>
                            <label>Obrázek</label>
                            <input type="file" name="image" class="text-input" accept=".gif,.jpg,.jpeg,.png" required>
                        </div>
                        <div>
                            <button type="submit" name="add-post" class="btn btn-big">Přidat článek</button>
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
			$("#autori_table tr:last").after("<tr id='row"+$rowno+"'><td><input type='text' name='autor_clanku[]' placeholder='Jméno autora' required></td><td><input type='text' name='email_autora_clanku[]' placeholder='Email autora' required></td><td><input type='button' value='Odstranit' onclick=delete_row('row"+$rowno+"')></td></tr>");
		}
		function delete_row(rowno)
		{
			$('#'+rowno).remove();
		}
		</script>

    </body>

</html>

<?php } else { echo 'Nemáte roli ´´Autor´´.'; } ?>
