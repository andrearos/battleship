<?php
namespace Application\Controller;

use Application\Entity\Field;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;

class FieldController extends AbstractActionController
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
        $dql = 'SELECT f FROM e:Field f ORDER BY f.name';
        $query = $this->em()->createQuery($dql);
        $fields = $query->getArrayResult();

        return array('fields' => $fields, 'user' => $this->user());
    }

    public function addAction()
    {
        $builder = new AnnotationBuilder();
        $entity = new Field();
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
                $this->em()->persist($entity);
                $this->em()->flush();

                // $this->flashMessenger()->addInfoMessage("Il mare è stato salvato.");
                $result = $this->redirect()->toRoute('field');
                return $result;
            }
        }

        return array('form1' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params('id');
        if (null === $id) {
            return $this->redirect()->toRoute('field');
        }

        $builder = new AnnotationBuilder();
        $entity = new Field();
        $form = $builder->createForm($entity);

        $form->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Salva',
                'required' => false,
            )
        ));

        $field = $this->em()->find('e:Field',$id);

        $form->bind($field);

        if($this->getRequest()->isPost()) {
            $data = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );
            $form->setData($data);
            if($form->isValid()) {
                $this->em()->persist($field);
                $this->em()->flush();

                // $this->flashMessenger()->addInfoMessage("Il mare è stato modificato.");
                $result = $this->redirect()->toRoute('field');
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

        $field = $this->em()->find('e:Field',$id);

        $this->em()->remove($field);
        $this->em()->flush();

        // $this->flashMessenger()->addSuccessMessage("Il mare è stato eliminato.");

        $result = $this->redirect()->toRoute('field');
        return $result;
    }

    public function clockAction()
    {
        $id = (int) $this->params('id');
        $conferma = (int) $this->params('richiesta');

        if (null === $id) {
            return $this->redirect()->toRoute('field');
        }

        $field = $this->em()->find('e:Field',$id);

        // Ciclo di lancio dei siluri
        foreach($field->getShips() as $ship) {                      // per ogni nave...
            if($ship->getApproved()) {                              // ...attiva
                foreach($ship->getWeapons() as $weapon) {           // per ogni siluro...
                    if($weapon->getFired()) {                       // ...lanciato
                        $colpita = null;
                        $distanzaMinima = 1000;
                        foreach($field->getShips() as $target) {    // verifico tutti i possibili bersagli
                            if($target->getApproved() && $target->getId()!=$ship->getId()) { // approvati e diversi dalla nave di origine
                                // calcolo l'angolo tra la nave di origine e quella target
                                $beta = rad2deg(atan2($target->getY() - $ship->getY(),$target->getX() - $ship->getX()));
                                if($beta<0) $beta+=360;
                                if(abs($beta - $weapon->getAngle())<15) { // è sulla scia del siluro
                                    // calcolo la distanza
                                    $distanza = sqrt(pow($target->getX() - $ship->getX(),2) + pow($target->getY() - $ship->getY(),2));
                                    if($distanza<$distanzaMinima) {
                                        $distanzaMinima = $distanza;
                                        $colpita = $target;
                                    }
                                }
                            }
                        }
                        if(!is_null($colpita)) {
                            if($conferma) { // l'azione precedente è confermata
                                if($conferma==1) {
                                    // nessun danno
                                    $this->em()->remove($weapon);
                                    $this->em()->flush();
                                }
                                if($conferma==2) {
                                    // bersaglio colpito
                                    $status = $colpita->getStatus();
                                    $status -= 10;
                                    if($status<0) $status = 0;
                                    $colpita->setStatus($status);
                                    $this->em()->persist($colpita);

                                    $this->em()->remove($weapon);
                                    $this->em()->flush();
                                    // todo: cosa faccio se una nave è distrutta?
                                    $this->flashMessenger()->addErrorMessage("Nave ".$colpita->getName()." colpita: stato ".$colpita->getStatus()."%");
                                    $result = $this->redirect()->toRoute('field',array('action'=>'supervision', 'id'=>$id));
                                    return $result;
                                }
                                if($conferma==3) {
                                    // siluro difettoso
                                    $status = $ship->getStatus();
                                    $status -= 10;
                                    if($status<0) $status = 0;
                                    $ship->setStatus($status);
                                    $this->em()->persist($ship);
                                    $this->em()->remove($weapon);
                                    $this->em()->flush();
                                    $this->flashMessenger()->addErrorMessage("Nave ".$ship->getName()." colpita: stato ".$ship->getStatus()."%");
                                    $result = $this->redirect()->toRoute('field',array('action'=>'supervision', 'id'=>$id));
                                    return $result;
                                }
                            }
                            else { // invio la richiesta di conferma
                                $this->flashMessenger()->addSuccessMessage("Siluro da ".$ship->getName()." a ".$colpita->getName().": ".$weapon->getText());

                                $result = $this->redirect()->toRoute('field',array('action'=>'supervision', 'id'=>$id, 'richiesta'=>'1'));
                                return $result;
                            }
                        }
                        else {
                            $this->flashMessenger()->addInfoMessage("Siluro da ".$ship->getName()." andato a vuoto!");
                            $this->em()->remove($weapon);
                            $this->em()->flush();

                            $result = $this->redirect()->toRoute('field',array('action'=>'supervision', 'id'=>$id));
                            return $result;
                        }
                    }
                }
            }
        }

        // Ciclo di aggiornamento della posizione, del carburante e delle collisioni
        foreach($field->getShips() as $ship) {
            if($ship->getApproved()) {
                $carburante = $ship->getFuel();

                // aggiornamento della posizione
                if($carburante>0) {
                    // calcolo della nuova posizione in base a velocità e angolo
                    $x = $ship->getX()+$ship->getVelocity()*cos(deg2rad($ship->getAngle()))/20;
                    $y = $ship->getY()+$ship->getVelocity()*sin(deg2rad($ship->getAngle()))/20;

                    // limitazione alla griglia
                    if($x<-9) $x = -9;
                    if($x>9) $x = 9;
                    if($y<-5) $y = -5;
                    if($y>5) $y = 5;

                    // settaggio della nuova posizione
                    $ship->setX($x);
                    $ship->setY($y);
                }

                // aggiornamento del carburante
                $carburante -= $ship->getVelocity()/10;
                // siamo in "Fuel Zone"?
                if(pow($x,2) + pow($y,2) <= 1) {
                    $carburante += 10;
                }
                if($carburante<0) $carburante = 0;
                if($carburante>100) $carburante = 100;
                $ship->setFuel($carburante);

                // @todo: aggiornamento dei danni in caso di collisione
            }
        }

        $this->em()->persist($field);
        $this->em()->flush();

        $result = $this->redirect()->toRoute('field',array('action'=>'supervision', 'id'=>$id));

        return $result;
    }

    public function supervisionAction() {
        $field_id = (int) $this->params('id');
        $richiesta = (int) $this->params('richiesta');
        if (null === $field_id) {
            return $this->redirect()->toRoute('home');
        }

        // parametri grafici
        $dx = 5.5664;   // margine laterale in percentuale
        $dyt = 4.6875;  // margine superiore in percentuale
        $dyb = 29.4271; // margine inferiore in percentuale

        $w = 100 - 2*$dx; // larghezza griglia in percentuale
        $h = 100 - $dyt - $dyb; // altezza griglia in percentuale

        $field = $this->em()->find('e:Field',$field_id);

        $count = 0;
        foreach($field->getShips() as $ship) {
            if($ship->getApproved()) {
                $count++;
                $navi[$count]['nome'] = $ship->getName();

                // trasformazione delle coordinate
                $x = $dx + $w/2 + $ship->getX()*$w/18;
                $y = 100 - $dyb - $h/2 - $ship->getY()*$h/10;

                $navi[$count]['x'] = round($x,1); // arrotondamento per i css
                $navi[$count]['y'] = round($y,1);
            }
        }

        return array(
            'navi' => $navi,
            'field' => $field,
            'richiesta' => $richiesta,
        );
    }
}