<section>
    <img src="../public/img/Icon_Profil-test.png" alt="profil picture">
    <h1>Profil</h1>
    <ul>
        <li><a href="./Profil">Modifier mon profil</a></li>
        <li><a href="./modifierMotdePasse">Modifier mon mot de passe</a></li>
        <li><a href="./adresse">Adresse de livraison</a></li>
        <li><a href="./historiqueCommande">Historique de commande</a></li>
        <li><a href="./deconnexion">Se deconnecter</a></li>
    </ul>
</section>
<article class="form">
    <section class="alert">
        <?php if (isset($_SESSION['flash'])) : ?>
            <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
                <p class="alert__message"><?= $message; ?></p>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['flash'])) :  ?>
            <?php unset($_SESSION['flash']) ?>
        <?php endif; ?>
    </section>

    <form class="form__container" action="" method="post">
        <h2 class="form__title">Destinataire</h2>

        <div class="form__field">
            <label class="form__label" for="nomAdresse">Nom de l'enregistrement : </label>
            <input class="form__text" type="text" id="nomAdresse" name="nomAdresse" aria-required="true">
        </div>

        <div class="form__field">
            <label class="form__label" for="nom">Nom :</label>
            <input class="form__text" type="text" id="nom" name="nom" aria-required="true">
        </div>

        <div class="form__field">
            <label class="form__label" for="prenom">Prenom :</label>
            <input class="form__text" type="text" id="prenom" name="prenom" aria-required="true">
        </div>

        <h2 class="form__title">Adresse</h2>

        <div class="form__field">
            <label class="form__label" for="libelle">Libellé : </label>
            <input class="form__text" type="text" id="libelle" name="libelle" aria-required="true">
        </div>

        <div class="form__field">
            <label class="form__label" for="voieSup">Voie Sup : </label>
            <input class="form__text" type="text" id="voieSup" name="voieSup" aria-required="true">
        </div>

        <div class="form__field">
            <label class="form__label" for="codePostal">Code Postal : </label>
            <input class="form__text" type="number" id="codePostal" name="codePostal" aria-required="true">
        </div>

        <div class="form__field">
            <label class="form__label" for="ville">Ville : </label>
            <input class="form__text" type="text" id="ville" name="ville" aria-required="true">
        </div>

        <div class="form__field">
            <label class="form__label" for="pays">Pays : </label>
            <input class="form__text" type="text" id="pays" name="pays" aria-required="true">
        </div>

        <div class="form__field">
            <label class="form__label" for="telephone">Telephone : </label>
            <input class="form__text" type="number" id="telephone" name="telephone" aria-required="true">
        </div>

        <div class="form__field">
            <input class="form__button" type="submit" name="submit" value="Ajouter">
        </div>
    </form>
</article>