<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ranking
 *
 * @ORM\Table(name="ranking")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RankingRepository")
 */
class Ranking
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
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="ranking")
     * @ORM\JoinColumn(name="usuario", referencedColumnName="id", nullable=false)
     **/
    private $usuario;


    /**
     * @var int
     *
     * @ORM\Column(name="puntos", type="integer", nullable=false)
     */
    private $puntos = 0;    

     


 

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
     * Set puntos
     *
     * @param integer $puntos
     *
     * @return Ranking
     */
    public function setPuntos($puntos)
    {
        $this->puntos = $puntos;

        return $this;
    }

    /**
     * Get puntos
     *
     * @return integer
     */
    public function getPuntos()
    {
        return $this->puntos;
    }

    /**
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     *
     * @return Ranking
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
}
