   <div class="containerMain">

       <?php echo $menuAdmin; ?>


       <div class="layoutContainertable updateUser">

           <div>
               <article>

                   <h3>Gestion des Utilisateurs</h3>
                   <section>
                       <h3>Admin</h3>

                   </section>
                   <?php if (isset($_SESSION['flash'])) : ?>
                       <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
                           <div><?= $message; ?></div>
                       <?php endforeach; ?>
                   <?php endif; ?>

                   <?php if (isset($_SESSION['flash'])) :  ?>
                       <?php unset($_SESSION['flash']) ?>
                   <?php endif; ?>


                   <?php if ($param == "liste") : ?>
                       <article>
                           <h1>Gestion des utilisateurs</h1>
                           <table>
                               <thead>
                                   <tr>
                                       <th>Email</th>
                                       <th>Prenom</th>
                                       <th>Nom</th>
                                       <th>Role</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   <?php foreach ($users as $user) : ?>
                                       <tr>
                                           <td><?= $user['email'] ?></td>
                                           <td><?= $user['prenom'] ?></td>
                                           <td><?= $user['nom'] ?></td>
                                           <td><?= $user['role'] ?></td>
                                           <td class="form__button"> <a href="./<?= $user['id_utilisateur'] ?>">Modifier</a></td>
                                       </tr>
                                   <?php endforeach; ?>
                               </tbody>
                           </table>
                       </article>
                   <?php endif; ?>


                   <?php if ($param !== "liste") : ?>

                       <h1>Données de l'user</h1>
                       <form action="" method="post">
                           <?php foreach ($userInfos[0] as $key => $userInfo) : ?>
                               <?php if ($key == 'role') : ?>
                                   <label for="role">Choisissez votre role</label>
                                   <select name="<?= $key ?>" id="role">
                                       <option>Utilisateurs</option>
                                       <option>Admin</option>
                                   </select>
                               <?php elseif ($key == 'id_utilisateur') : ?>
                                   <input type="hidden">
                               <?php elseif ($key == 'password') : ?>
                                   <input type="text" name="<?= $key ?>">
                               <?php else : ?>
                                   <input type="text" value="<?= $userInfo ?>" name="<?= $key ?>">
                               <?php endif; ?>
                           <?php endforeach; ?>

                           <input class="form__button" type="submit" name="modifier" value="Modifier">
                           <input class="form__button" type="submit" name="supprimer" value="Supprimer">
                       </form>
                   <?php endif; ?>
               </article>
           </div>

       </div>
   </div>