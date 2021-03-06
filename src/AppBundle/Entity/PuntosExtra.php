<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * PuntosExtra
 *
 * @ORM\Table(name="puntos_extra")
 * @ORM\Entity()
 */
class PuntosExtra
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
     * @var datetime
     *
     * @ORM\Column(name="hasta", type="datetime", nullable=true)
     */
    private $hasta;    


    /**
     * @ORM\ManyToOne(targetEntity="Equipo", inversedBy="puntosExtra")
     * @ORM\JoinColumn(name="campeon", referencedColumnName="id", nullable=true)
     **/
    private $campeon;    

    /**
     * @ORM\ManyToOne(targetEntity="Equipo", inversedBy="puntosExtra")
     * @ORM\JoinColumn(name="subcampeon", referencedColumnName="id", nullable=true)
     **/
    private $subcampeon; 

       


 

    

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
     * Set campeon
     *
     * @param \AppBundle\Entity\Equipo $campeon
     *
     * @return PuntosExtra
     */
    public function setCampeon(\AppBundle\Entity\Equipo $campeon = null)
    {
        $this->campeon = $campeon;

        return $this;
    }

    /**
     * Get campeon
     *
     * @return \AppBundle\Entity\Equipo
     */
    public function getCampeon()
    {
        return $this->campeon;
    }

    /**
     * Set subcampeon
     *
     * @param \AppBundle\Entity\Equipo $subcampeon
     *
     * @return PuntosExtra
     */
    public function setSubcampeon(\AppBundle\Entity\Equipo $subcampeon = null)
    {
        $this->subcampeon = $subcampeon;

        return $this;
    }

    /**
     * Get subcampeon
     *
     * @return \AppBundle\Entity\Equipo
     */
    public function getSubcampeon()
    {
        return $this->subcampeon;
    }

    /**
     * Set hasta.
     *
     * @param \DateTime|null $hasta
     *
     * @return PuntosExtra
     */
    public function setHasta($hasta = null)
    {
        $this->hasta = $hasta;

        return $this;
    }

    /**
     * Get hasta.
     *
     * @return \DateTime|null
     */
    public function getHasta()
    {
        return $this->hasta;
    }


    public function esValidoCambiar(){
        $respuesta = true;
        $ahora = new \DateTime("now");
        
        
        if($ahora->format("YmdHis") > $this->getHasta()->format("YmdHis")){
            $respuesta = false;
        }
        return $respuesta;
    }


}
