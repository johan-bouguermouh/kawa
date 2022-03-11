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
    <h1>Modifier mon Profil</h1>

    <?php if (isset($_SESSION['flash'])) : ?>
        <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
            <div><?= $message; ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['flash'])) :  ?>
        <?php unset($_SESSION['flash']) ?>
    <?php endif; ?>

    <form action="#" method="post">

        <label for="email">Email : </label>
        <input type="text" id="email" name="email" value="<?= $_SESSION['user']['email'] ?>">

        <label for="nom">Nom : </label>
        <input type="text" id="nom" name="nom" value="<?= $_SESSION['user']['nom'] ?>">

        <label for="prenom">Prenom : </label>
        <input type="text" id="prenom" name="prenom" value="<?= $_SESSION['user']['prenom'] ?>">

        <input type="submit" name="submit" value="Modifier">
    </form>
</article>