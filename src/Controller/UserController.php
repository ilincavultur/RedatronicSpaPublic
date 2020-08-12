<?php


namespace App\Controller;


use App\Entity\Membership;
use App\Entity\Package;
use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\MembershipType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
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
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     * @Route("/addUser", name="app_new_user")
     */
    public function addUser(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
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
     */
    public function listAction(Request $request)
    {
        $zoneRepository = $this->getDoctrine()->getRepository(User::class);
        $qb = $zoneRepository->findUsers($request->get('search'));

        $page = $request->get('page');
        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pager->setCurrentPage($page ? $page : 1);
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
     */
    public function packageDelete(User $user)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_user_list');

    }
}
