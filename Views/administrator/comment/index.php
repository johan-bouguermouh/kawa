      <div class="containerMain">

          <?php echo $menuAdmin; ?>



          <div class="layoutContainertable commentAdmin">

              <div>
                  <article>
                      <h1>Admin commentaires : </h1>

                      <?php if (isset($_SESSION['flash'])) : ?>
                          <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
                              <div><?= $message; ?></div>
                          <?php endforeach; ?>
                      <?php endif; ?>

                      <?php if (isset($_SESSION['flash'])) :  ?>
                          <?php unset($_SESSION['flash']) ?>
                      <?php endif; ?>
                      <form method="post" name="crudComment">
                          <label> Créer un commentaire</label>

                          <textarea name="commentaire" placeholder="Votre commentaire"></textarea>

                          <input list="articles" type="text" placeholder="choisir article">
                          <datalist id="articles">
                              <?php foreach ($articles as $article) {
                                ?>

                                  <option value="<?= $article['titre_article'] ?>">
                                      <input name="id_article" value="<?= $article['id_article'] ?>" type="hidden">

                                  <?php } ?>

                          </datalist>
                          <button class="form__button" name="create_comment" type="submit"> Créer </button>

                      </form>
                      <h3>Commentaire des admins : </h3>

                      <?php foreach ($comment as $value) {

                            if ($value['role'] == 'Admin' && $value['check_admin'] == 0) { ?>

                              <div class="containerInfo">

                                  <label> Commentaire : de <?= $value['prenom'] ?> <?= $value['nom'] ?> article <?= $value['titre_article'] ?> le : <?= $value['date'] ?> </label>

                                  <form action="" method="post">

                                      <input name="id_commentaire" value="<?= $value['id_commentaire'] ?>" type="hidden">

                                      <input name="comment" value="<?= $value['commentaire'] ?>" type="text">
                                      <div>

                                          <button class="form__button"> <a href="../produit/<?= $value['fk_id_article'] ?>">Voir l'article </a></button>

                                          <button class="form__button" name="update_comment" type="submit"> modifier </button>

                                          <button class="form__button" name="validateCom" type="submit" value="<?= $value['check_admin'] ?>"> V </button>
                                          <button class="form__button" name="delete_comment" type="submit"> X </button>

                                      </div>


                                  </form>
                              </div>
                      <?php }
                        } ?>
                      <?php

                        foreach ($answers as $answer) {
                            if ($answer['role'] == 'Admin' && $answer['check_admin'] == 0) {
                        ?>
                              <div class="containerInfo">

                                  <label> Commentaire : de <?= $answer['prenom'] ?> <?= $answer['nom'] ?> sur le commentaire <?= $answer['reponse_au_com'] ?> : <?= $answer['date'] ?> </label>

                                  <form action="" method="post">

                                      <input name="id_reponse_com" value="<?= $answer['id_reponse_com'] ?>" type="hidden">
                                      <input name="answer" value="<?= $answer['commentaire'] ?>" type="text">

                                      <div>

                                          <button class="form__button"> <a href="../produit/<?= $answer['fk_id_article'] ?>">Voir l'article </a></button>

                                          <button class="form__button" name="update_answer_comment" type="submit"> modifier </button>

                                          <button class="form__button" name="validateAnswerCom" type="submit" value="<?= $answer['check_admin'] ?>"> V </button>

                                          <button class="form__button" name="delete_answer_comment" type="submit"> X </button>
                                      </div>
                                  </form>
                              </div>
                      <?php
                            }
                        } ?>

                      <h3>Commentaire d'utilisateur des 3 dernières semaines : </h3>

                      <?php

                        foreach ($commentCommunityManag as $valueTime) {

                            if ($valueTime['role'] == 'Utilisateurs'  && $valueTime['check_admin'] == 0) { ?>

                              <div class="containerInfo">

                                  <label> Commentaire : de <?= $valueTime['prenom'] ?> <?= $valueTime['nom'] ?> article : <?= $valueTime['titre_article'] ?> le : <?= $valueTime['date'] ?> </label>


                                  <form action="" method="post">

                                      <input name="id_commentaire" value="<?= $valueTime['id_commentaire'] ?>" type="hidden">
                                      <input name="comment" value="<?= $valueTime['commentaire'] ?>" type="text">
                                      <textarea name="answerComAdmin" placeholder="Votre réponse."></textarea>

                                      <div>


                                          <button class="form__button"> <a href="../produit/<?= $valueTime['fk_id_article'] ?>">Voir l'article </a></button>


                                          <input name="fk_id_article" value="<?= $valueTime['fk_id_article'] ?>" type="hidden">

                                          <button class="form__button" name="subAnswerComAdmin" type="submit"> Répondre </button>

                                          <button class="form__button" name="validateCom" type="submit" value="<?= $valueTime['check_admin'] ?>"> V </button>
                                          <button class="form__button" name="delete_comment" type="submit"> X </button>
                                      </div>

                                  </form>

                              </div>
                      <?php }
                        } ?>
                      <h3>Réponses des utilisateurs : </h3>
                      <?php

                        foreach ($answersCommunityManag as $answerTime) {

                            if ($answerTime['role'] == 'Utilisateurs'  && $answerTime['check_admin'] == 0) { ?>

                              <div class="containerInfo">

                                  <label> Commentaire tototototo : de <?= $answerTime['prenom'] ?> <?= $answerTime['nom'] ?> sur le commentaire <?= $answerTime['reponse_au_com'] ?> le : <?= $answerTime['date'] ?> </label>

                                  <form action="" method="post">

                                      <input name="id_reponse_com" value="<?= $answerTime['id_reponse_com'] ?>" type="hidden">
                                      <input name="answer" value="<?= $answerTime['commentaire'] ?>" type="text">
                                      <textarea name="answerAdmin" placeholder="Votre réponse."></textarea>

                                      <div>

                                          <button class="form__button"> <a href="../produit/<?= $answerTime['fk_id_article'] ?>">Voir l'article </a></button>

                                          <button class="form__button" name="subAnswerAdmin" type="submit"> Répondre </button>

                                          <button class="form__button" name="validateAnswerCom" type="submit" value="<?= $answerTime['check_admin'] ?>"> V </button>

                                          <button class="form__button" name="delete_answer_comment" type="submit"> X </button>

                                          <input name="fk_id_commentaire" value="<?= $answerTime['fk_id_commentaire'] ?>" type="hidden">

                                      </div>

                                  </form>
                              </div>

                      <?php }
                        } ?>

                      <h3>Commentaire des utilisateurs signalés : </h3>
                      <?php foreach ($comment as $value) {
                            if ($value['role'] == 'Utilisateurs' && $value['signaler'] == 1) { ?>
                              <div class="containerInfo">

                                  <label> Commentaire : de <?= $value['prenom'] ?> <?= $value['nom'] ?> article <?= $value['titre_article'] ?> : le : <?= $answer['date'] ?></label>

                                  <form action="" method="post">

                                      <input name="id_commentaire" value="<?= $value['id_commentaire'] ?>" type="hidden">
                                      <input name="comment" value="<?= $value['commentaire'] ?>" type="text">

                                      <div>

                                          <button class="form__button"> <a href="../produit/<?= $value['fk_id_article'] ?>">Voir l'article </a></button>

                                          <button class="form__button" name="signaler" type="submit" value="<?= $value['id_commentaire'] ?>"> Modifier signalement </button>

                                          <button class="form__button" name="delete_comment" type="submit"> X </button>
                                      </div>

                                  </form>

                              </div>

                      <?php }
                        } ?>

                      <?php

                        foreach ($answers as $answer) {
                            if ($answer['role'] == 'Utilisateurs' && $answer['signaler'] == 1) { ?>

                              <div class="containerInfo">

                                  <label> Commentaire : de <?= $answer['prenom'] ?> <?= $answer['nom'] ?> sur le commentaire <?= $answer['reponse_au_com'] ?> </label>

                                  <form action="" method="post">

                                      <input name="id_reponse_com" value="<?= $answer['id_reponse_com'] ?>" type="hidden">
                                      <input name="answer" value="<?= $answer['commentaire'] ?>" type="text">

                                      <div>

                                          <button class="form__button"> <a href="../produit/<?= $answer['fk_id_article'] ?>">Voir l'article </a></button>

                                          <button class="form__button" name="reportAnswer" type="submit" value="<?= $answer['id_reponse_com'] ?>"> Modifier signalement </button>

                                          <button class="form__button" name="delete_answer_comment" type="submit"> X </button>
                                      </div>


                                  </form>
                              </div>
                      <?php }
                        } ?>

                  </article>
              </div>

          </div>
      </div>