<?php

namespace App\Controllers\admin;

use App\Models\Utilisateurs;

use App\Controllers\Controller;
use App\Controllers\Components\MenuAdminComponent;

class AdminUpdateUserController extends Controller
{
    protected $model;

    public function index($param)
    {
        $title = "Admin || Gestion utilisateur";
        $users = $this->getAllUser();
        $deleteUser = $this->deleteUser($param);
        $updateUser = $this->updateUser($param);
        $userInfos = $this->getUser($param);

        $menuAdmin = MenuAdminComponent::Menu();

        $this->view('administrator.updateUser', compact('title', 'users', 'param', 'userInfos', 'menuAdmin'));
    }

    public function getAllUser()
    {
        $model = new Utilisateurs();

        $query = $model->findAll();
        return $query;
    }

    public function getUser($id_utilisateur)
    {
        $model = new Utilisateurs();
        $argument = ['id_utilisateur'];
        $user = $model->find($argument, compact('id_utilisateur'));
        return $user;
    }

    public function deleteUser($id)
    {
        $model = new Utilisateurs();
        $id_utilisateur = $id;

        if (isset($_POST['supprimer'])) {
            $deleteUser = $model->delete(compact('id_utilisateur'));
            $_SESSION['flash']['erreur'] = "L'utilisateur a bien été supprimé";
            header('location: ../gestionUtilisateur/liste');
            exit();
        }
    }

    public function UpdateUser($id)
    {
        $model = new Utilisateurs();
        $id_utilisateur = $id;
        $actualPassword = $this->getUser($id);


        if (isset($_POST['modifier'])) {
            $email = $_POST['email'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            $updateUser = $model;

            if (empty($password)) {
                $password = $actualPassword[0]['password'];
                $updateUser = $model
                    ->setEmail($email)
                    ->setNom($nom)
                    ->setPrenom($prenom)
                    ->setPassword($password)
                    ->setRole($role);
            } else {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $updateUser = $model
                    ->setEmail($email)
                    ->setNom($nom)
                    ->setPrenom($prenom)
                    ->setPassword($password)
                    ->setRole($role);
            }

            $model->update($updateUser, compact('email', 'nom', 'prenom', 'password', 'role', 'id_utilisateur'));
            $_SESSION['flash']['erreur'] = "L'utilisateur a bien été modifié";
            header('location: ../gestionUtilisateur/liste');
            exit();
        }
    }
}
