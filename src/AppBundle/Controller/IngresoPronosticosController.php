<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IngresoPronosticosController extends Controller
{
    /**
     * @Route("/", name="ingresar_pronosticos")     
     */
    public function index(Request $request)
    {


            // Si es admin redirigir a resultados
            if($this->getUser()->getTipo() == "admin"){
                return $this->redirect($this->generateUrl("resultados"));
            }
        
    	$em = $this->getDoctrine()->getManager();
    	$fase_grupos = array();
    	$octavos = array();
    	$cuartos = array();
    	$semi = array();
    	$final = array();
    	$pronosticos = array();

    	$partidos_fase_de_grupos = $em->getRepository("AppBundle:Partido")->findBy(array("instancia" => "Fase de grupos"), array("grupo" => "ASC", "fecha" => "ASC"));    	
    	foreach ($partidos_fase_de_grupos as $p) {
    		$pronostico = $em->getRepository("AppBundle:Pronostico")->findOneBy(array("usuario" => $this->getUser()->getId(),"partido" => $p->getId()));
    		array_push($fase_grupos, $pronostico);
    		array_push($pronosticos, $pronostico);
    	}


    	$partidos_octavos = $em->getRepository("AppBundle:Partido")->findBy(array("instancia" => "Octavos de final"), array("fecha" => "ASC"));    	
    	foreach ($partidos_octavos as $p) {
    		$pronostico = $em->getRepository("AppBundle:Pronostico")->findOneBy(array("usuario" => $this->getUser()->getId(),"partido" => $p->getId()));
    		array_push($octavos, $pronostico);
    		array_push($pronosticos, $pronostico);
    	}

    	$partidos_cuartos = $em->getRepository("AppBundle:Partido")->findBy(array("instancia" => "Cuartos de final"), array("fecha" => "ASC"));    	
    	foreach ($partidos_cuartos as $p) {
    		$pronostico = $em->getRepository("AppBundle:Pronostico")->findOneBy(array("usuario" => $this->getUser()->getId(),"partido" => $p->getId()));
    		array_push($cuartos, $pronostico);
    		array_push($pronosticos, $pronostico);
    	}

    	$partidos_semi = $em->getRepository("AppBundle:Partido")->findBy(array("instancia" => "Semifinal"), array("fecha" => "ASC"));    	
    	foreach ($partidos_semi as $p) {
    		$pronostico = $em->getRepository("AppBundle:Pronostico")->findOneBy(array("usuario" => $this->getUser()->getId(),"partido" => $p->getId()));
    		array_push($semi, $pronostico);
    		array_push($pronosticos, $pronostico);
    	}

    	$partidos_final = $em->getRepository("AppBundle:Partido")->findBy(array("instancia" => "Final"), array("fecha" => "ASC"));    	
    	foreach ($partidos_final as $p) {
    		$pronostico = $em->getRepository("AppBundle:Pronostico")->findOneBy(array("usuario" => $this->getUser()->getId(),"partido" => $p->getId()));
    		array_push($final, $pronostico);
    		array_push($pronosticos, $pronostico);
    	}




    	if ($request->getMethod() == "POST") {      


    		foreach ($pronosticos as $pronostico) {


    			

    			if($pronostico->getPartido()->esValidoPronosticar()){

	    			$goles_local = $request->get($pronostico->getId()."-local");
	    			$pronostico->setGolesLocal($goles_local);

	    			$goles_visitante = $request->get($pronostico->getId()."-visitante");
	    			$pronostico->setGolesVisitante($goles_visitante);


                                                $pronostico->setPronosticado(true);

    			}
    			
    		}


    		$em->flush();
    		$this->get("session")->getFlashBag()->add("notificacion", "info guardada");
    		return $this->redirect($this->generateUrl("ingresar_pronosticos"));

        }


        return $this->render("user/inicio.html.twig", array(
        	"fase_grupos" => $fase_grupos,
        	"octavos" => $octavos,
        	"cuartos" => $cuartos,
        	"semi" => $semi,
        	"final" => $final,
        ));
    }
}
