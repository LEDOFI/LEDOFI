<?php include("../../path.php");
session_start();
require(ROOT_PATH . "/app/database/db.php");
if($_SESSION['role']=='redaktor') {
	
// initializing variables
$errors = array(); 

if (isset($_GET['id']) && isset($_GET['recenzent_id']) && isset($_GET['verze'])) {
	$id = $_GET['id'];
	$recenzent_id = $_GET['recenzent_id'];
	$verze = $_GET['verze'];
	
	if (empty($id)) { array_push($errors, "Chyba: Nenalezeno identifikační číslo článku."); }
	if (empty($recenzent_id)) { array_push($errors, "Nenalezeno identifikační číslo recenzenta"); }
	if (empty($verze)) { array_push($errors, "Chyba: Nenalezena verze článku."); }
	
	if (count($errors) == 0) {
	
		$sql_update = "UPDATE posts_vybrani_recenzenti SET zpristupneno_autorovi='1' WHERE id='$id' AND recenzent_id='$recenzent_id' AND verze='$verze'";
		$result = mysqli_query($conn, $sql_update);
		
		if($result != null)
		{
			mysqli_close($conn); // Close connection
			$_SESSION['message'] = "Recenze úspěšně odeslána autorovi.";
			$_SESSION['type'] = 'success';
			header('location: ' . BASE_URL . '/redaktor/posts/index2.php');  // redirects to all records page
			exit;
		}
		else
		{
			echo mysqli_error();
		}
	}
}
?>

<?php } else { echo 'Nemáte roli ´´redaktor´´.'; } ?>