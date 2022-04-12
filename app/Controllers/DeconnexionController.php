<?php
namespace App\controllers;

class DeconnexionController extends Controller
{
    public function index()
    {
    $title = "deconnexion";
    $this->view('profil.deconnexion', compact('title'));
    }
}
