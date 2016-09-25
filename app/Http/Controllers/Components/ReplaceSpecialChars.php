<?php

namespace App\Http\Controllers\Components;


class ReplaceSpecialChars
{
    public function ReplaceSpecialchars($chaine) {
        //  Remplacement des accents
        $chaine= trim($chaine);
        $chaine= strtr($chaine,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");

        //  Remplacement des autres caratères spéciaux
        $chaine = preg_replace('/([^.a-z0-9]+)/i', '-', $chaine);
        $chaine = strtolower($chaine);

        return $chaine;
    }
}