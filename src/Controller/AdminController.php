<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Doctor;
use App\Entity\User;

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
}
