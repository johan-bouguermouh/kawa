<?php

namespace App\models;




class Adresses extends Model

{
    protected $table = 'adresses';
    protected $id = 'id_adresse';
    protected $id_adresse;
    protected $nom_adresse;
    protected $ville;
    protected $pays;
    protected $voie;
    protected $voie_sup;
    protected $code_postal;
    protected $telephone;
    protected $fk_id_utilisateur;

    /**
     * Get the value of id_adresse
     */
    public function getId_adresse()
    {
        return $this->id_adresse;
    }

    /**
     * Set the value of id_adresse
     *
     * @return  self
     */
    public function setId_adresse($id_adresse)
    {
        $this->id_adresse = $id_adresse;

        return $this;
    }

    /**
     * Get the value of nom_adresse
     */
    public function getNom_adresse()
    {
        return $this->nom_adresse;
    }

    /**
     * Set the value of nom_adresse
     *
     * @return  self
     */
    public function setNom_adresse($nom_adresse)
    {
        $this->nom_adresse = $nom_adresse;

        return $this;
    }

    /**
     * Get the value of ville
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set the value of ville
     *
     * @return  self
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get the value of pays
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set the value of pays
     *
     * @return  self
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get the value of voie
     */
    public function getVoie()
    {
        return $this->voie;
    }

    /**
     * Set the value of voie
     *
     * @return  self
     */
    public function setVoie($voie)
    {
        $this->voie = $voie;

        return $this;
    }

    /**
     * Get the value of voie_sup
     */
    public function getVoie_sup()
    {
        return $this->voie_sup;
    }

    /**
     * Set the value of voie_sup
     *
     * @return  self
     */
    public function setVoie_sup($voie_sup)
    {
        $this->voie_sup = $voie_sup;

        return $this;
    }

    /**
     * Get the value of code_postal
     */
    public function getCode_postal()
    {
        return $this->code_postal;
    }

    /**
     * Set the value of code_postal
     *
     * @return  self
     */
    public function setCode_postal($code_postal)
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    /**
     * Get the value of telephone
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set the value of telephone
     *
     * @return  self
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

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
}
