<article class="mainAndSideAdmin">
    <section class="sideBarreAcount">
        <div>
            <h1>Profil</h1>
            <ul>
                <li><a href="/../boutique-en-ligne/profil/modifierProfil">Modifier mon profil</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="/../boutique-en-ligne/profil/modifierMotdePasse">Modifier mon mot de passe</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="">Adresse de livraison</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="/../boutique-en-ligne/profil/historiqueCommande">Historique de commande</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="/../boutique-en-ligne/profil/deconnexion">Se deconnecter</a></li>
            </ul>
        </div>
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

        <form action="" method="post" class="form__container">
            <h2 class="form__title">Destinataire</h2>

            <div class="form__field">
                <label class="form__label" for="nomAdresse">Nom de l'enregistrement : </label>
                <input class="form__text" type="text" id="nomAdresse" name="nomAdresse" aria-required="true" value="<?= $allInfoById[0]['nom_adresse'] ?>">
            </div>

            <h2 class="form__title">Adresse</h2>

            <div class="form__field">
                <label class="form__label" for="libelle">Libellé : </label>
                <input class="form__text" type="text" id="libelle" name="libelle" aria-required="true" value="<?= $allInfoById[0]['voie'] ?>">
            </div>

            <div class="form__field">
                <label class="form__label" for="voieSup">Voie Sup : </label>
                <input class="form__text" type="text" id="voieSup" name="voieSup" aria-required="true" value="<?= $allInfoById[0]['voie_sup'] ?>">
            </div>

            <div class="form__field">
                <label class="form__label" for="codePostal">Code Postal : </label>
                <input class="form__text" type="text" id="codePostal" name="codePostal" aria-required="true" value="<?= $allInfoById[0]['code_postal'] ?>">
            </div>

            <div class="form__field">
                <label class="form__label" for="ville">Ville : </label>
                <input class="form__text" type="text" id="ville" name="ville" aria-required="true" value="<?= $allInfoById[0]['ville'] ?>">
            </div>

            <div class="form__field">
                <label class="form__label" for="pays">Pays : </label>
                <input class="form__text" type="text" id="pays" name="pays" aria-required="true" value="<?= $allInfoById[0]['pays'] ?>">
            </div>

            <div class="form__field">
                <label class="form__label" for="telephone">Telephone : </label>
                <input class="form__text" type="tel" id="telephone" name="telephone" aria-required="true" value="<?= $allInfoById[0]['telephone'] ?>">
            </div>

            <div class="form__field--row">
                <input class="form__button form__button--update" type="submit" name="modifier" value="modifier">
                <input class="form__button form__button--update" type="submit" name="supprimer" value="supprimer">
            </div>
        </form>
    </article>
</article>