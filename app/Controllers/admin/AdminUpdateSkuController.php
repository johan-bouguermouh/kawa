<?php

namespace App\controllers\admin;

use App\controllers\Controller;

/* use Database\DBConnection; */
use App\controllers\components\ProductComponent;
use App\controllers\components\CategoriesComponent;
use App\models\Product;

class AdminUpdateSkuController extends Controller
{
    public $error = array();
    protected $Product;
    protected $Categories;

    public function __construct()
    {
        $this->Product = new ProductComponent();
        $this->Categories = new CategoriesComponent();
    }

    public function index()
    {
        $title = 'Admin | Gestion de Stock';
        if (!empty($_POST)) {
            $this->Product->updateSku($_POST);
        }
        $urgentStock = $this->Product->stockNow();
        if (isset($_GET['recherche'])) {
            $titre_article = $_GET['recherche'];
        }
        $urlRedirect = $this->modifLinkget('&PRINCIPALE');


        if (isset($_POST['PRINCIPALE']) && $_POST['PRINCIPALE'] !== $_GET['PRINCIPALE']) {
            header('location: ' . $urlRedirect . '&PRINCIPALE=' . $_POST['PRINCIPALE']);
        }
        if (!empty($_GET['recherche'])) {
            $result = $this->Product->find_article($_GET['recherche']);
        } else $result = $this->Product->getAllProductForUpdate(['ASC' => 'sku']);
        $resultSearch = $this->Product->selectArrayByValue($result, 'cat parent', @$_GET['PRINCIPALE']);
        $allCategories = $this->Categories->chooseCategoriesBySection(['section'], 'PRINCIPALE');
        $methodImport = new AdminUpdateProductController;


        $compact = compact('title', 'allCategories', 'urlRedirect', 'methodImport', 'resultSearch', 'urgentStock');
        $this->view('administrator.updateSku', $compact);
    }

    public function modifLinkget(string $paramGetToDelete): string
    {
        if (str_contains($_SERVER['REQUEST_URI'], $paramGetToDelete)) {
            $urlGet = $_SERVER['REQUEST_URI'] . 'todelete';
            $newUrl = explode($paramGetToDelete, $urlGet)[0];
        } else {
            $newUrl = $_SERVER['REQUEST_URI'];
        }
        return $newUrl;
    }

    public function countSearch($nameCategories)
    {
        if (!empty($_GET['recherche'])) {
            $result = $this->Product->find_article($_GET['recherche']);
        } else $result = $this->Product->getAllProductForUpdate(['ASC' => 'sku']);
        $result = count($this->Product->selectArrayByValue($result, 'cat parent', $nameCategories));
        return $result;
    }
}
