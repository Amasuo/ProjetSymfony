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
     * @Route("/doctor", name="doctor")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UsersAuthenticator $authenticator): Response
    {
        $doctor = new Doctor();
        //$user= new User($this->getUser());
        //$doctor->setName($user->getName());
        $form = $this->createForm(DoctorType::class, $doctor);
        //$form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($doctor);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $doctor,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );

        }
        return $this->render('doctor/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/showuser/{id}", name="showUser")
     */
    public function showUser($id){
        $user=$this->getDoctrine()->getRepository(user::class)->find($id);
        $entityManager=$this->getDoctrine()->getManager();

        $doctor=new Doctor();
        $doctor->setName($user->getName());
        $doctor->setLastname($user->getLastname());
        $doctor->setPhone($user->getPhone());
        $doctor->setB(false);
        $doctor->setEmail($user->getEmail());

        $entityManager->persist($doctor);
        $entityManager->flush();
        return new Response ('Demand sent'.$doctor->getId());

        //return new Response($user->getName());
    }



}
