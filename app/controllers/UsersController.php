<?php
namespace  App;
use Application\http\Request;

class UsersController extends Controller
{
   public function show(Request $request, $id)
   {
       return 'Users '. $id;
   }
}