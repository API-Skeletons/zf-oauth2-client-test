<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function logoutAction()
    {
        session_destroy();

        return $this->plugin('redirect')->toRoute('home');
    }

    /**
     * Authorize a default oauth2 session
     */
    public function authenticateAction()
    {
        $adapter = $this->getServiceLocator()->get('Application\Authentication\Adapter\DefaultAdapter');

        $auth = new AuthenticationService();
        $result = $auth->authenticate($adapter);

        return $this->plugin('redirect')->toRoute('home');
    }
}
