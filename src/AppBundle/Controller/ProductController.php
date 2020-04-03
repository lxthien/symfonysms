<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use AppBundle\Entity\ProductCat;
use AppBundle\Entity\Product;
use AppBundle\Entity\News;


class ProductController extends Controller
{
    /**
     * Render the list products of the category
     * 
     * @return Product
     */
    public function listAction($level1, $page = 1)
    {
        $category = $this->getDoctrine()
            ->getRepository(ProductCat::class)
            ->findOneBy(array('url' => $level1, 'enable' => 1));

        if (!$category) {
            throw $this->createNotFoundException("The item does not exist");
        }

        // Init breadcrum for category page
        $breadcrumbs = $this->buildBreadcrums(!empty($level2) ? $subCategory : $category, null, null);

        // Get the list post related to tag
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->createQueryBuilder('n')
            ->innerJoin('n.productCat', 't')
            ->where('t.id = :productcat_id')
            ->andWhere('n.enable = :enable')
            ->setParameter('productcat_id', $category->getId())
            ->setParameter('enable', 1)
            ->orderBy('n.createdAt', 'DESC')
            ->getQuery()->getResult();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $products,
            $page,
            $this->get('settings_manager')->get('numberRecordOnPage') ?: 10
        );

        return $this->render('product/list.html.twig', [
            'category' => !empty($level2) ? $subCategory : $category,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("san-pham/{slug}.html",
     *      defaults={"_format"="html"},
     *      name="product_show",
     *      requirements={
     *          "slug": "[^/\.]++"
     *      })
     */
    public function showAction($slug, Request $request)
    {
        if ($request->query->get('preview') === false || $request->query->get('preview_id') === null) {
            $product = $this->getDoctrine()
                ->getRepository(Product::class)
                ->findOneBy(
                    array('url' => $slug, 'enable' => 1)
                );
        } else {
            $product = $this->getDoctrine()
                ->getRepository(Product::class)
                ->find($request->query->get('preview_id'));
        }

        if (!$product) {
            throw $this->createNotFoundException("The item does not exist");
        }

        $shippingAndReturn = $this->getDoctrine()
            ->getRepository(News::class)
            ->findOneBy(
                array('url' => 'chinh-sach-giao-hang-va-tra-hang', 'enable' => 1)
            );

        // Init breadcrum for the post
        $breadcrumbs = $this->buildBreadcrums(null, $product, null);

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'shippingAndReturn' => $shippingAndReturn
        ]);
    }

    /**
     * Handle the breadcrumb
     * 
     * @return Breadcrums
     **/
    private function buildBreadcrums($productCat = null, $product = null)
    {
        // Init october breadcrum
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        
        // Add home item into first breadcrum.
        $breadcrumbs->addItem("home", $this->generateUrl("homepage"));
        
        // Breadcrum for category page
        if (!empty($productCat)) {
            if ($productCat->getParentcat() === 'root') {
                $breadcrumbs->addItem($productCat->getName(), $this->generateUrl("news_category", array('level1' => $productCat->getUrl() )));
            } else {
                //$breadcrumbs->addItem($productCat->getParentcat()->getName(), $this->generateUrl("news_category", array('level1' => $productCat->getParentcat()->getUrl() )));
                //$breadcrumbs->addItem($productCat->getName(), $this->generateUrl("list_category", array('level1' => $productCat->getParentcat()->getUrl(), 'level2' => $productCat->getUrl() )));
            }
        }

        // Breadcrum for post page
        if (!empty($product)) {
            $breadcrumbs->addItem($product->getName(), $this->generateUrl('product_show', array('slug' => $product->getUrl())) );
        }

        return $breadcrumbs;
    }
}