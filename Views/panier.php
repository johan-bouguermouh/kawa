<?php
require_once './app/controllers/ShoppingCartController.php';


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
    <h1>Mon panier</h1>

    <?php if (!empty($_SESSION['quantite'])) { ?>
        <p> nombre total d'articles : <?php echo $_SESSION['totalQuantity'] ?> </p>
        <?php if (isset($_SESSION['flash'])) : ?>
            <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
                <div><?= $message; ?></div>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['flash'])) :  ?>
            <?php unset($_SESSION['flash']) ?>
        <?php endif; ?>




        <?php
        //affiche uniquement les articles selectionnés par l'utilisateur
        foreach ($articles as $article) {
            foreach ($_SESSION['quantite'] as $key => $value) {
                if ($article['id_article'] == $key) {
        ?>
                    <form class="poductPanier" action="" method="post">

                        <img class="picturePanier" src="/boutique-en-ligne/public/assets/pictures/pictures_product/<?= $article['image_article'] ?>" alt="">
                        <div class="infoPanier">
                            <div class="firstInfoPanier">
                                <p> <?= $article['titre_article'] ?> </p>
                                <p><?= $article['prix_article'] ?> €</p>
                            </div>
                            <div class="selectQuatity">
                                <div>
                                    <input name="id_article" value="<?= $article['id_article'] ?>" type="hidden">
                                    <button class="buttonPanierUp" name="upQuantity" value="1" type="submit"> + </button>
                                    <div>
                                        <p><?= $_SESSION['quantite'][$article['id_article']]  ?></p>
                                    </div>
                                    <?php if ($_SESSION['quantite'][$article['id_article']] > 0) { ?>
                                        <button class="buttonPanierDown" name="downQuantity" value="1" type="submit"> - </button>

                    </form>
                <?php } ?>
                </div>
                <?php if (isset($_SESSION['quantite'][$article['id_article']])) { ?>

                    <form action="" method="post">
                        <button name="deleteProduct" type="submit"> <i class="fa-solid fa-trash"></i> </button>
                        <input name="id_article" value="<?= $article['id_article'] ?>" type="hidden">
                    </form>
                <?php } ?>
                </div>

                <p>prix total: <?php if (isset($_SESSION['singlePrice'][$article['id_article']])) {
                                    echo $_SESSION['singlePrice'][$article['id_article']];
                                }  ?> €</p>
                </div>

    <?php }
            }
        } ?>
    <div class="footerPanier">
        <p>Total tva incl : <?= $_SESSION['totalPrice'] ?> €</p>
        <form action="" method="post">
            <input class="button" name="goDelivery" value="commandé" type="submit">
        </form>
    </div>
<?php } else { ?>
    <p>Votre panier est vide.</p>
<?php
    } ?>
</section>