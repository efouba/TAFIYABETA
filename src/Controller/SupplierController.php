<?php

namespace App\Controller;

use App\Entity\Retailler;
use App\Entity\Supplier;
use App\Entity\User;
use App\Repository\RetaillerRepository;
use App\Repository\SupplierRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SupplierController extends AbstractController
{
    #[Route('/api/suppliers', name: 'get_supplier',methods:['GET'])]
    public function index(Request $request,SerializerInterface $serializer,SupplierRepository $supplierRepository): JsonResponse
    {
        $SupplierList =$supplierRepository->findAll();

        $jsonSupplierList = $serializer->serialize($SupplierList, 'json', ['groups' => 'getSupplier']);
        return new JsonResponse($jsonSupplierList , Response::HTTP_OK, [], true);
    }

    #[Route('/api/Supplier/{id}', name: 'get_supplier', methods: ['GET'])]
    public function getDetaillant(Supplier $supplier, int $id,SupplierRepository $supplierRepository,SerializerInterface $serializer): JsonResponse
    {
        $jsonSupplier = $serializer->serialize($supplier, 'json', ['groups' => 'getSupplier']);
        return new JsonResponse($jsonSupplier, Response::HTTP_OK, [], true);
     
    }


    
     #[Route("/api/supplier", name:"add_fournisseur", methods:["POST"])]
     
    public function addFournisseur(Request $request,RetaillerRepository $retaillerRepository,
    EntityManagerInterface $en,ValidatorInterface $validatorInterface,SerializerInterface $serializer,Security $security): JsonResponse
    {

        $user = $security->getUser();
    if (!$user) {
        return new JsonResponse(['error' => 'Unauthorized'], JsonResponse::HTTP_UNAUTHORIZED);
    }
        // Récupérer l'ID du détaillant associé à partir de l'URL ou d'autres méthodes
        $detaillantId = $request->query->getInt('retailler_id');
 
        // Vérifier si le détaillant est associé à l'utilisateur connecté
       
    
        $detaillant = $retaillerRepository->find($detaillantId);
        if (!$detaillant || $detaillant->getUser() !== $user) {
            return new JsonResponse(['error' => 'Unauthorized'],JsonResponse::HTTP_UNAUTHORIZED);
        }

        $data = json_decode($request->getContent(), true);

        // Créer une nouvelle instance de Fournisseur
        $fournisseur = new Supplier();
        // Vérifier si la clé 'name' existe dans le tableau $data
        $name = isset($data['name']) ? $data['name'] : null;

        if ($name === null) {
        // Gérer le cas où la clé 'name' n'est pas présente dans le tableau
        return new JsonResponse(['error' => 'Le champ "name" est requis'], JsonResponse::HTTP_BAD_REQUEST);
        }
        $fournisseur->setName($data['name']);
        $fournisseur->setHisLastness($data['his_lastness']);
        $fournisseur->setFunctioning($data['functioning']);
        $fournisseur->setPlace($data['place']);
        $fournisseur->setTransportCost($data['transport_cost']);

        //$fournisseur->setName($request->request->get('name')); 
        // Associer l'ID du détaillant au fournisseur
        $fournisseur->setRetailler($detaillant);

        // Validation des données
        $errors=$validatorInterface->validate($fournisseur);
        if ($errors->count()>0) {
            return new JsonResponse($serializer->serialize($errors,'json'),JsonResponse::HTTP_BAD_REQUEST,[],true);
        }

        // Enregistrer le fournisseur dans la base de données
        $en->persist($fournisseur);
        $en->flush();

        return new JsonResponse(['message' => 'Fournisseur ajouté avec succès'], JsonResponse::HTTP_CREATED);
    }

    #[Route("/api/supplier/{id}", name:"Update_Supplier", methods:["PUT"])]
    public function updateSupplierInfo(
        Request $request, int $id,SupplierRepository $SupplierRepository,Security $security,ValidatorInterface $validator
        ,Retailler $currentRetailler,SerializerInterface $serializer,EntityManagerInterface $em,UserRepository $userRepository): JsonResponse
    {
       // Récupérer l'utilisateur connecté (recenseur)
        $recenseur = $security->getUser();
      

        $supplier = $SupplierRepository->find($id);
        if (!$supplier) {
            return new JsonResponse(['error' => 'Fournisseur not found'], 404);
        }
         // Vérifier si le fournisseur est associé au détaillant enregistré par le recenseur
    if (!$this->isFournisseurAssociatedToRecenseur($supplier, $recenseur)) {
        return new JsonResponse(['error' => 'Unauthorized'], JsonResponse::HTTP_UNAUTHORIZED);
    }
    $data = json_decode($request->getContent(), true);
    $supplier->setName($data['name']);
    $supplier->setHisLastness($data['his_lastness']);
    $supplier->setFunctioning($data['functioning']);
    $supplier->setPlace($data['place']);
    $supplier->setTransportCost($data['transport_cost']);

    $errors = $validator->validate($supplier);
    if (count($errors) > 0) {
        return new JsonResponse($errors, JsonResponse::HTTP_BAD_REQUEST);
    }

        // Modifier une information spécifique du détaillant
        // $detaillant->setName($data['name']);
        // $detaillant->setCountry($data['contry']);
       
        $em->flush();
        return new JsonResponse(['message' => 'Fournisseur information updated successfully']);
     }
     private function isFournisseurAssociatedToRecenseur(Supplier $supplier, $recenseur): bool
{
    // Implémenter la logique pour vérifier si le fournisseur est associé au détaillant enregistré par le recenseur
    // Par exemple, vous pouvez vérifier si le détaillant du fournisseur appartient au recenseur
    $detaillant = $supplier->getRetailler();
    if ($detaillant && $detaillant->getUser() === $recenseur) {
        return true;
    }
    return false;
}

#[Route('/api/supplier/{id}', name: 'delete_supplier', methods: ['DELETE'])]
public function deleteDetaillant(int $id, SupplierRepository $supplierRepository,EntityManagerInterface $entityManager): JsonResponse
{
    $supplier = $supplierRepository->find($id);
    if (!$supplier) {
        return new JsonResponse(['error' => 'supplier not found'], 404);
    }

    $entityManager->remove($supplier);
    $entityManager->flush();

    return new JsonResponse(['message' => 'supplier deleted successfully']);
}
}
