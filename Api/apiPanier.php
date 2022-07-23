<?php
session_start();

//Echappe tout les caractère speciaux
if(isset($_GET))
{
    foreach ($_GET as $key => $value) {
        if(is_array($value)){
            foreach ($value as $key => $valueOfKeys) {
                htmlentities($valueOfKeys);
            }
        }
        else  htmlentities($value);
    }
}


if(isset($_GET['findArticle']) && count($_SESSION['quantite'])>0){

    $index = 0;
    $where ='WHERE `id_article` =';
    foreach ($_SESSION['quantite'] as $key => $value) {
        if($index === 0)
        {
            $where =  "{$where}{$key}";
            $index++;
        }
        else $where = "{$where} OR `id_article`= {$key}";
    }

    $DataBase = new PDO('mysql:host=localhost;dbname=kawajojo;', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET CHARACTER SET UTF8'
    ]);

    $sql = "SELECT `titre_article`,`id_article`,`prix_article`,`sku`,`image_article` FROM  `articles` {$where}";
    $query = $DataBase->prepare($sql);
    $query->setFetchMode(\PDO::FETCH_ASSOC);
    $query->execute();
    $articles = $query->fetchall();
    
    $indexForInsert = 0;

    foreach ($_SESSION['quantite'] as $key => $value){
        $articles[$indexForInsert]['quatitySelected']=$value;
        $indexForInsert++;
    }

    $retour = [
        "status" => 200,
        "totalTTC" => $_SESSION['totalPrice'],
        "totalOfArticles" => $_SESSION['totalQuantity'],
        "message" => isset($_SESSION['flash']) ? $_SESSION['flash'] : 'null',
        "result" => $articles
    ];


    echo json_encode($retour);
}
elseif(isset($_GET['findArticle']))
{
    $flash = 'Votre panier et vide';

    $retour = [
        "status" => 403,
        "totalOfArticles" => "null",
        "message" => isset($_SESSION['flash']) ? $_SESSION['flash'] : 'null',
        "result" => $flash
    ];
    echo json_encode($flash);
}

if(isset($_GET['upQuantity']) && isset($_GET['id_article'])){

        $id_article =  (int) $_GET['id_article'];

        $_SESSION['quantite'][$id_article] = $_SESSION['quantite'][$id_article] + 1;

        echo json_encode($_SESSION['quantite'][$id_article]);
}

if(isset($_GET['downQuantity']) && isset($_GET['id_article'])){

    $id_article =  (int) $_GET['id_article'];

    $_SESSION['quantite'][$id_article] = $_SESSION['quantite'][$id_article] - 1;

    echo json_encode($_SESSION['quantite'][$id_article]);
}

if (isset($_GET['deleteProduct']) && isset($_GET['id_article'])) {
    unset($_SESSION['quantite'][(int) $_GET['id_article']]);
    unset($_SESSION['prix'][(int) $_GET['id_article']]);
    
    $retour = 200;

    echo json_decode($retour);
}
?>