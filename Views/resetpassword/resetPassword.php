      <?php if (isset($_SESSION['user'])) {
            header('Location: /kawa');
        } ?>


      <div class="containerMain">
          <div class="layoutContainertable ">
              <div>


                  <article class="resetPassword">
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

                          <label for="question_secrete">Votre question secrete : <?= $_SESSION['reset']['question'] ?> ? </label>
                          <label for="reponse">Votre réponse : </label>
                          <input type="text" id="reponse" name="reponse">

                          <label for="mdp">Nouveau mot de passe : </label>
                          <input type="password" id="mdp" name="mdp">

                          <label for="mdpConfirm">Confirmez votre mot de Passe :</label>
                          <input type="password" id="mdpConfirm" name="mdpConfirm" aria-required="true">

                          <input class="form__button" type="submit" name="submit" value="valider">
                      </form>

                  </article>

              </div>
          </div>
      </div>