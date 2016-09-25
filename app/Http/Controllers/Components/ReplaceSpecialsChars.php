<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\Controller;

class ReplaceSpecialsChars extends Controller
{
    public function ReplaceSpecialsChars($chaine){
        //  les accents
        $chaine=trim($chaine);
        $chaine= strtr($chaine,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");

        //  les caracètres spéciaux (aures que lettres et chiffres en fait)
        $chaine = preg_replace('/([^.a-z0-9]+)/i', '-', $chaine);
        $chaine = strtolower($chaine);

        return $chaine;
    }
}