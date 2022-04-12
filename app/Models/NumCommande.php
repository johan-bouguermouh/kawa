<?php

namespace App\models;

class NumCommande extends Model

{
    protected $table = 'num_commande';
    protected $id = 'id_num_commande';
    protected $id_num_commande;
    protected $fk_id_utilisateurs;
    protected $date;
    protected $total_produit;
    protected $tva;
    protected $prix_sans_tva;
    protected $prix_avec_tva;


    public function orderInsert($db, $donnees)
    {

        $req = "INSERT INTO num_commande (fk_id_utilisateurs, date, total_produit, prix_sans_tva, prix_avec_tva) VALUE (:fk_id_utilisateurs, NOW(), :total_produit, :prix_sans_tva, :prix_avec_tva)";
        $stmt = $db->prepare($req);
        $stmt->execute(
            $donnees
        );

        $resultat = $db->lastInsertId();
        return $resultat;
    }

    public function countWaitingValidate()
    {
        $req = "SELECT etat_livraison, COUNT(etat_livraison) as nb FROM livraison WHERE etat_livraison = 'en attente confirmation'";
        $stmt = $this->db->prepare($req);
        $stmt->execute();
        $resultat = $stmt->fetch();
        return $resultat;
    }

    public function getAllOrderbyIdUser($id_user = null)
    {
        if ($id_user == null) {
            $stringWhere = null;
            $executearray =  null;
        } else {
            $stringWhere = "WHERE num_commande.fk_id_utilisateurs = :fk_id_utilisateurs";
            $executearray =  array(
                ":fk_id_utilisateurs" => "$id_user",
            );
        }

        $query = $this->db->prepare(
            "SELECT num_commande.date, num_commande.prix_avec_tva, num_commande.total_produit, num_commande.id_num_commande,

c1.nb_article, c1.prix_article, c1.prix_commande, c1.titre_article,


livraison.ville, livraison.voie, livraison.voie_sup, livraison.code_postal, 
livraison.prenom,livraison.nom_adresse,livraison.telephone,livraison.nom, livraison.email, 
livraison.fk_id_num_commande, livraison.pays, livraison.etat_livraison, livraison.id_livraison

            FROM num_commande 
            INNER JOIN commandes AS c1 ON c1.fk_id_num_commande = num_commande.id_num_commande 
            INNER JOIN livraison ON livraison.fk_id_num_commande = num_commande.id_num_commande
          
            $stringWhere
            GROUP BY id_num_commande;
           "
        );

        $query->setFetchMode(\PDO::FETCH_ASSOC);
        $query->execute($executearray);
        $result = $query->fetchall();
        return $result;
    }

    public function ResumeOrderAdmin()
    {

        $query = $this->db->prepare(
            "SELECT num_commande.date, num_commande.prix_avec_tva, num_commande.total_produit, num_commande.id_num_commande,

c1.nb_article, c1.prix_article, c1.prix_commande, c1.titre_article,


livraison.ville, livraison.voie, livraison.voie_sup, livraison.code_postal, 
livraison.prenom,livraison.nom_adresse,livraison.telephone,livraison.nom, livraison.email, 
livraison.fk_id_num_commande, livraison.pays, livraison.etat_livraison, livraison.id_livraison

            FROM num_commande 
            INNER JOIN commandes AS c1 ON c1.fk_id_num_commande = num_commande.id_num_commande 
            INNER JOIN livraison ON livraison.fk_id_num_commande = num_commande.id_num_commande
            
           "
        );

        $query->setFetchMode(\PDO::FETCH_ASSOC);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
}
