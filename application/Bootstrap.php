<?php

/**
 * 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends Yaf_Bootstrap_Abstract
{
    public function _initConfig()
    {
        $config = Yaf_Application::app()->getConfig();
        Yaf_Registry::set('config', $config);
    }

    public function _initDefaultName(Yaf_Dispatcher $dispatcher)
    {
        // $dispatcher->setDefaultModule('Rest')->setDefaultController('Index')->setDefaultAction('index');
        // $modules = Yaf_Application::app()->getModules();
        // print_r($modules);exit;
    }

    public function _initRoute(Yaf_Dispatcher $dispatcher)
    {
        $router     = Yaf_Dispatcher::getInstance()->getRouter();
        $regexRoute = new Yaf_Route_Regex(
            '#/rest/user/([0-9]+)#',
            [
                'module'     => 'rest',
                'controller' => 'users',
                'action'     => 'get',
            ],
            [
                2 => 'id',
            ]
        );
        $router->addRoute('regex_route', $regexRoute);
    }

    public function _initPlugin(Yaf_Dispatcher $dispatcher)
    {
        $restful = new RestfulPlugin();
        $dispatcher->registerPlugin($restful);
    }

    public function _initLibraries(Yaf_Dispatcher $dispatcher)
    {
        $config = Yaf_Registry::get('config');
        $redis  = new CRedis($config->redis);
        Yaf_Registry::set('redis', $redis);
    }
}
