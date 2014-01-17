<?php

namespace Application\Entity;
use Zend\Form\Annotation;

/**
 * @Annotation\Name("weapons")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 *
 * @Entity @Table(name="weapons")
 **/
class Weapon
{
    /** @Id @Column(type="integer") @GeneratedValue @Annotation\Exclude() **/
    protected $id;

    /**
     * @ManyToOne(targetEntity="Ship", inversedBy="weapons") @Annotation\Exclude()
     **/
    protected $ship;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Testo della domanda:", "width": 300})
     * @Annotation\Attributes({"size":80})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     *
     * @Column(type="text") **/
    protected $text;

    /** @Column(type="integer") @Annotation\Exclude() **/
    protected $fired;

    /** @Column(type="decimal", precision=5, scale=2) @Annotation\Exclude() **/
    protected $angle;

    public function getId()
    {
        return $this->id;
    }

    public function setShip($ship)
    {
        $ship->assignedWeapon($this);
        $this->ship = $ship;
        return $this;
    }

    public function getShip()
    {
        return $this->ship;
    }

    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setFired($fired)
    {
        $this->fired = $fired;
        return $this;
    }

    public function getFired()
    {
        return $this->fired;
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

}