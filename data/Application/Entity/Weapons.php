<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Weapons
 *
 * @ORM\Table(name="weapons", indexes={@ORM\Index(name="IDX_520EBBE1C256317D", columns={"ship_id"}), @ORM\Index(name="IDX_520EBBE1158E0B66", columns={"target_id"})})
 * @ORM\Entity
 */
class Weapons
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=false)
     */
    private $text;

    /**
     * @var integer
     *
     * @ORM\Column(name="result", type="integer", nullable=false)
     */
    private $result;

    /**
     * @var \Application\Entity\Ships
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Ships")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="target_id", referencedColumnName="id")
     * })
     */
    private $target;

    /**
     * @var \Application\Entity\Ships
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Ships")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ship_id", referencedColumnName="id")
     * })
     */
    private $ship;



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
     * Set text
     *
     * @param string $text
     * @return Weapons
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set result
     *
     * @param integer $result
     * @return Weapons
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return integer 
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set target
     *
     * @param \Application\Entity\Ships $target
     * @return Weapons
     */
    public function setTarget(\Application\Entity\Ships $target = null)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target
     *
     * @return \Application\Entity\Ships 
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set ship
     *
     * @param \Application\Entity\Ships $ship
     * @return Weapons
     */
    public function setShip(\Application\Entity\Ships $ship = null)
    {
        $this->ship = $ship;

        return $this;
    }

    /**
     * Get ship
     *
     * @return \Application\Entity\Ships 
     */
    public function getShip()
    {
        return $this->ship;
    }
}
