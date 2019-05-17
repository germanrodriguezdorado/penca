<?php
 
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



// Clases
use AppBundle\Entity\Ranking;
 



class RankingController extends Controller
{


    /**
     * @Route("/ranking", name="ranking")     
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $ranking = $em->getRepository("AppBundle:Ranking")->findAll(array(), array("puntos" => "DESC"));
        

         return $this->render("user/ranking.html.twig", array(
          "ranking" => $ranking
        ));
    }




    /**
     * @Route("/ranking_actualizar", name="ranking_actualizar")     
     */
    public function actualizar()
    {
        $em = $this->getDoctrine()->getManager();
        $res = $em->getRepository("AppBundle:Ranking")->calcular();
        return $this->redirect($this->generateUrl("ranking"));
    }







}