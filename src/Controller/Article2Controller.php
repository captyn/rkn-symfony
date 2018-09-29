<?php

namespace App\Controller;

use App\Entity\Ew\Organizacje;
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

class Article2Controller extends Controller
{


    /**
     * @Route("/article/list2", name="article_list2", methods="GET")
     */
    public function artciles() {
        $articles= $this->getDoctrine()->getRepository(Article::class, 'default')
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


        return $this->render('article/list2.html.twig', array('articles' => $articles, 'members' => $res));
    }


}