<?php
namespace ContactBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ContactBundle\Entity\Contact;

class RandomContactController extends DefaultController
{

    /**
     * @Route("/add/contact")
     */
    public function createContact()
    {
        $contact = new Contact();
        $contact->setFirstName('jean');
        $contact->setLastName('jean');
        $contact->setEmailAddress('jean@jean.jean');
        $contact->setPhoneNumber('06.00.00.00.00');
        $em = $this->getDoctrine()->getManager();
        $em->persist($contact);
        $em->flush();

        return new Response('ok');
    }

    /**
     * @Route("/contacts")
     */
    public function showContacts()
    {
        $em = $this->getDoctrine()->getManager();
        $contacts = $em->getRepository('ContactBundle:Contact')->findAll();

        return $this->render('@Contact/contacts.html.twig', ['contacts' => $contacts]);
    }

    /**
     * @Route("/contact/{id}", requirements={"id": "\d+"})
     */
    public function showPost(Contact $contact, $id)
    {
        return $this->render('@Contact/contact.html.twig', ['contact' => $contact]);
    }
}
