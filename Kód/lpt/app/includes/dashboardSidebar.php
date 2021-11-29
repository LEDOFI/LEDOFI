<?php
if($_SESSION['role']=='admin') {
?>
	
	<div class="left-sidebar">
		<ul>
			<li><a href="<?php echo BASE_URL . '/admin/dashboard.php'; ?>">Nedávná aktivita</a></li>
			<li><a href="<?php echo BASE_URL . '/admin/posts/index.php'; ?>">Spravovat články</a></li>
			<li><a href="<?php echo BASE_URL . '/admin/users/index.php'; ?>">Spravovat uživatele</a></li>
			<li><a href="<?php echo BASE_URL . '/admin/zadosti/index.php'; ?>">Žádosti o změnu role</a></li>
		</ul>
	</div>

<?php	
}

if($_SESSION['role']=='autor') {
?>
	
	<div class="left-sidebar">
		<ul>
			<li><a href="<?php echo BASE_URL . '/autor/dashboard.php'; ?>">Nedávná aktivita</a></li>
			<li><a href="<?php echo BASE_URL . '/autor/posts/index.php'; ?>">Vaše články</a></li>
			<li><a href="<?php echo BASE_URL . '/autor/posts/index2.php'; ?>">Recenze na<br>vaše články<br>(jednotlivé)</a></li>
			<li><a href="<?php echo BASE_URL . '/autor/posts/index3.php'; ?>">Recenze na<br>vaše články<br>(seskupené)</a></li>
		</ul>
	</div>
	
<?php	
}

if($_SESSION['role']=='recenzent') {
?>
	
	<div class="left-sidebar">
		<ul>
			<li><a href="<?php echo BASE_URL . '/recenzent/dashboard.php'; ?>">Nedávná aktivita</a></li>
			<li><a href="<?php echo BASE_URL . '/recenzent/posts/index.php'; ?>">Články k zrecenzování</a></li>
			<li><a href="<?php echo BASE_URL . '/recenzent/posts/index2.php'; ?>">Recenze, které<br>jste předložil<br>(jednotlivé)</a></li>
			<li><a href="<?php echo BASE_URL . '/recenzent/posts/index3.php'; ?>">Recenze, které<br>jste předložil<br>(seskupené)</a></li>
		</ul>
	</div>
	
<?php	
}

if($_SESSION['role']=='redaktor') {
?>
	
    <div class="left-sidebar">
        <ul>
            <li><a href="<?php echo BASE_URL . '/redaktor/dashboard.php'; ?>">Nedávná aktivita</a></li>
            <li><a href="<?php echo BASE_URL . '/redaktor/posts/index.php'; ?>">Předložené články</a></li>
    		<li><a href="<?php echo BASE_URL . '/redaktor/posts/index2.php'; ?>">Předložené recenze<br>(jednotlivé)</a></li>
    		<li><a href="<?php echo BASE_URL . '/redaktor/posts/index3.php'; ?>">Předložené recenze<br>(seskupené)</a></li>
        </ul>
    </div>

<?php	
}

if($_SESSION['role']=='ctenar') {
?>
	
    <div class="left-sidebar">
        <ul>
            <li><a href="<?php echo BASE_URL . '/ctenar/dashboard.php'; ?>">Nástěnka</a></li>
            <li><a href="<?php echo BASE_URL . '/ctenar/zadost_o_zmenu_role.php'; ?>">Žádost o změnu role</a></li>
        </ul>
    </div>

<?php	
}
?>