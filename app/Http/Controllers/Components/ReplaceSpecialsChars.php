<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\Controller;

class ReplaceSpecialsChars extends Controller
{
    public function ReplaceSpecialsChars($chaine){
        //  On supprime les espaces
        $chaine=trim($chaine);
        // On remplace les chaines de caractères dont on ne veut pas
        $chaine= strtr($chaine,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");

        // On dégage les caractères spéciaux
        $chaine = preg_replace('/([^.a-z0-9]+)/i', '-', $chaine);
        // On met la chaine de caractères en minuscule
        $chaine = strtolower($chaine);

        // On renvoie la chaine modifiée
        return $chaine;
    }
}