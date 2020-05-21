<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Post;
use App\Entity\Message;
use App\Entity\User;
use App\Form\ContactType;
class DefaultController extends AbstractController{
   /**
   * @Route("/", name="home")
   */
   public function home():Response{
     return $this->render('base.html.twig');
   }

   /**
    * @Route("/doctors", name="doctors")
    */
    public function doctors():Response{
      return $this->render('doctors.html.twig');
    }

    /**
     * @Route("/about", name="about")
     */
     public function about():Response{
       return $this->render('about.html.twig');
     }

     /**
      * @Route("/services", name="services")
      */
      public function services():Response{
        return $this->render('services.html.twig');
      }

      /**
       * @Route("/forum", name="forum")
       */
       public function forum():Response{
        $entityManager = $this->getDoctrine()->getManager();
        $listPosts = $entityManager->getRepository(Post::class)->findAll();
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
          $form = $this->createForm(ContactType::class, $message);
          $user=$this->getDoctrine()->getRepository(User::class)->find($id);

          if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $message->setUserID($id);
            $message->setHide(false);
            $message->setName($user->getName());
            $message->setLastname($user->getLastname());
            $message->setToID('admin');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();
          }

          return $this->render('contact.html.twig',[
            'form'=>$form->createView()
          ]);
        }
}
