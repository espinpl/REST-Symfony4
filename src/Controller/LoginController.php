<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Users;
use App\Entity\Login;
use App\Form\LoginType;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function index(Request $request, SessionInterface $session)
    {
        $message = null;
        $user = new Users();
        $form = $this->createForm(LoginType::class, new Login());

        if ($request->isMethod('POST'))
        {
            $form->submit($request->request->get($form->getName()));
 
            if ($form->isSubmitted() && $form->isValid()) 
            { 
                $repository = $this->getDoctrine()->getRepository(Users::class);
                $password = $user->crypted($form->get('password')->getData());

                $record = $repository->findOneBy([
                    'username' => $form->get('username')->getData(),
                    'password' => $password,
                    'status' => 1
                ]);

                if (!$record) {
                    $message.= 'You did not sign in correctly or your account is not activ.';
                } else 
                {
                    $session->set('user', $form->get('username')->getData());
                    $message.= 'You are logged in.';
                }
            } else 
            {
                $message = 'An error occured...'; 
            }
        }

        return $this->render('login/index.html.twig', [
            'message' => $message,
            'form' => $form->createView()
        ]);
    }
}
