<?php
require_once './app/Controllers/ShoppingCartController.php';


$controller = new App\Controllers\ShoppingCartController();

$controller->upValue();
$controller->downValue();
$controller->shoppingBag();
$controller->deleteProduct();
$controller->singlePrice();
$controller->totalQuantity();
$controller->totalPrice();
$controller->delivery();
$controller->index();
extract($controller->index());
?>
<section id="mySidenav" class="sidenav">
    <a href="#" class="closebtn" onclick="closeNav()">&times;</a>
    <div class="sidenav__content">
        <h1>Mon panier</h1>

    <?php if (empty($_SESSION['quantite'])) { ?>
    <p>Votre panier est vide.</p>
    <?php
        } ?>
    </div>
</section>