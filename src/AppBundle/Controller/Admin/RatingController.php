<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Rating;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/rating")
 * @Security("has_role('ROLE_ADMIN')")
 */

class RatingController extends Controller
{
    /**
     * @Route("/", name="admin_rating_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $objects = $em->getRepository(Rating::class)->findAll();

        return $this->render('admin/rating/index.html.twig', ['objects' => $objects]);
    }
}