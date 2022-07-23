<?php


namespace App\Controllers;


use App\Models\Articles;


class ShoppingCartController extends Controller
{

    public function __construct()
    {

        $this->modelArticle = new Articles();
    }

    public function index()
    {
        $articles = $this->modelArticle->findAll();
        $title = "panier";
        return compact('articles', 'title'/* , 'totalQuantity' */);
    }

    public function shoppingBag()
    {

        if (isset($_POST['add'])) {
            if (isset($_SESSION['quantite'])) {
                // assignation valeur
                $id_article =  (int) $_POST['id_article'];
                $prix_article =  (float) $_POST['prix_article'];

                $_SESSION['quantite'][$id_article] = 1;
                $_SESSION['prix'][$id_article] = $prix_article;
            } else {
                //init session
                $_SESSION['quantite'] = [];
                $_SESSION['prix'] = [];


                // assignation valeur

                $prix_article =  (float) $_POST['prix_article'];
                $id_article =  (int) $_POST['id_article'];
                $_SESSION['quantite'][$id_article] = 1;
                $_SESSION['prix'][$id_article] = $prix_article;
            }

            $_SESSION['productAddInShop']['sucess'] = "Le produit est ajouté au panier !";



            header('refresh: 0');
            header('refresh: 0');
            exit();
        }
    }


    public function upValue()
    {
        if (isset($_POST['upQuantity'])) {

            $up =  $_POST['upQuantity'];
            $id_article =  (int) $_POST['id_article'];
            $argument = ['id_article'];

            $checkQuantity = [];

            $checkQuantity[$id_article] = $this->modelArticle->find($argument, compact('id_article'));


            if (($_SESSION['quantite'][$id_article] + $up)  <= $checkQuantity[$id_article][0]['sku']) {
                $_SESSION['quantite'][$id_article] = $_SESSION['quantite'][$id_article] + $up;
            } else {
                $_SESSION['flash']['quantity'] = "Le stock est vide !";
            }

            header('refresh: 0');
        }
    }

    public function downValue()
    {

        if (isset($_POST['downQuantity'])) {

            $down =  $_POST['downQuantity'];
            $id_article =  (int) $_POST['id_article'];

            $_SESSION['quantite'][$id_article] = $_SESSION['quantite'][$id_article] - $down;

            header('refresh: 0');
        }
    }

    public function deleteProduct()
    {
        if (isset($_POST['deleteProduct'])) {
            unset($_SESSION['quantite'][(int) $_POST['id_article']]);
            unset($_SESSION['prix'][(int) $_POST['id_article']]);
            header('refresh: 0');
        }
    }


    public function singlePrice()
    {

        if (isset($_SESSION['quantite'])) {
            $_SESSION['singlePrice'] = [];

            $result = 0;
            foreach ($_SESSION['quantite'] as $key1 => $value1) {
                foreach ($_SESSION['prix'] as $key2 => $value2) {
                    if ($key1 == $key2) {

                        $result = $value1 * $value2;


                        $_SESSION['singlePrice'][$key1]  = $result;
                    }
                }
            }
        }
    }
    public function totalQuantity()
    {
        if (isset($_SESSION['quantite'])) {
            $_SESSION['totalQuantity'] = 0;
            foreach ($_SESSION['quantite'] as $quantite) {
                $_SESSION['totalQuantity'] += $quantite;
            }
        };

        /* return $_SESSION['totalQuantity'] */
    }

    public function totalPrice()
    {

        if (isset($_SESSION['quantite'])) {
            $_SESSION['totalPrice'] = [];

            $result = 0;
            foreach ($_SESSION['quantite'] as $key1 => $value1) {
                foreach ($_SESSION['prix'] as $key2 => $value2) {
                    if ($key1 == $key2) {

                        $resultSinglePrice = $value1 * $value2;
                        $result += $resultSinglePrice;

                        $_SESSION['totalPrice'] = $result;
                    }
                }
            }
        }
    }

    public function delivery()
    {
        if (isset($_POST['goDelivery'])) {
            /*  header('location: ./livraison'); */
            echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="/kawa/livraison" </SCRIPT>'; //force la direction

        }
    }
}
