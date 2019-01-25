<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Users;
use App\Form\UsersType;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function index(Request $request)
    {
        $users = new Users();
        $form = $this->createForm(UsersType::class, $users);
        $form->handleRequest($request);
        $message = null;

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($users);
            $entityManager->flush();

            $message = 'Użytkownik został dodany.'; 
        }

        return $this->render('register/index.html.twig', [
            'controller_name' => 'Rejestracja',
            'message' => $message,
            'form' => $form->createView()
        ]);
    }
}
