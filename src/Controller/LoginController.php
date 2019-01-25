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
        $form = $this->createForm(LoginType::class, new Login());

        if ($session->get('user')) {
            $message = '<p>Jesteś zalogowany '.$session->get('user').'</p>';
        }

        if ($request->isMethod('POST'))
        {
            $form->submit($request->request->get($form->getName()));
 
            if ($form->isSubmitted() && $form->isValid()) 
            { 
                $repository = $this->getDoctrine()->getRepository(Users::class);

                $record = $repository->findOneBy([
                    'username' => $form->get('username')->getData(),
                    'password' => sha1(md5($form->get('password')->getData())),			
                    'status' => 1
                ]);

                if (!$record) {
                    $message.= 'Nie udało się zalogować! Brak użytkownika lub jeszcze nie aktywny.';
                } else 
                {
                    $session->set('user', $form->get('username')->getData());
                    $message.= 'Zalogowany pozytywnie...';
                }
                
            } else 
            {
                $message = 'Error:'; 
            }
        }

        return $this->render('login/index.html.twig', [
            'controller_name' => 'Logowanie',
            'message' => $message,
            'form' => $form->createView()
        ]);
    }
}
