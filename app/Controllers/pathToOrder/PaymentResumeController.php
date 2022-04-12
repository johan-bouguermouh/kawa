<?php



namespace App\Controllers\pathToOrder;

use Exception;

use App\models\Commandes;
use App\controllers\Controller;

class PaymentResumeController extends Controller
{

    public function __construct()
    {
        $this->model = new Commandes();
    }


    public function index()
    {
        $commande = $this->model->getInfoCommande($_SESSION['num_commande']);
        $title = " Confirmation paiement - Kawa";
        return $this->view('shop.resumePayment', compact('title', 'commande'));
    }
}
