<header>
    <a class="logo" href="<?php echo BASE_URL . '/index.php'; ?>">
      <h1 class="logo-text">Los Polos Technikos</h1>
    </a>
    <i class="fa fa-bars menu-toggle"></i>
    <ul class="nav">
        <li><a href="<?php echo BASE_URL . '/app/controllers/edit_user.php'; ?>">Editovat uživatelské údaje</a></li>
        <?php if (isset($_SESSION['username'])): ?>
            <li>
                <a href="#">
                    <i class="fa fa-user"></i>
                    <?php echo $_SESSION['username']; ?>&emsp;
                    <i class="fa fa-chevron-down" style="font-size: 0.8em;"></i>
                </a>
                <ul>
                    <li><a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout">Odhlásit</a></li>
                </ul>
            </li>
        <?php endif; ?>
    </ul>
</header>