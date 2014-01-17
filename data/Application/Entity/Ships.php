<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ships
 *
 * @ORM\Table(name="ships", indexes={@ORM\Index(name="IDX_27F71B317E3C61F9", columns={"owner_id"}), @ORM\Index(name="IDX_27F71B31443707B0", columns={"field_id"})})
 * @ORM\Entity
 */
class Ships
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="velocity", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $velocity;

    /**
     * @var string
     *
     * @ORM\Column(name="angle", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $angle;

    /**
     * @var string
     *
     * @ORM\Column(name="x", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $x;

    /**
     * @var string
     *
     * @ORM\Column(name="y", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $y;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sonar", type="boolean", nullable=false)
     */
    private $sonar;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var boolean
     *
     * @ORM\Column(name="approved", type="boolean", nullable=false)
     */
    private $approved;

    /**
     * @var string
     *
     * @ORM\Column(name="fuel", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $fuel;

    /**
     * @var \Application\Entity\Fields
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Fields")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="field_id", referencedColumnName="id")
     * })
     */
    private $field;

    /**
     * @var \Application\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     * })
     */
    private $owner;



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
     * Set name
     *
     * @param string $name
     * @return Ships
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set velocity
     *
     * @param string $velocity
     * @return Ships
     */
    public function setVelocity($velocity)
    {
        $this->velocity = $velocity;

        return $this;
    }

    /**
     * Get velocity
     *
     * @return string 
     */
    public function getVelocity()
    {
        return $this->velocity;
    }

    /**
     * Set angle
     *
     * @param string $angle
     * @return Ships
     */
    public function setAngle($angle)
    {
        $this->angle = $angle;

        return $this;
    }

    /**
     * Get angle
     *
     * @return string 
     */
    public function getAngle()
    {
        return $this->angle;
    }

    /**
     * Set x
     *
     * @param string $x
     * @return Ships
     */
    public function setX($x)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * Get x
     *
     * @return string 
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set y
     *
     * @param string $y
     * @return Ships
     */
    public function setY($y)
    {
        $this->y = $y;

        return $this;
    }

    /**
     * Get y
     *
     * @return string 
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Set sonar
     *
     * @param boolean $sonar
     * @return Ships
     */
    public function setSonar($sonar)
    {
        $this->sonar = $sonar;

        return $this;
    }

    /**
     * Get sonar
     *
     * @return boolean 
     */
    public function getSonar()
    {
        return $this->sonar;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Ships
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set approved
     *
     * @param boolean $approved
     * @return Ships
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;

        return $this;
    }

    /**
     * Get approved
     *
     * @return boolean 
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * Set fuel
     *
     * @param string $fuel
     * @return Ships
     */
    public function setFuel($fuel)
    {
        $this->fuel = $fuel;

        return $this;
    }

    /**
     * Get fuel
     *
     * @return string 
     */
    public function getFuel()
    {
        return $this->fuel;
    }

    /**
     * Set field
     *
     * @param \Application\Entity\Fields $field
     * @return Ships
     */
    public function setField(\Application\Entity\Fields $field = null)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get field
     *
     * @return \Application\Entity\Fields 
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set owner
     *
     * @param \Application\Entity\Users $owner
     * @return Ships
     */
    public function setOwner(\Application\Entity\Users $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Application\Entity\Users 
     */
    public function getOwner()
    {
        return $this->owner;
    }
}
