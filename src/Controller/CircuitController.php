<?php

namespace App\Controller;

use App\Entity\Circuit;
use App\Entity\Membership;
use App\Entity\Product;
use App\Form\CircuitType;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CircuitController
 * @package App\Controller
 * @Route("/Spa/Circuit")
 */
class CircuitController extends AbstractController
{
    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route ("/startCircuit", name="app_new_circuit")
     */
    public function startCircuit(EntityManagerInterface $em, Request $request)
    {


        $circuit = new Circuit();




        $form = $this->createForm(CircuitType::class, $circuit);

        $circuit->setIsOpen(true);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){


            $em->persist($form->getData());

            $em->flush();
            return $this->redirect($this->generateUrl('app_circuit_list'));
        }
        return $this->render(
            'Circuit/startCircuit.html.twig',
            [
                'user_form' => $form->createView()
            ]
        );
        /*
        $em = $this->getDoctrine()->getManager();
        $circuit = $em->getRepository(Circuit::class)->find($circuitId);

        if (!$circuit || $circuit->getOpen()==false) {
            $newcircuit = new Circuit();
            $newcircuit->setOpen(true);
            $em->persist($newcircuit);
            $em->flush();
            return $this->redirect($this->generateUrl('app_circuit_list'));
        }
        else{
            throw $this->createNotFoundException(
                'cannot open circuit because it is already open'
            );
        }
        */

    }


    /**
     * @param Request $request
     * @return Response
     * @Route("/list", name="app_circuit_list")
     */
    public function listAction(Request $request)
    {
        $productRepository = $this->getDoctrine()->getRepository(Circuit::class);
        $qb = $productRepository->findCircuits($request->get('search'));

        $page = $request->get('page');
        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pager->setCurrentPage($page?$page:1);
        $pager->getNbResults();

        return $this->render(
            'Circuit/list.html.twig',
            [
                'pager' => $pager
            ]
        );

    }

    /**
     * @param Circuit $circuit
     * @return Response
     * @Route("/edit/{id}", name="app_circuit_edit")
     */
    public function endCircuit(Circuit $circuit)
    {

        $circuit->setEndTime(date_create());
        $circuitRepository = $this->getDoctrine()->getManager();
        $circuitRepository->flush();

        return $this->redirectToRoute('app_circuit_list');

    }
}
