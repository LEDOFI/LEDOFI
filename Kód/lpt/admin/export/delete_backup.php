<?php include("../../path.php");
session_start();
require(ROOT_PATH . "/app/database/db.php");
if($_SESSION['role']=='admin') {


if (isset($_GET['delete_name'])) {

    $file_to_delete = ROOT_PATH . "/assets/database/" . $_GET['delete_name'];
    if (is_file($file_to_delete)){
        unlink($file_to_delete);
        
        if (!is_file($file_to_delete)){
            $_SESSION['message'] = "Backup byl úspěšně smazán";
        	$_SESSION['type'] = 'success';
        	header('location: ' . BASE_URL . '/admin/export/index.php');
        	exit;
        }
        else{
            $_SESSION['message'] = "Backup nebyl smazán";
        	$_SESSION['type'] = 'error';
        	header('location: ' . BASE_URL . '/admin/export/index.php');
        	exit;
        }
        
        
    }
    else{
		$_SESSION['message'] = "Backup neexistuje";
		$_SESSION['type'] = 'error';
		header('location: ' . BASE_URL . '/admin/export/index.php');
		exit;
    }
}


} else { echo 'Nemáte roli ´´Admin´´.'; } ?>