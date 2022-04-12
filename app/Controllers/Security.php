<?php

namespace App\controllers;


class Security
{


    /**
     * Permet de sécuriser les donner d'entrée venant du client
     * @param mixed Information entrantes (compact()||POST/GET)
     * @return mixed Sortie des même information en verfiiant les chaine de caractère et les intervals
     */
    //Si la varaible à passer est une super global ne pas utilisé la function compact
    // $arguments_methode = compact('id','nom','age','array');
    // $control_donnees = $this->control($arguments_methode);
    // extract($control_donnees);
    public static function control($compact)
    {
        if (is_array($compact)) {
            foreach ($compact as $key => $value) {
                // On regarde si le type de string est un nombre entier (int)
                if (ctype_digit($value)) {
                    $value = intval($value);
                }
                // Pour tous les autres types
                else {
                    $value  = strip_tags($value);
                    $value = htmlentities($value);
                    $value = htmlspecialchars($value);
                }
            }

            return $compact; //On retourne les resultats sous forme de tableau
        } else {
            // if (ctype_digit($compact)==true) {
            //     $compact = intval($compact);
            // }
            // Pour tous les autres types
            // else {
            $compact  = strip_tags($compact);
            $compact = htmlentities($compact);
            $compact = htmlspecialchars($compact);
            // }
            return $compact; //On retourne le resultat sous forme de int ou String
        }
    }

    public static function controlAll($compact)
    {
        if (is_array($compact)) {
            foreach ($compact as $key => $value) {
                // On regarde si le type de string est un nombre entier (int)
                // if (ctype_digit($value) && is_array($value)==false) {
                //     $value = intval($value);
                // }
                // Pour tous les autres types
                // else {
                if (is_array($value)) {
                    foreach ($value as $underKey => $undervalue) {
                        if (ctype_digit($undervalue)) {
                            $undervalue = intval($undervalue);
                        } else {
                            $undervalue  = strip_tags($undervalue);
                            $undervalue = htmlentities($undervalue);
                            $undervalue = htmlspecialchars($undervalue);
                        }
                    }
                } else {
                    if (ctype_digit($value)) {
                        $value = intval($value);
                    } else {
                        $value  = strip_tags($value);
                        $value = htmlentities($value);
                        $value = htmlspecialchars($value);
                    }
                }
                // }
            }
        } else {
            if (ctype_digit($compact)) {
                $compact = intval($compact);
            }
            // Pour tous les autres types
            else {
                $compact  = strip_tags($compact);
                $compact = htmlentities($compact);
                $compact = htmlspecialchars($compact);
            }
        }
    }
}
