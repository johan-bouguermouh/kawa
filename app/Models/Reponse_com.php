<?php

namespace App\Models;


class Reponse_com extends Model
{
    protected $table = 'reponse_com';
    protected $id = "id_reponse_com";
    protected $id_reponse_com;
    protected $commentaire;
    protected $fk_id_commentaire;
    protected $fk_id_utilisateur;
    protected $date;

    /**
     * Get the value of id_reponse_com
     */
    public function getId_reponse_com()
    {
        return $this->id_reponse_com;
    }

    /**
     * Set the value of id_reponse_com
     *
     * @return  self
     */
    public function setId_reponse_com($id_reponse_com)
    {
        $this->id_reponse_com = $id_reponse_com;

        return $this;
    }

    /**
     * Get the value of commentaire
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set the value of commentaire
     *
     * @return  self
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get the value of fk_id_commentaire
     */
    public function getFk_id_commentaire()
    {
        return $this->fk_id_commentaire;
    }

    /**
     * Set the value of fk_id_commentaire
     *
     * @return  self
     */
    public function setFk_id_commentaire($fk_id_commentaire)
    {
        $this->fk_id_commentaire = $fk_id_commentaire;

        return $this;
    }

    /**
     * Get the value of fk_id_utilisateur
     */
    public function getFk_id_utilisateur()
    {
        return $this->fk_id_utilisateur;
    }

    /**
     * Set the value of fk_id_utilisateur
     *
     * @return  self
     */
    public function setFk_id_utilisateur($fk_id_utilisateur)
    {
        $this->fk_id_utilisateur = $fk_id_utilisateur;

        return $this;
    }

    /**
     * Get the value of date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }
}
