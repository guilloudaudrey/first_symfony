<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Post;



class ApiController extends Controller
{
    /**
     * @Route("/api/post/all")  
     *
     */
    
     public function indexAction()
    {
        $data = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('AppBundle:Post')
                     ->findAll();

                     $formatted = [];
                     foreach ($data as $d) {
                         $formatted[] = [
                            'id' => $d->getId(),
                            'title' => $d->getTitle(),
                            'content' => $d->getContent(),
                         ];
                     }
    
        return new JsonResponse($formatted);
    }

     }
  








