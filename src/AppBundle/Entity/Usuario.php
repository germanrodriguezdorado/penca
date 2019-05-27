<?php
// src/AppBundle/Entity/Usuario.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\PuntosExtra;


/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class Usuario extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();        
    }


    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;


        /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255, nullable=true)
     */
    private $tipo;    


    /**
     * @ORM\ManyToOne(targetEntity="Equipo", inversedBy="usuario")
     * @ORM\JoinColumn(name="campeon", referencedColumnName="id", nullable=true)
     **/
    private $campeon;    

    /**
     * @ORM\ManyToOne(targetEntity="Equipo", inversedBy="usuario")
     * @ORM\JoinColumn(name="subcampeon", referencedColumnName="id", nullable=true)
     **/
    private $subcampeon;     

    

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return User
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

   

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return Usuario
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set campeon
     *
     * @param \AppBundle\Entity\Equipo $campeon
     *
     * @return Usuario
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
     * @return Usuario
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


    public function puntosExtraGenerados(PuntosExtra $puntos_extra){

        $acumulado = 0;

        if($puntos_extra->getCampeon() == null || $puntos_extra->getSubcampeon() == null){
            return $acumulado;
        }


        if($this->getCampeon() == null || $this->getSubcampeon() == null){
            return $acumulado;
        }


        // Por acertar al campeon
        if($puntos_extra->getCampeon()->getId() == $this->getCampeon()->getId() ){
            $acumulado = $acumulado + 15;
        }

        // Por acertar al subcampeon
        if($puntos_extra->getSubcampeon()->getId() == $this->getSubcampeon()->getId() ){
            $acumulado = $acumulado + 10;
        }


        return $acumulado;


    }


}
