<header>
    <a href="<?php echo BASE_URL . '/index.php' ?>" class="logo">
      <h1 class="logo-text">Los Polos Technikos</h1>
    </a>
    <i class="fa fa-bars menu-toggle"></i>
    <ul class="nav">
      <li><a href="<?php echo BASE_URL . '/index.php' ?>">Domů</a></li>
      <li><a href="<?php echo BASE_URL . '/single.php?id=1' ?>">Jak se stát autorem</a></li>

      <?php if (isset($_SESSION['id'])): ?>
        <li>
          <a href="#">
            <i class="fa fa-user"></i>
            <?php echo $_SESSION['username']; ?>
            <i class="fa fa-chevron-down" style="font-size: 0.8em;"></i>
          </a>
          <ul>
            <?php $sessionrole = $_SESSION['role']; ?>
            <?php if(isset($_SESSION['role'])) { ?>
              <li><a href="<?php echo BASE_URL . '/' . $sessionrole . '/dashboard.php' ?>">Nástěnka</a></li>
            <?php } ?>
            <li><a href="<?php echo BASE_URL . '/logout.php' ?>" class="logout">Odhlásit</a></li>
          </ul>
        </li>
      <?php else: ?>
        <li><a href="<?php echo BASE_URL . '/register.php' ?>">Registrovat</a></li>
        <li><a href="<?php echo BASE_URL . '/login.php' ?>">Přihlásit</a></li>
      <?php endif; ?>
    </ul>
</header>