<?php include("../../path.php");
session_start();
require(ROOT_PATH . "/app/database/db.php");
if($_SESSION['role']=='redaktor') {
	
// initializing variables
$errors = array(); 

if (isset($_GET['publikovat_id'])) {
	$id = $_GET['publikovat_id'];


	
	$sql_update = "UPDATE posts SET published='1' WHERE id='$id' AND status='recenze vypracovany'";
	$result = mysqli_query($conn, $sql_update);
	
	if($result != null)
	{
		mysqli_close($conn); // Close connection
		$_SESSION['message'] = "Článek byl úspěšně publikován";
		$_SESSION['type'] = 'success';
		header('location: ' . BASE_URL . '/redaktor/posts/index.php');  // redirects to all records page
		exit;
	}
	else
	{
		echo mysqli_error();
	}
}

if (isset($_GET['zneverejnit_id'])) {
	$id = $_GET['zneverejnit_id'];
	
	$sql_update = "UPDATE posts SET published='0' WHERE id='$id' AND status='recenze vypracovany'";
	$result = mysqli_query($conn, $sql_update);
	
	if($result != null)
	{
		mysqli_close($conn); // Close connection
		$_SESSION['message'] = "Článek byl úspěšně zneveřejněn";
		$_SESSION['type'] = 'success';
		header('location: ' . BASE_URL . '/redaktor/posts/index.php');  // redirects to all records page
		exit;
	}
	else
	{
		echo mysqli_error();
	}
}
?>

<?php } else { echo 'Nemáte roli ´´redaktor´´.'; } ?>