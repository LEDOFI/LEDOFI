<?php include("../../path.php"); ?>
<?php session_start();
require(ROOT_PATH . "/app/database/db.php");?>
<?php
if($_SESSION['role']=='admin') {
?>
<?php


$errors = array(); 

if(isset($_GET['id']))
{
	
	$id = $_GET['id'];
	
	if (empty($id)) { array_push($errors, "id is required"); }

	
	if (count($errors) == 0) {
	
	    $sql = mysqli_query($conn,"SELECT * FROM users WHERE id='$id'");
	    $results = $sql -> fetch_assoc();
	    $zadost_na_zmenu_role = $results['zadost_na_zmenu_role'];
		
		$edit = mysqli_query($conn,"UPDATE users SET role='$zadost_na_zmenu_role', zadost_na_zmenu_role='0' WHERE id='$id'");
		
		if($edit != null)
		{
			mysqli_close($conn); // Close connection
			$_SESSION['message'] = 'Žádost byla úspěšně přijata';
			$_SESSION['type'] = 'success';
			header('location: ' . BASE_URL . '/admin/zadosti/index.php');
			exit;
		}
		else
		{
			echo mysqli_error();
		}   
	}		
}

if(isset($_GET['zamitnout_id']))
{
	

	$id = $_GET['zamitnout_id'];
	
	if (empty($id)) { array_push($errors, "Vyžadováno ID"); }
	
	if (count($errors) == 0) {
		
		$edit = mysqli_query($conn,"UPDATE users SET zadost_na_zmenu_role='0' WHERE id='$id'");
		
		if($edit != null)
		{
			mysqli_close($conn); // Close connection
			$_SESSION['message'] = 'Žádost byla úspěšně zamítnuta';
			$_SESSION['type'] = 'success';
			header('location: ' . BASE_URL . '/admin/zadosti/index.php'); 
			exit;
		}
		else
		{
			echo mysqli_error();
		}   
	}		
}
?>

<?php } ?>