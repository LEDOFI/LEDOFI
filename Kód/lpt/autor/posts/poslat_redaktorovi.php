<?php include("../../path.php");
session_start();
require(ROOT_PATH . "/app/database/db.php");
if($_SESSION['role']=='autor') {
if (($post['user_id'] == $_SESSION['id']) || ($post['user_id'] == $_SESSION['poslatredaktorovi_id'])) {
	
// initializing variables
$errors = array(); 

if (isset($_GET['poslatredaktorovi_id'])) {
	$poslatredaktorovi_id = $_GET['poslatredaktorovi_id'];
	
	if (empty($poslatredaktorovi_id)) { array_push($errors, "Chyba: Nenalezeno identifikační číslo redaktora."); }
	
	if (count($errors) == 0) {
	
		$sql_update = "UPDATE posts SET status='poslano redaktorovi', last_changed_at=now() WHERE id='$poslatredaktorovi_id'";
		$result = mysqli_query($conn, $sql_update);
		
		if($result != null)
		{
			mysqli_close($conn); // Close connection
			$_SESSION['message'] = "Článek byl úspěšně poslán redaktorovi";
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

<?php } else { echo 'Nemáte pravo editovat cizí posty.'; } ?>
<?php } else { echo 'Nemáte roli ´´Autor´´.'; } ?>