<?php

namespace App\Controllers;

use App\Controllers\User\AdresseController;

$adresse = new AdresseController;


if(empty($_SESSION['user']))
{
    $userPath = '/boutique-en-ligne/connexion';
    $iconUser = '<i class="fa-solid fa-user-xmark"></i>';
}
elseif($_SESSION['user']['role']=='Utilisateurs')
{
    $userPath = '/boutique-en-ligne/profil';
    if($adresse->getAdress()==null)
    {
        $iconUser = '<i class="fa-solid fa-user"></i>'.'<i id="notifOne" class="fa-solid fa-bell"></i>';
    }
    else $iconUser = '<i class="fa-solid fa-user"></i>';
}
elseif($_SESSION['user']['role']=='Admin')
{
    $iconUser = '<i class="fa-solid fa-user-gear"></i>';
    $userPath = '/boutique-en-ligne/admin';
}
