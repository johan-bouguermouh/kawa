<?php

namespace App\controllers\forgetpassword;

use App\controllers\Controller;

use App\models\Utilisateurs;

class checkEmailController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new Utilisateurs();
    }
    public function index()
    {
        $title = "reset password";
        /*        $refererPath = explode('/', $_SERVER['HTTP_REFERER'])[4];
        if ($refererPath !== 'connexion' && $refererPath !== 'admin') {
            $_SESSION['reload'] = $_SERVER['HTTP_REFERER'];
        } */
        return $this->view('resetpassword.checkEmail', compact('title'));
    }

    public function checkLogin()
    {
        $model = new Utilisateurs();

        if (isset($_POST['submit'])) {
            $email = $_POST['emailVerify'];


            if (empty($email)) {
                $_SESSION['flash']['erreur'] = "Oups ! Veuillez remplir tout les champs";
                echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="./checkemail" </SCRIPT>'; //force la direction
            } else {

                $argument = ['email'];
                $checkUser = $model->find($argument, compact('email'));
                if ($checkUser) {
                    $user = $model
                        ->setId_utilisateur((int)$checkUser[0]['id_utilisateur'])
                        ->setEmail($checkUser[0]['email'])
                        ->setQuestion_secrete($checkUser[0]['question_secrete']);

                    $_SESSION['reset']['id_utilisateur'] = (int)$user->getId_utilisateur();
                    $_SESSION['reset']['question'] = $user->getQuestion_secrete();
                    $_SESSION['reset']['email'] = $user->getEmail();
                    echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="./resetpassword" </SCRIPT>'; //force la direction

                } else {
                    $_SESSION['flash']['erreur'] = "Oups ! l'email est incorrect";
                    echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="./checkemail" </SCRIPT>'; //force la direction
                }
            }
        }
    }
}
