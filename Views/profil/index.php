<section class="mainAndSideAdmin">
    <article class="sideBarreAdmin">
        <section>
            <div>
                <h1>Profil</h1>
                <ul>
                    <li><a href="/../kawa/profil/modifierProfil">Modifier mon profil</a><i class="fa-solid fa-angle-right"></i></li>
                    <li><a href="/../kawa/profil/modifierMotdePasse">Modifier mon mot de passe</a><i class="fa-solid fa-angle-right"></i></li>
                    <li><a href="/../kawa/profil/adresse">Adresse de livraison</a><i class="fa-solid fa-angle-right"></i></li>
                    <li><a href="/../kawa/profil/historiqueCommande">Historique de commande</a><i class="fa-solid fa-angle-right"></i></li>
                    <li><a href="./profil/deconnexion">Se deconnecter</a></li>
                </ul>
                <?php if ($notifAdresse !== null) : ?>
                    <section class="notifAcount">
                        <p><?= $notifAdresse ?></p>
                        <a href="profil/adresse">Enregistrer une adresse ></a>
                    </section>
                <?php endif; ?>
            </div>
        </section>
    </article>
    <article class="acountIndexMain">
        <img class="imgIndexAcount" src="../kawa/public/assets/pictures/kawa_image_indexAcount.png" alt="image d'attente">
    </article>
</section>