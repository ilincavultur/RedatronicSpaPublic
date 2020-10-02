<?php


namespace App\Controller;

use App\Entity\Package;
use App\Form\PackageType;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class PackageController
 * @package App\Controller
 * @Route("/Spa/Package")
 */
class PackageController extends AbstractController
{

    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("/addPackage", name="app_new_package")
     * @Security("is_granted('ROLE_USER')")
     */
    public function addPackage(EntityManagerInterface $em , Request $request)
    {
        $form = $this->createForm(PackageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em->persist($form->getData());

            $em->flush();
            return $this->redirect($this->generateUrl('app_package_list'));
        }
        return $this->render(
            'Package/addPackage.html.twig',
            [
                'user_form' => $form->createView()
            ]
        );

    }

    /**
     * @Route("/list", name="app_package_list")
     * @param Request $request
     * @return Response
     * @Security("is_granted('ROLE_USER')")
     *
     */
    public function listAction(Request $request)
    {
        $zoneRepository = $this->getDoctrine()->getRepository(Package::class);
        $qb = $zoneRepository->findPackages($request->get('search'));

        $page = $request->get('page');
        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pager->setCurrentPage($page?$page:1);
        $pager->getNbResults();

        return $this->render(
            'Package/list.html.twig',
            [
                'pager' => $pager
            ]
        );



    }

    /**
     * @Route("/delete/{id}", name="app_package_delete")
     * @param Package $package
     * @return RedirectResponse
     * @Security("is_granted('ROLE_USER')")
     */
    public function packageDelete(Package $package)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($package);
        $entityManager->flush();

        return $this->redirectToRoute('app_package_list');

    }

    /**
     * @Route("/edit/{id}", name="app_package_edit")
     * @param Request $request
     * @param Package $package
     * @return Response
     * @Security("is_granted('ROLE_USER')")
     */
    public function update(Request $request, Package $package)
    {
        $entityManager = $this->getDoctrine()->getManager();


        $form = $this->createForm(PackageType::class, $package);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){

            $entityManager->flush();

            return $this->redirectToRoute('app_package_list');
        }

        return $this->render(
            'Package/editPackage.html.twig',
            [
                'user_form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/showDetails/{id}", name="app_package_showDetails")
     * @param Package $package
     * @return Response
     * @Security("is_granted('ROLE_USER')")
     */
    public function showDetails(Package $package)
    {

        return $this->render('Package/showDetails.html.twig', array(
            'package' => $package
        ));


    }





}
