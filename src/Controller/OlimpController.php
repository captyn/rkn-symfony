<?php

namespace App\Controller;

use App\Entity\Olimp;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class OlimpController extends Controller
{
    /**
     * @Route("/listaKN", name="listaKN")
     */
    public function index()
    {


        $pgdb = new Olimp();
        $pgdb->dbConnect();

        $resw = $pgdb->Q("SELECT o.id, o.skrot, o.nazwa, o.org_type AS typ, r.skrot AS rel
													FROM mainframe.v_unist_short o
													LEFT JOIN mainframe.v_unist_short r ON r.id = o.rel_org
						WHERE o.org_type = 1318151 AND o.active = true ORDER BY r.nazwa, o.nazwa 
          ");

        $res = $pgdb->Q("SELECT o.id, o.skrot, o.nazwa, o.org_type AS typ, r.skrot AS rel, w.nazwa AS wydzial
													FROM mainframe.v_unist_short o
													LEFT JOIN mainframe.v_unist_short r ON r.id = o.rel_org
													LEFT JOIN mainframe.v_unist_short w ON w.id = o.wydzial_id
						WHERE o.org_type = 25152 AND o.active = true ORDER BY r.nazwa, o.nazwa 
          ");

        /*echo 'DDDDDDDDDDd';
        echo '<pre>';
        print_r($res);
        echo '</pre>';*/
        /*return $this->render('olimp/index.html.twig', [
            'controller_name' => 'OlimpController',
        ]);*/
        return $this->render('olimp/index.html.twig', array('orgs' => $res, 'wydzials' => $resw));
    }

    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        $pgdb = new Olimp();
        $pgdb->dbConnect();



        return $this->render('olimp/index.html.twig', array('orgs' => $res));
    }
}
