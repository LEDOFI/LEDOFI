<?php include("../../path.php");
session_start();
require(ROOT_PATH . "/app/database/db.php");
if($_SESSION['role']=='admin') {


$errors = array();
$autors = array();

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

        <title>Admin - Žádosti</title>
    </head>

    <body>
        
    <?php include(ROOT_PATH . "/app/includes/dashboardHeader.php"); ?>

        <!-- Admin Page Wrapper -->
        <div class="admin-wrapper">

        <?php include(ROOT_PATH . "/app/includes/dashboardSidebar.php"); ?>


            <!-- Admin Content -->
            <div class="admin-content">
                <div class="button-group">
                </div>


                <div class="content">

                    <h2 class="page-title">Admin - Žádosti</h2>

                    <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>

                    <table>
                        <thead>
                            <th>SČ</th>
                            <th>Uživatelské jméno</th>
                            <th>Současná role</th>
                            <th>Žádaná role</th>
                            <th colspan="2">Akce</th>
                        </thead>
                        <tbody>
							<?php
								$key = 1;
								$sql = "SELECT * FROM users WHERE zadost_na_zmenu_role!='0'";
								$results = mysqli_query($conn,$sql);
								while ($post = mysqli_fetch_assoc($results)) {
							?>
                                <tr>
                                    <td><?php echo $key++; ?></td>
                                    <td><?php echo $post['username'] ?></td>
                                    <td><?php echo $post['role'] ?></td>
                                    <td><?php echo $post['zadost_na_zmenu_role'] ?></td>
                                    <td><a href="edit.php?id=<?php echo $post['id']; ?>" class="display">Přidělit žádanou roli</a></td>
                                    <td><a href="edit.php?zamitnout_id=<?php echo $post['id']; ?>" class="delete">Zamítnout</a></td>
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

<?php } else { echo 'Nemáte roli ´´Admin´´.'; } ?>