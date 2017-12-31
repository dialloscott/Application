<?php
namespace Application;
use Application\http\{Request, Response};

class Application 
{
   

    /**
     * Il  faut systematiquement un objet de type request
     * returen forcement un objet de type response
     * @param Request $request
     * @return Respoonse $request
     * 
     */
    public function handleRequest(Request $request):Response
    {
        
       return new Response;
    }
}