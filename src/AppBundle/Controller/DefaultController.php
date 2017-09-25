<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


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


}