<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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

    
}
