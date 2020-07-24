<?php


namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Form\FormTypeInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;




/**
 * Class ProductController
 * @package App\Controller
 * @Route("/Spa")
 */
class ProductController extends AbstractController
{


    /**
     * @Route ("/addProduct", name="app_new_product")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function addProduct(EntityManagerInterface $em ,Request $request)
    {
        $form = $this->createForm(\ProductType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $product = new Product();
            $product->setName($data->getName());
            $product->setCode($data->getCode());
            $product->setBarcode($data->getBarcode());
            $product->setPrice($data->getPrice());
            $product->setWeekendPrice($data->getWeekendPrice());
            $product->setType($data->getType());




            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('app_product_list');
        }
        return $this->render(
            'Product/addProduct.html.twig',
            [
                'user_form' => $form->createView()
            ]
        );

    }


    /**
     * @Route("/list", name="app_product_list")
     *
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function listAction(ProductRepository $productRepository)
    {
        $products = $productRepository->findAll();

        return $this->render('Product/list.html.twig', [
            'products'=>$products
        ]);

    }

    /**
     * @Route("/{id}/delete", name="app_product_delete")
     * @param $id
     * @return RedirectResponse
     *
     */
    public function productDelete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        $entityManager->remove($product);
        $entityManager->flush();
        return $this->redirectToRoute('app_product_list');
    }

    /**
     * @Route("/edit/{id}")
     * @param $id
     * @return RedirectResponse
     */
    public function update($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $product->setName('New product name!');
        $entityManager->flush();

        return $this->redirectToRoute('app_product_list', [
            'id' => $product->getId()
        ]);
    }



    /**
     * @Route("/{id}/info", name="app_product_info")
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function productInfo(Product $product)
    {
        $response = ['id' => $product->getId(), 'name' => $product->getName(), 'code' => $product->getCode(), 'price' => $product->getPrice()];
        return new JsonResponse($response);
    }








}






