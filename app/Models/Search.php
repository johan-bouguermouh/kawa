<?php

namespace App\models;



class Search extends Model

{


    protected $table = 'articles';
    protected $id = 'id_article';

    public function find_article($sql)
    {

        $query = $this->db->prepare("

     SELECT articles.id_article, articles.sku, articles.titre_article, articles.presentation_article, articles.description_article, articles.prix_article, articles.image_article, `cat2`.`nom_categorie` AS 'cat parent', 'categorie' AS 'type'
            FROM articles
            INNER JOIN articles_categories_filtre ON articles_categories_filtre.fk_id_article = articles.id_article
            INNER JOIN categories AS `cat1` ON articles_categories_filtre.fk_id_cat_categorie = `cat1`.id_categorie 
            INNER JOIN categories AS `cat2` ON articles_categories_filtre.id_parent = `cat2`.id_categorie 
            OR articles_categories_filtre.id_parent = `cat1`.id_categorie
            WHERE MATCH(`cat2`.nom_categorie) AGAINST (:nom_categorie) OR MATCH(`cat1`.nom_categorie) AGAINST (:nom_categorie)
            GROUP BY articles.id_article
UNION ALL

SELECT `art1`.id_article, `art1`.sku, `art1`.titre_article, `art1`.presentation_article, `art1`.description_article,`art1`.prix_article, `art1`.image_article, `cat2`.`nom_categorie` AS 'cat parent', 'article' AS 'type'
            FROM articles_categories_filtre
            INNER JOIN articles AS `art1` ON articles_categories_filtre.fk_id_article = `art1`.`id_article`
            INNER JOIN categories AS `cat1` ON articles_categories_filtre.fk_id_cat_categorie = `cat1`.id_categorie
            INNER JOIN categories AS `cat2` ON articles_categories_filtre.id_parent = `cat2`.id_categorie
    WHERE  MATCH (`art1`.titre_article  ) AGAINST (:titre_article ) OR MATCH(`art1`.presentation_article) AGAINST (:presentation_article)
        GROUP BY `art1`.id_article
UNION ALL

SELECT articles.id_article, articles.sku, articles.titre_article, articles.presentation_article, articles.description_article, articles.prix_article, articles.image_article, `cat2`.`nom_categorie` AS 'cat parent', 'tag' AS 'type'
            FROM articles
            INNER JOIN articles_tags ON articles_tags.fk_id_article = articles.id_article
            INNER JOIN articles_categories_filtre ON articles.id_article = articles_categories_filtre.fk_id_article
            INNER JOIN categories AS `cat1` ON articles_categories_filtre.fk_id_cat_categorie = `cat1`.id_categorie
            INNER JOIN categories AS `cat2` ON articles_categories_filtre.id_parent = `cat2`.id_categorie   
            INNER JOIN tag ON tag.id_tag = articles_tags.fk_id_tag
             WHERE  MATCH (tag.nom_tag) AGAINST (:nom_tag)
             GROUP BY `articles`.id_article;

         ");

        $query->setFetchMode(\PDO::FETCH_ASSOC);
        $query->execute(array(
            ":nom_categorie" => "%$sql%",
            ":presentation_article" => "%$sql%",
            ":titre_article" => "%$sql%",
            ":nom_tag" => "%$sql%"
        ));
        $article = $query->fetchall();

        return $article;
    }
}
