<?php

namespace App\Controllers\admin;

use App\controllers\Controller;

use App\controllers\components\ProductComponent;
use App\controllers\components\CategoriesComponent;

class AdminCreateProductController extends Controller
{
    protected $Product;
    protected $Categories;

    public function __construct()
    {
        $this->Product = new ProductComponent;
        $this->Categories = new CategoriesComponent;
    }

    //METHODE D'APPEL ADMIN
    public function index()
    {
        $title = 'Admin';
        // On génére la vue
        if (!empty($this->Product->stockNow())) {
            $sendStock = 'Vous avez certains article dont le stock est critique,
            pensez à contacter vos founisseur';
        } else $sendStock = null;
        $this->view('administrator/index', compact('title', 'sendStock'));
    }

    /**
     * Methode destiné
     * @param string Nom de l'étape à laquel il faut se rendre
     */
    public function CreatProduct(string $param)
    {
        //$param et défini selon la redirection du formulaire
        $title = 'Admin | Nouvel Article';
        $this->recover(); //Enregistre les valeurs du formulaire en variable de section

        if ($param == 'partie1') //Première partie du formulaire ___ Information dédier à la Table Article
        {
            $Admin_function = new AdminCreateProductController;
            $compact = compact('param', 'Admin_function', 'title');
        } elseif ($param == 'partie2') {
            $this->Categories->wheneInsertCategories('ajouter_SAVEUR');
            $this->Categories->wheneInsertCategories('ajouter_PROVENENCE');
            $result_request = array(
                'principale' => $this->Categories->chooseCategoriesBySection(['section'], 'PRINCIPALE'),
                'variete' => $this->Categories->chooseCategoriesBySection(['section'], 'VARIÉTÉ'),
                'specificite' => $this->Categories->chooseCategoriesBySection(['section'], 'SPÉCIFICITÉ'),
                'flavor' => $this->Categories->chooseCategoriesBySection(['section'], 'SAVEUR'),
                'strong' => $this->Categories->chooseCategoriesBySection(['section'], 'FORCE'),
                'origin' => $this->Categories->chooseCategoriesBySection(['section'], 'PROVENENCE')
            );

            //gestion des tags
            $allTags = $this->Product->getAlltag(); //On récupère les tags

            if (!empty($_POST['delettag'])) //
            {
                unset($_SESSION['nouvelarticle']['tag'][$_POST['delettag']]);
            }
            if (!empty($_POST['addTag']) && !empty($_POST['tag'])) {
                if (in_array($_POST['tag'], array_column($allTags, 'nom_tag'))) {
                    foreach ($allTags as $key => $value) {
                        if ($value['nom_tag'] == $_POST['tag']) {
                            $idNewTag = (int)$value['id_tag'];
                        }
                    }
                    $_SESSION['nouvelarticle']['tag'][$idNewTag] = $_POST['tag'];
                } else {
                    $this->Product->insertNewTag($_POST['tag']);
                    $idNewTag = ($allTags[array_key_last($allTags)]['id_tag']) + 1;
                    $_SESSION['nouvelarticle']['tag'][$idNewTag] = $_POST['tag'];
                }

                $allTags = $this->Product->getAlltag();
            }

            $compact = compact('param', 'result_request', 'title', 'allTags');
        } elseif ($param == 'rendu') {

            unset($_SESSION['nouvelarticle']['etape2']['tag']);
            $printTag = 'TAG : #' . implode(' #', $_SESSION['nouvelarticle']['tag']);
            $compact = compact('param', 'title', 'printTag');
        } elseif ($param == 'upload') {
            if (
                isset($_SESSION['nouvelarticle']['etape1'])
                && ($this->verify_input($_SESSION['nouvelarticle']['etape1']) === true)
                && !empty($_SESSION['nouvelarticle']['etape2']['PRINCIPALE'])
                && !empty($_SESSION['nouvelarticle']['etape2']['VARIÉTÉ'])
                && !empty($_SESSION['nouvelarticle']['etape2']['FORCE'])
                && !empty($_SESSION['nouvelarticle']['etape2']['PROVENENCE'])
                && !empty($_SESSION['nouvelarticle']['etape2']['SAVEUR'])
            ) {
                $this->Product->createProduct($_SESSION['nouvelarticle']);
                $this->Categories->insertAllCat(
                    $_SESSION['nouvelarticle']['etape2'],
                    $this->Product->useLastId(),
                    $_SESSION['nouvelarticle']['etape2']['PRINCIPALE'],
                );
                $this->Product->insertAllcatByProducts($_SESSION['nouvelarticle']['tag'], $this->Product->useLastId());

                unset($_SESSION['nouvelarticle']);
                $message = 'Félicitation ! Votre article est à présent en ligne';
            }
            $message = 'Félicitation ! Votre article est à présent en ligne';
            $compact = compact('param', 'message', 'title');
        } else $retour = 'Pas de paramettre à effectué';

        $this->less_part($param); //Passe à l'étape suivante selon les conditions d'acceptations
        $this->view('administrator.creerarticle', $compact);
    }

    //METHODE DE CONSTRUCTION

    /**
     * Récupère les données information et les traites
     * Envoie l'image dans le dossier associé
     * Affiche le résultat de l'image dans une vignette
     * @param string chemin vers l'image
     * @param string nom de l'image
     */
    public function upload_image(string $name_file, string $chemin = '/boutique-en-ligne/public/assets/pictures/pictures_product/')
    {
        $this->Product->verify_upload($name_file);
        $this->Product->stock_picture($chemin);
        if ($this->Product->verify_upload($name_file)) {
            $_SESSION['nouvelarticle']['image_article'] = $this->Product->image_article;
        }

        if (isset($_SESSION['nouvelarticle']['image_article'])) {
            $this->Product->screen_result($_SESSION['nouvelarticle']['image_article'], '/boutique-en-ligne/public/assets/pictures/pictures_product/');
        } else $this->Product->screen_result();
    }

    /**
     * Enregistrer les information du formulaire dans un variable de session
     */
    public function recover()
    {
        if (!empty($_FILES['image_article']['tpm_name']) && ($_FILES['image_article']['error'] == 0)) {
            $_SESSION['nouvelarticle']['image_article'] = $this->image_article;
        }
        if (!empty(@$_POST['etape1'] || @$_POST['titre_article'])) {
            $_SESSION['nouvelarticle']['etape1'] = $_POST;
            unset($_SESSION['nouvelarticle']['etape1']['etape1']);
        } elseif (!empty($_POST['etape2'])) {
            $_SESSION['nouvelarticle']['etape2'] = $_POST;
            unset($_SESSION['nouvelarticle']['etape2']['etape2']);
            unset($_SESSION['nouvelarticle']['etape2']['nom_PROVENENCE']);
            unset($_SESSION['nouvelarticle']['etape2']['nom_SAVEUR']);
        }
    }

    /**
     * Retourne les valeurs enregistrer dans la variable de session à selon l'emplacement des value input
     */
    public function coverup_form(string $name)
    {
        if (isset($_SESSION['nouvelarticle']['etape1'][$name])) {
            return $_SESSION['nouvelarticle']['etape1'][$name];
        } else return null;
    }

    /**
     * Verfie si toute les information son renseigner dans le champs
     * @param array retour de la methode POST|SECTION
     */
    public function verify_input($array)
    {
        foreach ($array as $key => $value) {
            if ($value == null) {
                $_SESSION['flash']['form'] = "Veuillez remplir tout les champs";
                return false;
            }
        }

        return true;
    }
    /**
     * Redirige l'utilisateur si toutes les conditions sont respecté
     * @param array retour de la method POST
     */
    public function less_part($param)
    {
        if (@$_SESSION['nouvelarticle']['image_article'] == false && $param !== 'upload') {
            $_SESSION['flash']['image'] = "Pensez à télécharger une image";
            // header('Refresh: 0');
            // exit();
        } elseif (!empty($_SESSION['nouvelarticle']['etape1']) && $this->verify_input($_SESSION['nouvelarticle']['etape1']) === true && !empty($_POST['etape1'])) {
            header('location: ./partie2');
        } elseif (isset($_POST['etape2']) && empty($_POST['PRINCIPALE'])) {
            $_SESSION['flash']['categorie'] = "Votre article doit obligatoirement avoir un catégorie Principale";
        } elseif (isset($_POST['etape2']) && empty($_POST['VARIÉTÉ'])) {
            $_SESSION['flash']['categorie'] = "Votre article doit obligatoirement avoir une variété";
        } elseif (isset($_POST['etape2']) && empty($_POST['FORCE'])) {
            $_SESSION['flash']['categorie'] = "Votre article doit obligatoirement avoir une force d'évaluer";
        } elseif (isset($_POST['etape2']) && empty($_POST['PROVENENCE'])) {
            $_SESSION['flash']['categorie'] = "Votre article doit obligatoirement avoir une provenence d'évaluer";
        } elseif (isset($_POST['etape2']) && empty($_POST['SAVEUR'])) {
            $_SESSION['flash']['categorie'] = "Votre article doit avoir au moins une saveur";
        } elseif (isset($_POST['etape2']) && empty($_SESSION['nouvelarticle']['tag'])) {
            $_SESSION['flash']['categorie'] = "Votre article doit avoir au moins un tag d'assigné";
        } elseif (
            isset($_SESSION['nouvelarticle']) && ($this->verify_input($_SESSION['nouvelarticle']['etape1']) === true)
            && !empty($_SESSION['nouvelarticle']['etape2']['PRINCIPALE'])
            && !empty($_SESSION['nouvelarticle']['etape2']['VARIÉTÉ'])
            && !empty($_SESSION['nouvelarticle']['etape2']['FORCE'])
            && !empty($_SESSION['nouvelarticle']['etape2']['PROVENENCE'])
            && !empty($_SESSION['nouvelarticle']['etape2']['SAVEUR'])
            && !empty($_POST['etape2'])
        ) {
            header('location: ./rendu');
        }
    }
}
