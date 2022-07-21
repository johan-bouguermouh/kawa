<section class="mainAndSideAdmin">
    <article class="sideBarreAdmin">
        <section>
            <h1>Admin</h1>
            <ul>
                <li><a href="admin/creerArticle/partie1">Creer un Article</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="admin/modifierArticle/liste">Modifier un articles</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="admin/gestiondestock">Gestion des stocks</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="admin/validercommande"> Gestion de commande</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="admin/categorie">Gestion des categories</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="admin/tag">Gestion des tags</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="admin/commentaire">Gestion des commentaires</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="admin/gestionUtilisateur/liste">Gestion des utilisateurs</a><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="profil/deconnexion">Se deconnecter</a></li>
            </ul>
        </section>
        <?php if ($sendStock !== null) : ?>
            <section class="notifAcount">
                <p><?= $sendStock ?></p>
                <a href="admin/gestiondestock">Restocker mes articles ></a>
            </section>
        <?php endif; ?>
    </article>
    <article class="acountIndexMain">
        <img class="imgIndexAcount" src="../kawa/public/assets/pictures/kawa_image_indexAcount.png" alt="image d'attente">
    </article>
</section>