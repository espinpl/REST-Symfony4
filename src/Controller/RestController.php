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

class RestController extends AbstractController
{
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
		/*if (!$this->isSecure() || $request->get('token')!==getenv('API_REST_TOKEN')) {
			return new JsonResponse(['status' => 'Bad token or not secure!'], JsonResponse::HTTP_FORBIDDEN);
        }*/
		
		try 
		{
            $new_user = json_decode($request->get('user'));
			
		} catch (\Exception $m) 
		{
			return new JsonResponse([$m->getMessage()], JsonResponse::HTTP_NO_CONTENT);
		}
		
			$entityManager = $this->getDoctrine()->getManager();
            print_r($new_user);
            return new JsonResponse(['user' => $new_user],JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/api/v1/user/{id}", name="read", methods={"GET"})
     */
    public function Read($id, Request $request, SerializerInterface $serializer)
    { 
        try 
		{
            $user = $this->repository->findOneById($id);
            $jsonContent = $serializer->serialize($user, 'json');

            $response = new Response($jsonContent, JsonResponse::HTTP_OK); 
            $response->headers->set('Content-Type', 'application/json');

            return $response;

		} catch (\Exception $m) 
		{
			return new JsonResponse(['error' => $m->getMessage()], JsonResponse::HTTP_NO_CONTENT);
		}
    }

	/*public function isSecure() 
	{
		if ( $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' && $_SERVER['HTTP_HTTPS'] == 'on' ) {
			return true;
		} else {
			return false;
		}
	}*/

}
