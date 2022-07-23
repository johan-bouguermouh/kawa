<?php

namespace App\Controllers;

use App\Models\Search;
use Database\DBConnection;
use App\Controllers\Components\CardCompenent;
use App\Controllers\Components\ProductComponent;
use App\Controllers\Components\CategoriesComponent;

class BoutiqueSearchController extends Controller
{
    public $error = array();
    protected $Product;
    protected $Categories;
    protected $search;
    protected $FooBag;

    public function __construct()
    {
        $this->Product = new ProductComponent();
        $this->Categories = new CategoriesComponent();
        $this->search = new Search();
        $this->FooBag = new ProductController();

        $this->error;
    }

    /**
     * Methode d'affichage de la boutique
     * @param string Paramettre obligatoire :
     * -> Si All le paramettre de recherche prend tout les
     * -> Si dosette|moulu|grain alors affiche les resultat assigné à la catégorie principale
     */
    public function index(string $param)
    {
        $this->FooBag->shoppingBag();

        if (isset($_POST['resetFilter'])) {
            unset($_SESSION['filter']);
        }
        /**
         * On redirige l'utilisateur si la valeur entrer dans l'url ne coresspond à aucun
         * élément attendue dans $param.
         */
        if (
            $param == 'all'
            || $param == 'Dosette'
            || $param == 'Moulu'
            || $param == 'Grain'
        ) {
            $title = 'Boutique | ' . $param;
            $style = '<style type="text/css">
            #' . $param . ' {
                font-weight: bold !important;
            }</style>';
        } else header('location: ./all');

        if (isset($_GET['filterDelete'])) {
            unset($_SESSION['filter']);
        }
        $result = $this->mergeCattoProduct(); //On merge les tables produit avec la tables catégorie

        $this->getSelection();
        if ($param !== 'all') //Si une ategorie autre que all a était selectionner on trie le tableau selon la categorie principale
        {
            $result = $this->Product->selectArrayByValue($result, 'cat parent', $param);
        }

        if (!empty($_POST['deletFilter'])) //Si le Post delet est utiliser on unset la valeur ciblé de notre varaible de section
        {
            $deleteValue = explode('-', $_POST['deletFilter']);
            if (count($deleteValue) == 3) {
                unset($_SESSION['filter'][$deleteValue[0]][$deleteValue[1]]);
            } else unset($_SESSION['filter'][$deleteValue[0]]);
        }
        if (!empty($_POST['filtre'])) //Si un nouveau formulaire de recherche avancé est soumis alors on ecrase ou on créer une vriable de section
        {
            $_SESSION['filter'] = $_POST;
            unset($_SESSION['filter']['filtre']);
            $resultFilter = $_SESSION['filter'];
            $result = $this->gestionFilter($result);
        } elseif (!empty($_SESSION['filter'])) //Si la vraible de section existe déjà alors on fait une nouvelle recherche selon les changement
        {
            $resultFilter = $_SESSION['filter'];
            $result = $this->gestionFilter($result);
        } else $resultFilter = null; //Si rien est effectuer on assigne nul à la variable de section pour eviter les erreurs

        $card = new CardCompenent(); //On instancie nos card pour l'envoyer dans le render

        /**
         * On récupère toute les catégories pour soumettre le formulaire à l'utilisateur
         */
        $result_request = array(
            'principale' => $this->Categories->chooseCategoriesBySection(['section'], 'PRINCIPALE'),
            'variete' => $this->Categories->chooseCategoriesBySection(['section'], 'VARIÉTÉ'),
            'specificite' => $this->Categories->chooseCategoriesBySection(['section'], 'SPÉCIFICITÉ'),
            'flavor' => $this->Categories->chooseCategoriesBySection(['section'], 'SAVEUR'),
            'strong' => $this->Categories->chooseCategoriesBySection(['section'], 'FORCE'),
            'origin' => $this->Categories->chooseCategoriesBySection(['section'], 'PROVENENCE')
        );

        $erreur = $this->error;
        /**
         * On prépare les condition de pagination
         */
        $allPages = [];
        for ($i = 0; $i < ceil((count($result) / 8)); $i++) {

            if (isset($_GET['page']) && $_GET['page'] == ($i * 8)) {
                $allPages[$i] = '<button class="pholioSelected" type="submit" name="page" value="' . ($i * 8) . '">' . ($i + 1) . '</button>';
            } elseif (empty($_GET['page']) && $i == 0) {
                $allPages[$i] = '<button class="pholioSelected" type="submit" name="page" value="' . ($i * 8) . '">' . ($i + 1) . '</button>';
            } else {
                $allPages[$i] = '<button class="pholio" type="submit" name="page" value="' . ($i * 8) . '">' . ($i + 1) . '</button>';
            }
        }

        if (isset($_GET['recherche'])) {
            $urlGet = $_GET['recherche'];
        } else {
            $urlGet = '';
        }
        if (empty($_GET['page'])) {
            $_GET['page'] = 0;
        }
        $firstProduct = (int)$_GET['page'];
        $lastProduct = ((int)$_GET['page'] + 8);
        $compact = compact('title', 'result_request', 'resultFilter', 'erreur', 'result', 'card', 'firstProduct', 'lastProduct', 'urlGet', 'allPages', 'style');
        $this->view('shop.boutique', $compact);
    }

    /**
     * Compte le nombre d'article disponnibles selon se filtre
     * @param string Nom de la categorie à rechercher
     */
    public function countSearch($nameCategories)
    {
        if (!empty($_GET['recherche'])) {
            $result = $this->search->find_article($_GET['recherche']);
        } else $result = $this->Product->getAllProductForCard();
        $result = count($this->Product->selectArrayByValue($result, 'cat parent', $nameCategories));
        return $result;
    }

    public function mergeCattoProduct()
    {
        if (!empty($_GET['recherche'])) {
            $result = $this->search->find_article($_GET['recherche']);
        } else $result = $this->Product->getAllProductForCard();
        $i = 0;
        while (isset($result[$i])) {
            $categories = $this->Categories->getSectionCatByIdProduct($result[$i]['id_article']);
            $k = 0;
            $j = 0;
            foreach ($categories as $key => $value) {
                if ($value['section'] == 'PROVENENCE') {
                    $result[$i]['PROVENENCE'] = $value['nom_categorie'];
                } elseif ($value['section'] == 'SPÉCIFICITÉ') {
                    $result[$i]['SPÉCIFICITÉ'][$j] = $value['nom_categorie'];
                    $j++;
                } elseif ($value['section'] == 'FORCE') {
                    $result[$i]['FORCE'] = $value['nom_categorie'];
                } elseif ($value['section'] == 'VARIÉTÉ') {
                    $result[$i]['VARIÉTÉ'] = $value['nom_categorie'];
                } elseif ($value['section'] == 'SAVEUR') {

                    $result[$i]['SAVEUR'][$k] = $value['nom_categorie'];

                    $k++;
                }
            }

            $i++;
        }

        return ($result);
    }

    /**
     * Permet de générer un nous veautableau multidimentsionnel de resultat
     * en le triant par les les variable de session définit
     * @param array Le tableau de resultat original
     */
    public function gestionFilter(array $result)
    {
        if (isset($_SESSION['filter']['VARIÉTÉ']) && count($result) >= 1) {
            $result = $this->Product->selectArrayByValue($result, 'VARIÉTÉ', $_SESSION['filter']['VARIÉTÉ']);
        }
        if (isset($_SESSION['filter']['SPÉCIFICITÉ'])) {
            foreach ($_SESSION['filter']['SPÉCIFICITÉ'] as $value) {
                if (count($result) < 1) {
                    return $result;
                } else {
                    $return = $this->Product->selectArrayByValue($result, 'SPÉCIFICITÉ', $value);
                    if (!empty($return)  && count($result) >= 1) {
                        $result = $return;
                    } else {
                        $this->error = "Le filtre de la spécificité " . $value . " n'a pus aboutir à un resultat, nous vous proposons cependant les articles suivant :";
                        // return $result;
                    }
                }
            }
        }
        if (isset($_SESSION['filter']['PROVENENCE'])) {
            $return = $this->Product->selectArrayByValue($result, 'PROVENENCE', $_SESSION['filter']['PROVENENCE']);
            if (!empty($return) && count($result) >= 1) {
                $result = $return;
            } else {
                $this->error = "Le filtre de la provenence " . $_SESSION['filter']['PROVENENCE'] . " n'a pus aboutir à un resultat, nous vous proposons cependant les articles suivant :";
                // return $result;
            }
        }
        if (isset($_SESSION['filter']['SAVEUR']) ) {
            foreach ($_SESSION['filter']['SAVEUR'] as $value) {
                if (count($result) < 1) {
                    // return $result;
                } else {
                    $return = $this->Product->selectArrayByValue($result, 'SAVEUR', $value);
                    if (!empty($return) && count($result) >= 1) {
                        $result = $return;
                    } else {
                        $this->error = "Le filtre de la saveur " . $value . " n'a pus aboutir à un resultat, nous vous proposons cependant les articles suivant :";
                        // return $result;
                    }
                }
            }
        }
        if (isset($_SESSION['filter']['FORCE']) ) {
            $return = $this->Product->selectArrayByValue($result, 'FORCE', $_SESSION['filter']['FORCE']);
            if (!empty($return) && count($result) >= 1) {
                $result = $return;
            } else {
                $this->error = "Le filtre de la force " . $_SESSION['filter']['FORCE'] . " n'a pus aboutir à un resultat, nous vous proposons cependant les articles suivant :";
                // return $result;
            }
        }


        return $result;
    }

    public function getSelection()
    {
        if (isset($_GET['selection'])) {
            $selection = $_GET['selection'];
            if ($selection == '1') {
                $_SESSION['filter']['SPÉCIFICITÉ'] = [0 => 'Décaféiné '];
            } elseif ($selection == '2') {
                $_SESSION['filter']['FORCE'] = 5;
            } elseif ($selection == '3') {
                $_SESSION['filter']['FORCE'] = 5;
            }
        }
    }
}
