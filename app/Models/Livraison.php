<?php

namespace App\models;

class Livraison extends Model

{
    protected $table = 'livraison';
    protected $id = 'id_livraison';
    protected $id_livraison;
    protected $fk_id_num_commande;
    protected $email;
    protected $nom;
    protected $prenom;
    protected $nom_adresse;
    protected $ville;
    protected $pays;
    protected $voie;
    protected $voie_sup;
    protected $code_postal;
    protected $telephone;
    protected $etat_livraison;

    /**
     * Get the value of id_livraison
     */
    public function getId_livraison()
    {
        return $this->id_livraison;
    }

    /**
     * Set the value of id_livraison
     *
     * @return  self
     */
    public function setId_livraison($id_livraison)
    {
        $this->id_livraison = $id_livraison;

        return $this;
    }

    /**
     * Get the value of fk_id_num_commande
     */
    public function getFk_id_num_commande()
    {
        return $this->fk_id_num_commande;
    }

    /**
     * Set the value of fk_id_num_commande
     *
     * @return  self
     */
    public function setFk_id_num_commande($fk_id_num_commande)
    {
        $this->fk_id_num_commande = $fk_id_num_commande;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of nom
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of prenom
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

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
     * Get the value of etat_livraison
     */
    public function getEtat_livraison()
    {
        return $this->etat_livraison;
    }

    /**
     * Set the value of etat_livraison
     *
     * @return  self
     */
    public function setEtat_livraison($etat_livraison)
    {
        $this->etat_livraison = $etat_livraison;

        return $this;
    }
}
