<?php

namespace App\Controller;

use App\Entity\App\Article;
use App\Entity\Olimp;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticleController extends Controller
{


    /**
     * @Route("/", name="index", methods="GET")
     */
    public function index()
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)
            ->findBy(
                array('article_type'=> 'index'),
                array('last_modified' => 'DESC')
            );

        return $this->render('index.html.twig', array('articles' => $articles));
    }


    /*public function show($slug)
    {
        $articlebody = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
        $title = 'Tytuł Artykułu';
        $date = '';
        return $this->render('testshow.html.twig', [
            'title' => $title,
            'comments' => $articlebody,
        ]);
    }*/

    /**
     * @Route("/article/new", name="new_article")
     * Method({"GET", "POST"})
     */
    public function new(Request $request) {
        $article = new Article();
        $del=FALSE;
        $article->setDeleted($del);
        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class, array('label' => 'Tytuł','attr' => array('class' => 'form-control')))
            ->add('article_type', ChoiceType::class, array(
                'attr' => array('class' => 'custom-select'),
                'label' => 'Typ Artykułu',
                'choices' => array(
                    'Artykuł na stronę główną' => 'index',
                    'Archiwizuj (z głównej strony)' => 'archiwum',
                    'test' => 'test',
                    'Artykuł z informacjami' => 'info',
                ),
            ))
            ->add('body', TextareaType::class, array(
                'label' => 'Treść Artykułu',
                'required' => false,
                'attr' => array('textarea','class' => 'form-control')
            ))
            ->add('creator', TextType::class, array('required' => false,'attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array(
                'label' => 'Utwórz',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $article->setModifiedby($form->get('creator')->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('article_list');
        }
        return $this->render('article/new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/article/edit/{id}", name="edit_article")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        $article = new Article();
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class, array('label' => 'Tytuł', 'attr' => array('class' => 'form-control')))
            ->add('article_type', ChoiceType::class, array(
                'attr' => array('class' => 'custom-select'),
                'label' => 'Typ Artykułu',
                'choices' => array(
                    'Artykuł na stronę główną' => 'index',
                    'Archiwizuj (z głównej strony)' => 'archiwum',
                    'test' => 'test',
                    'Artykuł z informacjami' => 'info',
                ),
            ))
            ->add('body', TextareaType::class, array(
                'label' => 'Treść Artykułu',
                'required' => false,
                'attr' => array('textarea', 'class' => 'form-control')
            ))
            ->add('deleted', ChoiceType::class, array(
                'expanded' => true,
                'attr' => array('class' => 'custom-control custom-radio'),
                'label' => 'Skasować artykuł',
                'choices' => array(
                    'Nie' => 'FALSE',
                    'Tak' => 'TRUE',
                ),
                'data' => 'FALSE',
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Zapisz',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('article_list');
        }
        return $this->render('article/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/article/list", name="article_list", methods="GET")
     */
    public function artciles() {
        $articles= $this->getDoctrine()->getRepository(Article::class)
            ->findBy(
                array('deleted' => 'false'),
                array('last_modified' => 'DESC')
            );


        $pgdb = new Olimp();
        $pgdb->dbConnect();

        $res = $pgdb->Q("SELECT o.uid AS id, o.org_id, o.name AS name, o.surname AS surname
													FROM mainframe.vroles_active_extend o
													
						WHERE o.org_id = 54223  ORDER BY  o.uid
          ");


        return $this->render('article/list.html.twig', array('articles' => $articles, 'members' => $res));
    }


    /**
     * @Route("/article/{id}", name="article_show", methods="GET")
     */
    public function show($id) {
        $article= $this->getDoctrine()->getRepository(Article::class)
            ->findOneBy(
                array(
                    'id' =>$id,
                    'deleted'=>'false'
                ));


        $pgdb = new Olimp();
        $pgdb->dbConnect();

        $res = $pgdb->Q("SELECT o.uid AS id, o.org_id, o.name AS name, o.surname AS surname
													FROM mainframe.vroles_active_extend o
													
						WHERE o.org_id = 54223  ORDER BY  o.uid
          ");


        return $this->render('article/show.html.twig', array('article' => $article, 'members' => $res));
    }


    /**
     * @Route("/news/{slug}")
     */
    public function showd($slug)
    {
        $comments = [
            'DDDDDDDDDDD',
            'XD',
            'XDDDDDDDDDDDDDDDDD',
        ];
        return $this->render('testshow.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'comments' => $comments,
        ]);
    }
}
