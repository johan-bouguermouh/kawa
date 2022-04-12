<article class="form">

    <?php if(isset($_SESSION['flash'])) :?>

        <?php if(isset($_SESSION['flash']['sucess']))
        {
            $alert = "alert alert--success";
            }
            else{
            $alert = "alert";
            }?>

        <section class="<?=$alert?>">
            <?php if (isset($_SESSION['flash'])) : ?>
                <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
                    <p class="alert__message"><?= $message; ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
    
            <?php if (isset($_SESSION['flash'])) :  ?>
                <?php unset($_SESSION['flash']) ?>
            <?php endif; ?>
        </section>
        
    <?php endif; ?>


    <form class="form__container" action="#" method="post">

        <h1 class="form__title">Connexion</h1>
        <div class="form__field">
            <label for="email" class="form__label">Email : </label>
            <input class="form__text" type="text" id="email" name="email">
        </div>
        <div class="form__field">
            <label for="mdp" class="form__label">Mot de passe : </label>
            <input class="form__text" type="password" id="mdp" name="mdp">
        </div>

        <div class="form__field">
            <input class="form__button" type="submit" name="submit" value="Connexion">
        </div>

        <a class="form__link" href="checkemail">Mot de passe oublié ?</a>
        <a class="form__link" href="inscription">Je créer un compte</a>
    </form>
</article>