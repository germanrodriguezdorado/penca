<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Resultado;

/**
 * Pronostico
 *
 * @ORM\Table(name="pronostico")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PronosticoRepository")
 */
class Pronostico
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="pronostico")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id", nullable=false)
     **/
    private $usuario;    

    /**
     * @ORM\ManyToOne(targetEntity="Partido", inversedBy="pronostico")
     * @ORM\JoinColumn(name="partido", referencedColumnName="id", nullable=false)
     **/
    private $partido;

    /**
     * @var int
     *
     * @ORM\Column(name="goles_local", type="integer", nullable=true)
     */
    private $golesLocal;


    /**
     * @var int
     *
     * @ORM\Column(name="goles_visitante", type="integer", nullable=true)
     */
    private $golesVisitante;        


    /**
     * @var boolean
     *
     * @ORM\Column(name="pronosticado", type="boolean")
     */
    private $pronosticado = false;     


 

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set golesLocal
     *
     * @param integer $golesLocal
     *
     * @return Pronostico
     */
    public function setGolesLocal($golesLocal)
    {
        $this->golesLocal = $golesLocal;

        return $this;
    }

    /**
     * Get golesLocal
     *
     * @return integer
     */
    public function getGolesLocal()
    {
        return $this->golesLocal;
    }

    /**
     * Set golesVisitante
     *
     * @param integer $golesVisitante
     *
     * @return Pronostico
     */
    public function setGolesVisitante($golesVisitante)
    {
        $this->golesVisitante = $golesVisitante;

        return $this;
    }

    /**
     * Get golesVisitante
     *
     * @return integer
     */
    public function getGolesVisitante()
    {
        return $this->golesVisitante;
    }

    /**
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     *
     * @return Pronostico
     */
    public function setUsuario(\AppBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set partido
     *
     * @param \AppBundle\Entity\Partido $partido
     *
     * @return Pronostico
     */
    public function setPartido(\AppBundle\Entity\Partido $partido)
    {
        $this->partido = $partido;

        return $this;
    }

    /**
     * Get partido
     *
     * @return \AppBundle\Entity\Partido
     */
    public function getPartido()
    {
        return $this->partido;
    }








    /**
     * Set pronosticado
     *
     * @param boolean $pronosticado
     *
     * @return Pronostico
     */
    public function setPronosticado($pronosticado)
    {
        $this->pronosticado = $pronosticado;

        return $this;
    }

    /**
     * Get pronosticado
     *
     * @return boolean
     */
    public function getPronosticado()
    {
        return $this->pronosticado;
    }



      public function darGanador(){


        if( $this->getGolesLocal() == $this->getGolesVisitante() ){
            return "empate";
        }


        if( $this->getGolesLocal() > $this->getGolesVisitante() ){
            return "local";
        }

        if( $this->getGolesLocal() < $this->getGolesVisitante() ){
            return "visitante";
        }


        return "";


    }



    public function darDiferenciaDeGoles(){
        return abs($this->getGolesLocal() - $this->getGolesVisitante());
    }





    public function calcularPuntaje(Resultado $resultado){

        $respuesta = array();
        $puntos = 0;
        $logros = array();

        if($this->getPronosticado()){

            // Resultado
            if($this->darGanador() == $resultado->darGanador()){
                $puntos = $puntos + 10;
                array_push($logros, "Acierto al resultado! (10)");
                if($this->darGanador() != "empate"){
                    // Diferencia de goles
                    if($resultado->darDiferenciaDeGoles() == $this->darDiferenciaDeGoles()){
                       $puntos = $puntos + 2;
                       array_push($logros, "Diferencia de goles! (2)"); 
                    }
                }
            }


            // Marcador exacto
            if($resultado->getGolesLocal() == $this->getGolesLocal()){
                if($resultado->getGolesVisitante() == $this->getGolesVisitante()){
                    $puntos = $puntos + 2;
                    array_push($logros, "Marcador exacto! (2)");
                }
            }


            


        }

        
        $respuesta["puntos"] = $puntos;
        $respuesta["logros"] = $logros;

        return $respuesta;


    }

    
}
