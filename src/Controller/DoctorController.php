<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Doctor;
use App\Entity\User;
use App\Form\DoctorType;


use App\Security\UsersAuthenticator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;


class DoctorController extends AbstractController
{
    /**
     * @Route("/doctor/{id}", name="doctor")
     */
    public function index($id ,Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UsersAuthenticator $authenticator): Response
    {
        $user=$this->getDoctrine()->getRepository(User::class)->find($id);
        $doctor=new Doctor();
        $doctor->setName($user->getName());
        $doctor->setLastname($user->getLastname());
        $doctor->setPhone($user->getPhone());
        $doctor->setB(false);
        $doctor->setEmail($user->getEmail());


        $form = $this->createForm(DoctorType::class, $doctor);
        //$form->handleRequest($request);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($doctor);
            $entityManager->flush();

            // do anything else you need here, like send an email

           /* return $guardHandler->authenticateUserAndHandleSuccess(
                $doctor,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );*/

        }
        return $this->render('security/RegisterAsDoctor.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
