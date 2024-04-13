<?php

namespace App\Controller;

use App\Entity\Retailler;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\RetaillerRepository;
use App\Repository\ProductRepository;
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

class ProductController extends AbstractController
{
    #[Route('/api/products', name: 'get_supplier',methods:['GET'])]
    public function index(Request $request,SerializerInterface $serializer,ProductRepository $productRepository): JsonResponse
    {
        $SupplierList =$productRepository->findAll();

        $jsonSupplierList = $serializer->serialize($SupplierList, 'json', ['groups' => 'getProduct']);
        return new JsonResponse($jsonSupplierList , Response::HTTP_OK, [], true);
    }

    #[Route('/api/product/{id}', name: 'get_product', methods: ['GET'])]
    public function getProduct(Product $product, int $id,ProductRepository $productRepository,SerializerInterface $serializer): JsonResponse
    {
        $jsonProduct = $serializer->serialize($product, 'json', ['groups' => 'getProduct']);
        return new JsonResponse($jsonProduct , Response::HTTP_OK, [], true);
     
    }


    
     #[Route("/api/product", name:"add_product", methods:["POST"])]
     
    public function addProduct(Request $request,RetaillerRepository $retaillerRepository,
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
        $product = new Product();
        // Vérifier si la clé 'name' existe dans le tableau $data
        $name = isset($data['designation']) ? $data['designation'] : null;

        if ($name === null) {
        // Gérer le cas où la clé 'name' n'est pas présente dans le tableau
        return new JsonResponse(['error' => 'Le champ "designation" est requis'], JsonResponse::HTTP_BAD_REQUEST);
        }
        $product->setDesignation($data['designation']);
        $product->setQuantity($data['quantity']);
        if (isset($data['delivery_at'])) {
            // Transformez la chaîne de date en objet DateTime et attribuez-la à l'entité
            $dateCreation = new \DateTimeImmutable($data['delivery_at']);
            $product->setDeliveryAt($dateCreation);
        }

        //$fournisseur->setName($request->request->get('name')); 
        // Associer l'ID du détaillant au fournisseur
        $product->setRetailler($detaillant);

        // Validation des données
        $errors=$validatorInterface->validate($product);
        if ($errors->count()>0) {
            return new JsonResponse($serializer->serialize($errors,'json'),JsonResponse::HTTP_BAD_REQUEST,[],true);
        }

        // Enregistrer le fournisseur dans la base de données
        $en->persist($product);
        $en->flush();

        return new JsonResponse(['message' => 'Produit ajouté avec succès'], JsonResponse::HTTP_CREATED);
    }

    #[Route("/api/product/{id}", name:"Update_Product", methods:["PUT"])]
    public function updateSupplierInfo(
        Request $request, int $id,ProductRepository $ProductRepository,Security $security,ValidatorInterface $validator
        ,Retailler $currentRetailler,SerializerInterface $serializer,EntityManagerInterface $em,UserRepository $userRepository): JsonResponse
    {
       // Récupérer l'utilisateur connecté (recenseur)
        $recenseur = $security->getUser();
      

        $product = $ProductRepository->find($id);
        if (!$product) {
            return new JsonResponse(['error' => 'Produit Nin trouve'], 404);
        }
         // Vérifier si le produit est associé au détaillant enregistré par le recenseur
        if (!$this->isProductAssociatedToRecenseur($product, $recenseur)) {
             return new JsonResponse(['error' => 'Unauthorized'], JsonResponse::HTTP_UNAUTHORIZED);
        }
        $data = json_decode($request->getContent(), true);
        $product->setDesignation($data['designation']);
        $product->setQuantity($data['quantity']);
    if (isset($data['delivery_at'])) {
        // Transformez la chaîne de date en objet DateTime et attribuez-la à l'entité
        $dateCreation = new \DateTimeImmutable($data['delivery_at']);
        $product->setDeliveryAt($dateCreation);
    }

        $errors = $validator->validate($product);
        if (count($errors) > 0) {
             return new JsonResponse($errors, JsonResponse::HTTP_BAD_REQUEST);
        }

        // Modifier une information spécifique du détaillant
        // $detaillant->setName($data['name']);
        // $detaillant->setCountry($data['contry']);
       
        $em->flush();
        return new JsonResponse(['message' => 'Produit information updated successfully']);
     }
     private function isProductAssociatedToRecenseur(Product $product, $recenseur): bool
    {
        // Par exemple, vous pouvez vérifier si le détaillant du produit appartient au recenseur
         $detaillant = $product->getRetailler();
        if ($detaillant && $detaillant->getUser() === $recenseur) {

             return true;
        }
     return false;
    }

#[Route('/api/product/{id}', name: 'delete_product', methods: ['DELETE'])]
public function deleteDetaillant(int $id, ProductRepository $productRepository,EntityManagerInterface $entityManager): JsonResponse
{
    $supplier = $productRepository->find($id);
    if (!$supplier) {
        return new JsonResponse(['error' => 'produit non trouve'], 404);
    }

    $entityManager->remove($supplier);
    $entityManager->flush();

    return new JsonResponse(['message' => 'produit suprime avec succes ']);
}
}
