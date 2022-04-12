<?php



namespace App\controllers\pathToOrder;

use Exception;
use Throwable;

use Stripe\Stripe;
use App\models\Articles;
use App\models\Commandes;
use App\models\Livraison;
use Stripe\PaymentIntent;
use Database\DBConnection;
use App\models\NumCommande;
use App\controllers\Security;
use App\controllers\Controller;

class PaymentController extends Controller
{

    public function __construct()
    {
        $this->modelNumCommande = new NumCommande();
        $this->modelCommandes = new Commandes();
        $this->modelLivraison = new Livraison();
        $this->modelArticle = new Articles();
    }


    public function index()
    {
        $title = "Paiement - Kawa";
        return $this->view('shop.payment', compact('title'));
    }


    public function checkQuantity($db)
    {

        $checkQuantity = [];
        $_SESSION['quantityPayment'] = [];
        $_SESSION['halfQuantityPayment'] = [];
        $_SESSION['noStock'] = [];

        foreach ($_SESSION['quantite'] as $key => $value) {
            $id_article = $key;
            $argument = ['id_article'];
            $selection = ['sku', 'titre_article', 'prix_article'];
            $checkQuantity[$id_article] = $this->modelArticle->findTransaction($argument, compact('id_article'), $db, $selection);

            /*         if (($checkQuantity[$key][0]["sku"] - $value) >= 0) {

                $titre_article = $checkQuantity[$key][0]["titre_article"];
                $prix_article = $checkQuantity[$key][0]["prix_article"];
                $image_article = $checkQuantity[$key][0]["image_article"];
                $_SESSION['quantityPayment'][$id_article][0] = $value;
                $_SESSION['quantityPayment'][$id_article][1] = $titre_article;
                $_SESSION['quantityPayment'][$id_article][2] = $prix_article;
                $_SESSION['quantityPayment'][$id_article][3] = $image_article;
            } */

            if (($checkQuantity[$key][0]["sku"] - $value) < 0 && ($checkQuantity[$key][0]["sku"] - $value) != 0) {

                $titre_article = $checkQuantity[$key][0]["titre_article"];
                $prix_article = $checkQuantity[$key][0]["prix_article"];
                $image_article = $checkQuantity[$key][0]["image_article"];

                // si commande 5 articles mais 3 en bdd, actualisation de nbr d'unité. 
                $_SESSION['quantite'][$key] = $checkQuantity[$key][0]["sku"];
                $_SESSION['halfQuantityPayment'][$id_article][0] = $checkQuantity[$key][0]["sku"];
                $_SESSION['halfQuantityPayment'][$id_article][1] = $titre_article;
                $_SESSION['halfQuantityPayment'][$id_article][2] = $prix_article;
                $_SESSION['halfQuantityPayment'][$id_article][3] = $image_article;
            }

            /*       if ($checkQuantity[$key][0]["sku"] == 0) {
                $_SESSION['noStock'][$id_article][1] = $titre_article;

                unset($_SESSION['quantite'][$id_article]);
                unset($_SESSION['prix'][$id_article]);
            } */
        }
    }

    public function updateQuantity($db)
    {
        foreach ($_SESSION['quantite'] as $key => $value) {

            $this->modelArticle->updateLock($db, $key, $value);
        }
    }


    public function insertLivraison($idNumC, $connexion)
    {
        $fk_id_num_commande = Security::control($idNumC);
        $email = Security::control($_SESSION['validate']['email']);
        $nom = Security::control($_SESSION['validate']['nom']);
        $prenom = Security::control($_SESSION['validate']['prenom']);
        $nom_adresse = Security::control($_SESSION['validate']['nom_adresse']);
        $ville =   Security::control($_SESSION['validate']['ville']);
        $pays = Security::control($_SESSION['validate']['pays']);
        $voie = Security::control($_SESSION['validate']['voie']);
        $voie_sup =  Security::control($_SESSION['validate']['voie_sup']);
        $code_postal =  Security::control($_SESSION['validate']['code_postal']);
        $telephone =   Security::control($_SESSION['validate']['telephone']);
        $etat_livraison = "en attente confirmation";

        $modelHydrate = $this->modelLivraison
            ->setFk_id_num_commande($fk_id_num_commande)
            ->setEmail($email)
            ->setNom($nom)
            ->setPrenom($prenom)
            ->setNom_adresse($nom_adresse)
            ->setVille($ville)
            ->setPays($pays)
            ->setVoie($voie)
            ->setVoie_sup($voie_sup)
            ->setCode_postal($code_postal)
            ->setTelephone($telephone)
            ->setEtat_livraison($etat_livraison);


        $this->modelLivraison->createTransaction($modelHydrate, compact('fk_id_num_commande', 'email', 'nom', 'prenom', 'nom_adresse', 'ville', 'pays', 'voie', 'voie_sup', 'code_postal', 'telephone', 'etat_livraison'), $connexion);
    }

    public function insertCommandes($idNumC, $connexion)
    {

        foreach ($_SESSION['quantite'] as $key1 => $value1) {
            foreach ($_SESSION['prix'] as $key2 => $value2) {
                if ($key1 == $key2) {
                    $fk_id_num_commande = $idNumC;
                    $nb_article = $value1;
                    (float) $prix_article = $value2;
                    $fk_id_article = $key1;
                    $id_article = $key1;
                    $argument = ['id_article'];
                    $article = $this->modelArticle->find($argument, compact('id_article'));
                    $titre_article = $article[0]['titre_article'];



                    (float) $prix_commande = ($prix_article * $nb_article);
                    $modelHydrate = $this->modelCommandes
                        ->setFk_id_num_commande($fk_id_num_commande)
                        ->setFk_id_article($fk_id_article)
                        ->setNb_article($nb_article)
                        ->setPrix_article($prix_article)
                        ->setPrix_commande($prix_commande)
                        ->setTitre_article($titre_article);
                    $this->modelCommandes->createTransaction($modelHydrate, compact('fk_id_num_commande', 'fk_id_article', 'nb_article', 'prix_article', 'prix_commande', 'titre_article'), $connexion);
                }
            }
        }
    }

    public function totalPrice()
    {

        if (isset($_SESSION['quantite'])) {

            $result = 0;
            foreach ($_SESSION['quantite'] as $key1 => $value1) {
                foreach ($_SESSION['prix'] as $key2 => $value2) {
                    if ($key1 == $key2) {

                        $resultSinglePrice = $value1 * $value2;
                        $result += $resultSinglePrice;
                    }
                }
            }
        }
        return $result;
    }

    public function totalQuantity()
    {
        (float) $result = 0;
        foreach ($_SESSION['quantite'] as $quantite) {
            $result = $result + $quantite;
        }

        return $result;
    }

    public function insertNumCommande($db)
    {
        (int) $secureIdUser = Security::control($_SESSION['user']['id_utilisateur']);
        (int) $secureTotalProduit = $this->totalQuantity();
        (float) $secureWithTvaPrice = $this->totalPrice();

        // variable init envoyer dans le model Num Commande
        $fk_id_utilisateurs = $secureIdUser;
        $total_produit = $secureTotalProduit;
        $prix_avec_tva = $secureWithTvaPrice;
        $prix_sans_tva = $secureWithTvaPrice * (94.5 / 100);
        $resultat =  $this->modelNumCommande->orderInsert($db, compact('fk_id_utilisateurs', 'total_produit', 'prix_sans_tva', 'prix_avec_tva'));
        return $resultat;
    }


    public function stripe()
    {
        if (isset($_POST['submit'])) {
            /* var_dump($_POST); */
            $totalPrice = 200;
            // Nous appelons l'autoloader pour avoir accès à Stripe      
            // Nous instancions Stripe en indiquand la clé privée, pour prouver que nous sommes bien à l'origine de cette demande
            \Stripe\Stripe::setApiKey('sk_test_51Kbk2DKiGV4T2BDFJHQjg1nW2gLVxPy5Renk8jdaZPIAvD31kIDLzrOmRiyxFEiszws6noml2hucPUeteSJfXnRp006gqmAwdp');

            /*     $customer = \Stripe\Customer::create(
            array(
                'email' => Security::control($_SESSION['validate']['nom']),
            )
        ); */
            // Nous créons l'intention de paiement et stockons la réponse dans la variable $intent
            $intent = \Stripe\PaymentIntent::create([
                'amount' => $totalPrice * 100, // Le prix doit être transmis en centimes
                'currency' => 'eur',
                'payment_method_types' => ['card'],
                ['payment_method' => 'pm_card_visa'],
            ]);
            if (empty($intent)) {
                $intent = 'importe stripe';
            } else {
                $intent['client_secret'];
            }
        }
    }

    public function payment()
    {           /*         $this->stripe($this->totalPrice()); */
        if (isset($_POST['submit'])) {

            /*     $this->stripe(); */
            try {
                $db = DBConnection::getPDO();
                $db->beginTransaction();
                $this->checkQuantity($db);
                $getIdNumCommande = $this->insertNumCommande($db);
                $this->updateQuantity($db);
                $this->insertLivraison($getIdNumCommande, $db);
                $this->insertCommandes($getIdNumCommande, $db);
                $db->commit();
                unset($_SESSION['validate']);
                unset($_SESSION['quantite']);
                unset($_SESSION['prix']);
                $_SESSION['num_commande'] = $getIdNumCommande;
                echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="./paiementResume" </SCRIPT>'; //force la direction

            } catch (Exception $e) {
                $db->rollBack();
                echo "Failed: " . $e->getMessage();
            }

            echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="./paiement" </SCRIPT>'; //force la direction

        }
    }
}
