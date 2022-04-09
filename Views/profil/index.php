<article class="mainAndSideAdmin">
    <section class="sideBarreAcount">
    <div>
        <h2>Profil</h2>
        <ul>
            <li><a href="profil/modifierMotdePasse">Modifier mon mot de passe</a></li>
            <li><a href="profil/adresse">Adresse de livraison</a></li>
            <li><a href="profil/historiqueCommande">Historique de commande</a></li>
            <li><a href="profil/deconnexion">Se deconnecter</a></li>
        </ul>
        </div>
    </section>

    <section class="mainProfil">
        <img src="public/img/Icon_Profil-test.png" alt="profil picture">
        <h1><?= ucfirst(@$_SESSION['user']['prenom']) . ' ' . ucfirst(@$_SESSION['user']['nom']); ?></h1>
        <p><?= @$_SESSION['user']['email'] ?></p>
        <article class="form">
        
            <?php if (isset($_SESSION['flash'])) : ?>
                <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
                    <div><?= $message; ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
        
            <?php if (isset($_SESSION['flash'])) :  ?>
                <?php unset($_SESSION['flash']) ?>
            <?php endif; ?>
        
            <form class="form__container" action="#" method="post">
        
                <h1 class="form__title">Modifier mon Profil</h1>
        
                <div class="form__field">
                    <label for="email" class="form__label">Email : </label>
                    <input class="form__text" type="text" id="email" name="email" value="<?= $_SESSION['user']['email'] ?>">
                </div>
        
                <div class="form__field">
                    <label for="nom" class="form__label">Nom : </label>
                    <input class="form__text" type="text" id="nom" name="nom" value="<?= $_SESSION['user']['nom'] ?>">
                </div>
        
                <div class="form__field">
                    <label for="prenom" class="form__label">Prenom : </label>
                    <input class="form__text" type="text" id="prenom" name="prenom" value="<?= $_SESSION['user']['prenom'] ?>">
                </div>
        
                <div class="form__field">
                    <input class="form__button" type="submit" name="submit" value="Modifier">
                </div>
            </form>
        </article>
    </section> 

    <?php if ($notifAdresse !== null) : ?>
        <section>
            <p><?= $notifAdresse ?></p>
            <a href="profil/adresse">Enregistrer une adresse ></a>
        </section>
        <?php endif; ?>
        
    </article>

</article>

