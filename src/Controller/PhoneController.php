<?php

namespace App\Controller;

use App\Entity\Phone;
use App\Repository\PhoneRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializerInterface;

class PhoneController extends AbstractController
{
    #[Route('/api/phones', name: 'phone', methods: ['GET'])]
    public function getPhoneList(PhoneRepository $phoneRepository, SerializerInterface $serializer, Request $request): JsonResponse
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 3);

        $phoneList = $phoneRepository->findAllWithPagination($page, $limit);
        $jsonPhoneList = $serializer->serialize($phoneList, 'json');
        //limiter les info

        return new JsonResponse($jsonPhoneList, Response::HTTP_OK, [], true);
    }

    //Détails des téléphone
    #[Route('/api/phones/{id}', name: 'phoneDetails', methods: ['GET'])]
    public function getPhoneDetails(SerializerInterface $serializer, PhoneRepository $phoneRepository, $id)
    {
        $phone = $phoneRepository->find($id);
        if ($phone === null){
            $data = [
                'status' => "404",
                'message' => "Le téléphone n'existe pas en base de donnée"
            ];
            return new JsonResponse($data);
        }

        $jsonPhone = $serializer->serialize($phone, 'json');
        return new JsonResponse($jsonPhone, Response::HTTP_OK, [], true);
    }
}
