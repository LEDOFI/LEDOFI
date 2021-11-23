<?php include('app\database\db.php'); ?>
<!DOCTYPE html>
<html lang="cs">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=BioRhyme&family=Lora&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="assets/css/style.css">

  <title>Los Polos Technikos</title>
</head>

<body>

  <?php include("app/includes/header.php"); ?>

  <?php include("app/includes/messages.php"); ?>

  <div class="page-wrapper">

    <div class="post-slider">
      <h1 class="slider-title">Oblíbené články</h1>
      <i class="fas fa-chevron-left prev"></i>
      <i class="fas fa-chevron-right next"></i>

      <div class="post-wrapper">

        <div class="post">
          <img src="images/img1.jpg" alt="" class="slider-image">
          <div class="post-info">
            <h4><a href="#">Lorem ipsum dolor sit amet</a></h4>
            <i class="far fa-user">Zdeněk Šrámek</i>
            &nbsp;
            <i class="far fa-calendar">10. listopadu 2021</i>
          </div>
        </div>

        <div class="post">
          <img src="assets/images/img1.jpg" alt="" class="slider-image">
          <div class="post-info">
            <h4><a href="#">Lorem ipsum dolor sit amet</a></h4>
            <i class="far fa-user">Aleš Brabec</i>
            &nbsp;
            <i class="far fa-calendar">10. listopadu 2021</i>
          </div>
        </div>

        <div class="post">
          <img src="assets/images/img1.jpg" alt="" class="slider-image">
          <div class="post-info">
            <h4><a href="#">Lorem ipsum dolor sit amet</a></h4>
            <i class="far fa-user">Tadeáš Fejt</i>
            &nbsp;
            <i class="far fa-calendar">10. listopadu 2021</i>
          </div>
        </div>

        <div class="post">
          <img src="assets/images/img1.jpg" alt="" class="slider-image">
          <div class="post-info">
            <h4><a href="#">Lorem ipsum dolor sit amet</a></h4>
            <i class="far fa-user">Jan Musil</i>
            &nbsp;
            <i class="far fa-calendar">10. listopadu 2021</i>
          </div>
        </div>

        <div class="post">
          <img src="assets/images/img1.jpg" alt="" class="slider-image">
          <div class="post-info">
            <h4><a href="#">Lorem ipsum dolor sit amet</a></h4>
            <i class="far fa-user">Unknown</i>
            &nbsp;
            <i class="far fa-calendar">10. listopadu 2021</i>
          </div>
        </div>


      </div>

    </div>

    <div class="content clearfix">

      <div class="main-content">
        <h1 class="recent-post-title">Nedávno přidané</h1>

        <div class="post clearfix">
          <img src="assets/images/img1.jpg" alt="" class="post-image">
          <div class="post-preview">
            <h2><a href="#">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</a></h2>
            <i class="far fa-user">Unknown</i>
            &nbsp;
            <i class="far fa-calendar">10. listopadu 2021</i>
            <p class="preview-text">
              Lorem ipsum dolor sit amet consectetur, adipisicing elit.
              Exercitationem optio possimus a inventore maxime laborum.
            </p>
            <a href="#" class="btn read-more">Zobrazit více</a>
          </div>
        </div>

        <div class="post clearfix">
          <img src="assets/images/img1.jpg" alt="" class="post-image">
          <div class="post-preview">
            <h2><a href="#">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</a></h2>
            <i class="far fa-user">Unknown</i>
            &nbsp;
            <i class="far fa-calendar">10. listopadu 2021</i>
            <p class="preview-text">
              Lorem ipsum dolor sit amet consectetur, adipisicing elit.
              Exercitationem optio possimus a inventore maxime laborum.
            </p>
            <a href="#" class="btn read-more">Zobrazit více</a>
          </div>
        </div>
        <div class="post clearfix">
          <img src="assets/images/img1.jpg" alt="" class="post-image">
          <div class="post-preview">
            <h2><a href="#">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</a></h2>
            <i class="far fa-user">Unknown</i>
            &nbsp;
            <i class="far fa-calendar">10. listopadu 2021</i>
            <p class="preview-text">
              Lorem ipsum dolor sit amet consectetur, adipisicing elit.
              Exercitationem optio possimus a inventore maxime laborum.
            </p>
            <a href="#" class="btn read-more">Zobrazit více</a>
          </div>
        </div>
        <div class="post clearfix">
          <img src="assets/images/img1.jpg" alt="" class="post-image">
          <div class="post-preview">
            <h2><a href="#">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</a></h2>
            <i class="far fa-user">Unknown</i>
            &nbsp;
            <i class="far fa-calendar">10. listopadu 2021</i>
            <p class="preview-text">
              Lorem ipsum dolor sit amet consectetur, adipisicing elit.
              Exercitationem optio possimus a inventore maxime laborum.
            </p>
            <a href="#" class="btn read-more">Zobrazit více</a>
          </div>
        </div>

      </div>

      <div class="sidebar">

        <div class="section search">
          <h2 class="section-title">Vyhledávání</h2>
          <form action="index.php" method="post">
            <input type="text" name="search-term" class="text-input" placeholder="Hledej...">
          </form>
        </div>


        <div class="section topics">
          <h2 class="section-title">Témata</h2>
          <ul>
            <li><a href="#">Programování</a></li>
            <li><a href="#">Finance</a></li>
            <li><a href="#">Matematika</a></li>
            <li><a href="#">Webové stránky</a></li>
          </ul>
        </div>

      </div>

    </div>

  </div>

  <?php include("app/includes/footer.php"); ?>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

  <script src="assets/js/scripts.js"></script>

</body>

</html>