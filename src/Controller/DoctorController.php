<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Doctor;
use App\Entity\User;
use App\Form\DoctorType;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
            $uploadedFile = $form['image']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/img/doctor';
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move(
                $destination,
                $newFilename
            );
            $doctor->setImg($newFilename);

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

  /**
     * @Route("/finddoctor/{id}", name="doctor")
     */
    public function findd($id )
    {
        $j=$this->getDoctrine()->getRepository(doctor::class)->find($id);
        return $this->render('security/profil.html.twig', ['doctor' =>$j,
        ]);   
    }

}
