<section>
    <h3>Admin</h3>
    <ul>
        <li><a href="admin/creerArticle/partie1">Creer un Article ></a></li>
        <li><a href="admin/modifierArticle/liste">Modifier un articles ></a></li>
        <li><a href="admin/gestiondestock">Gestion des stocks ></a></li>
        <li><a href="">Historique de commande ></a></li>
        <li><a href="">Gestion de livraison ></a></li>
    </ul>
</section>
    <?php if($sendStock !== null):?>
<section>
        <p><?=$sendStock?></p>
        <a href="admin/gestiondestock">Restocker mes articles ></a>
</section>
    <?php endif;?>