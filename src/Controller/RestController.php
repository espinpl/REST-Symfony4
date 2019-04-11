<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Serializer\SerializerInterface;

use App\Entity\Users;
use App\Repository\UsersRepository;

class RestController extends AbstractController {
	
    private $repository;

    public function __construct(
        UsersRepository $repository
    ){
        $this->repository = $repository;
    }

    /**
     * @Route("/api/v1/user", name="create", methods={"POST"})
     */
    public function Create(Request $request)
    { 
        $data = json_decode($request->get('user'));
			
        if (empty($data)) { 
            return new JsonResponse(['error' => 'no content']);
        }
		
        try 
        { 
            $entityManager = $this->getDoctrine()->getManager();
            $users = new Users();
            $users->setUsername($data->username);
            $users->setPassword($data->password);		
            $users->setEmail($data->email);	
            $users->setFirstname($data->firstname);	
            $users->setLastname($data->lastname);	
            $users->setStatus($data->status);	
            $entityManager->persist($users);
            $entityManager->flush();<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Serializer\SerializerInterface;

use App\Entity\Users;
use App\Repository\UsersRepository;

class RestController extends AbstractController {
	
    private $repository;

    public function __construct(
        UsersRepository $repository
    ){
        $this->repository = $repository;
    }

    /**
     * @Route("/api/v1/user", name="create", methods={"POST"})
     */
    public function Create(Request $request)
    { 
        $data = json_decode($request->get('user'));
			
        if (empty($data)) { 
            return new JsonResponse(['error' => 'no content']);
        }
		
        try 
        { 
            $entityManager = $this->getDoctrine()->getManager();
            $users = new Users();
            $users->setUsername($data->username);
            $users->setPassword($data->password);		
            $users->setEmail($data->email);	
            $users->setFirstname($data->firstname);	
            $users->setLastname($data->lastname);	
            $users->setStatus($data->status);	
            $entityManager->persist($users);
            $entityManager->flush();
			
            return new JsonResponse(['message' => 'The user was created.', 'user' => $data], JsonResponse::HTTP_CREATED);

        } catch (\Exception $m) 
        {
             return new JsonResponse(['error' => $m->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        } 
    }

    /**
     * @Route("/api/v1/user/{id}", name="read", methods={"GET"})
     */
    public function Read($id, Request $request, SerializerInterface $serializer)
    { 
        try 
        {
            $user = $this->repository->findOneById($id);
			
            if (!$user) {
                return new JsonResponse(['error' => 'No user found.']);
            }
			
            $jsonContent = $serializer->serialize($user, 'json');

            $response = new Response($jsonContent, JsonResponse::HTTP_OK); 
            $response->headers->set('Content-Type', 'application/json');

            return $response;

        } catch (\Exception $m) 
        {
             return new JsonResponse(['error' => $m->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
	
    /**
     * @Route("/api/v1/user/{id}", name="update", methods={"PUT"})
     */
    public function Update($id, Request $request)
    { 
        $data = json_decode($request->getContent());
		
        if (empty($data)) { 
            return new JsonResponse(['error' => 'no content']);
        }
		
        $user = $this->repository->findOneById($id);
		
        if (!$user) {
            return new JsonResponse(['error' => 'No user found.']);
        }		
		
        try 
        { 
            $entityManager = $this->getDoctrine()->getManager();
            $user->setUsername($data->username);
            $user->setPassword($data->password);		
            $user->setEmail($data->email);	
            $user->setFirstname($data->firstname);	
            $user->setLastname($data->lastname);	
            $user->setStatus($data->status);				
            $entityManager->flush();
			
            return new JsonResponse(['message' => 'The user was updated.', 'user' => $data], JsonResponse::HTTP_OK);
			
        } catch (\Exception $m) 
        {
            return new JsonResponse(['error' => $m->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        } 
    }
	
    /**
     * @Route("/api/v1/user/{id}", name="delete", methods={"DELETE"})
     */
    public function Delete($id)
    { 
        $user = $this->repository->findOneById($id);
		
        if (!$user) {
            return new JsonResponse(['error' => 'No user found.']);
        }
		
        try 
        { 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
			
            return new JsonResponse(['message' => 'The user was deleted.'], JsonResponse::HTTP_OK);
			
        } catch (\Exception $m) 
        {
             return new JsonResponse(['error' => $m->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }		
    }
	
}

			
            return new JsonResponse(['message' => 'The user was created.', 'user' => $data], JsonResponse::HTTP_CREATED);

        } catch (\Exception $m) 
        {
             return new JsonResponse(['error' => $m->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        } 
    }

    /**
     * @Route("/api/v1/user/{id}", name="read", methods={"GET"})
     */
    public function Read($id, Request $request, SerializerInterface $serializer)
    { 
        try 
        {
            $user = $this->repository->findOneById($id);
			
            if (!$user) {
                return new JsonResponse(['error' => 'No user found.']);
            }
			
            $jsonContent = $serializer->serialize($user, 'json');

            $response = new Response($jsonContent, JsonResponse::HTTP_OK); 
            $response->headers->set('Content-Type', 'application/json');

            return $response;

        } catch (\Exception $m) 
        {
             return new JsonResponse(['error' => $m->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
	
    /**
     * @Route("/api/v1/user/{id}", name="update", methods={"PUT"})
     */
    public function Update($id, Request $request)
    { 
        $data = json_decode($request->getContent());
		
        if (empty($data)) { 
            return new JsonResponse(['error' => 'no content']);
        }
		
        $user = $this->repository->findOneById($id);
		
        if (!$user) {
            return new JsonResponse(['error' => 'No user found.']);
        }		
		
        try 
        { 
            $entityManager = $this->getDoctrine()->getManager();
            $user->setUsername($data->username);
            $user->setPassword($data->password);		
            $user->setEmail($data->email);	
            $user->setFirstname($data->firstname);	
            $user->setLastname($data->lastname);	
            $user->setStatus($data->status);				
            $entityManager->flush();
			
            return new JsonResponse(['message' => 'The user was updated.', 'user' => $data], JsonResponse::HTTP_OK);
			
        } catch (\Exception $m) 
        {
            return new JsonResponse(['error' => $m->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        } 
    }
	
    /**
     * @Route("/api/v1/user/{id}", name="delete", methods={"DELETE"})
     */
    public function Delete($id)
    { 
        $user = $this->repository->findOneById($id);
		
        if (!$user) {
            return new JsonResponse(['error' => 'No user found.']);
        }
		
        try 
        { 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
			
            return new JsonResponse(['message' => 'The user was deleted.'], JsonResponse::HTTP_OK);
			
        } catch (\Exception $m) 
        {
             return new JsonResponse(['error' => $m->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }		
    }
	
}
