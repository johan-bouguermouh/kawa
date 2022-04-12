<?php

namespace App\models;

/* use Database\DBConnection; */


class Articles extends Model

{
    protected $table = 'articles';
    protected $id = 'id_article';


    public function updateLock($db, $id, $Value)
    {
        $req = "
        UPDATE articles SET sku = sku - :diminuer WHERE id_article =:id_article;
        ";
        $stmt = $db->prepare($req);
        $stmt->execute(array(
            ":id_article" => $id,
            ":diminuer" => $Value
        ));
    }
}
