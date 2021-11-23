<header>
    <a href="index.php" class="logo">
      <h1 class="logo-text">Los Polos Technikos</h1>
    </a>
    <i class="fa fa-bars menu-toggle"></i>
    <ul class="nav">
      <?php if (isset($_SESSION['id'])): ?>
        <li>
          <a href="#">
            <i class="fa fa-user"></i>
            <?php echo $_SESSION['username']; ?>
            <i class="fa fa-chevron-down" style="font-size: .8em;"></i>
          </a>
          <ul>
            <?php if($_SESSION['admin']): ?>
              <li><a href="index.php">Dashboard</a></li>
            <?php endif; ?>
            <li><a href="logout.php" class="logout">Odhlásit</a></li>
          </ul>
        </li>
      <?php else: ?>
        <li><a href="register.php">Registrace</a></li>
        <li><a href="login.php">Přihlášení</a></li>
      <?php endif; ?>
    </ul>
</header>