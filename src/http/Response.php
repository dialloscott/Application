<?php
namespace Application\http;

class Response
{
    
    /**
     * Retourne un chaine de caractere pour etre afficher par echo
     * @return String string 
     */
    public function send():string
    {
        return  "hello word";
    }
}