<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Doctor;
use App\Entity\User;
use App\Entity\Message;
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
        // affichage des tables de la BD
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
        // affichage des messages envoyés à partir de 'Contact'
          $entityManager = $this->getDoctrine()->getManager();
          $listMessages = $entityManager->getRepository(Message::class)->findAll();

          return $this->render('admin/inbox.html.twig', [
              'controller_name' => 'AdminController',
              'listMessages' => $listMessages
          ]);
      }

      /**
      * @Route("/becomeadmin/{id}", name="becomeadmin")
      * @param User $user
      */
      public function becomeAdmin($id, Request $request){
        // pour donner le privilège 'ADMIN' à un utilisateur
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
        // pour donner le privilège 'DOCTOR' à un utilisateur
        $entityManager = $this->getDoctrine()->getManager();

        $doctor = $entityManager->getRepository(Doctor::class)->find($id);
        $doctor->setB(true);

        $user = $entityManager->getRepository(User::class)->findOneBy(['email'=>$doctor->getEmail()]);
        $user->addRole('ROLE_DOCTOR');

        //ajouter les modifications dans la BD
        $entityManager->persist($doctor);
        $entityManager->flush();
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('admintables');
      }

      /**
       * @Route("/hidemessage/{id}", name="hidemessage")
       */
       public function hideMessage($id, Request $request){
         // pour ne plus afficher un message déja lu (dans admininbox)
         $entityManager = $this->getDoctrine()->getManager();
         $message = $entityManager->getRepository(Message::class)->find($id);
         $message->setHide(true);
         $entityManager->persist($message);
         $entityManager->flush();
         return $this->redirectToRoute('admininbox');
       }
}
