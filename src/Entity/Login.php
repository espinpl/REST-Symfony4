<?php
 
namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
 
class Login
{
    /**
     * @Assert\NotBlank()
     */
    public $username;
    
    /**
     * @Assert\NotBlank()
     */
    public $password;        
}
