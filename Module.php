<?php
namespace EddieJaoude\Zf2Logger;

use EddieJaoude\Zf2Logger\Listener\Request;
use EddieJaoude\Zf2Logger\Listener\Response;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    /**
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        /* @var $eventManager \Zend\EventManager\EventManager */
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $zf2Logger = $e->getApplication()->getServiceManager()->get('EddieJaoude\Zf2Logger');
        $request = new Request($zf2Logger);
        $request->attach($eventManager);

        $config = $e->getApplication()->getServiceManager()->get('Config');
        $moduleConfig = $config['EddieJaoude\Zf2Logger'];
        $response   = new Response($zf2Logger);
        $mediaTypes = empty($moduleConfig['doNotLog']['mediaTypes']) ? array() : $moduleConfig['doNotLog']['mediaTypes'];
        $response->setIgnoreMediaTypes($mediaTypes);
        $response->attach($eventManager);
        return;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src',
                ),
            ),
        );
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'EddieJaoude\Zf2Logger' => 'EddieJaoude\Zf2Logger\Factory\Zf2Logger'
            )
        );
    }

}
