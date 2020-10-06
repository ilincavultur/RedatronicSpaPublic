<?php

namespace App\Controller;

use App\Entity\Circuit;
use App\Entity\MemReception;
use App\Entity\Reception;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CircuitController
 * @package App\Controller
 * @Route("Circuit")
 */
class CircuitController extends AbstractController
{
    /**
     * @param EntityManagerInterface $em
     * @param Reception $reception
     * @return RedirectResponse|Response
     * @Route("/startCircuit/{id}", name="app_new_circuit")
     */
    public function startCircuit(EntityManagerInterface $em, Reception $reception)
    {

        $circuitRepository = $this->getDoctrine()->getRepository(Circuit::class);

        $array = $circuitRepository->findAllWithSameRfid($reception->getRfid());
        if($array == null){

            $circuit = new Circuit();

            $circuit->setRfid($reception->getRfid());
            $circuit->setIsOpen(true);

            $em->persist($circuit);

            $em->flush();

            return $this->redirect($this->generateUrl('app_circuit_list'));
        }

        $ok = true;
        foreach ($array as &$value){
            if ($value->getIsOpen() != false){

                $ok = false;

            }
        }
        if ($ok == false){
            $this->createNotFoundException("cannot start new circuit bc it is already open");
            //$this->addFlash('error', 'cannot start new circuit bc it is already open');
            return $this->redirect($this->generateUrl('app_circuit_list'));
        }else{
            $circuit = new Circuit();

            $circuit->setRfid("fsdsdf");
            $circuit->setIsOpen(true);

            $em->persist($circuit);

            $em->flush();

            return $this->redirect($this->generateUrl('app_circuit_list'));
        }

    }

    /**
     * @param EntityManagerInterface $em
     * @param MemReception $memreception
     * @return RedirectResponse
     * @Route("/startMemCircuit/{id}", name="app_new_memcircuit")
     */
    public function startMemCircuit(EntityManagerInterface $em, MemReception $memreception)
    {

        $circuitRepository = $this->getDoctrine()->getRepository(Circuit::class);
        $array = $circuitRepository->findAllWithSameRfid($memreception->getRfid());

        if($array == null){
            $circuit = new Circuit();

            $circuit->setRfid($memreception->getRfid());
            $circuit->setIsOpen(true);

            $em->persist($circuit);

            $em->flush();

            return $this->redirect($this->generateUrl('app_circuit_list'));
        }

        $ok = true;
        foreach ($array as &$value){
            if ($value->getIsOpen() != false){

                $ok = false;

            }
        }
        if ($ok == false){
            $this->createNotFoundException("cannot start new circuit bc it is already open");
            //$this->addFlash('error', 'cannot start new circuit bc it is already open');
            return $this->redirect($this->generateUrl('app_circuit_list'));
        }else{
            $circuit = new Circuit();

            $circuit->setRfid($memreception->getRfid());
            $circuit->setIsOpen(true);

            $em->persist($circuit);

            $em->flush();

            return $this->redirect($this->generateUrl('app_circuit_list'));
        }
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/list", name="app_circuit_list")
     */
    public function listAction(Request $request)
    {
        $circuitRepository = $this->getDoctrine()->getRepository(Circuit::class);
        $qb = $circuitRepository->findCircuits($request->get('search'));

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
        $circuit->setIsOpen(false);

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
