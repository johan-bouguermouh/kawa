<?php

namespace App\Controllers\admin;

use App\Models\Livraison;

use App\Models\NumCommande;
use App\Controllers\Controller;
use App\Controllers\Components\MenuAdminComponent;

class AdminOrderController extends Controller
{

    public function __construct()
    {
        $this->model = new Livraison();
        $this->modelNumCommande = new NumCommande();
    }

    public function index()
    {
        $title = "Admin commande en attente - Kawa";

        $livraison = $this->modelNumCommande->getAllOrderbyIdUser();

        $menuAdmin = MenuAdminComponent::Menu();

        $nb = $this->modelNumCommande->countWaitingValidate();

        $this->view('administrator/orderhistory/index', compact('title', 'livraison', 'nb', 'menuAdmin'));
    }

    public function update()
    {

        if (isset($_POST['submit'])) {

            $id_livraison = $_POST['id_livraison'];
            $etat_livraison = "confirme";
            $modelHydrate = $this->model
                ->setEtat_livraison($etat_livraison);
            $this->model->update($modelHydrate, compact('id_livraison', 'etat_livraison'));
            $_SESSION['flash']['sucess'] = "La commande est validée !";
            echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="./validercommande" </SCRIPT>'; //force la direction
            exit();
        }
    }
}
