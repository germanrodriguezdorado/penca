<?php
 
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;





class ReglamentoController extends Controller
{


    /**
     * @Route("/reglamento", name="reglamento")     
     */
    public function reglamento()
    {
         return $this->render("user/reglamento.html.twig");
    }






}