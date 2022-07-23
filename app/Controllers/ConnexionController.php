<?php

namespace App\Controllers;

use App\Models\Utilisateurs;

class ConnexionController extends Controller
{
    protected $model;

    public function index()
    {
        $title = "Connexion";
        $refererPath = explode('/', $_SERVER['HTTP_REFERER'])[4];
               if ($refererPath !== 'connexion' && $refererPath !== 'Admin') {
            $_SESSION['reload'] = $_SERVER['HTTP_REFERER'];
        }
        return $this->view('profil.connexion', compact('title'));
    }

    public function login()
    {
        $model = new Utilisateurs();

        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];

            if (empty($email) || empty($mdp)) {
                $_SESSION['flash']['erreur'] = "Oups ! Veuillez remplir tout les champs";
                echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="./connexion" </SCRIPT>'; //force la direction

            } else {

                $argument = ['email'];
                $checkUser = $model->find($argument, compact('email'));
                if (password_verify(@$mdp, @$checkUser[0]['password'])) {
                    $user = $model
                        ->setId_utilisateur((int)$checkUser[0]['id_utilisateur'])
                        ->setPrenom($checkUser[0]['prenom'])
                        ->setNom($checkUser[0]['nom'])
                        ->setEmail($checkUser[0]['email'])
                        ->setPassword($checkUser[0]['password'])
                        ->setRole($checkUser[0]['role']);

                    $_SESSION['user']['id_utilisateur'] = (int)$user->getId_utilisateur();
                    $_SESSION['user']['prenom'] = $user->getPrenom();
                    $_SESSION['user']['nom'] = $user->getNom();
                    $_SESSION['user']['email'] = $user->getEmail();
                    $_SESSION['user']['password'] = $user->getPassword();
                    $_SESSION['user']['role'] = $user->getRole();
                    // var_dump($user);
                    // header('Location: ./profil');
                    if (isset($_SESSION['referer'])) {
                        echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="' . $_SESSION['referer'] . '" </SCRIPT>'; //force la direction
                        // unset($_SESSION['referer']);
                        exit();
                    } elseif (explode('/', $_SESSION['reload'])[4] !== 'inscription') {
                        echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="' . $_SESSION['reload'] . '" </SCRIPT>'; //force la direction
                        unset($_SESSION['reload']);
                        exit();
                    } else {
                        echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="./profil" </SCRIPT>'; //force la direction
                        exit();
                    }
                } else {
                    $_SESSION['flash']['erreur'] = "Oups ! Le mot de passe ou l'email est incorrect";
                    echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="./connexion" </SCRIPT>'; //force la direction
                }
            }
        }
    }
}
