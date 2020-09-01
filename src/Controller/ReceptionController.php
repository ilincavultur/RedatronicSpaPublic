<?php

namespace App\Controller;

use App\Entity\Membership;
use App\Entity\Package;
use App\Entity\Product;
use App\Entity\Reception;
use App\Entity\Zone;
use App\Form\PackageType;
use App\Form\ReceptionType;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReceptionController
 * @package App\Controller
 * @Route("/Spa/Reception")
 *
 */
class ReceptionController extends AbstractController
{
    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("/addReception", name="app_new_reception")
     */
    public function addSimpleReception(EntityManagerInterface $em , Request $request)
    {
        $form = $this->createForm(ReceptionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em->persist($form->getData());

            $em->flush();
            return $this->redirect($this->generateUrl('app_reception_list'));
        }
        return $this->render(
            'reception/simplecard.html.twig',
            [
                'user_form' => $form->createView()
            ]
        );

    }

    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function addMembershipReception(EntityManagerInterface $em , Request $request)
    {
        $form = $this->createForm(ReceptionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em->persist($form->getData());

            $em->flush();
            return $this->redirect($this->generateUrl('app_reception_list'));
        }
        return $this->render(
            'reception/simplecard.html.twig',
            [
                'user_form' => $form->createView()
            ]
        );

    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/list", name="app_reception_list")
     */
    public function listAction(Request $request)
    {
        $zoneRepository = $this->getDoctrine()->getRepository(Reception::class);
        $qb = $zoneRepository->findReceptions($request->get('search'));

        $page = $request->get('page');
        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pager->setCurrentPage($page?$page:1);
        $pager->getNbResults();

        return $this->render(
            'reception/list.html.twig',
            [
                'pager' => $pager
            ]
        );



    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/decision", name="app_decision")
     */
    public function decision(Request $request)
    {


        return $this->render(
            'reception/decision.html.twig',
            [

            ]
        );



    }

    /**
     * @param Reception $reception
     * @return Response
     * @Route("/showDetails/{id}", name="app_reception_showDetails")
     */
    public function showDetails(Reception $reception)
    {

        # $this->denyAccessUnlessGranted('ROLE_USER',null, 'Unable to access this page!');

        return $this->render('reception/showDetails.html.twig', array(
            'reception' => $reception
        ));


    }


}
