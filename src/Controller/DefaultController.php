<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Post;
use App\Entity\Message;
use App\Entity\User;
use App\Entity\Doctor;
use App\Entity\Speciality;
use App\Form\ContactType;
use App\Form\SearchType;
class DefaultController extends AbstractController{
   /**
   * @Route("/", name="home")
   */
   public function home():Response{
    // Préparation des listes qu'on va afficher ou bien utiliser
    $entityManager = $this->getDoctrine()->getManager();
    $listUsers = $entityManager->getRepository(User::class)->findAll();
    $listDoctors = $entityManager->getRepository(Doctor::class)->findAll();
    $listPosts = $entityManager->getRepository(Post::class)->findBy(['type'=>'blog']);

    //redirection
     return $this->render('base.html.twig',[
      'listUsers' => $listUsers,
      'listDoctors' => $listDoctors,
      'listPosts' => $listPosts
  ]);
   }

   /**
    * @Route("/doctors", name="doctors")
    */
    public function doctors():Response{
      // Liste des Dcotors qu'on va afficher
      $list=$this->getDoctrine()->getRepository(Doctor::class)->findAll();

      //redirection
      return $this->render('doctors.html.twig', [
          'list' =>$list
      ]);
    }

     /**
      * @Route("/services", name="services")
      */
      public function services():Response{
        $doctor = new Doctor();

        // Création formulaire pour choisir le service qu'on va afficher les docteurs qui l'appartiennent
        $form = $this->createForm(SearchType::class, $doctor);

        // liste des services
        $list=$this->getDoctrine()->getRepository(Speciality::class)->findAll();

        return $this->render('services.html.twig',[
          'controller_name' => 'DefaultController',
          'list' => $list,
          'form' => $form->createView()
        ]);
      }

      /**
       * @Route("/forum", name="forum")
       */
       public function forum():Response{
         // list de tous les posts de type forum
        $entityManager = $this->getDoctrine()->getManager();
        $listPosts = $entityManager->getRepository(Post::class)->findAll();

        // redirection
         return $this->render('Forum/forum.html.twig',[
           'controller_name' => 'DefaultController',
           'listPosts' => $listPosts
         ]);
       }

       /**
        * @Route("/contact/{id}", name="contact")
        */
        public function contact($id,Request $request ):Response{
          $message = new Message();

          // Création du formulaire pour remplir le Titre et le contenu du message
          $form = $this->createForm(ContactType::class, $message);

          $user=$this->getDoctrine()->getRepository(User::class)->find($id);

          // lorsque le formulaire est rempli
          if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $message->setUserID($id);
            $message->setHide(false);
            $message->setName($user->getName());
            $message->setLastname($user->getLastname());
            $message->setToID('admin');

            // ajout de l'entité à la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();
          }

          // redirection
          return $this->render('contact.html.twig',[
            'controller_name' => 'DefaultController',
            'form'=>$form->createView()
          ]);
        }
}
