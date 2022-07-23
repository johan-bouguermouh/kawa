<article class="mainAndSideAdmin">
    <section class="sideBarreAcount">
        <div>
            <h1>Admin</h1>
            <ul>
                <li><a href="./creerArticle/partie1">Creer un Article</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="../modifierArticle/liste">Modifier un articles</a><i class="fa-solid fa-angle-right"></i></li>
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
    <article class="mainAdmin">
        <h1>Creer un Article</h1>
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
        <?php if ($param == 'partie1') : ?>

            <form class="formPartOne" action="./partie1" method="post" name="info_article_pincipal" enctype="multipart/form-data">

                <fieldset>
                    <legend>Ajouter une image</legend>
                    <div class="imgContener">
                        <?php $Admin_function->upload_image('image_article', 'public/assets/pictures/pictures_product/'); ?>

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

                        <label for="image_article">Télécharger une image:</label>
                        <input class="custom-file-input" type="file" name="image_article">
                    </div>
                    <input type="submit" name="upload_image" value="télécharger">
                </fieldset>

                <fieldset>
                    <legend>Informations sur l'article</legend>
                    <label for="titre_article"> Nom de l'articles:</label>
                    <input class="form__text" type="text" name="titre_article" id="titre_article" value="MUDA - ÇA PASSE CRÈME<?= $Admin_function->coverup_form('titre_article') ?>">
                    <label for="prix_article"> Prix unitaire:</label>
                    <input class="form__text" number="text" step="0.01" name="prix_article" id="prix_article" value="7.90<?= $Admin_function->coverup_form('prix_article') ?>">
                    <label for="presentation_article">Présentation de l'article :</label>
                    <textarea id="presentation_article" name="presentation_article" >Un café noir ou avec du lait ? Ça passe crème !<?= $Admin_function->coverup_form('presentation_article') ?></textarea>
                    <label for="description_article">Description de l'article:</label>
                    <textarea id="description_article" name="description_article" >"Vous aimez les cafés ronds aux notes chocolatées ? Ce café est fait pour vous ! Un café facile à boire et à préparer qui plaira au plus grand nombre. Il passera très bien au petit déjeuner avec votre croissant ou tartine.
L’origine de ce café changera au fil des saisons de récoltes, mais le profil aromatique restera le même."<?= $Admin_function->coverup_form('description_article') ?></textarea>
                </fieldset>

                <fieldset>
                    <legend>Information connexe</legend>
                    <label for="conditionnement">Preciser le conditionnement de l'article :</label>
                    <input class="form__text" type="text" name="conditionnement" id="conditionnement" placeholder="Sachet de 300g" value="Sachet de 250g<?= $Admin_function->coverup_form('conditionnement') ?>">
                    <label for="sku">Nombre d'article en stock:</label>
                    <input class="form__text" type="number" name="sku" id="sku" value="100<?= $Admin_function->coverup_form('sku') ?>">
                    <label for="fournisseur">Nom du producteur:</label>
                    <input class="form__text" type="text" name="fournisseur" id="fournisseur" value="FAMILLE DUTRA<?= $Admin_function->coverup_form('fournisseur') ?>">
                </fieldset>
                <input class="ctaCreatProduct" type="submit" name="etape1" value="Passer à l'étape suivante">
            </form>
        <?php endif; ?>

        <?php if ($param == 'partie2') : ?>
            <form action="./partie2" method="post">
                <fieldset>
                    <p>Tags selectionnés : </p>
                    <?php if (!empty($_SESSION['nouvelarticle']['tag'])) : ?>
                        <?php foreach ($_SESSION['nouvelarticle']['tag'] as $key => $value) : ?>
                            <button class="tagSelected" type="submit" name="delettag" value="<?= $key ?>">&#10006; <?= $value ?></button>
                    <?php endforeach;
                    endif; ?>

                    <legend>Tags</legend>
                    <p>Ajouter des tags :</p>

                    <label class="labelExplaine" for="liste_tag">Liste des tags <i class="fa-solid fa-caret-down"></i></label>
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
                    <input class="inputtag" type="submit" name="addTag" value="ajouter">
                </fieldset>

                <fieldset>
                    <legend>Catégories d'article</legend>
                    <label class="labelExplaine" for="PRINCIPALE">Choisir une categorie :</label>
                    <?php
                    foreach ($result_request['principale'] as $value) {
                    ?>
                        <input class="checkboxinput" type="radio" name="PRINCIPALE" id="<?= $value['id_categorie'] ?>" value="<?= $value['id_categorie'] ?>">
                        <label class="checkboxlabel" for="<?= $value['id_categorie'] ?>"><?= $value['nom_categorie'] ?></label>
                    <?php
                    }
                    ?>
                </fieldset>
                <fieldset>
                    <legend>Variétés & Spécificités</legend>
                    <p>Choisir la variété du café et renseigner ses spécificités</p>
                    <label class="labelExplaine" for="VARIÉTÉ">Choisir une variété :</label>
                    <?php
                    foreach ($result_request['variete'] as $value) {
                    ?>
                        <input class="checkboxinput" type="radio" name="VARIÉTÉ" id="<?= $value['id_categorie'] ?>" value="<?= $value['id_categorie'] ?>">
                        <label class="checkboxlabel" for="<?= $value['id_categorie'] ?>"><?= $value['nom_categorie'] ?></label>
                    <?php
                    }
                    ?>
                    <label class="labelExplaine" for="SPÉCIFICITÉ">Choisir les spécificités :</label>
                    <?php
                    foreach ($result_request['specificite'] as $value) {
                    ?>
                        <input class="checkboxinput" type="checkbox" name="SPÉCIFICITÉ[]" id="<?= $value['id_categorie'] ?>" value="<?= $value['id_categorie'] ?>">
                        <label class="checkboxlabel" for="<?= $value['id_categorie'] ?>"><?= $value['nom_categorie'] ?></label>
                    <?php
                    }
                    ?>
                </fieldset>
                <fieldset>
                    <legend>Provenence</legend>
                    <p>Définir la région originaire du café</p>

                    <label class="labelExplaine" for="liste_provenence">Liste des provenences <i class="fa-solid fa-caret-down"></i></label>
                    <input list="all_provenence" name="PROVENENCE" id="liste_provenence">
                    <datalist id="all_provenence">

                        <?php
                        foreach ($result_request['origin'] as $value) {
                        ?>
                            <option value="<?= $value['id_categorie'] ?>"><?= $value['nom_categorie'] ?></option>
                        <?php
                        }
                        ?>
                    </datalist>
                    <div id="addProvenence">
                        <label class="labelExplaine" for="nouvelle_PROVENENCE">Ajouter une nouvelle provenence</label>
                        <div>
                            <input type="text" name="nom_PROVENENCE" id="nouvelle_PROVENENCE">
                            <button class="inputAdd" type="submit" name="ajouter_PROVENENCE" value="Ajouter la provenece"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    </div>

                </fieldset>
                <fieldset>
                    <legend>Saveur associé</legend>
                    <p>Définissez les différentes saveurs de votre article :</p>

                    <!-- <label  for="nouvelle_saveur">Ajouter une nouvelle saveur</label>
                    
                        <input type="text" name="nom_SAVEUR" id="nouvelle_saveur">
                        <button type="submit" name="ajouter_SAVEUR" value="Ajouter la saveur"><i class="fa-solid fa-plus"></i></button> -->

                    <?php
                    foreach ($result_request['flavor'] as $value) {
                    ?>
                        <input class="checkboxinput" type="checkbox" name="SAVEUR[]" id="<?= $value['id_categorie'] ?>" value="<?= $value['id_categorie'] ?>">
                        <label class="checkboxlabel" for="<?= $value['id_categorie'] ?>"><?= $value['nom_categorie'] ?></label>
                    <?php
                    }
                    ?>
                </fieldset>
                <fieldset>
                    <legend>Force</legend>
                    <p>Noter la force du café</p>
                    <div class="selectstronger">
                        <?php
                        foreach ($result_request['strong'] as $value) {
                        ?>
                            <input class="checkboxinput" type="radio" name="FORCE" id="<?= $value['id_categorie'] ?>" value="<?= $value['id_categorie'] ?>">
                            <label class="checkboxlabel" for="<?= $value['id_categorie'] ?>"><?= $value['nom_categorie'] ?></label>
                        <?php
                        }
                        ?>
                    </div>
                </fieldset>

                <input class="ctaCreatProduct" type="submit" name="etape2" value="Visualiser le résultat">
            </form>

        <?php endif; ?>


        <?php if ($param == 'rendu') : ?>
            <article class="renduArticle">
                <div>
                    <h3><?= $_SESSION['nouvelarticle']['etape1']['titre_article'] ?></h3>
                    <p><?= $_SESSION['nouvelarticle']['etape1']['prix_article'] ?>€</p>
                </div>
                <div>
                    <img src="/kawa/public/assets/pictures/pictures_product/<?= $_SESSION['nouvelarticle']['image_article'] ?>" alt="image de l'article">
                    <div>
                        <h4><?= $_SESSION['nouvelarticle']['etape1']['presentation_article'] ?></h4>
                        <p><?= $_SESSION['nouvelarticle']['etape1']['description_article'] ?></p>
                        <?= $this->Categories->printAllCategories($_SESSION['nouvelarticle']['etape2']) ?>
                        <p><?= $printTag ?></p>
                    </div>
                </div>
            </article>
            <div>
                <a href="./partie1">Modifier les informations principales</a>
                <a href="./partie2">Modifier les attribues de catégories</a>
                <a href="./upload">Mettre l'article en ligne</a>
            </div>
        <?php endif; ?>
        <?php if ($param == 'upload') : ?>
            <h3 class="articleFinale"><?= $message ?></h3>
            <a href="../../admin">Revenir à l'espace Admin</a>
        <?php endif; ?>
    </article>
</article>