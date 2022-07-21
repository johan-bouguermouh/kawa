<?php

namespace App\Controllers\User;

use App\Controllers\Controller;

use App\Models\Adresses;
use App\Models\Utilisateurs;

class ModifierAdresseController extends Controller
{
    protected $model;

    public function index($id_adresse)
    {
        // $model = new Adresses();
        $title = "Modifier Adresse";
        $idAdresse = $id_adresse;
        $allInfoById = $this->getAdressebyId($idAdresse);
        return $this->view('profil/modifierAdresse', compact('title', 'idAdresse', 'allInfoById'));
    }

    public function getAdressebyId($id_adresse)
    {
        $model = new Adresses();
        $argument = ['id_adresse'];
        $adress = $model->find($argument, compact('id_adresse'));
        return $adress;
    }

    public function updateAdresse($id)
    {
        $model = new Adresses();
        $id_adresse = $id;


        if (isset($_POST['modifier'])) {
            $nom_adresse = $_POST['nomAdresse'];
            $ville = $_POST['ville'];
            $voie = $_POST['libelle'];
            $voie_sup = $_POST['voieSup'];
            $code_postal = $_POST['codePostal'];
            $telephone = $_POST['telephone'];
            $pays = $_POST['pays'];

            if (empty($nom_adresse) || empty($ville) || empty($voie) || empty($voie_sup) || empty($code_postal) || empty($telephone) || empty($pays)) {
                $_SESSION['flash']['erreur'] = "Oups ! Il faut renseigner des nouvelles informations !";
                // header('location: ./modifierProfil');
                echo "<SCRIPT LANGUAGE=\"JavaScript\"> document.location.href=\"./$id\" </SCRIPT>"; //force la direction
                exit;
            }

            $newAdresse = $model
                ->setNom_adresse($nom_adresse)
                ->setVille($ville)
                ->setVoie($voie)
                ->setVoie_sup($voie_sup)
                ->setCode_postal($code_postal)
                ->setTelephone($telephone)
                ->setPays($pays);

            $model->update($newAdresse, compact('id_adresse', 'nom_adresse', 'ville', 'voie', 'voie_sup', 'code_postal', 'telephone', 'pays'));
            echo "<SCRIPT LANGUAGE=\"JavaScript\"> document.location.href=\"./$id\" </SCRIPT>"; //force la direction

        }
    }

    public function deleteAdresse($id)
    {
        $model = new Adresses();
        $id_adresse = $id;

        if (isset($_POST['supprimer'])) {
            $deleteAdresse = $model->delete(compact('id_adresse'));
            echo "<SCRIPT LANGUAGE=\"JavaScript\"> document.location.href=\"/../kawa/profil/adresse\" </SCRIPT>"; //force la direction

        }
    }
}
