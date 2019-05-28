<?php
 
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;




use AppBundle\Entity\Sugerencia;
 



class SugerenciaController extends Controller
{



  /**
     * @Route("/sugerencias", name="redactar_sugerencias")     
     */
    public function redactarSugerencias(Request $request)
    {
        
        // Si es admin redirigir a resultados
        if($this->getUser()->getTipo() == "admin"){
            return $this->redirect($this->generateUrl("resultados"));
        }



        if ($request->getMethod() == "POST") {

          if($request->get("sugerencia") != ""){
            $em = $this->getDoctrine()->getManager();
            $sugerencia = new Sugerencia();
            $sugerencia->setSugerencia($request->get("sugerencia"));
            $sugerencia->setUsuario($this->getUser());
            $em->persist($sugerencia);
            $em->flush();
            $this->get("session")->getFlashBag()->add("notificacion", "Sugerencia enviada. Gracias.");
            return $this->redirect($this->generateUrl("redactar_sugerencias"));
          }


        }

        return $this->render("user/sugerencias.html.twig");

    }







  /**
     * @Route("/admin/sugerencias", name="leer_sugerencias")     
     */
    public function leerSugerencias(Request $request)
    {
        
        // Si es user redirigir
        if($this->getUser()->getTipo() == "user"){
            return $this->redirect($this->generateUrl("ingresar_pronosticos"));        
        } 


        $em = $this->getDoctrine()->getManager();
        $sugerencias = $em->getRepository("AppBundle:Sugerencia")->findAll();
        

        return $this->render("admin/sugerencias.html.twig", array(
          "sugerencias" => $sugerencias
        ));

    }    
    




}