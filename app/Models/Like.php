<?php

namespace App\models;



class Like extends Model
{
    protected $table = 'utilisateurs_articles_like';

    public function getLikeByArticle($id_article)
    {
        $sql = "SELECT COUNT(fk_id_article) FROM utilisateurs_articles_like WHERE fk_id_article = $id_article";
        return (int)$this->requete($sql)->fetch()['COUNT(fk_id_article)'];
    }

    public function insertLike($id_article, $id_utilisateur)
    {
        $sql = "INSERT INTO `utilisateurs_articles_like`(`fk_id_article`, `fk_id_utilisateur`) VALUES (:fk_id_article, :fk_id_utilisateur)";
        $fk_id_article = $id_article;
        $fk_id_utilisateur = $id_utilisateur;
        return $this->requete($sql, compact('fk_id_article', 'fk_id_utilisateur'));
    }

    public function deleteLike($id_article, $id_utilisateur)
    {
        $sql = "DELETE FROM `utilisateurs_articles_like` WHERE `fk_id_utilisateur` = :fk_id_utilisateur AND `fk_id_article` = :fk_id_article";
        $fk_id_article = $id_article;
        $fk_id_utilisateur = $id_utilisateur;
        return $this->requete($sql, compact('fk_id_article', 'fk_id_utilisateur'));
    }

    public function getLike($id_utilisateur)
    {
        $sql = "SELECT `fk_id_article` FROM `utilisateurs_articles_like` WHERE fk_id_utilisateur = $id_utilisateur";
        return $this->requete($sql)->fetch();
    }
}
