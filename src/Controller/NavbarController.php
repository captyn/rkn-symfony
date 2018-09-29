<?php

namespace App\Controller;

use App\Entity\App\Navbar;
use App\Entity\Olimp;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\Form\FormValidationType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class NavbarController extends Controller
{

//    /**
//     * @Route("/navbar", name="navbar")
//     * Method({"GET", "POST"})
//     */
//    public function new(Request $request){
//        $nav = new Navbar();
//        $del=FALSE;
//        $nav->setDeleted($del);
//        $nav->setCreated(new \DateTime());
//        $form = $this->createFormBuilder($nav)
//            ->add('name', TextType::class, array('label' => 'Tytuł','attr' => array('class' => 'form-control')))
//            ->add('add', SubmitType::class, array(
//                'label' => 'Dodaj',
//                'attr' => array('class' => 'btn btn-primary mt-3')
//            ))
//            ->add('save', SubmitType::class, array(
//                'label' => 'Utwórz',
//                'attr' => array('class' => 'btn btn-primary mt-3')
//            ))
//            ->getForm();
//
//        $form->handleRequest($request);
//        if($form->isSubmitted() && $form->isValid())
//            if($form->get('add')->isClicked()){
//                $form->add('name', TextType::class);
//            }
//            $uploaded = $form->get('file')->getData();
//            $FileName = 'file'.$this->generateUniqueFileName().'.'.$uploaded->guessExtension();
//            $uploaded->move($this->getParameter('files_directory'), $FileName);
//            $file->setFile($FileName);
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($file);
//            $entityManager->flush();
//            return $this->redirectToRoute('file_list');
//        }
//        return $this->render('files/new.html.twig', array(
//            'form' => $form->createView()
//        ));
//    }
//
//
//
//
//    public function recentArticles()
//    {
//        // make a database call or other logic
//        // to get the "$max" most recent articles
//        $articles = 2;
//        return $this->render(
//            'article/recent_list.html.twig',
//            array('articles' => $articles)
//        );
//
//    }
}
