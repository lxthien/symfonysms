<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\NewsCategory;
use AppBundle\Entity\News;
use AppBundle\Entity\ProductCat;
use AppBundle\Entity\Product;

class HomepageController extends Controller
{
    public function indexAction(Request $request)
    {
        $productsNew = $this->getDoctrine()
            ->getRepository(Product::class)
            ->createQueryBuilder('n')
            ->where('n.enable = :enable')
            ->setParameter('enable', 1)
            ->orderBy('n.createdAt', 'DESC')
            ->getQuery()->getResult();

        return $this->render('homepage/index.html.twig', [
            'productsNew' => $productsNew,
            'showSlide' => true
        ]);
    }
}
