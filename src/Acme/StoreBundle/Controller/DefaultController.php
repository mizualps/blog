<?php

namespace Acme\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Acme\StoreBundle\Entity\Product;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
class DefaultController extends FOSRestController
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('AcmeStoreBundle:Default:index.html.twig');
    }
    
    /**
     * @Route("/create/")
     */
    public function createAction(){
        $product = new Product();
        $product->setName('A Foo Bar');
        $product->setPrice('19.99');
        $product->setDescription('Lorem ipsum dolor');

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($product);
        $em->flush();

        return new Response('Created product id '.$product->getId());
    }
    
    /**
     * @Route("/show/{id}")
     */
    public function showAction($id){
        $product = $this->getDoctrine()
            ->getRepository('AcmeStoreBundle:Product')
            ->find($id);
        return $this->render('AcmeStoreBundle:Default:show.html.twig', ['product'=>$product]);
        if (!$product) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }
    }
    
    /**
     * @Rest\Get("/api/product.{_format}/{id}")
     */
    public function showjsonAction($id){
        $product = $this->getDoctrine()
            ->getRepository('AcmeStoreBundle:Product')
            ->find($id);
        $view = new View($product);
        return $this->handleView($view);
    }
    
}
