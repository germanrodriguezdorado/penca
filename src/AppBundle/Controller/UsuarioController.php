<?php
 
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



// Clases
use AppBundle\Entity\Usuario;
 



class UsuarioController extends Controller
{


    /**
     * @Route("/admin/usuarios", name="usuarios")     
     */
    public function index()
    {
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
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository("AppBundle:Usuario")->find($id);
        return $this->render("admin/usuarios/editar.html.twig", array("usuario" => $usuario));
    }



    /**
     * @Route("/admin/usuarios/nuevo", name="usuario_nuevo")     
     */
    public function nuevo()
    {        
        return $this->render("admin/usuarios/nuevo.html.twig");
    }




        /**
     * @Route("/admin/usuarios/editar_guardar/", name="usuario_editar_guardar")     
     */
    public function editarGuardar(Request $request)
    {
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
        $em->flush();  
        $this->get("session")->getFlashBag()->add("notificacion", "info guardada");
        return $this->redirect($this->generateUrl("usuarios"));
    }    





        /**
     * @Route("/admin/usuarios/eliminar/{id}", name="usuario_eliminar")     
     */
    public function eliminar($id)
    {
        return $this->redirect($this->generateUrl("usuarios"));
    }





}