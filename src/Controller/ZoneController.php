<?php


namespace App\Controller;


use App\Entity\Zone;
use App\Form\ZoneType;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ZoneController
 * @package App\Controller
 * @Route("/Spa/Zone")
 */
class ZoneController extends AbstractController
{

    /**
     * @Route("/addZone", name="app_new_zone")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return RedirectResponse|Response
     */
    public function addZone(EntityManagerInterface $em , Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(ZoneType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em->persist($form->getData());
            $errors = $validator->validate($em);
            if (count($errors) > 0) {

                $errorsString = (string) $errors;

                return new Response($errorsString);
            }
            $em->flush();
            return $this->redirect($this->generateUrl('app_zone_list'));
        }
        return $this->render(
            'Zone/addZone.html.twig',
            [
                'user_form' => $form->createView()
            ]
        );

    }


    /**
     * @Route("/list", name="app_zone_list")
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request)
    {
        $zoneRepository = $this->getDoctrine()->getRepository(Zone::class);
        $qb = $zoneRepository->findZones($request->get('search'));

        $page = $request->get('page');
        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pager->setCurrentPage($page?$page:1);
        $pager->getNbResults();

        return $this->render(
            'Zone/list.html.twig',
            [
                'pager' => $pager
            ]
        );

    }

    /**
     * @Route("/delete/{id}", name="app_zone_delete")
     * @param Zone $zone
     * @return RedirectResponse
     */
    public function zoneDelete(Zone $zone)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($zone);
        $entityManager->flush();

        return $this->redirectToRoute('app_zone_list');

    }

    /**
     * @Route("/edit/{id}", name="app_zone_edit")
     * @param Request $request
     * @param Zone $zone
     * @return Response
     */
    public function update(Request $request, Zone $zone)
    {
        $entityManager = $this->getDoctrine()->getManager();


        $form = $this->createForm(ZoneType::class, $zone);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){

            $entityManager->flush();

            return $this->redirectToRoute('app_zone_list');
        }

        return $this->render(
            'Zone/editZone.html.twig',
            [
                'user_form' => $form->createView()
            ]
        );
    }



}