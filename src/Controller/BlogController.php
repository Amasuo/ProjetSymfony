<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Security\UsersAuthenticator;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Comment;
use App\Form\PostType;
use App\Form\CommentType;

class BlogController extends AbstractController
{
    
    /**
   * @Route("/blogpost/{id}", name="blogpost")
   */
  public function blogPost($id,Request $request)
  {
      $post = new Post();
      $form = $this->createForm(PostType::class, $post);
      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $user=$this->getDoctrine()->getRepository(User::class)->find($id);
        $post->setEmailOwner($user->getEmail());
        $post->setType("blog");
        $post->setNbComments("0");
            $uploadedFile = $form['img']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/img/post';
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move(
                $destination,
                $newFilename
            );
        $post->setImg($newFilename);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($post);
        $entityManager->flush();
        }
      return $this->render('blog/makeblog.html.twig', [
          'form' => $form->createView()
      ]);
  }
  /**
   * @Route("/commentpost/{id}/{Uid}", name="commentpost")
  
   */
   public function commentPost($id,$Uid,Request $request)
   {

      $comment= new Comment();
      $form = $this->createForm(CommentType::class, $comment);
      $post=$this->getDoctrine()->getRepository(Post::class)->find($id);
      $user=$this->getDoctrine()->getRepository(User::class)->find($Uid);
     

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $comment->setIdPost($id);
        $comment->setEmail($user->getEmail());
        $comment->setName($user->getName());
        $comment->setLastname($user->getLastname());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();
        
        $nb=$post->getNbComments()+1;
        $post->setNbComments($nb);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($post);
        $entityManager->flush();

    }
    $listComments = $this->getDoctrine()->getRepository(Comment::class)->findAll();
      return $this->render('blog/commentPost.html.twig',[
        'post' => $post,
        'listComments' => $listComments,
        'form'=>$form->createView()
      ]);


}

}
