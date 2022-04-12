<?php

namespace App\controllers\admin;

use App\controllers\Controller;

use App\models\Categories;

class AdminCategoryController extends Controller
{

    public function __construct()
    {
        $this->model = new Categories();
    }

    public function index()
    {
        $title = "Admin category - Kawa";

        $category = $this->model->findAll();

        $this->view('administrator/category/index', compact('title', 'category'));
    }

    public function update()
    {

        if (isset($_POST['update_cat'])) {


            if (isset($_POST['section']) || isset($_POST['nom_categorie'])) {

                if (empty($_POST['nom_categorie']) || empty($_POST['section'])) {
                    $_SESSION['flash']['champsvides'] = "Les champs sont vides !";
                    header('location: ./categorie');
                    exit();
                }

                if (!empty($_POST['section'])  || !empty($_POST['nom_categorie'])) {
                    $id_categorie = $_POST['id_categorie'];
                    $nom_categorie = $_POST['nom_categorie'];
                    $section = $_POST['section'];

                    $modelHydrate = $this->model
                        ->setNom_categorie($nom_categorie)
                        ->setSection($section);
                    $this->model->update($modelHydrate, compact('id_categorie', 'section', 'nom_categorie'));
                    $_SESSION['flash']['sucess'] = "La catégorie est modifié !";
                    header('location: ./categorie');
                    exit();
                }
            }
        }
    }


    public function create()
    {
        if (isset($_POST['create_cat'])) {

            if (empty($_POST['nom_categorie']) || empty($_POST['section'])) {
                $_SESSION['flash']['champsvides'] = "Les champs sont vides !";
                header('location: ./categorie');
                exit();
            }
            $nom_categorie = $_POST['nom_categorie'];
            $section = $_POST['section'];
            $modelHydrate = $this->model
                ->setNom_categorie($nom_categorie)
                ->setSection($section);
            $this->model->create($modelHydrate, compact('nom_categorie', 'section'));
            $_SESSION['flash']['sucess'] = "La catégorie est crée !";
            header('location: ./categorie');
        }
    }


    public function delete()
    {
        if (isset($_POST['delete_cat'])) {
            $id_categorie = $_POST['id_categorie'];
            $this->model->delete(compact('id_categorie'));
            $_SESSION['flash']['delete'] = "La catégorie est supprimé !";
            header('location: ./categorie');
        }
    }
}
