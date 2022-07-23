<article class="mainAndSideAdmin">
    <section class="sideBarreAcount">
        <div>
            <h1>Admin</h1>
            <ul>
                <li><a href="./creerArticle/partie1">Creer un Article</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="./modifierArticle/liste">Modifier un articles</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="./gestiondestock">Gestion des stocks</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="./validercommande"> Gestion de commande</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="./categorie">Gestion des categories</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="./tag">Gestion des tags</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="./commentaire">Gestion des commentaires</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="./gestionUtilisateur/liste">Gestion des utilisateurs</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="../profil/deconnexion">Se deconnecter</a></li>
            </ul>
        </div>
    </section>
    
    <article class="mainUpdateProduct">
    <h1>Gestion de Stock</h1>
    <article class="tableEmergencyRestock">
        <h2>Produit au stock limités</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom de l'Article</th>
                    <th>Catégorie Principale</th>
                    <th>SKU</th>
                    <th>selectionner</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($urgentStock as $value) : ?>
                    <tr id="<?= $value['id_article'] ?>">
                        <td><?= $value['titre_article'] ?></td>
                        <td><?= $value['cat parent'] ?></td>
                        <td><?= $value['sku'] ?></td>
                        <td>
                            <form action="/kawa/produit/<?= $value['id_article'] ?>" method="POST">
                                <?php if (empty($_POST['enterFormNow' . $value['id_article']])) : ?>
                                    <button type="submit" name="enterFormNow<?= $value['id_article'] ?>">Consulter</button>
                                <?php else : ?>
                                    <input type="text" name="sku" value="<?= $value['sku'] ?>">
                                    <button type="submit" name="id_article" value="<?= $value['id_article'] ?>">Ajouter au Stock</button>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </article>
    <section class="formSearchUpdateProduct">
        <form action="" method="GET">
            <fieldset>
                <legend>Recherche avancée</legend>
                <label for="site-search">Rechercher par nom</label>
                <input type="search" name="recherche" aria-label="Search through site content">
                <button>Search</button>
            </fieldset>
        </form>
        <form action="<?= $urlRedirect ?>" method="POST">
            <label for="PRINCIPALE ">Trier par Catégories Principales</label>
            <select list="list_categories" name="PRINCIPALE" id="list_categories">
                <datalist id="list_categories">
                    <option></option>
                    <?php foreach ($allCategories as $value) : ?>
                        <option value="<?= $value['nom_categorie'] ?>"><?= $value['nom_categorie'] ?>(<?= $methodImport->countSearch($value['nom_categorie']) ?>)</option>
                    <?php endforeach; ?>
                </datalist>
            </select>
            <input type="submit" value='appliquer'>
        </form>
    </section>

    <table>
        <h2>Tout les articles</h2>
        <thead>
            <tr>
                <th>Nom de l'Article</th>
                <th>Catégorie Principale</th>
                <th>SKU</th>
                <th>selectionner</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultSearch as $value) : ?>
                <tr id="<?= $value['id_article'] ?>">
                    <td><?= $value['titre_article'] ?></td>
                    <td><?= $value['cat parent'] ?></td>
                    <td><?= $value['sku'] ?></td>
                    <td>
                        <form action="#<?= $value['id_article'] ?>" method="POST">
                            <?php if (empty($_POST['enterForm' . $value['id_article']])) : ?>
                                <button type="submit" name="enterForm<?= $value['id_article'] ?>" value="<?= $value['id_article'] ?>">Restocker</button>
                            <?php else : ?>
                                <input type="number" name="sku" step="1">
                                <button type="submit" name="id_article" value="<?= $value['id_article'] ?>">Ajouter au Stock</button>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </article>
</article>