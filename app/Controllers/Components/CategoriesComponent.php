<?php

namespace App\controllers\Components;

use App\models\Categories;

class CategoriesComponent extends Categories
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Renvoie l'ensemble des données selon le nom de la section
     * @param array Ensemble des critères à chercher
     * @param string La valeurs de la section
     * @param array|null Les différentes colonne à récupérer
     */
    public function chooseCategoriesBySection(array $criteres, $data, ?array $filters = null): array
    {
        $section = $data;
        $item = $this->find($criteres, compact('section'));
        return $item;
    }



    /**
     * Récupère le nom d'une catégorie par son Id
     * @param array Ensemble des critère à chercher
     * @param string l'id en question
     * @param array|null Les différentes colonnes a récupéré
     */
    public function getNameById(array $criteres, $data, ?array $filters = null): string
    {
        $id_categorie = $data;
        $column = ['nom_categorie'];
        $item = $this->find($criteres, compact('id_categorie'), $column);
        return $item[0]['nom_categorie'];
    }

    /**
     * Prépare la requête à l'insertion des données de nouvelles catégorie
     * @param string nom de la valeur du POST (Par Default, les post permetant l'insertion se nom 'nom_'+'nom de la section')
     */
    public function wheneInsertCategories(string $name_submit)
    {
        if (!empty($_POST[$name_submit])) {
            $sections = explode('_', $name_submit)[1];
            if (!empty($_POST['nom_' . $sections])) {
                $value = $_POST['nom_' . $sections];
                $New_cat = new Categories;
                $New_cat->section = $sections;
                $New_cat->nom_categorie = $value;

                $section = $sections;
                $nom_categorie = $value;

                $item = $this->create($New_cat, compact('section', 'nom_categorie'));
            }
        }
    }

    /**
     * 
     */
    public function printAllCategories($array)
    {
        foreach ($array as $key => $value) {
            if ($key == 'FORCE') {
                $i = 1;
                $result = '';
                while ($i <= $this->getNameById(['id_categorie'], $value)) {
                    $result .= '&#x272D ';
                    $i++;
                }
?>
                <p><b><?php echo "{$key}" ?></b> : <?= $result ?></p>
            <?php
            } elseif (($key == 'SAVEUR') || ($key == 'SPÉCIFICITÉ')) {
                $list_argument = '';
                for ($i = 0; $i < count($value); ++$i) {
                    $list_argument .= " {$this->getNameById(['id_categorie'],$value[$i])},";
                }
                $list_argument[-1] = ' ';
            ?>
                <p><b><?php echo "{$key}" ?></b> : <?= $list_argument ?></p>
            <?php
            } elseif ($key == 'etape2' || $key == 'PROVENENCE') {
            } else {
            ?>
                <p><b><?php echo "{$key}"; ?></b> : <?= $this->getNameById(['id_categorie'], $value) ?></p>
<?php
            }
        }
    }
    /**
     * Parcoure et récupère tout les ID en Variable de section
     */
    public function insertAllCat(array $array, $constIdProduct, $constIdCatPrincipal)
    {
        foreach ($array as $key => $value) {
            if ($key != 'PRINCIPALE') {
                if (is_array($value)) {
                    $i = 0;
                    while (isset($value[$i])) {
                        $this->insertInterTableCategorieProduct(
                            $constIdProduct,
                            $value[$i],
                            $constIdCatPrincipal
                        );

                        $i++;
                    }
                } else {
                    $this->insertInterTableCategorieProduct(
                        $constIdProduct,
                        $value,
                        $constIdCatPrincipal
                    );
                }
            }
        }
    }
}
?>