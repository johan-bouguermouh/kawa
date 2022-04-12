<article class="mainAndSideAdmin">
    <section class="sideBarreAcount">
        <div>
            <h2>Profil</h2>
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
        <h1 class="title__profil">Adresse de Livraison</h1>
        <section class="alert">
            <?php if (isset($_SESSION['flash'])) : ?>
                <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
                    <div><?= $message; ?></div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['flash'])) :  ?>
                <?php unset($_SESSION['flash']) ?>
            <?php endif; ?>
        </section>

        <section>

            <?php

            for ($i = 0; $i <= 2; $i++) : ?>
                <?php if (isset($userAdress[$i])) : ?>
                    <p><?= $userAdress[$i]['nom_adresse'] ?></p>
                    <button class="form__button form__button--update"><a href="./adresse/modifierAdresse/<?= $userAdress[$i]['id_adresse'] ?>">Modifier</a></button><br>
                <?php else : ?>
                    <a class="form__link">Adresse disponible N° <?= $i + 1 ?></a>
                <?php endif; ?>
            <?php endfor; ?>

        </section>

        <?php if (count($userAdress) < 3) : ?>
            <form action="" method="post" class="form__container">
                <h2 class="form__title">Destinataire</h2>

                <div class="form__field">
                    <label class="form__label" for="nomAdresse">Nom de l'enregistrement : </label>
                    <input class="form__text" type="text" id="nomAdresse" name="nomAdresse" aria-required="true">
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
        <?php endif; ?>

    </article>
</article>