<?php

namespace App\Controllers;

/* use Database\DBConnection; */

abstract class Controller
{

    protected $db;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        /* $this->db = DBConnection::getPDO(); */
    }

    protected function view(string $path, array $params = [])
    {

        extract($params);
        ob_start();
        $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
        require('Views/' . $path . '.php');
        $pageContent = ob_get_clean();
        require('Views/layout.php');
    }

    protected function getDB()
    {
        return $this->db;
    }
}
