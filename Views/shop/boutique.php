<?= $style ?>

<nav class="navCatégories">
    <ul>
        <li><a id="all" href="./all">Tous</a></li>
        <li><a id="Dosette" href="./Dosette">Dosette</a></li>
        <li><a id="Moulu" href="./Moulu">Moulu</a></li>
        <li><a id="Grain" href="./Grain">Grain</a></li>
    </ul>
</nav>
<?php if (isset($_SESSION['flash'])) : ?>
    <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
        <div><?= $message; ?></div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (isset($_SESSION['flash'])) :  ?>
    <?php unset($_SESSION['flash']) ?>
<?php endif; ?>
<div class="boutiqueWrapper">

    <section class="moreRecherche">
        <a href="#formRecherche">Recherche avancer <i class="fa-solid fa-angle-down"></i></a>
        <form id="formRecherche" action="#" method="post">
            <h4>Recherche avancer</h4>
            <fieldset>
                <legend>Variétés</legend>
                <?php
                foreach ($result_request['variete'] as $value) {
                ?>
                    <input type="radio" name="VARIÉTÉ" id="<?= $value['nom_categorie'] ?>" value="<?= $value['nom_categorie'] ?>">
                    <label for="<?= $value['nom_categorie'] ?>"><?= $value['nom_categorie'] ?></label>
                <?php
                }
                ?>
            </fieldset>
            <fieldset>
                <legend>Spécificités :</legend>
                <?php
                foreach ($result_request['specificite'] as $value) {
                ?>
                    <input type="checkbox" name="SPÉCIFICITÉ[]" id="<?= $value['nom_categorie'] ?>" value="<?= $value['nom_categorie'] ?>">
                    <label for="<?= $value['nom_categorie'] ?>"><?= $value['nom_categorie'] ?></label>
                <?php
                }
                ?>
            </fieldset>
            <fieldset>
                <legend>Provenence :</legend>

                <?php
                foreach ($result_request['origin'] as $value) {
                ?>
                    <input type="radio" name="PROVENENCE" id="<?= $value['nom_categorie'] ?>" value="<?= $value['nom_categorie'] ?>">
                    <label for="<?= $value['nom_categorie'] ?>"><?= $value['nom_categorie'] ?></label>
                <?php
                }
                ?>
            </fieldset>
            <fieldset>
                <legend>Saveur :</legend>
                <?php
                foreach ($result_request['flavor'] as $value) {
                ?>
                    <input type="checkbox" name="SAVEUR[]" id="<?= $value['nom_categorie'] ?>" value="<?= $value['nom_categorie'] ?>">
                    <label for="<?= $value['nom_categorie'] ?>"><?= $value['nom_categorie'] ?></label>
                <?php
                }
                ?>
            </fieldset>
            <fieldset>
                <legend>Force :</legend>
                <?php
                foreach ($result_request['strong'] as $value) {
                ?>
                    <input type="radio" name="FORCE" id="<?= $value['nom_categorie'] ?>" value="<?= $value['nom_categorie'] ?>">
                    <label for="<?= $value['nom_categorie'] ?>"><?= $value['nom_categorie'] ?></label>
                <?php
                }
                ?>
            </fieldset>

            <input type="submit" name="filtre" value="Filtrer">
            <input class="form__button form__button--delete" type="submit" name="resetFilter" value="Reset">
        </form>
    </section>
    <div class="boutiqueMain">

        <h1>Boutique</h1>
        <?php if (isset($resultFilter)) : ?>
            <section>
                <form class="filterSelect" action="" method="post">
                    <p>Filtres selectionnés : </p>
                    <?php foreach ($resultFilter as $key => $value) : ?>
                        <?php if (is_array($value)) : ?>
                            <?php foreach ($value as $underkey => $underValue) : ?>
                                <button type="submit" name="deletFilter" value="<?= $key ?>-<?= $underkey ?>-<?= $underValue ?>">&#10006; <?= $underValue ?></button>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <button type="submit" name="deletFilter" value="<?= $key ?>-<?= $value ?>">&#10006; <?= $value ?></button>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </form>
            </section>
        <?php endif; ?>

        <?php if (!empty($erreur)) : ?>
            <h4><?= $erreur ?></h4>
        <?php endif; ?>

        <section class="boutique">
            <?php for ($firstProduct; $firstProduct < $lastProduct; ++$firstProduct) {
                if (isset($result[$firstProduct])) {
                    $card->printCard($result[$firstProduct]);
                }
            }
            ?>
        </section>

        <form class="boutiquePagination" action="" method="get">
            <?php if (isset($_GET['recherche'])) : ?>
                <input type="hidden" name="recherche" value="<?= $urlGet ?>">
            <?php endif; ?>
            <?php if ($firstProduct > 8) : ?>
                <button type="submit" name="page" value="<?= (($firstProduct - 8) - 8) ?>"><i class="fa-solid fa-angle-left"></i> </button>
            <?php endif;
            foreach ($allPages as $key => $value) : ?>
                <?= $value ?>
            <?php endforeach;
            if (isset($result[$firstProduct])) : ?>
                <button type="submit" name="page" value="<?= ($firstProduct) ?>"><i class="fa-solid fa-angle-right"></i></button>
            <?php endif; ?>
        </form>
    </div>
</div>