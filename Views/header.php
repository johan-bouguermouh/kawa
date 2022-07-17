<?php require 'app/controllers/headerController.php' ?>

<nav class="nav">

    <!-- <section class="nav__list"> -->
    <a class="nav__link" href="/kawa/boutique/all">
        <img class="nav__logo" style="height:40px" src="/kawa/public/assets/pictures/kawa_logo_color.svg" alt="revenir à l'accuil principal">
    </a>

    <button type="submit" class="nav__link nav__search btn">
        <i class="nav__icon fas fa-search"></i>
    </button>

    <a href="#mySidenav" class="nav__link" onclick="openNav()">
        <i class="nav__icon fa-solid fa-cart-shopping"></i>
        <?php if (isset($_SESSION['totalQuantity']) && $_SESSION['totalQuantity'] !== 0) { ?><div class="notifPanier"> <?= $_SESSION['totalQuantity'] ?> </div> <?php } ?>
    </a>

    <a class="nav__link" href="<?= $userPath ?>"><?= $iconUser ?></a>



    <div class="container">
        <button class="close" value="close"><img src="/kawa/public/img/close_icon.png" alt=""></button>
        <form class="nav__search">
            <label for="site-search">Search the site:</label>
            <input type="search" name="recherche" aria-label="Search through site content" class="container__search" placeholder="Search ...">
            <button class="nav__link">
                <i class="nav__icon fas fa-search"></i>
            </button>
        </form>
        <section id="searchResult"></section>
    </div>

    <!-- </section> -->

</nav>