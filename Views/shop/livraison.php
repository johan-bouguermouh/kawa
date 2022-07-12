  <?php
    require_once './app/Controllers/ShoppingCartController.php';
    if (!isset($_SESSION['user'])) {
        header('Location: /kawa/connexion');
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




  <div class="containerMain">

      <form class="formLivraison" action="" method="post">

          <div class="formField">

              <?php if (isset($_SESSION['flash'])) : ?>
                  <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
                      <div><?= $message; ?></div>
                  <?php endforeach; ?>
              <?php endif; ?>

              <?php if (isset($_SESSION['flash'])) :  ?>
                  <?php unset($_SESSION['flash']) ?>
              <?php endif; ?>

              <h2> 1. Vos informations : </h2>
              <?php

                if (isset($adress)) {

                ?>
                  <label>
                      <h3>Vos adresses :</h3>
                  </label>


                  <?php foreach ($adress as $value) { ?>

                      <button class="form__button adress" type="submit" name="id_adresse" value="<?= $value['id_adresse'] ?>"><?= $value['nom_adresse'] ?></button>

                  <?php } ?>

              <?php } ?>


              <H3> Contact </H3>


              <fieldset>
                  <legend> Prenom : </legend>
                  <input class="formLivraison__text" name="prenom" value="" type="text">
              </fieldset>

              <fieldset>
                  <legend> Nom : </legend>
                  <input class="formLivraison__text" name="nom" value="" type="text">
              </fieldset>

              <fieldset>
                  <legend l> Numero de telephone : </legend>
                  <input class="formLivraison__text" name="telephone" value="" type="text">
              </fieldset>

              <fieldset>
                  <legend> Email : </legend>
                  <input class="formLivraison__text" name="email" value="" type="text">
              </fieldset>


              <H3> Adresse </H3>

              <fieldset>
                  <legend> Personnaliser votre adresse : </legend>
                  <input class="formLivraison__text" name="nom_adresse" value="<?php if (isset($_SESSION['select_adress'])) {
                                                                                    $id  = $_SESSION['select_adress'];
                                                                                    echo $adress[$id]['nom_adresse'];
                                                                                } ?>" type="text">
              </fieldset>

              <fieldset>
                  <legend> libellé : </legend>
                  <input class="formLivraison__text" name="voie" value="<?php if (isset($_SESSION['select_adress'])) {
                                                                            $id  = $_SESSION['select_adress'];
                                                                            echo $adress[$id]['voie'];
                                                                        } ?>" type="text">
              </fieldset>

              <fieldset>
                  <legend> Résidence, appartement, autre : </legend>
                  <input class="formLivraison__text" name="voie_sup" value="<?php if (isset($_SESSION['select_adress'])) {
                                                                                $id  = $_SESSION['select_adress'];
                                                                                echo $adress[$id]['voie_sup'];
                                                                            } ?>" type="text">
              </fieldset>

              <fieldset>
                  <legend> Code Postal : </legend>
                  <input class="formLivraison__text" name="code_postal" value="<?php if (isset($_SESSION['select_adress'])) {
                                                                                    $id  = $_SESSION['select_adress'];
                                                                                    echo $adress[$id]['code_postal'];
                                                                                } ?>" type="text">
              </fieldset>

              <fieldset>
                  <legend> Ville : </legend>
                  <input class="formLivraison__text" name="ville" value="<?php if (isset($_SESSION['select_adress'])) {
                                                                                $id  = $_SESSION['select_adress'];
                                                                                echo $adress[$id]['ville'];
                                                                            } ?>" type="text">
              </fieldset>

              <fieldset>
                  <legend> Pays : </legend>
                  <input class="formLivraison__text" name="pays" value="<?php if (isset($_SESSION['select_adress'])) {
                                                                            $id  = $_SESSION['select_adress'];
                                                                            echo $adress[$id]['pays'];
                                                                        } ?>" type="text">
              </fieldset>

              <input class="formLivraison__text" name="fk_id_utilisateur" value="<?= $_SESSION['user']['id_utilisateur'] ?>" type="hidden">

              <input class="form__button submit" name="submit" type="submit" value="Valider">
              <input class="form__button submit" name="back" type="submit" value="retour">
          </div>

          <div class="resumeOrder">


              <?php if (!empty($_SESSION['quantite'])) { ?>
                  <h3> nombre total d'articles : <?php echo $_SESSION['totalQuantity'] ?> </h3>
                  <h3>Total tva incl <?= $_SESSION['totalPrice'] ?> €</h3>
                  <a href="#mySidenav" class="nav__link" onclick="openNav()">
                      <p class="form__button">Modifier</p>
                  </a>
                  <?php
                    //affiche uniquement les articles selectionnés par l'utilisateur
                    foreach ($articles as $article) {
                        foreach ($_SESSION['quantite'] as $key => $value) {
                            if ($article['id_article'] == $key) {
                    ?>

                              <div class="cardProduct">


                                  <img class="" src="/kawa/public/assets/pictures/pictures_product/<?= $article['image_article'] ?>" alt="">
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

      </form>
  </div>