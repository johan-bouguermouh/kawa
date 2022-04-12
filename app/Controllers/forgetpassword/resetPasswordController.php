<?php

namespace App\controllers\forgetpassword;

use App\controllers\Controller;

use App\models\Utilisateurs;

class resetPasswordController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new Utilisateurs();
    }
    public function index()
    {
        $title = "reset password";

        return $this->view('resetpassword.resetPassword', compact('title'));
    }

    public function resetPassword()
    {
        if (isset($_POST['submit'])) {
            $reponse = $_POST['reponse'];
            $mdp = $_POST['mdp'];
            $mdpConfirm = $_POST['mdpConfirm'];

            if (empty($reponse) || empty($mdp)) {
                $_SESSION['flash']['remplir'] = "Oups ! Veuillez remplir tout les champs";
                echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="./resetpassword" </SCRIPT>'; //force la direction
            } elseif ($mdp != $mdpConfirm) {
                $_SESSION['flash']['mdp'] = "Oups ! Vos mots de passe doivent être similaires !";
                echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="./resetpassword" </SCRIPT>'; //force la direction

            }

            if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%.]{6,12}$/', $mdp)) {
                $_SESSION['flash']['remplir'] =
                    "Peut contenir des lettres et des nombres,
                    Doit contenir au moins 1 chiffre et 1 lettre,
Peut contenir l'un de ces caractères: !@#$%.,
Doit être de 6 à 12 caractères";
            } else {
                $email = $_SESSION['reset']['email'];
                $argument = ['email'];
                $checkUser = $this->model->find($argument, compact('email'));
                if (password_verify(@$reponse, @$checkUser[0]['reponse'])) {
                    $password = password_hash($mdp, PASSWORD_DEFAULT);

                    $user = $this->model
                        ->setId_utilisateur((int)$checkUser[0]['id_utilisateur'])
                        ->setPassword($password);
                    $id_utilisateur = (int)$checkUser[0]['id_utilisateur'];
                    $this->model->update($user, compact('id_utilisateur', 'password'));

                    echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="./connexion" </SCRIPT>'; //force la direction

                } else {

                    $_SESSION['flash']['erreur'] = "Oups ! La réponse est fausse !";
                }
            }

            echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="./resetpassword" </SCRIPT>'; //force la direction

        }
    }
}
