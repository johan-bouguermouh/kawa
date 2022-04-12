<?php
require_once './app/Controllers/ShoppingCartController.php';
if (!isset($_SESSION['user'])) {
  header('Location: /boutique-en-ligne/');
}

if (!isset($_SESSION['validate'])) {
  header('Location: /boutique-en-ligne/');
}
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

<?php if (isset($_SESSION['flash'])) : ?>
  <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
    <div><?= $message; ?></div>
  <?php endforeach; ?>
<?php endif; ?>

<?php if (isset($_SESSION['flash'])) :  ?>
  <?php unset($_SESSION['flash']) ?>
<?php endif; ?>


<div class="containerMain">

  <article class="formLivraison paiement" action="" method="post">

    <div class="formField paiement">
      <?php if (isset($_SESSION['flash'])) : ?>
        <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
          <div><?= $message; ?></div>
        <?php endforeach; ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['flash'])) :  ?>
        <?php unset($_SESSION['flash']) ?>
      <?php endif; ?>

      <h1> Paiement de la commande : </h1>
      <form method="post" action="">

        <input id="cardholder-name" type="text" placeholder="Titulaire de la carte">
        <div id="card-elements" class="test"></div>
        <div id="card-errors" role="alert"></div>
        <button class="form__button" id="card-button" type="submit" name="submit">Valider paiement</button>




      </form>
      <a href="./livraison"> <button class="form__button">retour</button></a>
      <div id="errors"></div>
      <script src="https://js.stripe.com/v3/"></script>
      <script src="https://code.jquery.com/jquery-2.0.2.min.js"></script>
      <script src="script.js"></script>

    </div>

    <div class="resumeOrder paiement">


      <?php if (!empty($_SESSION['quantite'])) { ?>
        <h3> nombre total d'articles : <?php echo $_SESSION['totalQuantity'] ?> </h3>
        <h3>Total tva incl <?= $_SESSION['totalPrice'] ?> €</h3>

        <?php
        //affiche uniquement les articles selectionnés par l'utilisateur
        foreach ($articles as $article) {
          foreach ($_SESSION['quantite'] as $key => $value) {
            if ($article['id_article'] == $key) {
        ?>

              <div class="cardProduct">


                <img class="" src="/boutique-en-ligne/public/assets/pictures/pictures_product/<?= $article['image_article'] ?>" alt="">
                <div class="cardProduct resume">
                  <p> <?= $article['titre_article'] ?> </p>
                  <div>
                    <p>prix</p>
                    <p> <?= $article['prix_article'] ?> €</p>
                  </div>

                  <div>

                    <p> Qté <?= $_SESSION['quantite'][$article['id_article']]  ?></p>
                    <p><?php if (isset($_SESSION['singlePrice'][$article['id_article']])) {
                          echo $_SESSION['singlePrice'][$article['id_article']];
                        }  ?> €</p>

                  </div>

                </div>
              </div>

      <?php }
          }
        }
      } ?>

    </div>

  </article>
</div>