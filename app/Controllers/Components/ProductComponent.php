<?php

namespace App\controllers\Components;

use Database\DBConnection;
use App\models\Product;

class ProductComponent extends Product
{
    protected $model;
    public $error = [];

    public function __construct()
    {
        parent::__construct();
        $this->model = new Product();
    }
    /**
     * Verifie la taille du fichier télécharger
     * Verifie si le téléchargement a bien était effectuée
     * @param string nom du fichier à verifier
     * @param int taille du fichier maximum
     * @return bool Si le fichier et inferieur à la taille maximal alors True, sinon False
     */
    public function verify_upload(string $name_file, ?int $size = 1000000): bool
    {
        if (@$_FILES[$name_file]['size'] > $size) {
            $_SESSION['flash']['imageTaille'] = 'Le fichier télécharger est trop volumineux, taille maximum 1Mo';
            return false;
        } elseif (empty($_FILES[$name_file]['tmp_name'])) {
            if (!empty($_SESSION['nouvelarticle']['image_article'])) {
                $_SESSION['flash']['imageProbleme'] = 'Le téléchargement de l\'image n\'a pas été effectué';
            }

            return false;
        } else return true;
    }

    /**
     * Traite l'image et l'ajoute dans un dossier donnée
     * Modifie le nom de l'image
     * @param string chemin d'enregistrement
     * @param string Nom du fichier
     */
    public function stock_picture(string $chemin = '/boutique-en-ligne/public/assets/pictures/pictures_product/', ?string $lastName = null)
    {
        if ($this->verify_upload('image_article') == true) {
            //Verification de l'extention du fichier reçu
            $explode_file = explode(".", $_FILES['image_article']['name']);
            $extention = ['jpeg', 'jpg', 'JPEG', 'JPG'];
            $approuve = false;
            foreach ($extention as $value) {
                if ($value == $explode_file[1]) {
                    $approuve = true;
                }
            }
            if ($approuve == false) {
                $_SESSION['flash']['format'] = "L'image doit être en jpeg";
            }

            if ($approuve == true) {
                //si approuver, traitement du fichier
                if (empty($lastName)) {
                    $explode_file[0] = uniqid(); //Renomage du fichier avec une string unique
                } else $explode_file[0] = $lastName; //Sinon on garde le nom choisi en param
                $explode_file[1] = ".$explode_file[1]"; //Ajout du dote avant concatenation
                $_FILES['image_article']['name'] = $explode_file[0] . $explode_file[1]; //Concataination du nom et de l'exention
                $im_miniature = $_FILES['image_article']['name'];

                //Modification de la taille de l'image
                $taille = getimagesize($_FILES['image_article']['tmp_name']); //Traitement de la largeur et  de la hauteur d'origine du fichier
                $largeur = $taille[0];
                $hauteur = $taille[1];
                $largeur_miniature = 720; //Definition de la nouvelle largeur
                $hauteur_miniature = $hauteur / $largeur * 720; //Definition de la nouvelle hauteur relative à la largeur
                $im = imagecreatefromjpeg($_FILES['image_article']['tmp_name']); //Creation d'une nouvelle image dans la memoire tampon
                $im_miniature = imagecreatetruecolor($largeur_miniature, $hauteur_miniature); //creation d'un gabari selon les dimention defini
                imagecopyresampled($im_miniature, $im, 0, 0, 0, 0, $largeur_miniature, $hauteur_miniature, $largeur, $hauteur); //redimention de l'image à la taille de l'image tampon
                imagejpeg($im_miniature, $chemin . $_FILES['image_article']['name'], 90); //Création de l'image dans le dossier assigner

                $this->image_article = $_FILES['image_article']['name'];

                return $this->image_article;
            } else $this->error['image'] = 'Assurez-vous que l\'image soit bien en jpg,jpeg.';

            return null;
        }
    }

    /**
     * Affiche une vignette avec le résultat du téléchargement
     * @param string lein vers l'image
     * @param string Nome de l'image selectionner
     */
    public function screen_result(string $nom_image = 'no_pict_product.jpg', string $chemin = '/boutique-en-ligne/public/assets/pictures/pictures_product/',)
    {
?>
        <img style="width: 200px;height: 200px;" src="<?= $chemin . $nom_image ?>" alt="votre nouvelle image d'article'">
<?php


    }


    /**
     * Insetion des données pour un nouvelle articles
     * @param array récupère la variable de session ayant enregistrer toute les information
     * 
     */
    public function createProduct(array $array)
    {
        $this->db = DBConnection::getPDO();
        $this->table = 'articles';

        $this->model->image_article = $array['image_article'];
        foreach ($array['etape1'] as $key => $value) {
            $this->model->$key = $value;
        }

        $NewArticle = $this->model;
        $image_article = $this->model->image_article;
        $titre_article = $this->model->titre_article;
        $presentation_article = $this->model->presentation_article;
        $description_article = $this->model->description_article;
        $prix_article = (float)$this->model->prix_article;
        $sku = (int)$this->model->sku;
        $fournisseur = $this->model->fournisseur;
        $conditionnement = $this->model->conditionnement;

        $item = $this->create($NewArticle, compact('image_article', 'titre_article', 'presentation_article', 'description_article', 'prix_article', 'sku', 'fournisseur', 'conditionnement'));
    }
    public function useLastId()
    {
        return $this->db->lastInsertId();
    }

    /**
     * Permet de selectionner l'ensemble des tableau correspondant à la valeur d'une clef donnée
     * @param array Tableau sur lequel on va triller
     * @param string Nom de la clef rechercher
     * @param mixed (string|float|int) valeur à selectionner
     * $obj = représente le tableau La table principale 
     */
    public function selectArrayByValue(array $array, ?string $paramKey = null, mixed $paramValue = null)
    {
        if ($paramValue == null) {
            return $array;
        }
        if (is_array($array[0])) {
            $result = [];

            $i = 0;
            while (isset($array[$i])) {
                foreach ($array[$i] as $key => $value) {
                    if (is_array($value) == true) {
                        if (in_array($paramValue, $value) == true) {
                            $result[] = $array[$i];
                        }
                    } elseif ($key == $paramKey && $value == $paramValue) {
                        $result[] = $array[$i];
                    }
                }
                $i++;
            }

            return $result;
        } else {
            foreach ($array as $key => $value) {
                if ($key == $paramKey && $value == $paramValue) {
                    return $array;
                }
            }
            return null;
        }
    }

    /**
     * Permet de modifier les informations de l'article
     * @param array Tableau venant d'un formulaire
     * @param ,l'id du produit;
     * @param string [Optionnel]Si l'image est traité dans un autre formulaire
     * permet de l'envoyer indépendamment du traitement;
     */
    public function updateProduct(array $form, $idProduct, ?string $pictureFileName)
    {

        $this->model->id_article = $idProduct;
        if (!empty($pictureFileName)) {
            $this->model->image_article = $pictureFileName;
        }

        $lastKey = array_key_last($form);
        unset($form[$lastKey]);
        foreach ($form as $key => $value) {
            $this->model->$key = $value;
        }

        $NewArticle = $this->model;
        $image_article = $this->model->image_article;
        $titre_article = $this->model->titre_article;
        $presentation_article = $this->model->presentation_article;
        $description_article = $this->model->description_article;
        $prix_article = (float)$this->model->prix_article;
        $sku = (int)$this->model->sku;
        $fournisseur = $this->model->fournisseur;
        $conditionnement = $this->model->conditionnement;
        $id_article = $idProduct;

        $item = $this->update($NewArticle, compact('id_article', 'image_article', 'titre_article', 'presentation_article', 'description_article', 'prix_article', 'sku', 'fournisseur', 'conditionnement'));
    }

    /**
     * Permet d'Update le nombre d'unité en stocke
     * @param array fomrulaire de reception
     */
    public function updateSku(array $form)
    {
        $oldSku = $this->find(['id_article'], ['id_article' => $form['id_article']], ['sku'])[0]['sku'];
        $newStock = (int)$form['sku'];
        $total = ($newStock + $oldSku);
        $form['sku'] = $total;
        if (!empty($form['sku']) && !empty($form['id_article'])) {
            $req = "UPDATE `articles` SET `sku`= :sku WHERE `id_article`= :id_article;";

            $this->requete($req, $form);
        }
    }

    /**
     * Methode specifique au compte des stock aillant moins de 10 unité
     * Permet de récupérer les articles dont le SKU est compris entre 0 et 10
     */
    public function stockNow()
    {
        $allsTock = $this->getAllProductForUpdate(['ASC' => 'sku']);

        $arrayStockNow = [];
        $i = 0;
        while (isset($allsTock[$i])) {
            foreach ($allsTock[$i] as $key => $value) {
                if ($key == 'sku' && $value <= 10) {
                    $arrayStockNow[] = $allsTock[$i];
                }
            }
            $i++;
        }
        return $arrayStockNow;
    }

    public function getAlltag()
    {
        $req = "SELECT * FROM `tag`";
        $result = $this->requete($req)->fetchAll();
        return $result;
    }

    public function insertNewTag($nom_tag)
    {
        $req = "INSERT INTO `tag`(`nom_tag`) VALUES (:nom_tag)";
        $result = $this->requete($req, compact('nom_tag'));
    }

    public function insertTag($fk_id_tag, $fk_id_article)
    {
        $req = "INSERT INTO `articles_tags`(`fk_id_tag`, `fk_id_article`) VALUES (:fk_id_tag,:fk_id_article);";
        $this->requete($req, compact('fk_id_tag', 'fk_id_article'));
    }
    /**
     * Permet d'ajouter tout les tag d'un produit
     * @param array le tableau avec les tags
     * @param ,id de l'article en question
     */
    public function insertAllcatByProducts($array, $fk_id_article)
    {
        foreach ($array as $key => $value) {
            $fk_id_tag = $key;
            $this->insertTag($fk_id_tag, $fk_id_article);
        }
    }

    public function getTagByProduct($fk_id_article)
    {
        $req = "SELECT `articles_tags`.fk_id_article, `articles_tags`.fk_id_tag, `tag`.nom_tag  FROM `articles_tags`
        INNER JOIN `tag` ON `tag`.id_tag = `articles_tags`.fk_id_tag
        WHERE `articles_tags`.fk_id_article = :fk_id_article;";
        $result = $this->requete($req, compact('fk_id_article'))->fetchAll();
        return $result;
    }

    public function deleteTagOfProduct($fk_id_tag, $fk_id_article)
    {
        $req = "DELETE FROM `articles_tags` WHERE fk_id_tag = :fk_id_tag AND fk_id_article = :fk_id_article;";
        $resutl = $this->requete($req, compact('fk_id_article', 'fk_id_tag'));
    }
}
