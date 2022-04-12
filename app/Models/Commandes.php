<?php

namespace App\models;

class Commandes extends Model

{
    protected $table = 'commandes';
    protected $id = 'id_commande';
    protected $id_commande;
    protected $fk_id_num_commande;
    protected $fk_id_article;
    protected $nb_article;
    protected $prix_article;
    protected $prix_commande;
    protected $titre_article;


    /**
     * Get the value of id_commande
     */
    public function getId_commande()
    {
        return $this->id_commande;
    }

    /**
     * Set the value of id_commande
     *
     * @return  self
     */
    public function setId_commande($id_commande)
    {
        $this->id_commande = $id_commande;

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
     * Get the value of fk_id_article
     */
    public function getFk_id_article()
    {
        return $this->fk_id_article;
    }

    /**
     * Set the value of fk_id_article
     *
     * @return  self
     */
    public function setFk_id_article($fk_id_article)
    {
        $this->fk_id_article = $fk_id_article;

        return $this;
    }

    /**
     * Get the value of nb_article
     */
    public function getNb_article()
    {
        return $this->nb_article;
    }

    /**
     * Set the value of nb_article
     *
     * @return  self
     */
    public function setNb_article($nb_article)
    {
        $this->nb_article = $nb_article;

        return $this;
    }

    /**
     * Get the value of prix_commande
     */
    public function getPrix_commande()
    {
        return $this->prix_commande;
    }

    /**
     * Set the value of prix_commande
     *
     * @return  self
     */
    public function setPrix_commande($prix_commande)
    {
        $this->prix_commande = $prix_commande;

        return $this;
    }

    /**
     * Get the value of prix_article
     */
    public function getPrix_article()
    {
        return $this->prix_article;
    }

    /**
     * Set the value of prix_article
     *
     * @return  self
     */
    public function setPrix_article($prix_article)
    {
        $this->prix_article = $prix_article;

        return $this;
    }

    public function getInfoCommande($id_commande)
    {
        $query = $this->db->prepare(
            "SELECT num_commande.fk_id_utilisateurs, num_commande.date, num_commande.prix_avec_tva, num_commande.total_produit, num_commande.id_num_commande,

c1.nb_article, c1.prix_article, c1.prix_commande,


livraison.ville, livraison.voie, livraison.voie_sup, livraison.code_postal, 
livraison.prenom,livraison.nom_adresse,livraison.telephone,livraison.nom, livraison.email, 
livraison.fk_id_num_commande, livraison.pays, livraison.etat_livraison,

c1.titre_article

            FROM num_commande 
            INNER JOIN commandes AS c1 ON c1.fk_id_num_commande = num_commande.id_num_commande 
            INNER JOIN livraison ON livraison.fk_id_num_commande = num_commande.id_num_commande
           
            
           WHERE num_commande.id_num_commande = :id_num_commande"
        );


        $query->execute(array(
            ":id_num_commande" => "$id_commande",

        ));
        $result = $query->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Get the value of titre_article
     */
    public function getTitre_article()
    {
        return $this->titre_article;
    }

    /**
     * Set the value of titre_article
     *
     * @return  self
     */
    public function setTitre_article($titre_article)
    {
        $this->titre_article = $titre_article;

        return $this;
    }
}
