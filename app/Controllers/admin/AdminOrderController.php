<?php

namespace App\Controllers\admin;

use App\models\Commandes;

use App\models\Livraison;
use App\models\NumCommande;
use App\controllers\Controller;

class AdminOrderController extends Controller
{

    public function __construct()
    {
        $this->model = new Livraison();
        $this->modelNumCommande = new NumCommande();
        $this->modelCommande = new Commandes();
    }

    public function index()
    {
        $title = "Admin commande en attente - Kawa";

        $livraison = $this->modelNumCommande->getAllOrderbyIdUser();
        $ResumeOrder = $this->modelNumCommande->ResumeOrderAdmin();


        $nb = $this->modelNumCommande->countWaitingValidate();

        $this->view('administrator/orderhistory/index', compact('title', 'livraison', 'nb', 'ResumeOrder'));
    }

    public function indexResume($id)
    {
        $title = "Admin résumé commande - Kawa";
        $resume = $this->resumeOrder($id);

        $this->view('administrator/orderhistory/resume', compact('title', 'resume'));
    }

    public function resumeOrder($id)
    {
        $resultat = $this->modelCommande->getInfoCommande($id);

        return $resultat;
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
