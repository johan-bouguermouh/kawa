<?php

namespace App\controllers;

use App\controllers\components\CardCompenent;
use App\models\Product;
use App\models\Articles;


class MainController extends Controller
{

    public function index()
    {
        $title = "accueil - kawa";

        $model = new Product();
        $bestArticle = $model->bestProduct();

        $cards = new CardCompenent;
        $lastidProduct = $model->lastProductById()['id_article'];
        if (count($bestArticle) > 8) {
            $selectNumberofCard = 4;
        } else $selectNumberofCard = (count($bestArticle) - 1);



        return $this->view('shop.index', compact('title', 'bestArticle', 'cards', 'lastidProduct', 'selectNumberofCard'));
    }
}
