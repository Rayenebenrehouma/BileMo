<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CustomerRepository;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use JMS\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    #[Route('/api/users', name: 'api_get_users', methods: ['GET'])]
    public function GetUsers(CustomerRepository $customerRepository,UserRepository $userRepository,SerializerInterface $serializer, Request $request): JsonResponse
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 3);

        $customer = $this->getUser();
        $users = $userRepository->findAllWithPagination($customer, $page, $limit);
        $context = SerializationContext::create()->setGroups(['ShowUsers']);
        $jsonUsersList = $serializer->serialize($users, 'json', $context);

        return new JsonResponse($jsonUsersList, Response::HTTP_OK, [], true);

    }

    #[Route('/api/users/{userId}', name: 'api_get_user_details', methods: ['GET'])]
    public function GetUsersDetails(CustomerRepository $customerRepository,UserRepository $userRepository,SerializerInterface $serializer,AuthorizationCheckerInterface $checkAuthorization, int $userId): JsonResponse
    {
        $customer = $this->getUser();

        $user = $userRepository->find($userId);

        if ($customer == $user->getCustomer()){
            $context  = SerializationContext::create()->setGroups(['ShowUsers','ShowUsersDetails']);
            $context1 = SerializationContext::create()->setGroups(['ShowUsersDetails']);
            $jsonUserDetails = $serializer->serialize($user, 'json', $context);


            return new JsonResponse(
                $jsonUserDetails, Response::HTTP_OK, [], true,

            );

        }else{
            return new JsonResponse(Response::HTTP_NO_CONTENT);
        }
    }

    #[Route('/api/users/{userId}', name: 'api_delete_user', methods: ['DELETE'])]
    public function DeleteUser(CustomerRepository $customerRepository,UserRepository $userRepository,SerializerInterface $serializer,EntityManagerInterface $em, int $userId): JsonResponse
    {
        $customer = $this->getUser();
        $user = $userRepository->find($userId);

            if ($customer === $user->getCustomer()) {

                $em->remove($user);
                $em->flush();

                return new JsonResponse(null, Response::HTTP_NO_CONTENT);

            } else {

                return new JsonResponse(Response::HTTP_BAD_REQUEST);
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