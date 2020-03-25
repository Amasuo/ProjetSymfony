<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Doctor;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/adminprofile", name="adminprofile")
     */
     public function adminProfile(){
         return $this->render('admin/profile.html.twig', [
             'controller_name' => 'AdminController',
         ]);
     }

     /**
      * @Route("/admintables", name="admintables")
      */
      public function adminTables(){
          $entityManager = $this->getDoctrine()->getManager();
          $listUsers = $entityManager->getRepository(User::class)->findAll();
          $listDoctors = $entityManager->getRepository(Doctor::class)->findAll();

          return $this->render('admin/tables.html.twig', [
              'controller_name' => 'AdminController',
              'listUsers' => $listUsers,
              'listDoctors' => $listDoctors
          ]);
      }

     /**
      * @Route("/admininbox", name="admininbox")
      */
      public function adminInbox(){
          return $this->render('admin/inbox.html.twig', [
              'controller_name' => 'AdminController',
          ]);
      }

      /**
      * @Route("/becomeadmin/{id}", name="becomeadmin")
      * @param User $user
      */
      public function becomeAdmin($id, Request $request){
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        $user->addRole('ROLE_ADMIN');
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('admintables');
      }

      /**
      * @Route("/becomedoctor/{id}", name="becomedoctor")
      * @param User $user
      */
      public function becomeDoctor($id, Request $request){
        $entityManager = $this->getDoctrine()->getManager();

        $doctor = $entityManager->getRepository(Doctor::class)->find($id);
        $doctor->setB(true);

        $user = $entityManager->getRepository(User::class)->findOneBy(['email'=>$doctor->getEmail()]);
        $user->addRole('ROLE_DOCTOR');

        $entityManager->persist($doctor);
        $entityManager->flush();
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('admintables');
      }

}
