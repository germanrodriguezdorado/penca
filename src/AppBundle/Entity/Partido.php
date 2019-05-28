<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partido
 *
 * @ORM\Table(name="partido")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartidoRepository")
 */
class Partido
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
     * @ORM\ManyToOne(targetEntity="Equipo", inversedBy="partido")
     * @ORM\JoinColumn(name="local", referencedColumnName="id", nullable=false)
     **/
    private $local;

    /**
     * @ORM\ManyToOne(targetEntity="Equipo", inversedBy="partido")
     * @ORM\JoinColumn(name="visitante", referencedColumnName="id", nullable=false)
     **/
    private $visitante;


    /**
     * @var datetime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;


    /**
     * @var string
     *
     * @ORM\Column(name="grupo", type="string", length=1, nullable=false)
     */
    private $grupo; 


    /**
     * @var string
     *
     * @ORM\Column(name="instancia", type="string", length=255, nullable=false)
     */
    private $instancia;    


 

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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Partido
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set grupo
     *
     * @param string $grupo
     *
     * @return Partido
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo
     *
     * @return string
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Set local
     *
     * @param \AppBundle\Entity\Equipo $local
     *
     * @return Partido
     */
    public function setLocal(\AppBundle\Entity\Equipo $local)
    {
        $this->local = $local;

        return $this;
    }

    /**
     * Get local
     *
     * @return \AppBundle\Entity\Equipo
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * Set visitante
     *
     * @param \AppBundle\Entity\Equipo $visitante
     *
     * @return Partido
     */
    public function setVisitante(\AppBundle\Entity\Equipo $visitante)
    {
        $this->visitante = $visitante;

        return $this;
    }

    /**
     * Get visitante
     *
     * @return \AppBundle\Entity\Equipo
     */
    public function getVisitante()
    {
        return $this->visitante;
    }


      /**
     * Set instancia
     *
     * @param string $instancia
     *
     * @return Partido
     */
    public function setInstancia($instancia)
    {
        $this->instancia = $instancia;

        return $this;
    }

    /**
     * Get instancia
     *
     * @return string
     */
    public function getInstancia()
    {
        return $this->instancia;
    }



    public function esValidoPronosticar(){
        $respuesta = true;
        $ahora = new \DateTime("now");
        $ahora->modify("+2 hours");




        if($ahora->format("YmdHis") > $this->getFecha()->format("YmdHis")){
            $respuesta = false;
        }

        return $respuesta;
    }
}
