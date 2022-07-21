<?php 

public function upValue()
{
    // if (isset($_POST['upQuantity'])) {

    //     $up =  $_POST['upQuantity'];
    //     $id_article =  (int) $_POST['id_article'];
    //     $argument = ['id_article'];

    //     $checkQuantity = [];

    //     $checkQuantity[$id_article] = $this->modelArticle->find($argument, compact('id_article'));


    //     if (($_SESSION['quantite'][$id_article] + $up)  <= $checkQuantity[$id_article][0]['sku']) {
    //         $_SESSION['quantite'][$id_article] = $_SESSION['quantite'][$id_article] + $up;
    //     } else {
    //         $_SESSION['flash']['quantity'] = "Le stock est vide !";
    //     }

    //     header('refresh: 0');
    // }

    $test = $_POST;
    echo json_encode($test);
}