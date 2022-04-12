<?php

namespace App\models;

use App\models\Model;
use Database\DBConnection;


class Tag extends Model
{
    protected $id = "id_tag";
    protected $id_tag;
    protected $nom_tag;
    protected $table = "tag";

    /**
     * Get the value of id_tag
     */
    public function getId_tag()
    {
        return $this->id_tag;
    }

    /**
     * Set the value of id_tag
     *
     * @return  self
     */
    public function setId_tag($id_tag)
    {
        $this->id_tag = $id_tag;

        return $this;
    }

    /**
     * Get the value of nom_tag
     */
    public function getNom_tag()
    {
        return $this->nom_tag;
    }

    /**
     * Set the value of nom_tag
     *
     * @return  self
     */
    public function setNom_tag($nom_tag)
    {
        $this->nom_tag = $nom_tag;

        return $this;
    }
}
