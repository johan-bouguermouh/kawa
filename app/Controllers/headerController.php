<?php

namespace App\Controllers;

use App\Controllers\User\AdresseController;

$adresse = new AdresseController;


if (empty($_SESSION['user'])) {
    $userPath = '/kawa/connexion';
    $iconUser = '<i class="fa-solid fa-user-xmark"></i>';
} elseif ($_SESSION['user']['role'] == 'Utilisateurs') {
    $userPath = '/kawa/profil';
    if ($adresse->getAdress() == null) {
        $iconUser = '<i class="fa-solid fa-user"></i>' . '<i id="notifOne" class="fa-solid fa-bell"></i>';
    } else $iconUser = '<i class="fa-solid fa-user"></i>';
} elseif ($_SESSION['user']['role'] == 'Admin') {
    $iconUser = '<i class="fa-solid fa-user-gear"></i>';
    $userPath = '/kawa/admin';
}
