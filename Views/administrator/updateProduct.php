<?php if (empty($_POST['deleteProductAdmin'])) : ?>
    <div id="deleteProduct">
        <div>
            <h3>Attention</h3>
            <p>Êtes-vous sur de vouloir supprimer l'article ?</p>
            <form action="#" method="POST">
                <a href="">annuler</a>
                <button class="buttonDelete" type="submit" name="deleteProductAdmin" value="on">Supprimer l'article</button>
            </form>
        </div>
    </div>
<?php endif; ?>
<article class="mainAndSideAdmin">
    <section class="sideBarreAcount">
        <div>
            <h1>Admin</h1>
            <ul>
                <li><a href="../creerArticle/partie1">Creer un Article</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="">Modifier un articles</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="../gestiondestock">Gestion des stocks</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="../validercommande"> Gestion de commande</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="../categorie">Gestion des categories</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="../tag">Gestion des tags</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="../commentaire">Gestion des commentaires</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="../gestionUtilisateur/liste">Gestion des utilisateurs</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="../../profil/deconnexion">Se deconnecter</a></li>
            </ul>
        </div>
    </section>
    <section class="mainUpdateProduct">
        <h1>Modification d'articles</h1>

        <?php if (isset($_SESSION['flash'])) : ?>
            <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
                <div><?= $message; ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['flash'])) :  ?>
            <?php unset($_SESSION['flash']) ?>
        <?php endif; ?>
        <?php if (!empty($erreur)) : ?>
            <p><?= $erreur ?></p>
        <?php endif; ?>

        <?php if ($param == 'liste') : ?>
            <section class="formSearchUpdateProduct">
                <form action="" method="GET">
                    <fieldset>
                        <legend>Recherche avancée</legend>
                        <!-- <label for="site-search">Rechercher par nom</label> -->
                        <input type="search" name="recherche" aria-label="Search through site content">
                        <button><i class="fa-solid fa-magnifying-glass"></i></button>
                    </fieldset>
                </form>
                <form action="" method="POST">
                    <!-- <label for="PRINCIPALE ">Trier par Catégories Principales</label> -->
                    <select list="list_categories" name="PRINCIPALE" id="list_categories">
                        <datalist id="list_categories">
                            <option></option>
                            <?php foreach ($allCategories as $value) : ?>
                                <option value="<?= $value['nom_categorie'] ?>"><?= $value['nom_categorie'] ?>(<?= $methodImport->countSearch($value['nom_categorie']) ?>)</option>
                            <?php endforeach; ?>
                        </datalist>
                    </select>
                    <button type="submit" value='appliquer'><i class="fa-solid fa-sort"></i></button>
                </form>
            </section>

            <table>
                <thead>
                    <tr>
                        <th>Nom de l'Article</th>
                        <th>Catégorie Principale</th>
                        <th>Prix</th>
                        <th>selectionner</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultSearch as $value) : ?>
                        <tr>
                            <td><b><?= $value['titre_article'] ?></b></td>
                            <td><?= $value['cat parent'] ?></td>
                            <td><?= $value['prix_article'] ?> €</td>
                            <td><a href="./<?= $value['id_article'] ?>"><button>Modifier</button></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>


        <?php if ($param !== 'liste') : ?>

            <section class="containerUpdateProduct">
                <div class="firstButtonUpdateProduct">
                    <a href="./liste"><i class="fa-solid fa-arrow-left"></i>Revenir à la liste</a>
                    <a class="buttonDelete" href="#deleteProduct">supprimer</a>
                </div>
                <form action="#formProduct" method="post" name="info_article_pincipal" enctype="multipart/form-data">
                    <fieldset>
                        <legend>Modifier l'image</legend>
                        <div class="imgContener">
                            <img src="/kawa/public/assets/pictures/pictures_product/<?= $product['image_article'] ?>" alt="image du produit">
                            <label for="image_article">Télécharger une nouvelle image:</label>
                            <input class="custom-file-input" type="file" name="image_article">
                        </div>
                        <input class="ctaUpdateProduct" type="submit" name="modifimage" value="Modifier l'image">
                    </fieldset>
                    <fieldset class="infoProduct">
                        <legend id="formProduct">Informations sur l'article</legend>
                        <label for="titre_article"> Nom de l'articles:</label>
                        <input class="form__text" type="text" name="titre_article" id="titre_article" value="<?= $product['titre_article'] ?>">
                        <label for="prix_article"> Prix unitaire:</label>
                        <input class="form__text" number="text" step="0.01" name="prix_article" id="prix_article" value="<?= $product['prix_article'] ?>">
                        <label for="presentation_article">Présentation de l'article :</label>
                        <textarea id="presentation_article" name="presentation_article"><?= $product['presentation_article'] ?></textarea>
                        <label for="description_article">Description de l'article:</label>
                        <textarea id="description_article" name="description_article"><?= $product['description_article'] ?></textarea>
                        <label for="conditionnement">Preciser le conditionnement de l'article :</label>
                        <input class="form__text" type="text" name="conditionnement" id="conditionnement" placeholder="Sachet de 300g" value="<?= $product['conditionnement'] ?>">
                        <label for="sku">Nombre d'article en stock:</label>
                        <input class="form__text" type="number" name="sku" id="sku" value="<?= $product['sku'] ?>">
                        <label for="fournisseur">Nom du fournisseur:</label>
                        <input class="form__text" type="text" name="fournisseur" id="fournisseur" value="<?= $product['fournisseur'] ?>">
                        <input class="ctaUpdateProduct" type="submit" name="modifInformations" value="Modifier">
                    </fieldset>
                </form>
                <form id="categorie" action="#categorie" method="post">
                    <fieldset>
                        <legend>Ajouter ou Suprimer une categorie</legend>
                        <hr>
                        <p>Catégorie Principale actuelle de l'article : <b><?= $CatOfProduct['mainCat']['nom_categorie'] ?></b></p>
                        <label class="labelExplaine" for="id_parent">Changer la categorie principale de l'article par</label>
                        <?php foreach ($AllCat['principale'] as $value) : ?>
                            <button type="submit" name="id_parent" value="<?= $value['id_categorie'] ?>"><?= $value['nom_categorie'] ?></button>
                        <?php endforeach; ?>
                        <hr>
                        <p>Origine actuelle du café : <b><?= $CatOfProduct['origin'][0]['nom_categorie'] ?></b></p>
                        <?php foreach ($AllCat['origin'] as $value) : ?>
                            <button type="submit" name="PROVENENCE" value="<?= $value['id_categorie'] ?>">&#10010; <?= $value['nom_categorie'] ?></button>
                        <?php endforeach; ?>
                        <hr>
                        <p>La force de actuel du produit est estimé à : <b><?= $CatOfProduct['strong'][0]['nom_categorie'] ?></b></p>
                        <label class="labelExplaine" for="FORCE">Réévaluer sa force à :</label>
                        <?php foreach ($AllCat['strong'] as $value) : ?>
                            <button type="submit" name="FORCE" value="<?= $value['id_categorie'] ?>">&#10010; <?= $value['nom_categorie'] ?></button>
                        <?php endforeach; ?>
                        <hr>
                        <p>La variété actuelle du produit est : <b><?= $CatOfProduct['variete'][0]['nom_categorie'] ?></b></p>
                        <label class="labelExplaine" for="VARIÉTÉ">Modifier sa variété :</label>
                        <?php foreach ($AllCat['variete'] as $value) : ?>
                            <button type="submit" name="VARIÉTÉ" value="<?= $value['id_categorie'] ?>">&#10010; <?= $value['nom_categorie'] ?></button>
                        <?php endforeach; ?>
                        <hr>
                        <label class="labelExplaine" for="delet-fk_id_categorie">Quelle spécifité souhaitez-vous supprimer de l'artcle ?</label>
                        <?php foreach ($CatOfProduct['specificite'] as $value) : ?>
                            <button class="buttonDelete" type="submit" name="delet-fk_id_categorie" value="<?= $value['id_categorie'] ?>">&#10006; <?= $value['nom_categorie'] ?></button>
                        <?php endforeach; ?>
                        <label class="labelExplaine" for="add-fk_id_categorie">Quelle spécifité souhaitez-vous ajouter de l'artcle ?</label>
                        <?php foreach ($AllCat['specificite'] as $value) : ?>
                            <button type="submit" name="add-fk_id_categorie" value="<?= $value['id_categorie'] ?>">&#10010; <?= $value['nom_categorie'] ?></button>
                        <?php endforeach; ?>
                        <hr>
                        <label class="labelExplaine" for="delet-fk_id_categorie">Quelle saveur souhaitez-vous supprimer de l'artcle ?</label>
                        <?php foreach ($CatOfProduct['flavor'] as $value) : ?>
                            <button class="buttonDelete" type="submit" name="delet-fk_id_categorie" value="<?= $value['id_categorie'] ?>">&#10006; <?= $value['nom_categorie'] ?></button>
                        <?php endforeach; ?>
                        <label class="labelExplaine" for="add-fk_id_categorie">Quelle saveur souhaitez-vous ajouter de l'artcle ?</label>
                        <?php foreach ($AllCat['flavor'] as $value) : ?>
                            <button type="submit" name="add-fk_id_categorie" value="<?= $value['id_categorie'] ?>">&#10010; <?= $value['nom_categorie'] ?></button>
                        <?php endforeach; ?>

                    </fieldset>

                    <fieldset>
                        <p>Filtres selectionnés : </p>
                        <?php if ($tagOfProduct) : ?>
                            <?php foreach ($tagOfProduct as $key => $value) : ?>
                                <button class="buttonDelete" type="submit" name="delettag" value="<?= $value['fk_id_tag'] ?>">&#10006; <?= $value['nom_tag'] ?></button>
                        <?php endforeach;
                        endif; ?>

                        <legend>Tags</legend>
                        <p>Ajouter des tags :</p>

                        <label for="liste_tag">Liste des tags :</label>
                        <input list="all_tag" name="tag" id="liste_tag">
                        <datalist id="all_tag">
                            <?php
                            foreach ($allTags as $value) {
                            ?>
                                <option value="<?= $value['nom_tag'] ?>"><?= $value['nom_tag'] ?></option>
                            <?php
                            }
                            ?>
                        </datalist>
                        <input type="submit" name="addTag" value="ajouter">
                    </fieldset>
                </form>
            <?php endif; ?>
            </section>
    </section>
</article>