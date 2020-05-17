<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PostType;
use App\Form\CommentType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ForumController extends AbstractController
{
  /**
   * @Route("/forumpost/{id}", name="forumpost")
   */
  public function forumPost($id,Request $request)
  {
      $post = new Post();
      $form = $this->createForm(PostType::class, $post);
     // , [
     //   'action' => $this->generateUrl('forum')
      //]);

      //$form->handleRequest($request);
     // if($form->isSubmitted() && $form->isValid()){
      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        //$id = $request->attributes->get('id');

        $user=$this->getDoctrine()->getRepository(User::class)->find($id);


        $post->setEmailOwner($user->getEmail());
        $post->setType("forum");
        $post->setNbComments("0");

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($post);
        $entityManager->flush();
        }
      return $this->render('forum/makeSubject.html.twig', [
          'form' => $form->createView()
      ]);
  }
  /**
   * @Route("/commentpost/{id}/{Uid}", name="commentpost")
   * Method( { "POST"})
   */
   public function commentPost($id,Request $request)
   {

      $comment= new Comment();
      $form = $this->createForm(CommentType::class, $comment);

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $user=$this->getDoctrine()->getRepository(User::class)->find($Uid);

        $comment->setIdPost($id);
        $comment->setEmail($user->getEmail());
        $comment->setEmail($user->getName());
        $comment->setEmail($user->getLastname());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();
      }

      $post=$this->getDoctrine()->getRepository(Post::class)->find($id);

      $entityManager = $this->getDoctrine()->getManager();
      $listComments = $entityManager->getRepository(Comment::class)->findAll();

      return $this->render('forum/commentPost.html.twig',[
        'post' => $post,
        'listComments' => $listComments,
        'form'=>$form->createView()
      ]);

}
}
