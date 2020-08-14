<?php


namespace App\Controller;

use App\Entity\Membership;
use App\Entity\Package;
use App\Form\MembershipType;
use App\Form\PackageType;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MembershipController
 * @package App\Controller
 * @Route("/Spa/Membership")
 */
class MembershipController extends AbstractController
{

    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("/addMembership", name="app_new_membership")
     *
     */
    public function addMembership(EntityManagerInterface $em , Request $request)
    {

        $form = $this->createForm(MembershipType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em->persist($form->getData());

            $em->flush();
            return $this->redirect($this->generateUrl('app_membership_list'));
        }
        return $this->render(
            'Membership/addMembership.html.twig',
            [
                'user_form' => $form->createView()
            ]
        );

    }

    /**
     * @Route("/list", name="app_membership_list")
     * @param Request $request
     * @return Response
     *
     *
     *
     */
    public function listAction(Request $request)
    {


        $zoneRepository = $this->getDoctrine()->getRepository(Membership::class);
        $qb = $zoneRepository->findMemberships($request->get('search'));

        $page = $request->get('page');
        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pager->setCurrentPage($page?$page:1);
        $pager->getNbResults();

        return $this->render(
            'Membership/list.html.twig',
            [
                'pager' => $pager
            ]
        );



    }

    /**
     * @Route("/delete/{id}", name="app_membership_delete")
     * @param Membership $membership
     * @return RedirectResponse
     *
     */
    public function membershipDelete(Membership $membership)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($membership);
        $entityManager->flush();

        return $this->redirectToRoute('app_membership_list');

    }

    /**
     * @Route("/edit/{id}", name="app_membership_edit")
     * @param Request $request
     * @param Membership $membership
     * @return Response
     *
     */
    public function update(Request $request, Membership $membership)
    {
        $entityManager = $this->getDoctrine()->getManager();


        $form = $this->createForm(MembershipType::class, $membership);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){

            $entityManager->flush();

            return $this->redirectToRoute('app_membership_list');
        }

        return $this->render(
            'Membership/editMembership.html.twig',
            [
                'user_form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/showDetails/{id}", name="app_membership_showDetails")
     * @param Membership $membership
     * @return Response
     *
     * @Security("is_granted('ROLE_USER')")
     *
     */
    public function showDetails(Membership $membership)
    {

        $this->denyAccessUnlessGranted('ROLE_USER',null, 'Unable to access this page!');

        return $this->render('Membership/showDetails.html.twig', array(
            'membership' => $membership
        ));


    }
}