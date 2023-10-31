<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CustomerRepository;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{

    #[Route('/api/users', name: 'api_get_users', methods: ['GET'])]
    public function GetUsers(CustomerRepository $customerRepository,UserRepository $userRepository,SerializerInterface $serializer): JsonResponse
    {
        $customer = $this->getUser();
        $users = $userRepository->findByCustomer($customer);
        $jsonUsersList = $serializer->serialize($users, 'json', ['groups' => 'ShowUsers']);

        return new JsonResponse($jsonUsersList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/users/{userId}', name: 'api_get_user_details', methods: ['GET'])]
    public function GetUsersDetails(CustomerRepository $customerRepository,UserRepository $userRepository,SerializerInterface $serializer,AuthorizationCheckerInterface $checkAuthorization, int $userId): JsonResponse
    {
        $customer = $this->getUser();

        $user = $userRepository->find($userId);

        if ($customer == $user->getCustomer()){

            $jsonUserDetails = $serializer->serialize($user, 'json', ['groups' => ['ShowUsers','ShowUserDetails']]);


            return new JsonResponse($jsonUserDetails, Response::HTTP_OK, [], true);

        }else{
            return new JsonResponse(Response::HTTP_NO_CONTENT);
        }
    }

    #[Route('/api/users/{userId}', name: 'api_delete_user', methods: ['DELETE'])]
    public function DeleteUser(CustomerRepository $customerRepository,UserRepository $userRepository,SerializerInterface $serializer,EntityManagerInterface $em, int $userId): JsonResponse
    {

        $customer = $this->getUser();
        $user = $userRepository->find($userId);

        if ($customer == $user->getCustomer()){

            $em->remove($user);
            $em->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);

        }else{
            return new JsonResponse(Response::HTTP_NO_CONTENT);
        }
    }

    #[Route('/api/user', name: 'api_post_user', methods: ['POST'])]
    public function AddUser(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator,CustomerRepository $customerRepository): JsonResponse
    {
        $customer = $this->getUser();
        $user = $serializer->deserialize($request->getContent(), User::class, 'json');
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setCustomer($customer);

        $entityManager->persist($user);
        $entityManager->flush();

        $jsonUserDetails = $serializer->serialize($user, 'json', ['groups' => ['ShowUsers','ShowUserDetails']]);

        return new JsonResponse($jsonUserDetails, Response::HTTP_OK, [], true);

    }
}