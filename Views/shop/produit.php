
<div class="containerProduit">
    <section class="alert alert--success">
        <?php if (isset($_SESSION['flash'])) : ?>
            <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
                <p class="alert__message"><?= $message; ?></p>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['flash'])) :  ?>
            <?php unset($_SESSION['flash']) ?>
        <?php endif; ?>
    </section>

    <article class="product">

        <!-- <?php if (isset($_SESSION['flash'])) : ?>
        <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
            <div><?= $message; ?></div>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['flash'])) :  ?>
        <?php unset($_SESSION['flash']) ?>
    <?php endif; ?> -->


        <img class="product__image" src="../public/assets/pictures/pictures_product/<?= $product[0]['image_article'] ?>" alt="Image du produit">

        <div class="test">
            <div class="product__heading">
                <h1 class="product__title"><?= $product[0]['titre_article'] ?></h1>

                <div class="like">
                    <form class="like__form" action="#like" method="post">
                        <button class="like__button" type="submit" name="like" id="like"><img class="like__icon" src="../public/img/Icon_Like-test.png" alt="Icon like"></button>
                    </form>
                    <p class="like__number"><?= $likes ?></p>
                </div>

            </div>

            <div class="details">
                <ul class="details__list">
                    <li class="details__item"><span>Provenence : </span><?= $CatOfProduct['origin'][0]['nom_categorie'] ?></li>
                    <li class="details__data"><span>Type : </span><?= $CatOfProduct['variete'][0]['nom_categorie'] ?></li>
                    <li class="details__item"><span>Saveur :</span>
                        <?php foreach ($CatOfProduct['flavor'] as $key => $flavors) : ?>
                            <?= $flavors['nom_categorie'] ?>
                        <?php endforeach; ?>
                        <!-- <?php implode(',', $CatOfProduct['flavor']); ?> -->
                    </li>
                    <li class="details__item"><span>Force :</span>
                        <?php for ($i=0; $i < 5; $i++) { 
                            if($i < intval($CatOfProduct['strong'][0]['nom_categorie']))
                            { ?>
                                <img class="item__grain" src="../public/assets/pictures/kawa_icon_strong.svg" alt="graine de café">
                           <?php }
                           else{ ?>
                            <img class="item__grain--none" src="../public/assets/pictures/kawa_icon_strong.svg" alt="graine de café">
                           <?php }
                        } ?>
                    </li>
                </ul>
                <p><?= $product[0]['description_article'] ?></p>
                <p>Fournisseur : <?= $product[0]['fournisseur'] ?></p>
                <p><?= $product[0]['conditionnement'] ?></p>


                <section class="comment-preview">
                    <p class="comment-preview__number"> Nombre de commentaire : <?= $numberOfComment ?></p>
                    <a class="comment-preview__link" href="#comment">Voir les commentaires</a>
                </section>

                <div class="payement">
                    <form class="basket" action="" method="post">
                        <label class="content__label" for="addBasket"></label>
                        <input type="hidden" name="id_article" value="<?= $product[0]['id_article'] ?>"></input>
                        <input type="hidden" name="prix_article" value="<?= $product[0]['prix_article'] ?>"></input>
                        <input class="form__button form__button--product" type="submit" id="addBasket" name="add" value="AJOUTER AU PANIER >">
                    </form>
                    <p class="price"><?= $product[0]['prix_article'] ?>€</p>
                </div>
            </div>
        </div>
    </article>


    <article class="comment" id="comment">
        <h2 class="comment__title">Commentaires</h2>
        <?php

        foreach ($comments as $key => $comment) {

            $NbrOfIndex = count($comment);
            $NbrOfIndex = $NbrOfIndex - 8;

        ?>

            <section class="comment__commentary">
                <h3><?= $comment['prenom'] . ' ' . $comment['nom'] ?> <?php if ($comment['signaler'] == 1) { ?> <span> signalé ! </span><?php } ?></h3>
                <p><?= $comment['commentaire'] ?></p>
                <p><?= $comment['date'] ?></p>
            </section>

            <section class="separator">
                <form class="form-reply" action="" method="POST">
                    <?php if ($comment['signaler'] == 0) { ?>
                        <input type="hidden" value="<?= $comment['id_commentaire'] ?>" name="signalement">
                        <button class="signal" type="submit" name="signaler" value="1">Signaler</button>
                    <?php  } ?>

                    <input type="hidden" id="comment" name="id_commentaire" value="<?= $comment['id_commentaire'] ?>">

                    <input class="form-reply-text" type="text" id="comment" name="comment" placeholder="Répondre au commentaire" value="">
                    <input class="form__button form__button--product form__button--reply" type="submit" name="submitAnswer" value="répondre">
                </form>

                <hr>
            </section>

            <?php
            for ($i = 0; $i <= $NbrOfIndex; $i++) {
                if ($comment['fk_id_commentaire'] == $comment['id_commentaire']) {

            ?>
                    <section class="reply">

                        <h3> réponse par : <?= $comment[$i]['reponse_nom'] . ' ' . $comment[$i]['reponse_prenom'] ?> <?php if ($comment[$i]['signaler'] == 1) { ?> Commentaire signalé ! <?php } ?></h3>
                        <p> commentaire : <?= $comment[$i]['reponse_assoc'] ?></p>
                        <p> date : <?= $comment[$i]['reponse_date'] ?></p>
                        <form action="" method="POST">
                            <?php if ($comment[$i]['signaler'] == 0) { ?>
                                <input type="hidden" value="<?= $comment[$i]['id_reponse_com'] ?>" name="idReportAnswer">
                                <button type="submit" name="reportAnswer" value="1" class="signal">Signaler</button>
                            <?php  } ?>
                        </form>
                    </section>


        <?php
                }
            }
        }

        ?>



        <section class="response">
            <form action="" method="POST">
                <label for="comment" style="display: none">Ecrire un commentaire</label>
                <input class="form-reply-text" class="test" type="text" id="comment" name="com" placeholder="Laissez votre commentaire ...">
                <input class="form__button form__button--product send-answer" type="submit" name="submit" value="Ecrire un commentaire">
            </form>
        </section>
</div>
</article>
</div>