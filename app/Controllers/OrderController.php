<?php


namespace App\Controllers;


use App\Models\Articles;
use App\Models\Utilisateurs;


class OrderController extends Controller
{

    public function __construct()
    {
        $this->model = new Utilisateurs();
        $this->modelArticle = new Articles();
    }


    public function index()
    {
        if (isset($_SESSION['user'])) {
            $id = $_SESSION['user']['id_utilisateur'];
            $info_user = $this->getUser($id);
            $orderCheck = $this->orderResume();
            $title = "Commande resumé - Kawa";
        } else {
            $_SESSION['flash']['noConnect'] = 'Connectez-vous pour valider votre commande';
            $_SESSION['referer'] = $_SERVER['REQUEST_URI'];
            echo "<SCRIPT LANGUAGE=\"JavaScript\"> document.location.href=\"./connexion\" </SCRIPT>"; //force la direction
            exit();
        }


        return $this->view('shop.order', compact('title', 'info_user', 'orderCheck'));
    }

    public function getUser($id)
    {
        $id_utilisateur = $id;

        $argument = ['id_utilisateur'];
        $resultat = $this->model->find($argument, compact('id_utilisateur'));


        return $resultat;
    }


    public function orderResume()
    {
        $checkQuantity = [];

        $argument = ['id_article'];
        foreach ($_SESSION['quantite'] as $id_article => $value) {
            $checkQuantity[$id_article] = $this->modelArticle->find($argument, compact('id_article'));
            /*        foreach ($_SESSION['quantite'] as $key2 => $value2) {
            } */
        }

        return $checkQuantity;
    }


    public function validate()
    {
        if (isset($_POST['submit'])) {
            /*  header('location: ./livraison'); */
            echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="./livraison" </SCRIPT>'; //force la direction

        }
    }
}
