<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
       * @Route("/blog", name="blog")
       */
       public function blog():Response{
         return $this->render('blog.html.twig');
       }

       /**
        * @Route("/contact", name="contact")
        */
        public function contact():Response{
          return $this->render('contact.html.twig');
        }
}
