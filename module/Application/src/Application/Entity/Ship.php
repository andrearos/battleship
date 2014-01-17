<?php

namespace Application\Entity;
use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Annotation\Name("ships")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 *
 * @Entity @Table(name="ships")
 **/
class Ship
{
    /** @Id @Column(type="integer") @GeneratedValue @Annotation\Exclude() **/
    protected $id;

    /**
     * @ManyToOne(targetEntity="Field", inversedBy="ships") @Annotation\Exclude()
     **/
    protected $field;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Nome della nave:"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     *
     * @Column(type="string")
     */
    protected $name;

    /** @Column(type="decimal", precision=5, scale=2) @Annotation\Exclude() **/
    protected $velocity;

    /** @Column(type="decimal", precision=5, scale=2) @Annotation\Exclude() **/
    protected $angle;

    /** @Column(type="decimal", precision=5, scale=2) @Annotation\Exclude() **/
    protected $x;

    /** @Column(type="decimal", precision=5, scale=2) @Annotation\Exclude() **/
    protected $y;

    /** @Column(type="boolean") @Annotation\Exclude() **/
    protected $sonar;

    /** @Column(type="integer") @Annotation\Exclude() **/
    protected $status;

    /** @Column(type="boolean") @Annotation\Exclude() **/
    protected $approved;

    /** @Column(type="decimal", precision=5, scale=2) @Annotation\Exclude() **/
    protected $fuel;

    /**
     * @OneToMany(targetEntity="Weapon", mappedBy="ship", cascade={"remove"}) @Annotation\Exclude()
     **/
    protected $weapons = null;

    /**
     * @OneToMany(targetEntity="Weapon", mappedBy="target") @Annotation\Exclude()
     *
    protected $attacks = null;
    */

    /**
     * @ManyToMany(targetEntity="User") @Annotation\Exclude()
     **/
    protected $members = null;

    public function __construct()
    {
        $this->weapons = new ArrayCollection();
        $this->members = new ArrayCollection();
    }

    public function assignedWeapon($weapon)
    {
        $this->weapons[] = $weapon;
    }

    public function getWeapons()
    {
        return $this->weapons;
    }

    /*
    public function attackedFrom($weapon)
    {
        $this->attacks[] = $weapon;
    }

    public function getAttacks()
    {
        return $this->attacks;
    }*/

    public function assignedMember($user)
    {
        $this->members[] = $user;
    }

    public function getMembers()
    {
        return $this->members;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setField($field)
    {
        $field->assignedShip($this);
        $this->field = $field;
        return $this;
    }

    public function getField()
    {
        return $this->field;
    }

    public function setVelocity($velocity)
    {
        $this->velocity = $velocity;

        return $this;
    }

    public function getVelocity()
    {
        return $this->velocity;
    }

    public function setAngle($angle)
    {
        $this->angle = $angle;

        return $this;
    }

    public function getAngle()
    {
        return $this->angle;
    }

    public function setX($x)
    {
        $this->x = $x;

        return $this;
    }

    public function getX()
    {
        return $this->x;
    }

    public function setY($y)
    {
        $this->y = $y;

        return $this;
    }

    public function getY()
    {
        return $this->y;
    }

    public function setSonar($sonar)
    {
        $this->sonar = $sonar;

        return $this;
    }

    public function getSonar()
    {
        return $this->sonar;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setApproved($approved)
    {
        $this->approved = $approved;

        return $this;
    }

    public function getApproved()
    {
        return $this->approved;
    }

    public function setFuel($fuel)
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getFuel()
    {
        return $this->fuel;
    }

    public function containsMember($user) {
        foreach ($this->getMembers() as $member) {
            if($member->getId() == $user->getId()) return true;
        }
    }
}