<?php
 
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



// Clases
use AppBundle\Entity\Equipo;
 



class EquipoController extends Controller
{


    /**
     * @Route("/admin/equipos", name="equipos")     
     */
    public function index()
    {

        if($this->getUser()->getTipo() == "user") return $this->redirect($this->generateUrl("ingresar_pronosticos"));        

        $em = $this->getDoctrine()->getManager();
        $equipos = $em->getRepository("AppBundle:Equipo")->findAll();
        

         return $this->render("admin/equipos/index.html.twig", array(
          "equipos" => $equipos
        ));
    }






    /**
     * @Route("/admin/equipos/editar/{id}", name="equipo_editar")     
     */
    public function editar($id)
    {
        if($this->getUser()->getTipo() == "user") return $this->redirect($this->generateUrl("ingresar_pronosticos"));        
        $em = $this->getDoctrine()->getManager();
        $equipo = $em->getRepository("AppBundle:Equipo")->find($id);
        return $this->render("admin/equipos/editar.html.twig", array("equipo" => $equipo));
    }



    /**
     * @Route("/admin/equipos/nuevo", name="equipo_nuevo")     
     */
    public function nuevo()
    {        
        if($this->getUser()->getTipo() == "user") return $this->redirect($this->generateUrl("ingresar_pronosticos"));        
        return $this->render("admin/equipos/nuevo.html.twig");
    }




        /**
     * @Route("/admin/equipos/editar_guardar/", name="equipo_editar_guardar")     
     */
    public function editarGuardar(Request $request)
    {
        if($this->getUser()->getTipo() == "user") return $this->redirect($this->generateUrl("ingresar_pronosticos"));        
        $em = $this->getDoctrine()->getManager();
        $equipo = $em->getRepository("AppBundle:Equipo")->find($request->get("id"));
        $equipo->setNombre($request->get("nombre"));



        $tmp_file_path = $_FILES["file"]["tmp_name"];
        $name = $_FILES["file"]["name"]; 
        if ($tmp_file_path != ""){
          $path_parts = pathinfo($name);
          $extension = $path_parts['extension'];                    
          // Agrego fisicamente el actual
          $filename = rand().".".$extension;
          $new_file_path = "fotos_equipos/".$filename;
          $res_move = move_uploaded_file($tmp_file_path, $new_file_path);                                
          $equipo->setFoto($filename);
        }


        $em->flush();
        $this->get("session")->getFlashBag()->add("notificacion", "info guardada");
        return $this->redirect($this->generateUrl("equipos"));
    }





        /**
     * @Route("/admin/equipos/nuevo_guardar/", name="equipo_nuevo_guardar")     
     */
    public function nuevoGuardar(Request $request)
    {

        if($this->getUser()->getTipo() == "user") return $this->redirect($this->generateUrl("ingresar_pronosticos"));        
        $em = $this->getDoctrine()->getManager();
        $equipo = new Equipo();
        $equipo->setNombre($request->get("nombre"));



        $tmp_file_path = $_FILES["file"]["tmp_name"];
        $name = $_FILES["file"]["name"]; 
        if ($tmp_file_path != ""){
          $path_parts = pathinfo($name);
          $extension = $path_parts['extension'];                    
          // Agrego fisicamente el actual
          $filename = rand().".".$extension;
          $new_file_path = "fotos_equipos/".$filename;
          $res_move = move_uploaded_file($tmp_file_path, $new_file_path);                                
          $equipo->setFoto($filename);
        }

        $em->persist($equipo);
        $em->flush();
        $this->get("session")->getFlashBag()->add("notificacion", "info guardada");
        return $this->redirect($this->generateUrl("equipos"));
    }    





        /**
     * @Route("/admin/equipos/eliminar/{id}", name="equipo_eliminar")     
     */
    public function eliminar($id)
    {
        if($this->getUser()->getTipo() == "user") return $this->redirect($this->generateUrl("ingresar_pronosticos"));        
        $em = $this->getDoctrine()->getManager();
        $equipo = $em->getRepository("AppBundle:Equipo")->find($id);
        // Me fijo si tiene partidos
        $tiene_partidos = false;
        
        $partidos_l = $em->getRepository("AppBundle:Partido")->findBy(array("local" => $equipo->getId()));      
        if(count($partidos_l) > 0) $tiene_partidos = true;

        $partidos_v = $em->getRepository("AppBundle:Partido")->findBy(array("visitante" => $equipo->getId()));      
        if(count($partidos_v) > 0) $tiene_partidos = true;


        if($tiene_partidos){
          $this->get("session")->getFlashBag()->add("error", "no se puede borrar porque el equipo tiene partidos asignados");
        return $this->redirect($this->generateUrl("equipos"));
        }
        
        $em->remove($equipo);
        $em->flush();
        $this->get("session")->getFlashBag()->add("notificacion", "info guardada");
        return $this->redirect($this->generateUrl("equipos"));
    }





}