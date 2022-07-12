    <?php if (isset($_SESSION['user'])) {
        header('Location: /kawa');
    } ?>


    <div class="containerMain">
        <div class="layoutContainertable">
            <div>

                <article>
                    <h1>Votre email </h1>

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
                        <input type="text" id="email" name="emailVerify">
                        <input class="form__button" type="submit" name="submit" value="verification email">
                    </form>

                </article>
            </div>
        </div>
    </div>