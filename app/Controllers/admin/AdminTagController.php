<?php

namespace App\Controllers\admin;

use App\Models\Tag;

use App\Controllers\Controller;

use App\Controllers\Components\MenuAdminComponent;



class AdminTagController extends Controller
{

    public function __construct()
    {
        $this->model = new Tag();
    }

    public function index()
    {
        $title = "Admin tag - Kawa";

        $tag = $this->model->findAll();

        $menuAdmin = MenuAdminComponent::Menu();

        $this->view('administrator/tag/index', compact('title', 'tag', 'menuAdmin'));
    }

    public function update()
    {
        if (isset($_POST['update_tag'])) {


            if (isset($_POST['nom_tag'])) {

                if (empty($_POST['nom_tag'])) {
                    $_SESSION['flash']['champsvides'] = "Les champs sont vides !";
                    header('location: ./tag');
                    exit();
                }


                if (!empty($_POST['nom_tag'])) {
                    $id_tag = $_POST['id_tag'];
                    $nom_tag = $_POST['nom_tag'];


                    $modelHydrate = $this->model
                        ->setNom_tag($nom_tag);

                    $this->model->update($modelHydrate, compact('id_tag', 'section', 'nom_tag'));
                    $_SESSION['flash']['sucess'] = "Le tag est modifié !";
                    header('location: ./tag');
                    exit();
                }
            }
        }
    }


    public function create()
    {
        if (isset($_POST['create_tag'])) {

            if (empty($_POST['nom_tag'])) {
                $_SESSION['flash']['champsvides'] = "Les champs sont vides !";
                header('location: ./tag');
                exit();
            }

            $nom_tag = $_POST['nom_tag'];
            $modelHydrate = $this->model
                ->setNom_tag($nom_tag);
            $this->model->create($modelHydrate, compact('nom_tag'));
            $_SESSION['flash']['sucess'] = "Le tag est créé !";
            header('location: ./tag');
        }
    }


    public function delete()
    {
        if (isset($_POST['delete_tag'])) {
            $id_tag = $_POST['id_tag'];
            $this->model->delete(compact('id_tag'));
            $_SESSION['flash']['delete'] = "Le tag est supprimé !";
            header('location: ./tag');
        }
    }
}
