<?php

namespace App\Controller;


use Symfony\Component\Security\Core\Security;


class UserController 
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function __invoke()
    {
        // returns User object or null if not authenticated
        $user = $this->security->getUser();
        return $user;
       
    }

  
}
