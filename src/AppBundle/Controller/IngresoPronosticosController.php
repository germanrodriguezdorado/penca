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
        
        $respuesta = array();
    	$em = $this->getDoctrine()->getManager();
    	$partidos = $em->getRepository("AppBundle:Partido")->findBy(array(), array("instancia" => "ASC","grupo" => "ASC", "fecha" => "ASC"));     
        foreach ($partidos as $partido) {
          $un_partido = array();
          $un_partido["id"] = $partido->getId();
          $un_partido["local"] = $partido->getLocal()->getNombre();  
          $un_partido["visitante"] = $partido->getVisitante()->getNombre();
          $un_partido["foto_local"] = $partido->getLocal()->getFoto();  
          $un_partido["foto_visitante"] = $partido->getVisitante()->getFoto();  
          $un_partido["dia"] = $partido->getFecha()->format("d/m/Y");
          $un_partido["hora"] = $partido->getFecha()->format("H:i")."hs.";
          $un_partido["instancia"] = $partido->getInstancia();
          $un_partido["grupo"] = $partido->getGrupo();
          $un_partido["es_valido_pronosticar"] = $partido->esValidoPronosticar();
          
          // Resultado real
          $resultado_entidad = $em->getRepository("AppBundle:Resultado")->findOneBy(array("partido" => $partido->getId(), "jugado" => true));     
          if($resultado_entidad != null){
            $resultado = array();
            $resultado["goles_local"] = $resultado_entidad->getGolesLocal();  
            $resultado["goles_visitante"] = $resultado_entidad->getGolesVisitante();    
            $un_partido["resultado"] = $resultado;
          }

          // Pronóstico
          $pronostico_entidad = $em->getRepository("AppBundle:Pronostico")->findOneBy(array("partido" => $partido->getId(), "usuario" => $this->getUser()->getId()));     
          if($pronostico_entidad != null){
            $pronostico = array();
            $pronostico["id"] = $pronostico_entidad->getId(); 
            $pronostico["goles_local"] = $pronostico_entidad->getGolesLocal();  
            $pronostico["goles_visitante"] = $pronostico_entidad->getGolesVisitante();    
            $un_partido["pronostico"] = $pronostico;


            // Puntos
            if($resultado_entidad != null){
              $puntaje = $pronostico_entidad->calcularPuntaje($resultado_entidad);
              $un_partido["puntaje"] = $puntaje;  
            }else{
              $un_partido["puntaje"] = "";  
            }


          }

          
          



          
          array_push($respuesta, $un_partido);
        }





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
    		return $this->redirect($this->generateUrl("ingresar_pronosticos"));

        }


        return $this->render("user/inicio.html.twig", array(
        	"partidos" => $respuesta
        ));
    }
}
