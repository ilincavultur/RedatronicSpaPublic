<?php

namespace App\Controller;


use App\Entity\Membership;
use App\Entity\MemReception;
use App\Entity\Reception;
use App\Form\ChooseMembershipType;
use App\Form\ReceptionType;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReceptionController
 * @package App\Controller
 * @Route("Reception")
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

        $reception = new Reception();

        $form = $this->createForm(ReceptionType::class, $reception);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $reception->setAge($form->get('age')->getData());
            $reception->setPackage($form->get('package')->getData());
            $reception->setCredit($form->get('credit')->getData());
            $reception->setProducts($form->get('products')->getData());

            if($reception->getAge() == Reception::TYPE_ADULT){
                $reception->setTotalAccess($reception->getPackage()->getPriceAdult());
            }else{
                $reception->setTotalAccess($reception->getPackage()->getPriceChild());
            }

            $arr = $reception->getProducts()->toArray();

            $sum = 0;
            foreach ($arr as $p) {
                $sum += $p->getPrice();
            }

            $reception->setTotalServices($sum);

            $reception->setTotalSum($reception->getTotalServices() + $reception->getTotalAccess() + $reception->getCredit());

            $em->persist($form->getData());

            $em->flush();
            return $this->redirect($this->generateUrl('app_new_circuit', array(
                'id' => $reception->getId())));
        }

        return $this->render(
            'reception/addNewCard.html.twig',
            [
                'user_form' => $form->createView()
            ]
        );

    }

    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("/addMemReception", name="app_new_rec")
     */
    public function addMembershipReception(EntityManagerInterface $em, Request $request)
    {

        $memreception = new MemReception();
        $form = $this->createForm(ChooseMembershipType::class, $memreception);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            //$memreception->setRfid('d');

            $membership = $form->get('membership')->getData();

            $repository = $this->getDoctrine()->getRepository(Membership::class);

            $m = $repository->find($membership->getId());

            $memreception->setRfid($m->getRFID());
            $memreception->setPackage($m->getPackage());
            $memreception->setAge($m->getAge());
            $memreception->setClientName($m->getClientName());

            $em->persist($form->getData());

            $em->flush();

            return $this->redirect($this->generateUrl('app_new_memcircuit', array(
                'id' => $memreception->getId())));
        }
        return $this->render(
            'reception/addMembershipCard.html.twig',
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
        $receptionRepository = $this->getDoctrine()->getRepository(Reception::class);
        $qbr = $receptionRepository->findReceptions($request->get('search'));

        $page = $request->get('page');
        $pager = new Pagerfanta(new DoctrineORMAdapter($qbr));
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
     * @Route("/memlist", name="app_memreception_list")
     */
    public function listMemAction(Request $request)
    {

        $memreceptionRepository = $this->getDoctrine()->getRepository(MemReception::class);
        $qbm = $memreceptionRepository->findMemReceptions($request->get('search'));

        $page = $request->get('page');
        $pager = new Pagerfanta(new DoctrineORMAdapter($qbm));
        $pager->setCurrentPage($page?$page:1);
        $pager->getNbResults();

        return $this->render(
            'reception/memlist.html.twig',
            [
                'pager' => $pager
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

    /**
     * @param MemReception $memreception
     * @return Response
     * @Route("/showMemDetails/{id}", name="app_reception_showMemDetails")
     */
    public function showMemDetails(MemReception $memreception)
    {
        # $this->denyAccessUnlessGranted('ROLE_USER',null, 'Unable to access this page!');
        return $this->render('reception/showMemDetails.html.twig', array(
            'memreception' => $memreception
        ));

    }

    /**
     * @param Reception $reception
     * @return RedirectResponse
     * @Route("/delete/{id}", name="app_reception_delete")
     */
    public function receptionDelete(Reception $reception)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reception);
        $entityManager->flush();

        return $this->redirectToRoute('app_reception_list');

    }

    /**
     * @param MemReception $memreception
     * @return RedirectResponse
     * @Route("/deletemem/{id}", name="app_memreception_delete")
     */
    public function memreceptionDelete(MemReception $memreception)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($memreception);
        $entityManager->flush();

        return $this->redirectToRoute('app_memreception_list');

    }


}
