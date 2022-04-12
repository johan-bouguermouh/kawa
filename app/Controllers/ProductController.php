<?php

namespace App\controllers;

use App\models\Categories;
use App\models\Product;
use App\models\Commentaires;
use App\models\Like;
use App\models\Reponse_com;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->Comments = new Commentaires();
        $this->Product = new Product();
        $this->Categories = new Categories();
        $this->Like = new Like();
        $this->AnswerCom = new Reponse_com();
    }

    public function index($id_article)
    {
        $title = "Produit";

        $comments = $this->comAssociate($id_article);
        $numberOfComment = $this->NumberComment($id_article);
        $product = $this->getProductById($id_article);
        $likes = $this->getLike($id_article);
        $this->Like($id_article);
        $this->addComment($id_article);

        $CatOfProduct = array(
            'variete' => $this->Categories->getSectionCatByIdProduct($id_article, 'VARIÉTÉ'),
            'specificite' => $this->Categories->getSectionCatByIdProduct($id_article, 'SPÉCIFICITÉ'),
            'flavor' => $this->Categories->getSectionCatByIdProduct($id_article, 'SAVEUR'),
            'strong' => $this->Categories->getSectionCatByIdProduct($id_article, 'FORCE'),
            'origin' => $this->Categories->getSectionCatByIdProduct($id_article, 'PROVENENCE')
        );
        /* $this->addComment($id_article); */
        $prix_article = $product[0]['prix_article'];
        $this->shoppingBag($id_article, $prix_article);

        return $this->view('shop.produit', compact('title', 'comments', 'product', 'CatOfProduct', 'likes', 'numberOfComment'));
    }

    public function getProductById($id_article)
    {
        $result = $this->Product->find(['id_article'], compact('id_article'));
        return $result;
    }

    public function comAssociate($id)
    {

        $id_article = $id;
        $comments = $this->Comments->getCommentbyId($id_article);
        $answerComments = $this->Comments->getAnswerById($id_article);

        foreach ($comments as $key => $comment) {
            $i = 0;
            $j = 0;
            foreach ($answerComments as $answerComment) {

                if ($comment['fk_id_commentaire'] == $comment['id_commentaire']) {

                    if ($answerComment['fk_id_commentaire'] == $comment['fk_id_commentaire']) {
                        $comments[$key][$i++] = $answerComment;
                    }
                }
            }
        }


        return $comments;
    }


    public function getCatByIdProduct($id_article)
    {
        $result = $this->Categories->getSectionCatByIdProduct($id_article);
        return $result;
    }

    public function pushAnswerCom($id_article)
    {
        if (isset($_POST['submitAnswer'])) {
            if (!isset($_SESSION['user'])) {
                $_SESSION['flash']['sucess'] = "Connectez-vous pour commenter.";
                /*  header("location: ./$id_article"); */

                echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="' . "./$id_article" . '" </SCRIPT>'; //force la direction
                exit();
            }

            if (isset($_SESSION['user'])) {


                $commentaire = $_POST['comment'];
                if (!empty($commentaire)) {
                    $fk_id_commentaire = $_POST['id_commentaire'];
                    $fk_id_utilisateur = $_SESSION['user']['id_utilisateur'];


                    $date = date('Y-m-d H:i:s');
                    $modelHydrate = $this->AnswerCom
                        ->setCommentaire($commentaire)
                        ->setFk_id_commentaire($fk_id_commentaire)
                        ->setFk_id_utilisateur($fk_id_utilisateur)
                        ->setDate($date);
                    $this->AnswerCom->create($modelHydrate, compact('commentaire', 'fk_id_commentaire', 'fk_id_utilisateur', 'date'));
                    $_SESSION['flash']['sucess'] = "Votre  réponse est postée.";
                    header("location: ./$id_article");
                    exit();
                }

                if (empty($commentaire)) {
                    $_SESSION['flash']['error'] = "Vous devez remplir le champs.";
                    header("location: ./$id_article");
                    exit();
                }
            }
        }
    }

    public function  report($id_article)
    {
        if (isset($_POST['signaler'])) {
            $id_commentaire = $_POST['signalement'];
            $signaler = 1;
            $modelHydrate = $this->Comments
                ->setSignaler($signaler);
            $this->Comments->update($modelHydrate, compact('id_commentaire', 'signaler'));
            $_SESSION['flash']['success'] = "Signalement enregistré.";
            echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="' . "./$id_article" . '" </SCRIPT>'; //force la direction
            exit();
        }
    }

    public function  reportAnswer($id_article)
    {
        if (isset($_POST['reportAnswer'])) {
            $id_reponse_com = $_POST['idReportAnswer'];
            $signaler = 1;
            $modelHydrate = $this->AnswerCom
                ->setSignaler($signaler);
            $this->AnswerCom->update($modelHydrate, compact('id_reponse_com', 'signaler'));
            $_SESSION['flash']['success'] = "Signalement enregistré.";
            echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="' . "./$id_article" . '" </SCRIPT>'; //force la direction
            exit();
        }
    }

    public function addComment($id_article)
    {
        if (isset($_POST['submit'])) {

            if (isset($_SESSION['user'])) {
                $fk_id_utilisateur = $_SESSION['user']['id_utilisateur'];
                $commentaire = $_POST['com'];
                if (!$commentaire) {
                    $_SESSION['flash']['error'] = "Il faut écrire du contenu pour laisser un commentaire.";
                    header("location: ./$id_article");
                    exit();
                } else {
                    $fk_id_article = $id_article;
                    $date = date('Y-m-d H:i:s');
                    $modelHydrate = $this->Comments
                        ->setCommentaire($commentaire)
                        ->setFk_id_article($fk_id_article)
                        ->setFk_id_utilisateur($fk_id_utilisateur)
                        ->setDate($date);
                    $this->Comments->create($modelHydrate, compact('commentaire', 'fk_id_article', 'fk_id_utilisateur', 'date'));
                }

                $_SESSION['flash']['sucess'] = "Commentaire posté.";

                header("location: ./$id_article");
                exit();
            }
        }
    }


    public function NumberComment($id_article)
    {
        $result = $this->Comments->getNumberOfComment($id_article);
        return $result;
    }

    public function getLike($id_article)
    {
        $result = $this->Like->getLikeByArticle($id_article);
        return $result;
    }

    public function Like($id_article)
    {

        if (isset($_POST['like'])) {
            if (!isset($_SESSION['user'])) {
                $_SESSION['flash']['sucess'] = "Il vous faut un compte utilisateur pour liker un produit :)";
                header("Refresh:0");
                exit();
            } else {

                $argument = ['id_utilisateur'];
                $fk_id_utilisateur = @$_SESSION['user']['id_utilisateur'];
                $fk_id_article = $id_article;
                $checkLike = $this->Like->getLike($fk_id_utilisateur);
                if ($checkLike == false) {
                    $this->Like->insertLike($id_article, $fk_id_utilisateur);
                    header("Refresh:0");
                } else {
                    $this->Like->deleteLike($id_article, $fk_id_utilisateur);
                    header("Refresh:0");
                }
            }
        }
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
            // header('location: ../panier'); test d'ajout panier sur le Layout
        }
    }
}
