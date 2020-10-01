<?php


namespace App\Controller;


use App\Entity\Membership;
use App\Entity\Package;
use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\MembershipType;
use App\Form\UserType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController
 * @package App\Controller
 * @Route("/Spa/User")
 */
class UserController extends AbstractController
{
    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     * @Route("/addUser", name="app_new_user")
     */
    public function addUser(Request $request, EntityManagerInterface $em,UserPasswordEncoderInterface $passwordEncoder)
    {

        $form = $this->createForm(UserType::class);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $user = $form->getData();
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);


            $em->persist($user);

            $em->flush();
            return $this->redirect($this->generateUrl('app_login'));


        }
        return $this->render(
            'User/addUser.html.twig',
            [
                'user_form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/list", name="app_user_list")
     * @param Request $request
     * @return Response
     * @Security("is_granted('ROLE_USER')")
     *
     */
    public function listAction(Request $request)
    {
        $zoneRepository = $this->getDoctrine()->getRepository(User::class);
        $qb = $zoneRepository->findUsers($request->get('search'));

        $page = $request->get('page', 1);
        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pager->setCurrentPage($page);
        $pager->getNbResults();

        return $this->render(
            'User/list.html.twig',
            [
                'pager' => $pager
            ]
        );


    }





    /**
     * @Route("/delete/{id}", name="app_user_delete")
     * @param User $user
     * @return RedirectResponse
     * @Security("is_granted('ROLE_ADMIN')")
     *
     *
     */
    public function userDelete(User $user)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_user_list');

    }


    /**
     * @param Request $request
     * @param User $user
     * @return RedirectResponse|Response
     * @Route("/edit/{id}", name="app_user_edit")
     */
    public function update(Request $request, User $user)
    {
        $entityManager = $this->getDoctrine()->getManager();


        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){

            $entityManager->flush();

            return $this->redirectToRoute('app_user_list');
        }

        return $this->render(
            'User/editUser.html.twig',
            [
                'user_form' => $form->createView()
            ]
        );
    }
}
