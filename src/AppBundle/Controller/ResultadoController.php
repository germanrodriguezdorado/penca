<?php
 
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


 



class ResultadoController extends Controller
{


    /**
     * @Route("/admin/resultados", name="resultados")     
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $resultados = $em->getRepository("AppBundle:Resultado")->findAll();
        

         return $this->render("admin/resultados/index.html.twig", array(
          "resultados" => $resultados
        ));
    }






 /**
     * @Route("/admin/resultados/editar/{id}", name="resultado_editar")     
     */
    public function editar($id)
    {
        $em = $this->getDoctrine()->getManager();
        $resultado = $em->getRepository("AppBundle:Resultado")->find($id);
        return $this->render("admin/resultados/editar.html.twig", array("resultado" => $resultado));
    }




    /**
     * @Route("/admin/resultados/editar_guardar/", name="resultado_editar_guardar")     
     */
    public function editarGuardar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $resultado = $em->getRepository("AppBundle:Resultado")->find($request->get("id"));
        $resultado->setGolesLocal($request->get("goles_local"));
        $resultado->setGolesVisitante($request->get("goles_visitante"));
        $resultado->setJugado(true);
        $em->flush();
        $this->get("session")->getFlashBag()->add("notificacion", "info guardada");
        return $this->redirect($this->generateUrl("resultados"));
    }    


 /**
     * @Route("/admin/resultados/quitar/{id}", name="resultado_quitar")     
     */
    public function quitar($id)
    {
        $em = $this->getDoctrine()->getManager();
        $resultado = $em->getRepository("AppBundle:Resultado")->find($id);
        $resultado->setGolesLocal(null);
        $resultado->setGolesVisitante(null);
        $resultado->setJugado(false);
        $em->flush();
        $this->get("session")->getFlashBag()->add("notificacion", "ok");
        return $this->redirect($this->generateUrl("resultados"));
    }    











        /**
     * @Route("/admin/resultados/eliminar/{id}", name="resultados_eliminar")     
     */
    public function eliminar($id)
    {
        $em = $this->getDoctrine()->getManager();
        $partido = $em->getRepository("AppBundle:Partido")->find($id);
        // Me fijo si tiene resultados
        
        $resultados = $em->getRepository("AppBundle:Resultado")->findBy(array("partido" => $partido->getId()));      
        if(count($resultados) > 0){
          $this->get("session")->getFlashBag()->add("error", "no se puede borrar porque el partido tiene resultados ya ingresados");
          return $this->redirect($this->generateUrl("partidos"));
        } 

        // Borro pronosticos
        $pronosticos = $em->getRepository("AppBundle:Pronostico")->findBy(array("partido" => $partido->getId()));      
        foreach ($pronosticos as $pronostico) {
          $em->remove($pronostico);
        }

        
        $em->remove($partido);
        $em->flush();
        $this->get("session")->getFlashBag()->add("notificacion", "ok");
        return $this->redirect($this->generateUrl("partidos"));
    }





}