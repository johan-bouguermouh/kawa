<?php

namespace App\controllers\admin;

use App\controllers\Controller;

/* use Database\DBConnection; */
use App\controllers\components\ProductComponent;
use App\controllers\components\CategoriesComponent;

class AdminUpdateProductController extends Controller
{
    public $error = array();
    protected $Product;
    protected $Categories;

    public function __construct()
    {
        $this->Product = new ProductComponent();
        $this->Categories = new CategoriesComponent();
    }

    public function index(string $id_article)
    {

        $title = 'Admin | Modifier Article';
        $param = $id_article;

        if ($id_article == 'liste') {
            $titre_article = @$_GET['recherche'];
            $urlRedirect = $this->modifLinkget('&PRINCIPALE');

            if (isset($_POST['PRINCIPALE']) && $_POST['PRINCIPALE'] !== $_GET['PRINCIPALE']) {
                if (isset($_GET['recherche'])) {
                    $getArgument = '&';
                } else {
                    $getArgument = '?';
                }

                header('location: ' . $urlRedirect . $getArgument . 'PRINCIPALE=' . $_POST['PRINCIPALE']);
            }
            if (!empty($_GET['recherche'])) {
                $result = $this->Product->find_article($_GET['recherche']);
            } else $result = $this->Product->getAllProductForUpdate();
            $resultSearch = $this->Product->selectArrayByValue($result, 'cat parent', @$_GET['PRINCIPALE']);
            $allCategories = $this->Categories->chooseCategoriesBySection(['section'], 'PRINCIPALE');
            $methodImport = new AdminUpdateProductController;
            $compact = compact('title', 'param', 'allCategories', 'urlRedirect', 'methodImport', 'resultSearch');
        }

        if ($id_article !== 'liste') {

            $product = $this->Product->find(['id_article'], [':id_article' => $id_article])[0];

            if (!empty($_POST['deleteProductAdmin']) && $_POST['deleteProductAdmin'] == 'on') {
                $this->Product->delete([':id_article' => $id_article]);
                $product = null;
            }

            if ($product == null) {
                header('location: ./liste');
                exit;
            }

            $namPicture = explode('.', $product['image_article'])[0];
            $this->modifyPicture('image_article', $namPicture, 'public/assets/pictures/pictures_product/');

            if (!empty($_POST['modifInformations'])) {
                $error = false;
                foreach ($_POST as $value) {
                    if ($value == null) {
                        $error = true;
                    }
                }
                if ($error == true) {
                    $_SESSION['flash']['form'] = "Tout les champs du formulaires doivent être remplis";
                } else $this->Product->updateProduct($_POST, $id_article, $product['image_article']);
            }
            if (!empty($_POST['id_parent'])) {
                $this->Categories->updateMainCatOfProduct($id_article, $_POST['id_parent']);
            }

            $this->gestionTag($param);
            $tagOfProduct = $this->Product->getTagByProduct($param);
            $allTags = $this->Product->getAlltag();

            $product = $this->Product->find(['id_article'], [':id_article' => $id_article])[0];

            $id_cat_parent = $this->Categories->selectMainCatOfProduct($id_article)['id_categorie'];
            $this->updateStrongofproduct($id_article, $_POST);
            $this->controlOfUpdateCategories($_POST, $id_article, $id_cat_parent);

            $CatOfProduct = array(
                'mainCat' => $this->Categories->selectMainCatOfProduct($id_article),
                'variete' => $this->Categories->getSectionCatByIdProduct($id_article, 'VARIÉTÉ'),
                'specificite' => $this->Categories->getSectionCatByIdProduct($id_article, 'SPÉCIFICITÉ'),
                'flavor' => $this->Categories->getSectionCatByIdProduct($id_article, 'SAVEUR'),
                'strong' => $this->Categories->getSectionCatByIdProduct($id_article, 'FORCE'),
                'origin' => $this->Categories->getSectionCatByIdProduct($id_article, 'PROVENENCE')
            );
            $AllCat = array(
                'principale' => $this->Categories->chooseCategoriesBySection(['section'], 'PRINCIPALE'),
                'variete' => $this->Categories->chooseCategoriesBySection(['section'], 'VARIÉTÉ'),
                'specificite' => $this->Categories->chooseCategoriesBySection(['section'], 'SPÉCIFICITÉ'),
                'flavor' => $this->Categories->chooseCategoriesBySection(['section'], 'SAVEUR'),
                'strong' => $this->Categories->chooseCategoriesBySection(['section'], 'FORCE'),
                'origin' => $this->Categories->chooseCategoriesBySection(['section'], 'PROVENENCE')
            );

            $compact = compact('title', 'param', 'product', 'CatOfProduct', 'AllCat', 'allTags', 'tagOfProduct');
        }
        // On génére la vue
        $this->view('administrator.updateProduct', $compact);
    }

    /**
     * Permet de récupérer le lien sur lequel on se retrouve sans les variable get défini
     * @param string index de la methode get à partir de laquel nous voulont suprimé le reste
     * @return string URL précedent la ffonction get
     */
    public function modifLinkget(string $paramGetToDelete): string
    {
        if (str_contains($_SERVER['REQUEST_URI'], $paramGetToDelete)) {
            $urlGet = $_SERVER['REQUEST_URI'] . 'todelete';
            $newUrl = explode($paramGetToDelete, $urlGet)[0];
        } else {
            $newUrl = $_SERVER['REQUEST_URI'];
        }
        return $newUrl;
    }

    /**
     * Compte le nombre d'article disponnibles selon se filtre
     * @param string Nom de la categorie à rechercher
     */
    public function countSearch($nameCategories)
    {
        if (!empty($_GET['recherche'])) {
            $result = $this->Product->find_article($_GET['recherche']);
        } else $result = $this->Product->getAllProductForUpdate();
        $result = count($this->Product->selectArrayByValue($result, 'cat parent', $nameCategories));
        return $result;
    }

    /**
     * Gestion de l'envoie des formulaire à la base de donner
     * @param array Récuperation du formulaire
     * @param ,id_article
     * @param ,id_categorie parent
     */
    public function controlOfUpdateCategories(array $form, $id_article, $id_cat_parent)
    {
        $resultForm = count($form);
        if (!empty($form) && $resultForm === 1) //Nous nous assurons de traité un fomulaire aillant un unique input
        {
            $key = array_key_first($form); //On extrait la clef correspondante
            if ($key == 'delet-fk_id_categorie' || $key == 'add-fk_id_categorie') //nous rejetons les formulaire uniques annexes
            {
                $state = explode('-', $key)[0]; //On récupère la condition du bouton input add=ajouter delete = Suprimée
                if ($state != 'add') {
                    $this->Categories->deleteCatOfProduct($id_article, $form[$key]);
                } else {
                    /** Pour nous assurer d'éviter les doublons
                     * nous récupérons un tableau témoins en base de donnée
                     * qui repertorie l'ensemble des categories*/
                    $arrayTelltale = $this->Categories->getSectionCatByIdProduct($id_article);
                    /**Nous verifions que l'id à ajouter n'existe pas dans le tableau témoin
                     * Si True alors l'insertion ne se fera pas
                     * Si False Alors on laisse l'envoie ce faire*/
                    if (in_array($form[$key], array_column($arrayTelltale, 'id_categorie')) == false) //Nous passons par arrat_column afin de vérifier sur l'ensemble du tableau Multidimensionnel
                    {
                        $this->Categories->insertInterTableCategorieProduct($id_article, $form[$key], $id_cat_parent);
                    }
                }
            }
        }

        /**
         * Modifie l
         */
    }
    public function updateStrongofproduct($id_article, $form)
    {
        if (!empty($_POST['FORCE']) xor !empty($_POST['PROVENENCE']) xor !empty($_POST['VARIÉTÉ'])) {
            $key = array_key_first($form);
            $strength = $this->Categories->getSectionCatByIdProduct($id_article, $key)[0];
            $this->Categories->updateStrenghtOfproduct($id_article, $strength['id_categorie'], $form[$key]);
        }
    }

    public function modifyPicture(string $name_file, string $namePicture, string $chemin = '/boutique-en-ligne/public/assets/pictures/pictures_product/')
    {

        if (!empty($_FILES[$name_file]['name'])) {
            $this->Product->verify_upload($name_file);
            $this->Product->stock_picture($chemin, $namePicture);
        }
    }

    public function gestionTag($param)
    {
        //gestion des tags
        $allTags = $this->Product->getAlltag(); //On récupère les tags

        if (!empty($_POST['delettag'])) //
        {
            $this->Product->deleteTagOfProduct($_POST['delettag'], $param);
        }
        if (!empty($_POST['addTag']) && !empty($_POST['tag'])) {
            if (in_array($_POST['tag'], array_column($allTags, 'nom_tag'))) {
                foreach ($allTags as $key => $value) {
                    if ($value['nom_tag'] == $_POST['tag']) {
                        $idNewTag = (int)$value['id_tag'];
                    }
                }
                if (in_array($idNewTag, array_column($this->Product->getTagByProduct($param), 'fk_id_tag')) == false) {
                    $this->Product->insertTag($idNewTag, $param);
                }
            } else {
                $this->Product->insertNewTag($_POST['tag']);
                $idNewTag = ($allTags[array_key_last($allTags)]['id_tag']) + 1;
                $this->Product->insertTag($idNewTag, $param);
            }
        }
    }
}
