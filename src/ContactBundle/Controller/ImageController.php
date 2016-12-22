<?php
namespace ContactBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ContactBundle\Entity\Image;

class ImageController extends DefaultController
{

    /**
     * @Route("/new/image/{contact_id}", requirements={"contact_id": "\d+"}, name="addImage")
     */
    public function newImage($contact_id)
    {
        $image = new Image();
        $name = 'test';
        $image->setName($name);
        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository('ContactBundle:Contact')->findOneBy(['id' => $contact_id]);
        $image->setContact($contact);
        $image->setLink('/web/images/normal.png');
        $em->persist($image);
        $em->flush();

    return $this->redirectToRoute('contact', ['id'=> $contact_id]);
    }

    /**
     * @Route("/images", name="images")
     */
    public function showImages()
    {
        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository('ContactBundle:Image')->findAll();

        return $this->render('@Contact/images.html.twig', ['images' => $images]);
    }

    /**
     * @Route("/image/{id}", requirements={"id": "\d+"}, name="image")
     */
    public function showImage(Image $image)
    {
        return $this->render('@Contact/image.html.twig', ['image' => $image]);
    }
}
