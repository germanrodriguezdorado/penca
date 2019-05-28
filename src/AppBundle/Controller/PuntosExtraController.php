<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PuntosExtraController extends Controller
{


     /**
     * @Route("/puntosextraadmin", name="puntos_extra_admin")     
     */
    public function puntosExtraAdmin(Request $request)
    {
            // Si es user no puede
        if($this->getUser()->getTipo() == "user"){
            return $this->redirect($this->generateUrl("ingresar_pronosticos"));
        }


        $em = $this->getDoctrine()->getManager();
        $equipos = $em->getRepository("AppBundle:Equipo")->findAll();  
        $puntos_extra = $em->getRepository("AppBundle:PuntosExtra")->find(1);  



        if ($request->getMethod() == "POST") {      

            $campeon = $request->get("campeon");
                        if($campeon == ""){
                            $puntos_extra->setCampeon(null);

                        }else{
                            $equipo = $em->getRepository("AppBundle:Equipo")->find($campeon);
                            $puntos_extra->setCampeon($equipo);   
                        }


                        $subcampeon = $request->get("subcampeon");
                        if($subcampeon == ""){
                            $puntos_extra->setSubcampeon(null);
                        }else{
                            $equipo = $em->getRepository("AppBundle:Equipo")->find($subcampeon);
                            $puntos_extra->setSubcampeon($equipo);   
                        }


                        $hasta = \DateTime::createFromFormat("d/m/Y H:i", $request->get("hasta"));
                        $puntos_extra->setHasta($hasta);   


            $em->flush();
            $this->get("session")->getFlashBag()->add("notificacion", "info guardada");
            return $this->redirect($this->generateUrl("puntos_extra_admin"));

        }


        return $this->render("admin/puntos_extra_admin.html.twig", array(
            "equipos" => $equipos,
            "puntos_extra" => $puntos_extra
        ));




    }






    /**
     * @Route("/puntosextra", name="puntos_extra")     
     */
    public function puntosExtraUser(Request $request)
    {


        // Si es admin redirigir a resultados
        if($this->getUser()->getTipo() == "admin"){
            return $this->redirect($this->generateUrl("resultados"));
        }


        
      
    	$em = $this->getDoctrine()->getManager();
    	$equipos = $em->getRepository("AppBundle:Equipo")->findAll();     
            $puntos_extra = $em->getRepository("AppBundle:PuntosExtra")->find(1); 
            

    	if ($request->getMethod() == "POST") {      

                        if( $puntos_extra->esValidoCambiar() == false ){
                            return $this->redirect($this->generateUrl("ingresar_pronosticos"));
                        }

    		$campeon = $request->get("campeon");
                        if($campeon == ""){
                            $this->getUser()->setCampeon(null);
                        }else{
                            $equipo = $em->getRepository("AppBundle:Equipo")->find($campeon);
                            $this->getUser()->setCampeon($equipo);   
                        }


                        $subcampeon = $request->get("subcampeon");
                        if($subcampeon == ""){
                            $this->getUser()->setSubcampeon(null);
                        }else{
                            $equipo = $em->getRepository("AppBundle:Equipo")->find($subcampeon);
                            $this->getUser()->setSubcampeon($equipo);   
                        }


    		$em->flush();
    		$this->get("session")->getFlashBag()->add("notificacion", "info guardada");
    		return $this->redirect($this->generateUrl("puntos_extra"));

        }


        return $this->render("user/puntos_extra.html.twig", array(
        	"equipos" => $equipos,
            "puntos_extra" => $puntos_extra
        ));
    }
}
