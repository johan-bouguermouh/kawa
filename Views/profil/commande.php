<article class="mainAndSideAdmin commande">
    <section class="sideBarreAcount">
        <div>
            <h1>Profil</h1>
            <ul>
                <li><a href="/../boutique-en-ligne/profil/modifierProfil">Modifier mon profil</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="/../boutique-en-ligne/profil/modifierMotdePasse">Modifier mon mot de passe</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="/../boutique-en-ligne/profil/adresse">Adresse de livraison</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="">Historique de commande</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="/../boutique-en-ligne/profil/deconnexion">Se deconnecter</a></li>
            </ul>
        </div>
    </section>
    <article class="order">
        <div class="order__resume">
            <?php foreach ($order_resume as $key => $order) { ?>

                <section>
                    <h1 class="order__title">Commande N°<?= $order['fk_id_num_commande'] ?></h1>
                    <p><span>Livrée le : </span><?= $order['date'] ?></p>

                    <p><span>Adresse de livraison : </span></p>

                    <p><?= $order['voie'] ?></p>
                    <p><?= $order['voie_sup'] ?></p>
                    <p><?= $order['code_postal'] . ' ' . $order['ville'] ?></p>
                </section>
            <?php break;
            } ?>
            <hr>
            <section>
                <?php foreach ($order_resume as $key => $order) { ?>
                    <h2 class="order__title">Article <?= $key + 1 ?></h2>
                    <p><span>Article: </span><?= $order['titre_article'] ?></p>
                    <p> <span>Quantité: </span><?= $order['nb_article'] ?></p>
                    <p><span>Prix: </span><?= $order['prix_article'] ?> € ttc</p>
            </section>
        <?php } ?>
        <hr>


        <section>
            <h2 class="order__title">Prix total</h2>
            <p><span>Total d'articles : </span><?= $order['total_produit'] ?> </p>
            <p><span>Prix total :</span><?= $order['prix_avec_tva'] ?> € ttc</p>
        </section>
        </div>
    </article>
</article>