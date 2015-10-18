<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Authentication\Adapter\DefaultAdapter;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Http\Client;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        session_start();
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Application\Authentication\Adapter\DefaultAdapter' => function($sm)
                {
                    $adapter = new DefaultAdapter();

                    $config = $sm->get('Config');
                    $oAuth2Service = $sm->get('ZF\OAuth2\Client\Service\OAuth2Service');

                    $adapter->setOAuth2Service($oAuth2Service);
                    $adapter->setUserInfoUrl($config['zf-oauth2-client-test']['user_info_url']);

                    return $adapter;
                },

                'ZF\OAuth2\Client\Http' => function ($sm) {
                    $client = new Client();
                    $client->setOptions([
                        'sslverifypeer' => false,
                    ]);

                    return $client;
                },

                'ZF\OAuth2\Client\HttpBearer' => function ($sm) {
                    $client = new Client();
                    $client->setOptions([
                        'sslverifypeer' => false,
                    ]);

                    return $client;
                },
            ),
        );
    }
}
