<?php session_start();
// error_reporting(0);

use App\controllers\Security;
use Exceptions\NotFoundException;

require_once 'app/controllers/Security.php';

//Control d'accée à l'url
$urlControlUser = $_SERVER['REQUEST_URI'];
$pathControl = explode('/', $urlControlUser);
if ($pathControl[2] !== 'connexion') {
    if ($pathControl[2] !== 'inscription') {
        $_SERVER['HTTP_REFERER'] = $_SERVER['REQUEST_URI'];
    }
}
// if($pathControl[2]=='admin' && $_SESSION['user']['role']!=='Admin')
// {
// if(isset($_SESSION['user']))
// {
// // echo 'redirection';
//     echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="'.$pathControl[0].'/'.$pathControl[1].'/profil" </SCRIPT>'; //force la direction
// exit();
// }
if ($pathControl[2] == 'admin' && $_SESSION['user']['role'] !== 'Admin') {
    if (isset($_SESSION['user'])) {
        // echo 'redirection';
        echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="' . $pathControl[0] . '/' . $pathControl[1] . '/profil" </SCRIPT>'; //force la direction
        exit();
    } else {
        echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="' . $pathControl[0] . '/' . $pathControl[1] . '/connexion" </SCRIPT>'; //force la direction 
    }
}
if ($pathControl[2] == 'profil' && empty($_SESSION['user'])) {
    echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="' . $pathControl[0] . '/' . $pathControl[1] . '/connexion" </SCRIPT>'; //force la direction 
}
if (($pathControl[2] == 'connexion' && !empty($_SESSION['user'])) || ($pathControl[2] == 'inscription' && !empty($_SESSION['user']))) {
    echo '<SCRIPT LANGUAGE="JavaScript"> document.location.href="../boutique-en-ligne/"</SCRIPT>'; //force la direction 
}

//Sécurité de tout les formulaire Get|POST
$securityAll = new Security();
if (isset($_GET)) {
    $securityAll->controlAll($_GET);
}
if (isset($_POST)) {
    $securityAll->controlAll($_POST);
}

require('vendor/autoload.php');


define('VIEWS', __DIR__ . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'errors' . DIRECTORY_SEPARATOR . '404.php');

define('REDIRECT', __DIR__ . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'shop' . DIRECTORY_SEPARATOR . 'livraison.php');

define('ERROR', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'pictures' . DIRECTORY_SEPARATOR . 'kawa_loading_blanc.gif');


function error($param)
{
    if ($param === False) {
        http_response_code(404);
        require VIEWS;
    }
}


$router = new AltoRouter();
$router->setBasePath('/boutique-en-ligne');
$router->map('GET|POST', '/', function () {
    $controller = new App\Controllers\MainController();
    $controller->index();
}, 'home');


/* ---------------------------- INTERFACE USER ------------------------
---------------------------- INTERFACE USER ------------------------ */

$router->map(
    'GET|POST',
    '/inscription',
    function () {
        $controller = new App\controllers\InscriptionController();
        $controller->index();
        $controller->SignUp();
    },
);

$router->map(
    'GET|POST',
    '/connexion',
    function () {
        $controller = new App\controllers\ConnexionController();
        $controller->index();
        $controller->login();
    },
);

$router->map(
    'GET|POST',
    '/checkemail',
    function () {
        $controller = new App\controllers\forgetpassword\checkEmailController();
        $controller->index();
        $controller->checkLogin();
    },
);



$router->map(
    'GET|POST',
    '/resetpassword',
    function () {

        $controller = new App\controllers\forgetpassword\resetPasswordController();
        $controller->index();
        $controller->resetPassword();
    },
);



$router->map(
    'GET|POST',
    '/profil',
    function () {
        $controller = new App\controllers\User\ProfilController();
        $controller->index();
    },
);

$router->map(
    'GET|POST',
    '/profil/modifierMotdePasse',
    function () {
        $controller = new App\controllers\User\ModifierPasswordController();
        $controller->index();
        $controller->updatePassword();
    },
);

$router->map(
    'GET|POST',
    '/profil/modifierProfil',
    function () {
        $controller = new App\controllers\User\ModifierProfilController();
        $controller->index();
        $controller->updateProfil();
    },
);

$router->map(
    'GET|POST',
    '/profil/adresse',
    function () {
        $controller = new App\controllers\User\AdresseController();
        $controller->index();
        $controller->getAdress();
        $controller->create();
    },
);

$router->map(
    'GET|POST',
    '/profil/adresse/modifierAdresse/[i:id_adresse]',
    function ($id_adresse) {
        $controller = new App\controllers\user\ModifierAdresseController();
        $controller->index($id_adresse);
        $controller->updateAdresse($id_adresse);
        $controller->getAdressebyId($id_adresse);
        $controller->deleteAdresse($id_adresse);
    },
);

$router->map(
    'GET|POST',
    '/profil/adresse/creerAdresse',
    function () {
        $controller = new App\controllers\user\CreerAdresseController();
        $controller->index();
        $controller->createAdresse();
    },
);

$router->map(
    'GET|POST',
    '/profil/historiqueCommande',
    function () {
        $controller = new App\controllers\user\HistoriqueController();
        $controller->index();
        // $controller->getCommande();
    },
);

$router->map(
    'GET|POST',
    '/profil/historiqueCommande/commande/[i:id_num_commande]',
    function ($id_num_commande) {
        $controller = new App\controllers\user\CommandeController();
        $controller->index($id_num_commande);

        // $controller->getCommandebyId($id_commande);
    },
);

/* -----------------------------------------SEARCH BAR--------------------------------------------------------- */





$router->map(
    'GET',
    '/search',
    function () {
        $controller = new App\controllers\SearchController();
        $controller->index();
    },
    'search'
);

$router->map(
    'GET|POST',
    '/profil/deconnexion',
    function () {
        $controller = new App\controllers\DeconnexionController();
        $controller->index();
    },
    'deconnexion'
);



/* ----------------------------- PARCOURS ADMIN -----------------------------
----------------------------- PARCOURS ADMIN -----------------------------
----------------------------- PARCOURS ADMIN ----------------------------- */


$router->map(
    'GET|POST',
    '/admin/creerArticle/[*:param]',
    function ($param) {
        $controller = new App\controllers\admin\AdminCreateProductController();
        $controller->CreatProduct($param);
    },
    'creat product'
);

$router->map(
    'GET|POST',
    '/admin',
    function () {
        $controller = new App\controllers\admin\AdminCreateProductController();
        $controller->index();
    },
    'Admin index'
);

$router->map(
    'GET|POST',
    '/admin/modifierArticle/[*:id_article]',
    function ($id_article) {
        $controller = new App\controllers\admin\AdminUpdateProductController();
        $controller->index($id_article);
    },
    'update product'
);

$router->map(
    'GET|POST',
    '/admin/gestiondestock',
    function () {
        $controller = new App\controllers\admin\AdminUpdateSkuController();
        $controller->index();
    },
    'gestion de stock'
);

$router->map(
    'GET|POST',
    '/admin/gestionUtilisateur/[*:param]',
    function ($param) {
        $controller = new App\controllers\admin\AdminUpdateUserController();
        $controller->index($param);
        $controller->getUser($param);
        $controller->deleteUser($param);
        $controller->UpdateUser($param);
    }
);

$router->map(
    'GET|POST',
    '/admin/validercommande',
    function () {
        $controller = new App\controllers\admin\AdminOrderController();
        $controller->index();
        $controller->update();
    },

);

$router->map(
    'GET|POST',
    '/admin/detail/[i:id]',
    function ($id) {
        $controller = new App\controllers\admin\AdminOrderController();
        $controller->indexResume($id);
    },

);

// CRUD Category
$router->map(
    'GET',
    '/admin/categorie',
    function () {
        $controller = new App\controllers\admin\AdminCategoryController();
        $controller->index();
    },

);

$router->map(
    'POST',
    '/admin/categorie',
    function () {
        $controller = new App\controllers\admin\AdminCategoryController();
        $controller->update();
        $controller->create();
        $controller->delete();
    },

);


// CRUD Comment
$router->map(
    'GET/POST',
    '/admin/commentaire',
    function () {
        $controller = new App\controllers\admin\AdminCommentController();
        $controller->update();
        $controller->create();
        $controller->delete();
        $controller->createAnswerCom();
        $controller->createAnswerAdmin();
        $controller->reportAnswer();
        $controller->report();
        $controller->validateAnswer();
        $controller->validateAnswerCom();

        $controller->index();
    },

);


$router->map(
    'POST/GET',
    '/admin/tag',
    function () {
        $controller = new App\controllers\admin\AdminTagController();
        $controller->update();
        $controller->create();
        $controller->delete();
        $controller->index();
    },

);


/* ----------------------------- FIN ADMIN -----------------------------
----------------------------- FIN ADMIN -----------------------------
 */

// PRODUIT
$router->map(
    'GET|POST',
    '/produit/[*:id_article]',
    function ($id_article) {
        $controller = new App\controllers\ProductController();
        $controller->index($id_article);
        $controller->shoppingBag();
        $controller->pushAnswerCom($id_article);
        $controller->report($id_article);
        $controller->reportAnswer($id_article);
        // $controller->Like($id_article);
        // $controller->addComment($id_article);
    },
);

//SHOP
$router->map(
    'GET|POST',
    '/boutique/[*:param]',
    function ($param) {
        $controller = new App\controllers\BoutiqueSearchController();
        $controller->index($param);
    }
);


/* ----------------------------- PARCOURS PANIER -----------------------------
----------------------------- PARCOURS PANIER -----------------------------
----------------------------- PARCOURS PANIER ----------------------------- */



//livraison
$router->map(
    'GET/POST',
    '/livraison',
    function () {
        $controller = new App\controllers\pathToOrder\LivraisonController();
        $controller->index();
        $controller->fieldCheck();
        $controller->adressCheck();
        $controller->getAdress();
        $controller->back();
    },
    'livraison'
);

//Paiement
$router->map(
    'GET/POST',
    '/paiement',
    function () {
        $controller = new App\controllers\pathToOrder\PaymentController();
        $controller->index();
        $controller->payment();
        $controller->stripe();
    },
    'paiement'
);


//Paiement
$router->map(
    'GET/POST',
    '/paiementResume',
    function () {
        $controller = new App\controllers\pathToOrder\PaymentResumeController();
        $controller->index();
    },
    'paiementResume'
);

$match = $router->match();
if (is_array($match)) {
    if (is_callable($match['target'])) {
        call_user_func_array($match['target'], $match['params']);
    }
}
error($match);
