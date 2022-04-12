<?php

namespace App\models;

use App\models\Model;
use Database\DBConnection;


class Categories extends Model
{
    protected $id = "id_categorie";
    protected $id_categorie;
    protected $nom_categorie;
    protected $section;

    public function __construct()
    {
        $this->table = 'categories';
        $this->db = DBConnection::getPDO();
    }

    /**
     * Renvoit un tableau avec les catégories principales
     * @param string Nom de la section sellectionner
     * @return array 
     */
    public function get_categorie(array $criteres, array $data, ?array $filters = null): array
    {

        $item = $this->find($criteres, compact('titre_article', 'prix_article'));

        return $item;
    }

    public function insertInterTableCategorieProduct($id_product, $id_cat_categorie, $id_cat_parent)
    {
        $req = "INSERT INTO `articles_categories_filtre`(`fk_id_article`, `fk_id_cat_categorie`, `id_parent`) VALUES (:fk_id_article,:fk_id_cat_categorie,:id_parent)";
        $fk_id_article = (int) $id_product;
        $fk_id_cat_categorie = (int) $id_cat_categorie;
        $id_parent = (int)$id_cat_parent;
        // On exécute la requête 
        return $this->requete($req, compact('fk_id_article', 'fk_id_cat_categorie', 'id_parent'));
    }

    /**
     * Get the value of id_categorie
     */
    public function getId_categorie()
    {
        return $this->id_categorie;
    }

    /**
     * Set the value of id_categorie
     *
     * @return  self
     */
    public function setId_categorie($id_categorie)
    {
        $this->id_categorie = $id_categorie;

        return $this;
    }

    /**
     * Get the value of nom_categorie
     */
    public function getNom_categorie()
    {
        return $this->nom_categorie;
    }

    /**
     * Set the value of nom_categorie
     *
     * @return  self
     */
    public function setNom_categorie($nom_categorie)
    {
        $this->nom_categorie = $nom_categorie;

        return $this;
    }

    /**
     * Get the value of section
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set the value of section
     *
     * @return  self
     */
    public function setSection($section)
    {
        $this->section = $section;

        return $this;
    }

    /** Récupère l'id et le nom de la catégorie associé a un article
     * @param ,Id du produit
     * @param string ,[Optionnel] Permet de spécifier la section a recupérer
     */
    public function getSectionCatByIdProduct($fk_id_article, ?string $section = null)
    {
        if ($section !== null) {
            $add = " AND `categories`.`section`= :section;";
            $compact = compact('fk_id_article', 'section');
        } else {
            $add = null;
            $compact = compact('fk_id_article');
        }

        $req = "SELECT `categories`.`nom_categorie`, `categories`.`id_categorie`, `categories`.`section`
        FROM `articles_categories_filtre` AS `intermediaire`
        INNER JOIN `categories` ON `intermediaire`.`fk_id_cat_categorie` = `categories`.`id_categorie`
        WHERE `intermediaire`.`fk_id_article`= :fk_id_article
        $add
        ";
        $value = array(
            ':fk_id_article' => $fk_id_article,
            ':section' => $section
        );
        return $this->requete($req, $compact)->fetchAll();
    }

    /**
     * Retourne le nom de la catégorie parente de l'article
     * @param ,id de l'article
     */
    public function selectMainCatOfProduct($fk_id_article)
    {
        $req = "SELECT `categories`.`nom_categorie`, `categories`.`id_categorie`
        FROM `articles_categories_filtre`AS `intermediaire`
        INNER JOIN `categories` ON `intermediaire`.`id_parent` = `categories`.`id_categorie`
        WHERE `intermediaire`.`fk_id_article`= :fk_id_article
        GROUP BY `categories`.`id_categorie`;";

        return $this->requete($req, compact('fk_id_article'))->fetchAll()[0];
    }
    /**
     * Surpime de la table intermediare articles_categories_filtre la ligne ciblée
     * @param ,id article
     * @param ,id catégorie
     */
    public function deleteCatOfProduct($fk_id_article, $fk_id_cat_categorie)
    {
        $req = "DELETE FROM `articles_categories_filtre` WHERE fk_id_cat_categorie  = :fk_id_cat_categorie  AND fk_id_article = :fk_id_article;";
        return $this->requete($req, compact('fk_id_article', 'fk_id_cat_categorie'));
    }

    /**
     * Modifie l'id de la catégorie principale d'un article
     * @param ,Id de l'article
     * @param, Id de la catégorie parent
     */
    public function updateMainCatOfProduct($fk_id_article, $id_parent)
    {
        $req = "UPDATE  `articles_categories_filtre` SET `id_parent`= :id_parent WHERE `fk_id_article`= :fk_id_article;";
        return $this->requete($req, compact('fk_id_article', 'id_parent'));
    }
    /**
     * Modifie l'id de la categorie enfante de la ligne associé à la force
     * @param ,id_article
     * @param ,id de la categorie de la force précédente
     * @param ,id de la categorie de la nouvelle force
     */
    public function updateStrenghtOfproduct($fk_id_article, $fk_id_cat_categorie, $new_id)
    {
        $req = "UPDATE  `articles_categories_filtre` SET `fk_id_cat_categorie`= :new_id
        WHERE `fk_id_cat_categorie`= :fk_id_cat_categorie
        AND `fk_id_article`= :fk_id_article;";
        return $this->requete($req, compact('fk_id_article', 'fk_id_cat_categorie', 'new_id'));
    }
}
