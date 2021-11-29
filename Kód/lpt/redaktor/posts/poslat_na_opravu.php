<?php include("../../path.php");
session_start();
require(ROOT_PATH . "/app/database/db.php");
if($_SESSION['role']=='redaktor') {
	
// initializing variables
$errors = array(); 

if(isset($_GET['id'])) // when click on Update button
{
	$id = $_GET['id'];
	
	if (empty($id)) { array_push($errors, "Chyba: Nenalezeno identifikační číslo článku."); }

	if (count($errors) == 0) {
		
		$sql_update = mysqli_query($conn,"UPDATE posts SET status='poslano autorovi na opravu', last_changed_at=now() WHERE id='$id'");
		
		
		if($sql_update != null)
		{
			mysqli_close($conn); // Close connection
			$_SESSION['message'] = "Článek byl úspěšně odeslán autorovi na opravu";
			$_SESSION['type'] = 'success';
			header('location: ' . BASE_URL . '/redaktor/posts/index.php');  // redirects to all records page
			exit;
		}
		else
		{
			echo mysqli_error();
		}
	}
}

} else { echo 'Nemáte roli ´´redaktor´´.'; } ?>