<?php include("../../path.php"); ?>
<?php session_start();
require(ROOT_PATH . "/app/database/db.php");?>
<?php
if($_SESSION['role']=='admin') {
?>
<?php


$errors = array();

if (isset($_GET['delete_id'])) {
	$delete_id = $_GET['delete_id'];
	
	$sql_delete = "DELETE FROM users WHERE id='$delete_id'";
	$result = mysqli_query($conn, $sql_delete);
	
	if($result != null)
	{
		mysqli_close($conn);
		$_SESSION['message'] = 'Uživatel byl smazán';
		$_SESSION['type'] = 'success';
		header('location: ' . BASE_URL . '/admin/users/index.php');
		exit;
	}
	else
	{
		echo mysqli_error();
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

        <title>Admin - Spravovat uživatele</title>
    </head>

    <body>
        
    <?php include(ROOT_PATH . "/app/includes/dashboardHeader.php"); ?>

        <!-- Admin Page Wrapper -->
        <div class="admin-wrapper">

        <?php include(ROOT_PATH . "/app/includes/dashboardSidebar.php"); ?>


            <!-- Admin Content -->
            <div class="admin-content">
                <div class="button-group">
                    <a href="export_database.php" class="btn btn-big">Exportovat databázi bez vytvoření zálohy</a>
                    <a href="backup_database.php" class="btn btn-big">Vytvořit zálohu databáze</a>
                </div>
                <div class="content">
                    <h2 class="page-title">Export/Zaloha databáze</h2>

                    <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>

                    <table>
                        <thead>
                            <th>Název zálohy</th>
                            <th>Datum vytvoření zálohy</th>
                            <th>Stáhnout</th>
                            <th>Smazat</th>
                        </thead>
                        <tbody>
							<?php
    							   $dir    = ROOT_PATH . "/assets/database";
                                   //$files1 = scandir($dir);
                                   $result = array();

                                   $cdir = scandir($dir, 1);
                                   foreach ($cdir as $key => $value)
                                   {
                                      if (!in_array($value,array(".","..")))
                                      {
                                         if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
                                         {
                                            $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
                                         }
                                         else
                                         {
                                            $result[] = $value;
                                         }
                                      }
                                   }
							?>
                                <tr>
                            <?php foreach ($result as $result_single) { 
                                  $datum_UNIX_timestamp = substr($result_single, 0, 10);
                            ?>   
                                    <td>
                            <?php echo $result_single; ?> 
                                    </td>
                                    <td>
                            <?php echo gmdate("Y-m-d H:i:s", $datum_UNIX_timestamp); ?> 
                                    </td>
                                    <td>
                            <?php echo "<a href='https://ledofi.000webhostapp.com/assets/database/".$result_single."'>stáhnout</a>"; ?> 
                                    </td>
                                    <td>
                            <a onclick="return confirm('Opravdu chcete tento backup smazat? Tuto akci nelze vrátit zpět.')" href="delete_backup.php?delete_name=<?php echo $result_single; ?>" class="delete">odstranit</a><br>
                                    </td>
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

<?php } ?>