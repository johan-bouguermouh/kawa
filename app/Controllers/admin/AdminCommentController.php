<?php

namespace App\Controllers\admin;

use Exception;

use App\Models\Articles;
use App\Models\Reponse_com;
use App\Models\Commentaires;
use App\Controllers\Controller;
use App\Controllers\Components\MenuAdminComponent;

class AdminCommentController extends Controller
{

    public function __construct()
    {
        $this->model = new Commentaires();
        $this->modelArticles = new Articles();
        $this->modelReponse_com = new Reponse_com();
    }

    public function index()
    {
        $title = "Admin commentaire - Kawa";

        $comment = $this->model->selectCommentwithArticleUser();
        $answers = $this->model->selectAnswerCommentwithArticleUser();

        //nombre semaines pour afficher les commentaires :
        $nombreofweek = "3";
        $commentCommunityManag = $this->model->selectCommentwithArticleUser($nombreofweek);
        $answersCommunityManag = $this->model->selectAnswerCommentwithArticleUser($nombreofweek);
        $articles = $this->modelArticles->findAll();

        $menuAdmin = MenuAdminComponent::Menu();

        $this->view('administrator/comment/index', compact('title', 'comment', 'articles', 'answers', 'commentCommunityManag', 'answersCommunityManag', 'menuAdmin'));
    }

    public function update()
    {
        if (isset($_POST['update_comment'])) {

            if (isset($_POST['comment'])) {

                if (empty($_POST['comment'])) {
                    $_SESSION['flash']['champsvides'] = "Le champ est vide !";
                    header('location: ./commentaire');
                    exit();
                }

                if (!empty($_POST['comment'])) {
                    $id_commentaire = $_POST['id_commentaire'];
                    $commentaire = $_POST['comment'];

                    $modelHydrate = $this->model
                        ->setCommentaire($commentaire);

                    $this->model->update($modelHydrate, compact('id_commentaire', 'commentaire'));
                    $_SESSION['flash']['sucess'] = "Le commentaire est modifié !";
                    header('location: ./commentaire');
                    exit();
                }
            }
        }

        if (isset($_POST['update_answer_comment'])) {

            if (isset($_POST['answer'])) {

                if (empty($_POST['answer'])) {
                    $_SESSION['flash']['champsvides'] = "Le champ est vide !";
                    header('location: ./commentaire');
                    exit();
                }

                if (!empty($_POST['answer'])) {
                    $id_reponse_com = $_POST['id_reponse_com'];
                    $commentaire = $_POST['answer'];

                    $modelHydrate = $this->modelReponse_com
                        ->setCommentaire($commentaire);

                    $this->modelReponse_com->update($modelHydrate, compact('id_reponse_com', 'commentaire'));
                    $_SESSION['flash']['sucess'] = "Le commentaire est modifié !";
                    header('location: ./commentaire');
                    exit();
                }
            }
        }
    }


    public function create()
    {
        if (isset($_POST['create_comment'])) {

            if (!empty($_POST['id_article']) && !empty($_POST['commentaire'])) {

                $commentaire = $_POST['commentaire'];
                $fk_id_article = $_POST['id_article'];
                $fk_id_utilisateur = $_SESSION['user']['id_utilisateur'];

                $modelHydrate = $this->model
                    ->setCommentaire($commentaire)
                    ->setFk_id_article($fk_id_article)
                    ->setFk_id_utilisateur($fk_id_utilisateur);
                $this->model->create($modelHydrate, compact('commentaire', 'fk_id_article', 'fk_id_utilisateur'));
                $_SESSION['flash']['sucess'] = "Le commentaire est créé !";

                header('location: ./commentaire');
                exit();
            }

            if (empty($_POST['id_article']) || empty($_POST['commentaire'])) {
                $_SESSION['flash']['champsvides'] = "Les champs sont vides !";
                header('location: ./commentaire');
                exit();
            }
        }
    }


    public function createAnswerAdmin()
    {
        if (isset($_POST['subAnswerAdmin'])) {

            if (!empty($_POST['fk_id_commentaire']) && !empty($_POST['answerAdmin'])) {

                $commentaire = $_POST['answerAdmin'];
                $fk_id_commentaire = $_POST['fk_id_commentaire'];
                $fk_id_utilisateur = $_SESSION['user']['id_utilisateur'];

                $modelHydrate =
                    $this->modelReponse_com
                    ->setCommentaire($commentaire)
                    ->setfk_id_commentaire($fk_id_commentaire)
                    ->setFk_id_utilisateur($fk_id_utilisateur);
                $this->modelReponse_com->create($modelHydrate, compact('commentaire', 'fk_id_commentaire', 'fk_id_utilisateur'));
                $_SESSION['flash']['sucess'] = "Le commentaire est créé !";

                header('location: ./commentaire');
                exit();
            }

            if (empty($_POST['fk_id_commentaire']) || empty($_POST['answerAdmin'])) {
                $_SESSION['flash']['champsvides'] = "Les champs sont vides teeeeeeest!";
                header('location: ./commentaire');
                exit();
            }
        }
    }

    public function createAnswerCom()
    {
        if (isset($_POST['subAnswerComAdmin'])) {

            if (!empty($_POST['fk_id_article']) && !empty($_POST['answerComAdmin'])) {

                $commentaire = $_POST['answerComAdmin'];
                $fk_id_article = $_POST['fk_id_article'];
                $fk_id_utilisateur = $_SESSION['user']['id_utilisateur'];

                $modelHydrate = $this->model
                    ->setCommentaire($commentaire)
                    ->setFk_id_article($fk_id_article)
                    ->setFk_id_utilisateur($fk_id_utilisateur);
                $this->model->create($modelHydrate, compact('commentaire', 'fk_id_article', 'fk_id_utilisateur'));
                $_SESSION['flash']['sucess'] = "Le commentaire est créé !";

                header('location: ./commentaire');
                exit();
            }

            if (empty($_POST['id_article']) || empty($_POST['commentaire'])) {
                $_SESSION['flash']['champsvides'] = "Les champs sont vides !";
                header('location: ./commentaire');
                exit();
            }
        }
    }



    public function  report()
    {
        if (isset($_POST['signaler'])) {
            $id_commentaire = $_POST['signaler'];
            $signaler = 0;
            $modelHydrate = $this->model
                ->setSignaler($signaler);
            $this->model->update($modelHydrate, compact('id_commentaire', 'signaler'));
            $_SESSION['flash']['success'] = "Retrait du signalement.";
            header('location: ./commentaire');
        }
    }

    public function  reportAnswer()
    {
        if (isset($_POST['reportAnswer'])) {
            $id_reponse_com = $_POST['reportAnswer'];
            $signaler = 0;
            $modelHydrate = $this->modelReponse_com
                ->setSignaler($signaler);
            $this->modelReponse_com->update($modelHydrate, compact('id_reponse_com', 'signaler'));
            $_SESSION['flash']['success'] = "Retrait du signalement.";
            header('location: ./commentaire');
        }
    }

    public function validateAnswerCom()
    {
        if (isset($_POST['validateAnswerCom'])) {
            $id_reponse_com = $_POST['id_reponse_com'];
            $check_admin = 1;
            $modelHydrate = $this->modelReponse_com
                ->setCheck_admin($check_admin);
            $this->modelReponse_com->update($modelHydrate, compact('id_reponse_com', 'check_admin'));
            $_SESSION['flash']['success'] = "Commentaire check.";
            header('location: ./commentaire');
        }
    }

    public function validateAnswer()
    {
        if (isset($_POST['validateCom'])) {
            $id_commentaire = $_POST['id_commentaire'];
            $check_admin = 1;
            $modelHydrate = $this->model
                ->setCheck_admin($check_admin);
            $this->model->update($modelHydrate, compact('id_commentaire', 'check_admin'));
            $_SESSION['flash']['success'] = "Commentaire check.";
            header('location: ./commentaire');
        }
    }

    public function delete()
    {
        if (isset($_POST['delete_comment'])) {

            $id_commentaire = $_POST['id_commentaire'];

            try {
                $this->model->delete(compact('id_commentaire'));
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            $_SESSION['flash']['delete'] = "Le commentaire est supprimé !";
            header('location: ./commentaire');
            exit();
        }

        if (isset($_POST['delete_answer_comment'])) {
            $id_reponse_com = $_POST['id_reponse_com'];
            $this->modelReponse_com->delete(compact('id_reponse_com'));

            try {
                $this->modelReponse_com->delete(compact('id_reponse_com'));
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            $_SESSION['flash']['delete'] = "Le commentaire est supprimé !";
            header('location: ./commentaire');
            exit();
        }
    }
}
