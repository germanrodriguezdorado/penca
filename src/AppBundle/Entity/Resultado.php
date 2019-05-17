<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resultado
 *
 * @ORM\Table(name="resultado")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultadoRepository")
 */
class Resultado
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
     * @ORM\ManyToOne(targetEntity="Partido", inversedBy="resultado")
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
     * @ORM\Column(name="jugado", type="boolean")
     */
    private $jugado = false;          


 

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
     * @return Resultado
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
     * @return Resultado
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
     * Set partido
     *
     * @param \AppBundle\Entity\Partido $partido
     *
     * @return Resultado
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
     * Set jugado
     *
     * @param boolean $jugado
     *
     * @return Resultado
     */
    public function setJugado($jugado)
    {
        $this->jugado = $jugado;

        return $this;
    }

    /**
     * Get jugado
     *
     * @return boolean
     */
    public function getJugado()
    {
        return $this->jugado;
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
