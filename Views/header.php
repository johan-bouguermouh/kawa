<?php require 'app/controllers/headerController.php' ?>

<nav class="nav">

    <!-- <section class="nav__list"> -->
    <a class="nav__link" href="/boutique-en-ligne/boutique/all">
        <img class="nav__logo" style="height:40px" src="/boutique-en-ligne/public/assets/pictures/kawa_logo_color.svg" alt="revenir à l'accuil principal">
    </a>

    <a href="#mySidenav" class="nav__link" onclick="openNav()">
        <i class="nav__icon fa-solid fa-cart-shopping"></i>
        <?php if (isset($_SESSION['totalQuantity']) && $_SESSION['totalQuantity'] !== 0) { ?><div class="notifPanier"> <?= $_SESSION['totalQuantity'] ?> </div> <?php } ?>
    </a>

    <a class="nav__link" href="<?= $userPath ?>"><?= $iconUser ?></a>

    <button type="submit" class="nav__link btn">
        <i class="nav__icon fas fa-search"></i>
    </button>

    <div class="container">
        <button class="close" value="close"><img src="/boutique-en-ligne/public/img/close_icon.png" alt=""></button>
        <form class="nav__search" action="/boutique-en-ligne/boutique/all" method="GET">
            <label for="site-search">Search the site:</label>
            <input type="search" name="recherche" aria-label="Search through site content" class="container__search" placeholder="Search ...">
            <button class="nav__link">
                <i class="nav__icon fas fa-search"></i>
            </button>
        </form>
    </div>

    <!-- </section> -->

</nav>