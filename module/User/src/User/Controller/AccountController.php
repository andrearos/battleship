<?php
namespace User\Controller;

// use User\Form\User as UserForm;
// use User\Service\Factory\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
// use Zend\EventManager\EventManager;
use Zend\Form\Annotation\AnnotationBuilder;
// use User\Model\Entity\User as UserEntity;

class AccountController extends AbstractActionController
{
    protected $entityManager;

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

    public function indexAction()
    {
        $user = $this->serviceLocator->get('user-entity');
        $utenti = $this->em()->getRepository(get_class($user))->findAll();

        return array('utenti' => $utenti);
    }

    public function addAction()
    {
        $builder = new AnnotationBuilder();
        $entity = $this->serviceLocator->get('user-entity');
        $form = $builder->createForm($entity);

        // $form->remove('ships');

        $form->add(array(
            'name' => 'password_verify',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Verifica password:'
            ),
            'attributes' => array(
                'required' => true,
                'placeholder' => 'Ripeti la password...',
            )
          ),
          array(
              'priority' => $form->get('password')->getOption('priority')
          )
        );

        $form->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));

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

                $this->flashMessenger()->addInfoMessage("L'utente è stato salvato.");
                $result = $this->redirect()->toRoute('user');
                return $result;
            }
        }

        return array('form1' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params('id');
        if (null === $id) {
            return $this->redirect()->toRoute('user');
        }

        $builder = new AnnotationBuilder();
        $entity = $this->serviceLocator->get('user-entity');
        $form = $builder->createForm($entity);

        // $form->remove('ships');

        $form->add(array(
                'name' => 'password_verify',
                'type' => 'Zend\Form\Element\Password',
                'options' => array(
                    'label' => 'Verifica password:'
                ),
                'attributes' => array(
                    'required' => true,
                    'placeholder' => 'Ripeti la password...',
                )
            ),
            array(
                'priority' => $form->get('password')->getOption('priority')
            )
        );

        $form->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));

        $form->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Salva',
                'required' => false,
            )
        ));

        $user = $this->em()->find('Application\Entity\User',$id);

        $form->bind($user);

        if($this->getRequest()->isPost()) {
            $data = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );
            $form->setData($data);
            if($form->isValid()) {
                $this->em()->persist($user);
                $this->em()->flush();

                $this->flashMessenger()->addInfoMessage("L'utente è stato modificato.");
                $result = $this->redirect()->toRoute('user');
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
            return $this->redirect()->toRoute('user');
        }

        $userEntity = $this->em()->find('Application\Entity\User',$id);

        $this->em()->remove($userEntity);
        $this->em()->flush();

        $this->flashMessenger()->addSuccessMessage("L'utente è stato cancellato.");

        $result = $this->forward()->dispatch('User\Controller\Account',array('action'=>'index'));
        return $result;
    }
}