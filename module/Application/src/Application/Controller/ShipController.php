<?php
namespace Application\Controller;

use Application\Entity\Ship;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;

class ShipController extends AbstractActionController
{
    protected $entityManager;
    protected $currentUser;

    public function setEntityManager(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    public function em() // get entityManager
    {
        if($this->entityManager === null) {
            $this->entityManager = $this->serviceLocator->get('entity-manager');
        }
        return $this->entityManager;
    }

    public function user() {
        if($this->currentUser === null) {
            $this->currentUser = $this->serviceLocator->get('auth')->getIdentity();
        }
        return $this->currentUser;
    }

    public function indexAction()
    {
        $field_id = (int) $this->params('id');
        if ($field_id === null) {
            return $this->redirect()->toRoute('field');
        }

        $dql = 'SELECT s FROM e:Ship s WHERE s.field = ?1 ORDER BY s.name';
        $query = $this->em()->createQuery($dql)->setParameter(1,$field_id);
        $ships = $query->getResult();
        $field = $this->em()->find('e:Field',$field_id);

        return array(
            'ships' => $ships,
            'field_id' => $field_id,
            'user' => $this->user(),
            'field' => $field
        );
    }

    public function addAction()
    {
        // current user
        $user = $this->em()->find('e:User',$this->user()->getId());

        // current field
        $field_id = (int) $this->params('id');
        if ($field_id === null) {
            return $this->redirect()->toRoute('field');
        }
        $field = $this->em()->find('e:Field',$field_id);

        $builder = new AnnotationBuilder();
        $entity = new Ship();
        $form = $builder->createForm($entity);

        $form->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Salva',
                'required' => false,
            )
        ));

        $form->bind($entity);

        if($this->getRequest()->isPost()) {
            $data = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );
            $form->setData($data);
            if($form->isValid()) {
                $entity->setVelocity(0);
                $entity->setAngle(0);
                $entity->setX(rand(-900,900)/100.0);
                $entity->setY(rand(-500,500)/100.0);
                $entity->setSonar(false);
                $entity->setStatus(100);
                $entity->setApproved(false);
                $entity->setFuel(100.0);
                if($user->getRole()!='admin') $entity->assignedMember($user);
                $entity->setField($field);

                $this->em()->persist($entity);
                $this->em()->flush();

                $result = $this->redirect()->toRoute('ship',array('action'=>'index', 'id'=>$field_id));
                return $result;
            }
        }

        return array('form1' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params('id');
        if (null === $id) {
            return $this->redirect()->toRoute('ship');
        }

        $builder = new AnnotationBuilder();
        $entity = new Ship();
        $form = $builder->createForm($entity);

        $form->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Salva',
                'required' => false,
            )
        ));

        $ship = $this->em()->find('e:Ship',$id);
        $field_id = $ship->getField()->getId();

        $form->bind($ship);

        if($this->getRequest()->isPost()) {
            $data = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );
            $form->setData($data);
            if($form->isValid()) {
                $this->em()->persist($ship);
                $this->em()->flush();

                $result = $this->redirect()->toRoute('ship',array('action'=>'index', 'id'=>$field_id));
                return $result;
            }
        }
        else {
            return array('form1' => $form);
        }
    }

    public function deleteAction()
    {
        $id = (int) $this->params('id');
        if (null === $id) {
            return $this->redirect()->toRoute('field');
        }

        $ship = $this->em()->find('e:Ship',$id);
        $field_id = $ship->getField()->getId();

        $this->em()->remove($ship);
        $this->em()->flush();

        $result = $this->redirect()->toRoute('ship',array('action'=>'index', 'id'=>$field_id));

        return $result;
    }

    public function approveAction()
    {
        $id = (int) $this->params('id');
        if (null === $id) {
            return $this->redirect()->toRoute('field');
        }

        $ship = $this->em()->find('e:Ship',$id);
        $field_id = $ship->getField()->getId();
        $approved = !$ship->getApproved();
        $ship->setApproved($approved);

        $this->em()->persist($ship);
        $this->em()->flush();

        $result = $this->redirect()->toRoute('ship',array('action'=>'index', 'id'=>$field_id));

        return $result;
    }

    public function pingAction()
    {
        $id = (int) $this->params('id');
        if (null === $id) {
            return $this->redirect()->toRoute('field');
        }

        $ship = $this->em()->find('e:Ship',$id);
        $field_id = $ship->getField()->getId();
        $ship->setSonar(true);

        $this->em()->persist($ship);
        $this->em()->flush();

        $result = $this->redirect()->toRoute('ship',array('action'=>'index', 'id'=>$field_id));

        return $result;
    }

    public function increaseVelocityAction()
    {
        $id = (int) $this->params('id');
        if (null === $id) {
            return $this->redirect()->toRoute('field');
        }

        $ship = $this->em()->find('e:Ship',$id);
        $velocity = $ship->getVelocity();
        $field_id = $ship->getField()->getId();
        $velocity+=2;
        if($velocity>30) $velocity=30;
        $ship->setVelocity($velocity);

        $this->em()->persist($ship);
        $this->em()->flush();

        $result = $this->redirect()->toRoute('ship',array('action'=>'panel', 'id'=>$id));

        return $result;
    }

    public function decreaseVelocityAction()
    {
        $id = (int) $this->params('id');
        if (null === $id) {
            return $this->redirect()->toRoute('field');
        }

        $ship = $this->em()->find('e:Ship',$id);
        $velocity = $ship->getVelocity();
        $field_id = $ship->getField()->getId();
        $velocity-=2;
        if($velocity<0) $velocity=0;
        $ship->setVelocity($velocity);

        $this->em()->persist($ship);
        $this->em()->flush();

        $result = $this->redirect()->toRoute('ship',array('action'=>'panel', 'id'=>$id));

        return $result;
    }

    public function increaseAngleAction()
    {
        $id = (int) $this->params('id');
        if (null === $id) {
            return $this->redirect()->toRoute('field');
        }

        $ship = $this->em()->find('e:Ship',$id);
        $angle = $ship->getAngle();
        $field_id = $ship->getField()->getId();
        $angle+=15;
        if($angle>360) $angle-=360;
        $ship->setAngle($angle);

        $this->em()->persist($ship);
        $this->em()->flush();

        $result = $this->redirect()->toRoute('ship',array('action'=>'panel', 'id'=>$id));

        return $result;
    }

    public function decreaseAngleAction()
    {
        $id = (int) $this->params('id');
        if (null === $id) {
            return $this->redirect()->toRoute('field');
        }

        $ship = $this->em()->find('e:Ship',$id);
        $angle = $ship->getAngle();
        $field_id = $ship->getField()->getId();
        $angle-=15;
        if($angle<0) $angle+=360;
        $ship->setAngle($angle);

        $this->em()->persist($ship);
        $this->em()->flush();

        $result = $this->redirect()->toRoute('ship',array('action'=>'panel', 'id'=>$id));

        return $result;
    }

    public function addMemberAction()
    {
        $id = (int) $this->params('id');
        if (null === $id) {
            return $this->redirect()->toRoute('field');
        }

        $ship = $this->em()->find('e:Ship',$id);
        $user = $this->em()->find('e:User',$this->user()->getId());

        $ship->assignedMember($user);

        $this->em()->persist($ship);
        $this->em()->flush();

        $result = $this->redirect()->toRoute('ship',array('action'=>'index', 'id'=>$ship->getField()->getId()));

        return $result;
    }

    public function removeMemberAction()
    {
        $id = (int) $this->params('id');
        if (null === $id) {
            return $this->redirect()->toRoute('field');
        }

        $ship = $this->em()->find('e:Ship',$id);
        $user = $this->em()->find('e:User',$this->user()->getId());

        $ship->getMembers()->removeElement($user);

        $this->em()->persist($ship);
        $this->em()->flush();

        $result = $this->redirect()->toRoute('ship',array('action'=>'index', 'id'=>$ship->getField()->getId()));

        return $result;
    }

    public function panelAction() {
        $id = (int) $this->params('id');
        if (null === $id) {
            return $this->redirect()->toRoute('field');
        }

        // parametri grafici
        $dx = 5.5664;   // margine laterale in percentuale
        $dyt = 4.6875;  // margine superiore in percentuale
        $dyb = 29.4271; // margine inferiore in percentuale

        $w = 100 - 2*$dx; // larghezza griglia in percentuale
        $h = 100 - $dyt - $dyb; // altezza griglia in percentuale

        $ship = $this->em()->find('e:Ship',$id);
        $field = $ship->getField();
        $weapons = $ship->getWeapons();

        $info = "Coordinate: (x,y) = (<b>".$ship->getX().",".$ship->getY()."</b>) - Velocit&agrave;: <b>".$ship->getVelocity()." nodi</b> - Rotta: <b>".$ship->getAngle()."°</b> - Efficienza: <b>".$ship->getStatus()."%</b> - Carburante: <b>".$ship->getFuel()."%</b>";

        $count = 0;
        foreach($field->getShips() as $nave) {
            if($ship->getApproved()) {
                $count++;
                $navi[$count]['nome'] = $nave->getName();

                // trasformazione delle coordinate
                $x = $dx + $w/2 + $nave->getX()*$w/18;
                $y = 100 - $dyb - $h/2 - $nave->getY()*$h/10;

                $navi[$count]['x'] = round($x,1); // arrotondamento per i css
                $navi[$count]['y'] = round($y,1);
            }
        }

        return array(
            'navi' => $navi,
            'field' => $field,
            'info' => $info,
            'ship' => $ship,
            'weapons' => $weapons,
        );
    }
}