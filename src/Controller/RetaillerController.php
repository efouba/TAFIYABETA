<?php

namespace App\Controller;

use App\Entity\Retailler;
use App\Repository\RetaillerRepository;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface as SerializerSerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route as AnnotationRoute;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class RetaillerController extends AbstractController
{
    private $entityManager;
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    #[Route('/api/detaillants', name: 'get_retailler',methods:['GET'])]
    public function index(TagAwareCacheInterface $cache, Request $request,RetaillerRepository $retaillerRepository,SerializerInterface $serializer): JsonResponse
    { 
        $RetaillerList = $retaillerRepository->findAll();

        $jsonRetaillerList = $serializer->serialize($RetaillerList, 'json', ['groups' => 'getRetailler']);
        return new JsonResponse($jsonRetaillerList, Response::HTTP_OK, [], true);
    }

     
    #[Route("/api/detaillant", name:"add_detaillant", methods:["POST"])]
    public function addDetaillant( RetaillerRepository $retaillerRepository, Request $request,
        SerializerSerializerInterface $serializer, ValidatorInterface $validator ,EntityManagerInterface $en,
        UrlGeneratorInterface $urlGenerator
     ): JsonResponse
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = $this->getUser();

        // Vérifier si l'utilisateur est authentifié
        if (!$user) {
            return new Response('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }
        // Récupérer l'ID de l'utilisateur
        $userId = $user->getUserIdentifier();

        // Récupérer les données du détaillant depuis la requête
        $requestData = json_decode($request->getContent(), true);
        $retailler =$serializer->deserialize($request->getContent(),Retailler::class,'json');
        //On verife les erreurs
        $errors=$validator->validate($retailler);
        if ($errors->count()>0) {
            return new JsonResponse($serializer->serialize($errors,'json'),JsonResponse::HTTP_BAD_REQUEST,[],true);
        }
        $retailler->setUser($user);
        $en->persist($retailler);
        $en->flush();
        return new JsonResponse(['message' => 'Detaillant creer avec succes successfully']);
    }


    #[Route('/api/detaillant/{id}', name: 'get_detaillant', methods: ['GET'])]
    public function getDetaillant(Retailler $retailler, int $id,RetaillerRepository $retaillerRepository,SerializerInterface $serializer): JsonResponse
    {
        $jsonRetailler = $serializer->serialize($retailler, 'json', ['groups' => 'getRetailler']);
        return new JsonResponse($jsonRetailler, Response::HTTP_OK, [], true);
     
    }

     /**
     * @Route("/api/detaillant/{id}", name="update_detaillant", methods={"PUT"})
     */
   
    public function updateDetaillant(Request $request, int $id,RetaillerRepository $retaillerRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $detaillant =$retaillerRepository->find($id);
        if (!$detaillant) {
            return new JsonResponse(['error' => 'Detaillant not found'], 404);
        }

        // Modifier les informations du détaillant
        $detaillant->setName($data['name']);
        // Modifier d'autres champs selon vos besoins

        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Detaillant updated successfully']);
    }

    #[Route('/api/detaillant/{id}', name: 'delete_detaillant', methods: ['DELETE'])]
    public function deleteDetaillant(int $id, RetaillerRepository $retaillerRepository): JsonResponse
    {
        $detaillant = $retaillerRepository->find($id);
        if (!$detaillant) {
            return new JsonResponse(['error' => 'Detaillant not found'], 404);
        }

        $this->entityManager->remove($detaillant);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Detaillant deleted successfully']);
    }

  
    #[Route('/api/detaillant/{id}', name:"update_detaillant", methods:['PUT'])]

    public function updateDetaillantInfo(
        Request $request, int $id,RetaillerRepository $retaillerRepository
        ,Retailler $currentRetailler,SerializerInterface $serializer,
        Security $security,EntityManagerInterface $em,UserRepository $userRepository
        ,ValidatorInterface $validator): JsonResponse
    {
       // Récupérer l'utilisateur connecté (recenseur)
       $recenseur = $security->getUser();

        $data = json_decode($request->getContent(), true);

        $detaillant = $retaillerRepository->find($id);
        if (!$detaillant) {
            return new JsonResponse(['error' => 'Detaillant not found'], 404);
        }

         // Vérifier si le fournisseur est associé au détaillant enregistré par le recenseur
    // if (!$this->isRetaillerAssociatedToRecenseur($detaillant, $recenseur)) {
    //     return new JsonResponse(['error' => 'Unauthorized'], JsonResponse::HTTP_UNAUTHORIZED);
    // }   
    $data = json_decode($request->getContent(), true);
        // Modifier une information spécifique du détaillant
         $detaillant->setName($data['name']);
         $detaillant->setCountry($data['country']);
         $detaillant->setGps($data['gps']);
         $detaillant->setMonthlyCA($data['monthly_ca']);
         $detaillant->setQuarter($data['quarter']);
         $detaillant->setPlaceSaid($data['place_said']);
         $detaillant->setTafiyaInterest($data['tafiya_interest']);
         $detaillant->setExistSupplier($data['exist_supplier']);
         $detaillant->setTakeToMarket($data['take_to_market']);
         $detaillant->setPhoneOne($data['country']);
         $detaillant->setPhoneTwo($data['phoneTwo']);
         $detaillant->setVille($data['ville']);
         $detaillant->setPicture($data['picture']);

         $errors = $validator->validate($detaillant);
         if (count($errors) > 0) {
             return new JsonResponse($errors, JsonResponse::HTTP_BAD_REQUEST);
         }
       // $em->persist($detaillant);
        $em->flush();
        return new JsonResponse(['message' => 'Retailer information updated successfully']);
    }
    // private function isRetaillerAssociatedToRecenseur(Retailler $detaillant, $recenseur): bool
    // {
    //     $detaillant = $detaillant->getUser();
    //     if ($detaillant && $detaillant->getUser() === $recenseur) {
    //     return true;
    //     }
    // return false;
    // }
}
