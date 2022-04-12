<?php

namespace App\models;

use App\Models\Model;
use Database\DBConnection;

class Product extends Model
{
    public $image_article;
    protected $id_article;
    protected $titre_article;
    protected $presentation_article;
    protected $description_article;
    protected $prix_article;
    protected $sku;
    protected $fournisseur;
    protected $conditionnement;

    public function __construct()
    {
        // Spécifie la table à utiliser pour la class Model
        $this->table = 'articles';
        $this->db = DBConnection::getPDO();
        $this->id = 'id_article';
    }

    /**
     * Renvoit un tableau avec tout les articles 
     * @return array 
     */
    public function get_all_art(): array
    {
        $return = $this->findAll();
        return $return;
    }

    // public function return_col($table)
    // {
    //     return $this->show_column($table);
    // }

    public function find_article($searchResult)
    {

        $req =
            "
            SELECT `art1`.id_article, `art1`.titre_article, `art1`.prix_article,`cat2`.`nom_categorie` AS 'cat parent', 'article' AS 'type'
            FROM articles_categories_filtre
            INNER JOIN articles AS `art1` ON articles_categories_filtre.fk_id_article = `art1`.`id_article`
            INNER JOIN categories AS `cat1` ON articles_categories_filtre.fk_id_cat_categorie = `cat1`.id_categorie
            INNER JOIN categories AS `cat2` ON articles_categories_filtre.id_parent = `cat2`.id_categorie
            WHERE  MATCH (`art1`.titre_article  ) AGAINST (:titre_article )
            GROUP BY `art1`.`id_article`;
        ";

        $query = $this->db->prepare($req);

        $query->setFetchMode(\PDO::FETCH_ASSOC);
        $query->execute(array(
            ":titre_article" => "%$searchResult%",
        ));
        $article = $query->fetchall();

        return $article;
    }

    /**
     * Retourne l'ensemble des produit en base de donnée avec le nom des categorie en question
     * @param array  [Optionnel] La manière de trier l'information
     * Tableau prenant [ index = methode ASC|DESC] => colonne sur laquel trier ]
     */
    public function getAllProductForUpdate(?array $sort = null)
    {
        if (!empty($sort)) {
            $method = array_key_first($sort);
            $sortGo = "ORDER BY `art1`." . $sort[$method] . " $method";
        } else $sortGo = null;

        $req = "
        SELECT `art1`.id_article, `art1`.titre_article, `art1`.sku,`art1`.prix_article,`cat2`.`nom_categorie` AS 'cat parent' 
        FROM articles_categories_filtre 
        INNER JOIN articles AS `art1` ON articles_categories_filtre.fk_id_article = `art1`.`id_article` 
        INNER JOIN categories AS `cat2` ON articles_categories_filtre.id_parent = `cat2`.id_categorie 
        GROUP BY `art1`.`id_article` $sortGo;";
        $query = $this->requete($req);
        return $query->fetchAll();
    }

    public function getAllProductForCard()
    {
        $req = "
        SELECT `art1`.id_article, `art1`.sku, `art1`.titre_article, `art1`.prix_article, `art1`.description_article, `art1`.presentation_article, `art1`.image_article,`cat2`.`nom_categorie` AS 'cat parent'
        FROM articles_categories_filtre 
        INNER JOIN articles AS `art1` ON articles_categories_filtre.fk_id_article = `art1`.`id_article` 
        INNER JOIN categories AS `cat2` ON articles_categories_filtre.id_parent = `cat2`.id_categorie 
        GROUP BY `art1`.`id_article`;";
        $query = $this->requete($req);
        return $query->fetchAll();
    }

    public function getProductForCardbyID($id_article)
    {

        $req = "SELECT `art1`.id_article, `art1`.sku, `art1`.titre_article, `art1`.prix_article, `art1`.description_article, `art1`.presentation_article, `art1`.image_article,`cat2`.`nom_categorie` AS 'cat parent'
        FROM articles_categories_filtre
        INNER JOIN articles AS `art1` ON articles_categories_filtre.fk_id_article = `art1`.`id_article`
        INNER JOIN categories AS `cat2` ON articles_categories_filtre.id_parent = `cat2`.id_categorie
        WHERE `art1`.id_article = :id_article GROUP BY `art1`.`id_article`;";
        $query = $this->requete($req, compact('id_article'));
        return $query->fetchAll()[0];
    }

    public function bestProduct()
    {
        $req = "SELECT `fk_id_article`, count(`fk_id_article`) AS `nb_vente` 
        FROM `commandes` INNER JOIN `articles` 
        ON `commandes`.fk_id_article = `articles`.id_article 
        GROUP BY `fk_id_article` ORDER BY `nb_vente` DESC;";
        $query = $this->requete($req);
        return $query->fetchAll();
    }

    public function lastProductById()
    {
        $req = "SELECT MAX(id_article) as id_article FROM `articles`;";
        $query = $this->requete($req);
        return $query->fetchAll()[0];
    }
}
