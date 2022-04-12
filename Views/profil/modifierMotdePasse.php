<article class="mainAndSideAdmin">
    <section class="sideBarreAcount">
        <div>
            <h1>Profil</h1>
            <ul>
                <li><a href="/../boutique-en-ligne/profil/modifierProfil">Modifier mon profil</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="">Modifier mon mot de passe</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="/../boutique-en-ligne/profil/adresse">Adresse de livraison</a><i class="fa-solid fa-angle-right"></i></li>
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

        <form class="form__container" action="#" method="post">
            <h1 class="form__title title__profil">Modifier mot de passe</h1>

            <div class="form__field">
                <label class="form__label" for="ancienMdp">Ancien mot de passe : </label>
                <input class="form__text" type="text" id="ancienMdp" name="ancienMdp">
            </div>

            <div class="form__field">
                <label class="form__label" for="nouveauMdp">Nouveau mot de passe : </label>
                <input class="form__text" type="text" id="nouveauMdp" name="nouveauMdp">
            </div>

            <div class="form__field">
                <label class="form__label" for="confirmMdp">Validez le nouveau mot de passe : </label>
                <input class="form__text" type="text" id="confirmMdp" name="confirmMdp">
            </div>

            <div class="form__field">
                <input class="form__button" type="submit" name="submit" value="Modifier">
            </div>
        </form>
    </article>
</article>