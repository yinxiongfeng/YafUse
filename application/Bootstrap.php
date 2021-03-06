<?php
class Bootstrap extends Yaf_Bootstrap_Abstract {

    private $_config;

    /*get a copy of the config*/
    public function _initBootstrap(){
        $this->_config = Yaf_Application::app()->getConfig();
        Yaf_Registry::set('config', $this->_config);
    }

    /*
     * initIncludePath is only required because zend components have a shit load of
     * include_once calls everywhere. Other libraries could probably just use
     * the autoloader (see _initNamespaces below).
     */
    public function _initIncludePath(){
        set_include_path(get_include_path() . PATH_SEPARATOR . $this->_config->application->library);
    }
    /**
     * [报错设置]
     */
    public function _initErrors(){
        if($this->_config->application->showErrors){
            error_reporting (-1);
            /*报错是否开启，On开启*/
            ini_set('display_errors','On');
            set_error_handler('handleError', E_ALL);
        }else{
            error_reporting (-1);
            set_error_handler('handleError', E_ALL);
        }
    }
    public function _initNamespaces(){
        Yaf_Loader::getInstance()->registerLocalNameSpace(array("Juaiwan"));
    }
    /**
     * [默认路由设置]
     */
    public function _initRoutes(){
        Yaf_Dispatcher::getInstance()->getRouter()->addRoute(
            "paging_example",
            new Yaf_Route_Regex(
                "#^/index/page/(\d+)#",
                array('controller' => "index"),
                array(1 => "page")
            )
        );
        
    }
    /**
     * layout页面布局
     */
    public function _initLayout(Yaf_Dispatcher $dispatcher){
        $this->_layout = new LayoutPlugin($this->_config->application->document,$this->_config->application->layoutpath);
        $dispatcher->registerPlugin($this->_layout);
        Yaf_Registry::set('layout', $this->_layout);
    }
}