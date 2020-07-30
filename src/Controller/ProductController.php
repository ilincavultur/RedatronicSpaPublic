<?php


namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Form\SearchProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;




/**
 * Class ProductController
 * @package App\Controller
 * @Route("/Spa/Product")
 */
class ProductController extends AbstractController
{


    /**
     * @Route ("/addProduct", name="app_new_product")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return Response
     */
    public function addProduct(EntityManagerInterface $em ,Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(Product\ProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em->persist($form->getData());

            $em->flush();
            return $this->redirect($this->generateUrl('app_product_list'));
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
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request)
    {
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $qb = $productRepository->findProducts($request->get('search'));

        $page = $request->get('page');
        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pager->setCurrentPage($page?$page:1);
        $pager->getNbResults();

        return $this->render(
            'Product/list.html.twig',
            [
                'pager' => $pager
            ]
        );

    }


    /**
     * @Route("/delete/{id}", name="app_product_delete")
     * @param Product $product
     * @return RedirectResponse
     */
    public function productDelete(Product $product)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('app_product_list');

    }

    /**
     * @Route("/edit/{id}", name="app_product_edit")
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function update(Request $request, Product $product)
    {
        $entityManager = $this->getDoctrine()->getManager();


        $form = $this->createForm(Product\ProductType::class, $product);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){

            $entityManager->flush();

            return $this->redirectToRoute('app_product_list');
        }

        return $this->render(
            'Product/editProduct.html.twig',
            [
                'user_form' => $form->createView()
            ]
        );
    }





















}






