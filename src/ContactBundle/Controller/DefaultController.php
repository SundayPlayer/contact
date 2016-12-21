<?php
namespace ContactBundle\Controller;

use ContactBundle\Entity\Contact;
use ContactBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="home")
     */
    public function showHome()
    {
        return $this->render('@Contact/Default/index.html.twig');
    }


}
