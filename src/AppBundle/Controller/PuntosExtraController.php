<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PuntosExtraController extends Controller
{
    /**
     * @Route("/puntosextra", name="puntos_extra")     
     */
    public function index(Request $request)
    {


        // Si es admin redirigir a resultados
        if($this->getUser()->getTipo() == "admin"){
            return $this->redirect($this->generateUrl("resultados"));
        }
        
      
    	$em = $this->getDoctrine()->getManager();
    	$equipos = $em->getRepository("AppBundle:Equipo")->findAll();     
       





    	if ($request->getMethod() == "POST") {      


    		foreach ($respuesta as $partido) {


    			

    			if($partido["es_valido_pronosticar"] == true){

            
            $goles_local = $request->get($partido["pronostico"]["id"]."-local");
            $goles_visitante = $request->get($partido["pronostico"]["id"]."-visitante");

            if($goles_local != "" && $goles_visitante != ""){
              $pronostico_entidad = $em->getRepository("AppBundle:Pronostico")->find($partido["pronostico"]["id"]);	    			
  	    			$pronostico_entidad->setGolesLocal($goles_local);	    			
  	    			$pronostico_entidad->setGolesVisitante($goles_visitante);
              $pronostico_entidad->setPronosticado(true);      
            }             

    			}
    			
    		}


    		$em->flush();
    		$this->get("session")->getFlashBag()->add("notificacion", "info guardada");
    		return $this->redirect($this->generateUrl("puntos_extra"));

        }


        return $this->render("user/puntos_extra.html.twig", array(
        	"equipos" => $equipos
        ));
    }
}
