<?php

namespace App\Models;



use Database\DBConnection;
use PDO;

abstract class Model
{

    protected $db;
    protected $table;
    protected $id;



    public function __construct()
    {
        $this->db = DBConnection::getPDO();
    }



    // $sql comptient toute la requête et $attributs comptient autant d'attributs qu'il y a de point d'interrogation
    // Methode qui permet de faire une requete prepare ou non, en fonction
    public function requete(string $sql,  $attributs = null)
    {

        // On vérifie si on a des attributs
        if ($attributs !== null) {
            //Requête préparée
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            // Requête simple
            return $this->db->query($sql);
        }
    }

    public function requeteTransaction(string $sql, $connexion,  $attributs = null)
    {

        // On vérifie si on a des attributs
        if ($attributs !== null) {
            //Requête préparée
            $query = $connexion->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            // Requête simple
            return $connexion->query($sql);
        }
    }



    /**
     * La fonction prend trois params :
     * les deux premiers sont obligatoires, le troisième est optionnel.
     * 1er param '$criteres' = un tableau contenant 1 ou plusieurs noms de colonnes pour selectionner dans le WHERE.
     * 2eme param '$donnees' = envoyer dans un compact 1 ou plusieurs noms de colonnes : cela permet de faire la recherche en fonction de/des valeurs choisis dans le Where.
     * 
     * 3eme param optionnel '$selection' = tableau contenant 1 ou plusieurs colonnes permettant de filtrer le resultat de la requete.
     * 
     * Si le 3eme param n'est pas envoyé, la selection est sur l'ensemble des champs.
     */

    // Permet de récupperer un ou plusieur enregistrement en fonction de criteres
    public function find(array $criteres, array $donnees, ?array $selection = Null)
    {

        // Récupére la valeur
        $champs = [];

        // On boucle pour éclater le tableau
        foreach ($criteres as $valeur) {

            $champs[] = "$valeur = :$valeur";
            // valeur = valeur associé à l'index

        }
        // On transforme le tableau champs en une string
        $liste_champs = implode(' AND ', $champs);

        if ($selection == Null) {

            $req = "SELECT * FROM $this->table WHERE $liste_champs";


            // On exécute la requête 
            return $this->requete($req, $donnees)->fetchAll();
        } else {

            $liste_selections = implode(', ', $selection);


            // $selections[] = "$valeur";
            // valeur = valeur associé à l'index

            // On transforme le tableau champs en une string
            // $liste_selections = implode(',', $selections);
        }

        $req = "SELECT $liste_selections FROM $this->table WHERE $liste_champs";

        // On exécute la requête 
        return $this->requete($req, $donnees)->fetchAll();
    }

    public function findTransaction(array $criteres, array $donnees, $db, ?array $selection = Null)
    {

        // Récupére la valeur
        $champs = [];

        // On boucle pour éclater le tableau
        foreach ($criteres as $valeur) {

            $champs[] = "$valeur = :$valeur";
            // valeur = valeur associé à l'index

        }
        // On transforme le tableau champs en une string
        $liste_champs = implode(' AND ', $champs);

        if ($selection == Null) {

            $req = "SELECT * FROM $this->table WHERE $liste_champs FOR UPDATE";


            // On exécute la requête 
            return $this->requeteTransaction($req, $db, $donnees)->fetchAll();
        } else {

            $liste_selections = implode(', ', $selection);


            // $selections[] = "$valeur";
            // valeur = valeur associé à l'index

            // On transforme le tableau champs en une string
            // $liste_selections = implode(',', $selections);
        }

        $req = "SELECT $liste_selections FROM $this->table WHERE $liste_champs FOR UPDATE";

        // On exécute la requête 
        return $this->requeteTransaction($req, $db, $donnees)->fetchAll();
    }



    /**
     * Methode qui permet de récupérer tout les enregistrements d'une table
     *
     * @return array
     */
    public function findAll()
    {
        $req = "SELECT * FROM  {$this->table}";
        $query = $this->requete($req);
        return $query->fetchAll();
    }

    // HYDRATATION
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            // On récupère le nom du setter correspondant à la clé(key)
            // titre -> setTitre
            $setter = 'set' . ucfirst($key);
            // On vérifie si le setter existe
            if (method_exists($this, $setter)) {
                // On appelle le setter
                $this->$setter($value);
            }
        }
        return $this;
    }


    // CREATE
    /**
     * La fonction prend deux params :
     * les deux premiers sont obligatoires.
     * 1er param '$model' = il faut hydrater les setter que nous souhaitons :  exemple    
     *  $model = new ExempleModel($this->getDB());
            $model_Article = $model
            ->setId_article($id_article)
             ->setTitre_article($titre_article);
             ...
     * 2eme param '$donnees' = envoyer dans un compact 1 ou plusieurs noms de colonnes : cela permet de modifier les champs.
     */
    public function create(Model $model, array $donnees)
    {
        // Récupére l'index
        $champs = [];
        // liste des points d'intérogation pour la requête aussi long que la listre des champs
        $inter = [];


        // On boucle pour éclater le tableau
        foreach ($model as $champ => $valeur) {
            if ($valeur !== null && $champ != 'db' && $champ != 'table' && $champ != 'id' && $champ != "$this->id") {
                // Champ = index
                $champs[] = $champ;
                $inter[] = ":$champ";
            }
        }
        // On transforme le tableau champs en string
        $liste_champs = implode(', ', $champs);
        $liste_inter = implode(', ', $inter);


        $req = 'INSERT INTO ' . $this->table . ' (' . $liste_champs . ') VALUES (' . $liste_inter . ')';

        // On exécute la requête 
        return $this->requete($req, $donnees);
    }


    public function createTransaction(Model $model, array $donnees, $connexion)
    {
        // Récupére l'index
        $champs = [];
        // liste des points d'intérogation pour la requête aussi long que la listre des champs
        $inter = [];


        // On boucle pour éclater le tableau
        foreach ($model as $champ => $valeur) {
            if ($valeur !== null && $champ != 'db' && $champ != 'table' && $champ != 'id' && $champ != "$this->id") {
                // Champ = index
                $champs[] = $champ;
                $inter[] = ":$champ";
            }
        }
        // On transforme le tableau champs en string
        $liste_champs = implode(', ', $champs);
        $liste_inter = implode(', ', $inter);


        $req = 'INSERT INTO ' . $this->table . ' (' . $liste_champs . ') VALUES (' . $liste_inter . ')';

        // On exécute la requête 
        return $this->requeteTransaction($req, $connexion, $donnees);
    }


    public function update(model $model, array $donnees)
    {

        // Récupére l'index
        $champs = [];


        // On boucle pour éclater le tableau
        foreach ($model as $champ => $valeur) {
            if ($valeur !== null && $champ != 'db' && $champ != 'table' && $champ != 'id' && $champ != "$this->id") {
                // Champ = index
                $champs[] = " $champ = :$champ";
            }
        }

        // On transforme le tableau champs en string
        $liste_champs = implode(',', $champs);


        // On exécute la requête 
        $req = "UPDATE  $this->table SET $liste_champs WHERE {$this->id} = :{$this->id}";
        return $this->requete($req, $donnees);
    }

    // DELETE
    public function delete(array $donnees = Null)
    {
        $req = "DELETE FROM {$this->table} WHERE {$this->id} =:{$this->id} AND `role` = 'Utilisateurs'";
        return $this->requete($req, $donnees);
    }
}
