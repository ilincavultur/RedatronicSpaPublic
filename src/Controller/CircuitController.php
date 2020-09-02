<?php

namespace App\Controller;

use App\Entity\Circuit;
use App\Entity\Membership;
use App\Entity\Product;
use App\Entity\Reception;
use App\Form\CircuitType;
use App\Form\MembershipType;
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
     * @param Reception $reception
     * @return RedirectResponse|Response
     * @Route("/startCircuit/{Rfid}", name="app_new_circuit")
     */
    public function startCircuit(EntityManagerInterface $em, Reception $reception)
    {

        $circuit = new Circuit();

        $circuit->setRfid($reception->getRfid());

        $circuit->setIsOpen(true);


        $em->persist($circuit);

        $em->flush();
        return $this->redirect($this->generateUrl('app_circuit_list'));




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

    /**
     * @param Circuit $circuit
     * @return RedirectResponse
     * @Route("/delete/{id}", name="app_circuit_delete")
     */
    public function circuitDelete(Circuit $circuit)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($circuit);
        $entityManager->flush();

        return $this->redirectToRoute('app_circuit_list');

    }

}
