<?php

namespace Application\Entity;
use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Annotation\Name("users")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 *
 * @Entity @Table(name="users")
 */
class User
{
    /**
     * @Annotation\Exclude()
     *
     * @Id @GeneratedValue @Column(type="integer")
     */
    protected $id;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Ruolo:"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Flags({"priority":"500"})
     *
     * @Column(type="string")
     */
    protected $role;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Nome:"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Flags({"priority":"400"})
     *
     * @Column(type="string")
     */
    protected $name;

    /**
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Options({"label":"Password:","priority":"300"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Flags({"priority":"300"})
     *
     * @Column(type="string")
     */
    protected $password;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Username:"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Flags({"priority":"400"})
     *
     * @Column(type="string")
     */
    protected $username;

    /**
     * @ManyToOne(targetEntity="Ship", inversedBy="members") @Annotation\Exclude()
     *
    protected $ship;
    */

    public function __construct()
    {
        $this->ships = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /*
    public function setShip($ship)
    {
        $ship->assignedMember($this);
        $this->ship = $ship;
        return $this;
    }

    public function getShip()
    {
        return $this->ship;
    }
    */

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $this->hashPassword($password);
        return $this;
    }

    public function verifyPassword($password)
    {
        return ($this->password == $this->hashPassword($password));
    }

    private function hashPassword($password)
    {
        return $password;
    }
}