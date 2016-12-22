<?php
namespace ContactBundle\Controller;

use ContactBundle\Form\ContactType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ContactBundle\Entity\Contact;

class ContactController extends DefaultController
{

    /**
     * @Route("/new/contact", name="addContact")
     */
    public function newContact(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            return $this->redirectToRoute('contacts');
        } else {
            return $this->render('@Contact/addContact.html.twig', ["form" => $form->createView()]);
        }
    }

    /**
     * @Route("/delete/contact/{id}", requirements={"id": "\d+"}, name="deleteContact")
     */
    public function deleteContact(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository('ContactBundle:Contact')->findOneBy(['id' => $id]);

        if ($contact != null) {
            $images = $em->getRepository('ContactBundle:Image')->findBy(['contact' => $contact]);
            if ($images != null) {
                foreach ($images as $image) {
                    $em->remove($image);
                    $em->flush();
                }
            }
            $em->remove($contact);
            $em->flush();
        }

        return $this->redirectToRoute('contacts');
    }

    /**
     * @Route("/contacts", name="contacts")
     */
    public function showContacts()
    {
        $em = $this->getDoctrine()->getManager();
        $contacts = $em->getRepository('ContactBundle:Contact')->findAll();

        return $this->render('@Contact/contacts.html.twig', ['contacts' => $contacts]);
    }

    /**
     * @Route("/contact/{id}", requirements={"id": "\d+"}, name="contact")
     */
    public function showPost(Contact $contact, $id)
    {
        return $this->render('@Contact/contact.html.twig', ['contact' => $contact]);
    }
}
