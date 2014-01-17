<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\Plugin\AcceptableViewModelSelector;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $config = $this->serviceLocator->get('config');

        $viewModel = new ViewModel();
        $viewModel->setVariables(
                Array(
                    'applicationName' => $config['application']['name'],
                    'applicationVersion' => $config['application']['version'],
                    'shipsCount'=>27,
                    'fieldsCount'=>12
                )
            );
        // $viewModel->setTerminal(true);
        $this->layout()->title = $config['application']['name'];
        return $viewModel;
    }
}
