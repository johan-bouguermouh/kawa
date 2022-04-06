<?php

namespace App\Controllers\admin;

use App\Controllers\Controller;



class MenuAdminController extends Controller
{


    public function index()
    {
        $menuAdmin = <<<HTML

                 <article id="menu">
             <section>
                 <h1>Admin</h1>
                 <ul>
                     <li><a href="./creerArticle/partie1">Creer un Article</a><i class="fa-solid fa-angle-right"></i></li>
                     <li><a href="./modifierArticle/liste">Modifier un articles</a><i class="fa-solid fa-angle-right"></i></li>
                     <li><a href="./gestiondestock">Gestion des stocks</a><i class="fa-solid fa-angle-right"></i></li>
                     <li><a href="./validercommande"> Gestion de commande</a><i class="fa-solid fa-angle-right"></i></li>
                     <li><a href="./categorie">Gestion des categories</a><i class="fa-solid fa-angle-right"></i></li>
                     <li><a href="./tag">Gestion des tags</a><i class="fa-solid fa-angle-right"></i></li>
                     <li><a href="./commentaire">Gestion des commentaires</a><i class="fa-solid fa-angle-right"></i></li>
                     <li><a href="./gestionUtilisateur/liste">Gestion des utilisateurs</a><i class="fa-solid fa-angle-right"></i></li>
                     <li><a href="profil/deconnexion">Se deconnecter</a></li>
                 </ul>
             </section>
         </article>
         <div id="header">
             <div id="menu-burger">
                 <div class="bar1"></div>
                 <div class="bar2"></div>
                 <div class="bar3"></div>
             </div>
         </div>

         HTML;



        $this->view('administrator/tag/index', compact('title', 'tag'));
    }
}
