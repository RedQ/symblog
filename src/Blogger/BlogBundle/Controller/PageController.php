<?php
// src/Blogger/BlogBundle/Controller/PageController.php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Import new namespaces
use Blogger\BlogBundle\Entity\Enquiry;
use Blogger\BlogBundle\Form\EnquiryType;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller{

    public function indexAction(){
        return $this->render('BloggerBlogBundle:Page:index.html.twig');
    }

    public function aboutAction(){
        return $this->render('BloggerBlogBundle:Page:about.html.twig');
    }

    public function contactAction(Request $request)
    {
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);

        if ($request->getMethod() == 'POST') {
            $form->submit($request);

            if ($form->isValid()) {
                // Perform some action, such as sending an email

//                $message = \Swift_Message::newInstance()
//                    ->setSubject('Contact enquiry from symblog')
//                    ->setFrom('enquiries@symblog.co.uk')
//                    ->setTo('email@email.com')
//                    ->setBody($this->renderView('BloggerBlogBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));
                //$this->get('mailer')->send($message);

                $this->get('session')->getFlashBag()->set('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!');

                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('blogger_blog_contact'));
            }
        }

        return $this->render('BloggerBlogBundle:Page:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
