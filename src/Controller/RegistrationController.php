<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;

class RegistrationController extends AbstractController
{
    #[Route(path: '/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordEncoder, ManagerRegistry $em): Response
    {
        if ($this->getUser() instanceof UserInterface) {
            return $this->redirectToRoute('index');
        }

        if ($request->isMethod('POST')) {
            $username = $request->request->get('username');
            $password = $request->request->get('password');

            $user = new User();
            $user->setUsername($username);

            $em = $em->getManager();
            $encodedPassword = $passwordEncoder->hashPassword($user, $password);
            $user->setPassword($encodedPassword);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('security/register.html.twig');
    }
}
