<?php
 
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



// Clases
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Pronostico;
use AppBundle\Entity\PuntosExtra;
 



class UsuarioController extends Controller
{


    /**
     * @Route("/admin/usuarios", name="usuarios")     
     */
    public function index()
    {
        if($this->getUser()->getTipo() == "user") return $this->redirect($this->generateUrl("ingresar_pronosticos"));        
        $em = $this->getDoctrine()->getManager();
        $usuarios = $em->getRepository("AppBundle:Usuario")->findBy(array("tipo" => "user"));
         return $this->render("admin/usuarios/index.html.twig", array(
          "usuarios" => $usuarios
        ));
    }






    /**
     * @Route("/admin/usuarios/editar/{id}", name="usuario_editar")     
     */
    public function editar($id)
    {
        if($this->getUser()->getTipo() == "user") return $this->redirect($this->generateUrl("ingresar_pronosticos"));        
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository("AppBundle:Usuario")->find($id);
        return $this->render("admin/usuarios/editar.html.twig", array("usuario" => $usuario));
    }



    /**
     * @Route("/admin/usuarios/nuevo", name="usuario_nuevo")     
     */
    public function nuevo()
    {        
        if($this->getUser()->getTipo() == "user") return $this->redirect($this->generateUrl("ingresar_pronosticos"));        
        return $this->render("admin/usuarios/nuevo.html.twig");
    }




        /**
     * @Route("/admin/usuarios/editar_guardar/", name="usuario_editar_guardar")     
     */
    public function editarGuardar(Request $request)
    {
        if($this->getUser()->getTipo() == "user") return $this->redirect($this->generateUrl("ingresar_pronosticos"));            
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get("fos_user.user_manager");
        $usuario = $em->getRepository("AppBundle:Usuario")->find($request->get("id"));
        $usuario->setNombre($request->get("nombre"));
        $usuario->setUsername($request->get("email"));
        $usuario->setEmail($request->get("email"));
        $usuario->setEmailCanonical($request->get("email"));      
        $userManager->updateUser($usuario);
        $em->flush();  
        $this->get("session")->getFlashBag()->add("notificacion", "info guardada");
        return $this->redirect($this->generateUrl("usuarios"));
    }





        /**
     * @Route("/admin/usuarios/nuevo_guardar/", name="usuario_nuevo_guardar")     
     */
    public function nuevoGuardar(Request $request)
    {

        if($this->getUser()->getTipo() == "user") return $this->redirect($this->generateUrl("ingresar_pronosticos"));        
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get("fos_user.user_manager");
        $usuario = $userManager->createUser();
        $usuario->setNombre($request->get("nombre"));
        $usuario->setUsername($request->get("email"));
        $usuario->setEmail($request->get("email"));
        $usuario->setEmailCanonical($request->get("email"));
        $usuario->setTipo("user");      
        $usuario->setPlainPassword("123456");              
        $usuario->setEnabled(true);          
        $userManager->updateUser($usuario);

        // Creo un pronostico para cada partido
        $partidos = $em->getRepository("AppBundle:Partido")->findAll();
        foreach ($partidos as $partido) {
            $pronostico = new Pronostico();
            $pronostico->setUsuario($usuario);
            $pronostico->setPartido($partido);
            $pronostico->setPronosticado(false);
            $em->persist($pronostico);
        }

        


        $em->flush();  
        $this->get("session")->getFlashBag()->add("notificacion", "info guardada");
        return $this->redirect($this->generateUrl("usuarios"));
    }    





        /**
     * @Route("/admin/usuarios/eliminar/{id}", name="usuario_eliminar")     
     */
    public function eliminar($id)
    {
        if($this->getUser()->getTipo() == "user") return $this->redirect($this->generateUrl("ingresar_pronosticos"));        
        return $this->redirect($this->generateUrl("usuarios"));
    }





    /**
     * @Route("/mis_datos", name="mis_datos")     
     */
    public function misDatos(Request $request)
    {
        if($this->getUser()->getTipo() == "admin") return $this->redirect($this->generateUrl("resultados"));        
        
        if($request->getMethod() == "POST") {    
            $em = $this->getDoctrine()->getManager();
            $this->getUser()->setNombre($request->get("nombre"));
            if($request->get("password") != ""){
                $this->getUser()->setPlainPassword($request->get("password"));       
            }
            $userManager = $this->get("fos_user.user_manager");
            $userManager->updateUser($this->getUser());
            $this->get("session")->getFlashBag()->add("notificacion", "info guardada");
            return $this->redirect($this->generateUrl("mis_datos"));
        }
        return $this->render("user/mis_datos.html.twig");
    }    





}