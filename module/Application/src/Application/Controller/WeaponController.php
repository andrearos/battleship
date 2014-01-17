<?php
namespace Application\Controller;

use Application\Entity\Weapon;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;

class WeaponController extends AbstractActionController
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
        $ship_id = (int) $this->params('id');
        if ($ship_id === null) {
            return $this->redirect()->toRoute('ship');
        }

        $dql = 'SELECT w FROM e:Weapon w WHERE w.ship = ?1 ORDER BY w.id';
        $query = $this->em()->createQuery($dql)->setParameter(1,$ship_id);
        $weapons = $query->getArrayResult();

        $ship = $this->em()->find('e:Ship',$ship_id);
        $field = $ship->getField();

        return array('weapons' => $weapons, 'ship_id' => $ship_id, 'ship' => $ship, 'field' => $field);
    }

    public function addAction()
    {
        $ship_id = (int) $this->params('id');
        if ($ship_id === null) {
            return $this->redirect()->toRoute('weapon');
        }
        $ship = $this->em()->find('e:Ship',$ship_id);

        $builder = new AnnotationBuilder();
        $entity = new Weapon();
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
                $entity->setShip($ship);
                $entity->setFired(0);
                $entity->setAngle(0);

                $this->em()->persist($entity);
                $this->em()->flush();

                // $this->flashMessenger()->addInfoMessage("Il siluro è stato armato.");
                $result = $this->redirect()->toRoute('weapon',array('action'=>'index', 'id'=>$ship_id));
                return $result;
            }
        }

        return array('form1' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params('id');
        if (null === $id) {
            return $this->redirect()->toRoute('weapon');
        }

        $builder = new AnnotationBuilder();
        $entity = new Weapon();
        $form = $builder->createForm($entity);

        $form->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Salva',
                'required' => false,
            )
        ));

        $weapon = $this->em()->find('e:Weapon',$id);
        $ship_id = $weapon->getShip()->getId();

        $form->bind($weapon);

        if($this->getRequest()->isPost()) {
            $data = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );
            $form->setData($data);
            if($form->isValid()) {
                $this->em()->persist($weapon);
                $this->em()->flush();

                // $this->flashMessenger()->addInfoMessage("Il siluro è stato modificato.");
                $result = $this->redirect()->toRoute('weapon',array('action'=>'index', 'id'=>$ship_id));
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
            return $this->redirect()->toRoute('weapon');
        }

        $weapon = $this->em()->find('e:Weapon',$id);
        $ship_id = $weapon->getShip()->getId();


        $this->em()->remove($weapon);
        $this->em()->flush();

        // $this->flashMessenger()->addSuccessMessage("Il siluro è stato eliminato.");

        $result = $this->redirect()->toRoute('weapon',array('action'=>'index', 'id'=>$ship_id));

        return $result;
    }

    public function fireAction()
    {
        $weapon_id = $this->params()->fromPost('weapon_id');
        $angle = (int)$this->params()->fromPost('angle');
        if ($weapon_id === null) {
            return $this->redirect()->toRoute('home');
        }

        if($angle<0) $angle=0;
        if($angle>=360) $angle=0;

        $weapon = $this->em()->find('e:Weapon',$weapon_id);
        $ship = $weapon->getShip();

        if(!$weapon->getFired()) { // il siluro non è già stato lanciato
            $weapon->setAngle($angle);
            $weapon->setFired(true);

            $this->em()->persist($weapon);
            $this->em()->flush();
        }

        $result = $this->redirect()->toRoute('ship',array('action'=>'panel', 'id'=>$ship->getId()));

        return $result;
    }
}