<?php

namespace App\controllers;

use App\models\Utilisateurs;

class InscriptionController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new Utilisateurs();
    }

    public function index()
    {
        $title = "Inscription";

        return $this->view('profil.inscription', compact('title'));
    }

    public function SignUp()
    {
        if ($this->Validate() == true) {

            $prenom = $_POST['prenom'];
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $question_secrete = $_POST['question_secrete'];
            $reponse = $_POST['reponse'];
            $password = $_POST['mdp'];
            $mdpConfirm = $_POST['mdpConfirm'];

            $password = password_hash($password, PASSWORD_DEFAULT);
            $reponse = password_hash($reponse, PASSWORD_DEFAULT);
            $role = "Utilisateurs";
            $user = $this->model
                ->setEmail($email)
                ->setPrenom($prenom)
                ->setNom($nom)
                ->setPassword($password)
                ->setQuestion_secrete($question_secrete)
                ->setReponse($reponse)
                ->setRole($role);
            $this->model->create($user, compact('email', 'prenom', 'nom', 'password', 'question_secrete', 'reponse', 'role'));


            $_SESSION['flash']['sucess'] = "Bravo vous êtes à présent inscrit, vous pouvez maintenant vous connectez";
            // header('Location: ./connexion');
            echo "<SCRIPT LANGUAGE=\"JavaScript\"> document.location.href=\"./connexion\" </SCRIPT>"; //force la direction
            exit();
        }
    }


    public function Validate()
    {

        if (isset($_POST['submit'])) {
            $prenom = $_POST['prenom'];
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $question_secrete = $_POST['question_secrete'];
            $reponse = $_POST['reponse'];
            $password = $_POST['mdp'];
            $mdpConfirm = $_POST['mdpConfirm'];

            $requis = array(
                'prenom',
                'nom',
                'email',
                'question_secrete',
                'reponse',
                'mdp',
                'mdpConfirm'
            );

            $erreur = false;
            foreach ($requis as $champs) {
                if (empty($_POST[$champs])) {
                    $erreur = true;
                }
            }
            $argument = ['email'];
            $checkEmail = $this->model->find($argument, compact('email'));

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['flash']['erreur'][0] = "Mauvais format d'email.";
            }

            if ($checkEmail == TRUE) {
                $_SESSION['flash']['erreur'][1] = "Oups ! L'email n'est pas disponible";
                // header('location: ./inscription');
                $erreur = true;
            } elseif ($erreur) {
                $_SESSION['flash']['erreur'][2] = "Oups ! Vous devez remplir tout les champs !";
                // header('location: ./inscription');
            } elseif ($password != $mdpConfirm) {
                $_SESSION['flash']['erreur'][3] = "Oups ! Vos mots de passe doivent être similaires !";
                // header('location: ./inscription');


            }
            if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%.]{6,12}$/', $password)) {
                $_SESSION['flash']['erreur'][4] =
                    "Peut contenir des lettres et des nombres,
                    Doit contenir au moins 1 chiffre et 1 lettre,
                    Peut contenir l'un de ces caractères: !@#$%.,
                    Doit être de 6 à 12 caractères";
            }
        }
        if (!isset($_SESSION['flash']['erreur'])) {
            return true;
        } else {
            echo "<SCRIPT LANGUAGE=\"JavaScript\"> document.location.href=\"./inscription\" </SCRIPT>"; //force la direction
        }
    }
}
