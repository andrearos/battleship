<?php

namespace Application\Entity;
use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Annotation\Name("fields")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 *
 * @Entity @Table(name="fields")
 **/
class Field
{
    /** @Id @Column(type="integer") @GeneratedValue @Annotation\Exclude() **/
    protected $id;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Nome del mare:"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     *
     * @Column(type="string")
     */
    protected $name;

    /**
     * @OneToMany(targetEntity="Ship", mappedBy="field", cascade={"remove"}) @Annotation\Exclude()
     **/
    protected $ships = null;

    public function __construct()
    {
        $this->ships = new ArrayCollection();
    }

    public function assignedShip($ship)
    {
        $this->ships[] = $ship;
    }

    public function getShips()
    {
        return $this->ships;
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
}