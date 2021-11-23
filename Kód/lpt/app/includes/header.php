<header>
    <div class="logo">
      <h1 class="logo-text">Los Polos Technikos</h1>
    </div>
    <i class="fa fa-bars menu-toggle"></i>
    <ul class="nav">
      <li><a href="<?php echo BASE_URL . '/index.php'?>" class="menu">Domů</a></li>
      <li><a href="#kontakt">Kontakt</a></li>
      <?php if(isset($_SESSION['id'])): ?>
        <li>
        <a href="#" class="profile">
          <i class="fa fa-user"></i>
          <?php echo $_SESSION['username']; ?>
          <i class="fa fa-chevron-down" style="font-size: .8em;"></i>
        </a>
        <ul>
          <?php if($_SESSION['admin']): ?>
            <li><a href="<?php echo BASE_URL . '/index.php' ?>">Nástěnka</a></li>
          <?php endif; ?>
          <li><a href="<?php echo BASE_URL . '/logout.php' ?>" class="logout">Odhlásit se</a></li>
        </ul>
      </li>
      <?php else: ?>
        <li><a href="<?php echo BASE_URL . '/register.php' ?>">Registrace</a></li>
        <li><a href="<?php echo BASE_URL . '/login.php' ?>">Přihlášení</a></li>
      <?php endif; ?>
    </ul>
</header>