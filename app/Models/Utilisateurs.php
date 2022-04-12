<?php

namespace App\models;

class Utilisateurs extends Model
{
    protected $table = 'utilisateurs';
    protected $id = "id_utilisateur";
    protected $id_utilisateur;
    protected $email;
    protected $prenom;
    protected $nom;
    protected $password;
    protected $role;
    protected $question_secrete;
    protected $reponse;

    /**
     * Get the value of id_utilisateur
     */
    public function getId_utilisateur()
    {
        return $this->id_utilisateur;
    }

    /**
     * Set the value of id_utilisateur
     *
     * @return  self
     */
    public function setId_utilisateur($id_utilisateur)
    {
        $this->id_utilisateur = $id_utilisateur;

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
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of question_secrete
     */
    public function getQuestion_secrete()
    {
        return $this->question_secrete;
    }

    /**
     * Set the value of question_secrete
     *
     * @return  self
     */
    public function setQuestion_secrete($question_secrete)
    {
        $this->question_secrete = $question_secrete;

        return $this;
    }

    /**
     * Get the value of reponse
     */
    public function getReponse()
    {
        return $this->reponse;
    }

    /**
     * Set the value of reponse
     *
     * @return  self
     */
    public function setReponse($reponse)
    {
        $this->reponse = $reponse;

        return $this;
    }
}
