<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use AppBundle\Entity\Post;
use AppBundle\Form\PostType;


class DefaultController extends Controller
{
    // [...]
    
   /**
     * @Route("/lucky/number/{max}", name="lucky_number", defaults={"max":100}, requirements={"max":"\d+"}) 
     *
     * Au final, cela donne l'url suivante: http://localhost:8080/lucky/number/
     *
     */

  
    public function numberAction($max)
    {


        // génération d'un nombre aléatoire
        $number = mt_rand(0, $max);
        //ici on va chercher le template et on lui transmet la variable
        return $this->render('AppBundle:Default:number.html.twig', array(
            // pour fournir des variables au template
            // a gauche, le nom qui sera utilisé dans le template
            // a droite, la valeur
            'number' => $number
        ));
    }
    
   // [...]


              // [...]

    /**
     * @Route("/blog/{_locale}/{year}/{title}", name="blog", defaults={"_locale":"fr"}, requirements = {"_locale":"en|fr","year": "\d{4}","title": "\w+"})  
     *
     * exemple d'url: http://localhost:8080/blog
     *
     */

     public function blogAction($_locale, $year, $title)
     {
    
 
         //ici on va chercher le template et on lui transmet la variable
         return $this->render('AppBundle:Default:blog.html.twig', array(
             // pour fournir des variables au template
             // a gauche, le nom qui sera utilisé dans le template
             // a droite, la valeur
             '_locale' => $_locale,
             'year' => $year,
             'title' => $title

        
         ));
     }

       // [...]

        // [...]

    /**
     * @Route("/findAll", name="Allblog")  
     *
     */

     public function listArticleAction(){
        $articles = $this->getDoctrine()
        ->getRepository('AppBundle:Post')
        ->findAll();

        return $this->render('AppBundle:Default:listearticle.html.twig', array(
            'articles' => $articles
        ));

     }

          // [...]

            // [...]

    /**
     * @Route("/findOneBy{id}", name="blogid")  
     *
     * exemple d'url: http://localhost:8080/blog
     *
     */

     public function showArticleAction($id){
        $article = $this->getDoctrine()
        ->getRepository('AppBundle:Post')
        ->find($id);

        $formDelete = $this->createDeleteForm($article);

    if (!$article) {
        throw $this->createNotFoundException(
            'No article found for id '.$id
        );
 
    }
    return $this->render('AppBundle:Default:article.html.twig', array(
        'article' => $article,
        'form_delete' => $formDelete->createView(),

     
 
    ));
    }
             
                // [...]
                // [...]
                  
    /**
     * @Route("/myentity/new", name="entitynew")  
     *
     * exemple d'url: http://localhost:8080/blog
     *
     */

     public function newEntityAction(Request $request)
     {
     $post = new Post();
        $form = $this->createForm(PostType::class, $post)
        ->add('save', SubmitType::class, array('label' => 'Create Post'));
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
        
            return $this->redirectToRoute('blogid', array('id' => $post->getId()));
        }
 
         return $this->render('AppBundle:Default:newarticle.html.twig', array(
             'form' => $form->createView(),
         ));             
                // [...]  
     }

   // [...]


   /**
     * @Route("/myentity/update/{id}", name="entityupdate")  
     *
     * exemple d'url: http://localhost:8080/blog
     *
     */

     public function updateEntityAction(Request $request, $id){
        $post = $this->getDoctrine()
        ->getRepository('AppBundle:Post')
        ->find($id);

        $form = $this->createForm(PostType::class, $post)
        ->add('save', SubmitType::class, array('label' => 'Update Post'));

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
        
            return $this->redirectToRoute('blogid', array('id' => $post->getId()));
        }
 
         return $this->render('AppBundle:Default:newarticle.html.twig', array(
             'form' => $form->createView()
         ));
     }

     private function createDeleteForm(Post $post)
     {
         //on crée un formulaire
         return $this->createFormBuilder()
             ->setAction($this->generateUrl('entityudelete', array('id' => $post->getId())))
             ->setMethod('DELETE')
             ->add('delete', SubmitType::class)
             ->getForm()
         ;
     }
      
       /**
     * @Route("/article_delete/{id}", name="entityudelete")  
     *
     * exemple d'url: http://localhost:8080/blog
     *
     */

     public function deleteEntityAction(Request $request, Post $post){
      $form = $this->createDeleteForm($post);
  
      $form->handleRequest($request);
      
      if ($form->isSubmitted() && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->remove($post);
          $em->flush();
          return $this->redirectToRoute('Allblog');
      }

      return $this->render('AppBundle:Default:articledelete.html.twig', array(
        'form' => $form->createView()
    ));
     }
}