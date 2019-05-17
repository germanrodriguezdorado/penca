<?php
 
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



// Clases
use AppBundle\Entity\Partido;
use AppBundle\Entity\Pronostico;
use AppBundle\Entity\Resultado;
 



class PartidoController extends Controller
{


    /**
     * @Route("/admin/partidos", name="partidos")     
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $partidos = $em->getRepository("AppBundle:Partido")->findBy(array(),array("fecha" => "ASC"));
        

         return $this->render("admin/partidos/index.html.twig", array(
          "partidos" => $partidos
        ));
    }






    /**
     * @Route("/admin/partidos/nuevo", name="partidos_nuevo")     
     */
    public function nuevo()
    {    
        $em = $this->getDoctrine()->getManager();    
        $equipos = $em->getRepository("AppBundle:Equipo")->findAll();
        return $this->render("admin/partidos/nuevo.html.twig", array("equipos" => $equipos));
    }




    



        /**
     * @Route("/admin/partidos/nuevo_guardar/", name="partido_nuevo_guardar")     
     */
    public function nuevoGuardar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $partido = new Partido();
        $partido->setLocal($em->getRepository("AppBundle:Equipo")->find($request->get("local")));
        $partido->setVisitante($em->getRepository("AppBundle:Equipo")->find($request->get("visitante")));
        

        $fecha = trim($request->get("fecha"));
        $hora = trim($request->get("hora"));
        $fecha_hora = $fecha." ".$hora.":00";
        $date = \DateTime::createFromFormat("d/m/Y H:i:s", $fecha_hora);
        $partido->setFecha($date);
        $partido->setInstancia($request->get("instancia"));
        $partido->setGrupo($request->get("grupo"));
        $em->persist($partido);

        // Hago pronosticos para cada uno de los users "user"
        $users = $em->getRepository("AppBundle:Usuario")->findBy(array("tipo" => "user"));
        foreach ($users as $user) {
          $pronostico = new Pronostico();          
          $pronostico->setUsuario($user);
          $pronostico->setPartido($partido);
          $pronostico->setPronosticado(false);
          $em->persist($pronostico);
        }

        // Creo un resultado para este partido.
        $resultado = new Resultado();
        $resultado->setPartido($partido);
        $resultado->setJugado(false);
        $em->persist($resultado);

        $em->flush();
        $this->get("session")->getFlashBag()->add("notificacion", "info guardada");
        return $this->redirect($this->generateUrl("partidos"));
    }    





        /**
     * @Route("/admin/partidos/eliminar/{id}", name="partido_eliminar")     
     */
    public function eliminar($id)
    {
        $em = $this->getDoctrine()->getManager();
        $partido = $em->getRepository("AppBundle:Partido")->find($id);

        // Me fijo si tiene resultados
        
        // Borro resultados
        $resultados = $em->getRepository("AppBundle:Resultado")->findBy(array("partido" => $partido->getId()));      
        foreach ($resultados as $resultado) {
          $em->remove($resultado);
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