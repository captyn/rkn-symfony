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

        $reswww = $pgdb->Q("SELECT e.contact AS www, e.org_id AS id, e.type AS type, r.opis AS opis
                                    FROM ew.contacts e
                                    LEFT JOIN ew.organizacje r ON r.id = e.org_id
                                        WHERE type = 163842 OR type =163861 
                                        ");

        return $this->render('olimp/index.html.twig', array('orgs' => $res, 'wydzials' => $resw, 'wwws' => $reswww,));
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

    /**
     * @Route("/team", name="team")
     */
    public function team()
    {


        $pgdb = new Olimp();
        $pgdb->dbConnect();

        $res = $pgdb->Q("SELECT o.uid AS id, o.org_id, o.role_type AS rola, o.name AS name, o.surname AS surname, r.contact AS mail, r.public AS mailpub, p.id AS photo  
													FROM mainframe.vroles_active_extend o
													LEFT JOIN ew.contacts r ON r.uid = o.uid
													LEFT JOIN mainframe.user_photo p ON p.uid = o.uid
						WHERE (o.org_id = 54223 AND o.role_type = 'CHAIRMAN' AND p.deleted = false AND p.priority = '0') 
						OR (o.org_id = 54223 AND o.role_type = 'D')
						OR (o.org_id = 54223 AND o.role_type = 'BM')   
						ORDER BY r.uid, o.uid
          ");
        if($res != NULL){
            foreach($res as &$value){
                if($value['rola'] == 'CHAIRMAN'){
                    $chairman['name'] = $value['name'];
                    $chairman['surname'] = $value['surname'];
                    $chairman['id'] = $value['id'];
                    $chairman['photo'] = 'NULL';
                    if($value['mailpub'] == '200'){
                        $chairman['mail'] = $value['mail'];
                    }
                }
            }
            unset($value);
            foreach($res as &$value){
                if($value['rola'] == 'D' AND $value['id'] != $chairman['id']){
                    $pnpn['name'] = $value['name'];
                    $pnpn['surname'] = $value['surname'];
                    $pnpn['id'] = $value['id'];
                    $pnpn['photo'] = 'NULL';
                    if($value['mailpub'] == '200'){
                        $pnpn['mail'] = $value['mail'];
                    }
                }
            }
            unset($value);
            foreach($res as &$value){
                if($value['rola'] == 'BM' AND $value['id'] != $pnpn['id']){
                    $ogolny['name'] = $value['name'];
                    $ogolny['surname'] = $value['surname'];
                    $ogolny['id'] = $value['id'];
                    $ogolny['photo'] = 'NULL';
                    if($value['mailpub'] == '200'){
                        $ogolny['mail'] = $value['mail'];
                    }
                }
            }
            unset($value);
            $photos = $pgdb->Q("SELECT id AS link, uid 
                                FROM mainframe.user_photo 
                                WHERE (uid = ".$chairman['id']." AND priority = '0')
                                OR (uid = ".$pnpn['id']." AND priority = '0')
                                OR (uid = ".$ogolny['id']." AND priority = '0')
                                 ");
            if($photos != NULL){
                foreach($photos as &$value){
                    if($value['uid'] == $chairman['id']){
                        $chairman['photo'] = 'https://mainframe.sspw.pl/?site=8010&uid='.$chairman['id'].'&id='.$value['link'].'';
                    }
                }
                unset($value);
                foreach($photos as &$value){
                    if($value['uid'] == $pnpn['id']){
                        $pnpn['photo'] = 'https://mainframe.sspw.pl/?site=8010&uid='.$pnpn['id'].'&id='.$value['link'].'';
                    }
                }
                unset($value);
                foreach($photos as &$value){
                    if($value['uid'] == $ogolny['id']){
                        $ogolny['photo'] = 'https://mainframe.sspw.pl/?site=8010&uid='.$ogolny['id'].'&id='.$value['link'].'';
                    }
                }
                unset($value);
            }
        }

        return $this->render('olimp/team.html.twig', array(
            'chairman' => $chairman,
            'pnpn' => $pnpn,
            'ogolny' => $ogolny
        ));
    }
}
