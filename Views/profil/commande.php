<section>
    <img src="../public/img/Icon_Profil-test.png" alt="profil picture">
    <h2>Profil</h2>
    <ul>
        <li><a href="./modifierProfil">Modifier mon profil</a></li>
        <li><a href="./modifierMotdePasse">Modifier mon mot de passe</a></li>
        <li><a href="./adresse">Adresse de livraison</a></li>
        <li><a href="./historiqueCommande">Historique de commande</a></li>
        <li><a href="./deconnexion">Se deconnecter</a></li>
    </ul>
</section>
<article>
    <section>
        <h1>Commande N°<?= $order[0]['num_commande'] ?></h1>
        <p>Livrée le <?= $order[0]['date_commande'] ?></p>
        <p>Adresse de livraison : </p>
        <p><?= $order[0]['voie'] ?></p>
        <p><?= $order[0]['voie_sup'] ?></p>
        <p><?= $order[0]['code_postal'] . ' ' . $order[0]['ville'] ?></p>
    </section>
    <section>
        <h2>Articles</h2>
        <p><?= $order[0]['titre_article'] ?></p>
        <p><?= $order[0]['nb_article'] ?></p>
        <p><?= $order[0]['prix_article'] ?> €</p>
    </section>
    <section>
        <h2>Prix total</h2>
        <p><?= $order[0]['prix_total'] ?> €</p>
    </section>
</article>